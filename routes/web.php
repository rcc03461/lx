<?php

use App\Models\Task;
use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Models\Invoice as InvoiceModel;
use App\Http\Controllers\TaskController;
use Webklex\IMAP\Facades\Client as ImapClient;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/oauth/gmail', function (){
    return LaravelGmail::redirect();
});

Route::get('/oauth/gmail/callback', function (){
    LaravelGmail::makeToken();
    return redirect()->to('/admin/emails');
});

Route::get('/oauth/gmail/logout', function (){
    LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/admin/emails');
});

Route::get('/try', function () {

    /** @var \Webklex\PHPIMAP\Client $client */
    // $client = Webklex\IMAP\Facades\Client::account('default');

    //Connect to the IMAP Server
    // $client->connect();

    //Get all Mailboxes
    /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
    // $folders = $client->getFolders();

        $oClient = ImapClient::account('default');
        $oClient->connect();

        $folders = $oClient->getFolders();
        // dump($folders->map(function($folder){
        //     return $folder->name;
        // }));
        // $folder = $oClient->getFolder('@/CANDICE');
        $folder = $oClient->getFolder('INBOX');
        // $folder = $oClient->getFolder('[Gmail]');
        // $folder = $oClient->getFolder('@/CURTIS');


        // dd($folder);
        $aMessages = $folder->query()
        // ->setFetchFlags(false)
        // ->setFetchBody(false)
        ->since('06.03.2024')
        // ->recent()
        ->limit(5)
        ->get()
        ->each(function($message){
            // dump($message->subject, $message->getFlags(), $message->getAttributes() );
            // dump($message->subject, $message->getFlags(), $message->getContainingFolder() );
            // dump($message->getAttributes());
            // dd($message->getFolder());
            // dd($message->getAttributes());
            // dd ([
            //     "uid" => $message->getAttributes()['uid'],
            //     "date" => $message->getDate(),
            //     "flags" => $message->getFlags(),
            //     "tag" => $message->getTag(),
            //     // "from" => $message->getFrom(),
            //     // "to" => $message->getTo(),
            //     // "cc" => $message->getCc(),
            //     // "bcc" => $message->getBcc(),
            //     "subject" => $message->getSubject(),
            //     // "text" => $message->getTextBody(),
            //     // "body" => $message->getHTMLBody()
            // ]);
            // return $message->subject;
        })
        ;

        // dd($aMessages);
        // foreach ($aMessages as $key => $message) {
        //     dump($message->subject);
        // }

        return $aMessages;

        //Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        foreach($folders as $folder){

            dump($folder->name);
            //Get all Messages of the current Mailbox $folder
            /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
            // $messages = $folder->messages()->all()->get();

            // /** @var \Webklex\PHPIMAP\Message $message */
            // foreach($messages as $message){
            //     echo $message->getSubject().'<br />';
            //     echo 'Attachments: '.$message->getAttachments()->count().'<br />';
            //     echo $message->getHTMLBody();

            //     //Move the current Message to 'INBOX.read'
            //     if($message->move('INBOX.read') == true){
            //         echo 'Message has ben moved';
            //     }else{
            //         echo 'Message could not be moved';
            //     }
            // }
        }


        return "";

        // $oClient = ImapClient::account('gmail');
        $oFolder = $oClient->getFolder('INBOX');
        $aMessage =  $oFolder->query()
        ->setFetchOrder("desc")
        // ->since(Carbon::now()->subDays(2))
        // ->whereText('PO From Nexgen')
        // ->text('HKPO1996640')
        ->limit(20)
        // ->markAsRead()
        ->get();


        $allmessages = [];

        foreach($aMessage as $oMessage){

            $subject = (string)$oMessage->subject->toString();
            if (!str($subject)->contains('PO From Nexgen')) continue;

            $singlemessage = new \stdClass();
            $singlemessage->subject = $subject;
            $singlemessage->content = $oMessage->getHTMLBody(true);

            $allmessages[] = $singlemessage;

        }

        dump($allmessages);


});

Route::get('/', function () {
    return redirect('/admin');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::get('/lx/invoices/{invoice}/view', function (InvoiceModel $invoice) {
    $invoice->load([
        'task.client',
        'task.job',
        'job',
    ]);

    // dump($invoice);

    return view('admin.invoice.view', [
        'invoice' => $invoice,
        'cre' => Client::find(1),
    ]);
});

// Route::group(['middleware' => ['auth', 'verified']], function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');

//     Route::resource('tasks', TaskController::class);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::resource('tasks', TaskController::class);
// // Route::get('/tasks', function () {
// //     return Inertia::render('Tasks/List', [
// //         'tasks' => \App\Models\Task::all(),
// //     ]);
// // })->middleware(['auth', 'verified'])->name('tasks');

// Route::get('/invoices', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('invoices');

require __DIR__.'/auth.php';
