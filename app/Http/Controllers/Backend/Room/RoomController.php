<?php

namespace App\Http\Controllers\Backend\Room;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Room;
use Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listRoom = Room::listRoom();
        foreach($listRoom as $key => $val){
            $listRoom[$key]->room_ip = explode(',', $val->room_ip);
        }
        $data = array(
                'listRoom' => $listRoom
            );
        return view('backend.room.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$listRoom = Room::listRoom();
        $data = array(
                'listRoom' => $listRoom
            );
        
        return view('backend.room.index', $data);*/
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
            'room_name'   =>'required|min:3|unique:room,room_name',
            'room_ip.*'   =>'required|ip'
        ];
        $messages = [
            'room_name.required'  =>'Bạn chưa nhập tên phòng',
            'room_name.min'       =>'Tên phòng phải có ít nhất 3 ký tự',
            'room_name.unique'    =>'Tên phòng bị trùng lặp',
            'room_ip.*.required'  =>'Bạn chưa nhập IP',
            'room_ip.*.ip'        =>'Bạn chưa nhập đúng định dạng IP'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $room_ip = implode(',',array_unique($request->room_ip));
            $arr = [
                'room_name'   => $request->room_name,
                'room_ip'     => $room_ip
            ];
            Room::insert($arr);
            return redirect()->back()->with(['flash_message_succ' => 'Lưu thông tin thành công']);
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
        $details    = Room::details($id);
        $listRoom   = Room::listRoom();
        foreach($listRoom as $key => $val){
            $listRoom[$key]->room_ip = explode(',', $val->room_ip);
        }
        $details->room_ip = explode(',', $details->room_ip);        
        $data = array(
                'listRoom'  => $listRoom,
                'details'   => $details,
                'id'        => $id
            );
        return view('backend.room.edit', $data);
        
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
            'room_name'   =>'required|min:3|unique:room,room_name,'.$id.',room_id',
            'room_ip.*'   =>'required|ip'
        ];
        $messages = [
            'room_name.required'  =>'Bạn chưa nhập tên phòng',
            'room_name.min'       =>'Tên phòng phải có ít nhất 3 ký tự',
            'room_name.unique'    =>'Tên phòng bị trùng lặp',
            'room_ip.*.required'  =>'Bạn chưa nhập IP',
            'room_ip.*.ip'        =>'Bạn chưa nhập đúng định dạng IP'

        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{ 
            $room_ip = implode(',', array_unique($request->room_ip));
            $arr = [
                'room_name'   => $request->room_name,
                'room_ip'     => $room_ip
            ];

            Room::update($id, $arr);
            return redirect()->back()->with(['flash_message_succ' => 'Lưu thông tin thành công']);
            
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
        Room::delRoom($id);
        return redirect('admin/room');
    }

    /**
     * Search Client
     *
     * @param  string  $stxt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {        
        $stxt = $request->stxt;
        $listRoom = Room::searchRoom($stxt);
        foreach($listRoom as $key => $val){
            $listRoom[$key]->room_ip = explode(',', $val->room_ip);
        }
        $data = array(
                'listRoom'  => $listRoom,
                'stxt'      => $stxt
            );
        
        return view('backend.room.index', $data);
    }
}