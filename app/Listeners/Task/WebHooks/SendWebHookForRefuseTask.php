<?php

namespace App\Listeners\Task\WebHooks;

use App\Events\Task\RefuseTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForRefuseTask
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
