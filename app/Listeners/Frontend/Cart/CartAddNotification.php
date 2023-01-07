<?php

namespace App\Listeners\Frontend\Cart;

use App\Events\Frontend\Cart\CartAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartAddNotification
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
     * @param  CartAdd  $event
     * @return void
     */
    public function handle(CartAdd $event)
    {
        //
        $arr = $event->notification;
    }
}
