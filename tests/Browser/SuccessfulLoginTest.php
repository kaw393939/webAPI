<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuccessfulLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->type('email', 'kjp44@njit.edu')
                    ->type('password', 'secret')
                    ->press('LOGIN')
                    ->assertPathIs('/');
        });
    }
}
