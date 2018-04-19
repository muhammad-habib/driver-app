<?php

namespace App\Listeners\Task;

use App\Events\Task\AcknowledgeTaskArrival;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForAcknowledgeTaskArrival
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
     * @param  AcknowledgeTaskArrival  $event
     * @return void
     */
    public function handle(AcknowledgeTaskArrival $event)
    {
        //
    }
}
