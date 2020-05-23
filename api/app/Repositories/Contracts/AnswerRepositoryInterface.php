<?php

namespace App\Repositories\Contracts;

interface AnswerRepositoryInterface extends RepositoryInterface
{
    public function findByQuestion(
        $question_id,
        array $sort_order,
        array $relations = []
    );
}
