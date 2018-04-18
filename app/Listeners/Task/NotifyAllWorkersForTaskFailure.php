<?php

namespace App\Listeners\Task;

use App\Events\Task\AcknowledgeTaskFailure;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForTaskFailure
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
     * @param  AcknowledgeTaskFailure  $event
     * @return void
     */
    public function handle(AcknowledgeTaskFailure $event)
    {
        //
    }
}
