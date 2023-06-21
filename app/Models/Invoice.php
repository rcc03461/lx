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
        "lx_code",
        "version",
        "ApproveId",
        "Transtatus",
        "InvoiceTime",
        "tranRemark",
        "total",
        "invoiceDate",
        "settlement_date",
        "reviseDate",
        "words",
        "pages",
        "other",
        "less",
        "meta",
        "self_ref",
        "no_more_sync",
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
        'invoicestatus',
    ];

    protected $dates = [
        'invoiceDate',
        'settlement_date',
        'reviseDate',
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

    // public function setTaskIdAttribute($value)
    // {
    //     if ( empty($value) ) {
    //         $this->attributes['task_id'] = 1;
    //     }
    //     $this->attributes['task_id'] = $value;
    // }


    public function getInvoicestatusAttribute()
    {
        return self::TRANSTATUS[$this->Transtatus] ?? $this->Transtatus;
    }

    public function getCodeAttribute()
    {
        return $this->lx_code;
    }

    public function generateInvoiceNo()
    {
        $prefix = $this->invoiceDate->format('ym');
        if ($this->idjob) {
            $max = Invoice::whereBetween('invoiceDate', [ $this->invoiceDate->firstOfMonth(), $this->invoiceDate->lastOfMonth() ] )->whereNotNull('idjob')->max('lx_number') ?: 0;
            $max = str($max)->replaceFirst($prefix, '')->toString();
            $max = intval($max) + 1;
            $code = $prefix . sprintf('%02d', $max);
            return [$code, 'Cre8-'. $code];
        }else{
            $max = Invoice::whereNull('idjob')->max('lx_number') + 1;
            $code = $max;
            return [$code, 'LI-'. $code];
        }

    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'idjob', 'idjob');
    }

    public function localtask()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function job()
    {
        return $this->belongsTo(C8CJob::class, 'idjob', 'idjob');
    }


}
