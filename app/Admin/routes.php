<?php

use App\Models\Task;
use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\TaskController;
use App\Admin\Controllers\EmailController;
use App\Admin\Controllers\C8CJobController;
use App\Admin\Controllers\VendorController;
use App\Admin\Controllers\AccountController;
use App\Admin\Controllers\InvoiceController;
use App\Admin\Controllers\TaskControlController;
use App\Admin\Controllers\PurchaseOrderController;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->post('/upload', 'HomeController@upload');
    // $router->get('/try', function(){
    //     return Task::with([
    //         'client',
    //         'invoices'
    //     ])->get();
    // });

    $router->resource('c8c_job', 'C8CJobController');
    $router->resource('vendors', 'VendorController');
    $router->resource('purchase_orders', 'PurchaseOrderController');

    $router->resource('client', 'ClientController');
    $router->resource('task', 'TaskController');
    $router->resource('account', 'AccountController');
    $router->resource('emails', 'EmailController');
    $router->resource('labels', 'LabelController');
    $router->get('account/report/{type}', [AccountController::class, 'report']);
    $router->post('api/account/update_settlements', [AccountController::class, 'update_settlements']);
    // $router->resource('invoice', 'InvoiceController');

    // $router->get('jobs/build', [JobController::class, 'build']);
    // $router->post('jobs/build-save', [JobController::class, 'buildSave']);
    // $router->get('jobs/build', 'JobController@build');
    $router->get('task/{task}/view', [TaskController::class, 'view']);
    $router->get('invoices', [InvoiceController::class, 'index']);
    $router->get('invoices/build', [InvoiceController::class, 'build']);
    $router->get('invoices/create', [InvoiceController::class, 'invoiceCreate']);
    $router->get('invoices/{invoice}', [InvoiceController::class, 'single']);
    $router->put('invoices/{invoice}', [InvoiceController::class, 'update']);
    $router->delete('invoices/{invoice}', [InvoiceController::class, 'destroy']);
    $router->get('invoices/{invoice}/edit', [InvoiceController::class, 'invoiceEdit']);
    $router->get('invoices/{invoice}/view', [InvoiceController::class, 'view']);
    $router->post('api/invoice', [InvoiceController::class, 'save']);

    // Print
    $router->get('print/estimated-revenue', [TaskController::class, 'estimated_revenue']);
    $router->get('print/vendors/{vendor}/statement', [VendorController::class, 'statement']);

    $router->get('purchase-orders/{po}/view', [PurchaseOrderController::class, 'view']);
    $router->get('api/c8c-jobs/{job:job_id}', [C8CJobController::class, 'apiGetJob']);
    $router->get('api/c8c-jobs', [C8CJobController::class, 'apiSearch']);
    $router->get('api/tasks/{task}', [TaskController::class, 'apiGetTask']);
    $router->get('api/tasks', [TaskController::class, 'apiSearch']);
    $router->get('api/generate-invoice-no', [InvoiceController::class, 'apiGenerateInvoiceNo']);


    // ================================== Control Panel

    // $router->get('control_panel', [TaskControlController::class, 'index']);
    $router->get('control_panel', [TaskControlController::class, 'inbox']);
    $router->get('control_panel/action/{message_id}', [TaskControlController::class, 'action']);


    $router->get('/api/labels', [EmailController::class, 'labels']);
    $router->get('/api/emails/contacts', [EmailController::class, 'contacts']);
    $router->get('/api/emails/{message:message_id}', [EmailController::class, 'info']);
    $router->put('/api/emails/{message:message_id}/labels', [EmailController::class, 'updateLabels']);

});
