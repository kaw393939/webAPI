<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class SuccessfulLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $this->artisan('migrate:refresh');
        $this->browse(function (Browser $browser) {
            $user = new User;
            $user->email = 'john_doe@email.com';
            $user->password = bcrypt('your_password');
            $user->save();
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->type('email', $user->email)
                    ->type('password', 'your_password')
                    ->press('LOGIN')
                    ->assertPathIs('/');
        });
    }
}
