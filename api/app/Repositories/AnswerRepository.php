<?php

namespace App\Repositories;

use App\Answer;
use App\Repositories\Contracts\AnswerRepositoryInterface;

class AnswerRepository extends AbstractRepository implements AnswerRepositoryInterface
{
    public function findByQuestion(
        $question_id,
        array $sort_order,
        array $relations = []
    ) {
        $query = $this->entity->with($relations)->select($this->columns);
        $this->orderResultSet($query, $sort_order);
        $query->where('question_id', $question_id);

        return $query->paginate(config('custom.per_page', 10));
    }

    protected function entity()
    {
        return Answer::class;
    }

    protected function setColumns()
    {
        $this->columns = [
            'id', 'value', 'is_true', 'question_id', 'created_at',
        ];
    }
}
