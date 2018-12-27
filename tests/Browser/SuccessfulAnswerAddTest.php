<?php

namespace Tests\Browser;
namespace App;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SuccessfulAnswerAddTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSuccessfulAnswerAdd()
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
            $question = new Question;
            $question->user_id = 2;
            $question->question = 'This is a sample question';
            $question->save();
            $browser->visit('/')
                ->clickLink('Login')
                ->assertPathIs('/login')
                ->type('email', $user->email)
                ->type('password', 'secretsecret')
                ->press('LOGIN');
            $browser->pause(1000)
                ->assertPathIs('/')
                ->click('@question')
                ->assertPathIs('/question/1')
                ->click('@addAnswer')
                ->assertPathIs('/question/1/answer')
                ->type('answer', 'This is a sample answer.')
                ->press('SUBMIT')
                ->assertPathIs('/question/1')
                ->assertSee('This is a sample answer.');
        });
    }
}
