<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'vendors';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'remark',
    ];


    public function purchaseorders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
