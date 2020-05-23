<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\AddQuizRequest;
use App\Http\Requests\Quiz\EditQuizRequest;
use App\Http\Resources\Quiz\QuizResource;
use App\Repositories\QuizRepository;

class QuizController extends Controller
{
    /**
     * @var QuizRepository
     */
    private $quizzes;

    public function __construct(QuizRepository $quizzes)
    {
        $this->quizzes = $quizzes;
    }

    public function index()
    {
        $sort_order = ['name' => 'ASC'];

        if (request('user')) {
            return $this->quizzes->findByUser(
                (int) request('user'),
                $sort_order
            );
        }

        return $this->quizzes->paginate($sort_order);
    }

    public function store(AddQuizRequest $request)
    {
        $quiz = $this->quizzes->create($request->all());

        return (new QuizResource($quiz))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $quiz = $this->quizzes->find($id);

        return new QuizResource($quiz);
    }

    public function update($id, EditQuizRequest $request)
    {
        $quiz = $this->quizzes->update($id, $request->all());

        return new QuizResource($quiz);
    }

    public function delete($id)
    {
        $this->quizzes->delete($id);

        return response()->json(null, 204);
    }
}
