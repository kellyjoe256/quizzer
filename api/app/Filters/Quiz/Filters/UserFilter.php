<?php

namespace App\Filters\Quiz\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class UserFilter implements FilterInterface
{
    public function filter(Builder $builder, $value)
    {
        return $builder->where('user_id', $value);
    }
}
