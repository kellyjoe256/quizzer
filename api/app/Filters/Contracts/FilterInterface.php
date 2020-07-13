<?php

namespace App\Filters\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filter(Builder $builder, $value);
}
