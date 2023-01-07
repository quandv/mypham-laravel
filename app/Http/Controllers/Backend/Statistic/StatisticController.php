<?php

namespace App\Http\Controllers\Backend\Statistic;

use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use Collective\Html\HtmlFacade;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Statistic;
use App\Mylibs\Mylibs;
use DateTime;
use PDF;
use SPDF;
use Excel;
use DateInterval;
use Mail;
use App\Mail\ReportDay;
use Illuminate\Mail\Mailer;
use Config;
use App\Mail\ReportTime;
use File;
class StatisticController extends Controller
{
    // get report today
    public function statisticToDay( Request $request ){

        $time = new DateTime('NOW');
        $today = $time->format('d-m-Y');
        $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
        $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');

        $schedule = Statistic::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;
        $fromCase = $recent_day.' '.$startCa1;
        $toCase = $newday.' '.$endCa3;
        
        $dataResult = Statistic::listDayOrder($fromCase, $toCase);
        
        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['data'] = $dataResult['data'];
            $data['data2'] = $dataResult['data2'];

            $data['sumTotalAll'] = $dataResult['sumTotalAll'];
            $data['sumCountAll'] = $dataResult['sumCountAll'];
            $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
            $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];

            $data['sumTotalAll2'] = $dataResult['sumTotalAll2'];
            $data['sumCountAll2'] = $dataResult['sumCountAll2'];
            $data['sumCountSuccess2'] = $dataResult['sumCountSuccess2'];
            $data['sumTotalSuccess2'] = $dataResult['sumTotalSuccess2'];

            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
        }else{
            $data['status'] = false;
        }
        $data['schedule'] = Statistic::getAllSchedule();
        $data['timeInADay'] = Mylibs::timeInADay();
        $data['timeInADay_start'] = Mylibs::timeInADay_start();
        
        return view('backend.statistic.statisticDay', $data);
    }

    public function getStatisticDay(Request $request){
        $order_status = $request->order_status;

        $data['schedule'] = Statistic::getAllSchedule();
        if($request->search_day_hour == 1){
            if($request->day_hour_from == '' || $request->day_hour_to == ''){
                $data['error_day'] = 'Bạn chưa chọn ngày giờ tìm kiếm';
                $data['status'] = false;
            }else if( strtotime($request->day_hour_from) >= strtotime($request->day_hour_to) ){
                $data['error_day'] = 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc';
                $data['status'] = false;
            }else{
                $fromCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_from)->format('Y-m-d H:i');
                $toCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_to)->format('Y-m-d H:i');

                $data['day'] = $request->day_hour_from.' - '.$request->day_hour_to;

                $dataResult = Statistic::listDayOrder($fromCase, $toCase, $order_status);
                if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['data'] = $dataResult['data'];
                    $data['data2'] = $dataResult['data2'];
                    $data['sumTotalAll'] = $dataResult['sumTotalAll'];
                    $data['sumCountAll'] = $dataResult['sumCountAll'];
                    $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
                    $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];

                    $data['sumTotalAll2'] = $dataResult['sumTotalAll2'];
                    $data['sumCountAll2'] = $dataResult['sumCountAll2'];
                    $data['sumCountSuccess2'] = $dataResult['sumCountSuccess2'];
                    $data['sumTotalSuccess2'] = $dataResult['sumTotalSuccess2'];

                    
                    $data['totalTK'] = $dataResult['totalTK'];
                    $data['totalCombo'] = $dataResult['totalCombo'];
                    $data['order_status'] = $order_status;
                }else{
                    $data['status'] = false;
                }
            }
        }else{
            if($request->day == ''){
                $data['error_day'] = 'Bạn chưa chọn ngày tìm kiếm';
                $data['status'] = false;            
            }else{
                $data['day'] = $request->day;
                $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d');
                $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
                $case = $request->case;
                $data['case'] = $case;
                
                $schedule = Statistic::getSchedule($case);

                if(!empty($schedule)){ //print_r($schedule);
                    if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $newday.' '.$schedule->time_end;
                    }else{
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $recent_day.' '.$schedule->time_end;
                    }
                }else{
                    $schedule = Statistic::getAllSchedule();
                    $startCa1 = $schedule[0]->time_start;
                    $endCa3 = $schedule[count($schedule)-1]->time_end;
                    $fromCase = $recent_day.' '.$startCa1;
                    $toCase = $newday.' '.$endCa3;
                }

                $dataResult = Statistic::listDayOrder($fromCase, $toCase, $order_status);
                if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['data'] = $dataResult['data'];
                    $data['data2'] = $dataResult['data2'];
                    $data['sumTotalAll'] = $dataResult['sumTotalAll'];
                    $data['sumCountAll'] = $dataResult['sumCountAll'];
                    $data['sumCountSuccess'] = $dataResult['sumCountSuccess'];
                    $data['sumTotalSuccess'] = $dataResult['sumTotalSuccess'];

                    $data['sumTotalAll2'] = $dataResult['sumTotalAll2'];
                    $data['sumCountAll2'] = $dataResult['sumCountAll2'];
                    $data['sumCountSuccess2'] = $dataResult['sumCountSuccess2'];
                    $data['sumTotalSuccess2'] = $dataResult['sumTotalSuccess2'];

                    
                    $data['totalTK'] = $dataResult['totalTK'];
                    $data['totalCombo'] = $dataResult['totalCombo'];
                    $data['order_status'] = $order_status;
                }else{
                    $data['status'] = false;
                }
            }
        }
        
        $data['timeInADay'] = Mylibs::timeInADay();
        $data['timeInADay_start'] = Mylibs::timeInADay_start();

        return view('backend.statistic.statisticDay', $data);
    }

    public function exportPdf(Request $request){
        $case = $request->case;
        $order_status = $request->order_status;

        if($request->search_day_hour == 1 ){
            if( $request->day_hour_from != '' && $request->day_hour_to != '' ){
                $fromCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_from)->format('Y-m-d H:i');
                $toCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_to)->format('Y-m-d H:i');

                $dataResult = Statistic::listDayOrder($fromCase, $toCase,$order_status,'print');
                // dd($dataResult);
                //if($request->has('download')){ 
                if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['day'] = $request->day_hour_from.' - '.$request->day_hour_to;
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
                //$old_limit = ini_set("memory_limit", "128M"); 
                //$pdf = PDF::loadView('demo',$data)->setPaper('a4', 'landscape');
                $filename = /*str_replace(' ', '_', $request->day_hour_from).'_'.strtotime($request->day_hour_from).*/'-report_day.pdf';
                //return $pdf->download($filename);
                //return view('demo',$data);
                $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
                          ->setOption('margin-top', 12)
                          ->setOption('margin-bottom', 12)
                          //->setOption('margin-left', 0)
                          //->setOption('margin-right', 0)
                         // ->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
                          //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
                          ->setOption('footer-right', 'Trang [page]');
                return $pdf->inline( $filename);
            }else{
                $time = new DateTime('NOW');
                $today = $time->format('d-m-Y');
                $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $fromCase = $recent_day.' '.$startCa1;
                $toCase = $newday.' '.$endCa3;
                $dataResult = Statistic::listDayOrder( $fromCase, $toCase,0,'print');
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
                        $data['totalTK'] = $dataResult['totalTK'];
                        $data['totalCombo'] = $dataResult['totalCombo'];
                        $data['order_status'] = $order_status;
                    }else{
                        $data['status'] = false;
                    }
                     $filename = date('Y-m-d', time()) .'-report_day.pdf';
                    //return $pdf->download($filename);
                     $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
                       ->setPaper('a4')
                       ->setOption('margin-top', 12)
                       ->setOption('margin-bottom', 12)
                      //->setOption('margin-left', 0)
                      //->setOption('margin-right', 0)
                       //->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
                       //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
                       ->setOption('footer-right', 'Trang [page]');
                    return $pdf->inline($filename);
                }
            }
        }else{
            if ($request->day != '') {
                $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getSchedule($case);
                if(!empty($schedule)){ //print_r($schedule);
                    if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $newday.' '.$schedule->time_end;
                    }else{
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $recent_day.' '.$schedule->time_end;
                    }
                }else{
                    $schedule = Statistic::getAllSchedule();
                    $startCa1 = $schedule[0]->time_start;
                    $endCa3 = $schedule[count($schedule)-1]->time_end;
                    $fromCase = $recent_day.' '.$startCa1;
                    $toCase = $newday.' '.$endCa3;
                }
              
                $dataResult = Statistic::listDayOrder($fromCase, $toCase,$order_status,'print');
            // dd($dataResult);
                //if($request->has('download')){ 
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
                    //$old_limit = ini_set("memory_limit", "128M"); 
                    //$pdf = PDF::loadView('demo',$data)->setPaper('a4', 'landscape');
                    $filename = $request->day.'-report_day.pdf';
                    //return $pdf->download($filename);
                    //return view('demo',$data);
                    $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
                              ->setOption('margin-top', 12)
                              ->setOption('margin-bottom', 12)
                              //->setOption('margin-left', 0)
                              //->setOption('margin-right', 0)
                             // ->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
                              //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
                              ->setOption('footer-right', 'Trang [page]');
                    return $pdf->inline( $filename);
                    
                //}
            }else{ 
                $time = new DateTime('NOW');
                $today = $time->format('d-m-Y');
                $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $fromCase = $recent_day.' '.$startCa1;
                $toCase = $newday.' '.$endCa3;
                $dataResult = Statistic::listDayOrder( $fromCase, $toCase,0,'print');
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
                        $data['totalTK'] = $dataResult['totalTK'];
                        $data['totalCombo'] = $dataResult['totalCombo'];
                        $data['order_status'] = $order_status;
                    }else{
                        $data['status'] = false;
                    }
                     $filename = date('Y-m-d', time()) .'-report_day.pdf';
                    //return $pdf->download($filename);
                     $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
                       ->setPaper('a4')
                       ->setOption('margin-top', 12)
                       ->setOption('margin-bottom', 12)
                      //->setOption('margin-left', 0)
                      //->setOption('margin-right', 0)
                       //->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
                       //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
                       ->setOption('footer-right', 'Trang [page]');
                    return $pdf->inline($filename);
                    
                }
            }
        }
    }

    public function getStatisticMonth(Request $request){
        $year = $request->year ? $request->year : date('Y', time());
        $month = $request->month ? $request->month : date('m', time());
        $case = $request->case ? $request->case : 0;

        $checkCase = Statistic::checkCaseTomorrow($case);
        $data['checkCase'] = $checkCase;
        $data['month'] = $month;
        $data['year']  = $year;
        $data['case']  = $case;
        
        $listDays = Mylibs::getDays($month, $year);
        $numMonth = count($listDays);
        $schedule = Statistic::getAllSchedule();
        $data['schedule']  = $schedule;

        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;
        $startMonth = $year.'-'.$month.'-1 '.$startCa1;
        
        if( $month < 12 ){
            $month2 = $month + 1;
            $endMonth = $year.'-'.$month2.'-1 '.$endCa3;
        }else{
            $year2 = $year + 1;
            $endMonth = $year2.'-1-1 '.$endCa3;
        }

        $data['endMonth'] = $numMonth;
        if( $case > 0 ){
            $startCase = $schedule[$case-1]->time_start;
            $endCase = $schedule[$case-1]->time_end;
            $dataResult = Statistic::listMonthOrder($numMonth, $startMonth, $endMonth, $endCa3, $startCase, $endCase);
        }else{
            $dataResult = Statistic::listMonthOrder($numMonth, $startMonth, $endMonth, $endCa3);
        }
        
        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['data'] = $dataResult['data'];
            $data['data2'] = $dataResult['data2'];

            //taikhoan & combo
            $mangTK = array();
            $mangCB = array();
            if(empty($dataResult['taikhoan'])){
                $data['totalTK'] = 0;
            }else{
                $priceTotalTK = 0;                
                foreach($dataResult['taikhoan'] as $tkKey => $tk){
                    /*if( $tk->month != $month ){
                        unset($dataResult['taikhoan'][$tkKey]);
                    }else{*/
                        $priceTotalTK += $tk->priceTotalTK;
                        $mangTK[$tk->day] = $tk->priceTotalTK;    
                    //}
                }
                $data['totalTK'] = $priceTotalTK;
            }

            if(empty($dataResult['combo'])){
                $data['totalCombo'] = 0;
            }else{
                $priceTotalCB = 0;
                foreach($dataResult['combo'] as $cbKey => $cb){
                    /*if( $cb->month != $month ){
                        unset($dataResult['combo'][$cbKey]);
                    }else{*/
                        $priceTotalCB += $cb->priceTotalCB;
                        $mangCB[$cb->day] = $cb->priceTotalCB;
                    //}
                }
                $data['totalCombo'] = $priceTotalCB;
            }
            $data['taikhoan'] = $mangTK;
            $data['combo'] = $mangCB;            
            
            //taikhoan2 & combo2
            $mangTK2 = array();
            $mangCB2 = array();
            if(empty($dataResult['taikhoan2'])){
                $data['totalTK2'] = 0;
            }else{
                $priceTotalTK2 = 0;                
                foreach($dataResult['taikhoan2'] as $tk2){
                    $priceTotalTK2 += $tk2->priceTotalTK;
                    $mangTK2[$tk2->day] = $tk2->priceTotalTK;
                }
                $data['totalTK2'] = $priceTotalTK2;
            }

            if(empty($dataResult['combo2'])){
                $data['totalCombo2'] = 0;
            }else{
                $priceTotalCB2 = 0;
                foreach($dataResult['combo2'] as $cb2){
                    $priceTotalCB2 += $cb2->priceTotalCB;
                    $mangCB2[$cb2->day] = $cb2->priceTotalCB;
                }
                $data['totalCombo2'] = $priceTotalCB2;
            }
            $data['taikhoan2'] = $mangTK2;
            $data['combo2'] = $mangCB2;

            //data
            $sumCountAll = 0;
            $sumTotalAll = 0;
            $sumCountSuccess = 0;
            $sumTotalSuccess = 0;
            $sumCountWait = 0;
            $sumCountPay = 0;
            $sumCountCancel = 0;

            $sumCountAll2 = 0;
            $sumTotalAll2 = 0;
            $sumCountSuccess2 = 0;
            $sumTotalSuccess2 = 0;
            $sumCountWait2 = 0;
            $sumCountPay2 = 0;
            $sumCountCancel2 = 0;
            
            foreach($dataResult['data'] as $k => $v){
                $sumCountAll += $v->sumCount;
                $sumTotalAll += $v->sumTotal;
                $sumCountSuccess += $v->sumFinish;
                $sumTotalSuccess += $v->sumFinishPrice;
                $sumCountWait += $v->sumWait;
                $sumCountPay += $v->sumPay;
                $sumCountCancel += $v->sumCancel;

                $sumCountAll2 += $v->sumCount2;
                $sumTotalAll2 += $v->sumTotal2;
                $sumCountSuccess2 += $v->sumFinish2;
                $sumTotalSuccess2 += $v->sumFinishPrice2;
                $sumCountWait2 += $v->sumWait2;
                $sumCountPay2 += $v->sumPay2;
                $sumCountCancel2 += $v->sumCancel2;
            }

            if( $case > 0 && $checkCase ){
                foreach($dataResult['data2'] as $k2 => $v2){
                    $sumCountAll += $v2->sumCount;
                    $sumTotalAll += $v2->sumTotal;
                    $sumCountSuccess += $v2->sumFinish;
                    $sumTotalSuccess += $v2->sumFinishPrice;
                    $sumCountWait += $v2->sumWait;
                    $sumCountPay += $v2->sumPay;
                    $sumCountCancel += $v2->sumCancel;

                    $sumCountAll2 += $v2->sumCount2;
                    $sumTotalAll2 += $v2->sumTotal2;
                    $sumCountSuccess2 += $v2->sumFinish2;
                    $sumTotalSuccess2 += $v2->sumFinishPrice2;
                    $sumCountWait2 += $v2->sumWait2;
                    $sumCountPay2 += $v2->sumPay2;
                    $sumCountCancel2 += $v2->sumCancel2;
                }
            }

            $data['sumCountAll'] = $sumCountAll;
            $data['sumTotalAll'] = $sumTotalAll;
            $data['sumCountSuccess'] = $sumCountSuccess;
            $data['sumTotalSuccess'] = $sumTotalSuccess;
            $data['sumCountWait'] = $sumCountWait;
            $data['sumCountPay'] = $sumCountPay;
            $data['sumCountCancel'] = $sumCountCancel;

            $data['sumCountAll2'] = $sumCountAll2;
            $data['sumTotalAll2'] = $sumTotalAll2;
            $data['sumCountSuccess2'] = $sumCountSuccess2;
            $data['sumTotalSuccess2'] = $sumTotalSuccess2;
            $data['sumCountWait2'] = $sumCountWait2;
            $data['sumCountPay2'] = $sumCountPay2;
            $data['sumCountCancel2'] = $sumCountCancel2;

        }else{
            $data['month'] = $month;
            $data['status'] = false; 
        }
        $data['timeInADay'] = Mylibs::timeInADay();
        $data['timeInADay_start'] = Mylibs::timeInADay_start();

        return view('backend.statistic.statisticMonth', $data);
    }


    public function getStatisticYear(Request $request){
        $year = $request->year ? $request->year : date('Y', time());
        $case = $request->case ? $request->case : 0;

        $checkCase = Statistic::checkCaseTomorrow($case);
        $data['checkCase'] = $checkCase;
        $data['year']  = $year;
        $data['case']  = $case;

        $schedule = Statistic::getAllSchedule();
        $data['schedule']  = $schedule;

        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;
        $startYear = $year.'-1-1 '.$startCa1;
        $endYear = ($year+1).'-1-1 '.$endCa3;
        
        if( $case > 0 ){
            $startCase = $schedule[$case-1]->time_start;
            $endCase = $schedule[$case-1]->time_end;
            $dataResult = Statistic::listYearOrder($year, $startYear, $endYear, $endCa3, $startCase, $endCase);
        }else{
            $dataResult = Statistic::listYearOrder($year, $startYear, $endYear, $endCa3);
        }

        if( $dataResult['status'] ){
            $data['status'] = true;
            $data['data'] = $dataResult['data'];
            $data['data2'] = $dataResult['data2'];
            $data['data3'] = $dataResult['data3'];

            $data['arr_taikhoan'] = $dataResult['taikhoan'];
            $data['arr_taikhoan2'] = $dataResult['taikhoan2'];
            $data['arr_taikhoan3'] = $dataResult['taikhoan3'];

            $data['arr_combo'] = $dataResult['combo'];
            $data['arr_combo2'] = $dataResult['combo2'];
            $data['arr_combo3'] = $dataResult['combo3'];

            //tai khoan & combo
            $mangTK = array();
            $mangCB = array();
            if(empty($dataResult['taikhoan'])){
                $data['totalTK'] = 0;
            }else{
                $priceTotalTK = 0;                
                foreach($dataResult['taikhoan'] as $tk){
                    $priceTotalTK += $tk->priceTotalTK;
                    $mangTK[$tk->month] = $tk->priceTotalTK;
                }
                $data['totalTK'] = $priceTotalTK;
            }

            if(empty($dataResult['combo'])){
                $data['totalCombo'] = 0;
            }else{
                $priceTotalCB = 0;
                foreach($dataResult['combo'] as $cb){
                    $priceTotalCB += $cb->priceTotalCB;
                    $mangCB[$cb->month] = $cb->priceTotalCB;
                }
                $data['totalCombo'] = $priceTotalCB;
            }
            $data['taikhoan'] = $mangTK;
            $data['combo'] = $mangCB;
            
            //taikhoan2 & combo2
            $mangTK2 = array();
            $mangCB2 = array();
            if(empty($dataResult['taikhoan2'])){
                $data['totalTK2'] = 0;
            }else{
                $priceTotalTK2 = 0;                
                foreach($dataResult['taikhoan2'] as $tk2){
                    $priceTotalTK2 += $tk2->priceTotalTK;
                    $mangTK2[$tk2->month] = $tk2->priceTotalTK;
                }
                $data['totalTK2'] = $priceTotalTK2;
            }
            if(empty($dataResult['combo2'])){
                $data['totalCombo2'] = 0;
            }else{
                $priceTotalCB2 = 0;
                foreach($dataResult['combo2'] as $cb2){
                    $priceTotalCB2 += $cb2->priceTotalCB;
                    $mangCB2[$cb2->month] = $cb2->priceTotalCB;
                }
                $data['totalCombo2'] = $priceTotalCB2;
            }
            $data['taikhoan2'] = $mangTK2;
            $data['combo2'] = $mangCB2;

            //taikhoan3 & combo3
            $mangTK3 = array();
            $mangCB3 = array();
            if(empty($dataResult['taikhoan3'])){
                $data['totalTK3'] = 0;
            }else{
                $priceTotalTK3 = 0;                
                foreach($dataResult['taikhoan3'] as $tk3){
                    $priceTotalTK3 += $tk3->priceTotalTK;
                    $mangTK3[$tk3->month] = $tk3->priceTotalTK;
                }
                $data['totalTK3'] = $priceTotalTK3;
            }
            if(empty($dataResult['combo3'])){
                $data['totalCombo3'] = 0;
            }else{
                $priceTotalCB3 = 0;
                foreach($dataResult['combo3'] as $cb3){
                    $priceTotalCB3 += $cb3->priceTotalCB;
                    $mangCB3[$cb3->month] = $cb3->priceTotalCB;
                }
                $data['totalCombo3'] = $priceTotalCB3;
            }
            $data['taikhoan3'] = $mangTK3;
            $data['combo3'] = $mangCB3;

            //
            $sumCountAll = 0;
            $sumTotalAll = 0;
            $sumCountSuccess = 0;
            $sumTotalSuccess = 0;
            $sumCountWait = 0;
            $sumCountPay = 0;
            $sumCountCancel = 0;

            $sumCountAll2 = 0;
            $sumTotalAll2 = 0;
            $sumCountSuccess2 = 0;
            $sumTotalSuccess2 = 0;
            $sumCountWait2 = 0;
            $sumCountPay2 = 0;
            $sumCountCancel2 = 0;

            foreach($dataResult['data'] as $k => $v){
                $sumCountAll += $v->sumCount;
                $sumTotalAll += $v->sumTotal;
                $sumCountSuccess += $v->sumFinish;
                $sumTotalSuccess += $v->sumFinishPrice;
                $sumCountWait += $v->sumWait;
                $sumCountPay += $v->sumPay;
                $sumCountCancel += $v->sumCancel;

                $sumCountAll2 += $v->sumCount2;
                $sumTotalAll2 += $v->sumTotal2;
                $sumCountSuccess2 += $v->sumFinish2;
                $sumTotalSuccess2 += $v->sumFinishPrice2;
                $sumCountWait2 += $v->sumWait2;
                $sumCountPay2 += $v->sumPay2;
                $sumCountCancel2 += $v->sumCancel2;
            }

            if( $case > 0 && $checkCase ){
                foreach($dataResult['data3'] as $k3 => $v3){ 
            
                    $sumCountAll += $v3->sumCount;
                    $sumTotalAll += $v3->sumTotal;
                    $sumCountSuccess += $v3->sumFinish;
                    $sumTotalSuccess += $v3->sumFinishPrice;
                    $sumCountWait += $v3->sumWait;
                    $sumCountPay += $v3->sumPay;
                    $sumCountCancel += $v3->sumCancel;

                    $sumCountAll2 += $v3->sumCount2;
                    $sumTotalAll2 += $v3->sumTotal2;
                    $sumCountSuccess2 += $v3->sumFinish2;
                    $sumTotalSuccess2 += $v3->sumFinishPrice2;
                    $sumCountWait2 += $v3->sumWait2;
                    $sumCountPay2 += $v3->sumPay2;
                    $sumCountCancel2 += $v3->sumCancel2;
                }
            }

            $data['sumCountAll'] = $sumCountAll;
            $data['sumTotalAll'] = $sumTotalAll;
            $data['sumCountSuccess'] = $sumCountSuccess;
            $data['sumTotalSuccess'] = $sumTotalSuccess;
            $data['sumCountWait'] = $sumCountWait;
            $data['sumCountPay'] = $sumCountPay;
            $data['sumCountCancel'] = $sumCountCancel;

            $data['sumCountAll2'] = $sumCountAll2;
            $data['sumTotalAll2'] = $sumTotalAll2;
            $data['sumCountSuccess2'] = $sumCountSuccess2;
            $data['sumTotalSuccess2'] = $sumTotalSuccess2;
            $data['sumCountWait2'] = $sumCountWait2;
            $data['sumCountPay2'] = $sumCountPay2;
            $data['sumCountCancel2'] = $sumCountCancel2;
            
        }else{            
            $data['status'] = false; 
        }
        $data['timeInADay'] = Mylibs::timeInADay();
        $data['timeInADay_start'] = Mylibs::timeInADay_start();
        
        return view('backend.statistic.statisticYear', $data);
    }

    public function getStatisticCategory(Request $request){
        if( $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;

            /*$from2 = DateTime::createFromFormat('d-m-Y', $from)->format('Y-m-d');
            $to2 = DateTime::createFromFormat('d-m-Y', $to)->add(new DateInterval('P1D'))->format('Y-m-d');

            $schedule = Statistic::getAllSchedule();
            $startCa1 = $schedule[0]->time_start;
            $endCa3 = $schedule[count($schedule)-1]->time_end;
            $fromCase = $from2.' '.$startCa1;
            $toCase = $to2.' '.$endCa3;*/

            $fromCase = DateTime::createFromFormat('d-m-Y H:i', $from)->format('Y-m-d H:i');
            $toCase = DateTime::createFromFormat('d-m-Y H:i', $to)->format('Y-m-d H:i');
            
            if($fromCase > $toCase){
                $data['error'] = 'Thời điểm kết thúc phải lớn hơn thời điểm bắt đầu';
            }else{                
                $dataResult = Statistic::reportCategory($fromCase, $toCase);
                $data['totalPrice'] = $dataResult['totalPrice'];
                $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
                $data['listProduct'] = $dataResult['listProduct'];
                $data['listIdProduct'] = $dataResult['listIdProduct'];
                $data['listOder'] = $dataResult['listOder'];
                $data['from'] = $from;
                $data['to'] = $to;
                $data['totalTK'] = $dataResult['totalTK'];
                $data['totalCombo'] = $dataResult['totalCombo'];
                $data['listOption'] = $dataResult['listOption'];
                $data['listIdOptions'] = $dataResult['listIdOptions'];
            }
        }else{
            $dataResult = Statistic::reportCategory();
            $data['totalPrice'] = $dataResult['totalPrice'];
            $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
            $data['listProduct'] = $dataResult['listProduct'];
            $data['listIdProduct'] = $dataResult['listIdProduct'];
            $data['listOder'] = $dataResult['listOder'];
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
            $data['listOption'] = $dataResult['listOption'];
            $data['listIdOptions'] = $dataResult['listIdOptions'];
        }
        return view('backend.statistic.statisticCategory', $data);
    }

    public function exportExcel(Request $request){
        $type = 'xls';
        if( $request->from && $request->to){
            $from = $request->from;
            $to = $request->to;

            /*$from2 = DateTime::createFromFormat('d-m-Y', $from)->format('Y-m-d');
            $to2 = DateTime::createFromFormat('d-m-Y', $to)->add(new DateInterval('P1D'))->format('Y-m-d');

            $schedule = Statistic::getAllSchedule();
            $startCa1 = $schedule[0]->time_start;
            $endCa3 = $schedule[count($schedule)-1]->time_end;
            $fromCase = $from2.' '.$startCa1;
            $toCase = $to2.' '.$endCa3;*/
            
            $fromCase = DateTime::createFromFormat('d-m-Y H:i', $from)->format('Y-m-d H:i');
            $toCase = DateTime::createFromFormat('d-m-Y H:i', $to)->format('Y-m-d H:i');
            
            if($fromCase > $toCase){
                $data['error'] = 'Thời điểm kết thúc phải lớn hơn thời điểm bắt đầu';
            }else{                
                $dataResult = Statistic::reportCategory($fromCase, $toCase);
                $data['totalPrice'] = $dataResult['totalPrice'];
                $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
                $data['listProduct'] = $dataResult['listProduct'];
                $data['listIdProduct'] = $dataResult['listIdProduct'];
                $data['listOder'] = $dataResult['listOder'];
                $data['from'] = $from;
                $data['to'] = $to;
                $data['totalTK'] = $dataResult['totalTK'];
                $data['totalCombo'] = $dataResult['totalCombo'];
                $data['listOption'] = $dataResult['listOption'];
                $data['listIdOptions'] = $dataResult['listIdOptions'];
            }
        }else{
            $dataResult = Statistic::reportCategory();
            $data['totalPrice'] = $dataResult['totalPrice'];
            $data['optionTotalPrice'] = $dataResult['optionTotalPrice'];
            $data['listProduct'] = $dataResult['listProduct'];
            $data['listIdProduct'] = $dataResult['listIdProduct'];
            $data['listOder'] = $dataResult['listOder'];
            $data['totalTK'] = $dataResult['totalTK'];
            $data['totalCombo'] = $dataResult['totalCombo'];
            $data['listOption'] = $dataResult['listOption'];
            $data['listIdOptions'] = $dataResult['listIdOptions'];
        }
        $data_excel = array();
        $data_item = array();

        if(!empty($data)){
            foreach($data['listOder'] as $k => $v){
                foreach($data['listProduct'] as $key => $value){
                    if( $v->product_id == $value->product_id ){
                        $data_item['produtct_name'] = $v->product_name;
                        $data_item['category_name'] =$value->category_name ;                            
                        $data_item['qty'] = $v->qtyTotal;
                        //$data_item['single_price'] =  $value->product_price;
                        $data_item['total_price'] =  $v->priceTotal-$v->priceOption;
                        $data_item['status'] =  '';

                        $data_excel[] = $data_item;
                    }
                }
                if( !in_array($v->product_id, $data['listIdProduct']) ){
                    $data_item['produtct_name'] = $v->product_name;
                    $data_item['category_name'] = '';                            
                    $data_item['qty'] = $v->qtyTotal;
                    //$data_item['single_price'] =  $value->product_price;
                    $data_item['total_price'] =  $v->priceTotal-$v->priceOption;
                    $data_item['status'] =  'Ngừng kinh doanh';

                    $data_excel[] = $data_item;
                }
            } 
        }
         
        $data_option = array();
        $data_itemOption = array();

        foreach($data['listOption'] as $key2 => $value2){
            if(in_array($key2,$data['listIdOptions'])){
                $data_itemOption['name'] = $value2['name'];
                $data_itemOption['qty'] = (int)$value2['qty'];
                $data_itemOption['total'] =  $value2['total'];
                $data_itemOption['status'] =  '';

                $data_option[] = $data_itemOption;
            }else{
                $data_itemOption['name'] = $value2['name'];
                $data_itemOption['qty'] = (int)$value2['qty'];
                $data_itemOption['total'] =  $value2['total'];
                $data_itemOption['status'] =  'Ngừng kinh doanh';

                $data_option[] = $data_itemOption;
            }
        }

        Excel::create('san_pham_ban_chay', function($excel) use ($data_excel,$data_option,$data) {
            $excel->sheet('san_pham', function($sheet) use ($data_excel,$data)
            {
                $sheet->fromArray($data_excel);
                //Manipulate first row
                $sheet->row(1, array(
                     'Sản phẩm', 'Nhóm hàng','Số lượng','Thành tiền','Trạng thái'
                ));
                $sheet->appendRow(array(
                    'Tổng tiền Option:','','',$data['optionTotalPrice']
                ));
                $sheet->appendRow(array(
                    'Tổng tiền (không bao gồm tiền nạp tài khoản và combo):', '','', number_format(($data['totalPrice'] - $data['totalTK'] - $data['totalCombo']),'0',',','.')
                ));
                $sheet->appendRow(array(
                    'Tổng tiền :', '','', number_format($data['totalPrice'],'0',',','.')
                ));
            });
            $excel->sheet('options', function($sheet) use ($data_option,$data)
            {
                $sheet->fromArray($data_option);
                //Manipulate first row
                $sheet->row(1, array(
                     'Options', 'Số lượng','Thành tiền','Trạng thái'
                ));
                $sheet->appendRow(array(
                    'Tổng tiền Option:','',$data['optionTotalPrice']
                ));
            });
        })->download($type);

        

        /*Excel::create('option_ban_chay', function($excel) use ($data_option,$data) {
            $excel->sheet('mySheet', function($sheet) use ($data_option,$data)
            {
                $sheet->fromArray($data_option);
                //Manipulate first row
                $sheet->row(1, array(
                     'Options', 'Số lượng','Thành tiền','Trạng thái'
                ));
                $sheet->appendRow(array(
                    'Tổng tiền Option:','','',$data['optionTotalPrice']
                ));
            });
        })->download($type);*/
    }
    //Laravel <= 5.2 
    /*public function basic_email(){
        $data = ['name'=>'Hoàng khôi Test'];
        Mail::send(['text'=>'mail'],$data,function($message){
            $message->to('hoangkhoik5@gmail.com','hello ')->subject('Send mail from Laravel with Basic');
            $message->from('hello@app.com', 'Your Application');       
        });
        echo 'Basic Email was sent';
    }
     public function attachment_email(){
        $data = ['name'=>'kkk'];
        Mail::send(['text'=>'mail'],$data,function($message){
            $message->to('hoangkhoik5@gmail.com','hello ')->subject('Send mail from Laravel with Basic');
            //add attach here
            $message->attach(public_path().'/images/logo_order.png');
            //$message->attach(public_path().'/images/logo_order.png');
            $message->from('hello@app.com', 'Your Application');
            
        });
        echo 'Basic Email was sent';
    }*/

    public function basic_email(Request $request,Mailer $mailer){
        $mailer->to('hoangkhoik5@gmail.com')
               ->send(new ReportDay('title here'));
    }

    public function sentMail(Request $request,Mailer $mailer){
        /*$case = $request->case;
        $order_status = $request->order_status;
        if ($request->day != '') {
            $dayEmail = $request->day;
            $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
            $schedule = Statistic::getSchedule($case);
            if(!empty($schedule)){ //print_r($schedule);
                if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                    $fromCase = $recent_day.' '.$schedule->time_start;
                    $toCase = $newday.' '.$schedule->time_end;
                }else{
                    $fromCase = $recent_day.' '.$schedule->time_start;
                    $toCase = $recent_day.' '.$schedule->time_end;
                }
            }else{
                $schedule = Statistic::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $fromCase = $recent_day.' '.$startCa1;
                $toCase = $newday.' '.$endCa3;
            }
          
            $dataResult = Statistic::listDayOrder($recent_day,$fromCase, $toCase,$order_status,'print');
      
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
        }else{ 
            $time = new DateTime('NOW');
            $today = $time->format('d-m-Y');
            $dayEmail = DateTime::createFromFormat('d-m-Y', $today)->format('d-m-Y'); 
            $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');
            $schedule = Statistic::getAllSchedule();
            $startCa1 = $schedule[0]->time_start;
            $endCa3 = $schedule[count($schedule)-1]->time_end;
            $fromCase = $recent_day.' '.$startCa1;
            $toCase = $newday.' '.$endCa3;
            $dataResult = Statistic::listDayOrder($recent_day, $fromCase, $toCase,0,'print');
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
                   
       
        }*/

        $case = $request->case;
        $order_status = $request->order_status;

        if($request->search_day_hour == 1 ){
            if( $request->day_hour_from != '' && $request->day_hour_to != '' ){
                $fromCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_from)->format('Y-m-d H:i');
                $toCase = DateTime::createFromFormat('d-m-Y H:i', $request->day_hour_to)->format('Y-m-d H:i');

                $dataResult = Statistic::listDayOrder($fromCase, $toCase,$order_status,'print');
                // dd($dataResult);
                //if($request->has('download')){ 
                if( $dataResult['status'] ){
                    $data['status'] = true;
                    $data['day'] = $request->day_hour_from.' - '.$request->day_hour_to;
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
                $dayEmail = $request->day_hour_from.' - '.$request->day_hour_to;
            }else{
                $time = new DateTime('NOW');
                $today = $time->format('d-m-Y');
                $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $fromCase = $recent_day.' '.$startCa1;
                $toCase = $newday.' '.$endCa3;
                $dataResult = Statistic::listDayOrder( $fromCase, $toCase,0,'print');
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
                        $data['totalTK'] = $dataResult['totalTK'];
                        $data['totalCombo'] = $dataResult['totalCombo'];
                        $data['order_status'] = $order_status;
                    }else{
                        $data['status'] = false;
                    }
                }
                $dayEmail = DateTime::createFromFormat('d-m-Y', $today)->format('d-m-Y'); 
            }
        }else{
            if ($request->day != '') {
                $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getSchedule($case);
                if(!empty($schedule)){ //print_r($schedule);
                    if( strtotime($schedule->time_start) >= strtotime($schedule->time_end)){
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $newday.' '.$schedule->time_end;
                    }else{
                        $fromCase = $recent_day.' '.$schedule->time_start;
                        $toCase = $recent_day.' '.$schedule->time_end;
                    }
                }else{
                    $schedule = Statistic::getAllSchedule();
                    $startCa1 = $schedule[0]->time_start;
                    $endCa3 = $schedule[count($schedule)-1]->time_end;
                    $fromCase = $recent_day.' '.$startCa1;
                    $toCase = $newday.' '.$endCa3;
                }
              
                $dataResult = Statistic::listDayOrder($fromCase, $toCase,$order_status,'print');
            // dd($dataResult);
                //if($request->has('download')){ 
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
                    $dayEmail = $request->day;
                //}
            }else{ 
                $time = new DateTime('NOW');
                $today = $time->format('d-m-Y');
                $recent_day = DateTime::createFromFormat('d-m-Y', $today)->format('Y-m-d'); 
                $newday = DateTime::createFromFormat('d-m-Y', $today)->add(new DateInterval('P1D'))->format('Y-m-d');
                $schedule = Statistic::getAllSchedule();
                $startCa1 = $schedule[0]->time_start;
                $endCa3 = $schedule[count($schedule)-1]->time_end;
                $fromCase = $recent_day.' '.$startCa1;
                $toCase = $newday.' '.$endCa3;
                $dataResult = Statistic::listDayOrder( $fromCase, $toCase,0,'print');
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
                        $data['totalTK'] = $dataResult['totalTK'];
                        $data['totalCombo'] = $dataResult['totalCombo'];
                        $data['order_status'] = $order_status;
                    }else{
                        $data['status'] = false;
                    }
                }
                $dayEmail = DateTime::createFromFormat('d-m-Y', $today)->format('d-m-Y');
            }
        }

        $titleCa = '';
        if ($case != 0 && $request->search_day_hour != 1) {
            $titleCa = ' Ca ' . $case;
        }
        $filename = $dayEmail.'-'.strtotime($fromCase).'.pdf';
        if (file_exists(public_path().'/report/' .$filename)) {
            File::delete(public_path().'/report/' .$filename);
        }
        $pdf = SPDF::loadView('backend.statistic.printDay',['data'=> $data])
           ->setPaper('a4')
           ->setOption('margin-top', 12)
           ->setOption('margin-bottom', 12)
           //->setOption('margin-left', 0)
           //->setOption('margin-right', 0)
           //->setOption('header-html', base_path('resources/views/backend/statistic/printHeader.html'))
           //->setOption('footer-html', base_path('resources/views/backend/statistic/printFooter.html'))
           ->setOption('footer-right', 'Trang [page]')->save(public_path().'/report/' .$filename);
        $arr  = Config::get('vgmmail.to') ;
        Mail::to($arr)->send(new ReportTime('Báo cáo ngày '. $dayEmail . $titleCa , $filename));
        return redirect()->back()->with(['flash_message_succ'=> 'Đã gửi mail thành công']);
    }

    public function getAjaxStatisticDay1(Request $request){
        //if ($request->ajax()) {
            $data = Statistic::listAjaxStatisticDay1($request);
            return json_encode($data);
        /*}else{
            return 'You can not permitsion';
        }*/
    }

    public function getAjaxStatisticDay2(Request $request){
        //if ($request->ajax()) {
            $data = Statistic::listAjaxStatisticDay2($request);
            return json_encode($data);
        /*}else{
            return 'You can not permitsion';
        }*/
    }
}
