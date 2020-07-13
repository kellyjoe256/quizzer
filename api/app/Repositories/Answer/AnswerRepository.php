<?php

namespace App\Repositories\Answer;

use App\Answer;
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\FilterInterface;
use Illuminate\Http\Request;

class AnswerRepository extends AbstractRepository implements FilterInterface
{
    public function filter(Request $request)
    {
        $this->builder = $this->builder->filter($request);

        return $this;
    }

    protected function entity(): string
    {
        return Answer::class;
    }
}
