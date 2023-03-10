<?php

namespace App\Events\Backend\Product;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductUpdateSts
{
    use InteractsWithSockets, SerializesModels;

    public $user;
    public $listId;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$listId,$status)
    {
        $this->user = $user;
        $this->listId = $listId;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
