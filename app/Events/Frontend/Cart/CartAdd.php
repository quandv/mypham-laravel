<?php

namespace App\Events\Frontend\Cart;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;
class CartAdd extends Event implements ShouldBroadcast
{
    use  SerializesModels;//InteractsWithSockets,

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $notification;
    public function __construct($arr)
    {
        //
        $this->notification = $arr;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('test_channel');
        return ['add_channel'];
    }
}
