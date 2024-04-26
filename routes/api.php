<?php

use App\Models\C8CJob;
use App\Models\Invoice;
use App\Mail\EmailReply;
use Illuminate\Http\Request;
use App\Services\MailServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Illuminate\Support\Facades\Request as RequestFacade;
// use Dacastro4\LaravelGmail\Services\Message\Mail as Gmail;

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


Route::post('/mail/send', function (Request $request){

    $inputModel = $request->all();

    // // return $inputModel['to'];
    // $mail = new Gmail;

    // $mail->from('translation@lingxpert.com');
    // // $mail->to(collect($inputModel['to'])->map(fn($email) => $email['email'])->toArray());
    // $mail->to('ych8815@gmail.com');
    // $mail->cc('');
    // $mail->bcc('');
    // // // $mail->cc( $cc, $name = null );
    // // // $mail->bcc( $bcc, $name = null )
    // $mail->subject( "test subject" );

    // $mail->message( "test message" );

    // // $mail->view( 'view.name', $dataArray )

    // // $mail->markdown( 'view.name', $dataArray )
    // // $attachments = collect($inputModel['attachments']);
    // // $attachments->each(function($attachment) use ($mail){
    // //     $mail->attach( $attachment['path']);
    // // });
    // // $mail->attach(  )

    // // $mail->priority( $priority )

    // return $mail->send();
    // dd($mail);

    // ------------------------
    $services = new MailServices();
    $services->send_email($inputModel);

    return response()->json([
        "message" => "Email sent successfully"
    ]);

});

Route::post('/upload', function (Request $request)
{

    // return request()->file('file');

    $dir = "public/uploads/" . date("Y-m");

    $paths = [];
    $files = RequestFacade::allFiles();

    // return $dir;
    // return $files;
    // return ($request->all());
    if ($files) {

        foreach ($files as $key => $file) {

            // $file = $request->file('file');
            // dd($file);
            $path = $file->storeAs(
                $dir,
                str()->uuid() . "." . $file->getClientOriginalExtension()
                // 'storage'
            );
            // $url = str()->replaceFirst('app/public', '/storage');

            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $mine = $file->getMimeType();

            // $file = File::create([
            //     "name" => $name,
            //     "size" => $file->getSize(),
            //     "ext" => $ext,
            //     "mine" => $mine,
            //     "path" => $path,
            //     "url" => $url,
            //     "fileable_id" => $request->input("fileable_id") ?? null,
            //     "fileable_type" => $request->input("fileable_type") ?? null,
            //     "fileable_category" => $request->input("fileable_category") ?? null,
            //     "uploaded_id" => $_SESSION['id'] ?? null,
            // ]);

            // $paths[] = $file->load("uploader");
            $path = str($path)->replaceFirst('public', '');
            $paths[] = [
                'name' => $name,
                'path' => $path,
                'is_inline' => false,
            ];
        }

        if ( request('for_type') == 'editor' ){
            return response()->json([
                'location' => '/storage'.$path,
            ]);
        }

        return response()->json([
            "files" => $paths,
        ]) ;
    }

    // if ($request->base64) {
    //     $file = Storage::put('app/public/extfile/', base64_decode($request->base64));
    //     return $file;
    // }

    return [
        "files" => $paths
    ];
});


Route::get('/hook', function(){
    Log::info('hook');
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
