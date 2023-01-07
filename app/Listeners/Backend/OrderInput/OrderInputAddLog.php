<?php

namespace App\Listeners\Backend\OrderInput;

use App\Events\Backend\OrderInput\OrderInputAdd;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History\HistoryStore;
class OrderInputAddLog
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
     * @param  OrderInputAdd  $event
     * @return void
     */
    public function handle(OrderInputAdd $event)
    {
        //
        /*echo "<pre>";
        print_r($event);
        echo "</pre>";*/
        if (!empty($event)) {
            $hdn_id = $event->info[0]['hn_hdn_id'];
            $historyStore = new HistoryStore();
            $historyStore->log('1', $hdn_id ,'',json_encode($event->info));
        }
    }
}
