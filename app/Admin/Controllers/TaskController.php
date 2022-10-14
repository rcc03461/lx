<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\C8CJob;
use App\Models\Client;
use App\Admin\Repositories\Task;
use App\Admin\Forms\TranslationForm;
use App\Admin\Renderable\C8CJobsTable;
use Dcat\Admin\Http\Controllers\AdminController;

class TaskController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Task(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('client_id');
            // $grid->column('ref');
            $grid->column('idjob');
            $grid->column('title')
            // ->modal(function ($modal) {
            //     $modal->title('Translation');
            //     $modal->xl();
            //     return TranslationForm::make()->setKey($this->id)->payload(["id" => $this->id]);
            // })
            ;
            $grid->column('description');
            $grid->column('remark');
            $grid->column('publish_date');
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
        return Show::make($id, new Task(), function (Show $show) {
            $show->field('id');
            $show->field('client_id');
            // $show->field('ref');
            $show->field('idjob');
            $show->field('title');
            $show->field('description');
            $show->field('remark');
            $show->field('publish_date');
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
        return Form::make(new Task(), function (Form $form) {
            $form->display('id');
            $form->select('client_id')->options(Client::all()->pluck('name', 'id'))->required()->default(1);
            // $form->text('ref');
            // $form->number('ref_id');
            // $form->text('idjob');
            $form->selectTable('idjob', 'Job')
            ->title('C8C Jobs')
            ->from(C8CJobsTable::make())
            ->model(C8CJob::class, 'idjob', 'job_code');

            $form->text('job_code');
            $form->text('title')->required();
            $form->textarea('description');
            $form->textarea('remark');
            $form->datetime('job_in_date')->default(date('Y-m-d H:i:s'));
            $form->datetime('publish_date');
            $form->table('meta', 'Translations', function($table) {
                $table->text('section');
                $table->select("direction")->options([
                    'e2c' => 'E > C',
                    'c2e' => 'C > E',
                    'cross-translation' => 'Cross-Translation',
                    'client' => 'Client',
                ]);
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
