<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FailedProfileUpdateTest extends DuskTestCase
{
    public function testFailedProfileUpdate()
    {
        $this->artisan('migrate:refresh');

        $this->browse(function (Browser $browser) {
            factory(User::class, 2)->create();
            $users = User::All();
            $users->each(function ($user) {
                $profile = factory(Profile::class)->make();
                $user->profile()->save($profile);
            });
            $user = User::find(1);
            $user2 = User::find(2);
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
                ->type('firstName', ' ')
                ->clear('lastName')
                ->type('lastName', ' ')
                ->clear('email')
                ->type('email', ' ')
                ->clear('bio')
                ->type('bio', ' ')
                ->assertSee('First name is required.')
                ->assertSee('Last name is required.')
                ->assertSee('Email is required.')
                ->assertSee('Bio is required.')
                ->type('email', 'j')
                ->assertSee('Must be a valid email.')
                ->clear('email')
                ->type('email', $user2->email)
                ->type('firstName', 'John')
                ->type('lastName', 'Doe')
                ->type('bio', 'Lorem Ipsum')
                ->press('SAVE')
                ->assertSee('Something went wrong. Please try again.');
        });
    }
}
