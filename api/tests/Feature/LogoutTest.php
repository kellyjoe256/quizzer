<?php

namespace Tests\Feature;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    use CreateUser;

    private $logout_route = '/api/auth/logout';

    /** @test */
    public function logout_works_with_valid_credentials()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', $this->logout_route, [], $headers)
            ->assertStatus(200);
    }

    /** @test */
    public function logout_fails_for_expired_credentials()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        auth()->logout(true);

        $this->json('POST', $this->logout_route, [], $headers)
            ->assertStatus(401);
    }

    public function logout_fails_for_invalid_credentials()
    {
        $token = null;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', $this->logout_route, [], $headers)
            ->assertStatus(401);
    }

    /** @test */
    public function logout_fails_with_no_credentials()
    {
        $this->json('POST', $this->logout_route)->assertStatus(401);
    }
}
