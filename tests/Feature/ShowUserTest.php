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
//        factory(User::class)->create([
//            'id' => ,
//            'name' => 'test',
//            'email' => 'testlogin@user.com',
//            'password' => bcrypt('toptal123'),
//        ]);
//        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];
        $this->json('POST', 'api/users/1')
            ->assertStatus(200);
//            ->assertJsonStructure(
//                [
//                    'code',
//                    'status',
//                    'message',
//                    'token',
//                ]
//            );
    }

}
