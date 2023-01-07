<?php

namespace App\Http\Controllers\Backend\CategoryStock;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Backend\Category_stock;

class CategoryStockController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $list = Category_stock::listItem();
        $unit = Category_stock::listUnit();
        $list_dm_spt = Category_stock::list_dm_spt();

        $data = array(
                'unit' => $unit,
                'list' => $list,
                'list_dm_spt' => $list_dm_spt
            );
        return view('backend.category_stock.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $list = Category_stock::listItem();
        $unit = Category_stock::listUnit();
        $list_dm_spt = Category_stock::list_dm_spt();
        $data = array(
                'unit' => $unit,
                'list' => $list,
                'list_dm_spt' => $list_dm_spt
            );
        return view('backend.category_stock.index',$data);
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
            'name' =>'required',
            'unit' =>'required'
        ];
        $messages = [
            'name.required'=>'Bạn chưa nhập loại sản phẩm',
            'unit.required'=>'Bạn chưa chọn đơn vị',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {               
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $checkNewItem = Category_stock::checkNew($request->name);
            if( empty($checkNewItem) ){
                $unit = Category_stock::detailsUnit($request->unit);
                if(!empty($unit)){
                    $arr = [
                        'name'      => $request->name,
                        'desc'      => $request->desc,
                        'status'    => $request->status,
                        'unit_id'   => $unit->dv_id,
                        'unit_name' => $unit->dv_name
                    ];
                    Category_stock::insert($arr);
                    return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
                }else{
                    return redirect()->back()->with(['flash_message_err' => 'Không xác định được đơn vị bạn chọn']);
                }
            }else{
                return redirect()->back()->with(['flash_message_err' => 'Loại sản phẩm này đã tồn tại']);
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
        $list = Category_stock::listItem();
        $list_dm_spt = Category_stock::list_dm_spt();
        $details = Category_stock::details($id);
        $unit = Category_stock::listUnit();
        $data = array(
                'unit' => $unit,
                'list' => $list,
                'list_dm_spt' => $list_dm_spt,
                'details' => $details
            );
        return view('backend.category_stock.edit',$data);
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
            'name' =>'required',
            'unit' =>'required'
        ];
        $messages = [
            'name.required'=>'Bạn chưa nhập loại sản phẩm',
            'unit.required'=>'Bạn chưa chọn đơn vị',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {               
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $checkOldItem = Category_stock::checkOld($id,$request->name);
            if( empty($checkOldItem) ){
                $unit = Category_stock::detailsUnit($request->unit);
                if(!empty($unit)){
                    $arr = [
                        'name'      => $request->name,
                        'desc'      => $request->desc,
                        'status'    => $request->status,
                        'unit_id'   => $unit->dv_id,
                        'unit_name' => $unit->dv_name
                    ];
                    Category_stock::update($id,$arr);
                    return redirect()->back()->with(['flash_message_succ' => 'Sửa thông tin thành công']);
                }else{
                    return redirect()->back()->with(['flash_message_err' => 'Không xác định được đơn vị bạn chọn']);
                }
            }else{
                return redirect()->back()->with(['flash_message_err' => 'Loại sản phẩm này đã tồn tại']);
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
        Category_stock::delete($id);
        return redirect()->route('category_stock.index')->with(['flash_message_succ' => 'Xóa thành công']);
    }

    public function search(Request $request)
    {        
        $stxt = $request->stxt;
        $listSearch = Category_stock::search($stxt);        
        $unit = Category_stock::listUnit();
        $list_dm_spt = Category_stock::list_dm_spt();
        $data = array(
                'unit' => $unit,
                'list' => $listSearch,
                'stxt' => $stxt,
                'list_dm_spt' => $list_dm_spt
            );
        
        return view('backend.category_stock.s_result', $data);
    }

    public function del_more(Request $request)
    {
        if( !is_array($request->idArr)){
            $listId = explode(',', $request->idArr);
        }else{
            $listId = $request->idArr;    
        }
        
        if(Category_stock::del_more($listId)){
            $result = true;
        }else{
            $result = false;
        }
        echo $result;
    }

    //process del one category stock
    public function check_stock_depend(Request $request)
    {
        $id = $request->id;        
        $list_spt = Category_stock::check_stock_depend($id);
        if( count($list_spt) > 0 ){
            $result['status'] = true;
            $result['list_spt'] = $list_spt;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }

    public function update_stock_depend(Request $request)
    {
        $id_new = $request->id_new;
        $idArr = explode(',', $request->idArr);

        if( Category_stock::update_stock_depend($idArr, $id_new) ){
            $result['status'] = true;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }
    //END -- process del one category stock

    //process del more category stock
    public function check_stock_more_depend(Request $request)
    {
        $idDelArr = $request->idDelArr;
        $list_spt = Category_stock::check_stock_more_depend($idDelArr);
        $result = array();
        if( $list_spt['status'] ){
            if(count($list_spt['data']) > 0){
                $result['status'] = 1;
                $result['data'] = $list_spt['data'];
            }else{
                $result['status'] = 0;
            }
        }else{
            if(count($list_spt['data']) > 0){
                $result['status'] = 2;
            }else{
                $result['status'] = 0;
            }
        }
        echo json_encode($result);
    }

    public function update_stock_more_depend(Request $request)
    {
        $id_new = $request->id_new;
        $idArr = explode(',', $request->idArr);

        if( Category_stock::update_stock_more_depend($idArr, $id_new) ){
            $result['status'] = true;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }
    //END -- process del more category stock
}
