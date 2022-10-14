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
        "description",
        "meta",
    ];

    protected $casts = [
        'meta' => 'object',
    ];

}
