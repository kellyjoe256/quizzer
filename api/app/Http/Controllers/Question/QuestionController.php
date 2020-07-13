<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Question\AddQuestionRequest;
use App\Http\Requests\Question\EditQuestionRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Repositories\Question\QuestionRepository;

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
            'created_at' => 'desc',
            'text' => 'asc',
        ];
        $limit = (int) request('limit', $this->limit);
        $questions = $this->repository
            ->filter(request())
            ->sort($sort_order)
            ->paginate($limit);

        return $this->collection($questions);
    }
}
