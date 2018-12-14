<?php

namespace Tests\Feature;

use App\Profile;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
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

    public function testUpdateProfileSuccessfullyTest()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $profile = factory(Profile::class)->create();
        $profile->user()->associate($user);
        $profile->save();

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

        $payload = ['email' => 'test@example.com', 'first_name' => 'Bob', 'last_name' => 'Johnson', 'bio' => 'Hello World!'];
        $this->withHeaders($headers)
            ->json('PUT',"/api/profiles/{$profile->id}", $payload)
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
