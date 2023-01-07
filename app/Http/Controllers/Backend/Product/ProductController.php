<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Product;
use App\Mylibs\Mylibs;
use Validator;
use DateTime;
use Illuminate\Http\UploadedFile;
use Event;
use Auth;
use App\Events\Backend\Product\ProductUpdateSts;
use App\Events\Backend\Product\ProductAdd;
use App\Events\Backend\Product\ProductEdit;
use App\Events\Backend\Product\ProductDel;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $listProduct = Product::listProduct();
        $data = array(
                'products' => $listProduct
            );
        if (access()->hasPermission('manager-product')) {
            $data['managerProduct'] = true;
        }else{
            $data['managerProduct'] = false;
        }
        if (access()->hasPermission('cap-nhat-het-hang')) {
            $data['hethang'] = true;
        }else{
            $data['hethang'] = false;
        }
        if (access()->hasPermission('manager-recipe')) {
            $data['managerRecipe'] = true;
        }else{
            $data['managerRecipe'] = false;
        }

        $listCat = Product::listCat($request);
        $display_cat = Mylibs::displayCat($listCat);
        $select = 0;
        if (old('category_parent') != null) {
            $select = old('category_parent');   
        }
        $select_cat = Mylibs::callProcessSelect($listCat,0,'',$select);
        $data['select_cat'] = $select_cat;

        return view('backend.product.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $listCategory = Product::listCategory();
        //end add option
        $data = array(
                'listCategory'  => $listCategory,
            );

        return view('backend.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $rules = [
            'pname'     =>'required|min:3|unique:product,product_name',
            'pprice'    =>'required|numeric',
            'psaleoff'  =>'numeric',
            'pimage'    =>'file|image|mimes:jpeg,jpg,png|max:5000'
            //'pparent'=>'required'
        ];
        $messages = [
            'pname.required'    =>'Bạn chưa nhập tên sản phẩm',
            'pname.min'         =>'Tên sản phẩm có ít nhất 3 ký tự',
            'pname.unique'      =>'Tên sản phẩm bị trùng lặp',
            'pprice.required'   =>'Bạn chưa nhập giá sản phẩm',
            'pprice.numeric'    =>'Định dạng giá sản phẩm chưa đúng',
            'psaleoff.numeric'  =>'Định dạng giảm giá chưa đúng',
            'pimage.image'      =>'Định dạng ảnh sản phẩm chưa đúng',
            'pimage.max'        =>'Kích thước file ảnh phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);

        if($request->hasFile('files')){
            $product_images = array();
            $files = $request->file('files');
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').$filename;
                $product_images[] = $picture;
                $destinationPath = 'uploads/product/';
                $file->move($destinationPath, $picture);
            }

            $arr = [
                'category_id'   => $request->cat_id,
                'product_name'  => trim($request->pname),
                'alias'  => Mylibs::alias(trim($request->pname)),
                'product_price' => $request->pprice,
                'product_type'  => $request->ptype,
                'product_desc'  => htmlentities($request->pdesc),
                'product_content'  => htmlentities($request->pcontent),
                'status'        => $request->pstatus,
                'product_image' => json_encode($product_images)
                
            ];
            if($request->ptype == 3){
                $arr['product_saleoff'] = $request->psaleoff;
            }else{
                $arr['product_saleoff'] = 0;
            }
            
            Product::insert($arr);
            return redirect()->back()->with(['flash_message_succ' => 'Thêm thông tin thành công']);
        }else{
            return redirect()->back()->with(['flash_message_err'=>'Bạn chưa chọn ảnh sản phẩm']);

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
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $details = Product::details($id);
        if( $details === false ){
            return redirect('index');
        }else{
            $listCategory = Product::listCategory();            
            $data = array(
                    'listCategory'  => $listCategory,
                    'details'       => $details,
                    'id'            => $id
                );
            return view('backend.product.edit', $data);
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
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $rules = [
            'pname'     =>'required|min:3|unique:product,product_name,'.$id.',product_id',
            'pprice'    =>'required|numeric',
            //'files'    =>'file|image|mimes:jpeg,jpg,png|max:5000'
        ];
        $messages = [
            'pname.required'    =>'Bạn chưa nhập tên sản phẩm',
            'pname.min'         =>'Tên sản phẩm có ít nhất 3 ký tự',
            'pname.unique'      =>'Tên sản phẩm bị trùng lặp',
            'pprice.required'   =>'Bạn chưa nhập giá sản phẩm',
            'pprice.numeric'    =>'Định dạng giá sản phẩm chưa đúng',
            //'files.image'      =>'Định dạng ảnh sản phẩm chưa đúng',
            //'files.max'        =>'Kích thước file ảnh phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->hasFile('files')){
                $product_images = array();
                $files = $request->file('files');
                foreach($files as $file){
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = date('His').$filename;
                    $product_images[] = $picture;
                    $destinationPath = 'uploads/product/';
                    $file->move($destinationPath, $picture);
                }
                $save_img = json_encode($product_images);
            }else{
                $save_img = $request->pimage_old;
            }

            $arr = [
                'product_name'  => trim($request->pname),
                'alias'  => Mylibs::alias(trim($request->pname)),
                'product_price' => $request->pprice,
                'product_desc'  => htmlentities($request->pdesc),
                'product_content'  => htmlentities($request->pcontent),
                'status'        => $request->pstatus,
                'category_id'   => $request->cat_id,
                'product_image' => $save_img,
                'product_type'  => $request->ptype
            ];
            Product::update($id, $arr);

            // $myArr = array('product_id'=>$id,'product_option'=> $product_option) + $arr;  
            // event(new ProductEdit(Auth::user(),$myArr));

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
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $products = DB::table('product')
                    ->where('product_id',$id)
                    ->first();

        // $product_option = DB::table('option')
        //             ->select('option_id','option_name', 'option_price')
        //             ->where('product_id',$id)
        //             ->get();
        // $data = $product_option->map(function($x){ return (array) $x; })->toArray();
        // $products->product_option = $data;
        Product::delProduct($id);
        //event(new ProductDel(Auth::user(),$products));
        return redirect('admin/product');        
    }

    /**
     * Search product
     *
     * @param  string  $stxt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {        
        /*if(!access()->hasPermission('manager-product') && !access()->hasPermission('chef-do') ){
            return redirect()->route('admin.dashboard');
        }*/
        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        
        $listProduct = Product::searchProduct($stxt, $category_id);
        foreach($listProduct as $key => $val){
            if($val->option_name_group != ''){
                $listProduct[$key]->option_name_group = explode(',', $val->option_name_group);
            }
        }
        $data = array(
                'products'  => $listProduct,
                'stxt'      => $stxt,
                'category_id' => $category_id
            );
        $cat_name = Product::getCategory($category_id);
        if( $cat_name != false ){
            $data['category_name'] = $cat_name;
        }else{
            $data['category_name'] = false;
        }

        if (access()->hasPermission('manager-product')) {
            $data['managerProduct'] = true;
        }else{
            $data['managerProduct'] = false;
        }
        if (access()->hasPermission('cap-nhat-het-hang')) {
            $data['hethang'] = true;
        }else{
            $data['hethang'] = false;
        }
        if (access()->hasPermission('manager-recipe')) {
            $data['managerRecipe'] = true;
        }else{
            $data['managerRecipe'] = false;
        }
        
        $listCat = Product::listCat($request);
        $display_cat = Mylibs::displayCat($listCat);

        if (old('category_parent') != null) {
            $select = old('category_parent');   
        }
        $select_cat = Mylibs::callProcessSelect($listCat,0,'',$category_id);
        $data['select_cat'] = $select_cat;
        return view('backend.product.s_result', $data);
    }

    /**
     * Update status product
     */
    public function updatestatus(Request $request)
    {   
        $listId = $request->idArr;
        $status = $request->action;
      
        $update = Product::updateStatus($listId, $status);
        if( $update ){
            $success = true;
            //Lưu lịch sử
            Event::fire(new ProductUpdateSts(Auth::user(),$listId,$status));
        }else{
            $success = false;
        }
        
        echo json_encode($success);
    }

    /**
     * Sort product
     */
    public function sort(Request $request)
    {
        if(!access()->hasPermission('manager-product')){
            return redirect()->route('admin.dashboard');
        }
        $result = array();
        $listCatRoot = Product::listCatRoot();
        
        foreach( $listCatRoot as $key => $val ){
            $result[] = array(
                    'category_id' => $val->category_id,
                    'category_name' => $val->category_name,
                    'data' => Product::listProductCat($val->category_id)
                );
        }
        return view('backend.product.sort', array('data' => $result));
    }

    /**
     * Update sort product
     */
    public function update_sort(Request $request)
    {
        $idArr = $request->idArr;
        $sortArr = $request->sortArr;
        $idCatRoot = $request->idCatRoot;

        if(Product::update_sort($idArr,$sortArr)){
            $result['status'] = true;            
        }else{
            $result['status'] = false;
        }
        echo json_encode($result);
    }

}
