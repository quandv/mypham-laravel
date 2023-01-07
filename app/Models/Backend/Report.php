<?php
namespace App\Models\Backend;
use DB;
use HtmlString;
use Auth;
class Report 
{
    
    public static function listDayOrder($day, $from=null,$to=null,$order_status=0){
        $dataResult = array();
        if( $from !=null && $to !=null ){
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0) {
                    $query->where('order_status', '=', $order_status);
                }
            })
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')->get();
            //->toSql();dd($data);
           // ->paginate(10);

            $total = DB::table("order")
            ->selectRaw("order_price")
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")            
            ->get();

            //total success
            $totalSuccess = DB::table("order")
            ->select("order_price")
            ->where('order_status', '=', 3)
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->get();

            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->first();

            //total combo
            $totalCombo = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 19],
            ])
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->first();
        }else{
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")           
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0) {
                    $query->where('order_status', '=', $order_status);
                }
            })
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')->get();
            //->paginate(10);

            $total = DB::table("order")
            ->selectRaw("order_price")
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->get();

            //total success
            $totalSuccess = DB::table("order")
            ->selectRaw("order_price")
            ->where('order_status', '=', 3)
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->get();

            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->first();

            //total combo
            $totalCombo = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 19],
            ])
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")            
            ->first();
        }        
        if (!empty($data)) {
            foreach ($data as $key => $value) {                
                $option = explode('|', $value->product_option_group);
                if (!empty($option)) {
                    foreach ($option as $k => $v) {
                        if (!empty($v)) {
                            $option[$k] = json_decode($v);
                            //$value->cout_option = count($value->product_option_group[$k]);
                        }
                    }
                }
                $data[$key]->option = $option;

                $product_name_group = explode(',', $value->product_name_group);
                $data[$key]->name_group = $product_name_group;

                $product_price_group = explode(',', $value->product_price_group);
                $data[$key]->price_group = $product_price_group;

                $product_qty_group = explode(',', $value->product_qty_group);
                $data[$key]->qty_group = $product_qty_group;
            }
            $sumCountAll = count($total);
            $sumTotalAll = 0;
            foreach($total as $totalPrice){
                $sumTotalAll += $totalPrice->order_price;
            }
            $sumCountSuccess = count($totalSuccess);
            $sumTotalSuccess = 0;
            foreach($totalSuccess as $totalSuccessPrice){
                $sumTotalSuccess = $sumTotalSuccess + $totalSuccessPrice->order_price;
            }
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['sumCountAll'] = $sumCountAll;
            $dataResult['sumTotalAll'] = $sumTotalAll;
            $dataResult['sumCountSuccess'] = $sumCountSuccess;
            $dataResult['sumTotalSuccess'] = $sumTotalSuccess;

            if(empty($totalTK) || $totalTK->priceTotalTK == null){
                $dataResult['totalTK'] = 0;
            }else{
                $dataResult['totalTK'] = $totalTK->priceTotalTK;
            }
            if(empty($totalCombo)){
                $dataResult['totalCombo'] = 0;
            }else{
                $dataResult['totalCombo'] = $totalCombo->priceTotalCB;
            }
        }else{
            $dataResult['status'] = false;
        }
        //dd($dataResult);
        return $dataResult;     
    }

    public static function listMonthOrder($year, $month, $startMonth, $endMonth){
        $dataResult = array();
        $data = DB::table("order")
        ->selectRaw("DAY(order.order_create_time) as day, COUNT(order_id) as sumCount, COUNT(IF(order_status = 1, 1, NULL)) as sumWait, COUNT(IF(order_status = 2, 1, NULL)) as sumPay, COUNT(IF(order_status = 3, 1, NULL)) as sumFinish, 
            COUNT(IF(order_status = 4, 1, NULL)) as sumCancel, SUM(IF(order_status = 3, order_price, 0)) as sumFinishPrice, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, SUM(order_price) as sumTotal")
        ->whereRaw("YEAR(order.order_create_time) = $year")
        ->whereRaw("MONTH(order.order_create_time) = $month")
        ->groupBy(DB::raw("DAY(order.order_create_time)"))
        ->get();

        //total nạp tài khoản
        $totalTK = DB::table("order_details")
        //->join('order_details', 'product.product_id', '=', 'order_details.product_id')
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("YEAR(order.order_create_time) = $year")
        ->whereRaw("MONTH(order.order_create_time) = $month")
        ->selectRaw("DAY(order.order_create_time) as order_day, SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        //total combo
        $totalCombo = DB::table("order_details")
        //->leftJoin('order_details', 'product.product_id', '=', 'order_details.product_id')
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("YEAR(order.order_create_time) = $year")
        ->whereRaw("MONTH(order.order_create_time) = $month")
        ->selectRaw("DAY(order.order_create_time) as order_day, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        if (!empty($data)) {
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['taikhoan'] = $totalTK;
            $dataResult['combo'] = $totalCombo;
        }else{
            $dataResult['status'] = false;
        }
        return $dataResult;     
    }

    public static function listYearOrder($year){
        $dataResult = array();
        $data = DB::table("order")
        ->selectRaw("MONTH(order.order_create_time) as month, COUNT(order_id) as sumCount, COUNT(IF(order_status = 1, 1, NULL)) as sumWait, COUNT(IF(order_status = 2, 1, NULL)) as sumPay, COUNT(IF(order_status = 3, 1, NULL)) as sumFinish, 
            COUNT(IF(order_status = 4, 1, NULL)) as sumCancel, SUM(IF(order_status = 3, order_price, 0)) as sumFinishPrice, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, SUM(order_price) as sumTotal")
        ->whereRaw("YEAR(order.order_create_time) = $year")
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total nạp tài khoản
        $totalTK = DB::table("order_details")
        //->join('order_details', 'product.product_id', '=', 'order_details.product_id')
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("YEAR(order.order_create_time) = $year")
        //->selectRaw("order_details.product_price, order_details.product_quantity")
        ->selectRaw("MONTH(order.order_create_time) as order_month, SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();


        //total combo
        $totalCombo = DB::table("order_details")
        //->leftJoin('order_details', 'product.product_id', '=', 'order_details.product_id')
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("YEAR(order.order_create_time) = $year")
        //->selectRaw("order_details.product_price, order_details.product_quantity")
        ->selectRaw("MONTH(order.order_create_time) as order_month, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        if (!empty($data)) {
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['taikhoan'] = $totalTK;
            $dataResult['combo'] = $totalCombo;
        }else{
            $dataResult['status'] = false;
        }
        return $dataResult;     
    }
    
    public static function reportCategory($from=null, $to=null){
        if($from!=null&&$to!=null){
            $from = strtotime($from);
            $to = strtotime($to);
            $from = date('Y-m-d',$from);
            $to = date('Y-m-d',$to);
            
            $listOder = DB::table("order")
            ->join('order_details', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("order_details.product_name, order_details.product_id, order_details.order_id, order.order_create_time,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group, GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group, GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group, SUM(order_details.product_quantity) as qtyTotal, SUM(order_details.product_price*order_details.product_quantity) as priceTotal")
            ->where('order.order_status', '=', '3')
            ->whereRaw("DATE(order.order_create_time) >='".$from."'")
            ->whereRaw("DATE(order.order_create_time) <= '".$to."'")
            ->groupBy('order_details.product_id')
            ->orderBy('qtyTotal', 'desc')
            ->get();

            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
            ->whereRaw("DATE(order.order_create_time) >='".$from."'")
            ->whereRaw("DATE(order.order_create_time) <= '".$to."'")
            ->first();

            //total combo
            $totalCombo = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 19],
            ])
            ->whereRaw("DATE(order.order_create_time) >='".$from."'")
            ->whereRaw("DATE(order.order_create_time) <= '".$to."'")        
            ->first();
        }else{
            $listOder = DB::table("order")
            ->join('order_details', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("order_details.product_name, order_details.product_id, order_details.order_id, order.order_create_time,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group, GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group, GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group, SUM(order_details.product_quantity) as qtyTotal, SUM(order_details.product_price*order_details.product_quantity) as priceTotal")
            ->where('order.order_status', '=', '3')
            ->groupBy('order_details.product_id')
            ->orderBy('qtyTotal', 'desc')
            ->get();
            //->toSql();dd($listOder);
            
            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
            ->first();

            //total combo
            $totalCombo = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 19],
            ])      
            ->first();
        }

        $dataResult = array();

        $listProduct = DB::table("category")
        ->leftJoin('product', 'category.category_id', '=', 'product.category_id')
        ->select('category.category_name', 'product.product_id', 'product.product_price')
        ->where('category.category_id_parent', '!=', '0')
        ->get();

        $optionTotalPrice = 0;
        $totalPrice = 0;
        $options = array();
        $options2 = array();

        foreach($listOder as $k => $order){
            $totalPrice += $order->priceTotal;

            if( $order->product_qty_group != null ){
                $product_qty_group = explode(',', $order->product_qty_group);
                $listOder[$k]->product_qty_group = array_sum($product_qty_group);
            }else{
                $listOder[$k]->product_qty_group = 0;
            }

            //process option
            if( $order->product_option_group != null /*&& !empty(json_decode($order->product_option_group))*/ ){
                $product_option_group = explode('|', $order->product_option_group);

                foreach($product_option_group as $key => $value){
                    $option = json_decode($value);
                    
                    if(!empty($option)){
                        $options[] = $option;
                        foreach($option as $k => $v){
                            $optionTotalPrice += $v['2'] * $v['3'];
                        }
                    }
                }
            }            
        }
        
        foreach ($options as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if( array_key_exists($value2[0],$options2) ){
                    $options2[$value2[0]]['qty'] += $value2[3];
                }else{
                    $options2[$value2[0]] = array(
                        'name'  => $value2[1],
                        'price' => $value2[2],
                        'qty'   => $value2[3]
                    );
                }
            }
        }

        $listOption = array_values(array_sort($options2, function ($value) {
            return $value['qty'];
        }));
        krsort($listOption);

        $dataResult['listOption'] = $listOption;
        $dataResult['totalPrice'] = $totalPrice;
        $dataResult['optionTotalPrice'] = $optionTotalPrice;
        $dataResult['listProduct'] = $listProduct;
        $dataResult['listOder'] = $listOder;
        if(empty($totalTK) || $totalTK->priceTotalTK == null){
            $dataResult['totalTK'] = 0;
        }else{
            $dataResult['totalTK'] = $totalTK->priceTotalTK;
        }
        if(empty($totalCombo)){
            $dataResult['totalCombo'] = 0;
        }else{
            $dataResult['totalCombo'] = $totalCombo->priceTotalCB;
        }

        return $dataResult;     
    }
    public static function listDayOrderForExport($day, $from=null,$to=null){
        $day = implode('-', $day);       
        $dataResult = array();
        if( $from !=null && $to !=null ){
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group, GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            /*->orWhere(function ($query) use ($request){
                if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
            })*/

            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) >= $from")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) <= $to")
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            //->toSql();dd($data);
            ->paginate(10);

            $total = DB::table("order")
            ->selectRaw("order_price")
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) >= $from")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) <= $to")
            ->get();

            //total success
            $totalSuccess = DB::table("order")
            ->select("order_price")
            ->where('order_status', '=', 3)
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) >= $from")
            ->whereRaw("UNIX_TIMESTAMP(order.order_create_time) <= $to")
            ->get();

        }else{
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            /*->orWhere(function ($query) use ($request){
                if ($request->table_search != '') {
                    $query->orWhere('order.client_name', 'LIKE', '%'.$request->table_search.'%');
                    $query->orWhere('order.order_id', 'LIKE', '%'.$request->table_search.'%');
                }
            })*/

            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            //->toSql();dd($data);
            ->paginate(10);

            $total = DB::table("order")
            ->selectRaw("order_price")
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            ->get();

            //total success
            $totalSuccess = DB::table("order")
            ->selectRaw("order_price")
            ->where('order_status', '=', 3)
            ->whereRaw("DATE(order.order_create_time) = '".$day."'")
            //->toSql();dd($totalSuccess);
            ->get();
        }
        
    
        if (!empty($data)) {
            foreach ($data as $key => $value) {                
                $option = explode('|', $value->product_option_group);
                if (!empty($option)) {
                    foreach ($option as $k => $v) {
                        if (!empty($v)) {
                            $option[$k] = json_decode($v);
                            //$value->cout_option = count($value->product_option_group[$k]);
                        }
                    }
                }
                $data[$key]->option = $option;

                $product_name_group = explode(',', $value->product_name_group);
                $data[$key]->name_group = $product_name_group;

                $product_price_group = explode(',', $value->product_price_group);
                $data[$key]->price_group = $product_price_group;

                $product_qty_group = explode(',', $value->product_qty_group);
                $data[$key]->qty_group = $product_qty_group;
            }
            $sumCountAll = count($total);
            $sumTotalAll = 0;
            foreach($total as $totalPrice){
                $sumTotalAll += $totalPrice->order_price;
            }
            $sumCountSuccess = count($totalSuccess);
            $sumTotalSuccess = 0;
            foreach($totalSuccess as $totalSuccessPrice){
                $sumTotalSuccess += $totalSuccessPrice->order_price;
            }
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['sumCountAll'] = $sumCountAll;
            $dataResult['sumTotalAll'] = $sumTotalAll;
            $dataResult['sumCountSuccess'] = $sumCountSuccess;
            $dataResult['sumTotalSuccess'] = $sumTotalSuccess;
        }else{
            $dataResult['status'] = false;
        }
        //echo '<pre>';var_dump($dataResult);die;
        return $dataResult;     
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