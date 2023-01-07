<?php

namespace App\Listeners\Backend\ProductInput;

use App\Events\Backend\ProductInput\ProductInputEdit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductInputEditLog
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
     * @param  ProductInputEdit  $event
     * @return void
     */
    public function handle(ProductInputEdit $event)
    {
        //
    }
}
