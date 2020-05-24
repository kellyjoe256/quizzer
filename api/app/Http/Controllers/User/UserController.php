<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController as Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;

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
            'name' => 'ASC',
            'created_at' => 'DESC',
        ];

        return $this->repository->paginate($sort_order);
    }
}
