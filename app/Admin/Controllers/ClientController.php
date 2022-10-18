<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Client;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ClientController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Client(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('phone');
            $grid->column('address');
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
        return Show::make($id, new Client(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('phone');
            $show->field('address');
            // $show->field('meta');
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
        return Form::make(new Client(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('attn');
            $form->text('email');
            $form->text('phone');
            $form->textarea('address');
            // $form->text('meta');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
