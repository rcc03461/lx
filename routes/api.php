<?php

use App\Models\C8CJob;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
    ->whereNotNull('InvoiceNo')
    ->whereNotNull('lx_code')
    ->get()
    ->map(function($inv){
        return [
            'idtranslation'     => $inv->idtranslation,
            'idjob'             => $inv->idjob,
            'refInvNo'          => $inv->lx_code,
            'refInvAmt'         => $inv->total,
            'refInvDate'        => $inv->invoiceDate,
        ];
    })
    ;

    //  (request()->all());
});

Route::post('/lx/translation', function () {

    // return request()->all();
    // Log::info('/lx/translation', request()->all());
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
