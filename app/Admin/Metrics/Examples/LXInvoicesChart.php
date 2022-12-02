<?php

namespace App\Admin\Metrics\Examples;



use Carbon\Carbon;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Support\Facades\Cache;

class LXInvoicesChart extends Line
{

    protected $chartHeight = 400;

    protected $chartOptions = [
        'colors' => [
            // '#0088FE', '#00C49F', '#FFBB28', '#FF8042',
        ],
        'chart' => [
            'type' => 'bar',
            // 'stacked' => true,
            // 'stackType'=> '100%',
            // 'toolbar' => [
            //     'show' => false,
            // ],
            // 'sparkline' => [
            //     'enabled' => true,
            // ],
            'grid' => [
                'show' => true,
                'padding' => [
                    'left' => 0,
                    'right' => 0,
                ],
            ],
        ],
        'tooltip' => [
            'x' => [
                'show' => false,
            ],
        ],
        'plotOptions' => [
            'bar' => [
                'horizontal' => false,
                'dataLabels' => [
                    'position' => 'top',
                ],
            ]
        ],
        'dataLabels' => [
            'enabled' => true,
            'offsetX' => -6,
            'style' => [
                'fontSize' => '12px',
                'colors' => ["#304758"]
            ]
        ],
        'xaxis' => [
            'labels' => [
                'show' => true,
            ],
            'axisBorder' => [
                'show' => true,
            ],
            'position' => 'top',
            'crosshairs' => [
                'fill' => [
                  'type' => 'gradient',
                  'gradient' => [
                    'colorFrom' => '#D8E3F0',
                    'colorTo' => '#BED1E6',
                    'stops' => [0, 100],
                    'opacityFrom' => 0.4,
                    'opacityTo' => 0.5,
                  ]
                ]
              ],
              'tooltip' => [
                'enabled' => true,
              ],
            'categories' => []
        ],
        'yaxis' => [
            [
                'axisBorder' => [
                    'show' => false
                ],
                'axisTicks' => [
                    'show' => false,
                ],
                'y' => 0,
                'offsetX' => 0,
                'offsetY' => 0,
                'padding' => ['left' => 0, 'right' => 0],
            ],
            // [
            //     'opposite' => true,
            //     'axisBorder' => [
            //         'show' => false
            //     ],
            //     'axisTicks' => [
            //         'show' => false,
            //     ],
            //     'y' => 0,
            //     'offsetX' => 0,
            //     'offsetY' => 0,
            //     'padding' => ['left' => 0, 'right' => 0],
            // ]
        ],
        'dataLabels' => [
            'enabled' => false,
        ],
        'stroke' => [
            'width' => 2.5,
            'curve' => 'smooth',
        ],
        // 'fill' => [
        //     'opacity' => 0.1,
        //     'type' => 'solid',
        // ],
        'title' => [
            // 'text' => 'Daily Sales',
            'floating' => true,
            'offsetY' => 0,
            'align' => 'center',
            'style' => [
              'color' => '#444'
            ]
        ]
    ];
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        // $this->chartOption('colors', [
        //     '#00C49F',
        //     '#FFBB28',
        //     '#0088FE',
        //     '#FF8042',
        // ]);
        $this->chartOption('colors', config('admin.colors.palette1'));
        $this->title('Profit and Loss');
        $this->chartStraight();
        $this->dropdown([
            'month' => 'By Month',
            'day' => 'By Date',
            'year' => 'By Year',
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function withData( $by = 'month'  ){

        $format = match($by){
            'day' => '%Y-%m-%d',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => '%Y-%m',
        };

        $max_date = Carbon::parse(Invoice::max('invoiceDate'));
        $min_date = Carbon::parse(Invoice::min('invoiceDate'));

        $m = $min_date->diffInMonths($max_date);

        // dd($m);

        $StartDate = match($by){
            'day' => Carbon::parse($max_date->subDays(30)),
            'month' => Carbon::parse($max_date->subMonths($m < 12 ? $m : 12)),
            'year' => Carbon::parse($max_date->subYears(3)),
        };
        $runningDate = $StartDate->copy();

        // $day_series = [];
        $day_series = match($by){
            'day' => [$StartDate->format('Y-m-d')],
            'month' => [$StartDate->format('Y-m')],
            'year' => [$StartDate->format('Y')],
            default => [$StartDate->format('Y-m')],
        };
        // dd($StartDate->diff(today())->days);
        // dd($StartDate->addYear(2)->diff(today())->days);
        // $count = 0;
        do{
            if ($by == 'day') {
                $day_series[] = $runningDate->addDay(1)->format('Y-m-d');
            }
            if ($by == 'month') {
                $day_series[] = $runningDate->addMonth(1)->format('Y-m');
            }
            if ($by == 'year') {
                $day_series[] = $runningDate->addYear(1)->format('Y');
            }
        }while($runningDate->diffInDays(today(), false) > 0 );


        // dd ($StartDate->format('Y-m-d'));
        // $series = [];
        $series = Invoice::with([
            'task.client',
            'localtask.client',
        ])
        ->whereDate('invoiceDate', '>=', $StartDate)
        ->whereDate('invoiceDate', '<=', today())
        // ->selectRaw("DATE_FORMAT(invoiceDate, '{$format}') as date, sum(total) as total")
        // ->groupBy('date')
        ->get()
        ->groupBy(function($item, $key){
            // dd($item);
            return $item->task?->client?->name ?? $item->localtask?->client?->name ?? 'Other';
        })
        ->map(function($invoices, $client) use($day_series, $format) {
            // dd($invoices);
            return [
                'name' => $client,
                'data' => collect($day_series)->map(function($date) use($invoices, $format){
                    return ceil($invoices->sum(function($invoice) use($date,  $format){
                        return $invoice->invoiceDate->format(str($format)->replace('%', '')) == $date ? $invoice->total : 0;
                    }));
                })
            ];
        })
        ->values()
        ->toArray();
        ;

        // dd($invoices);
        // Cache::forget("nexgen_profit_loss_{$by}");

        // $series = Cache::remember("nexgen_profit_loss_{$by}", 60*60, function() use($day_series,  $format){

            // $series = Client::all()->map(function($client) use( $day_series,  $format ) {
            //     // dd($db_data);
            //     return [
            //         'name' => $client->name,
            //         'data' => collect($day_series)->map(function($date) use( $format ) {
            //             // $bought = DB::table('paper_stocks')->whereDate('buy_at', '<=', $date)->where('paper_id', $paper_id)->selectRaw('SUM(qty) as total_bought')->first();
            //             // $paper_used = DB::table('paper_usage')->whereDate('date', '<=', $date)->where('paper_id', $paper_id)->selectRaw('SUM(used) as total_used')->first();
            //             $daily = Invoice::hasByNonDependentSubquery('localtask.client', function($q) use($client){
            //                 $q->where('client_id', $client->id);
            //             })->whereDate('invoiceDate', $date)->selectRaw('SUM(total) as total')->first();
            //             // dd($daily);
            //             // return [
            //             //     'date_name' => $date,
            //             //     'inv_total' => $daily->sum('invoice_price_in_HKD'),
            //             //     'inv_cost' => $daily->sum('cost_total'),
            //             //     'pl' => $daily->sum('invoice_price_in_HKD') - $daily->sum('cost_total'),
            //             // ];
            //             // return +$daily?->total_used ?? 0;
            //             return ($daily);
            //             // $data = $db_data->where('date', $date)->where('paper_id', $key)->first();
            //             // return $data ? +$data->used : 0;
            //         })->toArray(),
            //     ];
            // })->values()->toArray();

        // });



        return [
            'series' => $series,
            'categories' => $day_series,
        ];
    }

    public function handle(Request $request)
    {

        // switch ($request->get('option')) {
        //     case 'year':
        //         $data = $this->withData($request->get('option'));
        //         $this->withChart($data['series'], $data['categories']);
        //         break;
        //     case 'month':
        //         $data = $this->withData($request->get('option'));
        //         $this->withChart($data['series'], $data['categories']);
        //         break;
        //     case 'day':
        //     default:
                $data = $this->withData($request->get('option', 'month'));
                $this->withChart($data['series'], $data['categories']);
        // }
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $series, $categories = [])
    {
        return $this->chart([
            'series' => $series,
            "xaxis" => [
                "categories" => $categories
            ]
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
    <span class="mb-0 mr-1 text-80">{$this->title}</span>
</div>
HTML
        );
    }
}
