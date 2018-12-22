<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuccessfulProfileUpdateTest extends DuskTestCase
{
    public function testSuccessfulProfileUpdate()
    {
        $this->artisan('migrate:refresh');

        $this->browse(function (Browser $browser) {
            factory(User::class, 1)->create();
            $user = User::find(1);
            $profile = factory(Profile::class)->make();
            $user->profile()->save($profile);
            $browser->visit('/')
                ->clickLink('Login')
                ->assertPathIs('/login')
                ->type('email', $user->email)
                ->type('password', 'secretsecret')
                ->press('LOGIN');
            $browser->pause(1000)
                ->assertPathIs('/')
                ->clickLink('Profile');
            $browser->pause(1000)
                ->assertPathIs('/profile/1')
                ->clickLink('EDIT PROFILE');
            $browser->pause(1000)
                ->assertPathIs('/profile/1/edit')
                ->clear('firstName')
                ->type('firstName', 'John')
                ->clear('lastName')
                ->type('lastName', 'Doe')
                ->clear('email')
                ->type('email', 'johndoe@email.com')
                ->clear('bio')
                ->type('bio', 'Lorem Ipsum')
                ->press('SAVE');
            $browser->pause(1000)
                ->assertPathIs('/profile/1')
                ->assertSee('JOHN DOE')
                ->assertSee('johndoe@email.com')
                ->assertSee('Lorem Ipsum');
        });
    }
}
