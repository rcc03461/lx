<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Layout\Row;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dacastro4\LaravelGmail\LaravelGmailClass;
use App\Admin\Metrics\Examples\LXInvoicesChart;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class TaskControlController extends Controller
{
    public function inbox(Content $content)
    {

        $messages = LaravelGmail::check() ? LaravelGmail::message()->take(30)->preload()->all() : [];
        // foreach ( $messages as $message ) {
        //     // $labels = $mailbox->labelsList( $message );
        //     // dd($message);
        //     $labels = $message->getLabelIds();
        //     dump($labels);
        //     $body = $message->getHtmlBody();
        //     $subject = $message->getSubject();
        // }

        // return $data;
        return $content
            ->header('Control')
            ->description('Description...')
            ->body(view('admin.control.index', [
                "messages" => $messages,
            ]));
    }

    public function index(Content $content)
    {


        // // $mailbox = new LaravelGmailClass(config(), "me");


        // $messages = LaravelGmail::check() ? LaravelGmail::message()->take(30)->preload()->all() : [];
        // // foreach ( $messages as $message ) {
        // //     // $labels = $mailbox->labelsList( $message );
        // //     // dd($message);
        // //     $body = $message->getHtmlBody();
        // //     $subject = $message->getSubject();
        // // }

        // // return $data;
        // return $content
        //     ->header('Control')
        //     ->description('Description...')
        //     ->body(view('admin.control.index', [
        //         "messages" => $messages,
        //     ]));
    }

    public function action($message_id)
    {

        // new Google_Service_Gmail()
        $mailbox = new LaravelGmailClass(config(), LaravelGmail::user());
        $message = LaravelGmail::message()->get( $message_id );
        $labels = $mailbox->labelsList($message);
        // dd($labels);
        $message->removeLabel(['Label_5083418190461320972']);
        // dd( $message->getLabels() );
        // dd( $message->getLabels() );
        // dd( $message->addLabel(['Jobs', 'Hing']) );
        return LaravelGmail::message()->get( $message_id );
    }
}
