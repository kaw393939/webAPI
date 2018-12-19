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
    public function testExample()
    {
        $this->artisan('migrate:refresh');
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Register')
                    ->type('firstName', 'Kyle')
                    ->type('lastName', 'Payne')
                    ->type('email', 'kjp44@njit.edu')
                    ->type('password', 'secretsecret')
                    ->type('passwordConf', 'secretsecret')
                    ->type('bio', 'Lorem ipseum.')
                    ->press('REGISTER');
            $browser->pause(1)
                    ->assertPathIs('/login');
        });
    }
}
