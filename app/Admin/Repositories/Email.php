<?php

namespace App\Admin\Repositories;

use App\Models\Email as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Email extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
