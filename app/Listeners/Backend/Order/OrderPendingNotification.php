<?php

namespace App\Listeners\Backend\Order;

use App\Events\Backend\Order\OrderPending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPendingNotification
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
     * @param  OrderPending  $event
     * @return void
     */
    public function handle(OrderPending $event)
    {
        //
    }
}
