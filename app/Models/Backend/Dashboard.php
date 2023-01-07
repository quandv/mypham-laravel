<?php 
namespace App\Models\Backend;
use DB;
use DateTime;

class Dashboard{
  public static function sum_total_combo_tk($from = null,$to = null,$request){
     if (access()->hasPermission('dashboard')){

        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

        if(empty($request->day)) {
            $startTime = date('Y-m-d '.$startCa1);
            $endTime = date('Y-m-d '.$endCa3);
            $endTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));            
        }else{
            $startTime = date('Y-m-d '.$startCa1,strtotime($request->day));
            $endTime = date('Y-m-d '.$endCa3,strtotime($request->day));
            $endTime =  date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));
        }
                
        if ($from !=null && $to !=null ) {	                
          $totalTK = DB::table("order_details")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("order_details.category_id,order.room_id,SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->where([
                ['order_status', '=', 3],
                //['order.room_id','=', $tang],
                ['order_details.category_id', '=', 27],
                ['order_type', '=', 0],
            ]) 
            ->whereRaw("order.order_create_time > ?", array($startTime))
            ->whereRaw("order.order_create_time <= ?", array($endTime))
            ->whereRaw("order.order_create_time > ?",array($from))
            ->whereRaw("order.order_create_time <= ?",array($to))
            ->groupBy('order.room_id')
            ->get();
                  
          $totalCombo = DB::table("order_details")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("order_details.category_id,order.room_id,SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->where([
                ['order_status', '=', 3],
                //['order.room_id','=', $tang],
                ['order_details.category_id', '=', 19],
                ['order_type', '=', 0],
            ])
            ->whereRaw("order.order_create_time > ?", array($startTime))
            ->whereRaw("order.order_create_time <= ?", array($endTime))
            ->whereRaw("order.order_create_time > ?",array($from))
            ->whereRaw("order.order_create_time <= ?",array($to))
            ->groupBy('order.room_id')
            ->get();              
         }else{
	          $totalTK = DB::table("order_details")
	            ->join('order', 'order_details.order_id', '=', 'order.order_id')
	            ->selectRaw("order_details.category_id,order.room_id,SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
	            ->where([
	                ['order_status', '=', 3],
	                //['order.room_id','=', $tang],
	                ['order_details.category_id', '=', 27],
                  ['order_type', '=', 0],
	            ])
	            ->whereRaw("order.order_create_time > ?", array($startTime))
              ->whereRaw("order.order_create_time <= ?", array($endTime))
              ->groupBy('order.room_id')
              ->get();
  
	          $totalCombo = DB::table("order_details")
	            ->join('order', 'order_details.order_id', '=', 'order.order_id')
	            ->selectRaw("order_details.category_id,order.room_id,SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
	            ->where([
	                ['order_status', '=', 3],
	                //['order_status,order.room_id','=', $tang],
	                ['order_details.category_id', '=', 19],
                  ['order_type', '=', 0],
	            ])
	            ->whereRaw("order.order_create_time > ?", array($startTime))
              ->whereRaw("order.order_create_time <= ?", array($endTime))
              ->groupBy('order.room_id')->get();
        }
        $sorted = collect();
        $sortCombo = collect();
        if(!empty($totalTK)){
          $sorted = $totalTK->sortBy(function ($value, $key) {
            return $value->room_id;
          });

          /* $totalTK  = $totalTK->toArray();
          $totalTK = array_values(array_sort($totalTK, function ($value) {
              return $value->room_id;
          }));*/ 
        }
        if(!empty($totalCombo)){
          $sortCombo = $totalCombo->sortBy(function ($value, $key) {
             return $value->room_id;
          });
        }
        $merged = $sorted->merge($sortCombo);
        $grouped = $merged->groupBy('room_id');
        $arr = array();  //
        foreach ($grouped  as $key => $value) {
            if ($key == 2) {
               if (!empty($value)) {
                  foreach ($value as $k => $v) {
                      if (isset($v->priceTotalTK)) {
                         $arr[2]['totalTk'] = $v->priceTotalTK;
                    }else{
                       if (!isset($arr[2]['totalTk'])) {
                          $arr[2]['totalTk'] = 0;
                       }
                    }
                    if (isset($v->priceTotalCB)) {
                         $arr[2]['totalCB'] = $v->priceTotalCB;
                    }else{
                       if (!isset($arr[2]['totalCB'])) {
                          $arr[2]['totalCB'] = 0;
                       }
                    }
                  }
               }
                
            }
           if ($key == 3) {
               if (!empty($value)) {
                  foreach ($value as $k => $v) {
                    if (isset($v->priceTotalTK)) {
                         $arr[3]['totalTk'] = $v->priceTotalTK;
                    }else{
                       if (!isset($arr[3]['totalTk'])) {
                          $arr[3]['totalTk'] = 0;
                       }
                    }
                    if (isset($v->priceTotalCB)) {
                         $arr[3]['totalCB'] = $v->priceTotalCB;
                    }else{
                       if (!isset($arr[3]['totalCB'])) {
                          $arr[3]['totalCB'] = 0;
                       }
                    }
                  }
               }
                
            }
            if ($key == 4) {
               if (!empty($value)) {
                  foreach ($value as $k => $v) {
                    if (isset($v->priceTotalTK)) {
                         $arr[4]['totalTk'] = $v->priceTotalTK;
                    }else{
                       if (!isset($arr[4]['totalTk'])) {
                          $arr[4]['totalTk'] = 0;
                       }
                    }
                    if (isset($v->priceTotalCB)) {
                         $arr[4]['totalCB'] = $v->priceTotalCB;
                    }else{
                       if (!isset($arr[4]['totalCB'])) {
                          $arr[4]['totalCB'] = 0;
                       }
                    }
                    
                  }
               }
                
            }
            if ($key == 5) {
               if (!empty($value)) {
                  foreach ($value as $k => $v) {
                      if (isset($v->priceTotalTK)) {
                         $arr[5]['totalTk'] = $v->priceTotalTK;
                    }else{
                       if (!isset($arr[5]['totalTk'])) {
                          $arr[5]['totalTk'] = 0;
                       }
                    }
                    if (isset($v->priceTotalCB)) {
                         $arr[5]['totalCB'] = $v->priceTotalCB;
                    }else{
                       if (!isset($arr[5]['totalCB'])) {
                          $arr[5]['totalCB'] = 0;
                       }
                    }
                  }
               }
                
            }
            if ($key == 6) {
               if (!empty($value)) {
                  foreach ($value as $k => $v) {
                      if (isset($v->priceTotalTK)) {
                         $arr[6]['totalTk'] = $v->priceTotalTK;
                    }else{
                       if (!isset($arr[6]['totalTk'])) {
                          $arr[6]['totalTk'] = 0;
                       }
                    }
                    if (isset($v->priceTotalCB)) {
                         $arr[6]['totalCB'] = $v->priceTotalCB;
                    }else{
                       if (!isset($arr[6]['totalCB'])) {
                          $arr[6]['totalCB'] = 0;
                       }
                    }
                  }
               }
                
            }
            
        }  
        return $arr; 
      }
  }
 
  //Tính tổng tiền theo trạng thái
 public static function sum_total_order($from = null,$to = null,$request){
        $collec_Combo_TK = self::sum_total_combo_tk($from,$to ,$request);
        $sumTotalAll = 0;

        $schedule = self::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

       if (access()->hasPermission('dashboard')){
          if(empty($request->day)) {
            $startTime = date('Y-m-d '.$startCa1);
            $endTime = date('Y-m-d '.$endCa3);
            $endTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));
          }else{
            $startTime = date('Y-m-d '.$startCa1,strtotime($request->day));
            $endTime = date('Y-m-d '.$endCa3,strtotime($request->day));
            $endTime =  date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));
          }
          if ($from != null && $to !=null ) {


            $data = DB::table("order")
           ->selectRaw("order.room_id,order.order_status,SUM(order_price) as toTalAll , count(order_status) as toTalStatus")
           ->whereRaw("order.order_create_time > ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           ->whereRaw("order.order_create_time > ?",array($from))
           ->whereRaw("order.order_create_time <= ?",array($to))
           ->where('order_type', 0)
           ->groupBy('order.order_status')
           ->groupBy('order.room_id')->get();
          }else{
            $data = DB::table("order")
           ->selectRaw("order.room_id,order.order_status,SUM(order_price) as toTalAll , count(order_status) as toTalStatus")
           ->whereRaw("order.order_create_time > ?", array($startTime))
           ->whereRaw("order.order_create_time <= ?", array($endTime))
           //->where('order.order_status','=',$order_status)
           //->where('order.room_id','=',$tang)
           ->where('order_type', 0)
           ->groupBy('order.order_status')
           ->groupBy('order.room_id')->get();
          }            
     }

     $arr = array(); 

     if (!empty($data)) {
        $grouped = $data->groupBy('room_id'); 

        foreach ($grouped as $key => $value) {
          if ($key == 2) {
               if (!empty($value)) {
                  foreach ($value as $v) {
                    if ($v->order_status == 1) {
                        $arr[2][1] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[2][1])) {
                           $arr[2][1] = 0;
                        }     
                    }
                    if ($v->order_status == 2) {
                        $arr[2][2] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[2][2])) {
                           $arr[2][2] = 0;
                        } 
                    }
                    if ($v->order_status == 3) {
                        $arr[2][3] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[2][3])) {
                           $arr[2][3] = 0;
                        } 
                    }
                    if ($v->order_status == 4) {
                        $arr[2][4] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[2][4])) {
                           $arr[2][4] = 0;
                        } 
                    }
                    if ($v->order_status == 5) {
                        $arr[2][5] =  $v->toTalAll;
                    }
                    else{
                        if (!isset($arr[2][5])) {
                           $arr[2][5] = 0;
                        } 
                    }
                  }  
               }
              $arr[2]['totalCB'] = isset($collec_Combo_TK[2]['totalCB']) ? $collec_Combo_TK[2]['totalCB'] : 0;
              $arr[2]['totalTk'] = isset($collec_Combo_TK[2]['totalTk']) ? $collec_Combo_TK[2]['totalTk'] : 0;

           }
           if ($key == 3) {

               if (!empty($value)) {
                  foreach ($value as $v) {
                    if ($v->order_status == 1) {
                        $arr[3][1] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[3][1])) {
                           $arr[3][1] = 0;
                        }     
                    }
                    if ($v->order_status == 2) {
                        $arr[3][2] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[3][2])) {
                           $arr[3][2] = 0;
                        } 
                    }
                    if ($v->order_status == 3) {
                        $arr[3][3] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[3][3])) {
                           $arr[3][3] = 0;
                        } 
                    }
                    if ($v->order_status == 4) {
                        $arr[3][4] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[3][4])) {
                           $arr[3][4] = 0;
                        } 
                    }
                    if ($v->order_status == 5) {
                        $arr[3][5] =  $v->toTalAll;
                    }
                    else{
                        if (!isset($arr[3][5])) {
                           $arr[3][5] = 0;
                        } 
                    }
                 } 
               }
              $arr[3]['totalCB'] = isset($collec_Combo_TK[3]['totalCB']) ? $collec_Combo_TK[3]['totalCB'] : 0;
              $arr[3]['totalTk'] = isset($collec_Combo_TK[3]['totalTk']) ? $collec_Combo_TK[3]['totalTk'] : 0;

           }
           if ($key == 4 ) {
               if (!empty($value)) {
                  foreach ($value as $v) {
                    if ($v->order_status == 1) {
                        $arr[4][1] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[4][1])) {
                           $arr[4][1] = 0;
                        }     
                    }
                    if ($v->order_status == 2) {
                        $arr[4][2] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[4][2])) {
                           $arr[4][2] = 0;
                        } 
                    }
                    if ($v->order_status == 3) {
                        $arr[4][3] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[4][3])) {
                           $arr[4][3] = 0;
                        } 
                    }
                    if ($v->order_status == 4) {
                        $arr[4][4] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[4][4])) {
                           $arr[4][4] = 0;
                        } 
                    }
                    if ($v->order_status == 5) {
                        $arr[4][5] =  $v->toTalAll;
                    }
                    else{
                        if (!isset($arr[4][5])) {
                           $arr[4][5] = 0;
                        } 
                    }
               }
             }
              $arr[4]['totalCB'] = isset($collec_Combo_TK[4]['totalCB']) ? $collec_Combo_TK[4]['totalCB'] : 0;
              $arr[4]['totalTk'] = isset($collec_Combo_TK[4]['totalTk']) ? $collec_Combo_TK[4]['totalTk'] : 0;

           }
           if ($key == 5 ) {
               if (!empty($value)) {
                  foreach ($value as $v) {
                    if ($v->order_status == 1) {
                        $arr[5][1] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[5][1])) {
                           $arr[5][1] = 0;
                        }     
                    }
                    if ($v->order_status == 2) {
                        $arr[5][2] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[5][2])) {
                           $arr[5][2] = 0;
                        } 
                    }
                    if ($v->order_status == 3) {
                        $arr[5][3] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[5][3])) {
                           $arr[5][3] = 0;
                        } 
                    }
                    if ($v->order_status == 4) {
                        $arr[5][4] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[5][4])) {
                           $arr[5][4] = 0;
                        } 
                    }
                    if ($v->order_status == 5) {
                        $arr[5][5] =  $v->toTalAll;
                    }
                    else{
                        if (!isset($arr[5][5])) {
                           $arr[5][5] = 0;
                        } 
                    }
                    
                  }  
               }
              $arr[5]['totalCB'] = isset($collec_Combo_TK[5]['totalCB']) ? $collec_Combo_TK[5]['totalCB'] : 0;
              $arr[5]['totalTk'] = isset($collec_Combo_TK[5]['totalTk']) ? $collec_Combo_TK[5]['totalTk'] : 0;

           }
            if ($key == 6 ) {
               if (!empty($value)) {
                  foreach ($value as $v) {
                    if ($v->order_status == 1) {
                        $arr[6][1] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[6][1])) {
                           $arr[6][1] = 0;
                        }     
                    }
                    if ($v->order_status == 2) {
                        $arr[6][2] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[6][2])) {
                           $arr[6][2] = 0;
                        } 
                    }
                    if ($v->order_status == 3) {
                        $arr[6][3] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[6][3])) {
                           $arr[6][3] = 0;
                        } 
                    }
                    if ($v->order_status == 4) {
                        $arr[6][4] =  $v->toTalAll;
                    }else{
                        if (!isset($arr[6][4])) {
                           $arr[6][4] = 0;
                        } 
                    }
                    if ($v->order_status == 5) {
                        $arr[6][5] =  $v->toTalAll;
                    }
                    else{
                        if (!isset($arr[6][5])) {
                           $arr[6][5] = 0;
                        } 
                    }
                    
                  }
               }
              $arr[6]['totalCB'] = isset($collec_Combo_TK[6]['totalCB']) ? $collec_Combo_TK[6]['totalCB'] : 0;
              $arr[6]['totalTk'] = isset($collec_Combo_TK[6]['totalTk']) ? $collec_Combo_TK[6]['totalTk'] : 0;


         }
      }
   }

   ksort($arr);

    $startTime2 = date('Y-m-d '.$startCa1);
    $endTime2 = date('Y-m-d '.$endCa3);
    $endTime2 = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime2)));
    
    $data2 = DB::table("order")
    ->selectRaw("HOUR(order.order_create_time) as hour,SUM(order_price) as toTalAll")
    ->whereRaw("order.order_create_time > ?", array($startTime2))
    ->whereRaw("order.order_create_time <= ?", array($endTime2))
    ->where("order.order_status",3)
    ->where("order.order_type",0)
    ->groupBy(DB::raw("HOUR(order.order_create_time)"))
    ->get();
    return array(
        'data' => $data,
        'data2' => $data2,
        'r_display' => $arr,
    );
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

  //Chart - Doanh thu theo ngày
  public static function sumTotalForDay($day, $startCa1, $endCa3){
    if (access()->hasPermission('dashboard')){
      if(empty($day)) {
        $startTime = date('Y-m-d '.$startCa1);
        $endTime = date('Y-m-d '.$endCa3);
        $endTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));
      }else{
        $startTime = date('Y-m-d '.$startCa1,strtotime($day));
        $endTime = date('Y-m-d '.$endCa3,strtotime($day));
        $endTime =  date('Y-m-d H:i:s',strtotime('+1 day',strtotime($endTime)));
      }
      
      $data = DB::table("order")
      ->selectRaw("HOUR(order.order_create_time) as hour,SUM(order_price) as toTalAll")
      ->whereRaw("order.order_create_time > ?", array($startTime))
      ->whereRaw("order.order_create_time <= ?", array($endTime))
      ->where("order.order_status",3)
      ->where("order.order_type",0)
      ->groupBy(DB::raw("HOUR(order.order_create_time)"))
      ->get();
    }
    return $data;
  }

  //Chart - Doanh thu theo tháng
  public static function sumTotalForMonth($month,$year){
    if (access()->hasPermission('dashboard')){
      $schedule = self::getAllSchedule();
      $startCa1 = $schedule[0]->time_start;
      $endCa3 = $schedule[count($schedule)-1]->time_end;

      if($month == 12){
        $startTime = $year.'-'.$month.'-1 '.$startCa1;
        $endTime = ($year+1).'-1-1 '.$endCa3;
      }else{
        $startTime = $year.'-'.$month.'-1 '.$startCa1;
        $endTime = $year.'-'.($month+1).'-1 '.$endCa3;
      }

      $data = DB::table("order")
      ->selectRaw("DATE(order.order_create_time) as dateTime,DAY(order.order_create_time) as day,MONTH(order.order_create_time) as month,YEAR(order.order_create_time) as year,SUM(order_price) as toTalAll")
      ->whereRaw("order.order_create_time > ?", array($startTime))
      ->whereRaw("order.order_create_time <= ?", array($endTime))
      ->where("order.order_status",3)
      ->where("order.order_type",0)
      ->groupBy(DB::raw("DATE(order.order_create_time)"))
      ->get();

      $data2 = DB::table("order")
      ->selectRaw("DATE(order.order_create_time) as dateTime,DAY(order.order_create_time) as day,MONTH(order.order_create_time) as month,YEAR(order.order_create_time) as year,SUM(order_price) as toTalAll")
      ->whereRaw("order.order_create_time > ?", array($startTime))
      ->whereRaw("order.order_create_time <= ?", array($endTime))
      ->whereRaw("TIME(order.order_create_time) > '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")
      ->where("order.order_status",3)
      ->where("order.order_type",0)
      ->groupBy(DB::raw("DATE(order.order_create_time)"))
      ->get();

    }
    $result = array(
        'data' => $data,
        'data2' => $data2
      );
    return $result;
  }

  //Chart - Doanh thu theo năm
  public static function sumTotalForYear($year){
    if (access()->hasPermission('dashboard')){
      $schedule = self::getAllSchedule();
      $startCa1 = $schedule[0]->time_start;
      $endCa3 = $schedule[count($schedule)-1]->time_end;

      $startTime = $year.'-1-1 '.$startCa1;
      $endTime = ($year+1).'-1-1 '.$endCa3;

      $data = DB::table("order")
      ->selectRaw("DATE(order.order_create_time) as dateTime,DAY(order.order_create_time) as day,MONTH(order.order_create_time) as month,YEAR(order.order_create_time) as year,SUM(order_price) as toTalAll")
      ->whereRaw("order.order_create_time > ?", array($startTime))
      ->whereRaw("order.order_create_time <= ?", array($endTime))
      ->where("order.order_status",3)
      ->where("order.order_type",0)
      ->groupBy(DB::raw("MONTH(order.order_create_time)"))
      ->get();

      $data2 = DB::table("order")
      ->selectRaw("DATE(order.order_create_time) as dateTime,DAY(order.order_create_time) as day,MONTH(order.order_create_time) as month,YEAR(order.order_create_time) as year,SUM(order_price) as toTalAll")
      ->whereRaw("order.order_create_time > ?", array($startTime))
      ->whereRaw("order.order_create_time <= ?", array($endTime))
      ->whereRaw("TIME(order.order_create_time) > '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."' AND DAY(order.order_create_time) = '1'")
      ->where("order.order_status",3)
      ->where("order.order_type",0)
      ->groupBy(DB::raw("MONTH(order.order_create_time)"))
      ->get();
    }
    $result = array(
        'data' => $data,
        'data2' => $data2
      );
    return $result;
  }
} 