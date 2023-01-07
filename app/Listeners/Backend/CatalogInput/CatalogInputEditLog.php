<?php

namespace App\Listeners\Backend\CatalogInput;

use App\Events\Backend\CatalogInput\CatalogInputEdit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CatalogInputEditLog
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
     * @param  CatalogInputEdit  $event
     * @return void
     */
    public function handle(CatalogInputEdit $event)
    {
        //
    }
}
