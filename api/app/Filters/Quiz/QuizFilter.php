<?php

namespace App\Filters\Quiz;

use App\Filters\AbstractModelFilter;
use App\Filters\Quiz\Filters\TakeTestFilter;
use App\Filters\Quiz\Filters\UserFilter;

class QuizFilter extends AbstractModelFilter
{
    protected $filters = [
        'user' => UserFilter::class,
        'user_id' => UserFilter::class,
        'tt' => TakeTestFilter::class,
        'take-test' => TakeTestFilter::class,
        'take_test' => TakeTestFilter::class,
    ];
}
