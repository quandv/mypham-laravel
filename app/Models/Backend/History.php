<?php

namespace App\Models\Backend;
use DB;
use DateTime;
class History 
{
    //
    public static function getList($request){
      //$day_from = date('Y-m-d');
      if ($request->day_from != '') {
      	 $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
		 $day_from =  $day_from->format('Y-m-d');
      }
      if ($request->day_to != '') {
      	    $day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
		    $day_to = $day_to->format('Y-m-d');
	  }
		$data =  DB::table('history')
		    ->where('type_id','=',1)
			->where(function ($query) use ($request){
	            if ($request->user != '') {
	            	/*if(is_numeric($request->user)){
	                	$query->orWhere('user_id', '=',$request->user);
	            	}else{*/
	            		$query->orWhere('text', 'LIKE', '%'.trim($request->user).'%');
	            	//}
	            }
	         if ($request->day_from != '') {
	         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
		 			$day_from =  $day_from->format('Y-m-d');
	                $query->WhereRaw("DATE(created_at) >= ?", array($day_from));
	            } 

	            if ($request->day_to != ''){
	            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
		    		$day_to = $day_to->format('Y-m-d');
	                $query->WhereRaw("DATE(created_at) <= ?", array($day_to));
	            }  
	            /*if (!empty($request->day_from) && !empty($request->day_to)) {
	           		 $query->whereBetween('DATE(created_at)',[$day_from ,$day_to]);
	            }  */ 
	        })
	    	->orderBy('created_at', 'desc')
	    	->paginate(10);
	    	if (!empty($data)) {
	    		foreach ($data as $key => $value) {
	    			$value->list_order = json_decode($value->details_order_id,true);
	    			if (!empty($value->list_order)) {
	    				$arrayKeys = array_keys($value->list_order); 
	    				$value->status_changer = $value->list_order[$arrayKeys[0]]['status_changed'];
	    			}else{
	    				$value->status_changer = '';
	    			}
	    			
	    		}

	    	}
	    	//dd($data);
	    	$data->appends($request->all());
	    	return $data;

	}
	
