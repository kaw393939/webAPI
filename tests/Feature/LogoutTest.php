<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('key:generate');
        $this->artisan('migrate');

    }

    public function testUserLogout()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload);

        $payload = ['email' => 'john@toptal.com', 'password' => 'toptal123'];
        $response = $this->json('post', '/api/login', $payload)
        ->assertStatus(200);

        $this->json('get', '/api/logout?token=' . $response->json("token"))
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'message',
                ]
            );
    }
}
