<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Layout\Row;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use App\Admin\Metrics\Examples\LXInvoicesChart;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('Description...')
            ->body(function (Row $row) {
                // $row->column(6, function (Column $column) {
                //     $column->row(Dashboard::title());
                //     $column->row(new Examples\Tickets());
                // });

                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(12, new LXInvoicesChart());
                        // $row->column(6, new Examples\NewDevices());
                    });

                    // $column->row(new Examples\Sessions());
                    // $column->row(new Examples\ProductOrders());
                });
                // $row->column(6, function (Column $column) {
                //     $column->row(function (Row $row) {
                //         $row->column(6, new Examples\NewUsers());
                //         $row->column(6, new Examples\NewDevices());
                //     });

                //     $column->row(new Examples\Sessions());
                //     $column->row(new Examples\ProductOrders());
                // });
            });
    }
}
