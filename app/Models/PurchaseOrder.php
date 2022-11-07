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
        'vender_id',
        'job_date',
        'items',
        'total',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
