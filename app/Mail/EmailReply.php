<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        // $this->to = $input['to'];
        // $this->cc = $input['cc'];
        // $this->bcc = $input['bcc'];
        $this->subject = $input['subject'];
        $this->m_body = $input['body'];

        // dd($this);
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
