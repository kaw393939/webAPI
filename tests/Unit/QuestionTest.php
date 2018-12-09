<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    public function testCreateAndReceiveQuestion()
    {
        $user = $user = factory(\App\User::class)->make();
        $user->save();

        $question = factory(\App\Question::class)->make();
        $question->user()->associate($user);
        $this->assertTrue($question->save());

        $answer = factory(\App\Answer::class)->make();
        $answer->user()->associate($user);
        $answer->question($question);
        $answer->save();
        $this->assertTrue($answer->question);

    }
}
