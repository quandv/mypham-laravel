<?php

namespace App\Listeners\Backend\Product;

use App\Events\Backend\Product\ProductUpdateSts;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History\History;
use DB;
use DateTime;

class ProductUpdateStsLog
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
     * @param  ProductUpdateSts  $event
     * @return void
     */
    public function handle(ProductUpdateSts $event)
    {
        $listId = $event->listId;
        $status = $event->status;
        $listProduct = DB::table('product')
        ->select('product_id','product_name')
        ->whereIn('product_id', $listId)
        ->get();

        $listProductArr = array();
        foreach($listProduct as $key => $val){
            $listProductArr[$val->product_id] = $val->product_name;
        }
        if(count($listProductArr) > 0){
            $listProductJson = json_encode($listProductArr);
        }else{
            $listProductJson = '';
        }
       
        //Luu vao history
        $history = new History();
        $history->type_id = 2;
        $history->user_id = $event->user->id;
        $history->email = $event->user->email;
        $history->name = $event->user->name;
        $history->text = $listProductJson;
        $history->order_status = $status;
        $history->save();
    }
}
