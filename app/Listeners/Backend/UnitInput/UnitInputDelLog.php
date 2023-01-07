<?php

namespace App\Listeners\Backend\UnitInput;

use App\Events\Backend\UnitInput\UnitInputDel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitInputDelLog
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
     * @param  UnitInputDel  $event
     * @return void
     */
    public function handle(UnitInputDel $event)
    {
        //
    }
}
