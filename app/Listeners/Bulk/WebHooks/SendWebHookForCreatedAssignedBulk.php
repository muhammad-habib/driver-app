<?php

namespace App\Listeners\Bulk\WebHooks;

use App\Events\Bulk\CreatedAssignedBulk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWebHookForCreatedAssignedBulk
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
     * @param  CreatedAssignedBulk  $event
     * @return void
     */
    public function handle(CreatedAssignedBulk $event)
    {
        //
    }
}
