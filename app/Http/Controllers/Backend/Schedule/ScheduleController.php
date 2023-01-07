<?php

namespace App\Http\Controllers\Backend\Schedule;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Backend\Schedule;
use Validator;
use App\Mylibs\Mylibs;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {        
        $listSchedule = Schedule::listSchedule();
        $timeInADay = Mylibs::timeInADay();
        $timeInADay_start = Mylibs::timeInADay_start();

        $data = array(
                'schedules'   => $listSchedule,
                'timeInADay'  => $timeInADay,
                'timeInADay_start'    => $timeInADay_start
            );

        return view('backend.schedule.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $rules = [
            'schedule_name'   =>'required|min:3|unique:scheduletime,name',
        ];
        $messages = [
            'schedule_name.required'    =>'Bạn chưa nhập tên ca',
            'schedule_name.unique'      =>'Tên ca bị trùng lặp',
            'schedule_name.min'         =>'Tên ca phải có ít nhất 3 ký tự',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->time_start == '00:00:00' && $request->time_end == '00:00:00'){
                return redirect()->back()->with(['flash_message_err' => 'Mỗi ca ít nhất phải cách nhau 30 phút']);
            }else{
                $arr = [
                    'name'           => $request->schedule_name,
                    'time_start'     => $request->time_start,
                    'time_end'       => $request->time_end,
                ];

                Schedule::insert($arr);
                return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
            }
        }
    }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $details = Schedule::details($id);
        if( $details === false ){
            return redirect('schedule/index');
        }else{
            $listSchedule = Schedule::listSchedule();
            $timeInADay = Mylibs::timeInADay();
            $timeInADay_start = Mylibs::timeInADay_start();
            $data = array(
                    'schedules'     => $listSchedule,
                    'details'       => $details,
                    'id'            => $id,
                    'timeInADay'    => $timeInADay,
                    'timeInADay_start'    => $timeInADay_start
                );
            return view('backend.schedule.edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'schedule_name'   =>'required|min:3|unique:scheduletime,name,'.$id.',id',
        ];
        $messages = [
            'schedule_name.required'  =>'Bạn chưa nhập tên ca',
            'schedule_name.unique'    =>'Tên ca bị trùng lặp',
            'schedule_name.min'       =>'Tên ca phải có ít nhất 3 ký tự',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->time_start ==  '00:00:00' && $request->time_end == '00:00:00'){
                return redirect()->back()->with(['flash_message_err' => 'Mỗi ca ít nhất phải cách nhau 30 phút']);
            }else{
                $arr = [
                    'name'           => $request->schedule_name,
                    'time_start'     => $request->time_start,
                    'time_end'       => $request->time_end,
                ];

                Schedule::update($id, $arr);
                return redirect()->back()->with(['flash_message_succ' => 'Sửa thông tin thành công']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        Schedule::delSchedule($id);
        return redirect('admin/schedule');
    }

    /**
     * Search Schedule
     *
     * @param  string  $stxt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {        
        $stxt = $request->stxt;
        $listSchedule = Schedule::searchSchedule($stxt);
        $data = array(
                'Schedules'   => $listSchedule,
                'stxt'      => $stxt
            );
        
        return view('backend.schedule.s_result', $data);
    }
}