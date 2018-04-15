<?php

namespace App\Listeners\Bulk;

use App\Events\Bulk\CreatedAssignedBulk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAllWorkersForCreatedAssignedBulk
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
