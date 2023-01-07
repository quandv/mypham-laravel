<?php

namespace App\Http\Controllers\Backend\Recipe;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Recipe;
use DB;
use Cart;
use Validator;
use Session;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listRecipe = Recipe::listRecipe();
        
        foreach($listRecipe as $k => $v){
            $listRecipe[$k]->ctm_details = json_decode($v->ctm_details);
            $listRecipe[$k]->ctm_details_name = json_decode($v->ctm_details_name);
        }
        $unit = Recipe::getUnit();
        $data = array(
                'listRecipe' => $listRecipe,
                'unit' => $unit
            );

        return view('backend.recipe.index', $data);
    }
    public function getProduct(Request $request){
        $pid = $request->pid;
        $products = Recipe::listProduct($request);
        if($request->token_ && $request->token_ == 1){
            $prodSale = Recipe::getOptionSale($pid);
        }else{
            $prodSale = Recipe::getprodSale($pid); 
        }
        $xhtm = "";
        foreach($products as $product) {
            $xhtm .= "<tr> 
                <td class='text-center'><img src='". asset('uploads/product_stock/'.$product->spt_image) ."' width='80%' max-height='80px' alt=''></td>
                <td>".$product->spt_name ."</td>
                <td>". round($product->spt_quantity,4,PHP_ROUND_HALF_EVEN) . "(".$product->unit_name.")</td>
                <td>". $product->spt_category_name . "</td>
                <td>". $product->spt_desc ."</td>";
            $xhtm .=  "<td>";
            if( $product->spt_quantity <= 0.0001 ) {
                $xhtm .= "<span class='label label-danger'>Hết hàng</span>";
            }else{
                $xhtm .= "<span class='label label-success'>Còn hàng</span>";
            }
            $xhtm .= "</td><td>";
            /*$xhtm .= "<a class='btn btn-info btn-xs' href='". route('stock.edit', ['id' => $product->spt_id]) ."'><i class='fa fa-pencil'></i></a>
                              <form id='delete-form-".$product->spt_id."' style='display:inline-block' action='". route('stock.destroy', ['id' => $product->spt_id])."' method='post'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' name='_token' value='". csrf_token() ."'>
                                <a class='btn btn-danger btn-xs marginRight3' onclick='javascript:del_product(".$product->spt_id.")'><i class='fa fa-minus-circle'></i></a>
                              </form>";*/
           if(isset($prodSale->id)){
               $xhtm .= "<a class='btn btn-success btn-xs' onclick='add_cart_recipe(".$product->spt_id ."," .$prodSale->id.",1)'><i class='fa fa-plus'></i> Thêm vào công thức</a>";
           }elseif(isset($prodSale->product_id)){
               $xhtm .= "<a class='btn btn-success btn-xs' onclick='add_cart_recipe(".$product->spt_id ."," . $prodSale->product_id .",0)'><i class='fa fa-plus'></i> Thêm vào công thức</a></td></tr>";
           }                                                 
        }

        $pagi_link = "";
        if ($products->perPage() >= 1) {
            $pagi_link = $products->appends($request->all())->links()->toHtml();
        }
       return $result =[
          'html' => $xhtm,
          'pagi' => $pagi_link,
         ];
    }

    public function getProductEdit(Request $request){
        $pid = $request->pid;
        $id = $request->id;
        $products = Recipe::listProduct($request);
        
        $xhtm = "";
        foreach($products as $product) {
            $xhtm .= "<tr> 
                <td class='text-center'><img src='". asset('uploads/product_stock/'.$product->spt_image) ."' width='80%' max-height='80px' alt=''></td>
                <td>".$product->spt_name."</td>
                <td>".round($product->spt_quantity,4,PHP_ROUND_HALF_EVEN)." (".$product->unit_name.")</td>
                <td>".$product->spt_category_name."</td>
                <td>".$product->spt_desc."</td>";
            $xhtm .=  "<td>";
            if( $product->spt_quantity <= 0.0001 ) {
                $xhtm .= "<span class='label label-danger'>Hết hàng</span>";
            }else{
                $xhtm .= "<span class='label label-success'>Còn hàng</span>";
            }
            $xhtm .= "</td><td>";
            /*$xhtm .= "<a class='btn btn-info btn-xs' href='". route('stock.edit', ['id' => $product->spt_id]) ."'><i class='fa fa-pencil'></i></a>
                              <form id='delete-form-".$product->spt_id."' style='display:inline-block' action='". route('stock.destroy', ['id' => $product->spt_id])."' method='post'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' name='_token' value='". csrf_token() ."'>
                                <a class='btn btn-danger btn-xs marginRight3' onclick='javascript:del_product(".$product->spt_id.")'><i class='fa fa-minus-circle'></i></a>
                              </form>";*/
            $xhtm .= "<a class='btn btn-success btn-xs' onclick='add_cart_edit_recipe(".$product->spt_id .",".$id.")'><i class='fa fa-plus'></i> Thêm vào công thức</a></td></tr>";
                                                           
        }

        $pagi_link = "";
        if ($products->perPage() >= 1) {
            $pagi_link = $products->appends($request->all())->links()->toHtml();
        }
       return $result =[
          'html' => $xhtm,
          'pagi' => $pagi_link,  
         ];                        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {//$request->session()->flush();die;
        $data = array();
        $pid = $request->pid;
        $data['pid'] = $pid;

        $listProduct = Recipe::listProduct();
        $listCategory = Recipe::listCategory();

        if($request->token_ && $request->token_ == 1){
            $data['is_option'] = 1;
            $prodSale = Recipe::getOptionSale($pid);
            //$recipeInfo = Cart::instance('recipe_op_'.$pid)->content();
        }else{
            $data['is_option'] = 0;
            $prodSale = Recipe::getprodSale($pid);
            //$recipeInfo = Cart::instance('recipe_pr_'.$pid)->content();
        }
        $data['products'] = $listProduct;
        $data['category'] = $listCategory;
        $data['prodSale'] = $prodSale;        

        //xử lý cart(recipe == 'công thức món') info để đồng bộ với dữ liệu nhập từ form
        
        /*$recipeInfo2 = array();
        $sort = array();
        foreach($recipeInfo as $recipeItem){
            $recipeInfo2[] = $recipeItem;
            $sort[] = $recipeItem->options['sort'];
        }
        sort($sort);
        if($recipeInfo != null && count($recipeInfo) > 0){            
            $data['countRecipe'] = count($recipeInfo);
        }else{
            $data['countRecipe'] = 0;
        }
        $data['contentRecipe'] = $recipeInfo2;
        $data['sort'] = $sort;*/
/*echo "<pre>";
print_r($data);
echo "</pre>";die;*/
        return view('backend.recipe.create', $data);
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
    public function edit(Request $request, $id)
    {           
        //$request->session()->flush();die;
        $listCategory = Recipe::listCategory();
        $listProduct = Recipe::listProduct();
        $details = Recipe::details($id);
        $ctm_details = json_decode($details->ctm_details, true);
        $ctm_details_name = json_decode($details->ctm_details_name);
        $getUnit = Recipe::getUnit($ctm_details);

        Cart::instance('recipe_'.$id)->destroy();
        if( Cart::instance('recipe_'.$id)->count() <= 0 ){
            $sort = 1;
            foreach($ctm_details as $pid => $qty){
                /*if($qty < 0.00001){
                    $qty = 0.00001;
                }*/
                //xử lý qty ra dạng phân số numTop/numBot
                $qtyRat = Recipe::float2rat($qty, $tolerance = 1.e-6);                
                $addCartInfo = array(
                        'id'    => $pid,
                        'name'  => $ctm_details_name->$pid,
                        'qty'   => $qty,
                        'price' => 1,
                        'options'=> [
                                'unit'      => $getUnit[$pid],
                                'numTop'    => $qtyRat['numTop'],
                                'numBot'    => $qtyRat['numBot'],
                                'changeType'=> 0,
                                'sort'      => $sort
                            ]
                    );
                Cart::instance('recipe_'.$id)->add($addCartInfo);
                $sort++;
            }
        }

        //get product info
        $pid = $request->pid;
        if($request->token_ && $request->token_ == 1){
            $prodSale = Recipe::getOptionSale($pid);
        }else{
            $prodSale = Recipe::getprodSale($pid);
        }

        $data = array(
                'id'        => $id,
                'category'  => $listCategory,
                'products'  => $listProduct,
                'prodSale'  => $prodSale,

                //'content'   => Cart::instance('recipe_'.$id)->content(),
                'ctm_id'    => $details->ctm_id,
                'ctm_name'  => $details->ctm_name,
                'ctm_desc'  => $details->ctm_desc
            );

        return view('backend.recipe.edit', $data);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $is_option = $request->token_;
        $pid = $request->pid;
        Recipe::delRecipe($id,$pid,$is_option);
        return redirect()->route('recipe.index')->with(['flash_message_succ' => 'Xóa thành công']);
    }

    public function search(Request $request){
        $stxt = $request->stxt;

        $listRecipe = Recipe::search($stxt);
        foreach($listRecipe as $k => $v){
            $listRecipe[$k]->ctm_details = json_decode($v->ctm_details);
            $listRecipe[$k]->ctm_details_name = json_decode($v->ctm_details_name);
        }
        $unit = Recipe::getUnit();
        $data = array(
                'listRecipe'=> $listRecipe,
                'stxt'      => $stxt,
                'unit'      => $unit
            );

        return view('backend.recipe.s_result', $data);
    }
    //
    public function update_cart_input(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;
        $pid = $request->pid;
        $spt_id = $request->spt_id;
        $is_option = $request->is_option;
        $type = $request->type;

        $qtyRat = Recipe::float2rat($val, $tolerance = 1.e-6);
        if( $is_option == 1 ){
            $cartContent = Cart::instance('recipe_op_'.$pid)->content();
            Cart::instance('recipe_op_'.$pid)->update($rowid, ['qty' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $qtyRat['numTop'],
                    'numBot' => $qtyRat['numBot'],   
                    'changeType' => 0,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
            $cartContent = Cart::instance('recipe_op_'.$pid)->content();
        }else{
            $cartContent = Cart::instance('recipe_pr_'.$pid)->content();
            Cart::instance('recipe_pr_'.$pid)->update($rowid, ['qty' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $qtyRat['numTop'],
                    'numBot' => $qtyRat['numBot'],   
                    'changeType' => 0,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
            $cartContent = Cart::instance('recipe_pr_'.$pid)->content();
        }
        /*echo "<pre>";
        print_r($cartContent);
        echo "</pre>";die;*/
        $result = array();
        foreach ($cartContent as $key => $value) {
            if($value->id == $spt_id){
                $result['rowId']    = $value->rowId;
                $result['id']       = $value->id;
                $result['qty']      = $value->qty;
                $result['name']     = $value->name;
                $result['price']    = $value->price;
                $result['unit']     = $value->options['unit'];
                $result['numTop']   = $value->options['numTop'];
                $result['numBot']   = $value->options['numBot'];
                $result['changeType'] = $value->options['changeType'];
                $result['sort']     = $value->options['sort'];
            }
        }
        /*$result = array(
                'qty'       => $val,
                'numTop'    => $qtyRat['numTop'],
                'numBot'    => $qtyRat['numBot']
            );*/
        echo json_encode($result);
    }

    public function update_cart_input_2(Request $request){
        $rowid = $request->rowid;
        $numTop = $request->val;
        $pid = $request->pid;
        $is_option = $request->is_option;
        $type = $request->type;

        if( $is_option == 1 ){
            $cartContent = Cart::instance('recipe_op_'.$pid)->content();
            $qty = $numTop/($cartContent["$rowid"]->options['numBot']);
            Cart::instance('recipe_op_'.$pid)->update($rowid, ['qty' => $qty, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $numTop,
                    'numBot' => $cartContent["$rowid"]->options['numBot'],   
                    'changeType' => 1,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }else{
            $cartContent = Cart::instance('recipe_pr_'.$pid)->content();
            $qty = $numTop/($cartContent["$rowid"]->options['numBot']);
            Cart::instance('recipe_pr_'.$pid)->update($rowid, ['qty' => $qty, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $numTop,
                    'numBot' => $cartContent["$rowid"]->options['numBot'],   
                    'changeType' => 1,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }
        $result = array(
                'qty' => $qty
            );
        echo json_encode($result);
    }

    public function update_cart_input_3(Request $request){
        $rowid = $request->rowid;
        $numBot = $request->val;
        $pid = $request->pid;
        $is_option = $request->is_option;
        $type = $request->type;

        if( $numBot <= 0 ){
            print_r($numBot);
            die(json_encode(['success' => false]));
        }
        if( $is_option == 1 ){
            $cartContent = Cart::instance('recipe_op_'.$pid)->content();
            $qty = ($cartContent["$rowid"]->options['numTop'])/$numBot;
            Cart::instance('recipe_op_'.$pid)->update($rowid, ['qty' => $qty, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $cartContent["$rowid"]->options['numTop'],
                    'numBot' => $numBot,
                    'changeType' => 1,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }else{
            $cartContent = Cart::instance('recipe_pr_'.$pid)->content();
            $qty = ($cartContent["$rowid"]->options['numTop'])/$numBot;
            Cart::instance('recipe_pr_'.$pid)->update($rowid, ['qty' => $qty, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'numTop' => $cartContent["$rowid"]->options['numTop'],
                    'numBot' => $numBot,
                    'changeType' => 1,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }
        $result = array(
                'success'   => true,
                'qty'       => $qty
            );
        echo json_encode($result);
    }

    public function update_cart_input_edit(Request $request){
        $ctm_id = $request->ctm_id;
        $rowid = $request->rowid;
        $qty = $request->qty;

        $qtyRat = Recipe::float2rat($qty, $tolerance = 1.e-6);
        $cartContent = Cart::instance('recipe_'.$ctm_id)->content();            
        Cart::instance('recipe_'.$ctm_id)->update($rowid, ['qty' => $qty, 'options' => [
                'unit'   => $cartContent["$rowid"]->options['unit'],
                'numTop' => $qtyRat['numTop'],
                'numBot' => $qtyRat['numBot'],   
                'changeType' => 0,
                'sort'   => $cartContent["$rowid"]->options['sort']
            ]]);

        //$recipeInfo = Cart::instance('recipe_'.$ctm_id)->update($rowid, $qty);        
    }

    public function update_cart_input_edit_2(Request $request){
        $ctm_id = $request->ctm_id;
        $rowid = $request->rowid;
        $numTop = $request->val;

        $cartContent = Cart::instance('recipe_'.$ctm_id)->content();
        $qty = $numTop/($cartContent[$rowid]->options['numBot']);
        Cart::instance('recipe_'.$ctm_id)->update($rowid, ['qty' => $qty, 'options' => [
                'unit'   => $cartContent[$rowid]->options['unit'],
                'numTop' => $numTop,
                'numBot' => $cartContent[$rowid]->options['numBot'],
                'changeType' => 1,
                'sort'   => $cartContent["$rowid"]->options['sort']
            ]]);
        //$recipeInfo = Cart::instance('recipe_'.$ctm_id)->update($rowid, $qty);
    }

    public function update_cart_input_edit_3(Request $request){
        $ctm_id = $request->ctm_id;
        $rowid = $request->rowid;
        $numBot = $request->val;
                
        $cartContent = Cart::instance('recipe_'.$ctm_id)->content();
        $qty = ($cartContent["$rowid"]->options['numTop'])/$numBot;
        Cart::instance('recipe_'.$ctm_id)->update($rowid, ['qty' => $qty, 'options' => [
                'unit'   => $cartContent["$rowid"]->options['unit'],
                'numTop' => $cartContent["$rowid"]->options['numTop'],
                'numBot' => $numBot,
                'changeType' => 1,
                'sort'   => $cartContent["$rowid"]->options['sort']
            ]]);
        //$recipeInfo = Cart::instance('recipe_'.$ctm_id)->update($rowid, $qty);        
    }
    //CART RECIPE
    public function addcartRecipe(Request $request){
        $spt_id     = $request->spt_id;
        $pid        = $request->pid;
        $isOption   = $request->isOption;
        
        //get product_stock info
        $product = DB::table('san_pham_tho')
        ->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
        ->where('spt_id', $spt_id)
        ->select('spt_name', 'unit_name')
        ->first();
        if(!empty($product) && count($product) > 0){
            if( $isOption == 1 ){
                $cartInfo = Cart::instance('recipe_op_'.$pid)->content();
                $max = 0;
                foreach($cartInfo as $opKey => $opVal){
                    if( $opVal->options['sort'] >= $max ){
                        $max = $opVal->options['sort'];
                    }
                }
            }else{
                $cartInfo = Cart::instance('recipe_pr_'.$pid)->content();
                $max = 0;
                foreach($cartInfo as $opKey => $opVal){
                    if( $opVal->options['sort'] >= $max ){
                        $max = $opVal->options['sort'];
                    }
                }
            }

            $cart = array(
                'id'    => $spt_id,
                'name'  => $product->spt_name,
                'qty'   => 1,
                'price' => 1,
                'options' => [
                    'unit'      => $product->unit_name,
                    'numTop'    => 1,
                    'numBot'    => 1,
                    'changeType'=> 0,
                    'sort'      => ((int)$max+1)
                ]
            );

            $checkItem = false;
            foreach($cartInfo as $k => $v){
                if( $v->id == $spt_id){
                    $checkItem = true; break;
                }
            }
            if( $checkItem ){
                $dataResult = array(
                    'status' => 0,
                );
                die (json_encode($dataResult));
            }else{
                if( $isOption == 1 ){
                    Cart::instance('recipe_op_'.$pid)->add($cart);
                }else{
                    Cart::instance('recipe_pr_'.$pid)->add($cart);
                }
                $statusReturn = true;    
            }            
        }else{
            $statusReturn = false;
        }
        
        if( $isOption == 1 ){
            $cartInfo = Cart::instance('recipe_op_'.$pid)->content();
        }else{
            $cartInfo = Cart::instance('recipe_pr_'.$pid)->content();
        }

        $dataResult = array(
            'status' => $statusReturn,                
        );
        echo (json_encode($dataResult));        
    }

    public function delitemRecipe(Request $request){
        $rowId = $request->rowId;
        $pid   = $request->pid;
        $isOption = $request->isOption;
        if( $isOption == 1 ){
            Cart::instance('recipe_op_'.$pid)->remove($rowId);
        }else{
            Cart::instance('recipe_pr_'.$pid)->remove($rowId);
        }
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart_recipe(Request $request){
        $pid   = $request->pid;
        $isOption   = $request->isOption;
        if($isOption == 1){
            $info = Cart::instance('recipe_op_'.$pid)->content();
            $countCart = Cart::instance('recipe_op_'.$pid)->count();
        }else{
            $info = Cart::instance('recipe_pr_'.$pid)->content();
            $countCart = Cart::instance('recipe_pr_'.$pid)->count();
        }
        $sort = array();
        foreach($info as $inKey => $inVal){
            $sort[] = $inVal->options['sort'];
        }
        sort($sort);
        $dataResult = array(
                'content'   => $info,
                'count'     => $countCart,
                'sort'      => $sort
            );
        echo (json_encode($dataResult));
    }

    public function search_create(Request $request)
    {
        //get product info
        $s_pid = $request->s_pid;
        if($request->token_ && $request->token_ == 1){
            $prodSale = Recipe::getOptionSale($s_pid);
        }else{
            $prodSale = Recipe::getprodSale($s_pid);
        }

        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        
        $listProduct = Recipe::searchRecipe($stxt, $category_id);
        $listCategory = Recipe::listCategory();
        
        $cat_name = Recipe::getCategory($category_id);
        if( $cat_name != false ){
            $category_name = $cat_name->name;
        }else{
            $category_name = false;
        }

        $data = array(
                'products'      => $listProduct,
                'stxt'          => $stxt,
                'category_id'   => $category_id,
                'category'      => $listCategory,
                'category_name' => $category_name,
                'prodSale'      => $prodSale
            );
        
        //xử lý cart(recipe == 'công thức món') info để đồng bộ với dữ liệu nhập từ form
        if($request->token_ && $request->token_ == 1){
            $recipeInfo = Cart::instance('recipe_op_'.$s_pid)->content();
            $cartCount = Cart::instance('recipe_op_'.$s_pid)->count();
        }else{
            $recipeInfo = Cart::instance('recipe_pr_'.$s_pid)->content();
            $cartCount = Cart::instance('recipe_pr_'.$s_pid)->count();
        }
        
        $recipeInfo2 = array();
        foreach($recipeInfo as $recipeItem){
            $recipeInfo2[] = $recipeItem;
        }

        $data['contentRecipe'] = $recipeInfo2;
        $data['countRecipe'] = $cartCount;
        
        return view('backend.recipe.s_create', $data);
    }

    public function saverecipe(Request $request){
        
        $pid = trim($request->pid);
        if($request->token_ ){
            $isOption = 1;
            $cartInfo = Cart::instance('recipe_op_'.$pid)->content();
            $cartCount = Cart::instance('recipe_op_'.$pid)->count();
        }else{
            $isOption = 0;
            $cartInfo = Cart::instance('recipe_pr_'.$pid)->content();
            $cartCount = Cart::instance('recipe_pr_'.$pid)->count();
        }
/*echo "<pre>";
print_r($cartInfo);
echo "</pre>";die;*/
        if( $cartInfo != null && $cartCount > 0){
            $rules = [
                'recipeName'    =>'required|unique:cong_thuc_mon,ctm_name',
                'qtyRecipe.*'   =>['regex:/^(\d+|\d+\.{1}\d+)$/']
                //'qtyRecipe.*'   =>['required','regex:/^(\0|\d+\.{1}\d+)$|^(\d+|\d+\.{1}\d+)$/'] 0.0001
            ];
            $messages = [
                'recipeName.required'   =>'Bạn chưa nhập tên công thức',
                'recipeName.unique'     =>'Tên công thức bị trùng lặp',
                'qtyRecipe.required'    =>'Bạn chưa nhập lượng sản phẩm',
                'qtyRecipe.*.regex'     =>'Định dạng lượng sản phẩm không đúng!',
            ];
            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $idRecipe   = $request->idRecipe;
                $nameRecipe = $request->nameRecipe;
                $qtyRecipe  = $request->qtyRecipe;
/*echo "<pre>";
print_r($qtyRecipe);
echo "</pre>";die;*/
                $arrDetailsID   = array();
                $arrDetailsName = array();
                foreach($idRecipe as $k => $id){
                    $arrDetailsID[$id] = $qtyRecipe[$k];
                    $arrDetailsName[$id] = $nameRecipe[$k];
                }

                $recipeInsert = array(
                    'ctm_name'          => $request->recipeName,
                    'ctm_details'       => json_encode($arrDetailsID),
                    'ctm_details_name'  => json_encode($arrDetailsName),
                    'ctm_desc'          => $request->recipeDesc,
                    'ctm_status'        => 1
                );

                /*if( $isOption == 1 ){
                    foreach($cartInfo as $cartKey => $cartValue){
                        Cart::instance('recipe_op_'.$pid)->update($cartKey,1);
                    }
                echo "<pre>";
                print_r(Cart::instance('recipe_op_'.$pid)->content());
                echo "</pre>";
                }elseif( $isOption == 0 ){
                    foreach($cartInfo as $cartKey2 => $cartValue2){
                        Cart::instance('recipe_pr_'.$pid)->update($cartKey2,1);
                    }
                    echo "<pre>";
                print_r(Cart::instance('recipe_pr_'.$pid)->content());
                echo "</pre>";
                }die;*/
                
/*echo "<pre>";
print_r($recipeInsert);
echo "</pre>";die;*/
                $ctm_id = Recipe::createRecipe($recipeInsert);
//echo $ctm_id;
                if($isOption == 1){
                    $arr = array('ctm_id' => $ctm_id);
                    if(Recipe::updateCtmIdOption($pid, $arr)){
                        Cart::instance('recipe_op_'.$pid)->destroy();
                        //return redirect()->route('recipe.edit',['ctm_id' => $ctm_id,'pid' => $pid,'token_' => 1])->with(['flash_message_succ3' => 'Tạo công thức thành công!'])->withInput();
                        return redirect()->route('recipe.index')->with(['flash_message_succ' => 'Tạo công thức thành công!']);
                    }else{
                        return redirect()->route('recipe.create',['pid' => $pid,'token_' => 1])->with(['flash_message_err' => 'Không xác định sản phẩm này!'])->withInput();
                    }
                }else{
                    $arr = array('product_ctm_id' => $ctm_id);
                    if(Recipe::updateCtmIdProduct($pid, $arr)){
                        Cart::instance('recipe_pr_'.$pid)->destroy();
                        //return redirect()->route('recipe.edit',['ctm_id' => $ctm_id,'pid' => $pid])->with(['flash_message_succ3' => 'Tạo công thức thành công!'])->withInput();
                        return redirect()->route('recipe.index')->with(['flash_message_succ' => 'Tạo công thức thành công!']);
                    }else{
                        return redirect()->route('recipe.create',['pid' => $pid])->with(['flash_message_err' => 'Không xác định sản phẩm này!'])->withInput();
                    }
                }
            }
        }else{
            if($isOption == 1){
                return redirect()->route('recipe.create',['pid' => $pid,'token_' => 1])->with(['flash_message_err' => 'Bạn chưa chọn sản phẩm nào!'])->withInput();
            }else{
                return redirect()->route('recipe.create',['pid' => $pid])->with(['flash_message_err' => 'Bạn chưa chọn sản phẩm nào!'])->withInput();               
            }
        }
    }
    //END CART RECIPE

    //CART RECIPE edit
    public function addcart(Request $request){
        $spt_id = $request->spt_id;
        $ctm_id = $request->ctm_id;

        $recipeInfo = Cart::instance('recipe_'.$ctm_id)->content();
        $checkItemRecipe = false;
        foreach($recipeInfo as $k => $v){
            if( $v->id == $spt_id){
                $checkItemRecipe = true; break;
            }
        }
        if( $checkItemRecipe ){
            $dataResult = array(
                'status' => 0,
            );
            die (json_encode($dataResult));
        }else{            
            $max = 0;
            foreach($recipeInfo as $opKey => $opVal){
                if( $opVal->options['sort'] >= $max ){
                    $max = $opVal->options['sort'];
                }
            }

            //get product_stock info
            $product = Recipe::getASpt($spt_id);
            if(!empty($product) && count($product) > 0){
                $cart = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => 1,
                    'price' => 1,
                    'options' => [
                        'unit' => $product->unit_name,
                        'numTop'    => 1,
                        'numBot'    => 1,
                        'changeType'=> 0,
                        'sort'      => ((int)$max+1)
                    ]
                );            
                Cart::instance('recipe_'.$ctm_id)->add($cart);
                $statusReturn = true;
            }else{
                $statusReturn = false;
            }
            
            $dataResult = array(
                'status' => $statusReturn,                
            );
            echo (json_encode($dataResult));
        }
        
    }

    public function delitem(Request $request){
        $rowId = $request->rowId;
        $ctm_id = $request->ctm_id;
        $hn_id = $request->hn_id;

        /*if( (int)$hn_id > 0 ){
            Recipe::delRecipeDetailsItem($ctm_id, $hn_id);            
        }*/

        Cart::instance('recipe_'.$ctm_id)->remove($rowId);        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart(Request $request){
        $ctm_id = $request->ctm_id;
        $info = Cart::instance('recipe_'.$ctm_id)->content();
        $sort = array();
        foreach($info as $inKey => $inVal){
            $sort[] = $inVal->options['sort'];
        }
        sort($sort);
        $dataResult = array(
                'content'   => $info,
                'sort'      => $sort
            );
        echo (json_encode($dataResult));
    }

    public function search_edit(Request $request)
    {        
        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        $ctm_id = $request->ctm_id;
        
        $listProduct = Recipe::searchRecipe($stxt, $category_id);
        $listCategory = Recipe::listCategory();
        $details = Recipe::details($ctm_id);
        $ctm_details = json_decode($details->ctm_details,true);
        $ctm_details_name = json_decode($details->ctm_details_name);
        
        $cat_name = Recipe::getCategory($category_id);
        if( $cat_name != false ){
            $category_name = $cat_name->name;
        }else{
            $category_name = false;
        }

        $getUnit = Recipe::getUnit($ctm_details);

        Cart::instance('recipe_'.$ctm_id);
        foreach($ctm_details as $pid => $qty){
            $addCartInfo = array(
                    'id'    => $pid,
                    'name'  => $ctm_details_name->$pid,
                    'qty'   => 1,
                    'price' => 1,
                    'options'=> [
                            'quantity' => $qty,
                            'unit'     => $getUnit[$pid]
                        ]
                );
            Cart::instance('recipe_'.$ctm_id)->add($addCartInfo);
        }

        //get product info
        $s_pid = $request->s_pid;
        if($request->token_ && $request->token_ == 1){
            $prodSale = Recipe::getOptionSale($s_pid);
        }else{
            $prodSale = Recipe::getprodSale($s_pid);
        }

        $data = array(
                'prodSale'      => $prodSale,
                'products'      => $listProduct,
                'stxt'          => $stxt,
                'category_id'   => $category_id,
                'category'      => $listCategory,
                'category_name' => $category_name,

                'content'   => Cart::instance('recipe_'.$ctm_id)->content(),                
                'ctm_id'    => $details->ctm_id,
                'ctm_name'  => $details->ctm_name,
                'ctm_desc'  => $details->ctm_desc
            );
        return view('backend.recipe.s_edit', $data);
    }

    public function updateRecipe(Request $request)
    {        
        $ctm_id = $request->ctm_id;
        $pid = $request->pid;

        if(Cart::instance('recipe_'.$ctm_id)->count() > 0){
            $rules = [
                'recipeName'    =>'required|unique:cong_thuc_mon,ctm_name,'.$ctm_id.',ctm_id',
                'qtyRecipe.*'   =>['required','regex:/^(\d+|\d+\.{1}\d+)$/']
            ];
            $messages = [
                'recipeName.required'   =>'Bạn chưa nhập tên công thức',
                'recipeName.unique'     =>'Tên công thức bị trùng lặp',
                'qtyRecipe.required'    =>'Bạn chưa nhập lượng sản phẩm',
                'qtyRecipe.*.regex'     =>'Định dạng lượng sản phẩm không đúng!',
            ];
            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                //xóa chi tiết công thức
                //Recipe::delRecipe($ctm_id);

                //update công thức
                $idRecipe   = $request->idRecipe;
                $nameRecipe = $request->nameRecipe;
                $qtyRecipe  = $request->qtyRecipe;

                $arrDetailsID   = array();
                $arrDetailsName = array();
                foreach($idRecipe as $k => $id){
                    $arrDetailsID[$id] = $qtyRecipe[$k];
                    $arrDetailsName[$id] = $nameRecipe[$k];
                }

                $recipeUpdate = array(
                    'ctm_name'          => $request->recipeName,
                    'ctm_details'       => json_encode($arrDetailsID),
                    'ctm_details_name'  => json_encode($arrDetailsName),
                    'ctm_desc'          => $request->recipeDesc,
                    'ctm_status'        => 1
                );

                Recipe::update($ctm_id, $recipeUpdate);
                //Cart::instance('recipe_'.$ctm_id)->destroy();
                /*if($request->token_ && $request->token_ == 1){
                    return redirect()->route('recipe.edit', ['ctm_id' => $ctm_id, 'pid' => $pid, 'token_' => 1])->with(['flash_message_succ3' => 'Sửa công thức thành công!'])->withInput();    
                }else{
                    return redirect()->route('recipe.edit', ['ctm_id' => $ctm_id, 'pid' => $pid])->with(['flash_message_succ3' => 'Sửa công thức thành công!'])->withInput();
                }*/
                return redirect()->route('recipe.index')->with(['flash_message_succ' => 'Sửa công thức thành công!']);
            }
        }else{
            return redirect()->route('recipe.edit', ['ctm_id' => $ctm_id, 'pid' => $pid])->with(['flash_message_err3' => 'Bạn chưa chọn sản phẩm nào!'])->withInput();
        }
    }

    public function del_more(Request $request)
    {
        $listId = $request->idArr;

        if(Recipe::del_more($listId) == null){
            $success = true;
        }else{
            $success = false;
        }
        echo $success;
    }

}
