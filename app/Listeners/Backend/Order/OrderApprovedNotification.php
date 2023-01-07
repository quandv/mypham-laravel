<?php

namespace App\Listeners\Backend\Order;

use App\Events\Backend\Order\OrderApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderApprovedNotification
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
     * @param  OrderApproved  $event
     * @return void
     */
    public function handle(OrderApproved $event)
    {
        //
    }
}
