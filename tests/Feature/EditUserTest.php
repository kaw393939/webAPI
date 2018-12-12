<?php

namespace Tests\Feature;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

    }

    public function testEditUserTest()
    {
        $user = factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
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

        $profile = factory(Profile::class)->create([
            'first_name' => 'First',
            'last_name' => 'Last',
            'bio' => 'Hello!!!'
        ]);
        $profile->user_id = $user->id;
        $profile->save();

        $payload = ['id' => $profile->id, 'user_id' => $profile->user_id, 'email' => 'userlogin@user.com', 'first_name' => 'Test', 'last_name' => 'Johnson', 'bio' => 'Goodbye!!!'];
        $this->withHeaders($headers)
            ->json('post', '/api/edit', $payload)
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
