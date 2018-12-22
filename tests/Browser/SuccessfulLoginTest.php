<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class SuccessfulLoginTest extends DuskTestCase
{

    public function testSuccessfulLogin()
    {
        $this->artisan('migrate:refresh');
        $this->browse(function (Browser $browser) {
            $user = new User;
            $user->email = 'johndoe@email.com';
            $user->email_verified_at = now();
            $user->password = bcrypt('your_password');
            $user->remember_token = str_random(10);
            $user->save();
            $profile = new Profile;
            $profile->first_name = 'John';
            $profile->last_name = 'Doe';
            $profile->bio = 'Lorem Ipsum';
            $profile->user_id = 1;
            $profile->save();
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->type('email', $user->email)
                    ->type('password', 'your_password')
                    ->press('LOGIN');
            $browser->pause(1000)
                    ->assertPathIs('/');
        });
    }
}
