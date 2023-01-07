<?php

namespace App\Http\Controllers\Backend\Category;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DateTime;
use App\Models\Backend\Category;
use App\Mylibs\Mylibs;
use Schema;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // Không nhận Request ở đây ???
    {
        $listCatRoot = Category::listCatRoot();
        $listCat = Category::listCat($request);
        $display_cat = Mylibs::displayCat($listCat);
        $select = 0;
        if (old('category_parent') != null) {
            $select = old('category_parent');
        }
        $select_cat = Mylibs::callProcessSelect($listCat,0,'',$select);
        $select_cat2 = Mylibs::callProcessSelect2($listCat,'----');
        return view('backend.category.index',['listCatRoot'=>$listCatRoot,'select_cat'=>$select_cat,'display_cat'=>$display_cat,'select_cat2'=>$select_cat2]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $listCat = Category::listCat($request);
        $display_cat = Mylibs::displayCat($listCat);
        $select = 0;
        if (old('category_parent') != null) {
            $select = old('category_parent');   
        }
        $select_cat = Mylibs::callProcessSelect($listCat,0,'',$select);
        return view('backend.category.index',['select_cat'=>$select_cat,'display_cat'=>$display_cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'category_name' =>'required|min:2',
           /* 'category_description'=>'required|min:6',*/
            'fileImage' => 'file|image|mimes:jpeg,jpg,png|max:5000'
            //'category_parent'=>'required'
        ];
        $messages = [
            'category_name.required'=>'Bạn chưa nhập tên category',
            'category_name.min'=>'Tên danh mục phải có ít nhất 2 ký tự',
            /*'category_description.required'=>'Bạn chưa nhập description',*/
            'fileImage.image'=>'Định dạng bạn nhập chưa đúng',
            'fileImage.max'=>'Kích thước file phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if($request->hasFile('fileImage') && $request->hasFile('fileImageHover')){
            if($request->file('fileImage')->isValid() && $request->file('fileImageHover')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImage')->getClientOriginalName();
                    $filenameHover = time()+1 .'.'.$request->file('fileImageHover')->getClientOriginalName();      
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImage')->move($destinationPath,$filename);
                    $request->file('fileImageHover')->move($destinationPath,$filenameHover);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);      
                     $arr = [
                        'category_name' => $request->category_name,
                        'category_alias' => Mylibs::alias($request->category_name),
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image' =>  $filename,
                        'category_image_hover' =>  $filenameHover,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,

                    ];

                    Category::insert($arr);
                    return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }

        }elseif($request->hasFile('fileImage') && !$request->hasFile('fileImageHover')){
            if($request->file('fileImage')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImage')->getClientOriginalName();
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImage')->move($destinationPath,$filename);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);      
                     $arr = [
                        'category_name' => $request->category_name,
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image' =>  $filename,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,

                    ];

                    Category::insert($arr);
                    return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }
        }elseif(!$request->hasFile('fileImage') && $request->hasFile('fileImageHover')){
            if($request->file('fileImageHover')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImageHover')->getClientOriginalName();
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImageHover')->move($destinationPath,$filename);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);      
                     $arr = [
                        'category_name' => $request->category_name,
                        'category_alias' => Mylibs::alias($request->category_name),
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image_hover' =>  $filename,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,

                    ];

                    Category::insert($arr);
                    return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }
        }else{
             if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{    
                     $arr = [
                        'category_name' => $request->category_name,
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,
                    ];

                    Category::insert($arr);
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
        //
        $data = Category::getCatFromId($id);
        $listCat = Category::listCat($id,'list');
        $select = $data->category_id_parent;
        if (old('category_parent') != null) {
            $select = old('category_parent');   
        }
        $select_cat = Mylibs::callProcessSelect($listCat,0,'',$select);
        return view('backend.category.edit',['select_cat'=>$select_cat,'data'=>$data]);
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
            'category_name' =>'required|min:2',
            /*'category_description'=>'required|min:6',*/
            'fileImage' => 'file|image|mimes:jpeg,jpg,png|max:5000'
            //'category_parent'=>'required'
        ];
        $messages = [
            'category_name.required'=>'Bạn chưa nhập tên category',
            'category_name.min'=>'Tên danh mục phải có ít nhất 2 ký tự',
            /*'category_description.required'=>'Bạn chưa nhập description',*/
            'fileImage.image'=>'Định dạng bạn nhập chưa đúng',
            'fileImage.max'=>'Kích thước file phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if($request->hasFile('fileImage') && $request->hasFile('fileImageHover')){
            if($request->file('fileImage')->isValid() && $request->file('fileImageHover')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImage')->getClientOriginalName(); 
                    $filenameHover = time()+1 .'.'.$request->file('fileImageHover')->getClientOriginalName();      
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImage')->move($destinationPath,$filename);
                    $request->file('fileImageHover')->move($destinationPath,$filenameHover);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);      
                     $arr = [
                        'category_name' => $request->category_name,
                        'category_alias' => Mylibs::alias($request->category_name),
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image' =>  $filename,
                        'category_image_hover' =>  $filenameHover,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,
                    ];

                    Category::update($arr,$id);
                    return redirect()->back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }
        }elseif($request->hasFile('fileImage') && !$request->hasFile('fileImageHover')){
            if($request->file('fileImage')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImage')->getClientOriginalName();
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImage')->move($destinationPath,$filename);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);
                    $arr = [
                        'category_name' => $request->category_name,
                        'category_alias' => Mylibs::alias($request->category_name),
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image' =>  $filename,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,
                    ];

                    Category::update($arr,$id);
                    return redirect()->back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công']);
                }
            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }

        }elseif(!$request->hasFile('fileImage') && $request->hasFile('fileImageHover')){
            if($request->file('fileImageHover')->isValid()){
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $filename = time().'.'.$request->file('fileImageHover')->getClientOriginalName();
                    $destinationPath = 'uploads/category/';
                    $request->file('fileImageHover')->move($destinationPath,$filename);
                    $date_field = DateTime::createFromFormat('d/m/yy', $request->inputBirthday);
                    $arr = [
                        'category_name' => $request->category_name,
                        'category_alias' => Mylibs::alias($request->category_name),
                        'category_desc' =>  $request->category_description,
                        'category_status' =>  $request->category_status,
                        'category_image_hover' =>  $filename,
                        'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                        'category_type' =>  $request->category_type,
                    ];

                    Category::update($arr,$id);
                    return redirect()->back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công']);
                }

            }else{
                return redirect()->back()->with(['flash_message_err'=>'Có lỗi xảy ra trong quá trình upload vui lòng thử lại']);
            }
        }else{
             if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{    
                 $arr = [
                    'category_name' => $request->category_name,
                    'category_alias' => Mylibs::alias($request->category_name),
                    'category_desc' =>  $request->category_description,
                    'category_status' =>  $request->category_status,
                    'category_id_parent' => (!empty($request->category_parent)) ? $request->category_parent : 0 ,
                    'category_type' =>  $request->category_type,
                ];

                Category::update($arr,$id);
                return redirect()->back()->with(['flash_message_succ' => 'Cập nhật thông tin thành công']);
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
        /*$listCatNotDel = array(1,3,4,5,19,20,27,36,38);
        if( in_array($id, $listCatNotDel) ){
            return redirect()->route('admin.category.index')->with(['flash_message_err' => 'Bạn không được xóa mục này']);
        }else{*/
            Category::delete($id);
            return redirect()->route('admin.category.index')->with(['flash_message_succ' => 'Xóa thành công']);
        //}       
    }

    //process del one category stock
    public function check_category_depend(Request $request)
    {
        $id_parent = $request->id;
        $data = Category::check_category_depend($id_parent);
        if( count($data) > 0 ){
            $result['status'] = true;
            $result['data'] = $data;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }

    public function update_category_depend(Request $request)
    {
        $id_new = $request->id_new;
        $idArr = explode(',', $request->idArr);

        if( Category::update_category_depend($idArr, $id_new) ){
            $result['status'] = true;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }

    // check product depend
    public function check_product_depend(Request $request)
    {
        $id_cat = $request->id;
        $data = Category::check_product_depend($id_cat);
        if( count($data) > 0 ){
            $result['status'] = true;
            $result['data'] = $data;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }

    public function update_product_depend(Request $request)
    {
        $id_new = $request->id_new;
        $idArr = explode(',', $request->idArr);

        if( Category::update_product_depend($idArr, $id_new) ){
            $result['status'] = true;
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }
    //END -- process del one category stock
}
