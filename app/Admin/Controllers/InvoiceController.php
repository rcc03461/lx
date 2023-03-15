<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\Client;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\Invoice;
use App\Models\Invoice as InvoiceModel;
use App\Admin\Actions\Grid\GenerateInvoiceNo;
use Carbon\Carbon;
use Dcat\Admin\Http\Controllers\AdminController;

class InvoiceController extends AdminController
{

    public function apiGenerateInvoiceNo()
    {
        // $invoiceNo = InvoiceModel::generateInvoiceNo();
        // return response()->json([
        //     'invoiceNo' => $invoiceNo,
        // ]);
    }


    protected function grid()
    {
        // dd(Task::doesntHaveByNonDependentSubquery('invoices')->get());
        return Grid::make(InvoiceModel::with(['task.client', 'task.pos',  'job', 'localtask.client']), function (Grid $grid) {



            $grid->selector(function (Grid\Tools\Selector $selector) {

                // $selector->selectOne('client_id', 'Client', Client::pluck('name', 'id'));

                // select month of last year from now
                $months = [];
                $maxEndDate = InvoiceModel::max("invoiceDate");
                $maxEndDate = $maxEndDate ? Carbon::parse($maxEndDate) : now();
                // dd($maxEndDate);
                for ($i = 0; $i < 12; $i++) {
                    $months[$maxEndDate->format('Y-m')] = $maxEndDate->format('Y-m');
                    $maxEndDate->subMonth();
                }
                // dd($months);
                $selector->selectOne('invoiceDate', 'Month', $months, function($query, $value){
                    // $value = current($value);
                    [$year, $month] = explode('-', $value);
                    $query->whereYear('invoiceDate', $year)->whereMonth('invoiceDate', $month);
                });

            });

            $grid->model()->orderBy('id', 'desc');

            // $grid->column('idjob');
            $grid->column('job.job_code', 'Job No.');
            $grid->column('job.status', 'Job Status');
            $grid->column('idjob', 'Client')
            ->display(function ($idjob) {
                if ($idjob) {
                    return $this?->task?->client->name ?? "";
                }else{
                    $clientname = $this->localtask->client->name ?? "";
                    return <<<HTML
                    <div>$clientname</div>
                    HTML;
                }
            });
            $grid->column('task.lx_no')->display(function ($lx_no) {
                return $this->task?->code ?? $this->localtask->code ?? "";
            });
            // $grid->column('task_id', 'Client\'s Job No.')
            // // ->select('task_id')
            // ->select(Task::doesntHave('invoices')->pluck('lx_no', 'id')->prepend('', 0));
            $grid->column('invoiceCode', 'C8 Inv.')->sortable();
            $grid->column('company')->width(300)->display(function(){
                $displayname =  $this->job?->company ?? $this->localtask?->title ?? "";
                $display_description = $this->job?->jobdescription ?? $this->localtask->description;
                return <<<HTML
                $displayname
                <div class="text-gray-400">{$display_description}</div>
                HTML;
            })
            ;
            $grid->column('job.jobtypeKey')->display(function(){
                return <<<HTML
                {$this->job?->jobtypeKey}
                HTML;
            });
            $grid->column('lx_code', 'LX Invoice No')->sortable();
            $grid->column('invoiceDate')->display(function ($invoiceDate) {
                return $invoiceDate?->format('Y-m-d');
            })->sortable();
            $grid->column('total')->sortable();
            // $grid->column('vendor_total');
            $grid->column('vendor_total')->display(function () {
                return $this->task?->pos->sum('total') ?: "";
            });
            // $grid->column('tranRemark')->width(300);
            // $grid->column('reviseDate');
            // $grid->column('words');
            // $grid->column('pages');
            // $grid->column('other');
            // $grid->column('less');
            // $grid->column('meta');
            // $grid->column('translator')->display(function () {
            //     return $this->job?->meta?->translator?->name ?? '';
            // });
            $grid->column('Transtatus')->display(function ($Transtatus) {
                return $this->invoicestatus;
            })->sortable();
            // $grid->column('ApproveId');
            $grid->column('sales')->display(function ($sales) {
                return $this->job?->meta?->sales?->name;
            });
            $grid->column('no_more_sync')->switch();
            // $grid->column('created_at')->display(function ($created_at) {
            //     return $created_at->format('Y-m-d');
            // });
            // $grid->column('updated_at')->dispaly(function($updated_at){
            //     return $updated_at->format('Y-m-d');
            // })->sortable();
            $grid->column('id')->display(function ($id) {
                return <<<HTML
                <a class="text-blue-600" data-popup href="/admin/invoices/$this->id/view" target="_blank">View</a>
                HTML;
            })
            ->sortable();

            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->equal('id');

            // });

            $grid->actions([
                // ReScanAttachmentRowAction::make()
                GenerateInvoiceNo::make(),
                // JobPurchaseOrderAction::make()
            ]);

            $grid->quickSearch(['lx_code', 'invoiceCode', 'job.company', 'job.job_code', 'job.status', 'job.meta'])
            ->placeholder('lx_code, invoiceCode, company, job_code, status, meta')
            ;


        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Invoice(), function (Show $show) {
            $show->field('id');
            $show->field('idjob');
            $show->field('task_id');
            $show->field('tranRemark');
            $show->field('total');
            $show->field('invoiceDate');
            $show->field('reviseDate');
            $show->field('words');
            $show->field('pages');
            $show->field('other');
            $show->field('less');
            $show->field('meta');
            $show->field('no_more_sync');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Invoice(), function (Form $form) {
            $form->display('id');
            $form->text('job');
            $form->text('task_id');
            $form->text('tranRemark');
            $form->text('total');
            $form->text('invoiceDate');
            $form->text('reviseDate');
            $form->switch('no_more_sync');
            $form->text('words');
            $form->text('pages');
            $form->text('other');
            $form->text('less');
            $form->text('meta');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function view(InvoiceModel $invoice){

        $invoice->load([
            'task.client',
            'task.job',
            'job',
            'localtask.client',
        ]);

        // dump($invoice->localtask);

        return view('admin.invoice.view', [
            'invoice' => $invoice,
            'cre' => Client::find(1),
        ]);
    }

    public function build(Content $content){
        return view('admin.invoice.view', [

        ]);
    }

    public function invoiceCreate(Content $content){
        $invoice = new InvoiceModel();
        $invoice->InvoiceNo = InvoiceModel::max('InvoiceNo') + 1;
        // dd($invoice);
        return $content
            ->header('Create Invoice')
            ->description('Description...')
            ->body(view('admin.invoice.form', [
                'invoice' => $invoice,
            ]));
    }
    public function invoiceEdit(Content $content, InvoiceModel $invoice){
        return $content
            ->header('Edit Invoice')
            ->description('Description...')
            ->body(view('admin.invoice.form', [
                'invoice' => $invoice,
            ]));
    }

    public function save(){
        return InvoiceModel::updateOrCreate(
            ['id' => request('id', null)],
            array_merge(request()->all())
        );
        return request()->all();
    }
}
