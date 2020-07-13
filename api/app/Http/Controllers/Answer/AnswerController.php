<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Answer\AddAnswerRequest;
use App\Http\Requests\Answer\EditAnswerRequest;
use App\Http\Resources\Answer\AnswerResource;
use App\Repositories\Answer\AnswerRepository;

class AnswerController extends Controller
{
    public function __construct(AnswerRepository $answers)
    {
        parent::__construct(
            $answers,
            AnswerResource::class,
            AddAnswerRequest::class,
            EditAnswerRequest::class,
        );
    }

    public function index()
    {
        $sort_order = [
            'value' => 'asc',
        ];
        $limit = (int) request('limit', $this->limit);
        $answers = $this->repository
            ->filter(request())
            ->sort($sort_order)
            ->paginate($limit);

        return $this->collection($answers);
    }
}
