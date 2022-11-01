<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\Client;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\Invoice;
use App\Models\Invoice as InvoiceModel;
use App\Admin\Actions\Grid\GenerateInvoiceNo;
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
        return Grid::make(new Invoice(['task.client', 'job']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');

            // $grid->column('idjob');
            $grid->column('job.job_code', 'Job No.');
            $grid->column('idjob', 'Job Status');
            $grid->column('task_id', 'Client')->display(function ($task_id) {
                if ($task_id) {
                    return $this->task->client->name;
                }else{
                    return 'Cre8';
                }
            });
            $grid->column('task.title', 'Client\'s Job No.');
            // $grid->column('task_id');
            $grid->column('invoiceCode', 'C8 Inv.');
            $grid->column('company')->width(300)->display(function(){
                return <<<HTML
                {$this->job?->company}
                <div class="text-gray-400">{$this->job?->jobdescription}</div>
                HTML;
            });
            $grid->column('jobtype')->display(function(){
                return <<<HTML
                {$this->job?->jobtype}
                HTML;
            });
            $grid->column('lx_code', 'LX Invoice No');
            $grid->column('invoiceDate')->display(function ($invoiceDate) {
                return $invoiceDate?->format('Y-m-d');
            });
            $grid->column('total');
            $grid->column('vendor_total');
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
            });
            // $grid->column('ApproveId');
            $grid->column('sales')->display(function ($sales) {
                return $this->job?->meta?->sales?->name;
            });
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

            $grid->quickSearch(['lx_code', 'invoiceCode', 'job.company', 'job.job_code']);


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
        ]);

        // dump($invoice);

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
