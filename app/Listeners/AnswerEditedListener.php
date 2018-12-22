<?php

namespace App\Listeners;

use App\Events\AnswerEditedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AnswerEditedListener
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
     * @param  AnswerEditedEvent  $event
     * @return void
     */
    public function handle(AnswerEditedEvent $event)
    {
        Log::notice('User '.$event->answer->user_id.' has edited answer '.$event->answer->id.' to question '.$event->answer->question_id);
    }
}
