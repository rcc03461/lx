<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\C8CJob;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class C8CJobController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new C8CJob(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('job_id');
            $grid->column('job_code');
            $grid->column('jobdescription');
            $grid->column('company');
            $grid->column('description');
            $grid->column('meta');
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
        return Show::make($id, new C8CJob(), function (Show $show) {
            $show->field('id');
            $show->field('job_id');
            $show->field('job_code');
            $show->field('jobdescription');
            $show->field('company');
            $show->field('description');
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
        return Form::make(new C8CJob(), function (Form $form) {
            $form->display('id');
            $form->text('job_id');
            $form->text('job_code');
            $form->text('jobdescription');
            $form->text('company');
            $form->text('description');
            $form->text('meta');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
