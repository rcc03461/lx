<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        'ref_id',
        'account',
        'name',
        'color',
        'messageListVisibility',
        'labelListVisibility',
        'type',
    ];

    protected $casts = [
        'color' => 'object',
    ];

    public function customer(){
        $this->where('type', 'user');
    }

}
