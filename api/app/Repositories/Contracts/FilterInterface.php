<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface FilterInterface extends RepositoryInterface
{
    public function filter(Request $request);
}
