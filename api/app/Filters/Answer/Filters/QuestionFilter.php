<?php

namespace App\Filters\Answer\Filters;

use App\Filters\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class QuestionFilter implements FilterInterface
{
    public function filter(Builder $builder, $value)
    {
        return $builder->where('question_id', $value);
    }
}
