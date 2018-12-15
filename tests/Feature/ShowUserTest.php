<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends TestCase
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

  

    public function testsShowUsersSuccessfullyTest()
    {
        $user = factory(User::class)->create();

        $response = $this ->json('GET',"/api/users/");


        $response->assertStatus(200);
    }

    public function testshowUserSuccessfullyTest()
    {
        $user = factory(User::class)->create();

        $response = $this ->json('GET',"/api/users/{$user->id}");


        $response->assertStatus(200)
            ->assertJson([
                'id' => (string) $user->id,
                'attributes' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' =>(string)$user->email_verified_at
                ],
                'relationships' => '',
                'links' => [

                ]

            ]);
    }
}
