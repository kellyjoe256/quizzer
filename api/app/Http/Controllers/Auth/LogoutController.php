<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke()
    {
        auth()->logout(true);

        $cookie = cookie()->forget(config('custom.access_cookie_name'));

        return response()->json(null)->withCookie($cookie);
    }
}
