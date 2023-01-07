<?php
namespace App\Models\Backend;
use DB;
use HtmlString;
use Auth;
use DateTime;
use DateInterval;
class Statistic 
{
    
    public static function listDayOrder($from=null, $to=null, $order_status=0,$option = null){
        if ($option == null) {
            $dataResult = array();
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0 && $order_status != 4) {
                    $query->where('order_status', '=', $order_status);
                }elseif($order_status == 4){
                    $query->where('order_status', '=', $order_status)->orWhere('order_status', '=', 5);
                }
            })
            ->where('order.order_type', 0)
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            ->paginate(10);
            //->toSql();dd($data);

            $data2 = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0 && $order_status != 4) {
                    $query->where('order_status', '=', $order_status);
                }elseif($order_status == 4){
                    $query->where('order_status', '=', $order_status)->orWhere('order_status', '=', 5);
                }
            })
            ->where('order.order_type', 1)
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            ->paginate(10);

            $total = DB::table("order")
            ->selectRaw("SUM(order_price) as total, SUM(IF(order_status = 3, order_price, 0)) as totalSuccess, COUNT(order_id) as countTotal, COUNT(IF(order_status = 3, 1, NULL)) as countSuccess")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where('order_type', 0)
            ->first();

            $total2 = DB::table("order")
            ->selectRaw("SUM(order_price) as total, SUM(IF(order_status = 3, order_price, 0)) as totalSuccess, COUNT(order_id) as countTotal, COUNT(IF(order_status = 3, 1, NULL)) as countSuccess")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where('order_type', 1)
            ->first();

            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
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
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->first();
                    
            if (!empty($data)) {
                foreach ($data as $key => $value) {                
                    $option = explode('|', $value->product_option_group);
                    if (!empty($option)) {
                        foreach ($option as $k => $v) {
                            if (!empty($v)) {
                                $option[$k] = json_decode($v);
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
                /*$sumCountAll = count($total);
                $sumTotalAll = 0;
                foreach($total as $totalPrice){
                    $sumTotalAll += $totalPrice->order_price;
                }
                $sumCountSuccess = count($totalSuccess);
                $sumTotalSuccess = 0;
                foreach($totalSuccess as $totalSuccessPrice){
                    $sumTotalSuccess = $sumTotalSuccess + $totalSuccessPrice->order_price;
                }*/
                $dataResult['status'] = true;
                $dataResult['data'] = $data;
                $dataResult['sumCountAll'] = $total->countTotal;
                $dataResult['sumTotalAll'] = $total->total;
                $dataResult['sumCountSuccess'] = $total->countSuccess;
                $dataResult['sumTotalSuccess'] = $total->totalSuccess;

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

            if (!empty($data2)) {
                foreach ($data2 as $key2 => $value2) {                
                    $option = explode('|', $value2->product_option_group);
                    if (!empty($option)) {
                        foreach ($option as $k => $v) {
                            if (!empty($v)) {
                                $option[$k] = json_decode($v);
                            }
                        }
                    }

                    $data2[$key2]->option = $option;

                    $product_name_group = explode(',', $value2->product_name_group);
                    $data2[$key2]->name_group = $product_name_group;

                    $product_price_group = explode(',', $value2->product_price_group);
                    $data2[$key2]->price_group = $product_price_group;

                    $product_qty_group = explode(',', $value2->product_qty_group);
                    $data2[$key2]->qty_group = $product_qty_group;
                }
                /*$sumCountAll = count($total);
                $sumTotalAll = 0;
                foreach($total as $totalPrice){
                    $sumTotalAll += $totalPrice->order_price;
                }
                $sumCountSuccess = count($totalSuccess);
                $sumTotalSuccess = 0;
                foreach($totalSuccess as $totalSuccessPrice){
                    $sumTotalSuccess = $sumTotalSuccess + $totalSuccessPrice->order_price;
                }*/
                $dataResult['data2'] = $data2;
                $dataResult['sumCountAll2'] = $total2->countTotal;
                $dataResult['sumTotalAll2'] = $total2->total;
                $dataResult['sumCountSuccess2'] = $total2->countSuccess;
                $dataResult['sumTotalSuccess2'] = $total2->totalSuccess;
            }else{
                $dataResult['data2'] = array();
            }

            return $dataResult; 
        }else{
            $dataResult = array();
            $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0 && $order_status != 4) {
                    $query->where('order_status', '=', $order_status);
                }elseif($order_status == 4){
                    $query->where('order_status', '=', $order_status)->orWhere('order_status', '=', 5);
                }
            })
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            ->get();

            /*$total = DB::table("order")
            ->selectRaw("order_price")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")            
            ->get();*/

            $total = DB::table("order")
            ->selectRaw("SUM(order_price) as total, SUM(IF(order_status = 3, order_price, 0)) as totalSuccess, COUNT(order_id) as countTotal, COUNT(IF(order_status = 3, 1, NULL)) as countSuccess")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where([                
                ['order_type', '=', 0],
            ])
            ->first();

            $total2 = DB::table("order")
            ->selectRaw("SUM(order_price) as total, SUM(IF(order_status = 3, order_price, 0)) as totalSuccess, COUNT(order_id) as countTotal, COUNT(IF(order_status = 3, 1, NULL)) as countSuccess")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where([                
                ['order_type', '=', 1],
            ])
            ->first();

            //total success
            /*$totalSuccess = DB::table("order")
            ->select("order_price")
            ->where('order_status', '=', 3)
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->get();*/

            //total nạp tài khoản
            $totalTK = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
            ->join('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 27],
            ])
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
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->first();
                    
            if (!empty($data)) {
                foreach ($data as $key => $value) {                
                    $option = explode('|', $value->product_option_group);
                    if (!empty($option)) {
                        foreach ($option as $k => $v) {
                            if (!empty($v)) {
                                $option[$k] = json_decode($v);
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
                /*$sumCountAll = count($total);
                $sumTotalAll = 0;
                foreach($total as $totalPrice){
                    $sumTotalAll += $totalPrice->order_price;
                }
                $sumCountSuccess = count($totalSuccess);
                $sumTotalSuccess = 0;
                foreach($totalSuccess as $totalSuccessPrice){
                    $sumTotalSuccess = $sumTotalSuccess + $totalSuccessPrice->order_price;
                }*/
                $dataResult['status'] = true;
                $dataResult['data'] = $data;
                $dataResult['sumCountAll'] = $total->countTotal;
                $dataResult['sumTotalAll'] = $total->total;
                $dataResult['sumCountSuccess'] = $total->countSuccess;
                $dataResult['sumTotalSuccess'] = $total->totalSuccess;

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

            if (!empty($data2)) {
                foreach ($data2 as $key2 => $value2) {                
                    $option = explode('|', $value2->product_option_group);
                    if (!empty($option)) {
                        foreach ($option as $k => $v) {
                            if (!empty($v)) {
                                $option[$k] = json_decode($v);
                            }
                        }
                    }

                    $data2[$key2]->option = $option;

                    $product_name_group = explode(',', $value2->product_name_group);
                    $data2[$key2]->name_group = $product_name_group;

                    $product_price_group = explode(',', $value2->product_price_group);
                    $data2[$key2]->price_group = $product_price_group;

                    $product_qty_group = explode(',', $value2->product_qty_group);
                    $data2[$key2]->qty_group = $product_qty_group;
                }
                /*$sumCountAll = count($total);
                $sumTotalAll = 0;
                foreach($total as $totalPrice){
                    $sumTotalAll += $totalPrice->order_price;
                }
                $sumCountSuccess = count($totalSuccess);
                $sumTotalSuccess = 0;
                foreach($totalSuccess as $totalSuccessPrice){
                    $sumTotalSuccess = $sumTotalSuccess + $totalSuccessPrice->order_price;
                }*/
                $dataResult['data2'] = $data2;
                $dataResult['sumCountAll2'] = $total2->countTotal;
                $dataResult['sumTotalAll2'] = $total2->total;
                $dataResult['sumCountSuccess2'] = $total2->countSuccess;
                $dataResult['sumTotalSuccess2'] = $total2->totalSuccess;
            }else{
                $dataResult['data2'] = array();
            }
/*echo '<pre>';
print_r($dataResult);die;*/
            return $dataResult; 
        }

    }
    
    public static function listMonthOrder($numMonth, $startMonth, $endMonth, $endCa3, $startCase=null, $endCase=null){
        $dataResult = array();

        $data = DB::table("order")
        ->selectRaw("DATE(order.order_create_time) as date, DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, COUNT(IF(order_type = 0,order_id,NULL)) as sumCount, COUNT(IF((order_status = 1) and (order_type = 0), 1, NULL)) as sumWait, COUNT(IF((order_status = 2) and (order_type = 0), 1, NULL)) as sumPay, COUNT(IF((order_status = 3) and (order_type = 0), 1, NULL)) as sumFinish, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 0), 1, NULL)) as sumCancel, SUM(IF((order_status = 3) and (order_type = 0), order_price, 0)) as sumFinishPrice, SUM(IF(order_type = 0, order_price, 0)) as sumTotal, COUNT(IF(order_type = 1,order_id,NULL)) as sumCount2, COUNT(IF((order_status = 1) and (order_type = 1), 1, NULL)) as sumWait2, COUNT(IF((order_status = 2) and (order_type = 1), 1, NULL)) as sumPay2, COUNT(IF((order_status = 3) and (order_type = 1), 1, NULL)) as sumFinish2, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 1), 1, NULL)) as sumCancel2, SUM(IF((order_status = 3) and (order_type = 1), order_price, 0)) as sumFinishPrice2, SUM(IF(order_type = 1, order_price, 0)) as sumTotal2")
        ->whereRaw("order.order_create_time > '".$startMonth."'")
        ->whereRaw("order.order_create_time <= '".$endMonth."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if ( strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                }
            })
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        // data from 0h -> end ca3
        $data2 = DB::table("order")
        ->selectRaw("DATE(order.order_create_time) as date, DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, COUNT(IF(order_type = 0,order_id,NULL)) as sumCount, COUNT(IF((order_status = 1) and (order_type = 0), 1, NULL)) as sumWait, COUNT(IF((order_status = 2) and (order_type = 0), 1, NULL)) as sumPay, COUNT(IF((order_status = 3) and (order_type = 0), 1, NULL)) as sumFinish, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 0), 1, NULL)) as sumCancel, SUM(IF((order_status = 3) and (order_type = 0), order_price, 0)) as sumFinishPrice, SUM(IF(order_type = 0, order_price, 0)) as sumTotal, COUNT(IF(order_type = 1,order_id,NULL)) as sumCount2, COUNT(IF((order_status = 1) and (order_type = 1), 1, NULL)) as sumWait2, COUNT(IF((order_status = 2) and (order_type = 1), 1, NULL)) as sumPay2, COUNT(IF((order_status = 3) and (order_type = 1), 1, NULL)) as sumFinish2, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 1), 1, NULL)) as sumCancel2, SUM(IF((order_status = 3) and (order_type = 1), order_price, 0)) as sumFinishPrice2, SUM(IF(order_type = 1, order_price, 0)) as sumTotal2")
        ->whereRaw("order.order_create_time > '".$startMonth."' AND order.order_create_time <= '".$endMonth."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        //total nạp tài khoản
        $totalTK = DB::table("order_details")
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("order.order_create_time > '".$startMonth."'")
        ->whereRaw("order.order_create_time <= '".$endMonth."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if (strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                    
                }
            })
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        //total combo
        $totalCombo = DB::table("order_details")
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("order.order_create_time > '".$startMonth."'")
        ->whereRaw("order.order_create_time <= '".$endMonth."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if (strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                    
                }
            })
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        //total nạp tài khoản2
        $totalTK2 = DB::table("order_details")
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("order.order_create_time > '".$startMonth."' AND order.order_create_time <= '".$endMonth."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")        
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        //total combo2
        $totalCombo2 = DB::table("order_details")
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("DAY(order.order_create_time) as day, MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("order.order_create_time > '".$startMonth."' AND order.order_create_time <= '".$endMonth."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")
        ->groupBy(DB::raw("DATE(order.order_create_time)"))
        ->get();

        if (!empty($data)) {
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['data2'] = $data2;
            $dataResult['taikhoan'] = $totalTK;
            $dataResult['combo'] = $totalCombo;
            $dataResult['taikhoan2'] = $totalTK2;
            $dataResult['combo2'] = $totalCombo2;
        }else{
            $dataResult['status'] = false;
        }
        return $dataResult;     
    }

    public static function listYearOrder($year, $startYear, $endYear, $endCa3, $startCase=null, $endCase=null){
        $dataResult = array();
        $data = DB::table("order")
        ->selectRaw("YEAR(order.order_create_time) as year, MONTH(order.order_create_time) as month, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, COUNT(IF(order_type = 0, order_id, NULL)) as sumCount, COUNT(IF((order_status = 1) and (order_type = 0), 1, NULL)) as sumWait, COUNT(IF((order_status = 2) and (order_type = 0), 1, NULL)) as sumPay, COUNT(IF((order_status = 3) and (order_type = 0), 1, NULL)) as sumFinish, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 0), 1, NULL)) as sumCancel, SUM(IF((order_status = 3) and (order_type = 0), order_price, 0)) as sumFinishPrice, SUM(IF(order_type = 0, order_price, 0)) as sumTotal, COUNT(IF(order_type = 1, order_id, NULL)) as sumCount2, COUNT(IF((order_status = 1) and (order_type = 1), 1, NULL)) as sumWait2, COUNT(IF((order_status = 2) and (order_type = 1), 1, NULL)) as sumPay2, COUNT(IF((order_status = 3) and (order_type = 1), 1, NULL)) as sumFinish2, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 1), 1, NULL)) as sumCancel2, SUM(IF((order_status = 3) and (order_type = 1), order_price, 0)) as sumFinishPrice2, SUM(IF(order_type = 1, order_price, 0)) as sumTotal2")
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if (strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                }
            })
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        $data2 = DB::table("order")
        ->selectRaw("YEAR(order.order_create_time) as year, MONTH(order.order_create_time) as month, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, COUNT(IF(order_type = 0, order_id, NULL)) as sumCount, COUNT(IF((order_status = 1) and (order_type = 0), 1, NULL)) as sumWait, COUNT(IF((order_status = 2) and (order_type = 0), 1, NULL)) as sumPay, COUNT(IF((order_status = 3) and (order_type = 0), 1, NULL)) as sumFinish, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 0), 1, NULL)) as sumCancel, SUM(IF((order_status = 3) and (order_type = 0), order_price, 0)) as sumFinishPrice, SUM(IF(order_type = 0, order_price, 0)) as sumTotal, COUNT(IF(order_type = 1, order_id, NULL)) as sumCount2, COUNT(IF((order_status = 1) and (order_type = 1), 1, NULL)) as sumWait2, COUNT(IF((order_status = 2) and (order_type = 1), 1, NULL)) as sumPay2, COUNT(IF((order_status = 3) and (order_type = 1), 1, NULL)) as sumFinish2, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 1), 1, NULL)) as sumCancel2, SUM(IF((order_status = 3) and (order_type = 1), order_price, 0)) as sumFinishPrice2, SUM(IF(order_type = 1, order_price, 0)) as sumTotal2")
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."' AND DAY(order.order_create_time) = '1'")
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        $data3 = DB::table("order")
        ->selectRaw("YEAR(order.order_create_time) as year, MONTH(order.order_create_time) as month, GROUP_CONCAT(order_id SEPARATOR ',') as id_group, COUNT(IF(order_type = 0, order_id, NULL)) as sumCount, COUNT(IF((order_status = 1) and (order_type = 0), 1, NULL)) as sumWait, COUNT(IF((order_status = 2) and (order_type = 0), 1, NULL)) as sumPay, COUNT(IF((order_status = 3) and (order_type = 0), 1, NULL)) as sumFinish, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 0), 1, NULL)) as sumCancel, SUM(IF((order_status = 3) and (order_type = 0), order_price, 0)) as sumFinishPrice, SUM(IF(order_type = 0, order_price, 0)) as sumTotal, COUNT(IF(order_type = 1, order_id, NULL)) as sumCount2, COUNT(IF((order_status = 1) and (order_type = 1), 1, NULL)) as sumWait2, COUNT(IF((order_status = 2) and (order_type = 1), 1, NULL)) as sumPay2, COUNT(IF((order_status = 3) and (order_type = 1), 1, NULL)) as sumFinish2, 
            COUNT(IF(((order_status = 4) or (order_status = 5)) and (order_type = 1), 1, NULL)) as sumCancel2, SUM(IF((order_status = 3) and (order_type = 1), order_price, 0)) as sumFinishPrice2, SUM(IF(order_type = 1, order_price, 0)) as sumTotal2")
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total nạp tài khoản
        $totalTK = DB::table("order_details")
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if (strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                    
                }
            })
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total combo
        $totalCombo = DB::table("order_details")
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month, YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->where(function ($query) use ($startCase,$endCase){
                if ($startCase != null && $endCase != null) {
                    if (strtotime($startCase) < strtotime($endCase) ) {
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'");
                        $query->whereRaw("TIME(order.order_create_time) <= '".$endCase."'");
                    }else{
                        $query->whereRaw("TIME(order.order_create_time) > '".$startCase."'" );
                        $query->whereRaw("TIME(order.order_create_time) <= '23:59:59'");
                    }
                }
            })
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total nạp tài khoản2
        $totalTK2 = DB::table("order_details")
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month , YEAR(order.order_create_time) as year,  SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."' AND DAY(order.order_create_time) = 1")        
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total combo2
        $totalCombo2 = DB::table("order_details")
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month , YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."' AND DAY(order.order_create_time) = 1")        
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total nạp tài khoản3
        $totalTK3 = DB::table("order_details")
        ->join('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month , YEAR(order.order_create_time) as year,  SUM(order_details.product_price*order_details.product_quantity) as priceTotalTK")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 27],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")        
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        //total combo3
        $totalCombo3 = DB::table("order_details")
        ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
        ->selectRaw("MONTH(order.order_create_time) as month , YEAR(order.order_create_time) as year, SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
        ->where([
            ['order_status', '=', 3],
            ['order_details.category_id', '=', 19],
        ])
        ->whereRaw("order.order_create_time > '".$startYear."' AND order.order_create_time <= '".$endYear."'")
        ->whereRaw("TIME(order.order_create_time) >= '00:00:00' AND TIME(order.order_create_time) <= '".$endCa3."'")        
        ->groupBy(DB::raw("MONTH(order.order_create_time)"))
        ->get();

        if (!empty($data)) {
            $dataResult['status'] = true;
            $dataResult['data'] = $data;
            $dataResult['data2'] = $data2;
            $dataResult['data3'] = $data3;
            $dataResult['taikhoan'] = $totalTK;
            $dataResult['combo'] = $totalCombo;
            $dataResult['taikhoan2'] = $totalTK2;
            $dataResult['combo2'] = $totalCombo2;
            $dataResult['taikhoan3'] = $totalTK3;
            $dataResult['combo3'] = $totalCombo3;
        }else{
            $dataResult['status'] = false;
        }
        return $dataResult;     
    }
    
    public static function reportCategory($from=null, $to=null){
        if($from!=null&&$to!=null){
            $listOder = DB::table("order")
            ->join('order_details', 'order_details.order_id', '=', 'order.order_id')
            ->selectRaw("order_details.product_name, order_details.product_id, order_details.order_id, order.order_create_time,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group, GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group, GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group, SUM(order_details.product_quantity) as qtyTotal, SUM(order_details.product_price*order_details.product_quantity) as priceTotal")
            ->where('order.order_status', '=', '3')
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
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
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->first();

            //total combo
            $totalCombo = DB::table("order_details")
            ->selectRaw("SUM(order_details.product_price*order_details.product_quantity) as priceTotalCB")
            ->leftJoin('order', 'order_details.order_id', '=', 'order.order_id')
            ->where([
                ['order_status', '=', 3],
                ['order_details.category_id', '=', 19],
            ])
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")        
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

        //list product id
        $listProduct = DB::table("category")
        ->leftJoin('product', 'category.category_id', '=', 'product.category_id')
        ->select('category.category_name', 'product.product_id', 'product.product_price')
        ->where('category.category_id_parent', '!=', '0')
        ->get();
        $listIdProduct = array();
        foreach ($listProduct as $itemProduct) {
            if($itemProduct->product_id != ''){
                $listIdProduct[] = $itemProduct->product_id;    
            }
        }
        $dataResult['listIdProduct'] = $listIdProduct;
        
        //list options id
        $listOptions = DB::table("listoption")
        ->select('id', 'name', 'price')
        ->get();
        $listIdOptions = array();
        foreach ($listOptions as $itemOption) {
            if($itemOption->id != ''){
                $listIdOptions[] = $itemOption->id;
            }
        }
        $dataResult['listIdOptions'] = $listIdOptions;

        $optionTotalPrice = 0;
        $totalPrice = 0;
        $options = array();
        $options2 = array();

        foreach($listOder as $k => $order){            
            $listOder[$k]->priceOption = 0;

            if( $order->product_qty_group != null ){
                $product_qty_group = explode(',', $order->product_qty_group);                
            }

            //process option
            if( $order->product_option_group != null /*&& !empty(json_decode($order->product_option_group))*/ ){
                $product_option_group = explode('|', $order->product_option_group);

                foreach($product_option_group as $key => $value){
                    if(isset($product_qty_group[$key])){
                        $thisQty = $product_qty_group[$key];
                    }else{
                        $thisQty = 1;
                    }
                    $option = json_decode($value,true);
                    if(count($option) > 0){
                        $options[] = $option;
                        foreach($option as $vOp){
                            $listOder[$k]->priceOption += $vOp['2'] * $vOp['3'] * $thisQty;
                            $optionTotalPrice += $vOp['2'] * $vOp['3'] * $thisQty;
                        }
                    }
                }
            }
            $totalPrice += $order->priceTotal;
        }
        
        foreach ($options as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if( array_key_exists($value2[0],$options2) ){
                    $options2[$value2[0]]['qty'] += $value2[3];
                    $options2[$value2[0]]['total'] += $value2[2]*$value2[3];
                }else{
                    $options2[$value2[0]] = array(
                        'name'  => $value2[1],
                        'price' => $value2[2],
                        'qty'   => $value2[3],
                        'total' => $value2[2]*$value2[3]
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

    public static function listAjaxStatisticDay1($request){
        if($request->search_day_hour == 1){
            $from = DateTime::createFromFormat('d-m-Y H:i', urldecode($request->day_hour_from))->format('Y-m-d H:i:s'); 
            $to = DateTime::createFromFormat('d-m-Y H:i', urldecode($request->day_hour_to))->format('Y-m-d H:i:s');
                        
        }else{
            $day = $request->day ? $request->day : date('d-m-Y');
            $case = $request->case ? $request->case : 0;

            $recent_day = DateTime::createFromFormat('d-m-Y', $day)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $day)->add(new DateInterval('P1D'))->format('Y-m-d');
            $schedule = self::getSchedule($case);

            if(!empty($schedule)){ //print_r($schedule);
                if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                    $from = $recent_day.' '.$schedule->time_start;
                    $to = $newday.' '.$schedule->time_end;
                }else{
                    $from = $recent_day.' '.$schedule->time_start;
                    $to = $recent_day.' '.$schedule->time_end;
                }
            }else{
                $schedule = self::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $from = $recent_day.' '.$startCa1;
                $to = $newday.' '.$endCa3;
            }
        }

        $order_status = $request->order_status ? $request->order_status : 0;
        $page = $request->page ? $request->page : 1;

        $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0 && $order_status != 4) {
                    $query->where('order_status', '=', $order_status);
                }elseif($order_status == 4){
                    $query->where('order_status', '=', $order_status)->orWhere('order_status', '=', 5);
                }
            })        
            ->where('order.order_type', 0)
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            ->paginate(10);

        $result = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {                
                $option = explode('|', $value->product_option_group);
                if (!empty($option)) {
                    foreach ($option as $k => $v) {
                        if (!empty($v)) {
                            $option[$k] = json_decode($v);
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
        }

        $xhtml = '';
        $pagi_link = '';
        if(!empty($data)) { 
            foreach($data as $val) {
                $xhtml .="<tr>";
                    $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                    $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                    $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                    for($i = 0 ; $i < count($val->name_group); $i++) {
                        $xhtml .='<div class="row"><div class="col-sm-3">'. $val->name_group[$i];
                        if (!empty($val->option)) {
                            $xhtml .='<ul class="order-option">';
                                foreach ($val->option[$i] as $k => $v) {
                                  $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                                }                           
                            $xhtml .='</ul>';
                        }
                            $xhtml .= '</div>';
                            $xhtml .= '<div class="col-sm-3">'. $val->qty_group[$i] .'</div>';
                            $xhtml .= '<div class="col-sm-3">'. number_format($val->price_group[$i],0,",",".") .'</div>';
                            $xhtml .= '<div class="col-sm-3">'. number_format(($val->qty_group[$i]*$val->price_group[$i]),0,",",".") .'</div></div>';
                    }
                    $xhtml .='</td>';
                    $xhtml .='<td>'.number_format($val->order_price,0,",",".").'</td>';
                    $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->message_destroy.'</td>';
                    $xhtml .='<td>';
                        if($val->order_status == 1) {
                            $xhtml .='<a><span class="label label-warning">Đang xử lý</span></a>';
                        }elseif($val->order_status == 2 ){
                            $xhtml .='<a><span class="label label-success">Đã thu tiền</span></a>';
                        }elseif($val->order_status == 3 ){
                            $xhtml .='<a><span class="label label-success">Đã hoàn thành</span></a>';
                        }elseif($val->order_status == 4 ){
                            $xhtml .='<a><span class="label label-danger">Đã hủy</span></a>';
                        }elseif($val->order_status == 5 ){
                            $xhtml .='<a><span class="label label-danger">Đã hủy(hoàn trả)</span></a>';
                        }
                    $xhtml .='</td>';  
                $xhtml .= '</tr>'; 

            }
            if ($data->hasMorePages() || !empty($page)) {
                $req = array(
                        'case' => $request->case,
                        'day' => $request->day,
                        'search_day_hour' => $request->search_day_hour,
                        'order_status' => $request->order_status,
                        'page' => $request->page,

                        'day_hour_from' => urldecode($request->day_hour_from),
                        'day_hour_to' => urldecode($request->day_hour_to),
                    );
                $pagi_link = $data->setPath('getAjaxStatisticDay')->appends($req)->links()->toHtml();
            }
        }

        $result['html'] = $xhtml;
        $result['pagi'] = $pagi_link;

        return $result;
    }

    public static function listAjaxStatisticDay2($request){
        if($request->search_day_hour == 1){
            $from = DateTime::createFromFormat('d-m-Y H:i', urldecode($request->day_hour_from))->format('Y-m-d H:i:s'); 
            $to = DateTime::createFromFormat('d-m-Y H:i', urldecode($request->day_hour_to))->format('Y-m-d H:i:s'); 
        }else{
            $day = $request->day ? $request->day : date('d-m-Y');
            $case = $request->case ? $request->case : 0;

            $recent_day = DateTime::createFromFormat('d-m-Y', $day)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $day)->add(new DateInterval('P1D'))->format('Y-m-d');
            $schedule = self::getSchedule($case);

            if(!empty($schedule)){ //print_r($schedule);
                if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                    $from = $recent_day.' '.$schedule->time_start;
                    $to = $newday.' '.$schedule->time_end;
                }else{
                    $from = $recent_day.' '.$schedule->time_start;
                    $to = $recent_day.' '.$schedule->time_end;
                }
            }else{
                $schedule = self::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $from = $recent_day.' '.$startCa1;
                $to = $newday.' '.$endCa3;
            }
        }

        $order_status = $request->order_status ? $request->order_status : 0;
        $page = $request->page ? $request->page : 1;

        $data = DB::table("order")
            ->leftJoin('order_details', 'order.order_id', '=', 'order_details.order_id')
            ->selectRaw("order.order_id,order.client_name,order.order_create_time,order.order_price,order.order_status,order.message_destroy,GROUP_CONCAT(order_details.product_name SEPARATOR ',') as product_name_group,GROUP_CONCAT(order_details.product_price SEPARATOR ',') as product_price_group,GROUP_CONCAT(order_details.product_quantity SEPARATOR ',') as product_qty_group,GROUP_CONCAT(order_details.product_option SEPARATOR '|') as product_option_group")
            ->whereRaw("order.order_create_time > '".$from."'")
            ->whereRaw("order.order_create_time <= '".$to."'")
            ->where(function ($query) use ($order_status){
                if ($order_status != 0 && $order_status != 4) {
                    $query->where('order_status', '=', $order_status);
                }elseif($order_status == 4){
                    $query->where('order_status', '=', $order_status)->orWhere('order_status', '=', 5);
                }
            })        
            ->where('order.order_type', 1)
            ->orderBy('order.order_id', 'desc')
            ->groupBy('order.order_id')
            ->paginate(10);
      
        $result = array();
        if (!empty($data)) {
            foreach ($data as $key => $value) {                
                $option = explode('|', $value->product_option_group);
                if (!empty($option)) {
                    foreach ($option as $k => $v) {
                        if (!empty($v)) {
                            $option[$k] = json_decode($v);
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
        }

        $xhtml = '';
        $pagi_link = '';
        if(!empty($data)) { 
            foreach($data as $val) {
                $xhtml .="<tr>";
                    $xhtml .= "<td>".$val->order_id."</td><td>".$val->client_name."</td>";
                    $xhtml .= "<td>".date("d-m-Y H:i:s",strtotime($val->order_create_time)) ."</td>";
                    $xhtml .=  '<td><div class="row"><div class="col-sm-3">&nbsp;</div><div class="col-sm-3">Số lượng</div><div class="col-sm-3">Đơn giá</div><div class="col-sm-3">Thành tiền</div></div>';
                    for($i = 0 ; $i < count($val->name_group); $i++) {
                        $xhtml .='<div class="row"><div class="col-sm-3">'. $val->name_group[$i];
                        if (!empty($val->option)) {
                            $xhtml .='<ul class="order-option">';
                                foreach ($val->option[$i] as $k => $v) {
                                  $xhtml .= '<li>'.$v['1'].'('.number_format($v['2'],0,",",".").')('.$v['3'].')</li>';
                                }                           
                            $xhtml .='</ul>';
                        }
                            $xhtml .= '</div>';
                            $xhtml .= '<div class="col-sm-3">'. $val->qty_group[$i] .'</div>';
                            $xhtml .= '<div class="col-sm-3">'. number_format($val->price_group[$i],0,",",".") .'</div>';
                            $xhtml .= '<div class="col-sm-3">'. number_format(($val->qty_group[$i]*$val->price_group[$i]),0,",",".") .'</div></div>';
                    }
                    $xhtml .='</td>';
                    $xhtml .='<td>'.number_format($val->order_price,0,",",".").'</td>';
                    $xhtml .='<td style="max-width:150px;min-width: 80px;">'.$val->message_destroy.'</td>';
                    $xhtml .='<td>';
                        if($val->order_status == 1) {
                            $xhtml .='<a><span class="label label-warning">Đang xử lý</span></a>';
                        }elseif($val->order_status == 2 ){
                            $xhtml .='<a><span class="label label-success">Đã thu tiền</span></a>';
                        }elseif($val->order_status == 3 ){
                            $xhtml .='<a><span class="label label-success">Đã hoàn thành</span></a>';
                        }elseif($val->order_status == 4 ){
                            $xhtml .='<a><span class="label label-danger">Đã hủy</span></a>';
                        }elseif($val->order_status == 5 ){
                            $xhtml .='<a><span class="label label-danger">Đã hủy(hoàn trả)</span></a>';
                        }
                    $xhtml .='</td>';  
                $xhtml .= '</tr>'; 

            }
            if ($data->hasMorePages() || !empty($page)) {
                $req = array(
                        'case' => $request->case,
                        'day' => $request->day,
                        'search_day_hour' => $request->search_day_hour,
                        'order_status' => $request->order_status,
                        'page' => $request->page,

                        'day_hour_from' => urldecode($request->day_hour_from),
                        'day_hour_to' => urldecode($request->day_hour_to),
                    );
                $pagi_link = $data->setPath('getAjaxStatisticDay')->appends($req)->links()->toHtml();
            }
        }

        $result['html'] = $xhtml;
        $result['pagi'] = $pagi_link;

        return $result;
    }

    public static function checkCaseTomorrow($case){
        $case = DB::table('scheduletime')
        ->select('time_start', 'time_end')
        ->where('id', $case)
        ->first();

        if(count($case) > 0){
            if(strtotime($case->time_start) > strtotime($case->time_end)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}