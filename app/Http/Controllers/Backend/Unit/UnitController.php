<?php

namespace App\Http\Controllers\Backend\Unit;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Backend\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // Không nhận Request ở đây ???
    {        
        $listUnit = Unit::listUnit();
        $data = array(
                'listUnit' => $listUnit
            );
        return view('backend.unit.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $listUnit = Unit::listUnit();
        $data = array(
                'listUnit' => $listUnit
            );
        return view('backend.unit.index',$data);
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
            'dv_name' =>'required|unique:don_vi,dv_name',
        ];
        $messages = [
            'dv_name.required'=>'Bạn chưa nhập tên đơn vị',
            'dv_name.unique'=>'Đơn vị này đã tồn tại',
        ];   
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {               
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $arr = [
                'dv_name' => $request->dv_name,
                'dv_desc' =>  $request->dv_desc,
                'dv_status' =>  $request->dv_status
            ];
            Unit::insert($arr);
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
        $listUnit = Unit::listUnit();
        $data = array(
                'listUnit' => $listUnit,
                'details' => Unit::details($id)
            );
        return view('backend.unit.edit',$data);
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
            'dv_name' =>'required|unique:don_vi,dv_name,'.$id.',dv_id',
        ];
        $messages = [
            'dv_name.required'=>'Bạn chưa nhập tên đơn vị',
            'dv_name.unique'=>'Đơn vị này đã tồn tại',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {               
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $arr = [
                'dv_name' => $request->dv_name,
                'dv_desc' =>  $request->dv_desc,
                'dv_status' =>  $request->dv_status
            ];
            Unit::update($id,$arr);
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
        Unit::delete($id);
        return redirect()->route('unit.index')->with(['flash_message_succ' => 'Xóa thành công']);
    }

    public function search(Request $request){
        $stxt = $request->stxt;        
        $listUnit = Unit::searchunit($stxt);
        $data = array(
                'stxt'  => $stxt,
                'listUnit' => $listUnit
            );
        return view('backend.unit.index',$data);
    }
}
