<?php

namespace App\Repositories\Question;

use App\Question;
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\FilterInterface;
use Illuminate\Http\Request;

class QuestionRepository extends AbstractRepository implements FilterInterface
{
    public function filter(Request $request)
    {
        $this->builder = $this->builder->filter($request);

        return $this;
    }

    protected function entity(): string
    {
        return Question::class;
    }
}
