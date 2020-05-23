<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\AddQuestionRequest;
use App\Http\Requests\Question\EditQuestionRequest;
use App\Http\Resources\Question\QuestionResource;
use App\Repositories\QuestionRepository;

class QuestionController extends Controller
{
    /**
     * @var QuestionRepository
     */
    private $questions;

    public function __construct(QuestionRepository $questions)
    {
        $this->questions = $questions;
    }

    public function index()
    {
        $sort_order = [
            'created_at' => 'DESC',
            'text' => 'ASC',
        ];

        if (request('quiz')) {
            return $this->questions->findByQuiz(
                (int) request('quiz'),
                $sort_order
            );
        }

        return $this->questions->paginate($sort_order);
    }

    public function store(AddQuestionRequest $request)
    {
        $question = $this->questions->create($request->all());

        return (new QuestionResource($question))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $question = $this->questions->find($id);

        return new QuestionResource($question);
    }

    public function update($id, EditQuestionRequest $request)
    {
        $question = $this->questions->update($id, $request->all());

        return new QuestionResource($question);
    }

    public function delete($id)
    {
        $this->questions->delete($id);

        return response()->json(null, 204);
    }
}
