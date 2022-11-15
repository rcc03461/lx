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
    ];

    protected $casts = [
        'items' => 'array',
    ];

    protected $dates = [
        'job_date',
    ];

    protected $appends = [
        'code',
    ];

    public function getCodeAttribute(){
        return 'LXPO-' . $this->po_no;
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

}
