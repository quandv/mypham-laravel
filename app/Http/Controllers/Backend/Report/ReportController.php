<?php

namespace App\Http\Controllers\Backend\Report;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use Collective\Html\HtmlFacade;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Report;
use App\Mylibs\Mylibs;
use DateTime;
use PDF;
use Excel;
use DateInterval;

class ReportController extends Controller
{
    // get report today
    public function reportToDay( Request $request ){
       
        $today = new DateTime('NOW');
        $today = $today->format('Y-m-d');
        $dataResult = Report::listDayOrder($today);
        
        if( $dataResult['status'] ){
            $data['status'] = true;            
            $data['data'] = $dataResult['data'];
            $data['sumTotalAll'] = $dataResult['sumTotalAll'];
            $data['sumCountAll'] = $dataResult['sumCountAll'];
            $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
            $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
        }else{
            $data['status'] = false;
        }
        $data['schedule'] = Report::getAllSchedule();
        return view('backend.report.reportDay', $data);
    }


    public function getReportDay(Request $request){
        $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
        $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
        $case = $request->case;
        $order_status = $request->order_status;
        $schedule = Report::getSchedule($case);

        if(!empty($schedule)){ //print_r($schedule);
            if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                $fromCase = $recent_day.' '.$schedule->time_start; 
                $toCase = $newday.' '.$schedule->time_end;    
            }else{
                $fromCase = $recent_day.' '.$schedule->time_start;
                $toCase = $recent_day.' '.$schedule->time_end;
            }
        }else{
            $fromCase = null;
            $toCase = null;
        }
      
        $dataResult = Report::listDayOrder($recent_day, $fromCase, $toCase, $order_status);
        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['day'] = $request->day;
            $data['data'] = $dataResult['data'];
            $data['sumTotalAll'] = $dataResult['sumTotalAll'];
            $data['sumCountAll'] = $dataResult['sumCountAll'];
            $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
            $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];
            $data['case'] = $case;
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
            $data['order_status'] = $order_status;
        }else{
            $data['status'] = false;
        }
        $data['schedule'] = Report::getAllSchedule();

        //echo '<pre>'; print_r($data);die;
        return view('backend.report.reportDay', $data);
    }

    public function exportPdf(Request $request){  
        if ($request->day != '') {
            $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
            $case = $request->case;
            switch ($case) {
                case '1':
                    //6h-14h
                    $fromCase = $recent_day.' 06:00:00';
                    $toCase = $recent_day.' 14:00:00';
                    break;
                case '2':
                    $fromCase = $recent_day.' 14:00:00';
                    $toCase = $recent_day.' 22:00:00';
                    //14h-22h
                    break;
                case '3':
                    $fromCase = $recent_day.' 22:00:00';
                    $toCase = $newday.' 06:00:00';
                    //22-6h
                    break;
                case '0':
                    $fromCase = null;
                    $toCase = null;
                    break;
                default: 
                    $fromCase = null;
                    $toCase = null;
                    break;
            }
          
            $dataResult = Report::listDayOrder($recent_day,$fromCase, $toCase);
            if($request->has('download')){ 
                if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['day'] = $request->day;
                    $data['data'] = $dataResult['data'];
                    $data['sumTotalAll'] = $dataResult['sumTotalAll'];
                    $data['sumCountAll'] = $dataResult['sumCountAll'];
                    $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
                    $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];
                    $data['case'] = $case;

                }else{
                    $data['status'] = false;
                }
                //$old_limit = ini_set("memory_limit", "128M"); 
                //$pdf = PDF::loadView('demo',$data)->setPaper('a4', 'landscape');
                $filename = $request->day.'-report_day.pdf';
                //return $pdf->download($filename);
                return view('demo',$data);
                /*$pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf ->get_canvas();
                $canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));*/
               // return $pdf->stream($filename);
            }
        }else{
            $today = new DateTime('NOW');
            $today = $today->format('Y-m-d');
            $dataResult = Report::listDayOrder($today);
            if($request->has('download')){ 
                if( $dataResult['status'] ){
                    $data['status'] = true;            
                    $data['data'] = $dataResult['data'];
                    $data['sumTotalAll'] = $dataResult['sumTotalAll'];
                    $data['sumCountAll'] = $dataResult['sumCountAll'];
                    $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
                    $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];
                }else{
                    $data['status'] = false;
                }
                 $filename = date('Y-m-d', time()) .'-report_day.pdf';
                //return $pdf->download($filename);
                return view('demo',$data);
            }
        }
       
       
    }


    public function getReportMonth(Request $request){
        if($request->year){
            $year = $request->year;    
        }else{
            $year = date('Y', time());
        }
        if($request->month){
            $month = $request->month;    
        }else{
            $month = date('m', time());
        }
        
        $listDays = Mylibs::getDays($month, $year);
        $startMonth = 1;
        $endMonth = count($listDays);

        $data['month'] = $month;
        $data['year']  = $year;
        $data['endMonth'] = $endMonth;        
        $dataResult = Report::listMonthOrder($year, $month, $startMonth, $endMonth);
        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['data'] = $dataResult['data'];
            $sumCountAll = 0;
            $sumTotalAll = 0;
            $sumCountSuccess = 0;
            $sumTotalSuccess = 0;
            foreach($dataResult['data'] as $k => $v){
                $sumCountAll += $v->sumCount;
                $sumTotalAll += $v->sumTotal;
                $sumCountSuccess += $v->sumFinish;
                $sumTotalSuccess += $v->sumFinishPrice;
            }
            $data['sumCountAll'] = $sumCountAll;
            $data['sumTotalAll'] = $sumTotalAll;
            $data['sumCountSuccess'] = $sumCountSuccess;
            $data['sumTotalSuccess'] = $sumTotalSuccess;

            $mangTK = array();
            $mangCB = array();
            if(empty($dataResult['taikhoan'])){
                $data['totalTK'] = 0;
            }else{
                $priceTotalTK = 0;                
                foreach($dataResult['taikhoan'] as $tk){
                    $priceTotalTK += $tk->priceTotalTK;
                    $mangTK[$tk->order_day] = $tk->priceTotalTK;
                }
                $data['totalTK'] = $priceTotalTK;
            }
            if(empty($dataResult['combo'])){
                $data['totalCombo'] = 0;
            }else{
                $priceTotalCB = 0;
                foreach($dataResult['combo'] as $cb){
                    $priceTotalCB += $cb->priceTotalCB;
                    $mangCB[$cb->order_day] = $cb->priceTotalCB;
                }
                $data['totalCombo'] = $priceTotalCB;
            }
            $data['taikhoan'] = $mangTK;
            $data['combo'] = $mangCB;
        }else{
            $data['month'] = $month;
            $data['status'] = false; 
        }
