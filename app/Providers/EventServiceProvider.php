<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\Bulk\CreatedUnAssignedBulk' => [
            'App\Listeners\Bulk\NotifyAllWorkersForCreatedUnAssignedBulk',
            'App\Listeners\Bulk\WebHooks\SendWebHookForCreatedUnAssignedBulk',
        ],
        'App\Events\Bulk\CreatedAssignedBulk' => [
            'App\Listeners\Bulk\NotifyAllWorkersForCreatedAssignedBulk',
            'App\Listeners\Bulk\WebHooks\SendWebHookForCreatedAssignedBulk',
        ],
        'App\Events\Task\DeliverTask' => [

        ]
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
