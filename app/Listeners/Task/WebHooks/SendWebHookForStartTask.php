<?php

namespace App\Listeners\Task\WebHooks;

use App\Events\Task\StartTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForStartTask
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
     * @param  StartTask  $event
     * @return void
     */
    public function handle(StartTask $event)
    {
        //
    }
}
