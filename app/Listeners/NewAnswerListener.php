<?php

namespace App\Listeners;

use App\Events\NewAnswerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        //
    }
}
