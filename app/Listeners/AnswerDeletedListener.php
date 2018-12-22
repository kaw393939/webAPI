<?php

namespace App\Listeners;

use App\Events\AnswerDeletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AnswerDeletedListener
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
     * @param  AnswerDeletedEvent  $event
     * @return void
     */
    public function handle(AnswerDeletedEvent $event)
    {
        Log::notice('Answer '.$event->answer->id.' to question '.$event->answer->question_id.' has been deleted.');
    }
}