//echo '<pre>'; print_r($data);die;
        return view('backend.report.reportMonth', $data);
    }


    public function getReportYear(Request $request){
        if($request->year){
            $year = $request->year;    
        }else{
            $year = date('Y', time());
        }

        $data['year']  = $year;      
        $dataResult = Report::listYearOrder($year); //echo '<pre>'; print_r($dataResult);die;
        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['data'] = $dataResult['data'];
            $sumCountAll = 0;
            $sumTotalAll = 0;
            $sumCountSuccess = 0;
            $sumTotalSuccess = 0;
            foreach($dataResult['data'] as $k => $v){
                $sumCountAll += $v->sumCount;
                $sumTotalAll += $v->sumTotal;
                $sumCountSuccess += $v->sumFinish;
                $sumTotalSuccess += $v->sumFinishPrice;
            }
            $data['sumCountAll'] = $sumCountAll;
            $data['sumTotalAll'] = $sumTotalAll;
            $data['sumCountSuccess'] = $sumCountSuccess;
            $data['sumTotalSuccess'] = $sumTotalSuccess;            

            $mangTK = array();
            $mangCB = array();
            if(empty($dataResult['taikhoan'])){
                $data['totalTK'] = 0;
            }else{
                $priceTotalTK = 0;                
                foreach($dataResult['taikhoan'] as $tk){
                    $priceTotalTK += $tk->priceTotalTK;
                    $mangTK[$tk->order_month] = $tk->priceTotalTK;
                }
                $data['totalTK'] = $priceTotalTK;
            }
            if(empty($dataResult['combo'])){
                $data['totalCombo'] = 0;
            }else{
                $priceTotalCB = 0;
                foreach($dataResult['combo'] as $cb){
                    $priceTotalCB += $cb->priceTotalCB;
                    $mangCB[$cb->order_month] = $cb->priceTotalCB;
                }
                $data['totalCombo'] = $priceTotalCB;
            }
            $data['taikhoan'] = $mangTK;
            $data['combo'] = $mangCB;
            
        }else{            
            $data['status'] = false; 
        }

        return view('backend.report.reportYear', $data);
    }

    public function getReportCategory(Request $request){
        if( $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;

            if(strtotime($from) > strtotime($to)){
                $data['error'] = 'Thời điểm kết thúc phải lớn hơn thời điểm bắt đầu';
            }else{                
                $dataResult = Report::reportCategory($from, $to);
                $data['totalPrice'] = $dataResult['totalPrice'];
                $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
                $data['listProduct'] = $dataResult['listProduct'];
                $data['listOder'] = $dataResult['listOder'];
                $data['from'] = $from;
                $data['to'] = $to;
                $data['totalTK'] = $dataResult['totalTK'];
                $data['totalCombo'] = $dataResult['totalCombo'];
                $data['listOption'] = $dataResult['listOption'];
            }
        }else{
            $dataResult = Report::reportCategory();
            $data['totalPrice'] = $dataResult['totalPrice'];
            $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
            $data['listProduct'] = $dataResult['listProduct'];
            $data['listOder'] = $dataResult['listOder'];
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
            $data['listOption'] = $dataResult['listOption'];
        }
        

        return view('backend.report.reportCategory', $data);
    }

    public function exportExcel(Request $request){
        $type = 'xls';
         if( $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;

            if(strtotime($from) > strtotime($to)){
                $data['error'] = 'Thời điểm kết thúc phải lớn hơn thời điểm bắt đầu';
            }else{                
                $dataResult = Report::reportCategory($from, $to);
                $data['totalPrice'] = $dataResult['totalPrice'];
                $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
                $data['listProduct'] = $dataResult['listProduct'];
                $data['listOder'] = $dataResult['listOder'];
                $data['from'] = $from;
                $data['to'] = $to;
                $data['totalTK'] = $dataResult['totalTK'];
                $data['totalCombo'] = $dataResult['totalCombo'];
            }

        }else{
            $dataResult = Report::reportCategory(); //echo '<pre>'; print_r($dataResult);die;        
            $data['totalPrice'] = $dataResult['totalPrice'];
            $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
            $data['listProduct'] = $dataResult['listProduct'];
            $data['listOder'] = $dataResult['listOder'];
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
        }
        $data_excel = array();
        $data_item = array();

        if(!empty($data)){
          foreach($data['listOder'] as $k => $v){
             foreach($data['listProduct'] as $key => $value){
              if( $v->product_id == $value->product_id ){
                  $data_item['produtct_name'] = $v->product_name;
                  $data_item['category_name'] =$value->category_name ;                            
                  $data_item['qty'] = $v->product_qty_group;
                  $data_item['single_price'] =  $value->product_price;
                  $data_item['total_price'] =  $value->product_price*$v->product_qty_group;
                  $data_excel[] = $data_item;
              }
                
            }
          } 
        }  
       //dd($data_excel);

         
        return Excel::create('_example', function($excel) use ($data_excel,$data) {
            $excel->sheet('mySheet', function($sheet) use ($data_excel,$data)
            {
                $sheet->fromArray($data_excel);
                //Manipulate first row
                $sheet->row(1, array(
                     'Sản phẩm', 'Nhóm hàng','Số lượng','Đơn giá','Thành tiền'
                ));
                $sheet->appendRow(array(
                    'Tổng tiền Option:','','','',$data['optionTotalPrice']
                ));
                $sheet->appendRow(array(
                    'Tổng tiền (không bao gồm tiền nạp tài khoản và combo):', '','','', number_format(($data['totalPrice'] - $data['totalTK'] - $data['totalCombo']),'0',',','.')
                ));
                $sheet->appendRow(array(
                    'Tổng tiền :', '','','', number_format($data['totalPrice'],'0',',','.')
                ));

                  
            });
        })->download($type);
    }



}
