<?php

namespace Tests\Feature;

use App\Quiz;

trait CreateQuiz
{
    use CreateUser;

    private function quiz_data()
    {
        return [
            'name' => 'Science Quiz',
            'description' => 'This is a _wonderful_ quizzer',
            'user_id' => null,
        ];
    }

    private function create_quiz()
    {
        return Quiz::create($this->quiz_data());
    }
}
