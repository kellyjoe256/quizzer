<?php

namespace App\Filters\Quiz;

use App\Filters\AbstractModelFilter;
use App\Filters\Quiz\Filters\UserFilter;

class QuizFilter extends AbstractModelFilter
{
    protected $filters = [
        'user' => UserFilter::class,
        'user_id' => UserFilter::class,
    ];
}
