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
        $user = $request->user();
        $this->removeUserQueryParams($request);
        if ($user && !$user->is_admin) {
            // find a quiz or quizzes that belong to current user
            $request->query->set('user', $user->id);
        }
        $this->builder = $this->builder->filter($request);

        return $this;
    }

    protected function entity(): string
    {
        return Quiz::class;
    }

    /**
     * Remove user query filter parameters if available in query string
     *
     * @return void
     */
    protected function removeUserQueryParams(Request $request)
    {
        $keys = ['user', 'user_id'];
        foreach ($keys as $key) {
            if (!$request->query->has($key)) {
                continue;
            }

            $request->query->remove($key);
        }
    }
}
