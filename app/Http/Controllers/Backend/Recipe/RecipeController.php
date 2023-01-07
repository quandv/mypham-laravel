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
            if( $product->spt_quantity <= 0 ) {
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
            if( $product->spt_quantity <= 0 ) {
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
    {   
        //$request->session()->flush();//die;
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
        //$request->session()->flush();//die;
        $listCategory = Recipe::listCategory();
        $listProduct = Recipe::listProduct();
        $details = Recipe::details($id);
        $ctm_details = json_decode($details->ctm_details, true);
        $ctm_details_name = json_decode($details->ctm_details_name);
        $getUnit = Recipe::getUnit($ctm_details);

        //Session::forget('recipe_'.$id);
        foreach($ctm_details as $pid => $qty){            
            //xử lý qty ra dạng phân số numTop/numBot
            $qtyRat = Recipe::float2rat($qty, $tolerance = 1.e-6);
            $addCartInfo[$pid] = array(
                    'id'    => $pid,
                    'name'  => $ctm_details_name->$pid,
                    'qty'   => $qty,
                    'price' => 1,
                    'unit'      => $getUnit[$pid],
                    'numTop'    => $qtyRat['numTop'],
                    'numBot'    => $qtyRat['numBot'],
                    'changeType'=> 0,
                );
            
        }
        Session::put('recipe_'.$id,$addCartInfo);

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
            $cartContent = Session::get('recipe_op_'.$pid);

            $cartContent[$spt_id]['qty'] = $val;
            $cartContent[$spt_id]['numTop'] = $qtyRat['numTop'];
            $cartContent[$spt_id]['numBot'] = $qtyRat['numBot'];

            $this->update_cart('recipe_op_'.$pid,$cartContent);
        }else{
            $cartContent = Session::get('recipe_pr_'.$pid);            
            $cartContent[$spt_id]['qty'] = $val;
            $cartContent[$spt_id]['numTop'] = $qtyRat['numTop'];
            $cartContent[$spt_id]['numBot'] = $qtyRat['numBot'];

            $this->update_cart('recipe_pr_'.$pid,$cartContent);
        }
        //echo json_encode($result);
    }

    public function update_cart_input_2(Request $request){
        $rowid = $request->rowid;
        $numTop = $request->val;
        $pid = $request->pid;
        $is_option = $request->is_option;
        $type = $request->type;

        if( $is_option == 1 ){
            $cartContent = Session::get('recipe_op_'.$pid);
            $qty = $numTop/($cartContent[$rowid]['numBot']);

            $cartContent[$rowid]['qty'] = $qty;
            $cartContent[$rowid]['numTop'] = $numTop;

            $this->update_cart('recipe_op_'.$pid,$cartContent);
        }else{
            $cartContent = Session::get('recipe_pr_'.$pid);
            $qty = $numTop/($cartContent[$rowid]['numBot']);
            $cartContent[$rowid]['qty'] = $qty;
            $cartContent[$rowid]['numTop'] = $numTop;
            
            $this->update_cart('recipe_pr_'.$pid,$cartContent);
        }
        
    }

    public function update_cart_input_3(Request $request){
        $rowid = $request->rowid;
        $numBot = $request->val;
        $pid = $request->pid;
        $is_option = $request->is_option;
        $type = $request->type;

        if( $is_option == 1 ){
            $cartContent = Session::get('recipe_op_'.$pid);         
            $qty = $cartContent[$rowid]['numTop']/$numBot;

            $cartContent[$rowid]['qty'] = $qty;
            $cartContent[$rowid]['numBot'] = $numBot;

            $this->update_cart('recipe_op_'.$pid,$cartContent);
        }else{
            $cartContent = Session::get('recipe_pr_'.$pid);          
            $qty = $cartContent[$rowid]['numTop']/$numBot;
            $cartContent[$rowid]['qty'] = $qty;
            $cartContent[$rowid]['numBot'] = $numBot;
            
            $this->update_cart('recipe_pr_'.$pid,$cartContent);
        }
    }

    public function update_cart_input_edit(Request $request){
        $ctm_id = $request->ctm_id;
        $spt_id = $request->spt_id;
        $qty = $request->qty;

        $qtyRat = Recipe::float2rat($qty, $tolerance = 1.e-6);
        $cartContent = Session::get('recipe_'.$ctm_id);

        $cartContent[$spt_id]['qty'] = $qty;
        $cartContent[$spt_id]['numTop'] = $qtyRat['numTop'];
        $cartContent[$spt_id]['numBot'] = $qtyRat['numBot'];
        $cartContent[$spt_id]['changeType'] = 0;
        
        $this->update_cart('recipe_'.$ctm_id,$cartContent);

    }

    public function update_cart_input_edit_2(Request $request){
        $ctm_id = $request->ctm_id;
        $spt_id = $request->spt_id;
        $numTop = $request->val;

        $cartContent = Session::get('recipe_'.$ctm_id);
        $qty = $numTop/($cartContent[$spt_id]['numBot']);

        $cartContent[$spt_id]['qty'] = $qty;
        $cartContent[$spt_id]['numTop'] = $numTop;
        $cartContent[$spt_id]['changeType'] = 1;
        
        $this->update_cart('recipe_'.$ctm_id,$cartContent);
    }

    public function update_cart_input_edit_3(Request $request){
        $ctm_id = $request->ctm_id;
        $spt_id = $request->spt_id;
        $numBot = $request->val;
                
        $cartContent = Session::get('recipe_'.$ctm_id);
        $qty = ($cartContent[$spt_id]['numTop'])/$numBot;
        
        $cartContent[$spt_id]['qty'] = $qty;
        $cartContent[$spt_id]['numBot'] = $numBot;
        $cartContent[$spt_id]['changeType'] = 1;
        
        $this->update_cart('recipe_'.$ctm_id,$cartContent);  
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
                $cartInfo = Session::get('recipe_op_'.$pid);
            }else{
                $cartInfo = Session::get('recipe_pr_'.$pid);
            }

            $quantity = 1;
            if (!isset($cartInfo[$spt_id])) { 
                $cartInfo[$spt_id] = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => $quantity,
                    'price' => 1,                
                    'unit'      => $product->unit_name,
                    'numTop'    => 1,
                    'numBot'    => 1,
                    'changeType'=> 0,
                );
            
                if( $isOption == 1 ){
                    $this->update_cart('recipe_op_'.$pid, $cartInfo);
                }else{
                    $this->update_cart('recipe_pr_'.$pid, $cartInfo);
                }
            }else{
                $cartInfo[$spt_id]['qty'] = $cartInfo[$spt_id]['qty'] + 1;
                if( $isOption == 1 ){
                    $this->update_cart('recipe_op_'.$pid, $cartInfo);
                }else{
                    $this->update_cart('recipe_pr_'.$pid, $cartInfo);
                }
            }
            $statusReturn = true;
        }else{
            $statusReturn = false;
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
            $opRecipe = Session::get('recipe_op_'.$pid);
            unset($opRecipe[$rowId]);
            $this->update_cart('recipe_op_'.$pid, $opRecipe);
        }else{
            $proRecipe = Session::get('recipe_pr_'.$pid);
            unset($proRecipe[$rowId]);
            $this->update_cart('recipe_pr_'.$pid, $proRecipe);
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
            $info = Session::get('recipe_op_'.$pid);
        }else{
            $info = Session::get('recipe_pr_'.$pid);
        }
       
        $dataResult = array(
                'content'   => $info,
                'count'     => count($info)
            );
        echo (json_encode($dataResult));
    }

    public function saverecipe(Request $request){
        
        $pid = trim($request->pid);
        if($request->token_ ){
            $isOption = 1;
            $cartInfo = Session::get('recipe_op_'.$pid);
            $cartCount = count($cartInfo);
        }else{
            $isOption = 0;
            $cartInfo = Session::get('recipe_pr_'.$pid);
            $cartCount = count($cartInfo);
        }

        if( $cartInfo != null && $cartCount > 0){
            $rules = [
                'recipeName'    =>'required|unique:cong_thuc_mon,ctm_name',
                'qtyRecipe.*'   =>['required','regex:/^(\d+|\d+\.{1}\d+)$/','min:0.0000001','numeric']
                //'qtyRecipe.*'   =>['required','regex:/^(\0|\d+\.{1}\d+)$|^(\d+|\d+\.{1}\d+)$/'] 0.0001
            ];
            $messages = [
                'recipeName.required'   =>'Bạn chưa nhập tên công thức',
                'recipeName.unique'     =>'Tên công thức bị trùng lặp',
                'qtyRecipe.required'    =>'Bạn chưa nhập lượng sản phẩm',
                'qtyRecipe.*.regex'     =>'Định dạng lượng sản phẩm không đúng!',
                'qtyRecipe.*.min'       =>'Lượng sản phẩm lớn hơn 0!',

            ];
            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $idRecipe   = $request->idRecipe;
                $nameRecipe = $request->nameRecipe;
                $qtyRecipe  = $request->qtyRecipe;

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
                        Session::forget('recipe_op_'.$pid);
                        //return redirect()->route('recipe.edit',['ctm_id' => $ctm_id,'pid' => $pid,'token_' => 1])->with(['flash_message_succ3' => 'Tạo công thức thành công!'])->withInput();
                        return redirect()->route('recipe.index')->with(['flash_message_succ' => 'Tạo công thức thành công!']);
                    }else{
                        return redirect()->route('recipe.create',['pid' => $pid,'token_' => 1])->with(['flash_message_err' => 'Không xác định sản phẩm này!'])->withInput();
                    }
                }else{
                    $arr = array('product_ctm_id' => $ctm_id);
                    if(Recipe::updateCtmIdProduct($pid, $arr)){
                        Session::forget('recipe_pr_'.$pid);
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

        $recipeInfo = Session::get('recipe_'.$ctm_id);
        
        $quantity = 0;
        //get product_stock info
        $product = Recipe::getASpt($spt_id);
        if(!empty($product) && count($product) > 0){
            if (!isset($recipeInfo[$spt_id])) { 
                $recipeInfo[$spt_id] = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => $quantity,
                    'price' => 1,
                    'unit' => $product->unit_name,
                    'numTop'    => 1,
                    'numBot'    => 1,
                    'changeType'=> 0,
                );
                $this->update_cart('recipe_'.$ctm_id,$recipeInfo);                
            }else{
                $recipeInfo[$spt_id]['qty'] = $recipeInfo[$spt_id]['qty'] + 1;
                $this->update_cart('recipe_'.$ctm_id,$recipeInfo);
            }
            $statusReturn = true;
        }else{
            $statusReturn = false;
        }
        
        $dataResult = array(
            'status' => $statusReturn,                
        );
        echo (json_encode($dataResult));        
        
    }

    public function delitem(Request $request){
        $ctm_id = $request->ctm_id;
        $hn_id = $request->hn_id;

        $cartInfo = Session::get('recipe_'.$ctm_id);
        unset($cartInfo[$hn_id]);
        $this->update_cart('recipe_'.$ctm_id,$cartInfo);

        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart(Request $request){
        $ctm_id = $request->ctm_id;
        $info = Session::get('recipe_'.$ctm_id);
        
        $dataResult = array(
                'content'   => $info,
            );
        echo (json_encode($dataResult));
    }

    public function updateRecipe(Request $request)
    {        
        $ctm_id = $request->ctm_id;
        $pid = $request->pid;

        if(count(Session::get('recipe_'.$ctm_id)) > 0){
            $rules = [
                'recipeName'    =>'required|unique:cong_thuc_mon,ctm_name,'.$ctm_id.',ctm_id',
                'qtyRecipe.*'   =>['required','regex:/^(\d+|\d+\.{1}\d+)$/','min:0.0000001','numeric']
            ];
            $messages = [
                'recipeName.required'   =>'Bạn chưa nhập tên công thức',
                'recipeName.unique'     =>'Tên công thức bị trùng lặp',
                'qtyRecipe.required'    =>'Bạn chưa nhập lượng sản phẩm',
                'qtyRecipe.*.regex'     =>'Định dạng lượng sản phẩm không đúng!',
                'qtyRecipe.*.min'       =>'Lượng sản phẩm lớn hơn 0!',
            ];
            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
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

    public function update_cart($session_key = null,$data = null){
        if (!is_null($session_key)) {
            Session::put($session_key,$data);
        }
        /*if (!is_null($session_key) && null !== Session::get($session_key)) {
            Session::forget($session_key);
            Session::put($session_key,$data);
        }else if(!is_null($session_key)){
            Session::put($session_key,$data);
        }*/
    }

    public function get_pro_op(){
        $result = Recipe::getProOp();

        echo json_encode($result);
    }

}
