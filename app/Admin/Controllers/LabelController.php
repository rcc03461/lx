<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Label;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class LabelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Label(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('type');
            $grid->column('ref_id');
            $grid->column('ref_code');
            $grid->column('name');
            $grid->column('color');
            $grid->column('messageListVisibility');
            $grid->column('labelListVisibility');
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
        return Show::make($id, new Label(), function (Show $show) {
            $show->field('id');
            $show->field('ref_id');
            $show->field('ref_code');
            $show->field('name');
            $show->field('color');
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
        return Form::make(new Label(), function (Form $form) {
            $form->display('id');
            $form->text('ref_id');
            $form->text('ref_code');
            $form->text('name');
            $form->text('color');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
