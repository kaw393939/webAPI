<?php

namespace App\Listeners;

use App\Events\LogOutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Class LogOutListener
 * @package App\Listeners
 */
class LogOutListener
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
     * @param  LogOutEvent  $event
     * @return void
     */
    public function handle(LogOutEvent $event)
    {
        Log::notice('A User Has Logged Off:', ['name'=>$event->profile->first_name . " " . $event->profile->last_name, 'email'=>$event->user->email]);
    }
}
