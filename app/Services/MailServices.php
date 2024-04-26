<?php

namespace App\Services;

use App\Models\Email;
use App\Models\Label;
use App\Mail\EmailReply;
use Illuminate\Support\Carbon;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
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

    public function is_downloaded( $message_id ){
        return Email::where("message_id", $message_id)->exists();
    }
    public function download_messages( $limit = 5 ){

        $messages = LaravelGmail::check() ? LaravelGmail::message()->take($limit)->preload()->all() : [];

        // dump($messages);

        foreach ($messages as $key => $message) {

            $message_id = $message->getId();

            $attachments = [];

            $exist = Email::where("message_id", $message_id)->exists();

            // $htmlPlain = $message->getPlainTextBody();
            // $htmlRaw = $message->getRawPlainTextBody ();
            $html = $message->getHtmlBody();
            $labels = $message->getLabels();
            // $headers = $message->getHeaders();
            // echo $htmlPlain;
            // echo $htmlRaw;
            // echo $html;
            if ( in_array('DRAFT', $labels) ) continue;
            if ( $this->is_downloaded($message_id) ) continue;


            if ( $message->hasAttachments()  ) {
                $message->getAttachments()->each(function ($attachment) use($message_id, &$attachments, $html) {

                    // dd($attachment->getData());

                    // ($path = null, $filename = null, $disk = 'local')
                    $newNameUuid = str()->uuid();
                    $newName = $newNameUuid . ".". $attachment->getFileName();

                    // print_r($attachment->headerDetails);
                    $path = str($attachment->saveAttachmentTo( "public/attachments/{$message_id}", $newName ))->replace("public/", "");
                    $content_id = isset($attachment->headerDetails['Content-ID']) ? str($attachment->headerDetails['Content-ID'])->replace("<", "")->replace(">", "") : NULL;
                    $attachments[] = [
                        "path" => $path,
                        // "html" => $html,
                        "name" => $attachment->getFileName(),
                        "attachment_id" => $attachment->getId(),
                        // "headers" => $headers,
                        "attachment" => $attachment,
                        "is_inline" => $content_id && str($html)->contains(  "cid:" . $content_id ) ? true : false,
                        // "mime_type" => $attachment->getMimeType(),
                        // "size" => $attachment->getSize(),
                        "content_id" => $content_id,
                    ];
                    // $attachments[] = $attachment->getData();

                    // print_r($attachments);
                });
                // return ($attachments);
            }

            // return $attachments;


            $toBeUpdate = [
                "message_id" => $message_id,
                "subject" => $message->getSubject(),
                "from" => $message->getFrom(),
                "to" => collect($message->getTo())->filter(function($item){
                    return filter_var($item['email'], FILTER_VALIDATE_EMAIL);
                })->toArray(),
                "cc" => collect($message->getCc())->filter(function($item){
                    return filter_var($item['email'], FILTER_VALIDATE_EMAIL);
                })->toArray(),
                "bcc" => collect($message->getBcc())->filter(function($item){
                    return filter_var($item['email'], FILTER_VALIDATE_EMAIL);
                })->toArray(),
                "text_body" => $message->getPlainTextBody(),
                "html_body" => $message->getHtmlBody(),
                "email_datetime" => Carbon::parse(+$message->getInternalDate() / 1000)->setTimezone('Asia/Hong_Kong')->toDateTimeString(),
                // "internal_date" => $message->getInternalDate() / 1000,
                // "headers" => $message->getHeaders(),
                "has_attachments" => $message->hasAttachments(),
                "attachments" => $attachments,
            ];

            // dd($toBeUpdate);

            if ( Email::where("message_id", $message_id)->exists() ) {
                Email::where("message_id", $message_id)->update($toBeUpdate);
            } else {
                $email = Email::create($toBeUpdate);
                $email->syncLabels($labels);
            }

        }

        return true;
    }

    public function send_email( $inputModel ){
        Mail::to(request('to'))
        ->cc(request('cc'))
        ->bcc(request('bcc'))
        // ->subject($inputModel['subject'])
        ->send(new EmailReply($inputModel));
    }

    public function download_message( string $message_id ){

    }

    public function folder( string $folder_name, string $search_key ){

    }
    public function all_folders_name( string $search_key ){

    }
}
