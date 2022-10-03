<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'ref',
        'ref_id',
        'title',
        'description',
        'remark',
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
