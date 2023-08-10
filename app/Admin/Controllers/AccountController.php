<?php

namespace App\Admin\Controllers;

use App\Models\Invoice;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use App\Admin\Metrics\Examples\LXInvoicesChart;

class AccountController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Account')
            ->description('Description...')
            ->body(view('admin.account.index'));
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
        $invoices = Invoice::with([
            'task.pos',
            'task.client',
            'localtask.client',
            'job',
        ])->whereBetween('invoiceDate', [$date_from, $date_to])->get();
        return [
            "data" => $invoices->map(function ($invoice) {
                $cost = $invoice?->localtask?->pos->sum('total') ?? $invoice?->task?->pos->sum('total');
                $pos = $invoice?->localtask?->pos ?? $invoice?->task?->pos;
                $pos_btns = collect($pos)->map(function ($po) {
                    return "<a class='text-blue-500 hover:text-blue-600' data-popup href='/admin/purchase-orders/{$po->id}/view'>PO</a>";
                })->implode(' | ');
                $invoice_date = $invoice->invoiceDate?->clone()->format('Y-m-d');
                $due_date = $invoice->invoiceDate->clone()?->addDays(30)->format('Y-m-d');
                $net =  $invoice->total - $cost;
                return [
                    "id" => $invoice->id,
                    "invoiceCode" => $invoice->invoiceCode,
                    "invoiceDate" => $invoice_date,
                    "client" => $invoice->localtask?->client?->name ?? $invoice->task?->client?->name,
                    "lx_no" => $invoice->lx_code,
                    "lx_job_no" => ($invoice->localtask?->lx_no ?? $invoice->task?->lx_no),
                    "total" => number_format($invoice->total, 2),
                    "costing" => number_format($cost ?? 0, 2),
                    "net" => '<div class="'. ($net < 0 ? 'bg-red-300' : '') .'">'.number_format($net, 2)."</div>",
                    "due_date" => $due_date,
                    "settlement_date" => $invoice->settlement_date?->format('Y-m-d'),
                    "jobtypeKey" => $invoice?->job?->jobtypeKey,
                    "view" => "<a class='text-blue-500 hover:text-blue-600 mr-2' data-popup href='/admin/invoices/{$invoice->id}/view'>View</a>" . $pos_btns,
                ];
            }),
            "columns" => [
                ["title" => "LX Ref", "data" => "lx_no"],
                // ["title" => "Invoice #", "data" => "invoiceCode"],
                ["title" => "Invoice Date", "data" => "invoiceDate"],
                ["title" => "Client", "data" => "client"],
                ["title" => "LX No", "data" => "lx_job_no"],
                ["title" => "Total", "data" => "total", "className" => "text-right"],
                ["title" => "Costing", "data" => "costing"],
                ["title" => "Net Amount", "data" => "net"],
                ["title" => "Due Date", "data" => "due_date"],
                ["title" => "Settlement Date", "data" => "settlement_date"],
                ["title" => "Job Type", "data" => "jobtypeKey", "className" => "dt-control"],
                ["title" => "View", "data" => "view"],
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
