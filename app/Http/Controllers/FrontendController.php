<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Mylibs\Mylibs;
use App\Events\Frontend\Cart\CartAdd;
use App\Models\Frontend\Frontend;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{   
    /**
     * @return \Illuminate\View\View
     */
    
    public function index()
    {
        
        /*$category = DB::table('category')
        ->select("category_name,category_id")
        ->where('category_status', 1)
        ->first();
        return redirect()->route('food', ['name' => Mylibs::alias($category->category_name), 'id' => $category->category_id]);*/
    }

    public function food($name=null, $id=null){ //echo '<pre>'; var_dump(Cart::content());die;
        if( $id == null && $name==null){
            $category = DB::table('category')
            ->select('category_name','category_id')
            ->where('category_status', 1)
            ->where('category_type', 0)
            ->first();
            //->toSql();dd($category);
           
            $id = $category->category_id;
            $name = Mylibs::alias($category->category_name);
        } 
        else {
            $id = (int)$id;
            $name = $name;
        }
        //check category_type
        $thisCat = DB::table('category')->select('category_type','category_status')->where('category_id', $id)->first();
        if(($thisCat->category_type == 1 && !access()->hasPermission('quan-ly-tang-2') && !access()->hasPermission('quan-ly-tang-3') && !access()->hasPermission('quan-ly-tang-4') && !access()->hasPermission('quan-ly-tang-5') && !access()->hasPermission('quan-ly-tang-6') && !access()->hasPermission('chef-do')) || $thisCat->category_status != 1 ){
            return redirect()->route('frontend.index');
        }

        //danh sách máy theo quản lý tầng
        if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')){

            $dataClient = DB::table("client")
            ->where(function($query) {
            if (access()->hasPermission('quan-ly-tang-2')) {
                $query->orWhere('client.room_id','=',2);
            }
            if (access()->hasPermission('quan-ly-tang-3')) {
                $query->orWhere('client.room_id','=',3);
            }
            if (access()->hasPermission('quan-ly-tang-4')) {
                $query->orWhere('client.room_id','=',4);
            }
            if (access()->hasPermission('quan-ly-tang-5')) {
                $query->orWhere('client.room_id','=',5);
            }
            if (access()->hasPermission('quan-ly-tang-6')) {
                $query->orWhere('client.room_id','=',6);
            }
            })
            ->orderBy('client_id', 'asc')
            ->get();

            $category = $this->root_category();
        }else{
            $dataClient = array();
            $category = $this->root_category_client();
        }
        //END-danh sách máy theo quản lý tầng
        
        foreach($category as $key => $value){
            $category[$key]->category_alias = strtolower(Mylibs::alias($value->category_name));
        }
        $data = array( 
            'category'      => $category,
            'category_id'   => $id
            );

        $limit = 4;
        $data['limit'] = $limit;
        if( is_numeric($id) ){
            if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6') || access()->hasPermission('chef-do')){
                $childs = DB::table('category')
                ->select('category_id', 'category_id_parent', 'category_name')
                ->where([
                    ['category_id_parent', $id],
                    ['category_status', 1]
                ])
                ->get();
            }else{
                $childs = DB::table('category')
                ->select('category_id', 'category_id_parent', 'category_name')
                ->where([
                    ['category_id_parent', $id],
                    ['category_status', 1],
                    ['category_type', 0]
                ])
                ->get();
            }

            if( !empty($childs) && count($childs) > 0 ){
                foreach($category as $cat){
                    if( $cat->category_id == $id ){
                        $data['title'] = mb_strtoupper($cat->category_name, 'UTF-8');
                    }
                }
                
                $listChildID = array();
                foreach($childs as $key => $value){
                    $childs[$key]->category_alias = strtolower(Mylibs::alias($value->category_name));
                    $listChildID[] = $value->category_id;
                }
                
                $data['childs'] = $childs;
                $data['category_id_parent'] = $id;
                $products = DB::table('product')
                ->leftJoin('option', 'product.product_id', '=', 'option.product_id')
                ->leftJoin('listoption', 'listoption.id', '=', 'option.option_id')
                ->selectRaw("product.product_id, product.product_name, product.product_price, product.product_desc, product.product_image, product.status, GROUP_CONCAT(option.id SEPARATOR ',') as option_id_group, GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group, GROUP_CONCAT(option.option_price SEPARATOR ',') as option_price_group, GROUP_CONCAT(listoption.status SEPARATOR ',') as option_status_group")
                ->whereIn('product.category_id', $listChildID)
                ->orderBy('product.sort', 'asc')
                ->groupBy('product.product_id')
                ->skip(0)->take($limit)
                ->get();
                //echo '<pre>'; print_r($products);die;

                //check category_type                
                if($thisCat->category_type == 1){
                    $employee = true;
                }else{
                    $employee = false;
                }
            }else{
                $parent = DB::table('category')
                ->select('category_id_parent', 'category_name', 'category_type')
                ->where([
                    ['category_id', $id],
                    ['category_status', 1]
                ])
                ->first();
                $data['title'] = mb_strtoupper($parent->category_name, 'UTF-8');
                
                if (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6') || access()->hasPermission('chef-do')){
                    $childs = DB::table('category')
                    ->select('category_id', 'category_id_parent', 'category_name')
                    ->where([
                        ['category_id_parent', $parent->category_id_parent],
                        ['category_status', 1]
                    ])
                    ->get();
                }else{
                    $childs = DB::table('category')
                    ->select('category_id', 'category_id_parent', 'category_name')
                    ->where([
                        ['category_id_parent', $parent->category_id_parent],
                        ['category_status', 1],
                        ['category_type', 0]
                    ])
                    ->get();
                }

                foreach($childs as $key => $value){
                    $childs[$key]->category_alias = strtolower(Mylibs::alias($value->category_name));
                }
                $data['childs'] = $childs;
                $data['category_id_parent'] = $parent->category_id_parent;
                $products = DB::table('product')
                ->leftJoin('option', 'product.product_id', '=', 'option.product_id')
                ->leftJoin('listoption', 'listoption.id', '=', 'option.option_id')
                ->selectRaw("product.product_id, product.product_name, product.product_price, product.product_desc, product.product_image, product.status, GROUP_CONCAT(option.id SEPARATOR ',') as option_id_group, GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group, GROUP_CONCAT(option.option_price SEPARATOR ',') as option_price_group, GROUP_CONCAT(listoption.status SEPARATOR ',') as option_status_group")
                ->where('category_id', $id)
                ->orderBy('product.sort', 'asc')
                ->groupBy('product.product_id')
                ->skip(0)->take($limit)
                ->get();

                if($parent->category_type == 1){
                    $employee = true;
                }else{
                    $employee = false;
                }
            }

            foreach( $products as $k => $product ){
                $option_id_group = explode(',', $product->option_id_group);
                $option_name_group = explode(',', $product->option_name_group);
                $option_price_group = explode(',', $product->option_price_group);
                $option_status_group = explode(',', $product->option_status_group);
                if( !empty($option_id_group) ){
                    $products[$k]->option_id_group = $option_id_group;
                }
                if( !empty($option_name_group) ){
                    $products[$k]->option_name_group = $option_name_group;
                }
                if( !empty($option_price_group) ){
                    $products[$k]->option_price_group = $option_price_group;
                }
                if( !empty($option_status_group) ){
                    $products[$k]->option_status_group = $option_status_group;
                }
            }

            $data['products'] = $products;
            $data['dataClient'] = $dataClient;

            if($employee == true){
                //cart for employee
                if( !empty(Cart::instance('cart_employee')->content()) ){
                    $data['cart'] = Cart::content();
                    $data['subtotal'] = Cart::subtotal(0, ',', '.');
                    $data['count'] = Cart::count();
                }
                return view('frontend.employee', $data);    
            }else{
                //cart
                if( !empty(Cart::content()) ){
                    $data['cart'] = Cart::content();
                    $data['subtotal'] = Cart::subtotal(0, ',', '.');
                    $data['count'] = Cart::count();
                }
                return view('frontend.index', $data);
            }
            
        }else{
            return redirect()->route('frontend.index');
        }
    }

    public function product(Request $request){
        $limit = 4;
        $offset = isset($request->offset) ?  $request->offset : $limit ;
        $category_id = isset($request->category_id) ?  $request->category_id : 1;       

        $childs = DB::table('category')->select('category_id', 'category_id_parent', 'category_name')->where('category_id_parent', $category_id)->get();

        if( !empty($childs) && count($childs) > 0 ){
            
            $listChildID = array();
            foreach($childs as $key => $value){
                $childs[$key]->category_alias = strtolower(Mylibs::alias($value->category_name));
                $listChildID[] = $value->category_id;
            }

            $products = DB::table('product')
            ->leftJoin('option', 'product.product_id', '=', 'option.product_id')
            ->leftJoin('listoption', 'listoption.id', '=', 'option.option_id')
            ->selectRaw("product.product_id, product.product_name, product.product_price, product.product_desc, product.product_image, product.status, GROUP_CONCAT(option.id SEPARATOR ',') as option_id_group, GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group, GROUP_CONCAT(option.option_price SEPARATOR ',') as option_price_group, GROUP_CONCAT(listoption.status SEPARATOR ',') as option_status_group")
            ->whereIn('product.category_id', $listChildID)
            ->orderBy('product.sort', 'asc')
            ->groupBy('product.product_id')
            ->skip($offset)->take($limit)
            ->get();            
            
        }else{
            $parent = DB::table('category')->select('category_id_parent')->where('category_id', $category_id)->first();
            $childs = DB::table('category')->select('category_id', 'category_id_parent', 'category_name')->where('category_id_parent', $parent->category_id_parent)->get();
            foreach($childs as $key => $value){
                $childs[$key]->category_alias = strtolower(Mylibs::alias($value->category_name));
            }            

            $products = DB::table('product')
            ->leftJoin('option', 'product.product_id', '=', 'option.product_id')
            ->leftJoin('listoption', 'listoption.id', '=', 'option.option_id')
            ->selectRaw("product.product_id, product.product_name, product.product_price, product.product_desc, product.product_image, product.status, GROUP_CONCAT(option.id SEPARATOR ',') as option_id_group, GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group, GROUP_CONCAT(option.option_price SEPARATOR ',') as option_price_group, GROUP_CONCAT(listoption.status SEPARATOR ',') as option_status_group")
            ->where('category_id', $category_id)
            ->orderBy('product.sort', 'asc')
            ->groupBy('product.product_id')
            ->skip($offset)->take($limit)
            ->get();        
        }

        foreach( $products as $k => $product ){
            $option_id_group = explode(',', $product->option_id_group);
            $option_name_group = explode(',', $product->option_name_group);
            $option_price_group = explode(',', $product->option_price_group);
            $option_status_group = explode(',', $product->option_status_group);
            if( !empty($option_id_group) ){
                $products[$k]->option_id_group = $option_id_group;
            }
            if( !empty($option_name_group) ){
                $products[$k]->option_name_group = $option_name_group;
            }
            if( !empty($option_price_group) ){
                $products[$k]->option_price_group = $option_price_group;
            }
            if( !empty($option_status_group) ){
                $products[$k]->option_status_group = $option_status_group;
            }
        }

        $data['childs'] = $childs;
        $data['products'] = $products;


        $dataResult = array(
                'category_id'   => $category_id,
                'products'      => $products,
                'offset'        => $offset+$limit,
            );
        if (access()->hasPermission('manager-product')) {
            $dataResult['managerProduct'] = true;
        }else{
            $dataResult['managerProduct'] = false;
        }
        die(json_encode($dataResult));

    }

    public function option(Request $request){
        $product_id = isset($request->product_id) ?  $request->product_id : 1 ;

        $options = DB::table('option')        
        ->where('product_id', $product_id)
        ->get();

        $dataResult = array(
                'options'      => $options,
        );

        die(json_encode($dataResult));
    }


    //CART
    public function addcart(Request $request){
        $product_id = $request->product_id;
        if(isset($request->option)){
            $option = $request->option;
            foreach (array_keys($option, '', true) as $key) {
                unset($option[$key]);
            }
        }else{
            $option = '';
        }
        //echo '<pre>'; print_r($option);die;

        //get product info
        $product = DB::table('product')
        ->where('product_id', $product_id)
        ->select('product_name', 'product_price')
        ->first();

        if(is_array($option)){
            //get option info
            $opId = array();
            foreach($option as $key => $value){
                $opId[] = $key;
            }

            $options = DB::table('option')
            ->whereIn('id', $opId)
            ->select('id', 'option_id', 'option_name', 'option_price')
            ->get();

            //add product and option into cart
            
            $opItem  = array();
            $opPrice = array();
            foreach($options as $op){
                foreach($option as $key => $value){            
                    if( $op->id == $key ){
                        $opItem[]  = $op->id.','.$op->option_name.','.$op->option_price.','.$value.','.$op->option_id;
                        $opPrice[] = $op->option_price*$value;
                    }
                }
                
                    
            }
        }else{
            $opItem  = array();
            $opPrice = array(0);
        }
        
        
        $cart = array(
            'id'    => $product_id,
            'name'  => $product->product_name,
            'qty'   => 1,
            'price' => $product->product_price+array_sum($opPrice),
            'options'   => $opItem
        );
        //echo '<pre>'; print_r($cart);die;

        Cart::add($cart);
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
        
    }

    public function updatecart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty + 1);
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function downcart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        if($qty > 1){
            Cart::update($rowId, $qty - 1);
        }else{
            Cart::remove($rowId);
        }
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function delitem(Request $request){
        $rowId = $request->rowId;        
        Cart::remove($rowId);
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function removecart(){
        Cart::destroy();
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart(){
        $dataResult = array(
            'content' => Cart::content(),
            'count'  => Cart::count()
            );
        echo (json_encode($dataResult));
    }

    public function insertorder(Request $request){
       
        if( filter_var($request->client_ip_select, FILTER_VALIDATE_IP) ){
            $client_ip = $request->client_ip_select;
        }else{
            $client_ip = $request->client_ip;
        }
        //echo $client_ip;die;
        $notice = htmlentities($request->notice);
        $room_ip = $_SERVER['REMOTE_ADDR'];

        //xu ly room (ip)
        $rooms = DB::table('room')->get();
        
        $IDreturnArr = array();
        foreach($rooms as $key => $val){
            $roomIPArr = explode(',', $val->room_ip);
            if(in_array($room_ip, $roomIPArr)){
                $IDreturnArr[] = $val->room_id;
            }
        }
        $dataResult = array();
        if( count($IDreturnArr) <= 0 ){
            $dataResult['status'] = 2;
            die(json_encode($dataResult));
        }

        $client = DB::table('client')
        ->join('room', 'room.room_id', '=', 'client.room_id')
        ->where('client_ip','=', $client_ip)
        ->whereIn('room.room_id', $IDreturnArr)
        ->select('client_ip', 'client_name', 'room.room_name', 'room.room_id')
        ->first();

        if(Cart::count() > 0){
            $cartSubtotal = Cart::subtotal(0,'',''); $cartSubtotal = str_replace(',', '', $cartSubtotal);
            $cartContent = Cart::content();
            
            $prodId = array();
            $opId = array();
            
            foreach($cartContent as $rowid => $item){
                $prodId[] = $item->id;
                foreach($item->options as $oKey => $oVal){
                    $oValArr = explode(',', $oVal);
                    $opId[] = $oValArr[4];
                }
            }
            
            //check sự tồn tại của sản phẩm hoặc option mà bếp phải xử lý hay không
            $checkChef = false;
            if( count($prodId) > 0 ){
                //-- check product
                $checkProduct_chef = DB::table('product')
                ->selectRaw("COUNT(IF(product_type = 1, 1,NULL)) as chefDo")
                ->whereIn('product_id', $prodId)
                ->first();
                if( $checkProduct_chef->chefDo > 0 ){
                    $checkChef = true;
                }
            }
            
            if( count($opId) > 0 ){
                //-- check option
                $checkOption_chef = DB::table('listoption')
                ->selectRaw("COUNT(IF(type = 1, 1,NULL)) as chefDo")
                ->whereIn('id', $opId)
                ->first();
                if( $checkOption_chef->chefDo > 0 ){
                    $checkChef = true;
                }
            }
            
            $dataSavetoOrder = array(
                'order_name'    => '',
                'order_create_time' => date('Y-m-d H:i:s', time()),
                'order_notice'  => $notice,
                'order_price'   => $cartSubtotal,
                'order_status'  => 1,
                'order_type'    => 0 // 0: khách đặt hàng | 1: nhân viên đặt hàng
            );
            if($checkChef == true){
                $dataSavetoOrder['order_chef_do'] = 1;
            }else{
                $dataSavetoOrder['order_chef_do'] = 0;
            }

            if ( (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')) && filter_var($request->client_ip_select, FILTER_VALIDATE_IP) ){

                $dataClient = DB::table("client")
                ->join('room', 'room.room_id', '=', 'client.room_id')
                ->where('client_ip','=', $client_ip)
                ->where(function($query) {
                if (access()->hasPermission('quan-ly-tang-2')) {
                    $query->orWhere('client.room_id','=',2);
                }
                if (access()->hasPermission('quan-ly-tang-3')) {
                    $query->orWhere('client.room_id','=',3);
                }
                if (access()->hasPermission('quan-ly-tang-4')) {
                    $query->orWhere('client.room_id','=',4);
                }
                if (access()->hasPermission('quan-ly-tang-5')) {
                    $query->orWhere('client.room_id','=',5);
                }
                if (access()->hasPermission('quan-ly-tang-6')) {
                    $query->orWhere('client.room_id','=',6);
                }
                })                
                ->first();

                $dataSavetoOrder['client_name'] = $dataClient->client_name;
                $dataSavetoOrder['client_ip']   = $dataClient->client_ip;
                $dataSavetoOrder['room']        = $dataClient->room_name;
                $dataSavetoOrder['room_id']     = $dataClient->room_id;
                
            }else{
                $dataSavetoOrder['client_name'] = $client->client_name;
                $dataSavetoOrder['client_ip']   = $client->client_ip;
                $dataSavetoOrder['room']        = $client->room_name;
                $dataSavetoOrder['room_id']     = $client->room_id;
                
            } 

            /*if ($dataSavetoOrder['room_id'] == 2 && access()->hasPermission('quan-ly-tang-2')) {
                event(new CartAdd("Có đơn hàng mới"));
            }
            if ($dataSavetoOrder['room_id'] == 3 && access()->hasPermission('quan-ly-tang-3')) {
                event(new CartAdd("Có đơn hàng mới"));
            }
            if ($dataSavetoOrder['room_id'] == 4 && access()->hasPermission('quan-ly-tang-4')) {
                event(new CartAdd("Có đơn hàng mới"));
            }
            if ($dataSavetoOrder['room_id'] == 5 && access()->hasPermission('quan-ly-tang-5')) {
                event(new CartAdd("Có đơn hàng mới"));
            }     */  
           /* $arr_message = [
                'room_id' => $dataSavetoOrder['room_id'],
                'messager' => 'Có đơn hàng mới'
            ];
            event(new CartAdd($arr_message));*/

            $dataSavetoOrderDetails = array();
            $processStockProduct = array();
            $processStockOption = array();

            $contentCart = Cart::content();
            //xu ly stock
            foreach( $contentCart as $cart ){
                $optionDetais = array();
                foreach( $cart->options as $key => $option ){
                    $optionItem = explode(',', $option);
                    $optionDetais[] = $optionItem;
                }
                //mang option(id => qty)
                foreach($optionDetais as $val){
                    if (array_key_exists($val['4'], $processStockOption)) {
                        $processStockOption[$val['4']] += $val['3']*$cart->qty;
                    }else{
                        $processStockOption[$val['4']] = $val['3']*$cart->qty;
                    }
                }
                //mang product(id => qty)
                if (array_key_exists($cart->id, $processStockProduct)) {
                    $processStockProduct[$cart->id] += $cart->qty;
                }else{
                    $processStockProduct[$cart->id] = $cart->qty;
                }
            }

            $processStockProductID = array_keys($processStockProduct);
            $processStockOptionID = array_keys($processStockOption);
            $stockNum = array();

            $recipeProduct = Frontend::recipeProduct($processStockProductID);
            foreach($recipeProduct as $k => $item){                
                $arrDetails = json_decode($item->ctm_details, true);
                $num = $processStockProduct[$item->pid];
                $recipeProduct[$k]->qty = $num;
                foreach($arrDetails as $key => $val){                    
                    if (array_key_exists($key, $stockNum)) {
                        $stockNum[$key] += $val*$num;
                    }else{
                        $stockNum[$key] = $val*$num;
                    }
                }
            }

            $recipeOption = Frontend::recipeOption($processStockOptionID);
            foreach($recipeOption as $k => $item){                
                $arrDetails = json_decode($item->ctm_details, true);
                $num = $processStockOption[$item->pid];
                $recipeOption[$k]->qty = $num;
                foreach($arrDetails as $key => $val){                    
                    if (array_key_exists($key, $stockNum)) {
                        $stockNum[$key] += $val*$num;
                    }else{
                        $stockNum[$key] = $val*$num;
                    }
                }
            }

            $dataSavetoOrder['order_stock'] = json_encode($stockNum);
                        
            //check stock remain
            $checkHetHang = false;
            $checkRemain = Frontend::checkRemain($stockNum);
            if($checkRemain['status']){
                $order_id = Frontend::createOrder($dataSavetoOrder, $stockNum);
                $dataResult['pstatus'] = 0;
            }else{
                $order_id = Frontend::createOrder($dataSavetoOrder, $stockNum);
                $id_arr = $checkRemain['id_arr']; // mang spt_id het hang

                if($request->config_pstatus == 0){ // cập nhật trạng thái sản phẩm bằng tay
                    $checkHetHang = true;
                    $dataResult['pstatus'] = 0;
                }else{ // cập nhật trạng thái sản phẩm tự động
                    $checkHetHang = false;
                    $dataResult['pstatus'] = 1;
                    $idArrRecipe = Frontend::check_recipe($id_arr);
                    
                    if(isset($idArrRecipe['product_over']) && count($idArrRecipe['product_over']) > 0){
                        $dataResult['product_over'] = $idArrRecipe['product_over'];
                    }
                    if(isset($idArrRecipe['option_over']) && count($idArrRecipe['option_over']) > 0){
                        $dataResult['option_over'] = $idArrRecipe['option_over'];
                    }
                }
            }
            $arr_message = [
                'room_id'   => $dataSavetoOrder['room_id'],
                'check'     => $checkHetHang,
                'messager'  => 'CHÚ Ý: Cập nhật trạng thái sản phẩm',
                'checkChef' => $checkChef
            ];
            event(new CartAdd($arr_message));

            foreach( $contentCart as $cart ){
                $optionDetais = array();

                $dataOrderDetails = array(
                        'order_id'      => $order_id,
                        'product_id'    => $cart->id,
                        'product_name'  => $cart->name,
                        'product_price' => $cart->price,
                        'product_quantity' => $cart->qty,
                        'category_id' => $this->get_catId($cart->id)
                    );

                foreach( $cart->options as $key => $option ){
                    $optionItem = explode(',', $option);
                    $optionDetais[] = $optionItem;
                }
                
                $dataOrderDetails['product_option'] = json_encode($optionDetais);
                $dataSavetoOrderDetails[] = $dataOrderDetails;
            }

            DB::table('order_details')->insert($dataSavetoOrderDetails);

            $dataResult['status'] = 1;
        }else{
            $dataResult['status'] = 0;
        }
        echo json_encode($dataResult);
    }


    /**
     * @return list category with category_id_parent = 0 (root category)
     */    
    public function root_category()
    {       
        return DB::table('category')
        ->where([
            ['category_id_parent', '=', 0],
            ['category_status', '=', 1]
        ])
        ->get();
    }

    /**
     * @return list category with category_id_parent = 0 (root category)
     */    
    public function root_category_client()
    {       
        return DB::table('category')
        ->where([
            ['category_id_parent', '=', 0],
            ['category_status', '=', 1],
            ['category_type', '=', 0]
        ])
        ->get();
    }

    public function get_catId($pid){
        $cat_id = DB::table('product')->where('product_id', $pid)->first();
        return $cat_id->category_id;
    }

    //function bổ trợ xử lý tăng giảm lượng sản phẩm trong kho khi order
    public function sumStokc($unit, $num){
        return $unit*$num;
    }

    // CART FOR EMPLOYEE
    public function add_cart_employee(Request $request){
        $product_id = $request->product_id;
        if(isset($request->option)){
            $option = $request->option;
            foreach (array_keys($option, '', true) as $key) {
                unset($option[$key]);
            }
        }else{
            $option = '';
        }
        //echo '<pre>'; print_r($option);die;

        //get product info
        $product = DB::table('product')
        ->where('product_id', $product_id)
        ->select('product_name', 'product_price')
        ->first();

        if(is_array($option)){
            //get option info
            $opId = array();
            foreach($option as $key => $value){
                $opId[] = $key;
            }

            $options = DB::table('option')
            ->whereIn('id', $opId)
            ->select('id', 'option_id', 'option_name', 'option_price')
            ->get();

            //add product and option into cart
            
            $opItem  = array();
            $opPrice = array();
            foreach($options as $op){
                foreach($option as $key => $value){            
                    if( $op->id == $key ){
                        $opItem[]  = $op->id.','.$op->option_name.','.$op->option_price.','.$value.','.$op->option_id;
                        $opPrice[] = $op->option_price*$value;
                    }
                } 
            }
        }else{
            $opItem  = array();
            $opPrice = array(0);
        }
        
        
        $cart = array(
            'id'    => $product_id,
            'name'  => $product->product_name,
            'qty'   => 1,
            'price' => $product->product_price+array_sum($opPrice),
            'options'   => $opItem
        );
        //echo '<pre>'; print_r($cart);die;

        Cart::instance('cart_employee')->add($cart);
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
        
    }

    public function update_cart_employee(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::instance('cart_employee')->update($rowId, $qty + 1);
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function down_cart_employee(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        if($qty > 1){
            Cart::instance('cart_employee')->update($rowId, $qty - 1);
        }else{
            Cart::instance('cart_employee')->remove($rowId);
        }
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function del_item_cart_employee(Request $request){
        $rowId = $request->rowId;        
        Cart::instance('cart_employee')->remove($rowId);
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function remove_cart_employee(){
        Cart::instance('cart_employee')->destroy();
        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart_employee(){
        $dataResult = array(
            'content' => Cart::instance('cart_employee')->content(),
            'count'  => Cart::instance('cart_employee')->count()
            );
        echo (json_encode($dataResult));
    }

    public function insert_order_employee(Request $request){
        $dataResult = array();

        $client_ip = $request->client_ip;
        $notice = htmlentities($request->notice);
        $room_ip = $_SERVER['REMOTE_ADDR'];

        //xu ly room (ip)
        $rooms = DB::table('room')->get();        
        $IDreturnArr = array();
        foreach($rooms as $key => $val){
            $roomIPArr = explode(',', $val->room_ip);
            if(in_array($room_ip, $roomIPArr)){
                $IDreturnArr[] = $val->room_id;
            }
        }
        
        if( count($IDreturnArr) <= 0 ){
            $dataResult['status'] = 2;
            die(json_encode($dataResult));
        }

        $client = DB::table('client')
        ->join('room', 'room.room_id', '=', 'client.room_id')
        ->where('client_ip','=', $client_ip)
        ->whereIn('room.room_id', $IDreturnArr)
        ->select('client_ip', 'client_name', 'room.room_name', 'room.room_id')
        ->first();

        if(Cart::instance('cart_employee')->count() > 0){
            $cartSubtotal = Cart::instance('cart_employee')->subtotal(0,'','');
            $cartSubtotal = str_replace(',', '', $cartSubtotal);

            $dataSavetoOrder = array(
                'order_name'    => '',
                'order_create_time' => date('Y-m-d H:i:s', time()),
                'order_notice'  => $notice,
                'order_price'   => $cartSubtotal,
                'order_status'  => 1,
                'order_type'    => 1 // 0: khách đặt hàng | 1: nhân viên đặt hàng
            );

            if ( (access()->hasPermission('quan-ly-tang-2') || access()->hasPermission('quan-ly-tang-3') || access()->hasPermission('quan-ly-tang-4') || access()->hasPermission('quan-ly-tang-5') || access()->hasPermission('quan-ly-tang-6')) ){

                $dataClient = DB::table("client")
                ->join('room', 'room.room_id', '=', 'client.room_id')
                ->where('client_ip','=', $client_ip)
                ->where(function($query) {
                    if (access()->hasPermission('quan-ly-tang-2')) {
                        $query->orWhere('client.room_id','=',2);
                    }
                    if (access()->hasPermission('quan-ly-tang-3')) {
                        $query->orWhere('client.room_id','=',3);
                    }
                    if (access()->hasPermission('quan-ly-tang-4')) {
                        $query->orWhere('client.room_id','=',4);
                    }
                    if (access()->hasPermission('quan-ly-tang-5')) {
                        $query->orWhere('client.room_id','=',5);
                    }
                    if (access()->hasPermission('quan-ly-tang-6')) {
                        $query->orWhere('client.room_id','=',6);
                    }
                })
                ->first();

                $dataSavetoOrder['client_name'] = $dataClient->client_name;
                $dataSavetoOrder['client_ip']   = $dataClient->client_ip;
                $dataSavetoOrder['room']        = $dataClient->room_name;
                $dataSavetoOrder['room_id']     = $dataClient->room_id;                
            }else{
                $dataResult['status'] = 4;
                die(json_encode($dataResult));
            }

            $dataSavetoOrderDetails = array();
            $processStockProduct = array();
            $processStockOption = array();

            $contentCart = Cart::instance('cart_employee')->content();
            //xu ly stock
            foreach( $contentCart as $cart ){
                $optionDetais = array();
                foreach( $cart->options as $key => $option ){
                    $optionItem = explode(',', $option);
                    $optionDetais[] = $optionItem;
                }
                //mang option(id => qty)
                foreach($optionDetais as $val){
                    if (array_key_exists($val['4'], $processStockOption)) {
                        $processStockOption[$val['4']] += $val['3']*$cart->qty;
                    }else{
                        $processStockOption[$val['4']] = $val['3']*$cart->qty;
                    }
                }
                //mang product(id => qty)
                if (array_key_exists($cart->id, $processStockProduct)) {
                    $processStockProduct[$cart->id] += $cart->qty;
                }else{
                    $processStockProduct[$cart->id] = $cart->qty;
                }
            }

            $processStockProductID = array_keys($processStockProduct);
            $processStockOptionID = array_keys($processStockOption);
            $stockNum = array();

            $recipeProduct = Frontend::recipeProduct($processStockProductID);
            foreach($recipeProduct as $k => $item){                
                $arrDetails = json_decode($item->ctm_details, true);
                $num = $processStockProduct[$item->pid];
                $recipeProduct[$k]->qty = $num;
                foreach($arrDetails as $key => $val){                    
                    if (array_key_exists($key, $stockNum)) {
                        $stockNum[$key] += $val*$num;
                    }else{
                        $stockNum[$key] = $val*$num;
                    }
                }
            }

            $recipeOption = Frontend::recipeOption($processStockOptionID);
            foreach($recipeOption as $k => $item){                
                $arrDetails = json_decode($item->ctm_details, true);
                $num = $processStockOption[$item->pid];
                $recipeOption[$k]->qty = $num;
                foreach($arrDetails as $key => $val){                    
                    if (array_key_exists($key, $stockNum)) {
                        $stockNum[$key] += $val*$num;
                    }else{
                        $stockNum[$key] = $val*$num;
                    }
                }
            }

            $dataSavetoOrder['order_stock'] = json_encode($stockNum);
                        
            //check stock remain
            $checkHetHang = false;
            $checkRemain = Frontend::checkRemain($stockNum);
            if($checkRemain['status']){
                $order_id = Frontend::createOrder($dataSavetoOrder, $stockNum);
                $dataResult['pstatus'] = 0;
            }else{
                $order_id = Frontend::createOrder($dataSavetoOrder, $stockNum);
                $id_arr = $checkRemain['id_arr']; // mang spt_id het hang

                if($request->config_pstatus == 0){ // cập nhật trạng thái sản phẩm bằng tay
                    $checkHetHang = true;
                    $dataResult['pstatus'] = 0;
                }else{ // cập nhật trạng thái sản phẩm tự động
                    $checkHetHang = false;
                    $dataResult['pstatus'] = 1;
                    $idArrRecipe = Frontend::check_recipe($id_arr);
                    
                    if(isset($idArrRecipe['product_over']) && count($idArrRecipe['product_over']) > 0){
                        $dataResult['product_over'] = $idArrRecipe['product_over'];
                    }
                    if(isset($idArrRecipe['option_over']) && count($idArrRecipe['option_over']) > 0){
                        $dataResult['option_over'] = $idArrRecipe['option_over'];
                    }
                }
            }
            $arr_message = [
                'room_id'   => $dataSavetoOrder['room_id'],
                'check'     => $checkHetHang,
                'messager'  => 'CHÚ Ý: Đơn hàng của nhân viên'
            ];
            event(new CartAdd($arr_message));

            foreach( $contentCart as $cart ){
                $optionDetais = array();

                $dataOrderDetails = array(
                        'order_id'      => $order_id,
                        'product_id'    => $cart->id,
                        'product_name'  => $cart->name,
                        'product_price' => $cart->price,
                        'product_quantity' => $cart->qty,
                        'category_id' => $this->get_catId($cart->id)
                    );

                foreach( $cart->options as $key => $option ){
                    $optionItem = explode(',', $option);
                    $optionDetais[] = $optionItem;
                }
                
                $dataOrderDetails['product_option'] = json_encode($optionDetais);
                $dataSavetoOrderDetails[] = $dataOrderDetails;
            }

            DB::table('order_details')->insert($dataSavetoOrderDetails);

            $dataResult['status'] = 1;
        }else{
            $dataResult['status'] = 0;
        }
        echo json_encode($dataResult);
    }
   
}