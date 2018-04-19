<?php

namespace App\Listeners\Task;

use App\Events\Task\AssignTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForAssignTask
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
     * @param  AssignTask  $event
     * @return void
     */
    public function handle(AssignTask $event)
    {

    }
}
