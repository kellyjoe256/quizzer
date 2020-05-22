<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class MeController extends Controller
{
    public function __invoke()
    {
        return response()->json(request()->user());
    }
}
