<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ExampleTest extends TestCase
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
        $this->artisan('migrate');
        factory(User::class)->create();
    }

    public function testUserModelNotFoundExceptionTest()
    {
        $this->expectException('\Illuminate\Database\Eloquent\ModelNotFoundException');
        $user = User::findorfail(2);

        $this->assertTrue($user->save());
    }
}
