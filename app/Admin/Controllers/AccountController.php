<?php

namespace App\Admin\Controllers;

use App\Models\Invoice;
use Dcat\Admin\Layout\Row;
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
                $invoice_date = $invoice->invoiceDate?->clone()->format('Y-m-d');
                $due_date = $invoice->invoiceDate->clone()?->addDays(30)->format('Y-m-d');
                return [
                    "id" => $invoice->id,
                    "invoiceCode" => $invoice->invoiceCode,
                    "invoiceDate" => $invoice_date,
                    "client" => $invoice->localtask?->client?->name ?? $invoice->task?->client?->name,
                    "lx_no" => $invoice->lx_code,
                    "lx_job_no" => ($invoice->localtask?->lx_no ?? $invoice->task?->lx_no),
                    "total" => number_format($invoice->total, 2),
                    "costing" => number_format($cost ?? 0, 2),
                    "net" => number_format($invoice->total - $cost, 2),
                    "due_date" => $due_date,
                    "jobtypeKey" => $invoice?->job?->jobtypeKey,
                    "view" => "<a data-popup href='/admin/invoices/{$invoice->id}/view'>View</a>",
                ];
            }),
            "columns" => [
                ["title" => "Invoice #", "data" => "invoiceCode"],
                ["title" => "Invoice Date", "data" => "invoiceDate"],
                ["title" => "Client", "data" => "client"],
                ["title" => "Total", "data" => "total", "className" => "text-right"],
                ["title" => "LX No", "data" => "lx_job_no"],
                ["title" => "LX Ref", "data" => "lx_no"],
                ["title" => "Costing", "data" => "costing"],
                ["title" => "Net Amount", "data" => "net"],
                ["title" => "Due Date", "data" => "due_date"],
                ["title" => "Job Type", "data" => "jobtypeKey"],
                ["title" => "View", "data" => "view"],
            ]
        ];
    }
}
