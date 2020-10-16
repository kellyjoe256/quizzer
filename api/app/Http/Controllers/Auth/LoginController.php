<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->all(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(
                ['error' => 'Email or Password incorrect'],
                401
            );
        }
        $cookie = $this->makeCookie($token);

        return response()->json(auth()->user())->withCookie($cookie);
    }

    /**
     * Set cookie details and return cookie
     *
     * @param string $token JWT
     *
     * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
     */
    private function makeCookie($token)
    {
        return cookie(
            config('custom.access_cookie_name', '_token'),
            $token,
            config('custom.access_cookie_duration', 60),
            null,
            null,
            isset($_SERVER['HTTPS']),
            true,
            false,
            'Strict'
        );
    }
}
