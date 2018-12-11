<?php

namespace Tests\Feature;

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

        $token = $response->json("token");

        $payload = ['id' => $user->id, 'token' => $token];
        $this->withHeaders($payload)
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
