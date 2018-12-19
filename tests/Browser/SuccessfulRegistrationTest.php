<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuccessfulRegistrationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $this->artisan('migrate:refresh');
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Register')
                    ->type('firstName', 'John')
                    ->type('lastName', 'Doe')
                    ->type('email', 'johndoe@email.com')
                    ->type('password', 'your_password')
                    ->type('passwordConf', 'your_password')
                    ->type('bio', 'Lorem ipseum.')
                    ->press('REGISTER');
            $browser->pause(1000)
                    ->assertPathIs('/login');
        });
    }
}
