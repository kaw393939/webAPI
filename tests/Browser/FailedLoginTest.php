<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FailedLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testFailedLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->type('email', '')
                    ->type('password', '')
                    ->assertSee('Email is required.')
                    ->type('email', 'a')
                    ->assertSee('Password is required.')
                    ->assertSee('Must be a valid email.')
                    ->type('password', 'a')
                    ->assertSee('Password must be at least 8 characters long.')
                    ->type('email', '@a.com')
                    ->type('password', 'aaaaaaa')
                    ->press('LOGIN')
                    ->assertSee('Something went wrong. Please try again.');
        });
    }
}
