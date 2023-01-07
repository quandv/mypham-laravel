<?php

namespace App\Http\Controllers\Backend\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Backend\Client;
use Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {        
        $listClient = Client::listClient();
        $listRoom = Client::listRoom();
        $data = array(
                'clients'   => $listClient,
                'rooms'     => $listRoom
            );
        
        return view('backend.client.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listRoom = Client::listRoom();
        $data = array(
                'rooms'     => $listRoom
            );
        
        return view('backend.client.index', $data);
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
            'client_name'   =>'required|min:3|unique:client,client_name',
            'client_ip'     =>'required|ip|unique:client,client_ip',
            'room_id'       =>'required'
        ];
        $messages = [
            'client_name.required'  =>'Bạn chưa nhập tên máy',
            'client_name.min'       =>'Tên máy phải có ít nhất 3 ký tự',
            'client_name.unique'    =>'Tên máy đã tồn tại',
            'client_ip.required'    =>'Bạn chưa nhập IP',
            'client_ip.ip'          =>'Bạn chưa nhập đúng định dạng IP',
            'client_ip.unique'      =>'IP này đã tồn tại',
            'room_id.required'      =>'Bạn chưa chọn phòng máy',

        ]; 
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $arr = [
                'client_name'   => $request->client_name,
                'client_ip'     => $request->client_ip,
                'room_id'       => $request->room_id,
                'chat_type'     => isset($request->chat_type) ? 1 : null ,
            ];
            Client::insert($arr);
            return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
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
        $listRoom = Client::listRoom();
        $details = Client::details($id);
        if( $details === false ){
            return redirect('client/index');
        }else{
            $listClient = Client::listClient();
            $data = array(
                    'rooms'         => $listRoom,
                    'clients'       => $listClient,
                    'details'       => $details,
                    'id'            => $id
                );
            return view('backend.client.edit', $data);
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
            'client_name'   =>'required|min:3|unique:client,client_name,'.$id.',client_id',
            'client_ip'     =>'required|ip|unique:client,client_ip,'.$id.',client_id',
            'room_id'       =>'required'
        ];
        $messages = [
            'client_name.required'  =>'Bạn chưa nhập tên máy',
            'client_name.min'       =>'Tên máy phải có ít nhất 3 ký tự',
            'client_name.unique'    =>'Tên máy đã tồn tại',
            'client_ip.required'    =>'Bạn chưa nhập IP',
            'client_ip.ip'          =>'Bạn chưa nhập đúng định dạng IP',
            'client_ip.unique'      =>'IP này đã tồn tại',
            'room_id.required'      =>'Bạn chưa chọn phòng máy',

        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $arr = [
                'client_name'   => $request->client_name,
                'client_ip'     => $request->client_ip,
                'room_id'       => $request->room_id,
                'chat_type'     => isset($request->chat_type) ? 1 : null ,
            ];

            Client::update($id, $arr);
            return redirect()->back()->with(['flash_message_succ' => 'Sửa thông tin thành công']);
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
        Client::delClient($id);
        return redirect('admin/client');
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
        $listClient = Client::searchClient($stxt);
        $listRoom   = Client::listRoom();
        $data = array(
                'rooms'     => $listRoom,
                'clients'   => $listClient,
                'stxt'      => $stxt
            );
        
        return view('backend.client.s_result', $data);
    }
}