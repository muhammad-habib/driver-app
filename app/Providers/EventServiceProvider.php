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
        'App\Events\Task\StartTask' => [
            'App\Listeners\Task\NotifyAllWorkersForStartTask',
            'App\Listeners\Task\WebHooks\SendWebHookForStartTask',
        ],
        'App\Events\Task\RefuseTask' => [
            'App\Listeners\Task\NotifyAllWorkersForRefuseTask',
            'App\Listeners\Task\WebHooks\SendWebHookForRefuseTask',
        ],
        'App\Events\Task\DeliverTask' => [
            'App\Listeners\Task\NotifyAllWorkersForDeliverTask',
            'App\Listeners\Task\WebHooks\SendWebHookForDeliverTask',
        ],
        'App\Events\Task\AcknowledgeTaskFailure' => [
            'App\Listeners\Task\NotifyAllWorkersForTaskFailure',
            'App\Listeners\Task\WebHooks\SendWebHookForTaskFailure',
        ],
        'App\Events\Task\AssignTask' => [
            'App\Listeners\Task\NotifyAllWorkersForAssignTask',
            'App\Listeners\Task\WebHooks\SendWebHookForAssignTask',
        ],
        'App\Events\Task\ReAssignTask' => [
            'App\Listeners\Task\NotifyAllWorkersForReAssignTask',
            'App\Listeners\Task\WebHooks\SendWebHookForReAssignTask',
        ],
        'App\Events\Task\AcknowledgeTaskArrival' => [
            'App\Listeners\Task\NotifyAllWorkersForAcknowledgeTaskArrival',
            'App\Listeners\Task\WebHooks\SendWebHookForAcknowledgeTaskArrival',
        ],
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
