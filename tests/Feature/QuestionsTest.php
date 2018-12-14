<?php

namespace Tests\Feature;

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
        $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(\App\Question::class)->create();
        $question->user()->associate($user);

        $response = $this ->json('DELETE',"/api/questions/{$question->id}");
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
            $user = factory(\App\User::class)->make();
            $user->save();
            $headers = [
                'user_id' => $user->id,
                'question' => 'Test Question?'
            ];
            $response = $this ->json('POST',"/api/questions/", $headers);
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
        $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(\App\Question::class)->create();
        $question->user()->associate($user);
        $question->question = "This is a test";
        $question->save();

        $headers = [
          'question'=> 'Test this is a',
        ];
        $response = $this ->json('PUT',"/api/questions/{$question->id}", $headers);
        $response->assertStatus(200)
            ->assertJson([
                'id' => $question->id,
                'code' => '200',
                'status' => true,
                'message' => 'Update Success',
            ]);
    }
}
