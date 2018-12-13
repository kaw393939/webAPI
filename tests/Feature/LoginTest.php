<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\LogInEvent;

use Tests\TestCase;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        //$this->artisan('migrate', ['param' => '--seed']);
        //$this->artisan('migrate:refresh');
        //$this->artisan('key:generate');

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRequiresEmailAndLoginTest()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function testUserLoginsSuccessfullyTest()
    {
        factory(User::class)->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);
        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                    'token',
                ]
            );
    }

    public function testUserLoginFailure()
    {
        $this->expectsEvents(LogInEvent::class);

        $payload = ['email' => 'wrongemail@wrongemail.com', 'password' => 'password'];
        $this->json('POST', 'api/login', $payload)
            ->assertStatus(401)
            ->assertJsonStructure(
                [
                    'code',
                    'status',
                    'message',
                ]
            );
    }
}
