<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Question;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowQuestionTest extends TestCase
{
    /**
     * A test example for when viewing a particular users info.
     *
     * @return void
     */

    use refreshDatabase;
    public function setUp()
    {
        parent::setUp();
    }
    public function testsShowQuestionsSuccessfullyTest()
    {
        $user = factory(\App\User::class)->make();
        $user->save();
        $profile = factory(\App\Profile::class)->create();
        $profile->user()->associate($user);
        $profile->save();
        $question = factory(Question::class)->create();
        $question->user()->associate($user);
        $question->save();

        $response = $this ->json('GET',"/api/questions/");
        $response->assertStatus(200);
 //           ->assertJson([
 //               'data' =>[[
 //                   'type'=>'questions',
 //               ]]
 //           ]);
    }
    public function testShowQuestionSuccessfullyTest()
    {
        $user = factory(\App\User::class)->make();
        $user->save();
        $profile = factory(\App\Profile::class)->create();
        $profile->user()->associate($user);
        $profile->save();
        $question = factory(Question::class)->create();
        $question->user()->associate($user);
        $question->save();
        $response = $this ->json('GET',"/api/questions/{$question->id}");
        $response->assertStatus(200);
//            ->assertJson([
//                'id' => (string) $question->id,
//                'text' => $question->question,
//                'relationships' => '',
//                'links' => [
//                ]
//            ]);
    }

    public function testCreateQuestion() {

        $user = factory(\App\User::class)->make();
        $user->save();
        $question = factory(Question::class)->make();
        $question->user()->associate($user);
        $this->assertTrue($question->save());
    }
}
