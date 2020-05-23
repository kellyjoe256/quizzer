<?php

namespace Tests\Feature;

use Tests\TestCase;

class QuestionTest extends TestCase
{
    use CreateQuestion;

    private $question_route = '/api/questions';

    /** @test */
    public function required_fields_for_question_creation()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->question_data();

        collect($data)
            ->keys()
            ->each(function ($field) use ($data, $headers) {
                $response = $this->json(
                    'POST',
                    $this->question_route,
                    array_merge($data, [$field => '']),
                    $headers
                );

                $response->assertStatus(422);
            });
    }

    /** @test */
    public function question_is_created_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $quiz = $this->create_quiz();
        $data = $this->question_data();
        $data['quiz_id'] = $quiz->id;

        $this->json('POST', $this->question_route, $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function question_creation_fails_if_text_quiz_id_already_exist()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $quiz = $this->create_quiz();
        $data = $this->question_data();
        $data['quiz_id'] = $quiz->id;

        $this->json('POST', $this->question_route, $data, $headers)
            ->assertStatus(201);

        $this->json('POST', $this->question_route, $data, $headers)
            ->assertStatus(422);
    }

    /** @test */
    public function getting_an_existing_question_works()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->question_data();
        $question = $this->create_question();

        $uri = sprintf('%s/%d', $this->question_route, $question->id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function getting_a_non_existence_question_fails()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $fake_id = 500;
        $uri = sprintf('%s/%d', $this->question_route, $fake_id);

        $this->json('GET', $uri, [], $headers)
            ->assertStatus(404);
    }

    /** @test */
    public function question_is_updated_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->question_data();
        $question = $this->create_question();

        $data['text'] = 'What is this?'; // change question
        $data['quiz_id'] = $question->id;
        $uri = sprintf('%s/%d', $this->question_route, $question->id);

        $this->json('PUT', $uri, $data, $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(['id'], array_keys($data)),
            ]);
    }

    /** @test */
    public function question_is_deleted_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $question = $this->create_question();

        $uri = sprintf('%s/%d', $this->question_route, $question->id);

        $this->json('DELETE', $uri, [], $headers)
            ->assertStatus(204);
    }

    /** @test */
    public function questions_are_listed_correctly()
    {
        $token = $this->login();
        $headers = ['Authorization' => "Bearer $token"];

        $data = $this->question_data();
        $this->create_question();

        $this->json('GET', $this->question_route, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [array_merge(['id'], array_keys($data))],
            ]);
    }
}
