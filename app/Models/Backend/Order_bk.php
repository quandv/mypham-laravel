<?php
namespace App\Models\Backend;
use DB;
use HtmlString;
class Order 
{
	
	public static function listOrder($request){
		$data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->orWhere(function ($query) use ($request){          	    
           		if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
           	})
           ->orderBy('order.order_id', 'desc')
           ->groupBy("order.order_id")
	       ->paginate(5);
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
	       		$data->appends($request->all());
	       }
	         //
	     $xhtml = '';
	     $pagi_link = '';
	     $check_new_order = false;
	     if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .= "<tr><td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-3">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ol class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ol>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-3">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status]);
                        if($val->order_status == 1) {	
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Pendding</span></a></td>';
                        }
                        if($val->order_status == 2){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Approved</span></a></td>';
                        }
                        if($val->order_status == 3){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Finish</span></a></td>';
                        }
                        /*else{
                        	$xhtml .='<td><span class="label label-success">Approved</span></td>';
                        }   */    
                
                   $xhtml .= '</tr>';
            }
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->links()->toHtml();
            }
            if (isset($data->neworder) && !empty($data->neworder)) {
            	$check_new_order = true;
            }
            
         }
         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
         	'check_new_order' =>$check_new_order
         ];

	    return $result;
	}
	public static function ajaxStatus($order_id,$order_status){
		if ($order_status == 1) {
			$status = 2 ;
		}
		if ($order_status == 2) {
			$status = 3 ;
		}
		if ($order_status == 3) {
			$status = 1 ;
		}
		DB::table('order')->where('order_id',$order_id)->update(['order_status'=>$status]);
		$result = array(
			'order_id'  => (int)$order_id, 
			'order_status'	=> $status, 
			'link'		=> route('admin.order.status',['order_id'=>$order_id,'order_status'=>$status])
		); 
		return $result;
		
	}
	public static function listOrderApproved($request){
		$data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->where('order.order_status','=',2)
           ->orWhere(function ($query) use ($request){          	    
           		if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
           	})
           ->orderBy('order.order_id', 'asc')
           ->groupBy("order.order_id")
	       ->paginate(5);
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
	       		$data->appends($request->all());
	       }

	     $xhtml = '';
	     $pagi_link = '';
	     $check_new_order = false;
	     if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .= "<tr><td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-3">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ol class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ol>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-3">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status]);
                        if($val->order_status == 1) {	
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Pendding</span></a></td>';
                        }
                        if($val->order_status == 2){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Approved</span></a></td>';
                        }
                        if($val->order_status == 3){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Finish</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
            }
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->links()->toHtml();
            }
             if (isset($data->neworder) && !empty($data->neworder)) {
            	$check_new_order = true;
            }
            
         }
         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
         	'check_new_order' =>$check_new_order
         ];

	    return $result;
	}
	public static function listOrderPending($request){
		$data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->where('order.order_status','=',1)
           ->orWhere(function ($query) use ($request){          	    
           		if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
           	})
           ->orderBy('order.order_id', 'asc')
           ->groupBy("order.order_id")
	       ->paginate(5);
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
	       		$data->appends($request->all());
	       }
	     $xhtml = '';
	     $pagi_link = '';
	     $check_new_order = false;
	     if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .= "<tr><td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-3">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ol class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ol>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-3">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                        $link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status]);
                        if($val->order_status == 1) {	
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Pendding</span></a></td>';
                        }
                        if($val->order_status == 2){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Approved</span></a></td>';
                        }
                        if($val->order_status == 3){
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-success">Finish</span></a></td>';
                        }
                
                   $xhtml .= '</tr>';
            }
            if ($data->hasMorePages() || !empty($request->page)) {
            	$pagi_link = $data->links()->toHtml();
            }
            if (isset($data->neworder) && !empty($data->neworder)) {
            	$check_new_order = true;
            }
            
         }
         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
         	'check_new_order' =>$check_new_order
         ];

	    return $result;
	}
	public static function listOrder2($request){
		$data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id')
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
           ->orWhere(function ($query) use ($request){
           		if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
           	})
           ->orderBy('order.order_id', 'desc')
           ->groupBy("order.order_id")
	       ->paginate(5);
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
	       		$data->appends($request->all());
	       }
	     $xhtml = '';
	     $pagi_link = '';
	     if(!empty($data)) { 
            foreach($data as $val) {
                  $xhtml .= "<tr><td>".$val->order_id."</td><td>".$val->client_name."</td>";
                  $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                  $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                       for($i = 0 ; $i < count($val->product_name_group); $i++) {
                       	 $xhtml .='<div class="row"><div class="col-sm-3">'. $val->product_name_group[$i];
                       	 if (!empty($val->product_option_group)) {
                       	 	$xhtml .='<ol class="order-option">';
                   	 		foreach ($val->product_option_group[$i] as $k => $v) {
                   	 			$xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')</li>';
                   	 		}		                     	 	
                       	 	$xhtml .='</ol>';
                       	 }
                       	 $xhtml .= '</div>';
                         $xhtml .= '<div class="col-sm-3">'. $val->product_qty_group[$i] .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->product_price_group[$i],0,",",".") .'</div>';
                         $xhtml .= '<div class="col-sm-3">'. number_format($val->price[$i],0,",",".") .'</div></div>';
                       }
                        $xhtml .='</td>';
                  $xhtml .='<td>'.number_format($val->sumPrice,0,",",".").'</td>';
                        if($val->order_status == 1) {
                        	$link = route('admin.order.status',['order_id'=>$val->order_id,'order_status'=>$val->order_status]);
                        	$xhtml .="<td>";
                        	$xhtml .='<a href="javascript:ajaxStatus(\''.$link.'\')" id="change-status-'.$val->order_id.'"><span class="label label-warning">Pendding</span></a></td>';
                        }else{
                        	$xhtml .='<td><span class="label label-success">Approved</span></td>';
                        }       
                
                   $xhtml .= '</tr>';
            }
            if ($data->hasMorePages()) {	
            	$pagi_link = $data->links()->toHtml();
            }
            
         }
         $result = array();
         $result =[
         	'html' => $xhtml,
         	'pagi' => $pagi_link,
         ];

	    return $result;
	}
	public static function listOrder3(){
		$data = DB::table("order")
           ->join('order_details', 'order.order_id', '=', 'order_details.order_id') 
           ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group")
           ->groupBy("order.order_id")
	       ->paginate(10);
	       if (!empty($data)) {
	       		foreach ($data as $key => $value) {
	       			$arr = array();
	       			$value->product_name_group = explode(',', $value->product_name_group);
	       			$value->product_price_group = explode(',', $value->product_price_group);
	       			$value->product_qty_group = explode(',', $value->product_qty_group);
	       			for($i = 0 ; $i < count($value->product_qty_group) ; $i++) {
	       				 $arr[$i] = $value->product_price_group[$i] * $value->product_qty_group[$i];
	       				 $value->price = $arr;
	       			}  
	       		}
	       }
	    return $data;
	}
}