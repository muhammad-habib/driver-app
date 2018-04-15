<?php

namespace App\Listeners\Bulk\WebHooks;

use App\Events\Bulk\CreatedUnAssignedBulk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForCreatedUnAssignedBulk
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
     * @param  CreatedUnAssignedBulk  $event
     * @return void
     */
    public function handle(CreatedUnAssignedBulk $event)
    {
        //
    }
}
