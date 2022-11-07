<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Vendor;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class VendorController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Vendor(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('address');
            $grid->column('phone');
            $grid->column('email');
            $grid->column('remark');
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
        return Show::make($id, new Vendor(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('address');
            $show->field('phone');
            $show->field('email');
            $show->field('remark');
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
        return Form::make(new Vendor(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->textarea('address');
            $form->text('phone');
            $form->text('email');
            $form->textarea('remark');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
