<?php

use App\Models\C8CJob;
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

    foreach (request()->all() as $key => $value) {
        C8CJob::where('job_id', $value['job_id'])->updateOrCreate(
            ['job_id' => $value['job_id']],
            [
                'job_code' => $value['job_code'],
                'jobdescription' => $value['jobdescription'],
                'company' => $value['company'],
                'description' => $value['description'],
                'meta' => $value['meta'],
            ]
        );

    }


    //  (request()->all());
});
