<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use App\Models\Vendor;
use App\Admin\Repositories\PurchaseOrder;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\PurchaseOrder as PurchaseOrderModel;

class PurchaseOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new PurchaseOrder(['vendor', 'task']), function (Grid $grid) {

            $grid->selector(function (Grid\Tools\Selector $selector) {

                $selector->selectOne('vendor_id', 'Vendor', Vendor::pluck('name', 'id'));

                // select month of last year from now
                $months = [];
                $maxEndDate = now();
                // dd($maxEndDate);
                for ($i = 0; $i < 12; $i++) {
                    $months[$maxEndDate->format('Y-m')] = $maxEndDate->format('Y-m');
                    $maxEndDate->subMonth();
                }
                // dd($months);
                $selector->selectOne('job_date', 'Month', $months, function($query, $value){
                    // $value = current($value);
                    [$year, $month] = explode('-', $value);
                    $query->whereYear('job_date', $year)->whereMonth('job_date', $month);
                });

            });

            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->display(function () {
                $id = $this->id;
                return <<<HTML
<a class="text-blue-500" data-popup="" href="/admin/purchase-orders/{$id}/view" target="_blank">$id</a>
HTML;
            })->sortable();
            // $grid->column('task_id');
            $grid->column('po_no')->display(function () {
                return $this->code;
            })
            ->sortable()
            ->editable(true);
            $grid->column('vendor.name', 'Vendor')->width(300)->sortable();
            $grid->column('task.lx_no', 'LX Ref')->sortable();
            $grid->column('task.title', 'Title')->width(300)->display(function(){
                return <<<HTML
                {$this->task?->title}
                <div class="text-xs text-gray-400">{$this->task?->description}</div>
                HTML;
            });

            $grid->column('job_date')
            ->display(function () {
                return $this->job_date?->format('Y-m-d');
            })
            ->sortable();
            // $grid->column('items');
            $grid->column('detail')->display(function () {
                $items_display = collect($this->items)->map(function ($item) {
                    return <<<HTML
                    <div class="text-xs text-gray-400">{$item['title']}</div>
                    <div class="text-xs text-gray-400">{$item['description']}</div>
                    <div class="text-xs text-gray-400 mb-1">{$item['qty']} {$item['unit']} x HK$ {$item['unit_price']}</div>
                    HTML;
                })->implode('');
                return <<<HTML
                <div class="text-xs text-gray-400">$items_display</div>
                HTML;
            });
            $grid->column('total')->sortable();
            $grid->column('attachments');
            $grid->column('wip_at')->sortable()->editable(true);
            $grid->column('settled_at')->sortable()->editable(true);
            $grid->column('settled_ref')->editable(true);
            // $grid->column('created_at');
            // $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->quickSearch(['task.lx_no', 'vendor.name', 'po_no'])->placeholder('task.lx_no, vendor.name, po');

            $grid->export()->rows(function ($rows) {
                // dd($rows);
                foreach ($rows as $index => &$row) {
                    // dd($row->task->code);
                    // $row['po_no'] = $row->task->code;
                    $row['po_no'] = $row['code'];
                    // $row['task.lx_no'] = $row->task->code;
                    // $row['lx_no'] = $row->task->code;
                    // $row['extra'] = $row->task->code;
                }

                return $rows;
            })->xlsx();
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
            $show->field('po_no');
            $show->field('vendor_id');
            $show->field('job_date');
            $show->field('items');
            $show->field('total');
            $show->field('settled_at');
            $show->field('settled_ref');
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
        Admin::script(
            <<<JS
                Dcat.ready(function () {
                    $(document).on('keyup', "[name^=items]", function(){
                        let total = 0;
                        $(".has-many-items-form.fields-group").each(function(){
                            let qty = $(this).find('input.field_qty').val();
                            let price = $(this).find('input.field_unit_price').val();
                            total = total + (Number(qty) * Number(price));
                        });
                        $("[name=total]").val(total);
                    });
                    console.log('所有JS脚本都加载完了');
                });
            JS
        );
        return Form::make(new PurchaseOrder(), function (Form $form) {
            $form->display('id');
            $form->select('task_id')
            ->options(Task::all()->pluck('lx_no', 'id'))
            ->required()
            ->default(request('task_id', null));

            $form->select('vendor_id')
            ->options(Vendor::all()->pluck('name', 'id'))
            ->required();

            $form->text('po_no')->default(PurchaseOrderModel::max('po_no') + 1)->required();
            $form->date('job_date');

            $form->array('items', 'Items', function($table) {
                $table->text('title');
                $table->textarea('description');
                $table->number('qty');
                $table->text('unit');
                $table->decimal('unit_price');
            })
            // ->useTable()
            ;
            $form->decimal('total');
            $form->multipleFile('attachments', 'Attachments')->removable();
            $form->date('wip_at');
            $form->date('settled_at');
            $form->textarea('settled_ref');

            $form->display('created_at');
            $form->display('updated_at');
        });

    }

    public function view(PurchaseOrderModel $po){

        $po->load([
            'task.client',
            'task.job',
            'vendor',
        ]);

        // dump($invoice);

        return view('admin.purchase-order.view', [
            'po' => $po,
        ]);
    }

}
