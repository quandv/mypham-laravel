<?php

namespace App\Listeners\Backend\Product;

use App\Events\Backend\Product\ProductDel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History\History;
class ProductDelLog
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
     * @param  ProductDel  $event
     * @return void
     */
    public function handle(ProductDel $event)
    {        
        $history = new History();
        $history->type_id = 5;
        $history->entity_id = $event->info->product_id;
        $history->entity_name = $event->info->product_name;
        $history->entity_value = $event->info->product_price;
        $history->entity_status = $event->info->status;
        //$history->entity_option = json_encode($event->info->product_option);
        $history->user_id = $event->user->id;
        $history->name = $event->user->name;
        $history->email = $event->user->email;
        $history->save();
    }
}
