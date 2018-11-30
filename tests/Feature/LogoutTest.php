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

        $headers = [
//            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $response->json('token'),
        ];
        print_r($headers);
//        $this->withHeaders($headers)
        $this
            ->json('get','/api/logout',[$headers])
//            ->json('get', '/api/logout')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'message',
                ]
            );
        print_r($this);
    }
}
