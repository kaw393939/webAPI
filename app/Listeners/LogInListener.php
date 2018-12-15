<?php

namespace App\Listeners;

use App\Events\LogInEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\User;

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
        Log::notice('User Has Logged In: ',['name'=>$event->user->name,'email'=>$event->user->email]);
    }
}
