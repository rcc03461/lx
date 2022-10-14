<?php

namespace App\Admin\Renderable;

use App\Models\C8CJob;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

class C8CJobsTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new C8CJob(), function (Grid $grid) {
            $grid->column('idjob')->sortable();
            $grid->column('job_code');
            $grid->column('company');

            // $grid->quickSearch(['id', 'name']);

            $grid->paginate(10);
            $grid->disableActions();

            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->like('id')->width(4);
            //     $filter->like('name')->width(4);
            // });
        });
    }
}
