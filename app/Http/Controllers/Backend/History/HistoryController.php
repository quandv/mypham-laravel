<?php

namespace App\Http\Controllers\Backend\History;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\History;
use App\Models\History\HistoryStore;
use App\Models\History\HistoryType;
use DateTime;
use App\Mylibs\Mylibs;

/*use Excel;
use PDF;*/
class HistoryController extends Controller
{
    
    public function getList(Request $request){
    	$data = History::getList($request);
    	return view('backend.history.index',['data'=>$data]);
    	
    }
    public function getReport(Request $request){
        if ($request->day_from != '' && $request->day_to  != '') {
            $recent_day = DateTime::createFromFormat('d-m-Y', $request->day_from)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $request->day_to)->format('Y-m-d'); 
            //$newday = DateTime::createFromFormat('d-m-Y', $request->day_from)->add(new DateInterval('P1D'))->format('Y-m-d');
        }else {
            $recent_day = new DateTime('NOW');
            $recent_day = $recent_day->format('Y-m-d');
            $newday = new DateTime('+1 day');
            $newday = $newday->format('Y-m-d'); 
        } 
        $case = $request->case;
        $schedule = History::getSchedule($case);
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
        $schedule = History::getAllSchedule();
        $data = History::getReport($request,$fromCase,$toCase);
        $tong_thoigian = History::getReport($request,$fromCase,$toCase,'thoigian_tb');
        $thoigian_tb = 0;
        if (!empty($tong_thoigian)) {
            if ($tong_thoigian->tong_qty > 0) {
                $thoigian_tb = $tong_thoigian->tong_time / $tong_thoigian->tong_qty;
            }
            
        }
        $data['timeInADay'] = Mylibs::timeInADay();
        $data['timeInADay_start'] = Mylibs::timeInADay_start();

        return view('backend.history.report',['data'=>$data,'schedule'=>$schedule,'thoigian_tb'=>$thoigian_tb, 'timeInADay'=>Mylibs::timeInADay() ,'timeInADay_start'=>Mylibs::timeInADay_start()]);

    }

    public function listAddOrderInput(Request $request){  
        $data = HistoryStore::where(function ($query) use ($request){
                    $query->where('type_id','1');
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
                    if ($request->input_search != '') {
                        if(is_numeric($request->input_search)){
                            $query->where('entity_id', '=',$request->input_search);
                        }else{
                            //$query->orwhere('name', 'LIKE', '%'.trim($request->user).'%');
                            $query->where('email', 'LIKE', '%'.trim($request->input_search).'%');
      
                        }
                    } 
                })->paginate(10);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value->content = json_decode($value->content,true);
            }
        }
        return view('backend.history.add_input_order',['data'=>$data]);
    }

    public function listEditOrderInput(Request $request){
        $data = HistoryStore::where(function ($query) use ($request){
                    $query->where('type_id','2');
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
                    if ($request->input_search != '') {
                        if(is_numeric($request->input_search)){
                            $query->where('entity_id', '=',$request->input_search);
                        }else{
                            //$query->orwhere('name', 'LIKE', '%'.trim($request->user).'%');
                            $query->where('email', 'LIKE', '%'.trim($request->input_search).'%');
      
                        }
                    } 
                })->paginate(10);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $value->content = json_decode($value->content,true);
            }
        }
        return view('backend.history.edit_input_order',['data'=>$data]);
    }

    public function listUpdateStsProduct(Request $request){
        $data = History::getStsProduct($request);
        $returnArr = array(
                'data'=>$data,
                'day_from'  => $request->day_from,
                'day_to'    => $request->day_to,
                'input_search' => $request->input_search,
                'input_status' => $request->input_status
            );
        return view('backend.history.status_product',$returnArr);
    }
    public function getProduct(Request $request){
        $select_box = HistoryType::where('id','>', 2)->get()->pluck('name','id');
        $data = History::getProductAll($request);        
        return view('backend.history.product',['data'=>$data,'select_box'=>$select_box]);
    }

}
