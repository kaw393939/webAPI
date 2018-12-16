<?php

namespace Tests\Feature;

use App\Profile;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProfileTest extends TestCase
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

    public function testsShowProfilesSuccessfullyTest()
    {
        $profile = factory(Profile::class)->create();
        $response = $this ->json('GET',"/api/profiles/");
        $response->assertStatus(200);
//            ->assertJson([
//                'data' =>[[
//                    'type'=>'profiles',
//                ]]
//            ]);
    }

    public function testShowProfileSuccessfullyTest()
    {
        $user = factory(\App\User::class)->make();
        $user->save();
        $profile = factory(Profile::class)->create();
        $profile->user()->associate($user);
        $response = $this ->json('GET',"/api/profiles/{$profile->id}");
        $response->assertStatus(200);
//            ->assertJson([
//                'id'    => (string)$profile->id,
//                'user_id' => $profile -> user_id,
//                'first_name' => $profile -> first_name,
//                'last_name' => $profile -> last_name,
//                'bio' => $profile -> bio,
//                'created_at' => $profile -> created_at,
//            ]);
    }
}
