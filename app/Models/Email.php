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
    ];

    protected $casts = [
        "has_attachments" => "boolean",
        "from" => "object",
        "to" => "array",
        "cc" => "array",
        "bcc" => "array",
        "email_datetime" => "datetime",
    ];

}
