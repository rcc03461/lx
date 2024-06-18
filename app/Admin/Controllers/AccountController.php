<?php

namespace App\Admin\Controllers;

use App\Models\Invoice;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Dcat\Admin\Http\Controllers\Dashboard;
use App\Admin\Metrics\Examples\LXInvoicesChart;
use Dcat\EasyExcel\Excel;
class AccountController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Account')
            ->description('Description...')
            ->body(view('admin.account.index'));
    }

    public function export_xero(Request $request){

        $date_from = request()->get('date_from');
        $date_to = request()->get('date_to');
        $type = request()->get('type');

        $invoices = Invoice::with([
            'task.pos',
            'task.client',
            'localtask.client',
            'job',
        ])
        ->whereBetween('invoiceDate', [$date_from, $date_to .' 23:59:59'])
        // ->dd()
        ->orderBy('lx_code')
        ->get()
        ->transform(function ($invoice) {
            $invoiceNo = $invoice->lx_code;
            return [
                "*ContactName" => "Lingxpert Language Services Limited",
                "EmailAddress" => "",
                "POAddressLine1" => "",
                "POAddressLine2" => "",
                "POAddressLine3" => "",
                "POAddressLine4" => "",
                "POCity" => "",
                "PORegion" => "",
                "POPostalCode" => "",
                "POCountry" => "",
                "*InvoiceNumber" => $invoiceNo . ($invoice->invoiceCode ? '('. $invoice->invoiceCode .')' : ''),
                "*InvoiceDate" => $invoice->invoiceDate->format('Y-m-d'),
                // 2 months from invoice date
                "*DueDate" => $invoice->invoiceDate->clone()->addMonths(2)->format('Y-m-d'),
                "Total" => number_format($invoice->total, 2),
                "InventoryItemCode" => "",
                "Description" => $invoiceNo,
                "*Quantity" => 1,
                "*UnitAmount" => number_format($invoice->total, 2),
                "*AccountCode" => "4213030",
                "*TaxType" => "Tax Exempt",
                "TaxAmount" => "",
                "TrackingName1" => "",
                "TrackingOption1" => "",
                "TrackingName2" => "",
                "TrackingOption2" => "",
                "Currency" => "HKD",
            ];
        })
        ->toArray();

        Excel::export($invoices)->download('Cre8_lx_xero_'.$date_from. '_to_' . $date_to .'.csv');

    }

    public function report($type)
    {
        $date_from = request()->get('date_from');
        $date_to = request()->get('date_to');

        switch ($type) {
            case 'gp':
                return $this->report_gp($date_from, $date_to);
                break;

        }
    }

    public function report_gp($date_from, $date_to)
    {

        $invoices = Cache::remember("lx_account_{$date_from}_{$date_to}", 60, function () use ($date_from, $date_to) {
            $invoices = Invoice::with([
                'task.pos',
                'task.client',
                'localtask.client',
                'job',
            ])
            ->whereBetween('invoiceDate', [$date_from, $date_to .' 23:59:59'])
            // ->dd()
            ->get()
            ;

            return $invoices;

        });

        // return $invoices;


        return [
            "data" => $invoices->map(function ($invoice) {
                $cost = $invoice?->localtask?->pos->sum('total') ?? $invoice?->task?->pos->sum('total');
                $pos = $invoice?->localtask?->pos ?? $invoice?->task?->pos;
                $pos_btns = collect($pos)->map(function ($po) {
                    return "<a class='text-blue-500 hover:text-blue-600' data-popup href='/admin/purchase-orders/{$po->id}/view'>PO{$po->po_no}</a>";
                })->implode(' | ');
                $invoice_date = $invoice->invoiceDate?->clone()->format('Y-m-d');
                $due_date = $invoice->invoiceDate->clone()?->addDays(30)->format('Y-m-d');
                $net =  $invoice->total - $cost;
                return [
                    "id" => $invoice->id,
                    "invoiceCode" => $invoice->invoiceCode,
                    "invoiceDate" => $invoice_date,
                    "invoicestatus" => $invoice->invoicestatus,
                    "client" => $invoice->localtask?->client?->name ?? $invoice->task?->client?->name,
                    "lx_no" => $invoice->lx_code,
                    "lx_job_no" => ($invoice->localtask?->lx_no ?? $invoice->task?->lx_no),
                    "job_ref" => $invoice?->job?->job_code ?? '',
                    "job_status" => $invoice?->job?->status ?? '',
                    // "pos" => $pos_btns,
                    "total" => number_format($invoice->total, 2),
                    "costing" => number_format($cost ?? 0, 2),
                    "net" => '<div class="'. ($net < 0 ? 'bg-red-300' : '') .'">'.number_format($net, 2)."</div>",
                    "due_date" => $due_date,
                    "settlement_date" => $invoice->settlement_date?->format('Y-m-d'),
                    "jobtypeKey" => $invoice?->job?->jobtypeKey,
                    "pos" => $pos_btns,
                    "view" => "<a class='text-blue-500 hover:text-blue-600 mr-2' data-popup href='/admin/invoices/{$invoice->id}/view'>View</a>",
                    "edit" => "<a class='text-blue-500 hover:text-blue-600 mr-2' data-popup href='/admin/invoices/{$invoice->id}/edit'>Edit</a>",
                ];
            }),
            "columns" => [
                ["title" => "LX Ref", "data" => "lx_no"],
                ["title" => "Invoice #", "data" => "invoiceCode"],
                ["title" => "Invoice Date", "data" => "invoiceDate"],
                ["title" => "Invoice Status", "data" => "invoicestatus"],
                ["title" => "Client", "data" => "client"],
                ["title" => "LX No", "data" => "lx_job_no"],
                ["title" => "Job Ref", "data" => "job_ref"],
                ["title" => "Job Status", "data" => "job_status"],
                // ["title" => "POs", "data" => "pos"],
                ["title" => "Total", "data" => "total", "className" => "text-right"],
                ["title" => "Costing", "data" => "costing", "className" => "text-right"],
                ["title" => "Net Amount", "data" => "net", "className" => "text-right"],
                ["title" => "Due Date", "data" => "due_date"],
                ["title" => "Settlement Date", "data" => "settlement_date"],
                ["title" => "Job Type", "data" => "jobtypeKey"], // , "className" => "dt-control"
                ["title" => "PO", "data" => "pos"],
                ["title" => "View", "data" => "view"],
                ["title" => "Edit", "data" => "edit"],
            ]
        ];
    }

    public function update_settlements( Request $request )
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
            'settlement_date' => 'required|date',
        ]);

        Invoice::whereIn('id', request()->get('ids'))->update([
            'settlement_date' => request()->get('settlement_date'),
        ]);
        // $invoces->each(function ($invoice) {
        //     $invoice->settlement_date = request()->get('settlement_date');
        //     $invoice->save();
        // });
        return [
            "status" => "success",
            "message" => "Settlement date updated",
        ];
    }
}
