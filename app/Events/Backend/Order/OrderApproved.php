<?php

namespace App\Events\Backend\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;
class OrderApproved implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $notification;
    public $check_chef_do;
    public function __construct($message,$check_chef_do=1)
    {
        //
        $this->notification = $message;
        $this->check_chef_do = $check_chef_do;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
       // return new PrivateChannel('channel-name');
        return ['approved_channel'];
    }
}
