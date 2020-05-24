<?php

namespace Tests\Feature;

use Tests\TestCase;

class QuizTest extends TestCase
{
    use CreateQuiz;

    private $quiz_route = '/api/quizzes';

    /** @test */
    public function required_fields_for_quiz_creation()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->quiz_data();

        collect($data)
            ->except('user_id')
            ->keys()
            ->each(function ($field) use ($data, $headers) {
                $response = $this->json(
                    'POST',
                    $this->quiz_route,
                    array_merge($data, [$field => '']),
                    $headers
                );

                $response->assertStatus(422);
            });
    }

    /** @test */
    public function quiz_is_created_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->quiz_data();

        $this->json('POST', $this->quiz_route, $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function quiz_creation_fails_if_name_already_exists()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->quiz_data();
        $this->create_quiz();

        $this->json('POST', $this->quiz_route, $data, $headers)
            ->assertStatus(422);
    }

    /** @test */
    public function getting_an_existing_quiz_works()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->quiz_data();
        $quiz = $this->create_quiz();

        $uri = sprintf('%s/%d', $this->quiz_route, $quiz->id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function getting_a_non_existence_quiz_fails()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $fake_id = 500;
        $uri = sprintf('%s/%d', $this->quiz_route, $fake_id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(404);
    }

    /** @test */
    public function quiz_is_updated_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->quiz_data();
        $quiz = $this->create_quiz();

        $data['name'] = 'new name'; // update name
        $uri = sprintf('%s/%d', $this->quiz_route, $quiz->id);

        $this->json('PUT', $uri, $data, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function quiz_is_deleted_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $quiz = $this->create_quiz();
        $uri = sprintf('%s/%d', $this->quiz_route, $quiz->id);

        $this->json('DELETE', $uri, [], $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function quizzes_are_listed_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->quiz_route, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
            ]);
    }
}