	public static function getReport($request,$from = null,$to = null,$option = null){
		if ($option == null) {
			if ($from != null && $to != null) {
				$data =  DB::table('history')
				->join('history_details', 'history.id', '=', 'history_details.history_id')
				->selectRaw("history.*,GROUP_CONCAT(history_details.order_id SEPARATOR ',') as group_order_id,GROUP_CONCAT(history_details.order_status SEPARATOR ',') as group_order_status,GROUP_CONCAT(history_details.timestamp_process SEPARATOR ',') as group_timestamp_process")
				//->whereRaw("DATE(created_at) = '".$day."'")
				->whereRaw("history.created_at > '".$from."'")
	            ->whereRaw("history.created_at <= '".$to."'")
	            ->where('history.order_status','=',3)
	            ->where(function ($query) use ($request){
	            	if ($request->day_from != '') {
		         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
			 			$day_from =  $day_from->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) >= ?", array($day_from));
		            } 
		            if ($request->day_to != ''){
		            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
			    		$day_to = $day_to->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) <= ?", array($day_to));
		            }
		            if (empty($request->day_from) && empty($request->day_to)) {
		            	$query->whereRaw("DATE(history.created_at) = ?", array(date('Y-m-d')));
		            } 
		            if (!empty($request->tang)) {
		            	$query->where('history_details.room_id','=',$request->tang);
		            }   
	            })
		    	->orderBy('history.created_at', 'desc')
		    	->groupBy('history.id')
                ->paginate(10);

			}else{
				$data =  DB::table('history')
				->join('history_details', 'history.id', '=', 'history_details.history_id')
				->selectRaw("history.*,history_details.order_id,GROUP_CONCAT(history_details.order_id SEPARATOR ',') as group_order_id,GROUP_CONCAT(history_details.order_status SEPARATOR ',') as group_order_status,GROUP_CONCAT(history_details.timestamp_process SEPARATOR ',') as group_timestamp_process")
				//->whereRaw("DATE(created_at) = '".$day."'")
	            ->where('history.order_status','=',3)
	            ->where(function ($query) use ($request){
	            	if ($request->day_from != '') {
		         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
			 			$day_from =  $day_from->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) >= ?", array($day_from));
		            } 
		            if ($request->day_to != ''){
		            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
			    		$day_to = $day_to->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) <= ?", array($day_to));
		            } 
		            if (empty($request->day_from) && empty($request->day_to)) {
		            	$query->whereRaw("DATE(history.created_at) = ?", array(date('Y-m-d')));
		            }
		            if (!empty($request->tang)) {
		            	$query->where('history_details.room_id','=',$request->tang);
		            }
		            
	            })
		    	->orderBy('history.created_at', 'desc')
		    	->groupBy('history.id')
		    	->paginate(10);
			}
			if (!empty($data)) {	
		    	$data->appends($request->all());
		    	foreach ($data as $key => $value) {
		    		//$arr = array();
		    		$value->list_order = json_decode($value->details_order_id,true);
		    		/*$value->group_order_id = explode(',', $value->group_order_id);
		    		$value->group_order_status = explode(',', $value->group_order_status);
		    		$value->group_timestamp_process = explode(',', $value->group_timestamp_process);
		    		if (!empty($value->group_order_id)) {
			    		for ($i = 0; $i < count($value->group_order_id) ; $i++) { 
			    		  $arr[$key] = [
			    			'order_id'=> $value->group_order_id[$i],
			    			"order_status" => $value->group_order_status[$i],
				            "timestamp_process" => $value->group_timestamp_process[$i],
				    	  ];
				    	  //$value->list_order = $arr;
				    	}
			    	}*/

		    	}
		    }
		    return $data;

		}else{
			if ($from != null && $to != null) {
				$data =  DB::table('history')
				->join('history_details', 'history.id', '=', 'history_details.history_id')
				->selectRaw("SUM(time_process) as tong_time , SUM(qty_order) as tong_qty ")
				//->whereRaw("DATE(created_at) = '".$day."'")
				->whereRaw("history.created_at > '".$from."'")
	            ->whereRaw("history.created_at <= '".$to."'")
	            ->where('history.order_status','=',3)
	            ->where(function ($query) use ($request){
	            	if ($request->day_from != '') {
		         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
			 			$day_from =  $day_from->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) >= ?", array($day_from));
		            } 
		            if ($request->day_to != ''){
		            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
			    		$day_to = $day_to->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) <= ?", array($day_to));
		            } 
		            if (empty($request->day_from) && empty($request->day_to)) {
		            	$query->whereRaw("DATE(history.created_at) = ?", array(date('Y-m-d')));
		            }
		            if (!empty($request->tang)) {
		            	$query->where('history_details.room_id','=',$request->tang);
		            }
		            
	            })
		    	->orderBy('history.created_at', 'desc')
		    	->first();
			}else{
				$data =  DB::table('history')
				->join('history_details', 'history.id', '=', 'history_details.history_id')
				//->whereRaw("DATE(created_at) = '".$day."'")
				->selectRaw(" SUM(time_process) as tong_time , SUM(qty_order) as tong_qty ")
	            ->where('history.order_status','=',3)
	            ->where(function ($query) use ($request){
	            	if ($request->day_from != '') {
		         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
			 			$day_from =  $day_from->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) >= ?", array($day_from));
		            } 
		            if ($request->day_to != ''){
		            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
			    		$day_to = $day_to->format('Y-m-d');
		                $query->whereRaw("DATE(history.created_at) <= ?", array($day_to));
		            } 
		            if (empty($request->day_from) && empty($request->day_to)) {
		            	$query->whereRaw("DATE(history.created_at) = ?", array(date('Y-m-d')));
		            }
		            if (!empty($request->tang)) {
		            	$query->where('history_details.room_id','=',$request->tang);
		            }  
		            
	            })
		    	->orderBy('history.created_at', 'desc')
		    	->first();
			}
			return $data; 
		}
	}
    public static function getProductAll($request){
    	$data =  DB::table('history')
    	    ->where('type_id','>',2)
			->where(function ($query) use ($request){ 
	            if ($request->day_from != '') {
	         	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
		 			$day_from =  $day_from->format('Y-m-d');
	                $query->whereRaw("DATE(created_at) >= ?", array($day_from));
	            } 
	            if ($request->day_to != ''){
	            	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
		    		$day_to = $day_to->format('Y-m-d');
	                $query->whereRaw("DATE(created_at) <= ?", array($day_to));
	            } 
	            if ($request->select_type != '') {
	                $query->where('type_id','=',$request->select_type);
	            }  
	            if ($request->search_item != '') {
	              	if (is_numeric($request->search_item)) {
	              		$query->where('entity_id','=',$request->search_item);
	              	}else{
	              		$query->where('entity_name','like', '%'.trim($request->search_item).'%');
	              	}
	            } 
	            if ($request->user_item != '') {
	              	if (is_numeric($request->user_item)) {
	              		$query->where('user_id','=',$request->user_item);
	              	}else{
	              		//if (preg_match("/\@+/",$request->user_item)) {
	              		if (strpos($request->user_item,"@") !== false) {
	              			$query->where('email','like', '%'. trim($request->user_item).'%');
	              		}else{
                            $query->where('name','like', '%'. trim($request->user_item) .'%');
	              		}		          		 
	              	}
	            }   
	        })
	    	->orderBy('created_at', 'desc')//->toSql();
	    	->paginate(10);
	    	if (!empty($data)) {
	    		foreach ($data as $key => $value) {
	    		    $value->entity_option = json_decode($value->entity_option,true);			
	    		}
	    	}
	       return $data;
    }
	//get history (update status product)
	public static function getStsProduct($request){
		return DB::table('history')
		->select('text', 'order_status', 'created_at', 'updated_at', 'email', 'name')
	    ->where('type_id','=',2)
	    ->where(function ($query) use ($request){
	    	if ($request->day_from != '') {
	     	    $day_from = DateTime::createFromFormat('d-m-Y', $request->day_from);
	 			$day_from =  $day_from->format('Y-m-d');
	            $query->whereRaw("DATE(history.created_at) >= ?", array($day_from));
	        } 
	        if ($request->day_to != ''){
	        	$day_to = DateTime::createFromFormat('d-m-Y', $request->day_to);
	    		$day_to = $day_to->format('Y-m-d');
	            $query->whereRaw("DATE(history.created_at) <= ?", array($day_to));
	        }	        
	        if (isset($request->input_status) && $request->input_status != '') {
	        	$query->where('order_status', '=', $request->input_status);
	        }
	        
	    })
	    ->where(function ($query) use ($request){
	    	if (($request->input_search)) {
	        	$query->where('email', 'like', '%'.$request->input_search.'%');
	        	$query->orWhere('name', 'like', '%'.$request->input_search.'%');
	        }
	    })
		->orderBy('created_at', 'desc')
		->paginate(10);
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
