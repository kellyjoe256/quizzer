<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\Quiz\AddQuizRequest;
use App\Http\Requests\Quiz\EditQuizRequest;
use App\Http\Resources\Quiz\QuizResource;
use App\Repositories\QuizRepository;

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
        $user = request()->user();
        $sort_order = ['name' => 'ASC'];

        if (!$user->is_admin) {
            return $this->repository->findByUser($user->id, $sort_order);
        }

        return $this->repository->paginate($sort_order);
    }
}
