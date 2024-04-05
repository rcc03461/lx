<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Services\HtmlImageFullPath;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailReply extends Mailable
{
    use Queueable, SerializesModels;

    // Public $m_to;
    // Public $m_cc;
    // Public $m_bcc;
    // Public $m_subject;
    Public $m_body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($input)
    {
        // dd($input);
        $this->input = $input;
        // $this->to = $input['to'];
        // $this->cc = $input['cc'];
        // $this->bcc = $input['bcc'];
        $this->subject = $input['subject'];
        $this->m_body = $input['body'] ?? $input['message'];

        $this->m_body = $this->replaceImagePath($this->m_body);

        // dd($this->m_body);
        // $this->attachments = $input['attachments'];

        // dump($input['attachments']);
        if(isset($input['attachments'])) {
            foreach($input['attachments'] as $path) {
                // dump($input['attachments']);
                $this->attachFromStorageDisk('public', $path['path'], $path['name']);
            }
        }
        // dd($input['attachments']);
        // dd($this->attachments);
    }

    public function replaceImagePath($body)
    {
        $base_url = env('APP_URL');
        // dd($base_url);
        $pattern = '/src="(.*?)\/storage/i';
        $replace = 'src="'.$base_url.'/storage';
        $body = preg_replace($pattern, $replace, $body);
        return $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->view('emails.reply');
    }
}
