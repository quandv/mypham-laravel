<?php

namespace App\Listeners\Backend\OrderInput;

use App\Events\Backend\OrderInput\OrderInputEdit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History\HistoryStore;
class OrderInputEditLog
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
     * @param  OrderInputEdit  $event
     * @return void
     */
    public function handle(OrderInputEdit $event)
    {
        //
        if (!empty($event)) {
            $hdn_id = $event->info[0]['hn_hdn_id'];
            $historyStore = new HistoryStore();
            $historyStore->log('2', $hdn_id ,'',json_encode($event->info));
        }
    }
}
