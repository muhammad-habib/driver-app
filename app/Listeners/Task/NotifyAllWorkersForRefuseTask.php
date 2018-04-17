<?php

namespace App\Listeners\Task;

use App\Events\Task\RefuseTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForRefuseTask
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
     * @param  RefuseTask  $event
     * @return void
     */
    public function handle(RefuseTask $event)
    {
        //
    }
}
