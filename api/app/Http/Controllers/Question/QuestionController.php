<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Question\AddQuestionRequest;
use App\Http\Requests\Question\EditQuestionRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    public function __construct(QuestionRepository $questions)
    {
        parent::__construct(
            $questions,
            QuestionResource::class,
            AddQuestionRequest::class,
            EditQuestionRequest::class
        );
    }

    public function index()
    {
        $sort_order = [
            'created_at' => 'DESC',
            'text' => 'ASC',
        ];

        if (request('quiz')) {
            return $this->repository->findByQuiz(
                (int) request('quiz'),
                $sort_order
            );
        }

        return $this->repository->paginate($sort_order);
    }
}
