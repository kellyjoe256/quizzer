<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $sort_order = [
            'name' => 'ASC',
            'created_at' => 'DESC',
        ];

        return $this->users->paginate($sort_order);
    }

    public function store(AddUserRequest $request)
    {
        $user = $this->users->create($request->all());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $user = $this->users->find($id);

        return new UserResource($user);
    }

    public function update($id, EditUserRequest $request)
    {
        $user = $this->users->update($id, $request->all());

        return new UserResource($user);
    }

    public function delete($id)
    {
        $this->users->delete($id);

        return response()->json(null, 204);
    }
}
