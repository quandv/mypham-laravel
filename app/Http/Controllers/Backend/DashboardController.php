<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\Models\Access\User;
use App\Models\Backend\Dashboard;
use Validator;
use Illuminate\Support\Facades\Hash;
use File;
use App\Mylibs\Mylibs;
use App\Mylibs\ResizeImage;
use DB;
use DateTime;
use DateInterval;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function __construct(){
   /*     if (access()->hasRole(4) && !access()->hasRole(1)) {
            return redirect()->route('admin.order.approved');
        }
        if (access()->hasRole(2) && !access()->hasRole(1)) {
            return redirect()->route('admin.order.pending');
        }
        */
        
    }
    public function welcome(Request $request){
        return view('backend.welcome');
    }
    public function index(Request $request)
    {
        if (!empty($request->day)) {
            $recent_day = DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d'); 
            $newday = DateTime::createFromFormat('d-m-Y', $request->day)->add(new DateInterval('P1D'))->format('Y-m-d');
        }else{
            $recent_day = new DateTime('NOW');
            $recent_day = $recent_day->format('Y-m-d');
            $newday = new DateTime('+1 day');
            $newday = $newday->format('Y-m-d'); 
        }
        $case = $request->case;
        $schedule = Dashboard::getSchedule($case);
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
    
        $scheduleAll = Dashboard::getAllSchedule();
        $dataResult['schedule'] = $scheduleAll;

        $data = Dashboard::sum_total_order($fromCase,$toCase,$request);        

        $toTalStatus = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        );

        if (!empty($data['data']) && count($data['data']) > 0) {
            
            $dataResult['all'] = $data['r_display'];
            
            foreach($data['data'] as $key => $val){
                if( array_key_exists($val->order_status, $toTalStatus) ){
                    $toTalStatus[$val->order_status] += $val->toTalStatus;
                }else{
                    $toTalStatus[$val->order_status] = $val->toTalStatus;
                }
            }
        }
        $dataResult['toTalStatus'] = $toTalStatus;

        //Chart - Thống kê doanh thu theo ngày
        $today = date("Y-m-d");
        $dataResult['today'] = date('d-m-Y', strtotime($today));
        $startCa1 = $scheduleAll[0]->time_start;
        $arrHour = array();
        foreach($data['data2'] as $key2 => $val2){
            $arrHour[] = $val2->hour;
        }
        for($i=0;$i<24;$i++){
            if( !in_array($i, $arrHour) ){
                $arr2 = array(
                        'hour' => $i,
                        'toTalAll' => 0
                    );
                $data['data2']->push((object)$arr2);
            }
        }

        foreach( $data['data2'] as $key3 => $val3){
            if( $val3->hour < $startCa1 ){
                $newDay = date('Y-m-d',strtotime('+1 day',strtotime($today)));
                $data['data2'][$key3]->dateTime = $newDay." ".$val3->hour.":00:00";
            }else{
                $data['data2'][$key3]->dateTime = $today." ".$val3->hour.":00:00";
            }
        }
        $dataResult['data2'] = $data['data2'];

        $dataResult['timeInADay'] = Mylibs::timeInADay();
        $dataResult['timeInADay_start'] = Mylibs::timeInADay_start();

        return view('backend.dashboard',['data'=>$dataResult]);
    }

    public function getProfile(){
        return view('backend.user.profile');
    }
    public function postProfile(Request $request){
        $rules = [
            'changeAvatar' => 'file|image|mimes:jpeg,jpg,png|max:5000'
        ];
        $messages = [
            'changeAvatar.image'=>'Định dạng bạn nhập chưa đúng',
            'changeAvatar.max'=>'Kích thước file phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if($request->hasFile('changeAvatar')){
            if($request->file('changeAvatar')->isValid() ){
                if ($validator->fails()) {
                    // Validator fail
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('changeAvatar')->getClientOriginalName();
                    $destinationPath = 'uploads/users/';
                    //$request->file('changeAvatar')->move($destinationPath,$filename);
                    $resize = new ResizeImage($request->file('changeAvatar')->getPathName());
                    $resize->resizeTo(150, 150, 'exact');
                    $resize->saveImage($destinationPath.$filename);     
                    $user = User::findOrFail(Auth::user()->id);
                    if (!empty($user->avatar)) {
                        if (file_exists(public_path().'/uploads/users/'.$user->avatar)) {
                            File::delete(public_path().'/uploads/users/'.$user->avatar);
                        }
                    }
                    $user->avatar = $filename;
                    $user->save();
                    return redirect()->back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }
        }else{
            return redirect()->back()->with(['flash_message_err' => 'Bạn chưa chọn ảnh']);
        }

    }
    public function postChangepass(Request $request){
        $rules = [
            'password_current' =>'required',
            'password'=>'required|min:6|max:32|confirmed',
            'password_confirmation'=>'required|min:6|max:32',
        ];
        $messages = [
            'password_current.required'=>'Bạn chưa nhập password hiện tại',
            'password.required'=>'Bạn chưa nhập password',
            'password_confirmation.required'=>'Bạn chưa nhập lại password',
            'password.min'=> 'Mật khẩu phải có từ 6 ký tự trở lên',
            'password.max'=>'Mật khẩu phải nhỏ hơn 32 ký tự',
            'password_confirmation.min'=> 'Mật khẩu phải có từ 6 ký tự trở lên',
            'password_confirmation.max'=>'Mật khẩu phải nhỏ hơn 32 ký tự',
            'password.confirmed'=>'Mật khẩu nhập lại chưa đúng',

        ];
        $pass = $request->input('password_current');
        $user = User::find(Auth::user()->id);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->after(function($validator) use ($pass,$user)  {
            if (!Hash::check($pass,$user->password)){
                $validator->errors()->add('field', 'Mật khẩu hiện tại ko chính xác !');
            }
        });

        if ($validator->fails()) {
            //validator false
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
             $user->password = bcrypt($request->input('password'));
             $user->save();
             return redirect()->route('admin.profile')->with(['flash_message_succ' => 'Thay đổi mật khẩu thành Công']);;

        }
    }

    public function chartDay(Request $request){
        $day = $request->day;
        $day = date('Y-m-d', strtotime($day));

        $schedule = Dashboard::getAllSchedule();
        $startCa1 = $schedule[0]->time_start;
        $endCa3 = $schedule[count($schedule)-1]->time_end;

        $data = Dashboard::sumTotalForDay($day, $startCa1, $endCa3);
        //Chart - Thống kê doanh thu theo ngày
        $arrHour = array();
        foreach($data as $key2 => $val2){
            $arrHour[] = $val2->hour;
        }
        for($i=0;$i<24;$i++){
            if( !in_array($i, $arrHour) ){
                $arr2 = array(
                        'hour' => $i,
                        'toTalAll' => 0
                    );
                $data->push((object)$arr2);
            }
        }

        foreach( $data as $key3 => $val3){
            if( $val3->hour < $startCa1 ){
                $newDay = date('Y-m-d',strtotime('+1 day',strtotime($day)));
                $data[$key3]->dateTime = $newDay." ".$val3->hour.":00:00";
            }else{
                $data[$key3]->dateTime = $day." ".$val3->hour.":00:00";    
            }
        }

        echo json_encode($data);
    }

    public function chartMonth(Request $request){
        $month = $request->month;
        $year = $request->year;

        $listDays = Mylibs::getDays($month, $year);
        $result = Dashboard::sumTotalForMonth($month,$year);
        $data = $result['data'];
        $data2 = $result['data2'];

        $arrDay = array();
        foreach($data as $key => $val){
            if($val->month == $month){
                $arrDay[] = $val->day;
            }
        }
        for($i=1;$i<=count($listDays);$i++){
            if( !in_array($i, $arrDay) ){
                $arr = array(
                    'dateTime'  => $year.'-'.$month.'-'.$i,
                    'day'   => $i,
                    'month' => $month,
                    'year'  => $year,
                    'toTalAll' => 0
                );
                $data->push((object)$arr);
            }
        }

        foreach($data as $key => $val){
            if($val->month != $month){
                $data->forget($key);
            }else{
                foreach($data2 as $kdata2 => $vdata2){
                    if( $val->day == count($listDays) ){
                        if($val->month != $vdata2->month && $vdata2->day == 1){
                            $data[$key]->toTalAll += $vdata2->toTalAll;
                        }
                    }
                    if( $val->month == $vdata2->month ){
                        if( $val->day == $vdata2->day ){
                            $data[$key]->toTalAll -= $vdata2->toTalAll;
                        }else if( $val->day == ($vdata2->day - 1) ){
                            $data[$key]->toTalAll += $vdata2->toTalAll;
                        }    
                    }
                    
                }
            }
        }
        
        /*foreach($data as $key => $val){
            if($val->year != $year){
                foreach($data as $key2 => $val2){
                    if( $val2->day == count($listDays) ){
                        $data[$key2]->toTalAll += $val->toTalAll;
                    }
                }
                $data->forget($key);
            }else{
                if($val->month != $month){
                    foreach($data as $key3 => $val3){
                        if( $val3->day == count($listDays) ){
                            $data[$key3]->toTalAll += $val->toTalAll;
                        }
                    }
                    $data->forget($key);
                }
            }
        }*/

        echo json_encode($data);
    }

    public function chartYear(Request $request){        
        $year = $request->year;

        $result = Dashboard::sumTotalForYear($year);
        $data = $result['data'];
        $data2 = $result['data2'];

        $arrMonth = array();
        foreach($data as $key => $val){
            if($val->year == $year){
                $arrMonth[] = $val->month;
            }
        }
        for($i=1;$i<=12;$i++){
            if( !in_array($i, $arrMonth) ){
                $arr = array(
                    'dateTime'  => $year.'-'.$i,
                    'month' => $i,
                    'year'  => $year,
                    'toTalAll' => 0
                );
                $data->push((object)$arr);
            }
        }        

        foreach($data as $key => $val){
            if($val->year != $year){
                $data->forget($key);
            }else{
                foreach($data2 as $kdata2 => $vdata2){
                    if( $val->month == 12 ){
                        if($val->year != $vdata2->year && $vdata2->month == 1 && $vdata2->day == 1){
                            $data[$key]->toTalAll += $vdata2->toTalAll;
                        }
                    }
                    if( $val->year == $vdata2->year ){
                        if( $val->month == $vdata2->month ){
                            $data[$key]->toTalAll -= $vdata2->toTalAll;
                        }else if( $val->month == ($vdata2->month - 1) ){
                            $data[$key]->toTalAll += $vdata2->toTalAll;
                        }    
                    }
                    
                }
            }
        }
        /*
        foreach($data as $key => $val){
            if($val->year != $year){
                foreach($data as $key2 => $val2){
                    if( $val2->month == 12 ){
                        $data[$key2]->toTalAll += $val->toTalAll;
                    }
                }
                $data->forget($key);
            }
        }*/
        echo json_encode($data);
    }
}