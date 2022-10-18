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
        "idtranslation",
        "idjob",
        "invoiceCode", // final invoice number
        "InvoiceNo", // monthly invoice number
        "lx_number",
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

    protected $appends = [
        'code',
        // 'invoicestatus',
    ];

    public const TRANSTATUS = [
        1 => "To be Invoiced",
        2 => "Invoiced/Waiting for Approval",
        3 => "Approved",
        4 => "To be Revised",
        5 => "Revised/Waiting for Approval",
        6 => "Completed",
        9 => "Deleted",
    ];

    public function getCodeAttribute()
    {
        // return "";
        return $this->InvoiceNo ?: "LX-" . $this->lx_number;
    }

    public static function generateInvoiceNo()
    {
        // $invoiceNo = date("ym") . str_pad($invoiceNo + 1, 3, "0", STR_PAD_LEFT);
        $invoiceNo = Invoice::max('lx_number')+ 1;
        // $invoiceNo = Invoice::max('InvoiceNo')+ 1;

        return $invoiceNo;
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function job()
    {
        return $this->belongsTo(C8CJob::class);
    }


}
