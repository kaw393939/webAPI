<?php

namespace App\Listeners;

use App\Events\RegistrationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Profile;

/**
 * Class RegistrationListener
 * @package App\Listeners
 */
class RegistrationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationEvent  $event
     * @return void
     */
    public function handle(RegistrationEvent $event)
    {
        Log::notice('New User Registered: ', ['name'=>$event->profile->first_name . " " . $event->profile->last_name, 'email'=>$event->user->email]);
    }
}
