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

    protected $fillable = [
        'client_id',
        // 'ref',
        // 'ref_id',
        'idjob',
        // 'job_code',
        'lx_no',
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
    protected $appends = [
        'code',
    ];

    public function getCodeAttribute(){
        return $this->lx_no;
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function job()
    {
        return $this->belongsTo(C8CJob::class, 'idjob', 'idjob');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


}
