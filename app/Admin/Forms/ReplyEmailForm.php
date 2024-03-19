<?php

namespace App\Admin\Forms;

use App\Models\Email;
use App\Mail\EmailReply;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Illuminate\Support\Facades\Mail;
use Dcat\Admin\Contracts\LazyRenderable;

class ReplyEmailForm extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        $inputModel = $this->seInput($input);
        // dd($inputModel);
        Mail::to($inputModel['to'])
        ->cc($inputModel['cc'])
        ->bcc($inputModel['bcc'])
        // ->subject($inputModel['subject'])
        ->send(new EmailReply($inputModel));

        return $this->response()->success('Processed successfully.')->refresh();
    }

    public function seInput($input){

        // dd(collect($input['to'])->count());
        $to = !isset($input['to']) ? [] : collect($input['to'])->map(function($item){
            return $item['email'];
        })->toArray();

        $cc = !isset($input['cc']) ? [] : collect($input['cc'])->map(function($item){
            return ['name' => $item['name'], 'address' => $item['email']];
        })->toArray();
        // dd($cc);
        $bcc = !isset($input['bcc']) ? [] : collect($input['bcc'])->map(function($item){
            return ['name' => $item['name'], 'address' => $item['email']];
        })->toArray();

        $model = [
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'subject' => $input['subject'],
            'body' => $input['body'],
            'attachments' => null,
        ];
        return $model;
    }
    /**
     * Build a form here.
     */
    public function form()
    {
        // $this->text('message_id')->readOnly();
        $this->table('to', function($field){
            $field->text('name');
            $field->text('email');
        });
        $this->table('cc', function($field){
            $field->text('name');
            $field->text('email');
        });
        $this->table('bcc', function($field){
            $field->text('name');
            $field->text('email');
        });
        $this->text('subject');
        $this->editor('body')->options([
            "content_css" => '/assets/css/editor_content.css'
        ]);
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        $email = Email::find($this->payload['id']);

        // dd($this->payload['id']);
        $receiver = match($this->payload['title']){
            'Reply All' => [
                'to' => collect([])->push($email->from),
                'cc' => $email->cc
            ],
            'Reply' => [
                'to' => collect([])->push($email->from),
                'cc' => []
            ],
            'Forward' =>[
                'to' => [],
                'cc' => []
            ],
        };

        // dd($this->payload['title']);
        return [
            'to'  => $receiver['to'],
            'cc' => $receiver['cc'],
            'subject' => "Re: " . $email->subject,
            'body' => $this->wrapOldMessage($email, $email->html_body ),
            'attachments' => null,
        ];
    }

    public function wrapOldMessage( $email, $old_message ){
        // NoReply <noreply@apac.toppanmerrill.com> 於 2024年3月13日 週三 上午9:30寫道：
        // On Sat, 16 Mar 2024 at 11:09, Xero &lt;noreply@send.xero.com&gt; wrote:
        $signature = <<<HTML
<p>Dear Team,</p>
<p></p><p></p><p></p>
<p>Best regards,</p>
<p></p>
<p>Curtis Yuen<br/>
Mobile: +852-9235 2879</p>
<p></p>
<p>Yan Yuen<br/>
Mobile: +852-6420 2015</p>
<p></p>
<p>Rose Yip <br/>
Direct Line: +852-2868 9717<br/>
Mobile: +852-9745 6494</p>
<p></p>
<p>Yvette Pang<br/>
Mobile: +852-5989 5713</p>
<p></p>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 11pt; color: black; font-family: sans-serif;">
    <tr><td colspan="2" style="padding: 5px 1px"><b>LingXpertLanguage Services Limited</b></td></tr>
    <tr><td width="100" style="padding: 3px 1px">Email:</td>    <td style="padding: 3px 1px"><a href="mailto:translation@lingxpert.com">translation@lingxpert.com</a></td></tr>
    <tr><td width="100" style="padding: 3px 1px">Hotline:</td>  <td style="padding: 3px 1px">+852-2868 9729</td></tr>
    <tr><td width="100" style="padding: 3px 1px">Fax:</td>      <td style="padding: 3px 1px">+852-8101 1281</td></tr>
    <tr><td width="100" style="padding: 3px 1px">Address:</td>  <td style="padding: 3px 1px">Room 1106, OfficePlus @Sheung Wan, 93-103 Wing Lok Street, Sheung Wan, Hong Kong</td></tr>
    <tr><td width="100" style="padding: 3px 1px">Website:</td>  <td style="padding: 3px 1px"><a href="http://www.LingXpert.com" target="_blank">www.LingXpert.com</a></td></tr>
</table>
HTML;
        $wrapMsg = "";
        return <<<HTML
$signature
<hr style="margin: 2rem 0px;" />
<div class="gmail_quote"><div dir="ltr" class="gmail_attr">$wrapMsg<br></div><blockquote class="gmail_quote" style="margin: 0px 0px 0px 0.8ex; border-left: 1px solid rgb(204, 204, 204); padding-left: 1ex;"><div class="msg8295916469085419493"><u></u>
$old_message
</div></blockquote></div>
HTML;
    }
}
