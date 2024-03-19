<?php

namespace App\Services;

use App\Models\Email;
use App\Models\Label;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Http;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class MailServices
{
    public $account;
    public function _construct()
    {
        // $this->account = Client::account('default');
    }

    public function download_labels(  ){
        $token = LaravelGmail::getToken()['access_token'];
        $account = LaravelGmail::getToken()['email'];
        $response = Http::withToken($token)->get("https://gmail.googleapis.com/gmail/v1/users/{$account}/labels");

        foreach ($response['labels'] as $key => $value) {
            Label::updateOrCreate([
                "ref_id" => $value['id'],
            ], [
                "ref_id" => $value['id'],
                "account" => $account,
                "name" => $value['name'],
                "color" => $value['color'] ?? null,
                "messageListVisibility" => $value['messageListVisibility'] ?? "show",
                "labelListVisibility" => $value['labelListVisibility'] ?? "labelShow",
                "type" => $value['type'],
            ]);
            // Email::updateOrCreate([
            //     "message_id" => $value->getId(),
            // ], [
            //     "message_id" => $value->getId(),
            //     "subject" => $value->getSubject(),
            //     "from" => $value->getFrom(),
            //     "to" => $value->getTo(),
            //     "cc" => $value->getCc(),
            //     "bcc" => $value->getBcc(),
            //     // "text_body" => $value->getPlainTextBody(),
            //     "html_body" => $value->getHtmlBody(),
            //     "email_datetime" => $value->getDate()->format('Y-m-d H:i:s'),
            //     "has_attachments" => $value->hasAttachments(),
            // ]);
        }
    }

    public function download_messages( $limit = 5 ){
        $messages = LaravelGmail::check() ? LaravelGmail::message()->take($limit)->preload()->all() : [];

        foreach ($messages as $key => $value) {
            $message = Email::updateOrCreate([
                "message_id" => $value->getId(),
            ], [
                "message_id" => $value->getId(),
                "subject" => $value->getSubject(),
                "from" => $value->getFrom(),
                "to" => $value->getTo(),
                "cc" => $value->getCc(),
                "bcc" => $value->getBcc(),
                // "text_body" => $value->getPlainTextBody(),
                "html_body" => $value->getHtmlBody(),
                "email_datetime" => $value->getDate()->format('Y-m-d H:i:s'),
                "has_attachments" => $value->hasAttachments(),
            ]);
            $message->syncLabels($value->getLabels());
        }
    }

    public function download_message( string $message_id ){

    }

    public function folder( string $folder_name, string $search_key ){

    }
    public function all_folders_name( string $search_key ){

    }
}
