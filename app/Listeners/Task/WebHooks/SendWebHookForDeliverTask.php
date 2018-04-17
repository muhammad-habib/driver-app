<?php

namespace App\Listeners\Task\WebHooks;

use App\Events\Task\DeliverTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForDeliverTask
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
