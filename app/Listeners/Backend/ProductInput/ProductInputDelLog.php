<?php

namespace App\Listeners\Backend\ProductInput;

use App\Events\Backend\ProductInput\ProductInputDel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductInputDelLog
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
     * @param  ProductInputDel  $event
     * @return void
     */
    public function handle(ProductInputDel $event)
    {
        //
    }
}
