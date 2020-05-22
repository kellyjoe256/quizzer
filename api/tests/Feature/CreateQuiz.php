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
            'description' => 'This is a _wonderful_ quiz',
            'user_id' => null,
        ];
    }

    private function create_quiz()
    {
        $user = $this->create_user();

        return factory(Quiz::class)->create(
            array_merge(
                $this->quiz_data(),
                ['user_id' => $user->id]
            )
        );
    }
}
