<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Quiz\AddQuizRequest;
use App\Http\Requests\Quiz\EditQuizRequest;
use App\Http\Resources\Quiz\QuizResource;
use App\Repositories\Quiz\QuizRepository;

class QuizController extends Controller
{
    public function __construct(QuizRepository $quizzes)
    {
        parent::__construct(
            $quizzes,
            QuizResource::class,
            AddQuizRequest::class,
            EditQuizRequest::class
        );
    }

    public function index()
    {
        $relations = [];
        $user = request()->user();
        if ($user && $user->is_admin) {
            $relations = ['user'];
        }

        $sort_order = [
            'created_at' => 'desc',
            'name' => 'asc',
        ];
        $limit = (int) request('limit', $this->limit);
        $quizzes = $this->repository
            ->with($relations)
            ->filter(request())
            ->sort($sort_order)
            ->paginate($limit);

        return $this->collection($quizzes);
    }

    public function show($id)
    {
        $quiz = $this->repository->filter(request())->find($id);

        return new $this->resource($quiz);
    }
}
