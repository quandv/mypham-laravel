<?php

namespace App\Listeners\Backend\CatalogInput;

use App\Events\Backend\CatalogInput\CatalogInputDel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CatalogInputDelLog
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
     * @param  CatalogInputDel  $event
     * @return void
     */
    public function handle(CatalogInputDel $event)
    {
        //
    }
}
