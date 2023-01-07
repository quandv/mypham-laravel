<?php

namespace App\Listeners\Backend\UnitInput;

use App\Events\Backend\UnitInput\UnitInputAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitInputAddLog
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
     * @param  UnitInputAdd  $event
     * @return void
     */
    public function handle(UnitInputAdd $event)
    {
        //
    }
}
