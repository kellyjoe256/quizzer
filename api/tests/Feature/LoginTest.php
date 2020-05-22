<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    use CreateUser;

    private $login_route = '/api/auth/login';

    /** @test */
    public function fields_required_for_login()
    {
        $data = $this->user_data();

        collect($data)
            ->except(['name', 'is_admin'])
            ->keys()
            ->each(function ($field) use ($data) {
                $response = $this->json(
                    'POST',
                    $this->login_route,
                    array_merge($data, [$field => ''])
                );

                $response->assertStatus(422);
            });
    }

    /** @test */
    public function successful_login()
    {
        $credentials = $this->create_user();

        $this->json('POST', $this->login_route, $credentials)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'is_admin',
                'created_at',
            ]);
    }

    /** @test */
    public function token_after_successful_login_is_sent_through_cookie()
    {
        $credentials = $this->create_user();
        $cookie_name = config('custom.access_cookie_name', '');

        $this->json('POST', $this->login_route, $credentials)
            ->assertCookie($cookie_name);
    }

    /** @test */
    public function login_fails_for_invalid_credentials()
    {
        $data = [
            'email' => 'foo-bar@example.com',
            'password' => 'bar-foo',
        ];

        $this->json('POST', $this->login_route, $data)
            ->assertStatus(401);
    }
}
