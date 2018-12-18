<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /* 'path'= 'App\Events\ what ever the name of the event to listen to is going to be' => [
            'listener' = 'App\Listeners\what ever the name of the listener is going to be
        ],

            'path'=>[
            'listener'
        ],

        */

        //User Registration Event/Listener Pair

        'App\Events\RegistrationEvent'=>[
            'App\Listeners\RegistrationListener'
        ],

        //User Log In Event/Listener Pair

        'App\Events\LogInEvent'=>[
            'App\Listeners\LogInListener'
        ],

        //User Log Out Event/Listener Pair

        'App\Events\LogOutEvent'=>[
            'App\Listeners\LogOutListener'
        ],

        //New Question Made Event/Listener Pair

        'App\Events\NewQuestionEvent'=>[
            'App\Listeners\NewQuestionListener'
        ],

        //New Answer Made Event/Listener Pair

        'App\Events\NewAnswerEvent'=>[
            'App\Listeners\NewAnswerListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
