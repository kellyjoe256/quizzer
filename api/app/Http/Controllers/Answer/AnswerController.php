<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\AddAnswerRequest;
use App\Http\Requests\Answer\EditAnswerRequest;
use App\Http\Resources\Answer\AnswerResource;
use App\Repositories\AnswerRepository;

class AnswerController extends Controller
{
    /**
     * @var AnswerRepository
     */
    private $answers;

    public function __construct(AnswerRepository $answers)
    {
        $this->answers = $answers;
    }

    public function index()
    {
        $sort_order = [
            'value' => 'ASC',
            'created_at' => 'DESC',
        ];

        if (request('question')) {
            return $this->answers->findByQuestion(
                (int) request('question'),
                $sort_order
            );
        }

        return $this->answers->paginate($sort_order);
    }

    public function store(AddAnswerRequest $request)
    {
        $answer = $this->answers->create($request->all());

        return (new AnswerResource($answer))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $answer = $this->answers->find($id);

        return new AnswerResource($answer);
    }

    public function update($id, EditAnswerRequest $request)
    {
        $answer = $this->answers->update($id, $request->all());

        return new AnswerResource($answer);
    }

    public function delete($id)
    {
        $this->answers->delete($id);

        return response()->json(null, 204);
    }
}
