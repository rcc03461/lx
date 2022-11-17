<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\PurchaseOrder;
use App\Admin\Repositories\Vendor;
use App\Models\Vendor as VendorModel;
use App\Admin\Renderable\VendorPOTable;
use Dcat\Admin\Http\Controllers\AdminController;

class VendorController extends AdminController
{

    public function statement( VendorModel $vendor ){

        $from = request('from', now()->startOfMonth()->format('Y-m-d'));
        $to = request('to', now()->endOfMonth()->format('Y-m-d'));
        $orderby = request('orderby', 'po_no' );

        $pos = PurchaseOrder::whereBetween('job_date', [$from, $to])->orderBy($orderby)->get();

        return view('admin.vendor.statement', [
            'from' => $from,
            'to' => $to,
            'orderby' => $orderby,
            'vendor' => $vendor,
            'pos' => $pos,
        ]);

    }

    protected function grid()
    {
        return Grid::make(new Vendor(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name')->sortable()
            ->expand(function(){
                return VendorPOTable::make([
                    "vendor_id" => $this->id
                ]);
            });

            $grid->column('address')->sortable();
            $grid->column('phone')->sortable();
            $grid->column('email')->sortable();
            $grid->column('remark')->sortable();

            $grid->column('view')->display(function () {
                return <<<HTML
                <div class="text-blue-500 hover:text-blue-300" data-popup href="/admin/print/vendors/$this->id/statement" target="_blank">Statement</div>
                HTML;
            });

            // $grid->column('created_at');
            $grid->column('updated_at')->sortable();


            $grid->quickSearch(['name','address','phone','email','remark'])->placeholder('name, address, phone, email, remark');

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
