<?php

namespace App\Repositories\User;

use App\Repositories\AbstractRepository;
use App\User;

class UserRepository extends AbstractRepository
{
    protected function entity(): string
    {
        return User::class;
    }
}
