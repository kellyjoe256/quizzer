<?php

namespace App\Filters\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filter
{
    public function scopeFilter(Builder $builder, Request $request)
    {
        $model = class_basename($this);
        $filter_class = "App\Filters\\{$model}\\{$model}Filter";

        if (!class_exists($filter_class)) {
            return $builder;
        }

        return (new $filter_class($request))->filter($builder);
    }
}
