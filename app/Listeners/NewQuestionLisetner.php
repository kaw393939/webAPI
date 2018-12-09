<?php

namespace App\Listeners;

use App\Events\NewQuestionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NewQuestionLisetner
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
        Log::notice('A New Question Has Been Asked.');
    }
}
