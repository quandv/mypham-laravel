<?php

namespace App\Listeners\Backend\Order;

use App\Events\Backend\Order\OrderDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDoneNotification
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
     * @param  OrderDone  $event
     * @return void
     */
    public function handle(OrderDone $event)
    {
        //
    }
}
