<?php

namespace App\Models;

use App\Traits\HasLabels;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasLabels;
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        "message_id",
        "from",
        "to",
        "cc",
        "bcc",
        "subject",
        "html_body",
        "text_body",
        "email_datetime",
        "has_attachments",
        "attachments",
        "ref"
    ];

    protected $casts = [
        "has_attachments" => "boolean",
        "from" => "object",
        "to" => "array",
        "cc" => "array",
        "bcc" => "array",
        "email_datetime" => "datetime",
        "attachments" => "array"
    ];



    // public function getToAttribute($value)
    // {
    //     return collect(json_decode($value))->filter(function ($item) {
    //         return filter_var($item->email, FILTER_VALIDATE_EMAIL);
    //     })->toArray();
    // }
    // public function getCcAttribute($value)
    // {
    //     return collect(json_decode($value))->filter(function ($item) {
    //         return filter_var($item->email, FILTER_VALIDATE_EMAIL);
    //     })->toArray();
    // }
    // public function getBccAttribute($value)
    // {
    //     return collect(json_decode($value))->filter(function ($item) {
    //         return filter_var($item->email, FILTER_VALIDATE_EMAIL);
    //     })->toArray();
    // }

}
