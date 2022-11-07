<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\PurchaseOrder;
use App\Models\Task;
use App\Models\Vendor;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PurchaseOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PurchaseOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('task_id');
            $grid->column('vender_id');
            $grid->column('job_date');
            $grid->column('items');
            $grid->column('total');
            // $grid->column('created_at');
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
        return Show::make($id, new PurchaseOrder(), function (Show $show) {
            $show->field('id');
            $show->field('task_id');
            $show->field('vender_id');
            $show->field('job_date');
            $show->field('items');
            $show->field('total');
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
        return Form::make(new PurchaseOrder(), function (Form $form) {
            $form->display('id');
            $form->select('task_id')
            ->options(Task::all()->pluck('lx_no', 'id'))
            ->required()
            ->default(request('task_id', null));

            $form->select('vender_id')
            ->options(Vendor::all()->pluck('name', 'id'))
            ->required();

            $form->date('job_date');

            $form->array('items', 'Items', function($table) {
                $table->text('title');
                $table->textarea('description');
                $table->number('qty');
                $table->text('unit');
                $table->currency('unit_price');
            })
            // ->useTable()
            ;
            $form->currency('total');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
