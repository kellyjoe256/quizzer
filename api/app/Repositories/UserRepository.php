<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected function entity()
    {
        return User::class;
    }

    protected function setColumns()
    {
        $this->columns = [
            'id', 'name', 'email', 'is_admin', 'created_at',
        ];
    }
}
