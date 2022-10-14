<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        "task_id",
        "idjob",
        "invoiceCode",
        "InvoiceNo",
        "version",
        "ApproveId",
        "Transtatus",
        "InvoiceTime",
        "tranRemark",
        "total",
        "invoiceDate",
        "reviseDate",
        "words",
        "pages",
        "other",
        "less",
        "meta",
    ];


    protected $casts = [
        'words' => 'object',
        'pages' => 'object',
        'other' => 'array',
        'less' => 'array',
        'meta' => 'object',
    ];
}
