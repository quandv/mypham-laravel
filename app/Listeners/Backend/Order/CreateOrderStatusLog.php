<?php

namespace App\Listeners\Backend\Order;

use App\Events\Backend\Order\OrderStatusEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History\History;
use App\Models\History\HistoryDetails;
use Auth;
use DB;

class CreateOrderStatusLog
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
     * @param  OrderStatusEvent  $event
     * @return void
     */
    public function handle(OrderStatusEvent $event)
    {
        //    
        $user_name = $event->user->name;
        $user_email = $event->user->email;
        $order_id = $event->info['order_id'];
        $status = $event->info['order_status'];
        $back_stock = isset($event->info['back_stock']) ? $event->info['back_stock'] : 0;
        $new_txt = '';
        $status_txt = '';
        $new_arr = array();
        $history_status_order = '';
        $tong_time_stamp = 0;
        $soluong = 1;
        if (is_array($order_id)) {
            $history_status_order = $event->info['order_status'];
            //$order_id = implode(',',$order_id);
            if ($status == 1) {
                $status_txt ='<span class="label label-warning">Đang xử lý</span>';
            }
            if ($status == 2) {
                $status_txt ='<span class="label label-success">Đã thu tiền</span>';
            }
            if ($status == 3) {
                $status_txt ='<span class="label label-success">Đã hoàn thành</span>';
            }
            if ($status == 4) {
                $status_txt ='<span class="label label-danger">Đã hủy</span>';
            }
            if ($status == 5) {
                $status_txt ='<span class="label label-danger">Đã hủy(hoàn trả)</span>';
            }
            $time_stamp = array();
            foreach ($event->info['order_id'] as $key => $value) {
                $time_stamp[$key] = time() - strtotime($event->info['arr_date'][$key]);
                $new_arr[$event->info['order_id'][$key]] = array(
                        'order_id' => $event->info['order_id'][$key],
                        'order_status' => $event->info['arr_status'][$key],
                        'created_at' => $event->info['arr_date'][$key],
                        'room_id' => $event->info['arr_room'][$key],
                        'status_changed' => $event->info['order_status'],
                        'timestamp_process' => time() - strtotime($event->info['arr_date'][$key]),
                ); 
                if (floor($time_stamp[$key] / 86400) > 0) {
                    $new_txt .= $event->info['order_id'][$key] . '('. floor($time_stamp[$key] / 86400). ' d - ' . floor(($time_stamp[$key] % 86400) / 3600).' h - '. floor(($time_stamp[$key] % 3600) / 60).' phút) ,' ;          
                }else{
                    if (floor(($time_stamp[$key] % 86400) / 3600) > 0) {
                        $new_txt .= $event->info['order_id'][$key] . '('. floor(($time_stamp[$key] % 86400) / 3600) .' h - '. floor(($time_stamp[$key] % 3600) / 60) .' phút) ,' ;
                    }else{
                        $new_txt .= $event->info['order_id'][$key] . '('. floor(($time_stamp[$key] % 3600) / 60).' phút) ,' ;
                    }
                }

                $tong_time_stamp += $time_stamp[$key];  
            }
            //$time_process = implode(',',$event->info['arr_date']);
            //$room_id = implode(',', $event->info['arr_room']);
            //$tb_time_stamp = $tong_time_stamp / (count($event->info['arr_status'])); 
            $soluong = count($event->info['arr_status']);
        }else{  
            $tong_time_stamp = time() - strtotime($event->info['order_date']);
            $day = floor($tong_time_stamp / 86400);
            $hr = floor(($tong_time_stamp % 86400) / 3600);
            $min = floor(($tong_time_stamp % 3600) / 60);
            if ($day > 0 ) {
               $new_txt .= $order_id . '('. $day . ' d - ' . $hr .' h - '. $min .' phút) ,' ;       
            }else{
                if ($hr > 0) {
                    $new_txt .= $order_id . '('. $hr .' h - '. $min .' phút) ,' ;
                }else{
                    $new_txt .= $order_id . '('. $min .' phút) ,' ;
                }
            }
                
            if ($status == 1) {
                $status_txt ='<span class="label label-success">Đã thu tiền</span>';
                $status_changed = 2;
            }
            if ($status == 2) {
                $status_txt ='<span class="label label-success">Đã hoàn thành</span>';
                $status_changed = 3;
            }
            if ($status == 3) {
                if($back_stock == 0){
                    $status_txt ='<span class="label label-danger">Đã hủy</span>';
                    $status_changed = 4;
                }else{
                    $status_txt ='<span class="label label-danger">Đã hủy(hoàn trả)</span>';
                    $status_changed = 5;
                }
                
            }
            if ($status == 4 || $status == 5) {
                $status_txt ='<span class="label label-warning">Đang xử lý</span>';
                $status_changed = 1;
            }
            $history_status_order = $status_changed;
            $new_arr[$order_id] = array(
                    'order_id' => $order_id,
                    'order_status' => $event->info['order_status'],
                    'created_at' => $event->info['order_date'],
                    'room_id' => $event->info['room_id'],
                    'status_changed' => $status_changed,
                    'timestamp_process' => time() - strtotime($event->info['order_date']),
            ); 
            //$room_id = $event->info['room_id'];
        }

        $history = new History();
        $history->type_id = 1;
        $history->user_id = $event->user->id;
        $history->text = '<strong> '.$user_name . '( '.$user_email.' )</strong> thay đổi trạng thái đơn hàng  <strong>' .$new_txt .'</strong> sang ' . $status_txt;
        $history->order_status = $history_status_order;
        $history->name = Auth::user()->name;
        $history->email = Auth::user()->email;
        $history->details_order_id = json_encode($new_arr);
        $history->time_process = $tong_time_stamp;
        $history->qty_order = $soluong;
        $history->save();
        $insertedId = $history->id;
        foreach ($new_arr as $key => $value) {
            $new_arr[$key]['history_id'] =  $insertedId;
        }
        DB::table('history_details')->insert($new_arr);



    }
}
