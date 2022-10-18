<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\Invoice;
use App\Models\Invoice as InvoiceModel;
use Dcat\Admin\Http\Controllers\AdminController;

class InvoiceController extends AdminController
{

    public function apiGenerateInvoiceNo()
    {
        $invoiceNo = InvoiceModel::generateInvoiceNo();
        return response()->json([
            'invoiceNo' => $invoiceNo,
        ]);
    }


    protected function grid()
    {
        return Grid::make(new Invoice(), function (Grid $grid) {
            $grid->column('id')->sortable()
            // $grid->column('idjob');
            ->display(function ($id) {
                return <<<HTML
                <a data-popup href="/admin/invoices/$id/view" target="_blank">$id</a>
                HTML;
            });
            $grid->column('task_id');
            $grid->column('total');
            $grid->column('invoiceDate');
            $grid->column('tranRemark');
            $grid->column('reviseDate');
            // $grid->column('words');
            // $grid->column('pages');
            // $grid->column('other');
            // $grid->column('less');
            // $grid->column('meta');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
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
        return view('admin.invoice.view', [
            'invoice' => $invoice->load([
                'task.client',
                'task.job',
            ]),
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
