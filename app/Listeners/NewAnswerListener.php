<?php

namespace App\Listeners;

use App\Events\NewAnswerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NewAnswerListener
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
     * @param  NewAnswerEvent  $event
     * @return void
     */
    public function handle(NewAnswerEvent $event)
    {
        Log::notice('New Answer Has Been Added.');
    }
}
