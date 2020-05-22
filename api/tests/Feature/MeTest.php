<?php

namespace Tests\Feature;

use Tests\TestCase;

class MeTest extends TestCase
{
    use CreateUser;

    private $me_route = '/api/auth/me';

    /** @test */
    public function me_success_with_valid_credentials()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $this->get($this->me_route, $headers)
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
    public function me_failure_with_expired_credentials()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        auth()->logout(true);

        $this->get($this->me_route, $headers)
            ->assertStatus(401);
    }

    /** @test */
    public function me_failure_with_invalid_credentials()
    {
        $token = null;
        $headers = ['Authorization' => "Bearer $token"];

        $this->get($this->me_route, $headers)
            ->assertStatus(401);
    }

    /** @test */
    public function me_failure_with_no_credentials()
    {
        $this->get($this->me_route)->assertStatus(401);
    }
}
