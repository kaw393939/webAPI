<?php

namespace App\Listeners;

use App\Events\QuestionDeletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Class QuestionDeletedListener
 * @package App\Listeners
 */
class QuestionDeletedListener
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
     * @param  QuestionDeletedEvent  $event
     * @return void
     */
    public function handle(QuestionDeletedEvent $event)
    {
        Log::notice('Question '.$event->question->id.' has been deleted.');
    }
}
