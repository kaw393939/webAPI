<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        //$this->artisan('migrate', ['param' => '--seed']);
        //$this->artisan('migrate:refresh');
        //$this->artisan('key:generate');

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
