<?php

namespace App\Listeners\Task;

use App\Events\Task\ReAssignTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForReAssignTask
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
     * @param  ReAssignTask  $event
     * @return void
     */
    public function handle(ReAssignTask $event)
    {
        //
    }
}
