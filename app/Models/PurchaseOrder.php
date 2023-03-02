<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'task_id',
        'vendor_id',
        'po_no',
        'job_date',
        'items',
        'total',
        'attachments',
        'wip_at',
        'settled_at',
        'settled_ref',
    ];

    protected $casts = [
        'items' => 'array',
        'attachments' => 'array',
    ];

    protected $dates = [
        'job_date',
        'settled_at',
    ];

    protected $appends = [
        'code',
        'is_settled',
    ];

    public function getCodeAttribute(){
        return 'PO' . $this->po_no;
    }

    public function getIsSettledAttribute(){
        return $this->settled_at ? true : false;
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

}
