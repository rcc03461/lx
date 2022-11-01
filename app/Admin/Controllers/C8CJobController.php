<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\C8CJob;
use App\Models\C8CJob as C8CJobModel;
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

            $grid->model()->orderBy('idjob', 'desc');

            $grid->column('id')->sortable();
            $grid->column('idjob')->sortable();
            $grid->column('job_code');
            $grid->column('jobtypeKey');
            $grid->column('company')->width(500)->display(function ($company) {
                return <<<HTML
                <div>$this->company</div>
                <div class="text-xs text-gray-300">$this->jobdescription</div>

HTML;
            });
            $grid->column('idtranslator');
            $grid->column('othertranslator');
            $grid->column('status');
            // $grid->column('description');
            $grid->column('sales')->display(function ($sales) {
                return $this->meta->sales->name;
            });
            // $grid->column('meta');
            // $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->quickSearch(['idjob' ,'job_code', 'company', 'jobdescription']);
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
            $show->field('idjob');
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
            $form->text('idjob');
            $form->text('job_code');
            $form->text('jobdescription');
            $form->text('company');
            $form->text('description');
            $form->text('meta');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function apiSearch(){
        $q = request()->get('q');
        $data = C8CJobModel::where('job_code', 'like', "%$q%")->orWhere('company', 'like', "%$q%")->take(20)->get();
        return $data;
    }

    public function apiGetJob( C8CJobModel $job ){
        return $job;
    }
}
