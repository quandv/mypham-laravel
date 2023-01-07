<?php

namespace App\Listeners\Backend\CatalogInput;

use App\Events\Backend\CatalogInput\CatalogInputAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CatalogInputAddLog
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
     * @param  CatalogInputAdd  $event
     * @return void
     */
    public function handle(CatalogInputAdd $event)
    {
        //
    }
}
