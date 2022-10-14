<?php

use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\C8CJobController;
use App\Admin\Controllers\InvoiceController;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('c8c_job', 'C8CJobController');

    $router->resource('client', 'ClientController');
    $router->resource('task', 'TaskController');
    // $router->resource('invoice', 'InvoiceController');

    // $router->get('jobs/build', [JobController::class, 'build']);
    // $router->post('jobs/build-save', [JobController::class, 'buildSave']);
    // $router->get('jobs/build', 'JobController@build');
    $router->get('invoice', [InvoiceController::class, 'index']);
    $router->get('invoice/create', [InvoiceController::class, 'invoiceCreate']);
    $router->post('api/invoice', [InvoiceController::class, 'save']);
    $router->get('invoice/{job}', [InvoiceController::class, 'single']);
    $router->put('invoice/{job}', [InvoiceController::class, 'update']);
    $router->get('invoice/{job}/edit', [InvoiceController::class, 'buildEdit']);


    $router->get('api/c8c-jobs/{job:job_id}', [C8CJobController::class, 'apiGetJob']);
    $router->get('api/c8c-jobs', [C8CJobController::class, 'apiSearch']);

});
