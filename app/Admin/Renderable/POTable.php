<?php

namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Row;
use Illuminate\Support\Str;
use App\Admin\Repositories\Invoice;
use App\Models\Invoice as InvoiceModel;
use App\Models\PurchaseOrder;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Grid\LazyRenderable;

class POTable extends LazyRenderable
{

    public function grid(): Grid
    {
        // $purchase_order_id = $this->purchase_order_id;
        return Grid::make(new PurchaseOrder(), function (Grid $grid) {
            $grid->model()
                ->where("task_id", $this->task_id)
                // ->orderBy('id', 'desc');
                ;

            $grid->column('id', 'ID');
            $grid->column('vender_id');
            $grid->column('job_date');
            $grid->column('total');


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
