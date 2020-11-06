<?php

namespace App\Filters\Question;

use App\Filters\AbstractModelFilter;
use App\Filters\Question\Filters\QuizFilter;

class QuestionFilter extends AbstractModelFilter
{
    protected $filters = [
        'quizzer' => QuizFilter::class,
        'quiz_id' => QuizFilter::class,
    ];
}
