<?php

namespace Tests\Feature;

use App\Question;

trait CreateQuestion
{
    use CreateQuiz;

    private function question_data()
    {
        return [
            'text' => 'What is science?',
            'quiz_id' => null,
        ];
    }

    private function create_question()
    {
        $quiz = $this->create_quiz();

        return factory(Question::class)->create(
            array_merge(
                $this->question_data(),
                ['quiz_id' => $quiz->id]
            )
        );
    }
}
