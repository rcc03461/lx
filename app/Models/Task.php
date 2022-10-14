<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use HasFactory;
    ref
    ref_id
    job_code
    protected $fillable = [
        'client_id',
        // 'ref',
        // 'ref_id',
        'idjob',
        // 'job_code',
        'title',
        'description',
        'remark',
        'job_in_date',
        'publish_date',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
    protected $dates = [
        'publish_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


}
