<?php

use App\Models\C8CJob;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Services\MailServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hook', function(){
    $services = new MailServices();
    $services->download_messages();
});

Route::get('/download_messages', function(){
    $services = new MailServices();
    $services->download_messages();
});

Route::get('/update_labels', function(){
    $services = new MailServices();
    $services->download_labels();
});


Route::post('/c8c_jobs', function () {
    // return request()->all();
    Log::info(request()->all());

    foreach (request()->jobs as $key => $value) {

        C8CJob::where('idjob', $value['idjob'])->updateOrCreate(
            ['idjob' => $value['idjob']],
            [
                'job_code' => $value['job_code'],
                'jobdescription' => $value['jobdescription'],
                'company' => $value['company'],
                'jobtypeKey' => $value['jobtypeKey'],
                'status' => $value['status'],
                'description' => $value['description'],
                'idtranslator' => $value['idtranslator'],
                'othertranslator' => $value['othertranslator'],
                'meta' => $value['meta'],
            ]
        );

    }

    return Invoice::where('updated_at', '>=' , now()->subHours(1))
    ->whereNotNull('idtranslation')
    ->whereNotNull('idjob')
    ->whereNotNull('lx_code')
    ->get()
    ->map(function($inv){
        return [
            'idtranslation'     => $inv->idtranslation,
            'idjob'             => $inv->idjob,
            'refInvNo'          => $inv->lx_code,
            'refInvAmt'         => $inv->total,
            'refInvDate'        => $inv->invoiceDate->format('Y-m-d H:i:s'),
            'invoiceInfo'       => "//panel.lingxpert.com/lx/invoices/{$inv->id}/view",
        ];
    })
    ;

    //  (request()->all());
});

Route::post('/lx/translation', function () {

    // return request()->all();
    // Log::info('/lx/translation', request()->all());
    $invoice = Invoice::where('idtranslation', request('idtranslation'))->first();
    if (  $invoice && $invoice->no_more_sync ){
        return $invoice->update([
            "ApproveId" => request('ApproveId'),
            "Transtatus" => request('Transtatus'),
        ]);
    }

    return Invoice::updateOrCreate([
        'idtranslation' => request('idtranslation'),
    ],
    array_merge(request()->all(), [
        'words' => json_decode(request('words', null)),
        'pages' => json_decode(request('pages', null)),
        'other' => json_decode(request('other', null)),
        'less' => json_decode(request('less', null)),
    ]));
});
