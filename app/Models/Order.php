<?php
namespace App\Models\Backend;
use DB;
use HtmlString;
use Auth;
use Session;
use DateTime;
use App\Events\Backend\Order\OrderStatusEvent;
use Event;
class Order 
{
  public static function checkNewOrder(){
      $flag = false;
      $data = DB::table('order')->where('order_status', 1)->orderBy('order.order_id', 'desc')->first();
      if (!empty($data)) { 
          //session()->forget('id_new_order');
          if (!session()->has('id_new_order')) {
            Session::set('id_new_order', $data->order_id);     
            $flag = true; 
          }else{ 
            if($data->order_id != session()->get('id_new_order')){
                  $flag = true; 
                  Session::set('id_new_order', $data->order_id);    
              }else{
                 $flag = false;
             }     
          } 
      }  
      return $flag;   
  }
	public static function listOrder($request){
    $page_num = $request->pnum;
    if (access()->hasPermission('manager-all-order')) {
        $data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.order_status,order.room_id,order.client_ip,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->where(function ($query) use ($request){                
                if ($request->table_search != '' ) {
                   if (!is_numeric($request->table_search)) {
                      $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                   }else{
                      $query->where('order.order_id', '=', trim($request->table_search));
                   }     
                }
            })
           ->where('order_type', 0)
           ->orderBy('order.order_id', 'desc')
           ->groupBy("order.order_id")
           ->paginate($page_num);
    }else{
     /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
        $startTime = date("Y-m-d 07:00:00");
        $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
     }else{
        $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
        $endTime = date("Y-m-d 08:30:00");
     }*/
       $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

      if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){

         $data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.client_ip,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           ->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
            })
           ->where(function ($query) use ($request){                
                if ($request->table_search != '' ) {
                   if (!is_numeric($request->table_search)) {
                      $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                   }else{
                      $query->where('order.order_id', '=', trim($request->table_search));
                   }     
                }
            })
           ->where('order_type', 0)
           ->orderBy('order.order_id', 'desc')
           ->groupBy("order.order_id")
           ->paginate($page_num);
          }
    }
     if (!empty($data)) {
     		foreach ($data as $key => $value) {
     			if ($value->order_status == 1) {
     				$data->neworder = 1;
     			}
     			$arr = array();
     			$value->product_name_group = explode(',', $value->product_name_group);
     			$value->product_price_group = explode(',', $value->product_price_group);
     			$value->product_qty_group = explode(',', $value->product_qty_group);
     			$value->product_option_group = explode('|', $value->product_option_group);
     			if (!empty($value->product_option_group)) {
     				foreach ($value->product_option_group as $k => $v) {
     					if (!empty($v)) {
     						$value->product_option_group[$k] = json_decode($v);
     						//$value->cout_option = count($value->product_option_group[$k]);
     					}
     				}
     			}
     			for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
     				 $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
     				 $value->price = $arr;
     				 $value->sumPrice = array_sum($value->price);
     			}  
     		}	
     }
	         //
	     $xhtml = '';
	     $pagi_link = '';
	     if(!empty($data)) { 
            foreach($data as $val) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val->updated_at);
                  $xhtml .="<tr class='orderItem' data-id='".$val->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";

                  /*$xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";*/
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ul class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ul>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time,'order_chef_do'=>$val->order_chef_do]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a data-time="'.$val->order_create_time.'" href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a data-time="'.$val->order_create_time.'" href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/
                          $xhtml .="</td>";
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';
                          
                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/

                          $xhtml .="</td>";

                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a data-time="'.$val->order_create_time.'" href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a data-time="'.$val->order_create_time.'" href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                        
                   $xhtml .= '</tr>';

            }
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->appends($request->all())->links()->toHtml();
            } 
            
         }
         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
         	//'check_new_order' => self::checkNewOrder(),
         ];

	    return $result;
	}
	public static function ajaxStatus($order_id,$order_status,$order_time = null,$room_id = null){
    //1:đang xử lý , 2: đã thu tiền , 3:đã hoàn thành , 4: hủy, 5: hủy hoàn trả kho hàng
    $flag = false;
    
		if ($order_status == 1 && access()->hasPermission('access-status-money')) {
			 $status = 2 ;
       $flag = true;
		}
		if ($order_status == 2 && access()->hasPermission('access-status-finish')) {
			 $status = 3 ;
       $flag = true;
		}
		if ($order_status == 3 && access()->hasPermission('access-done-destroy')) {        
        $status = 4;
        $flag = true;
		}
    if (($order_status == 4 || $order_status == 5) && access()->hasPermission('access-status-pending')) {
        $status = 1 ;
        $flag = true;
    }

    if ($flag) {
        if($order_status == 5){
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
          $getStockOrder = DB::table('order')->select('order_stock')->where('order_id','=',$order_id)->first();
          $stockOrder = json_decode($getStockOrder->order_stock);
          
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
          foreach( $stockOrder as $id => $qty ){
            //$qty = number_format($qty, 3, '.', '');
            DB::table('san_pham_tho')->where('spt_id', $id)->decrement('spt_quantity', $qty);
          }
        }else{
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
        }
        
        $result = array(
          'order_id'  => (int)$order_id, 
          'order_status'  => $status, 
          'link'=> route('admin.order.status',['order_id'=>$order_id,'order_status'=>$status,'room_id'=>$room_id,'order_time'=>$order_time])
        );  
        return $result;
    }else{
        return false;
    }
		
	}

  public static function ajaxStatus2Approved($order_id,$order_status,$order_time = null,$room_id = null){
    //1:đang xử lý , 2: đã thu tiền , 3:đã hoàn thành , 4: hủy, 5: hủy hoàn trả kho hàng
    $flag = false;
    
    if ($order_status == 1 && access()->hasPermission('access-status-money')) {
       $status = 2 ;
       $flag = true;
    }
    if ($order_status == 2 && access()->hasPermission('access-status-finish')) {
       $status = 3 ;
       $flag = true;
    }
    if ($order_status == 3 && access()->hasPermission('access-done-destroy')) {
        $status = 4;
        $flag = true;
    }
    if ( ($order_status == 4 || $order_status == 5) && (access()->hasPermission('access-status-pending') || access()->hasPermission('access-status-money')) ) {
        $status = 2 ;
        $flag = true;
    }

    if ($flag) {
        if($order_status == 5){
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
          $getStockOrder = DB::table('order')->select('order_stock')->where('order_id','=',$order_id)->first();
          $stockOrder = json_decode($getStockOrder->order_stock);
          
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
          foreach( $stockOrder as $id => $qty ){
            //$qty = number_format($qty, 3, '.', '');
            DB::table('san_pham_tho')->where('spt_id', $id)->decrement('spt_quantity', $qty);
          }
        }else{
          DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
        }
        
        $result = array(
          'order_id'  => (int)$order_id, 
          'order_status'  => $status, 
          'link'=> route('admin.order.status',['order_id'=>$order_id,'order_status'=>$status,'room_id'=>$room_id,'order_time'=>$order_time])
        );  
        return $result;
    }else{
        return false;
    }
    
  }

  public static function ajaxStatusMessage($order_id,$order_status,$message_destroy,$back_stock=0){
    $flag = false;
    if ($order_status == 3 && access()->hasPermission('access-done-destroy')) {
        $flag = true;
    }
    if ($flag) {
        if( $back_stock == 1){
          $getStockOrder = DB::table('order')->select('order_stock')->where('order_id','=',$order_id)->first();
          $stockOrder = json_decode($getStockOrder->order_stock);
          DB::table('order')->where('order_id',$order_id)->update(['message_destroy'=> htmlentities($message_destroy), 'order_status' => 5]);
          foreach( $stockOrder as $id => $qty ){
            //$qty = number_format($qty, 3, '.', '');
            DB::table('san_pham_tho')->where('spt_id', $id)->increment('spt_quantity', $qty);
          }
        }else{
          DB::table('order')->where('order_id',$order_id)->update(['message_destroy'=> htmlentities($message_destroy), 'order_status' => 4]);
        }
        return $message_destroy;
    }else{
        return false;
    }
  }
  public static function ajaxStatusTwo($list_order_id,$order_status,$info){
    $flag = false;
    $message_err = '';
    $message_succ = '';
    if ($order_status == 1 && access()->hasPermission('access-status-pending')) {
       $flag = true;
    }
    if ($order_status == 2 && access()->hasPermission('access-status-money')) {
       $flag = true;
    }
    if ($order_status == 3 && access()->hasPermission('access-status-finish')) {
        $flag = true;
    }
/*    if ($order_status == 4 && access()->hasPermission('access-status-destroy')) {
        $flag = true;
    }*/
    if ($order_status == 4 && (access()->hasPermission('access-pendding-destroy') || access()->hasPermission('access-approved-destroy') || access()->hasPermission('access-done-destroy'))) {
        $listArr = array_combine($list_order_id,$info['arr_status']);
        $messageArrErr = array();
        foreach ($listArr as $key => $value) {
            if ( $value == 1 && !access()->hasPermission('access-pendding-destroy')) {
               unset($listArr[$key]);
               $messageArrErr[] = $key;
            }
            if ( $value == 2 && !access()->hasPermission('access-approved-destroy')) {
               unset($listArr[$key]);
               $messageArrErr[] = $key;
            }
            if ( $value == 3 && !access()->hasPermission('access-done-destroy')) {
               unset($listArr[$key]);
               $messageArrErr[] = $key;
            }
            if ( $value == 4 || $value == 5) {
               unset($listArr[$key]);
               $messageArrErr[] = $key;
            }
        }
        if (count($messageArrErr) > 0) {
           $message_err = 'Các đơn hàng '. implode(',', $messageArrErr) . ' cập nhật không thành công';
        }
        if(count($listArr) > 0){
            $list_order_id = array_keys($listArr);
            $message_succ = 'Các đơn hàng '. implode(',',  $list_order_id) . ' cập nhật thành công';
            $flag = true;
        }  
    }
    if ($flag) {
        $info['order_id'] = $list_order_id;
        Event::fire(new OrderStatusEvent(Auth::user(),$info));
        $getStockOrder = DB::table('order')->select('order_stock')->whereIn('order_id',$list_order_id)->get();
          $stockOrder = array();
          if(count($getStockOrder) > 0){
            foreach($getStockOrder as $val){
              $arr = json_decode($val->order_stock, true);
              if(count($arr) > 0){
                foreach ($arr as $key => $value) {
                  if(array_key_exists($key, $stockOrder)){
                    $stockOrder[$key] += $value;
                  }else{
                    $stockOrder[$key] = $value;
                  }
                }
              }
            }
          }

        if (!empty($info['message_destroy'])) {
          if($info['back_stock'] == 1){
            $order_status = 5;            
            $update =  DB::table('order')->whereIn('order_id',$list_order_id)->update(['order_status'=>$order_status,'message_destroy'=>htmlentities($info['message_destroy'])]);
            if(count($stockOrder) > 0){
                foreach( $stockOrder as $id => $qty ){
                  //$qty = number_format($qty, 3, '.', '');
                  DB::table('san_pham_tho')->where('spt_id', $id)->increment('spt_quantity', $qty);
                }
            }
            
          }else{
            $update =  DB::table('order')->whereIn('order_id',$list_order_id)->update(['order_status'=>$order_status,'message_destroy'=>htmlentities($info['message_destroy'])]);
          }
          
        }else{
          $update =  DB::table('order')->whereIn('order_id',$list_order_id)->update(['order_status'=>$order_status]);
          foreach( $stockOrder as $id => $qty ){
            //$qty = number_format($qty, 3, '.', '');
            DB::table('san_pham_tho')->where('spt_id', $id)->decrement('spt_quantity', $qty);
          }
        }

        if ($update) {
          $result = array(
            'status'  => true,
            'message_err' => $message_err,
            'message_succ' => $message_succ,
          ); 
        }else{
          $result = array(
            'status'  => false, 
            'message_err' => $message_err,
            'message_succ' => $message_succ,
          ); 
        }
        
        return $result; 
     }else{
        $result = array(
          'status'  => false,
          'message_err' => $message_err,
          'message_succ' => $message_succ,
        ); 
        return $result;
     }  
  }
  
  //Đơn hàng đã thu tiền
	public static function listOrderApproved($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
        $total = self::sum_total_order(2,'all');
        $total2 = self::sum_total_order_2(2,'all');
        $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
              ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
              ->where('order_type', 0)
              ->orderBy('order.order_id', 'asc')
              ->groupBy("order.order_id")
              ->paginate($page_num);

        // Order of employee
        $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
               })
              ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
              ->where('order_type', 1)
              ->orderBy('order.order_id', 'asc')
              ->groupBy("order.order_id")
              ->paginate($page_num2);
    }else{
       /*$startTimeNow = date("Y-m-d 07:00:00");
       if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
          $startTime = date("Y-m-d 07:00:00");
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
          $endTime = date("Y-m-d 08:30:00");
       }*/
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('chef-do')){
          $total = self::sum_total_order(2);
          $total2 = self::sum_total_order_2(2);
          $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               /*->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })*/
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order.order_type', 0)
               ->where('order.order_chef_do', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num);
//dd($data);
          // Order of employee
          $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               /*->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })*/
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order.order_type', 1)
               ->where('order.order_chef_do', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num2);
        }
       else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') ||  access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(2);
          $total2 = self::sum_total_order_2(2);
          $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num);

          // Order of employee
          $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num2);
        }

    }
      
       if (!empty($data)) {
       		foreach ($data as $key => $value) {
       			$arr = array();
       			$value->product_name_group = explode(',', $value->product_name_group);
       			$value->product_price_group = explode(',', $value->product_price_group);
       			$value->product_qty_group = explode(',', $value->product_qty_group);
       			$value->product_option_group = explode('|', $value->product_option_group);
       			if (!empty($value->product_option_group)) {
       				foreach ($value->product_option_group as $k => $v) {
       					if (!empty($v)) {
       						$value->product_option_group[$k] = json_decode($v);
       						//$value->cout_option = count($value->product_option_group[$k]);
       					}
       				}
       			}
       			for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
       				 $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
       				 $value->price = $arr;
       				 $value->sumPrice = array_sum($value->price);
       			}  
       		}
       }
	     $xhtml = '';
	     $pagi_link = '';
	     if(!empty($data)) { 
            foreach($data as $val) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val->updated_at);
                  $xhtml .="<tr class='orderItem' data-id='".$val->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ul class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ul>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        /*if ($val->updated_at != null) {
                           $order_time = $val->updated_at;
                        }else{
                           $order_time = $val->order_create_time;
                        }*/
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';

            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->appends($request->all())->links()->toHtml();
            }
         }

      // Order of employee
         if (!empty($data2)) {
          foreach ($data2 as $key2 => $value2) {
            $arr = array();
            $value2->product_name_group = explode(',', $value2->product_name_group);
            $value2->product_price_group = explode(',', $value2->product_price_group);
            $value2->product_qty_group = explode(',', $value2->product_qty_group);
            $value2->product_option_group = explode('|', $value2->product_option_group);
            if (!empty($value2->product_option_group)) {
              foreach ($value2->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value2->product_option_group[$k] = json_decode($v);
                  //$value2->cout_option = count($value2->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
               $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
               $value2->price = $arr;
               $value2->sumPrice = array_sum($value2->price);
            }  
          }
       }
       $xhtml2 = '';
       $pagi_link2= '';
       if(!empty($data2)) {
            foreach($data2 as $val2) {
                  /*$xhtml2 .="<tr>";
                  $xhtml2 .="<td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";*/

                  $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val2->updated_at);
                  $xhtml2 .="<tr class='orderItem' data-id='".$val2->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";

                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row">';
                      $xhtml2 .= '<div class="col-sm-5">&nbsp;</div>';
                      $xhtml2 .= '<div class="col-sm-2">Số lượng</div>';
                      $xhtml2 .= '<div class="col-sm-2">Đơn giá</div>';
                      $xhtml2 .= '<div class="col-sm-2">Thành tiền</div>';
                  $xhtml2 .= '</div>';

                       for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                         $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                         if (!empty($val2->product_option_group)) {
                          $xhtml2 .='<ul class="order-option">';
                        foreach ($val2->product_option_group[$i] as $k => $v) {
                          $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml2 .='</ul>';
                         }
                         $xhtml2 .= '</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml2 .='</td>';
                  $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                        /*if ($val2->updated_at != null) {
                           $order_time = $val2->updated_at;
                        }else{
                           $order_time = $val2->order_create_time;
                        }*/
                        $link = route('admin.order.status',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time]);
                        if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";

                        }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";
                        }
                        if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml2 .= '</tr>'; 

            }
            $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total2,0,",",".").'</td></tr>';
            $xhtml2 .='</tr>';
            if ($data2->hasMorePages() || !empty($request->page)) {
              $pagi_link2 = $data2->setPath('getAjaxListApproved2')->appends($request->all())->toHtml();
            }
         }

         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
         	//'check_new_order' => self::checkNewOrder(),
         ];
         
	    return $result;
	}

  //don hang da thu tien (client) - pagination
  public static function listOrderApproved1($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
        $total = self::sum_total_order(2,'all');
        $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
              ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
              ->where('order_type', 0)
              ->orderBy('order.order_id', 'asc')
              ->groupBy("order.order_id")
              ->paginate($page_num);
    }else{
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('chef-do')){
          $total = self::sum_total_order(2);
          $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               /*->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })*/
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 0)
               ->where('order_chef_do', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num);
        }else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') ||  access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(2);
          $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num);
        }

    }
      
       if (!empty($data)) {
          foreach ($data as $key => $value) {
            $arr = array();
            $value->product_name_group = explode(',', $value->product_name_group);
            $value->product_price_group = explode(',', $value->product_price_group);
            $value->product_qty_group = explode(',', $value->product_qty_group);
            $value->product_option_group = explode('|', $value->product_option_group);
            if (!empty($value->product_option_group)) {
              foreach ($value->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value->product_option_group[$k] = json_decode($v);
                  //$value->cout_option = count($value->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
               $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
               $value->price = $arr;
               $value->sumPrice = array_sum($value->price);
            }  
          }
       }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) { 
            foreach($data as $val) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val->updated_at);
                  $xhtml .="<tr class='orderItem' data-id='".$val->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";

                  /*$xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";*/
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        /*if ($val->updated_at != null) {
                           $order_time = $val->updated_at;
                        }else{
                           $order_time = $val->order_create_time;
                        }*/
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>'; 

            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->appends($request->all())->links()->toHtml();
            }
         }

         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'html2' => $xhtml2,
          //'pagi2' => $pagi_link2,
          //'check_new_order' => self::checkNewOrder(),
         ];
         
      return $result;
  }

  //Đơn hàng đã thu tiền employee
  public static function listOrderApproved2($request){
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
      $total = self::sum_total_order_2(2,'all');
        // Order of employee
        $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.order_chef_do,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
               })
              ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
              ->where('order_type', 1)
              ->orderBy('order.order_id', 'asc')
              ->groupBy("order.order_id")
              ->paginate($page_num2);
    }else{
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('chef-do')){
          $total = self::sum_total_order_2(2);
          // Order of employee
          $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.order_chef_do,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               /*->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })*/
               ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 1)
               ->where('order.order_chef_do', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num2);

        }else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') ||  access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order_2(2);
          // Order of employee
          $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.updated_at,order.room_id,order.order_status,order.order_chef_do,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                   if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }
                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
               })
               ->where('order.order_status','=',2) // Di chuyển xuống dưới orWhere ko bị lỗi tìm kiếm ???
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'asc')
               ->groupBy("order.order_id")
               ->paginate($page_num2);
        }
    }

      // Order of employee
         if (!empty($data2)) {
          foreach ($data2 as $key2 => $value2) {
            $arr = array();
            $value2->product_name_group = explode(',', $value2->product_name_group);
            $value2->product_price_group = explode(',', $value2->product_price_group);
            $value2->product_qty_group = explode(',', $value2->product_qty_group);
            $value2->product_option_group = explode('|', $value2->product_option_group);
            if (!empty($value2->product_option_group)) {
              foreach ($value2->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value2->product_option_group[$k] = json_decode($v);
                  //$value2->cout_option = count($value2->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
               $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
               $value2->price = $arr;
               $value2->sumPrice = array_sum($value2->price);
            }  
          }
       }
       $xhtml2 = '';
       $pagi_link2= '';
       if(!empty($data2)) { 
            foreach($data2 as $val2) {
                  $xhtml2 .="<tr>";
                  $xhtml2 .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";
                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row">';
                      $xhtml2 .= '<div class="col-sm-5">&nbsp;</div>';
                      $xhtml2 .= '<div class="col-sm-2">Số lượng</div>';
                      $xhtml2 .= '<div class="col-sm-2">Đơn giá</div>';
                      $xhtml2 .= '<div class="col-sm-2">Thành tiền</div>';
                  $xhtml2 .= '</div>';

                       for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                         $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                         if (!empty($val2->product_option_group)) {
                          $xhtml2 .='<ul class="order-option">';
                        foreach ($val2->product_option_group[$i] as $k => $v) {
                          $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml2 .='</ul>';
                         }
                         $xhtml2 .= '</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml2 .='</td>';
                  $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                        /*if ($val2->updated_at != null) {
                           $order_time = $val2->updated_at;
                        }else{
                           $order_time = $val2->order_create_time;
                        }*/
                        $link = route('admin.order.status',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time,'order_chef_do'=>$val2->order_chef_do]);
                        if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";

                        }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";

                        }
                        if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml2 .= '</tr>'; 

            }
            $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            $xhtml2 .='</tr>';
            if ($data2->hasMorePages() || !empty($request->page)) {
              $pagi_link2 = $data2->setPath('getAjaxListApproved2')->appends($request->all())->toHtml();
            }
         }

         $result = array();
         $result =[
          //'html' => $xhtml,
          //'pagi' => $pagi_link,
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
          //'check_new_order' => self::checkNewOrder(),
         ];
         
      return $result;
  }

  //Đơn hàng đang xử lý
	public static function listOrderPending($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
        $total = self::sum_total_order(1,'all');
        $total2 = self::sum_total_order_2(1,'all');

        $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
    }else{
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('chef-do')){
          $total = self::sum_total_order(1);
          $total2 = self::sum_total_order_2(1);
        $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             /*->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })*/
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 0)
             ->where('order_chef_do', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
             //dd($data);

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             /*->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })*/
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 1)
             ->where('order_chef_do', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
             //dd($data);
        }else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(1);
          $total2 = self::sum_total_order_2(1);
        $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             ->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
             //dd($data);

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             ->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
             //dd($data);
        }

    }
       if (!empty($data)) {
       		foreach ($data as $key => $value) {
       			$arr = array();
       			$value->product_name_group = explode(',', $value->product_name_group);
       			$value->product_price_group = explode(',', $value->product_price_group);
       			$value->product_qty_group = explode(',', $value->product_qty_group);
       			$value->product_option_group = explode('|', $value->product_option_group);
       			if (!empty($value->product_option_group)) {
       				foreach ($value->product_option_group as $k => $v) {
       					if (!empty($v)) {
       						$value->product_option_group[$k] = json_decode($v);
       						//$value->cout_option = count($value->product_option_group[$k]);
       					}
       				}
       			}
       			for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
       				 $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
       				 $value->price = $arr;
       				 $value->sumPrice = array_sum($value->price);
       			}  
       		}
       }
	     $xhtml = '';
	     $pagi_link = '';
	     if(!empty($data)) { 
            foreach($data as $val) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val->order_create_time);
                  $xhtml .="<tr class='orderItem' data-id='".$val->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ul class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ul>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                         $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time,'order_chef_do'=>$val->order_chef_do]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/

                          $xhtml .="</td>";

                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/

                          $xhtml .="</td>";
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';   
            }
             $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->appends($request->all())->links()->toHtml();
            }
         }

        // Order of employee
         if (!empty($data2)) {
          foreach ($data2 as $key2 => $value2) {
            $arr = array();
            $value2->product_name_group = explode(',', $value2->product_name_group);
            $value2->product_price_group = explode(',', $value2->product_price_group);
            $value2->product_qty_group = explode(',', $value2->product_qty_group);
            $value2->product_option_group = explode('|', $value2->product_option_group);
            if (!empty($value2->product_option_group)) {
              foreach ($value2->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value2->product_option_group[$k] = json_decode($v);
                  //$value2->cout_option = count($value2->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
               $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
               $value2->price = $arr;
               $value2->sumPrice = array_sum($value2->price);
            }  
          }
       }
        $xhtml2 = '';
        $pagi_link2 = '';
        if(!empty($data2)) { 
            foreach($data2 as $val2) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val2->order_create_time);
                  $xhtml2 .="<tr class='orderItem' data-id='".$val2->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";
                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                         $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                         if (!empty($val2->product_option_group)) {
                          $xhtml2 .='<ul class="order-option">';
                        foreach ($val2->product_option_group[$i] as $k => $v) {
                          $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml2 .='</ul>';
                         }
                         $xhtml2 .= '</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml2 .='</td>';
                  $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                         $link = route('admin.order.status',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time,'order_chef_do'=>$val2->order_chef_do]);
                        if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";
                        }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";
                        }
                        if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';*/

                          $xhtml2 .="</td>";

                        }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';*/

                          $xhtml2 .="</td>";
                        }
                        if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml2 .= '</tr>';   
            }
             $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total2,0,",",".").'</td></tr>';
            if ($data2->hasMorePages() || !empty($request->page)) {
              $pagi_link2 = $data2->setPath('getAjaxListPending2')->appends($request->all())->toHtml();
            }
         }

         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
         	//'check_new_order' => self::checkNewOrder(),
         ];

	    return $result;
	}

  //don hang da thu tien (client) - pagination
  public static function listOrderPending1($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
        $total = self::sum_total_order(1,'all');

        $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
        
    }else{
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('chef-do')){
          $total = self::sum_total_order(1);

          $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order.order_type', 0)
             ->where('order.order_chef_do', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
             
        }else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(1);

          $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             ->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })
             ->where(function ($query) use ($request){
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
             
        }

    }
       if (!empty($data)) {
          foreach ($data as $key => $value) {
            $arr = array();
            $value->product_name_group = explode(',', $value->product_name_group);
            $value->product_price_group = explode(',', $value->product_price_group);
            $value->product_qty_group = explode(',', $value->product_qty_group);
            $value->product_option_group = explode('|', $value->product_option_group);
            if (!empty($value->product_option_group)) {
              foreach ($value->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value->product_option_group[$k] = json_decode($v);
                  //$value->cout_option = count($value->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
               $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
               $value->price = $arr;
               $value->sumPrice = array_sum($value->price);
            }  
          }
       }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) { 
            foreach($data as $val) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val->order_create_time);
                  $xhtml .="<tr class='orderItem' data-id='".$val->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                         $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time,'order_chef_do'=>$val->order_chef_do]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';

                          $xhtml .="</td>";
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/

                          $xhtml .="</td>";

                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml .='<div class="countup countup-'.$val->order_id.'"><div class="days-'.$val->order_id.' hide"><span id="days-'.$val->order_id.'">00</span><div class="timeRefDays-'.$val->order_id.'">ngày</div></div><div class="hours-'.$val->order_id.'"><span id="hours-'.$val->order_id.'">00</span><div class="timeRefHours-'.$val->order_id.'">giờ</div></div><div class="minutes-'.$val->order_id.'"><span id="minutes-'.$val->order_id.'">00</span><div class="timeRefMinutes-'.$val->order_id.'">phút</div></div><div class="seconds-'.$val->order_id.'"><span id="seconds-'.$val->order_id.'">00</span><div class="timeRefSeconds-'.$val->order_id.'">giây</div></div></div>';*/

                          $xhtml .="</td>";
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';   
            }
             $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->appends($request->all())->links()->toHtml();
            }
         }

         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'check_new_order' => self::checkNewOrder(),
         ];

      return $result;
  }

  //Đơn hàng đã thu tiền employee
  public static function listOrderPending2($request){
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;

    if (access()->hasPermission('manager-all-order')) {
        $total2 = self::sum_total_order_2(1,'all');

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
    }else{
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

       if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total2 = self::sum_total_order_2(1);

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             
             ->where(function ($query) use ($request){
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order.order_type', 1)
             ->where('order.order_chef_do', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
        }else if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total2 = self::sum_total_order_2(1);

        $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,order.order_chef_do,order.updated_at,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->whereRaw("order.order_create_time >= ?", array($startTime))
             ->whereRaw("order.order_create_time <= ?", array($endTime))
             ->where(function($query) {
                 if (access()->hasPermission('quan-ly-tang-2')) {
                      $query->orWhere('order.room_id','=',2);
                  }
                 if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('order.room_id','=',3);
                 }
                 if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('order.room_id','=',4);
                 }
                 if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('order.room_id','=',5);
                 }
                 if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('order.room_id','=',6);
                 }
              })
             ->where(function ($query) use ($request){
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
              })
             ->where('order.order_status','=',1)
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'asc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
        }
    }
        // Order of employee
         if (!empty($data2)) {
          foreach ($data2 as $key2 => $value2) {
            $arr = array();
            $value2->product_name_group = explode(',', $value2->product_name_group);
            $value2->product_price_group = explode(',', $value2->product_price_group);
            $value2->product_qty_group = explode(',', $value2->product_qty_group);
            $value2->product_option_group = explode('|', $value2->product_option_group);
            if (!empty($value2->product_option_group)) {
              foreach ($value2->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value2->product_option_group[$k] = json_decode($v);
                  //$value2->cout_option = count($value2->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
               $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
               $value2->price = $arr;
               $value2->sumPrice = array_sum($value2->price);
            }  
          }
       }
        $xhtml2 = '';
        $pagi_link2 = '';
        if(!empty($data2)) { 
            foreach($data2 as $val2) {
              $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($val2->order_create_time);
                  $xhtml2 .="<tr class='orderItem' data-id='".$val2->order_id."' data-updated_at='".$diff."'><td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";
                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                         $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                         if (!empty($val2->product_option_group)) {
                          $xhtml2 .='<ul class="order-option">';
                        foreach ($val2->product_option_group[$i] as $k => $v) {
                          $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml2 .='</ul>';
                         }
                         $xhtml2 .= '</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml2 .='</td>';
                  $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                         $link = route('admin.order.status',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time,'order_chef_do'=>$val2->order_chef_do]);
                        if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";
                        }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a>';

                          $xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';

                          $xhtml2 .="</td>";
                        }
                        if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';*/

                          $xhtml2 .="</td>";

                        }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a>';

                          /*$xhtml2 .='<div class="countup countup-'.$val2->order_id.'"><div class="days-'.$val2->order_id.' hide"><span id="days-'.$val2->order_id.'">00</span><div class="timeRefDays-'.$val2->order_id.'">ngày</div></div><div class="hours-'.$val2->order_id.'"><span id="hours-'.$val2->order_id.'">00</span><div class="timeRefHours-'.$val2->order_id.'">giờ</div></div><div class="minutes-'.$val2->order_id.'"><span id="minutes-'.$val2->order_id.'">00</span><div class="timeRefMinutes-'.$val2->order_id.'">phút</div></div><div class="seconds-'.$val2->order_id.'"><span id="seconds-'.$val2->order_id.'">00</span><div class="timeRefSeconds-'.$val2->order_id.'">giây</div></div></div>';*/

                          $xhtml2 .="</td>";
                        }
                        if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml2 .= '</tr>';   
            }
             $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total2,0,",",".").'</td></tr>';
            if ($data2->hasMorePages() || !empty($request->page)) {
              $pagi_link2 = $data2->setPath('getAjaxListPending2')->appends($request->all())->toHtml();
            }
         }

         $result = array();
         $result =[
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
          //'check_new_order' => self::checkNewOrder(),
         ];

      return $result;
  }
  //Đơn hàng đã hoàn thành
  public static function listOrderDone($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;
     /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
        $startTime = date("Y-m-d 07:00:00");
        $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
     }else{
        $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
        $endTime = date("Y-m-d 08:30:00");
     }*/
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

    if (access()->hasPermission('manager-all-order')) {
         $total = self::sum_total_order(3,'done');
         $total2 = self::sum_total_order_2(3,'done');
         $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->orWhere(function ($query) use ($request){                
                    if ($request->table_search != '') {
                          $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                          $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                      }
                  })
               ->where('order.order_status','=',3)
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
               ->paginate($page_num);

        $data2 = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->orWhere(function ($query) use ($request){                
                    if ($request->table_search_2 != '') {
                          $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                          $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search_2.'%');
                      }
                  })
               ->where('order.order_status','=',3)
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
               ->paginate($page_num);
    }else{
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(3);
          $total2 = self::sum_total_order_2(3);
          $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->whereRaw("order.order_create_time >= ?", array($startTime))
                 ->whereRaw("order.order_create_time <= ?", array($endTime))
                 ->where(function($query) {
                     if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                     }
                     if (access()->hasPermission('quan-ly-tang-3')) {
                        $query->orWhere('order.room_id','=',3);
                     }
                     if (access()->hasPermission('quan-ly-tang-4')) {
                        $query->orWhere('order.room_id','=',4);
                     }
                     if (access()->hasPermission('quan-ly-tang-5')) {
                        $query->orWhere('order.room_id','=',5);
                     }
                     if (access()->hasPermission('quan-ly-tang-6')) {
                        $query->orWhere('order.room_id','=',6);
                     }
                  })
                 ->where(function ($query) use ($request){                
                      if ($request->table_search != '' ) {
                         if (!is_numeric($request->table_search)) {
                            $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                         }else{
                            $query->where('order.order_id', '=', trim($request->table_search));
                         }     
                      }
                  })
                 ->where('order.order_status','=',3)
                 ->where('order_type', 0)
                 ->orderBy('order.order_id', 'desc')
                 ->groupBy("order.order_id")
                 ->paginate($page_num);

          //Order for employee
          $data2 = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->whereRaw("order.order_create_time >= ?", array($startTime))
                 ->whereRaw("order.order_create_time <= ?", array($endTime))
                 ->where(function($query) {
                     if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                     }
                     if (access()->hasPermission('quan-ly-tang-3')) {
                        $query->orWhere('order.room_id','=',3);
                     }
                     if (access()->hasPermission('quan-ly-tang-4')) {
                        $query->orWhere('order.room_id','=',4);
                     }
                     if (access()->hasPermission('quan-ly-tang-5')) {
                        $query->orWhere('order.room_id','=',5);
                     }
                     if (access()->hasPermission('quan-ly-tang-6')) {
                        $query->orWhere('order.room_id','=',6);
                     }
                  })
                 ->where(function ($query) use ($request){                
                      if ($request->table_search_2 != '' ) {
                         if (!is_numeric($request->table_search_2)) {
                            $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                         }else{
                            $query->where('order.order_id', '=', trim($request->table_search_2));
                         }     
                      }
                  })
                 ->where('order.order_status','=',3)
                 ->where('order_type', 1)
                 ->orderBy('order.order_id', 'desc')
                 ->groupBy("order.order_id")
                 ->paginate($page_num);
                 //echo '<pre>'; print_r($data2);die;
      }
    }

     if (!empty($data)) {
        foreach ($data as $key => $value) {
          $arr = array();
          $value->product_name_group = explode(',', $value->product_name_group);
          $value->product_price_group = explode(',', $value->product_price_group);
          $value->product_qty_group = explode(',', $value->product_qty_group);
          $value->product_option_group = explode('|', $value->product_option_group);
          if (!empty($value->product_option_group)) {
            foreach ($value->product_option_group as $k => $v) {
              if (!empty($v)) {
                $value->product_option_group[$k] = json_decode($v);
                //$value->cout_option = count($value->product_option_group[$k]);
              }
            }
          }
          for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
             $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
             $value->price = $arr;
             $value->sumPrice = array_sum($value->price);
          }  
        }
     }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) {
            foreach($data as $val) {
                  $xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                    
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDone1')->appends($request->all())->links()->toHtml();
            }
    
         }

      //Order for employee
      if (!empty($data2)) {
        foreach ($data2 as $key2 => $value2) {
          $arr = array();
          $value2->product_name_group = explode(',', $value2->product_name_group);
          $value2->product_price_group = explode(',', $value2->product_price_group);
          $value2->product_qty_group = explode(',', $value2->product_qty_group);
          $value2->product_option_group = explode('|', $value2->product_option_group);
          if (!empty($value2->product_option_group)) {
            foreach ($value2->product_option_group as $k => $v) {
              if (!empty($v)) {
                $value2->product_option_group[$k] = json_decode($v);
                //$value2->cout_option = count($value2->product_option_group[$k]);
              }
            }
          }
          for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
             $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
             $value2->price = $arr;
             $value2->sumPrice = array_sum($value2->price);
          }  
        }
     }
    $xhtml2 = '';
    $pagi_link2 = '';
    if(!empty($data2)) {
      foreach($data2 as $val2) {
          $xhtml2 .="<tr>";
                  $xhtml2 .="<td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";
                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row">';
                      $xhtml2 .= '<div class="col-sm-5">&nbsp;</div>';
                      $xhtml2 .= '<div class="col-sm-2">Số lượng</div>';
                      $xhtml2 .= '<div class="col-sm-2">Đơn giá</div>';
                      $xhtml2 .= '<div class="col-sm-2">Thành tiền</div>';
                  $xhtml2 .= '</div>';
               for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                 $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                 if (!empty($val2->product_option_group)) {
                  $xhtml2 .='<ul class="order-option">';
                foreach ($val2->product_option_group[$i] as $k => $v) {
                  $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                }                           
                  $xhtml2 .='</ul>';
                 }
                 $xhtml2 .= '</div>';
                 $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                 $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                 $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
               }
                $xhtml2 .='</td>';
          $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
          $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                $link = route('admin.order.status',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time]);
                if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                }
                if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                }
                if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val2->room_id,'id'=>$val2->order_id]).'" class="label-success print">print</a></td>';
                }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val2->room_id,'id'=>$val2->order_id]).'" class="label-success print">print</a></td>';
                }
                if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                }
                if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                  $xhtml2 .="<td>";
                  $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                }
        
           $xhtml2 .= '</tr>';
            
    }
    $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total2,0,",",".").'</td></tr>';
    if ($data2->hasMorePages() || !empty($request->page)) {
      $pagi_link2 = $data2->setPath('getAjaxListDone2')->appends($request->all())->links()->toHtml();
    }

 }
         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
          //'check_new_order' => self::checkNewOrder(),
          'total'=> $total,
          'total2'=> $total2,
         ];

      return $result;
  }

  //Đơn hàng đã hoàn thành
  public static function listOrderDone1($request){
    if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->page) $page = $request->page; else $page = 1;

        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

    if (access()->hasPermission('manager-all-order')) {
         $total = self::sum_total_order(3,'done');
         $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->orWhere(function ($query) use ($request){                
                    if ($request->table_search != '') {
                          $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                          $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                      }
                  })
               ->where('order.order_status','=',3)
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
               ->paginate($page_num);
    }else{
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order(3);
          $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->whereRaw("order.order_create_time >= ?", array($startTime))
                 ->whereRaw("order.order_create_time <= ?", array($endTime))
                 ->where(function($query) {
                     if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                     }
                     if (access()->hasPermission('quan-ly-tang-3')) {
                        $query->orWhere('order.room_id','=',3);
                     }
                     if (access()->hasPermission('quan-ly-tang-4')) {
                        $query->orWhere('order.room_id','=',4);
                     }
                     if (access()->hasPermission('quan-ly-tang-5')) {
                        $query->orWhere('order.room_id','=',5);
                     }
                     if (access()->hasPermission('quan-ly-tang-6')) {
                        $query->orWhere('order.room_id','=',6);
                     }
                  })
                 ->where(function ($query) use ($request){                
                      if ($request->table_search != '' ) {
                         if (!is_numeric($request->table_search)) {
                            $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                         }else{
                            $query->where('order.order_id', '=', trim($request->table_search));
                         }     
                      }
                  })
                 ->where('order.order_status','=',3)
                 ->where('order_type', 0)
                 ->orderBy('order.order_id', 'desc')
                 ->groupBy("order.order_id")
                 ->paginate($page_num);
      }
    }

     if (!empty($data)) {
        foreach ($data as $key => $value) {
          $arr = array();
          $value->product_name_group = explode(',', $value->product_name_group);
          $value->product_price_group = explode(',', $value->product_price_group);
          $value->product_qty_group = explode(',', $value->product_qty_group);
          $value->product_option_group = explode('|', $value->product_option_group);
          if (!empty($value->product_option_group)) {
            foreach ($value->product_option_group as $k => $v) {
              if (!empty($v)) {
                $value->product_option_group[$k] = json_decode($v);
              }
            }
          }
          for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
             $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
             $value->price = $arr;
             $value->sumPrice = array_sum($value->price);
          }  
        }
     }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) {
            foreach($data as $val) {
                  $xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                    
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDone1')->appends($request->all())->links()->toHtml();
            }
    
         }
         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'check_new_order' => self::checkNewOrder(),
          'total'=> $total,
         ];

      return $result;
  }

  //Đơn hàng đã hoàn thành
  public static function listOrderDone2($request){
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

    if (access()->hasPermission('manager-all-order')) {
         $total = self::sum_total_order_2(3,'done');
         $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->orWhere(function ($query) use ($request){                
                    if ($request->table_search_2 != '') {
                          $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                          $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search_2.'%');
                      }
                  })
               ->where('order.order_status','=',3)
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
               ->paginate($page_num2);
    }else{
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
          $total = self::sum_total_order_2(3);
          $data = DB::table("order")
                 ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
                 ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
                 ->whereRaw("order.order_create_time >= ?", array($startTime))
                 ->whereRaw("order.order_create_time <= ?", array($endTime))
                 ->where(function($query) {
                     if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                     }
                     if (access()->hasPermission('quan-ly-tang-3')) {
                        $query->orWhere('order.room_id','=',3);
                     }
                     if (access()->hasPermission('quan-ly-tang-4')) {
                        $query->orWhere('order.room_id','=',4);
                     }
                     if (access()->hasPermission('quan-ly-tang-5')) {
                        $query->orWhere('order.room_id','=',5);
                     }
                     if (access()->hasPermission('quan-ly-tang-6')) {
                        $query->orWhere('order.room_id','=',6);
                     }
                  })
                 ->where(function ($query) use ($request){                
                      if ($request->table_search_2 != '' ) {
                         if (!is_numeric($request->table_search_2)) {
                            $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                         }else{
                            $query->where('order.order_id', '=', trim($request->table_search_2));
                         }     
                      }
                  })
                 ->where('order.order_status','=',3)
                 ->where('order_type', 1)
                 ->orderBy('order.order_id', 'desc')
                 ->groupBy("order.order_id")
                 ->paginate($page_num2);
      }
    }

     if (!empty($data)) {
        foreach ($data as $key => $value) {
          $arr = array();
          $value->product_name_group = explode(',', $value->product_name_group);
          $value->product_price_group = explode(',', $value->product_price_group);
          $value->product_qty_group = explode(',', $value->product_qty_group);
          $value->product_option_group = explode('|', $value->product_option_group);
          if (!empty($value->product_option_group)) {
            foreach ($value->product_option_group as $k => $v) {
              if (!empty($v)) {
                $value->product_option_group[$k] = json_decode($v);
              }
            }
          }
          for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
             $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
             $value->price = $arr;
             $value->sumPrice = array_sum($value->price);
          }  
        }
     }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) {
            foreach($data as $val) {
                  $xhtml .="<tr>";
                  $xhtml .="<td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row">';
                      $xhtml .= '<div class="col-sm-5">&nbsp;</div>';
                      $xhtml .= '<div class="col-sm-2">Số lượng</div>';
                      $xhtml .= '<div class="col-sm-2">Đơn giá</div>';
                      $xhtml .= '<div class="col-sm-2">Thành tiền</div>';
                  $xhtml .= '</div>';
                   for($i = 0 ; $i < count($val->product_name_group); $i++) {
                     $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                     if (!empty($val->product_option_group)) {
                        $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                        $xhtml .='</ul>';
                     }
                     $xhtml .= '</div>';
                     $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                     $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                     $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div>';
                     $xhtml .= '</div>';
                   }
                $xhtml .='</td>';
          $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a><a href="'.route('order.print',['room_id'=>$val->room_id,'id'=>$val->order_id]).'" class="label-success print">print</a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                    
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDone2')->appends($request->all())->links()->toHtml();
            }
    
         }
         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'check_new_order' => self::checkNewOrder(),
          'total'=> $total,
         ];

      return $result;
  }
  //Đơn hàng đã hủy
  public static function listOrderDestroy($request){
       if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;
       if (access()->hasPermission('manager-all-order')) {
          $total = self::sum_total_order_destroy('destroy');
          $total2 = self::sum_total_order_destroy_2('destroy');
          $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){  
                if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
                if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                }  
              }) 
             ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
             })
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'desc')
             ->groupBy("order.order_id")
             ->paginate($page_num);

             $data2 = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){  
                if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
                if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                }  
              }) 
             ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
             })
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'desc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
      }else{
          if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
             $total = self::sum_total_order_destroy();
             $total2 = self::sum_total_order_destroy_2();
             /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
                $startTime = date("Y-m-d 07:00:00");
                $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
             }else{
                $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
                $endTime = date("Y-m-d 08:30:00");
             }*/
              $schedule = self::getAllSchedule();
              $startCa1 = $schedule[0]->time_start;
              $endCa3 = $schedule[count($schedule)-1]->time_end;

             if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
                $startTime = date('Y-m-d '.$startCa1);
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
             }else{
                $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
             }

             $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                  if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }

                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
                  if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                  }
                })
               ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
                })
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
             ->paginate($page_num);

           $data2 = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                  if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }

                })
               ->where(function ($query) use ($request){
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
                  if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                  }
                })
               ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
                })
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
             ->paginate($page_num2);
           }
      }
       if (!empty($data)) {
          foreach ($data as $key => $value) {
            $arr = array();
            $value->product_name_group = explode(',', $value->product_name_group);
            $value->product_price_group = explode(',', $value->product_price_group);
            $value->product_qty_group = explode(',', $value->product_qty_group);
            $value->product_option_group = explode('|', $value->product_option_group);
            if (!empty($value->product_option_group)) {
              foreach ($value->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value->product_option_group[$k] = json_decode($v);
                  //$value->cout_option = count($value->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
               $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
               $value->price = $arr;
               $value->sumPrice = array_sum($value->price);
            }  
          }
       }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->message_destroy.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                   
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDestroy1')->appends($request->all())->links()->toHtml();
            }
         }

         if (!empty($data2)) {
          foreach ($data2 as $key2 => $value2) {
            $arr = array();
            $value2->product_name_group = explode(',', $value2->product_name_group);
            $value2->product_price_group = explode(',', $value2->product_price_group);
            $value2->product_qty_group = explode(',', $value2->product_qty_group);
            $value2->product_option_group = explode('|', $value2->product_option_group);
            if (!empty($value2->product_option_group)) {
              foreach ($value2->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value2->product_option_group[$k] = json_decode($v);
                  //$value2->cout_option = count($value2->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value2->product_qty_group) ; $i++) {
               $arr[$i] = $value2->product_price_group[$i] * $value2->product_qty_group[$i];
               $value2->price = $arr;
               $value2->sumPrice = array_sum($value2->price);
            }  
          }
       }
       $xhtml2 = '';
       $pagi_link2 = '';
       if(!empty($data2)) { 
            foreach($data2 as $val2) {
                  $xhtml2 .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val2->room_id."' data-time='".$val2->order_create_time."'  data-status='".$val2->order_status."' value='".$val2->order_id."'></td>";
                  $xhtml2 .= "<td>".$val2->order_id."</td><td>".$val2->client_name."</td>";
                  $xhtml2 .= "<td>".date("d-m-Y H:i:s",strtotime($val2->order_create_time)) ."</td>";
                  $xhtml2 .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val2->product_name_group); $i++) {
                         $xhtml2 .='<div class="row"><div class="col-sm-5">'. $val2->product_name_group[$i];
                         if (!empty($val2->product_option_group)) {
                          $xhtml2 .='<ul class="order-option">';
                        foreach ($val2->product_option_group[$i] as $k => $v) {
                          $xhtml2 .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml2 .='</ul>';
                         }
                         $xhtml2 .= '</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. $val2->product_qty_group[$i] .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml2 .= '<div class="col-sm-2">'. number_format($val2->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml2 .='</td>';
                  $xhtml2 .='<td>'.number_format($val2->sumPrice,0,",",".").'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->order_notice.'</td>';
                  $xhtml2 .='<td style="max-width:150px;min-width: 80px;">'.$val2->message_destroy.'</td>';
                        $link = route('admin.order.status2',['order_id'=>$val2->order_id,'order_status'=>$val2->order_status,'room_id'=>$val2->room_id,'order_time'=>$val2->order_create_time]);
                        if($val2->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val2->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val2->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val2->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val2->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val2->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val2->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val2->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val2->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val2->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val2->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml2 .="<td>";
                          $xhtml2 .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml2 .= '</tr>';
                   
            }
            $xhtml2 .='<tr><td></td><td></td><td></td><td></td><td colspan="2" class="text-right"><strong>Tổng tiền hiện tại: </strong> '. number_format($total2,0,",",".").'</td></tr>';
            if ($data2->hasMorePages() || !empty($request->page)) {
              $pagi_link2 = $data2->setPath('getAjaxListDestroy2')->appends($request->all())->links()->toHtml();
            }
         }

         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          'html2' => $xhtml2,
          'pagi2' => $pagi_link2,
          //'check_new_order' => false,
          'total' => $total,
          'total2' => $total2,
         ];

      return $result;
  }

  //Đơn hàng đã hủy
  public static function listOrderDestroy1($request){ 
       if($request->pnum) $page_num = $request->pnum; else $page_num = 5;
    if($request->page) $page = $request->page; else $page = 1;
       if (access()->hasPermission('manager-all-order')) {
          $total = self::sum_total_order_destroy('destroy');
          $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){  
                if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
                if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                }  
              }) 
             ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
             })
             ->where('order_type', 0)
             ->orderBy('order.order_id', 'desc')
             ->groupBy("order.order_id")
             ->paginate($page_num);
      }else{
          if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
             $total = self::sum_total_order_destroy();
             /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
                $startTime = date("Y-m-d 07:00:00");
                $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
             }else{
                $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
                $endTime = date("Y-m-d 08:30:00");
             }*/
              $schedule = self::getAllSchedule();
              $startCa1 = $schedule[0]->time_start;
              $endCa3 = $schedule[count($schedule)-1]->time_end;

             if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
                $startTime = date('Y-m-d '.$startCa1);
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
             }else{
                $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
             }

             $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                  if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }

                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search != '' ) {
                     if (!is_numeric($request->table_search)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search));
                     }     
                  }
                  if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                  }
                })
               ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
                })
               ->where('order_type', 0)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
             ->paginate($page_num);
           }
      }
       if (!empty($data)) {
          foreach ($data as $key => $value) {
            $arr = array();
            $value->product_name_group = explode(',', $value->product_name_group);
            $value->product_price_group = explode(',', $value->product_price_group);
            $value->product_qty_group = explode(',', $value->product_qty_group);
            $value->product_option_group = explode('|', $value->product_option_group);
            if (!empty($value->product_option_group)) {
              foreach ($value->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value->product_option_group[$k] = json_decode($v);
                  //$value->cout_option = count($value->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
               $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
               $value->price = $arr;
               $value->sumPrice = array_sum($value->price);
            }  
          }
       }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->message_destroy.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                   
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td></td><td><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDestroy1')->appends($request->all())->links()->toHtml();
            }
        
            
         }
         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'check_new_order' => false,
          'total' => $total,
         ];

      return $result;
  }

  //Đơn hàng đã hủy
  public static function listOrderDestroy2($request){ 
       if($request->pnum2) $page_num2 = $request->pnum2; else $page_num2 = 5;
    if($request->page) $page = $request->page; else $page = 1;
       if (access()->hasPermission('manager-all-order')) {
          $total = self::sum_total_order_destroy_2('destroy');
          $data = DB::table("order")
             ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
             ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
             ->where(function ($query) use ($request){  
                if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
                if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                }  
              }) 
             ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
             })
             ->where('order_type', 1)
             ->orderBy('order.order_id', 'desc')
             ->groupBy("order.order_id")
             ->paginate($page_num2);
      }else{
          if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){
              $total = self::sum_total_order_destroy_2();
              $schedule = self::getAllSchedule();
              $startCa1 = $schedule[0]->time_start;
              $endCa3 = $schedule[count($schedule)-1]->time_end;

             if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
                $startTime = date('Y-m-d '.$startCa1);
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
             }else{
                $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
                $endTime = date('Y-m-d '.$endCa3);
                $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
             }

             $data = DB::table("order")
               ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
               ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room_id,order.message_destroy,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
               ->whereRaw("order.order_create_time >= ?", array($startTime))
               ->whereRaw("order.order_create_time <= ?", array($endTime))
               ->where(function($query) {
                   if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('order.room_id','=',2);
                    }
                   if (access()->hasPermission('quan-ly-tang-3')) {
                      $query->orWhere('order.room_id','=',3);
                   }
                   if (access()->hasPermission('quan-ly-tang-4')) {
                      $query->orWhere('order.room_id','=',4);
                   }
                   if (access()->hasPermission('quan-ly-tang-5')) {
                      $query->orWhere('order.room_id','=',5);
                   }
                  if (access()->hasPermission('quan-ly-tang-6')) {
                      $query->orWhere('order.room_id','=',6);
                   }

                })
               ->where(function ($query) use ($request){                
                  if ($request->table_search_2 != '' ) {
                     if (!is_numeric($request->table_search_2)) {
                        $query->where('order.client_name', 'LIKE', '%'.$request->table_search_2.'%');
                     }else{
                        $query->where('order.order_id', '=', trim($request->table_search_2));
                     }     
                  }
                  if ($request->sdate != '') {
                    $sdate = DateTime::createFromFormat('d-m-Y', $request->sdate);
                    $sdate =  $sdate->format('Y-m-d');
                    $query->whereRaw("DATE(order.order_create_time) = ?", array($sdate));
                  }
                })
               ->where(function($query){
                 $query->orWhere('order.order_status','=',4);
                 $query->orWhere('order.order_status','=',5);
                })
               ->where('order_type', 1)
               ->orderBy('order.order_id', 'desc')
               ->groupBy("order.order_id")
             ->paginate($page_num2);
           }
      }
       if (!empty($data)) {
          foreach ($data as $key => $value) {
            $arr = array();
            $value->product_name_group = explode(',', $value->product_name_group);
            $value->product_price_group = explode(',', $value->product_price_group);
            $value->product_qty_group = explode(',', $value->product_qty_group);
            $value->product_option_group = explode('|', $value->product_option_group);
            if (!empty($value->product_option_group)) {
              foreach ($value->product_option_group as $k => $v) {
                if (!empty($v)) {
                  $value->product_option_group[$k] = json_decode($v);
                  //$value->cout_option = count($value->product_option_group[$k]);
                }
              }
            }
            for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
               $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
               $value->price = $arr;
               $value->sumPrice = array_sum($value->price);
            }  
          }
       }
       $xhtml = '';
       $pagi_link = '';
       if(!empty($data)) {
            foreach($data as $val) {
                  $xhtml .="<tr><td><input type='checkbox' name='order_id[]' data-room='".$val->room_id."' data-time='".$val->order_create_time."'  data-status='".$val->order_status."' value='".$val->order_id."'></td>";
                  $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-5">&nbsp;</div><div class="col-sm-2">Số lượng</div><div class="col-sm-2">Đơn giá</div><div class="col-sm-2">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                         $xhtml .='<div class="row"><div class="col-sm-5">'. $val->product_name_group[$i];
                         if (!empty($val->product_option_group)) {
                          $xhtml .='<ul class="order-option">';
                        foreach ($val->product_option_group[$i] as $k => $v) {
                          $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                        }                           
                          $xhtml .='</ul>';
                         }
                         $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-2">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-2">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->order_notice.'</td>';
                  $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->message_destroy.'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status,'room_id'=>$val->room_id,'order_time'=>$val->order_create_time]);
                        if($val->order_status == 1 && access()->hasPermission('access-status-money')) { 
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }elseif($val->order_status == 1 && !access()->hasPermission('access-status-money')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-warning">Đang xử lý</span></a></td>';
                        }
                        if($val->order_status == 2 && access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }elseif($val->order_status == 2 && !access()->hasPermission('access-status-finish')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã thu tiền</span></a></td>';
                        }
                        if($val->order_status == 3 && access()->hasPermission('access-done-destroy')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }elseif ($val->order_status == 3 && !access()->hasPermission('access-done-destroy')) {
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-success">Đã hoàn thành</span></a></td>';
                        }
                        if($val->order_status == 4 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy</span></a></td>';
                        }elseif($val->order_status == 4 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy</span></a></td>';
                        }
                        if($val->order_status == 5 && access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:ajaxStatus2Approved(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }elseif($val->order_status == 5 && !access()->hasPermission('access-status-pending')){
                          $xhtml .="<td>";
                          $xhtml .='<a href="javascript:void(0)"><span class="label label-danger">Đã hủy(Hoàn trả)</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
                   
            }
            $xhtml .='<tr><td></td><td></td><td></td><td></td><td></td><td><strong>Tổng tiền hiện tại: </strong> '. number_format($total,0,",",".").'</td></tr>';
            if ($data->hasMorePages() || !empty($request->page)) {
              $pagi_link = $data->setPath('getAjaxListDestroy2')->appends($request->all())->links()->toHtml();
            }
        
            
         }
         $result = array();
         $result =[
          'html' => $xhtml,
          'pagi' => $pagi_link,
          //'check_new_order' => false,
          'total' => $total,
         ];

      return $result;
  }

  public static function sum_total_combo_tk($order_status){
     if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){ 
          $total = 0;
          $order_date = date('Y-m-d');
          /*$startTime = date("Y-m-d 07:00:00");
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));*/
          $totalTK = DB::table("order_details")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->where([
                ['order_status', '=', $order_status],
                ['order_details.category_id', '=', 27],
            ])
            /*->whereRaw("order.order_create_time >= ?", array($startTime))
            ->whereRaw("order.order_create_time <= ?", array($endTime))*/
            ->whereRaw("order.order_create_time = ?", array($order_date))
            ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                  $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
            ->where('order_type', 0)
            ->first();
            
          $totalCombo = DB::table("order_details")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->where([
                ['order_status', '=', $order_status],
                ['order_details.category_id', '=', 19],
            ])
            /*->whereRaw("order.order_create_time >= ?", array($startTime))
            ->whereRaw("order.order_create_time <= ?", array($endTime))*/
            ->whereRaw("DATE(order.order_create_time) = ?", array($order_date))
            ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                  $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
            ->where('order_type', 0)
            ->first();
            if (!empty($totalTK->priceTotalTK)) {
                $total = $totalTK->priceTotalTK;
            }
            if (!empty($totalCombo->priceTotalCB)) {
               $total =  $total + $totalCombo->priceTotalCB ;
            }
            return $total;
      }
  }
 
  //Tính tổng tiền theo trạng thái
  public static function sum_total_order($order_status,$option = null){
      $sumTotalAll = 0;
     /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
        $startTime = date("Y-m-d 07:00:00");
        $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
     }else{
        $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
        $endTime = date("Y-m-d 08:30:00");
     }*/
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

      if ($option == null) {
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){ 
          //$order_date = date('Y-m-d');
          $data = DB::table("order")
           ->select("order_price")
           ->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           //->whereRaw("DATE(order.order_create_time) = ?", array($order_date))
           ->where('order.order_status','=',$order_status)
           ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                    $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
           ->where('order_type', 0)
           ->get();
         }
      }else{
          $data = DB::table("order")
           ->select("order_price")
           /*->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))*/
           ->where('order.order_status','=',$order_status)
           ->where('order_type', 0)
           ->get();
      }
     if (!empty($data)) {
       // dd($data);
        foreach ($data as  $value) {      
          $sumTotalAll += $value->order_price;
        }  
      } 
      return $sumTotalAll;
  }

  //Tính tổng tiền theo trạng thái(order for employee)
  public static function sum_total_order_2($order_status,$option = null){
      $sumTotalAll = 0;
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

      if ($option == null) {
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){ 
          //$order_date = date('Y-m-d');
          $data = DB::table("order")
           ->select("order_price")
           ->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           //->whereRaw("DATE(order.order_create_time) = ?", array($order_date))
           ->where('order.order_status','=',$order_status)
           ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                    $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
           ->where('order_type', 1)
           ->get();
         }
      }else{
          $data = DB::table("order")
           ->select("order_price")
           /*->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))*/
           ->where('order.order_status','=',$order_status)
           ->where('order_type', 1)
           ->get();
      }
     if (!empty($data)) {
       // dd($data);
        foreach ($data as  $value) {      
          $sumTotalAll += $value->order_price;
        }  
      } 
      return $sumTotalAll;
  }

  //Tính tổng tiền theo trạng thái hủy
  public static function sum_total_order_destroy($option = null){
      $sumTotalAll = 0;
     /*if(strtotime(date('Y-m-d H:i:s')) > strtotime(date("Y-m-d 08:30:00"))){
        $startTime = date("Y-m-d 07:00:00");
        $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($startTime)));
     }else{
        $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d 07:00:00"))));
        $endTime = date("Y-m-d 08:30:00");
     }*/
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

      if ($option == null) {
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){ 
          //$order_date = date('Y-m-d');
          $data = DB::table("order")
           ->select("order_price")
           ->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           //->whereRaw("DATE(order.order_create_time) = ?", array($order_date))
           ->where(function($query) {
               $query->orwhere('order.order_status','=',4);
               $query->orwhere('order.order_status','=',5);
           })
           ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                    $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
           ->where('order_type', 0)
           ->get();
         }
      }else{
          $data = DB::table("order")
           ->select("order_price")
           ->where(function($query) {
               $query->orwhere('order.order_status','=',4);
               $query->orwhere('order.order_status','=',5);
           })
           ->where('order_type', 0)
           ->get();
      }
     if (!empty($data)) {
        foreach ($data as  $value) {      
          $sumTotalAll += $value->order_price;
        }  
      } 

      return $sumTotalAll;
  }

  //Tính tổng tiền theo trạng thái hủy
  public static function sum_total_order_destroy_2($option = null){
      $sumTotalAll = 0;
        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if( strtotime(date('Y-m-d H:i:s')) > strtotime('+1 hour +30 minutes',strtotime(date("Y-m-d ".$startCa1))) ){
          $startTime = date('Y-m-d '.$startCa1);
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 day +1 hour +30 minutes',strtotime($endTime)));
       }else{
          $startTime = date('Y-m-d H:i:s',strtotime('-1 day',strtotime(date("Y-m-d ".$startCa1))));
          $endTime = date('Y-m-d '.$endCa3);
          $endTime = date('Y-m-d H:i:s',strtotime('+1 hour +30 minutes',strtotime($endTime)));
       }

      if ($option == null) {
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){ 
          //$order_date = date('Y-m-d');
          $data = DB::table("order")
           ->select("order_price")
           ->whereRaw("order.order_create_time >= ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           //->whereRaw("DATE(order.order_create_time) = ?", array($order_date))
           ->where(function($query) {
               $query->orwhere('order.order_status','=',4);
               $query->orwhere('order.order_status','=',5);
           })
           ->where(function($query) {
               if (access()->hasPermission('quan-ly-tang-2')) {
                    $query->orWhere('order.room_id','=',2);
                }
               if (access()->hasPermission('quan-ly-tang-3')) {
                  $query->orWhere('order.room_id','=',3);
               }
               if (access()->hasPermission('quan-ly-tang-4')) {
                  $query->orWhere('order.room_id','=',4);
               }
               if (access()->hasPermission('quan-ly-tang-5')) {
                  $query->orWhere('order.room_id','=',5);
               }
               if (access()->hasPermission('quan-ly-tang-6')) {
                  $query->orWhere('order.room_id','=',6);
               }
            })
           ->where('order_type', 1)
           ->get();
         }
      }else{
          $data = DB::table("order")
           ->select("order_price")
           ->where(function($query) {
               $query->orwhere('order.order_status','=',4);
               $query->orwhere('order.order_status','=',5);
           })
           ->where('order_type', 1)
           ->get();
      }

     if (!empty($data)) {
        foreach ($data as  $value) {      
          $sumTotalAll += $value->order_price;
        }  
      } 
      return $sumTotalAll;
  }

  public static function printOrder($room_id,$order_id){
     $data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_notice,order.room,order.room_id,order.order_status,order.client_ip,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->where('order.order_id','=',$order_id)
           ->where('order.room_id','=',$room_id)
           ->where('order_type', 0)
           ->first();
       
      if (!empty($data)) {
          $data->product_name_group = explode(',', $data->product_name_group);
          $data->product_price_group = explode(',', $data->product_price_group);
          $data->product_qty_group = explode(',', $data->product_qty_group);
          $data->product_option_group = explode('|', $data->product_option_group);
          if (!empty($data->product_option_group)) {
            foreach ($data->product_option_group as $k => $v) {
              if (!empty($v)) {
                $data->product_option_group[$k] = json_decode($v);
                //$value->cout_option = count($value->product_option_group[$k]);
              }
            }
          }
          for($i = 0 ; $i < count($data->product_qty_group) ; $i++) {
             $arr[$i] = $data->product_price_group[$i] * $data->product_qty_group[$i];
             $data->price = $arr;
             $data->sumPrice = array_sum($data->price);
          } 
          
     }
     $array = json_decode(json_encode($data), true);
     return $array;
  }

  public static function getSchedule($case){
        return DB::table('scheduletime')
        ->where('id', '=', $case)
        ->first();
  }

  public static function getAllSchedule(){
      return DB::table('scheduletime')        
      ->get();
  }
}