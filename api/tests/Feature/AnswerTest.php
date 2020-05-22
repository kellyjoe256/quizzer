<?php

namespace Tests\Feature;

use App\Answer;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use CreateUser, CreateQuestion;

    private $answer_route = '/api/answers';

    /** @test */
    public function required_fields_for_answer_creation()
    {
        $data = $this->answer_data();

        collect($data)
            ->keys()
            ->each(function ($field) use ($data) {
                $response = $this->json(
                    'POST',
                    $this->answer_route,
                    array_merge($data, [$field => ''])
                );

                $response->assertStatus(422);
            });
    }

    /** @test */
    public function answer_is_created_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->answer_data();

        $this->json('POST', $this->answer_route, $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function answer_creation_fails_if_value_question_id_already_exist()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->answer_data();
        $this->create_answer();

        $this->json('POST', $this->answer_route, $data, $headers)
            ->assertStatus(409);
    }

    public function getting_an_existing_answer_works()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->answer_data();
        $answer = $this->create_answer();

        $uri = sprintf('%s/%d', $this->answer_route, $answer->id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function getting_a_non_existence_answer_fails()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $fake_id = 500;
        $uri = sprintf('%s/%d', $this->answer_route, $fake_id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(404);
    }

    /** @test */
    public function answer_is_updated_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->answer_data;
        $answer = $this->create_answer();

        $data['value'] = 'False'; // change value
        $uri = sprintf('%s/%d', $this->answer_route, $answer->id);

        $this->json('PUT', $uri, $data, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function answer_is_deleted_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $answer = $this->create_answer();

        $uri = sprintf('%s/%d', $this->answer_route, $answer->id);

        $this->json('DELETE', $uri, [], $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function answers_are_listed_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->answer_data();
        $this->create_answer();

        $this->json('GET', $this->answer_route, [], $headers)
            ->assertStatus(206)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    private function answer_data()
    {
        return [
            'value' => 'True',
            'is_true' => false,
            'question_id' => null,
        ];
    }

    private function create_answer()
    {
        $question = $this->create_question();

        return factory(Answer::class)->create(
            array_merge(
                $this->answer_data(),
                ['question_id' => $question->id]
            )
        );
    }
}
