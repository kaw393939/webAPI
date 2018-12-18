<?php

namespace App\Listeners;

use App\Events\NewQuestionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\User;

class NewQuestionListener
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
     * @param  NewQuestionEvent  $event
     * @return void
     */
    public function handle(NewQuestionEvent $event)
    {
        Log::notice($event->question->user().' has asked a question: '.$event->question->getQuestion());
    }
}
