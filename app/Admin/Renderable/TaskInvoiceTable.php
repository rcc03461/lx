<?php

namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Row;
use Illuminate\Support\Str;
use App\Admin\Repositories\Invoice;
use App\Models\Invoice as InvoiceModel;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Grid\LazyRenderable;

class TaskInvoiceTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // $purchase_order_id = $this->purchase_order_id;
        return Grid::make(new Invoice(), function (Grid $grid) {
            $grid->model()
                ->where("task_id", $this->task_id)
                // ->orderBy('id', 'desc');
                ;

            $grid->column('id', 'ID');
            $grid->column('idjob');
            $grid->column('invoiceCode');
            $grid->column('InvoiceNo')->display(function ($InvoiceNo) {
                return <<<HTML
                <a href="/admin/invoices/$this->id/edit">$InvoiceNo --- </a>
                HTML;
            });
            $grid->column('version');
            $grid->column('ApproveId');
            $grid->column('total');
            $grid->column('invoiceDate');
            $grid->column('reviseDate');


            $grid->disablerefreshButton();
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableBatchDelete();

            // $grid->tools(SetItemNoByProductType::make()->setKey($this->order_detail_id));
            // $grid->tools(RetriveDataFromSourceAction::make()->setKey($this->order_detail_id));

            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->like('po')->width(4);
            //     // $filter->like('name')->width(4);
            // });
        });
    }
}
