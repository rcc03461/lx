<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class C8CJob extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'c8_c_jobs';

    protected $fillable = [
        "idjob",
        "job_code",
        "jobdescription",
        "company",
        "jobtypeKey",
        "status",
        "description",
        "meta",
        "idtranslator",
        "othertranslator",
    ];

    protected $casts = [
        'meta' => 'object',
        'othertranslator' => 'array',
    ];

    protected $appends = [
        'jobtype',
    ];

    public function getJobtypeAttribute()
    {
        return str($this->attributes['job_code'])->between('_', '[')->trim();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'idjob', 'idjob');
    }

}
