<?php

namespace App\Events\Bulk;

use App\Models\Bulk;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreatedUnAssignedBulk
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bulk;
    /**
     * Create a new event instance.
     * @param $bulk
     *
     */
    public function __construct(Bulk $bulk)
    {
        $this->bulk = $bulk;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [new Channel('channel-name')];
    }
}
