<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\RegistrationEvent;


class RegisterTest extends TestCase
{

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        //$this->artisan('migrate', ['param' => '--seed']);
        $this->artisan('key:generate');
        $this->artisan('migrate');




    }

    public function testRegistersSuccessfullyTest()
    {
        $this->expectsEvents(RegistrationEvent::class);

        $payload = [
            'name' => 'frank',
            'email' => 'frank@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'code',
                'status',
                'message',
                'token',
            ]
            );
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }
/*
    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                    'password' => ['The password confirmation does not match.'],
                ]
            ]);
    }
*/
}
