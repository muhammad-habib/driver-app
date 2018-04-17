<?php

namespace App\Listeners\Task;

use App\Events\Task\DeliverTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForDeliverTask
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
     * @param  DeliverTask  $event
     * @return void
     */
    public function handle(DeliverTask $event)
    {
        //
    }
}
