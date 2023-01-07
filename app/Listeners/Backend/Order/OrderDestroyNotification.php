<?php

namespace App\Listeners\Backend\Order;

use App\Events\Backend\Order\OrderDestroy;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDestroyNotification
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
     * @param  OrderDestroy  $event
     * @return void
     */
    public function handle(OrderDestroy $event)
    {
        //
    }
}
