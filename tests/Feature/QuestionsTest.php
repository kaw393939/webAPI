<?php

namespace Tests\Feature;

use App\Events\NewQuestionEvent;
use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    public function testDeleteQuestion()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $user->save();
        $question = factory(\App\Question::class)->create();
        $question->user()->associate($user);
        $question->save();

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $response = $this->json('POST', 'api/login', $payload);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json("token"),
        ];

        $response = $this->withHeaders($headers)
            ->json('DELETE',"/api/questions/{$question->id}");

        $response->assertStatus(200)
        ->assertJson([
            'id' => $question->id,
            'code' => '200',
            'status' => true,
            'message' => 'Delete Success',
        ]);

    }

    public function testCreateQuestion()
        {
            $this->expectsEvents(NewQuestionEvent::class);

            $user = factory(\App\User::class)->create([
                'email' => 'testlogin@user.com',
                'password' => bcrypt('toptal123'),
            ]);
            $user->save();

            $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
            $response = $this->json('POST', 'api/login', $payload);

            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $response->json("token"),
            ];

            $payload = [
                'question' => 'Test Question?'
            ];

            $response = $this->withHeaders($headers)
                ->json('POST',"/api/questions/", $payload);
            $response->assertStatus(200)
                ->assertJson([
                    'id' => DB::table('questions')->orderBy('id', 'desc')->first()->id,
                    'code' => '200',
                    'status' => true,
                    'message' => 'Create Success',
                ]);
    }

    public function testUpdateQuestion()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $user->save();
        $question = factory(\App\Question::class)->create();
        $question->user()->associate($user);
        $question->question = "This is a test";
        $question->save();

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $response = $this->json('POST', 'api/login', $payload);


        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json("token"),
        ];

        $payload = ['question' => 'This is a test"'];

        $response = $this ->withHeaders($headers)
        ->json('PUT',"/api/questions/{$question->id}", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $question->id,
                'code' => '200',
                'status' => true,
                'message' => 'Update Success',
            ]);
    }
}
