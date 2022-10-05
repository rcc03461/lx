<?php

namespace App\Admin\Repositories;

use App\Models\C8CJob as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class C8CJob extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
