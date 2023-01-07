<?php

namespace App\Http\Controllers\Backend\ProductStock;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Product_stock;
use App\Mylibs\Mylibs;
use Validator;
use DateTime;
use Illuminate\Http\UploadedFile;
use Cart;
use DB;
use Auth;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $listProduct = Product_stock::listProduct();
        $listCategory = Product_stock::listCategory();

        $listStockOver = Product_stock::listStockOver();
        $listRecipe = Product_stock::listRecipe();
        $recipeIdOver = array();
        foreach ($listRecipe as $recipe) {
            $recipeDetails = json_decode($recipe->ctm_details, true);
            foreach ($listStockOver as $stockOver) {
                if( array_key_exists($stockOver->spt_id, $recipeDetails) ){
                    $recipeIdOver[] = $recipe->ctm_id;break;
                }
            }    
        }
        $listProductOver = Product_stock::listProductOver($recipeIdOver);
        $listOptionOver = Product_stock::listOptionOver($recipeIdOver);

        $listProductIdOver = array();
        $listOptionIdOver = array();
        foreach($listProductOver as $productOver){
            $listProductIdOver[] = $productOver->product_id;
        }
        foreach($listOptionOver as $optionOver){
            $listOptionIdOver[] = $optionOver->id;
        }

        $data = array(
                'products' => $listProduct,
                'category' => $listCategory,
                'listProductOver' => $listProductOver,
                'listOptionOver' => $listOptionOver,
                'listProductIdOver' => implode(',', $listProductIdOver),
                'listOptionIdOver' => implode(',', $listOptionIdOver)
            );
        return view('backend.stock.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $listCategory = Product_stock::listCategory();
        $data = array(
                'category'  => $listCategory,                
            );

        return view('backend.stock.create', $data);
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
            'unit'      =>'required',
            'pname'     =>'required|min:3|unique:san_pham_tho,spt_name',
            'pimage'    =>'file|image|mimes:jpeg,jpg,png|max:5000'
        ];
        $messages = [
            'unit.required'     =>'Bạn chưa chọn danh mục sản phẩm',
            'pname.required'    =>'Bạn chưa nhập tên sản phẩm',
            'pname.unique'      =>'Tên sản phẩm bị trùng lặp',
            'pimage.image'      =>'Định dạng ảnh sản phẩm chưa đúng',
            'pimage.max'        =>'Kích thước file ảnh phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);            
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->hasFile('pimage')){
                if($request->file('pimage')->isValid()){
                    $filename = time().'.'.$request->file('pimage')->getClientOriginalName();            
                    $destinationPath = 'uploads/product_stock/';
                    $request->file('pimage')->move($destinationPath,$filename);
                }
            }else{
                $filename = '';
            }
            if($request->pquantity && is_numeric($request->pquantity) > 0){
                $pquantity = $request->pquantity;
            }else{
                $pquantity = 0;
            }

            $arr = [
                'spt_name'      => $request->pname,
                'spt_quantity'  => $pquantity,
                'spt_desc'      => $request->pdesc,
                'spt_status'    => $request->pstatus,
                'spt_image'     => $filename,
                'spt_category_id'   => $request->unit,
            ];
            $spt_catname = Product_stock::getCategory($request->unit);
            if(count($spt_catname) > 0){
                $arr['spt_category_name'] = $spt_catname->name;
            }
            
            Product_stock::insert($arr);
            return redirect()->back()->with(['flash_message_succ' => 'Thêm sản phẩm thành công']);
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
        $details = Product_stock::details($id);        
        $listCategory = Product_stock::listCategory();
        $data = array(
                'category'  => $listCategory,
                'details'   => $details
            );
        return view('backend.stock.edit', $data);        
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
            'unit'      =>'required',
            'pname'     =>'required|min:3|unique:san_pham_tho,spt_name,'.$id.',spt_id',
            //'pquantity' =>'required|numeric',
            'pimage'    =>'file|image|mimes:jpeg,jpg,png|max:5000'
        ];
        $messages = [
            'unit.required'     =>'Bạn chưa chọn danh mục sản phẩm',
            'pname.required'    =>'Bạn chưa nhập tên sản phẩm',
            'pname.unique'      =>'Tên sản phẩm bị trùng lặp',
            //'pquantity.required'=>'Bạn chưa nhập lượng sản phẩm',
            //'pquantity.numeric' =>'Định dạng lượng sản phẩm chưa đúng',
            'pimage.image'      =>'Định dạng ảnh sản phẩm chưa đúng',
            'pimage.max'        =>'Kích thước file ảnh phải nhỏ hơn 5 mb'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);            
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->hasFile('pimage')){
                if($request->file('pimage')->isValid()){
                    $filename = time().'.'.$request->file('pimage')->getClientOriginalName();            
                    $destinationPath = 'uploads/product_stock/';
                    $request->file('pimage')->move($destinationPath,$filename);
                }
            }else{
                $filename = $request->pimage_old;
            }            

            $arr = [
                'spt_name'      => $request->pname,
                //'spt_quantity'  => $request->pquantity,
                'spt_desc'      => $request->pdesc,
                'spt_status'    => $request->pstatus,
                'spt_image'     => $filename,
                'spt_category_id'   => $request->unit,

            ];
            $spt_catname = Product_stock::getCategory($request->unit);
            if(count($spt_catname) > 0){
                $arr['spt_category_name'] = $spt_catname->name;
            }

            Product_stock::update($id,$arr);
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
        Product_stock::delProduct($id);
        return redirect()->route('stock.index')->with(['flash_message_succ' => 'Xóa thành công']);
    }

    /**
     * Search product
     *
     * @param  string  $stxt
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {        
        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        
        $listProduct = Product_stock::searchProduct($stxt, $category_id);
        $listCategory = Product_stock::listCategory();

        //
        $listStockOver = Product_stock::listStockOver();
        $listRecipe = Product_stock::listRecipe();
        $recipeIdOver = array();
        foreach ($listRecipe as $recipe) {
            $recipeDetails = json_decode($recipe->ctm_details, true);
            foreach ($listStockOver as $stockOver) {
                if( array_key_exists($stockOver->spt_id, $recipeDetails) ){
                    $recipeIdOver[] = $recipe->ctm_id;break;
                }
            }    
        }
        $listProductOver = Product_stock::listProductOver($recipeIdOver);
        $listOptionOver = Product_stock::listOptionOver($recipeIdOver);

        $listProductIdOver = array();
        $listOptionIdOver = array();
        foreach($listProductOver as $productOver){
            $listProductIdOver[] = $productOver->product_id;
        }
        foreach($listOptionOver as $optionOver){
            $listOptionIdOver[] = $optionOver->id;
        }

        $data = array(
                'products'  => $listProduct,
                'stxt'      => $stxt,
                'category_id' => $category_id,
                'category'  => $listCategory,            
                'listProductOver' => $listProductOver,
                'listOptionOver' => $listOptionOver,
                'listProductIdOver' => implode(',', $listProductIdOver),
                'listOptionIdOver' => implode(',', $listOptionIdOver)
            );
        $cat_name = Product_stock::getCategory($category_id);
        if( $cat_name != false ){
            $data['category_name'] = $cat_name->name;
        }else{
            $data['category_name'] = false;
        }
        
        return view('backend.stock.s_result', $data);
        
    }

    public function stsover(Request $request)
    {
        if( $request->idArrProduct != ''){
            $idArrProduct = explode(',', $request->idArrProduct);
        }else{
            $idArrProduct = array();
        }
        if( $request->idArrOption != ''){
            $idArrOption = explode(',', $request->idArrOption);
        }else{
            $idArrOption = array();
        }
        $update = Product_stock::stsover($idArrProduct, $idArrOption, 0);
        if( $update ){
            $success = true;
        }else{
            $success = false;
        }
        echo json_encode($success);
    }

    //delete more recipe
    public function del_more(Request $request)
    {
        $listId = $request->idArr;
        if(Product_stock::del_more($listId)){
            $success = true;
        }else{
            $success = false;
        }
        echo $success;
    }

    public function check_recipe_more(Request $request)
    {
        $listIdStock = $request->listIdStock;
        $result = Product_stock::check_recipe_more($listIdStock);
        echo json_encode($result);
    }

    public function update_recipe_depend_more(Request $request)
    {
        $listIdStock = $request->listIdStock;
        $idArr = $request->idArr;

        $result = Product_stock::update_recipe_depend_more($listIdStock,$idArr);
        echo json_encode($result);
    }
    // END -- delete more recipe

    public function check_recipe(Request $request)
    {
        $spt_id = $request->spt_id;
        $result = Product_stock::check_recipe($spt_id);
        echo json_encode($result);
    }
    
    public function update_recipe_depend(Request $request)
    {
        $spt_id = $request->spt_id;
        $idArr = $request->idArr;
        
        $result = Product_stock::update_recipe_depend($spt_id,$idArr);
        echo json_encode($result);
    }
}