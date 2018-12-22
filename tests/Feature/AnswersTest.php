<?php

namespace Tests\Feature;

use App\Answer;
use App\Events\NewAnswerEvent;
use App\Profile;
use App\Question;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswersTest extends TestCase
{
    /**
     * A test example for when viewing a particular users info.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

    }

    public function testUpdateAnswerSuccessfullyTest()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $question = factory(Question::class)->create();
        $question->user()->associate($user);
        $question->save();
        $answer = factory(Answer::class)->make();
        $answer->user()->associate($user);
        $answer->question()->associate($question);
        $answer->save();

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $response = $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                    'token',
                ]
            );

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json("token"),
        ];

        $payload = ['answer' => 'Answer has been updated'];
        $this->withHeaders($headers)
            ->json('PUT',"/api/questions/{$question->id}/answers/{$answer->id}", $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                ]
            );
    }

    public function testDeleteAnswer()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $question = factory(Question::class)->create();
        $question->user()->associate($user);
        $question->save();
        $answer = factory(Answer::class)->make();
        $answer->user()->associate($user);
        $answer->question()->associate($question);
        $answer->save();

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $response = $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                    'token',
                ]
            );

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json("token"),
        ];

        $this->withHeaders($headers)
            ->json('DELETE',"/api/questions/{$question->id}/answers/{$answer->id}")
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                ]
            );
    }

    public function testCreateAnswer()
    {
        $this->expectsEvents(NewAnswerEvent::class);

        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $question = factory(Question::class)->create();
        $question->user()->associate($user);
        $question->save();
        $answer = factory(Answer::class)->make();
        $answer->user()->associate($user);
        $answer->question()->associate($question);
        $answer->save();

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $response = $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                    'token',
                ]
            );

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json("token"),
        ];

        $payload = ['answer' => 'This is a new Answer'];
        $this->withHeaders($headers)
            ->json('POST',"/api/questions/{$question->id}/answers/", $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                ]
            );
    }
}
