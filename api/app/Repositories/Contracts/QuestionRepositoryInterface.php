<?php

namespace App\Repositories\Contracts;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    public function findByQuiz(
        $quiz_id,
        array $sort_order,
        array $relations = []
    );
}
