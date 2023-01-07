<?php

namespace App\Listeners\Backend\UnitInput;

use App\Events\Backend\UnitInput\UnitInputEdit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitInputEditLog
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
     * @param  UnitInputEdit  $event
     * @return void
     */
    public function handle(UnitInputEdit $event)
    {
        //
    }
}
