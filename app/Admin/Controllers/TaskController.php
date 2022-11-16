<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\C8CJob;
use App\Models\Client;
use Illuminate\Support\Carbon;
use App\Admin\Repositories\Task;
use App\Admin\Renderable\POTable;
use App\Models\Task as TaskModel;
use App\Models\Task as ModelsTask;
use App\Admin\Forms\TranslationForm;
use App\Admin\Renderable\C8CJobsTable;
use App\Admin\Renderable\TaskInvoiceTable;
use App\Admin\Actions\Grid\CreatePOByTaskId;
use App\Admin\Actions\Tools\EstimatedRevenue;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Actions\Grid\CreateInvoiceByTaskId;

class TaskController extends AdminController
{

    public function view( ModelsTask $task ){
        // return $task->load(['job', 'client']);
        return view('admin.task.view', [
           'task' => $task->load(['job', 'client'])
        ] );
    }
    public function estimated_revenue( ){

        $from = request('from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $to = request('to', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $orderby = request('orderby', 'lx_no' );

        $tasks = TaskModel::whereBetween('end_date', [$from, $to])->orderBy($orderby)->get();

        return view('admin.task.estimated_revenue', [
            'tasks' => $tasks,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function apiGetTask( ModelsTask $task ){
        return $task->load(['job', 'client']);
    }

    public function apiSearch( ){
        $q = request()->get('q');
        return TaskModel::with(['job'])
            ->where('lx_no', 'like', "%$q%")
            ->orWhere('title', 'like', "%$q%")
            ->orHasByNonDependentSubquery('job', function($query) use ($q){
                $query->where('job_code', 'like', "%$q%");
            })
            ->get();
    }

    protected function grid()
    {
        return Grid::make(TaskModel::with(['job', 'client', 'invoices'])->withSum('pos', 'total')->withSum('invoices', 'total'), function (Grid $grid) {


            $grid->selector(function (Grid\Tools\Selector $selector) {

                $selector->selectOne('client_id', 'Client', Client::pluck('name', 'id'));

                // select month of last year from now
                $months = [];
                $maxEndDate = TaskModel::max("end_date");
                $maxEndDate = $maxEndDate ? Carbon::parse($maxEndDate) : now();
                // dd($maxEndDate);
                for ($i = 0; $i < 12; $i++) {
                    $months[$maxEndDate->format('Y-m')] = $maxEndDate->format('Y-m');
                    $maxEndDate->subMonth();
                }
                // dd($months);
                $selector->selectOne('end_date', 'Month', $months, function($query, $value){
                    // $value = current($value);
                    [$year, $month] = explode('-', $value);
                    $query->whereYear('end_date', $year)->whereMonth('end_date', $month);
                });

            });

            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('lx_no')->sortable();
            $grid->column('client')
            ->display(function ($client) {
                return $client->name;
            })
            ->sortable();
            $grid->column('title')
            ->width(400)
            ->sortable()
            ->display(function ($job) {
                return <<<HTML
                <div class="text-blue-500 hover:text-blue-300" data-popup href="/admin/task/{$this->id}/view" target="_blank">{$this->title}</div>
                <div class="text-xs text-gray-300">{$this->description}</div>
HTML;
            });
            $grid->column('job_')->width(400)->display(function ($job) {
                // <a data-popup href="/admin/invoices/build?task_id={$this->id}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg></a>
                // {$this->job?->job_code}

                return <<<HTML
                <div>
                    {$this->job?->job_code}
                </div>
                <div class="text-xs text-gray-300">{$this->job?->jobdescription}</div>
HTML;
            });

//             $grid->column('invoices_')->display(function ($job) {
//                 $invoices = collect($this->invoices)->map(function ($invoice) {
//                     return <<<HTML
//                     <a data-popup href="/admin/invoices/{$invoice['id']}/view" target="_blank">
//                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
//                     </a>
//                     HTML;
//                 })->implode(' ');

//                 return <<<HTML
//                     <a href="/admin/invoices/create?task_id={$this->id}">
//                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>
//                     </a>
//                     {$invoices}
// HTML;
//             })
//             ->expand(function(){
//                 return TaskInvoiceTable::make([
//                     "task_id" => $this->id
//                 ]);
//             });
            // ->modal(function ($modal) {
            //     $modal->title('Translation');
            //     $modal->xl();
            //     return TranslationForm::make()->setKey($this->id)->payload(["id" => $this->id]);
            // })
            // $grid->column('description');
            // $grid->column('remark');
            $grid->column('end_date')->width(120)
            ->display(function($endDate){
                return $endDate ? $endDate->format('Y-m-d') : "";
            })
            ->sortable()
            ->editable(true)
            // ->date()
            // ->editableDate(true)
            ;
            $grid->column('invoices_sum_total')
            // ->addTableClass(['text-right'])
            ->display(function($total){
                return $total ? number_format($total, 2) : "";
            })
            ->expand(function(){
                return TaskInvoiceTable::make([
                    "task_id" => $this->id
                ]);
            });
            $grid->column('pos_sum_total')
            // ->addTableClass(['text-right'])
            ->display(function($total){
                return $total ? number_format($total, 2) : "";
            })
            ->expand(function(){
                return POTable::make([
                    "task_id" => $this->id
                ]);
            });

            $grid->column('estimated_revenue')
            // ->addTableClass(['text-right'])
            ->display(function($total){
                return $total ? number_format($total, 2) : "";
            })
            ->sortable();
            // $grid->column('publish_date')->sortable();
            // $grid->column('meta');

            // $grid->column('PO')->display(function () {
            //     return <<< HTML
            //     <a href="/admin/purchase_orders/create?task_id={$this->id}">Create</a>
            //     HTML;
            // });
            // $grid->column('created_at')->sortable();
            $grid->column('updated_at')->sortable();

            $grid->actions([
                // ReScanAttachmentRowAction::make()
                CreateInvoiceByTaskId::make(),
                CreatePOByTaskId::make(),
                // JobPurchaseOrderAction::make()
            ]);

            $grid->tools([
                EstimatedRevenue::make(),
            ]);
            // $grid->tools("<div class='btn-group' id='tools-group' style='margin-right:3px'>
            // <a data-popup href='/' class='btn btn-primary'>
            // <i class='feather icon-plus'></i>
            // <span class='d-none d-sm-inline'>&nbsp;&nbsp;新增</span>
            // </a>
            // </div>");

            $grid->quickSearch(['id', 'title', 'client.name', 'job.job_code', 'job.jobdescription'])->placeholder('id, title, client.name, job.job_code, job.jobdescription');

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
            $show->field('lx_no');
            $show->field('client_id');
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
            $form->number('lx_no')->default(ModelsTask::max('lx_no') + 1);
            $form->selectTable('idjob', 'Job')
            ->title('C8C Jobs')
            ->from(C8CJobsTable::make())
            ->model(C8CJob::class, 'idjob', 'job_code');

            // $form->text('job_code');
            $form->text('title')->required();
            $form->textarea('description');
            $form->textarea('remark');
            $form->currency('estimated_revenue')->symbol('HK$');
            $form->datetime('job_in_date')->default(date('Y-m-d H:i:s'));
            $form->date('end_date');
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
