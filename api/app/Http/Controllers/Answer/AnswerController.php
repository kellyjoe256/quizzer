<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Answer\AddAnswerRequest;
use App\Http\Requests\Answer\EditAnswerRequest;
use App\Http\Resources\Answer\AnswerResource;
use App\Repositories\AnswerRepository;

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
            'value' => 'ASC',
            'created_at' => 'DESC',
        ];

        if (request('question')) {
            return $this->repository->findByQuestion(
                (int) request('question'),
                $sort_order
            );
        }

        return $this->repository->paginate($sort_order);
    }
}
