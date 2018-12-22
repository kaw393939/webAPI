<?php

namespace App\Listeners;

use App\Events\QuestionEditedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Question;

/**
 * Class QuestionEditedListener
 * @package App\Listeners
 */
class QuestionEditedListener
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
     * @param  QuestionEditedEvent  $event
     * @return void
     */
    public function handle(QuestionEditedEvent $event)
    {
        Log::notice('User '.$event->question->user_id.' has edited their question: '.$event->question->getQuestion());
    }
}
