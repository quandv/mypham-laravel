<?php

namespace App\Listeners\Backend\Recipe;

use App\Events\Backend\Recipe\RecipeAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecipeAddLog
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
     * @param  RecipeAdd  $event
     * @return void
     */
    public function handle(RecipeAdd $event)
    {
        //
    }
}
