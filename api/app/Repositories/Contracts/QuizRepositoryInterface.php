<?php

namespace App\Repositories\Contracts;

interface QuizRepositoryInterface extends RepositoryInterface
{
    public function findByUser(
        $user_id,
        array $sort_order,
        array $relations = []
    );
}
