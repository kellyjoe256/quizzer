<?php

namespace App\Filters\Answer;

use App\Filters\AbstractModelFilter;
use App\Filters\Answer\Filters\QuestionFilter;

class AnswerFilter extends AbstractModelFilter
{
    protected $filters = [
        'question' => QuestionFilter::class,
        'question_id' => QuestionFilter::class,
    ];
}
