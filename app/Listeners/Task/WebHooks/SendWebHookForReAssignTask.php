<?php

namespace App\Listeners\Task\WebHooks;

use App\Events\Task\ReAssignTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForReAssignTask
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
