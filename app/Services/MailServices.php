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

        foreach ($messages as $key => $message) {

            $message_id = $message->getId();

            $attachments = [];

            $exist = Email::where("message_id", $message_id)->exists();

            if ( $message->hasAttachments() && $exist == false ) {
                $message->getAttachments()->each(function ($attachment) use($message_id, &$attachments) {
                    // ($path = null, $filename = null, $disk = 'local')
                    $path = str($attachment->saveAttachmentTo( "public/attachments/{$message_id}" ))->replace("public/", "");
                    $attachments[] = $path;
                });
            }


            $toBeUpdate = [
                "message_id" => $message_id,
                "subject" => $message->getSubject(),
                "from" => $message->getFrom(),
                "to" => $message->getTo(),
                "cc" => $message->getCc(),
                "bcc" => $message->getBcc(),
                // "text_body" => $message->getPlainTextBody(),
                "html_body" => $message->getHtmlBody(),
                "email_datetime" => $message->getDate()->format('Y-m-d H:i:s'),
                "has_attachments" => $message->hasAttachments(),
                "attachments" => $attachments,
            ];

            if ( Email::where("message_id", $message_id)->exists() ) {
                Email::where("message_id", $message_id)->update($toBeUpdate);
            } else {
                $email = Email::create($toBeUpdate);
                $email->syncLabels($message->getLabels());
            }

        }

        return "success";
    }

    public function download_message( string $message_id ){

    }

    public function folder( string $folder_name, string $search_key ){

    }
    public function all_folders_name( string $search_key ){

    }
}
