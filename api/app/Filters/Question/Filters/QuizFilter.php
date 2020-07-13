<?php

namespace App\Filters\Question\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class QuizFilter implements FilterInterface
{
    public function filter(Builder $builder, $value)
    {
        return $builder->where('quiz_id', $value);
    }
}
