<?php

namespace App\Listeners\Backend\ProductInput;

use App\Events\Backend\ProductInput\ProductInputAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductInputAddLog
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
     * @param  ProductInputAdd  $event
     * @return void
     */
    public function handle(ProductInputAdd $event)
    {
        //
    }
}
