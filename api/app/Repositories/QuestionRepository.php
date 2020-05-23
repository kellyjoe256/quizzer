<?php

namespace App\Repositories;

use App\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;

class QuestionRepository extends AbstractRepository implements QuestionRepositoryInterface
{
    public function findByQuiz(
        $quiz_id,
        array $sort_order,
        array $relations = []
    ) {
        $query = $this->entity->with($relations)->select($this->columns);
        $this->orderResultSet($query, $sort_order);
        $query->where('quiz_id', $quiz_id);

        return $query->paginate(config('custom.per_page', 10));
    }

    protected function entity()
    {
        return Question::class;
    }

    protected function setColumns()
    {
        $this->columns = [
            'id', 'text', 'quiz_id', 'created_at',
        ];
    }
}
