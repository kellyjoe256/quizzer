<?php

namespace App\Repositories;

use App\Quiz;
use App\Repositories\Contracts\QuizRepositoryInterface;

class QuizRepository extends AbstractRepository implements QuizRepositoryInterface
{
    public function findByUser(
        $user_id,
        array $sort_order,
        array $relations = []
    ) {
        $query = $this->entity->with($relations)->select($this->columns);
        $this->orderResultSet($query, $sort_order);
        $query->where('user_id', $user_id);

        return $query->paginate(config('custom.per_page', 10));
    }

    protected function entity()
    {
        return Quiz::class;
    }

    protected function setColumns()
    {
        $this->columns = [
            'id', 'name', 'description', 'user_id', 'created_at',
        ];
    }
}
