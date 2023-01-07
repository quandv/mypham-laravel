<?php

namespace App\Http\Controllers\Backend\Option;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Option;
use Validator;
use Session;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//Session::flush();
        $listOption = Option::listOption();
        
        $data = array(
                'options' => $listOption
            );
        if (access()->hasPermission('manager-option')) {
            $data['managerOption'] = true;
        }else{
            $data['managerOption'] = false;
        }
        if (access()->hasPermission('cap-nhat-het-hang')) {
            $data['hethang'] = true;
        }else{
            $data['hethang'] = false;
        }
        return view('backend.option.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if(!access()->hasPermission('manager-option')){
            return redirect()->route('admin.dashboard');
        }
        return view('backend.option.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!access()->hasPermission('manager-option')){
            return redirect()->route('admin.dashboard');
        }
        $rules = [
            'name'     =>'required|min:3|unique:listoption',
            'price'    =>'required|numeric'
        ];
        $messages = [
            'name.required'     =>'Bạn chưa nhập tên option',        
            'name.min'          =>'Tên option phải chứa tối thiểu 3 ký tự',
            'name.unique'       =>'Tên option bị trùng lặp',
            'price.required'    =>'Bạn chưa nhập giá option',
            'price.numeric'     =>'Định dạng giá option chưa đúng',            
        ];

        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{            
            $arr = [
                'name'  => $request->name,
                'price' => $request->price,
                'status'=> $request->status,
                'type'  => $request->type

            ];
            Option::insert($arr);
            return redirect()->back()->with(['flash_message_succ' => 'Thêm option thành công']);
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
        if(!access()->hasPermission('manager-option')){
            return redirect()->route('admin.dashboard');
        }
        $details = Option::details($id);
        if( $details === false ){
            return redirect('index');
        }else{
            $data = array(
                'details'       => $details,
                'id'            => $id
            );
            return view('backend.option.edit', $data);
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
        if(!access()->hasPermission('manager-option')){
            return redirect()->route('admin.dashboard');
        }
        $rules = [
            'name'     =>'required|min:3|unique:listoption,name,'.$id.',id',
            'price'    =>'required|numeric'
        ];
        $messages = [
            'name.required'    =>'Bạn chưa nhập tên option',
            'name.min'         =>'Tên option phải chứa tối thiểu 3 ký tự',
            'name.unique'      =>'Tên option bị trùng lặp',
            'price.required'   =>'Bạn chưa nhập giá option',
            'price.numeric'    =>'Định dạng giá option chưa đúng',            
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{            
            $arr = [
                'name'  => $request->name,
                'price' => $request->price,
                'status'=> $request->status,
                'type'  => $request->type

            ];
            Option::update($id, $arr);
            return redirect()->back()->with(['flash_message_succ' => 'Sửa option thành công']);            
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
        if(!access()->hasPermission('manager-option')){
            return redirect()->route('admin.dashboard');
        }
        Option::delOption($id);
        return redirect('admin/option');
    }

    /**
     * Search option
     *
     * @param  string  $stxt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if(!access()->hasPermission('manager-option') && !access()->hasPermission('chef-do')){
            return redirect()->route('admin.dashboard');
        } 
        $stxt = $request->stxt;
        $listOption = Option::searchOption($stxt);
        $data = array(
                'options'  => $listOption,
                'stxt'      => $stxt
            );
        if (access()->hasPermission('manager-option')) {
            $data['managerOption'] = true;
        }else{
            $data['managerOption'] = false;
        }
        if (access()->hasPermission('cap-nhat-het-hang')) {
            $data['hethang'] = true;
        }else{
            $data['hethang'] = false;
        }    
        
        return view('backend.option.s_result', $data);
    }

    /**
     * Update status product
     */
    public function updatestatus(Request $request)
    {   
        $listId = $request->idArr;
        $status = $request->action;
      
        $update = Option::updateStatus($listId, $status);
        if( $update ){
            $success = true;
            //Lưu lịch sử
            //Event::fire(new ProductUpdateSts(Auth::user(),$listId,$status));
        }else{
            $success = false;
        }
        
        echo json_encode($success);
    }
}
