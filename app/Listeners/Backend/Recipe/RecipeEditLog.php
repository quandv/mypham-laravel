<?php

namespace App\Listeners\Backend\Recipe;

use App\Events\Backend\Recipe\RecipeEdit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecipeEditLog
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
     * @param  RecipeEdit  $event
     * @return void
     */
    public function handle(RecipeEdit $event)
    {
        //
    }
}
