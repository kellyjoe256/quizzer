<?php

namespace App\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements FilterInterface
{
    abstract public function filter(Builder $builder, $value);

    public function mappings(): array
    {
        return [];
    }

    protected function resolveFilterValue($value)
    {
        return collect($this->mappings())->get($value);
    }
}
