<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    use CreateUser;

    private $user_route = '/api/users';

    public function required_fields_for_user_creation()
    {
        $data = $this->user_data();

        collect($data)
            ->except('is_admin')
            ->keys()
            ->each(function ($field) use ($data) {
                $response = $this->json(
                    'POST',
                    $this->user_route,
                    array_merge($data, [$field => ''])
                );

                $response->assertStatus(422);
            });
    }

    /** @test */
    public function user_is_created_correctly()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->user_data();
        $data['email'] = 'janedoe@example.com';

        $this->json('POST', $this->user_route, $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function user_creation_fails_if_email_already_exists()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->user_data();
        $data['email'] = 'janedoe@example.com';

        $this->json('POST', $this->user_route, $data, $headers)
            ->assertStatus(201);

        $this->json('POST', $this->user_route, $data, $headers)
            ->assertStatus(409);
    }

    /** @test */
    public function getting_an_existing_user_works()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->user_data();
        $data['email'] = 'janedoe@example.com';

        $user = $this->create_user($data);
        $uri = sprintf('%s/%d', $this->user_route, $user->id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function getting_a_non_existence_user_fails()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $fake_id = 500;
        $uri = sprintf('%s/%d', $this->user_route, $fake_id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(404);
    }

    /** @test */
    public function user_is_updated_correctly()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->user_data();
        $data['email'] = 'janedoe@example.com';

        $user = $this->create_user($data);
        $uri = sprintf('%s/%d', $this->user_route, $user->id);

        $data['email'] = 'new-email@example.com'; // change email

        $this->json('PUT', $uri, $data, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function user_is_deleted_correctly()
    {
        $token = $this->login(true);
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->user_data();
        $data['email'] = 'janedoe@example.com';

        $user = $this->create_user($data);
        $uri = sprintf('%s/%d', $this->user_route, $user->id);

        $this->json('DELETE', $uri, [], $headers)
            ->assertStatus(204);
    }

    public function all_http_methods_fail_for_non_admin()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $id_route = sprintf("%s/%d", $this->user_route, 1);
        $methods = [
            'GET' => $this->user_route,
            'POST' => $this->user_route,
            'PUT' => $id_route,
            'DELETE' => $id_route,
        ];

        collect($methods)
            ->keys()
            ->each(function ($key) use ($methods, $headers) {
                $response = $this->json(
                    $key,
                    $methods[$key]
                    [],
                    $headers
                );

                $response->assertStatus(401);
            });
    }
}
