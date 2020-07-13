<?php

namespace App\Repositories\Quiz;

use App\Quiz;
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\FilterInterface;
use Illuminate\Http\Request;

class QuizRepository extends AbstractRepository implements FilterInterface
{
    public function filter(Request $request)
    {
        $this->builder = $this->builder->filter($request);

        return $this;
    }

    protected function entity(): string
    {
        return Quiz::class;
    }
}
