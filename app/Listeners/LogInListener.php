<?php

namespace App\Listeners;

use App\Events\LogInEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Profile;

/**
 * Class LogInListener
 * @package App\Listeners
 */
class LogInListener
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
     * @param  LogInEvent  $event
     * @return void
     */
    public function handle(LogInEvent $event)
    {
        Log::notice('User Has Logged In: ', ['name'=>$event->profile->first_name . " " . $event->profile->last_name, 'email'=>$event->user->email]);
    }
}
