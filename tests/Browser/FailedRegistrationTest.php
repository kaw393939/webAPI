<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FailedRegistrationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testFailedRegistration()
    {
        $this->artisan('migrate:refresh');
        $this->browse(function (Browser $browser) {
            $user = new User;
            $user->email = 'johndoe@email.com';
            $user->password = 'your_password';
            $user->save();
            $browser->visit('/')
                    ->clickLink('Register')
                    ->type('firstName', '')
                    ->type('lastName', '')
                    ->type('email', '')
                    ->type('password', '')
                    ->type('passwordConf', '')
                    ->type('bio', '')
                    ->assertSee('First name is required.')
                    ->assertSee('Last name is required.')
                    ->assertSee('Email is required.')
                    ->assertSee('Password is required.')
                    ->assertSee('Password confirmation is required.')
                    ->type('email', 'j')
                    ->assertSee('Bio is required.')
                    ->assertSee('Must be a valid email.')
                    ->type('password', 'y')
                    ->assertSee('Password must be between 8 and 60 characters long.')
                    ->type('passwordConf', 'yo')
                    ->assertSee('Passwords must match.')
                    ->type('firstName', 'John')
                    ->type('lastName', 'Doe')
                    ->type('email', 'ohndoe@email.com')
                    ->type('password', 'our_password')
                    ->type('passwordConf', 'ur_password')
                    ->type('bio', 'Lorem ipsum.')
                    ->press('REGISTER')
                    ->assertSee('The email has already been taken.');
        });
    }
}
