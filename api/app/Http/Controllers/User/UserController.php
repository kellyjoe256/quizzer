<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $users)
    {
        parent::__construct(
            $users,
            UserResource::class,
            AddUserRequest::class,
            EditUserRequest::class
        );
    }

    public function index()
    {
        $sort_order = [
            'created_at' => 'desc',
            'name' => 'asc',
        ];
        $limit = (int) request('limit', $this->limit);
        $users = $this->repository
            ->sort($sort_order)
            ->paginate($limit);

        return $this->collection($users);
    }
}
