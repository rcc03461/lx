<?php

namespace App\Admin\Repositories;

use App\Models\Vendor as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Vendor extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
