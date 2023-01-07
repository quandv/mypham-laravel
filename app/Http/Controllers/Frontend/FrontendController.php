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
use Config;
use Auth;
use Validator;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{   
    public $limit;
    public $menu;
    function __construct()
    {
        $this->limit = Config::get("vgmconfig.per_page");
        $this->menu = DB::table('category')
                ->where('category_id_parent', 0)
                ->where('category_type', 1)
                ->get();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {        
        $limit = 4;
        //get product sale off
        $sale = DB::table('product')
        ->where('product_type', 3)
        ->orderBy('product.sort', 'asc')
        ->skip(0)->take($limit)
        ->get();
        $hot = DB::table('product')
        ->where('product_type', 2)
        ->orderBy('product.sort', 'asc')
        ->skip(0)->take($limit)
        ->get();
        $new = DB::table('product')
        ->where('product_type', 1)
        ->orderBy('product.sort', 'asc')
        ->skip(0)->take($limit)
        ->get();
        
        $data = array(
                'title' => 'Mỹ phẩm ABC',
                'sale' => $sale,
                'hot' => $hot,
                'new' => $new,
                'menu' => $this->menu,
                'cart' => Cart::content(),
                'count' => Cart::count(),
                'subtotal' => Cart::subtotal(0, ',', '.')
            );
        return view('frontend.index', $data);
    }

    public function details($id,$name)
    {
        $details = DB::table('product')
        ->where('product_id', $id)
        ->first();
        if(count($details) > 0){
            $data = array(
                'details' => $details,
                'menu' => $this->menu,
                'cart' => Cart::content(),
                'count' => Cart::count(),
                'subtotal' => Cart::subtotal(0, ',', '.')
            );
            return view('frontend.details', $data);
        }else{
            return view('errors.503');
        }
        
    }

    public function category($id,$name){
        $products = DB::table('product')
        ->leftJoin('category', 'category.category_id', '=', 'product.category_id')
        ->select('product.*','category_name')
        ->where('product.status', 1)
        ->orderBy('product.sort', 'asc')
        ->paginate(1);
                        
        $data = array(
                'menu' => $this->menu,
                'category_id'   => $id,
                'category_name' => Frontend::getCategory($id),
                'products'      => $products
            );

        return view('frontend.category', $data);

    }

    public function search(Request $request){
        $s = $request->s;
        if( $s != '' ){
            $products = DB::table('product')
            ->where('product_name', 'like', '%'.$s.'%')
            ->where('product.status', 1)
            ->orderBy('product.sort', 'asc')
            ->paginate(1);
            $data = array(
                'title'          => 'Tìm kiếm',
                'menu'      => $this->menu,
                'stext'     => $s,
                'products'  => $products
            );

            return view('frontend.search', $data);
        }else{
            //return redirect('/');
        }
    }

    /*public function getSearch(Request $request){
        $s = $request->s;
        if( $request->page ){
            $page = $request->page;
        }else{
            $page = 1;
        }
        $limit = 12;
        $offset = ($page - 1)*$limit;
        if( $s != '' ){
            $products = DB::table('product')
            ->where('product_name', 'like', '%'.$s.'%')
            ->where('product.status', 1)
            ->orderBy('product.sort', 'asc')
            ->skip($offset)->limit($limit)
            ->get();
            $data = array(
                'title'          => 'Tìm kiếm',
                'menu'      => $this->menu,
                'stext'     => $s,
                'products'  => $products
            );

            return view('frontend.search', $data);
        }else{
            //return redirect('/');
        }

    }*/


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

        $limit = $this->limit;
        $data['limit'] = $this->limit;
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
        $limit = $this->limit;
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
                'limit'         => $limit
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

        //get product info
        $product = DB::table('product')
        ->where('product_id', $product_id)
        ->select('product_name', 'product_price', 'product_image')
        ->first();

        // echo '<pre>';
        // print_r($product);
        
        $product_image = json_decode($product->product_image);

        $cart = array(
            'id'    => $product_id,
            'name'  => $product->product_name,
            'qty'   => 1,
            'price' => $product->product_price,
            'options'   => array(
                    'img' => $product_image[0]
                )
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
        $qty = (int)$request->qty;
        if( $qty > 0 ){
            Cart::update($rowId, $qty);
            $thisItem = Cart::get($rowId);
            //print_r($thisItem);
            $dataResult = array(
                'status' => true,
                'price' => number_format($thisItem->qty*$thisItem->price, 0, ',','.'),
                'count' => Cart::count(),
                'subTotal' => Cart::subtotal(0, ',', '.'),
                'msg' => 'Cập nhật thành công'
            );
        }else{
            $dataResult = array(
                'status' => false,
                'msg' => 'Số lượng thay đổi không hợp lệ. Vui lòng nhập một số nguyên dương.'
            );
        }

        echo (json_encode($dataResult));
    }

    public function delitem(Request $request){
        $rowId = $request->rowId;

        Cart::remove($rowId);
        $dataResult = array(
            'status' => true,
            'count' => Cart::count(),
            'subTotal' => Cart::subtotal(0, ',', '.'),
            'msg' => 'Xử lý thành công'
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

    public function order(){
        $data = array(
            'title' => 'Giỏ hàng',
            'menu' => $this->menu,
            'cart' => Cart::content(),
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(0, ',', '.')
        );
        return view('frontend.order', $data);
    }

    public function order_confirm(){
        $data = array(
            'title' => 'Đặt hàng',
            'menu' => $this->menu,
            'cart' => Cart::content(),
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(0, ',', '.')
        );
        return view('frontend.order_confirm', $data);
    }

    public function insertorder(Request $request){
        $rules = [
            'customer_name' =>'required',
            'customer_phone' =>'required|min:9',
            'customer_address' =>'required',
        ];
        $messages = [
            'customer_name.required'=>'Bạn chưa nhập tên khách hàng',
            'customer_phone.required'=>'Bạn chưa nhập số điện thoại',
            'customer_phone.min'=>'Số điện thoại bao gồm ít nhất 9 chữ số',
            'customer_address.required'=>'Bạn chưa nhập địa chỉ',
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if(Cart::count() > 0){
                $cartSubtotal = Cart::subtotal(0,'','');
                $cartSubtotal = str_replace(',', '', $cartSubtotal);

                $cartContent = Cart::content();

                $dataSavetoOrder = array(
                    'customer_name'    => $request->customer_name,
                    'customer_phone'    => $request->customer_phone,
                    'customer_email'    => $request->customer_email,
                    'customer_address'    => $request->customer_address,
                    'order_create_time' => date('Y-m-d H:i:s', time()),
                    'order_notice'  => $request->order_notice,
                    'order_price'   => $cartSubtotal,
                    'order_status'  => 1,
                    'order_type'    => 0 // 0: khách đặt hàng | 1: nhân viên đặt hàng
                );
                $order_id = DB::table('order')->insertGetId($dataSavetoOrder);

                foreach( $cartContent as $cart ){
                    $dataOrderDetails = array(
                            'order_id'      => $order_id,
                            'product_id'    => $cart->id,
                            'product_name'  => $cart->name,
                            'product_price' => $cart->price,
                            'product_quantity' => $cart->qty,
                            'category_id' => $this->get_catId($cart->id)
                        );

                    $dataSavetoOrderDetails[] = $dataOrderDetails;
                }
                Cart::destroy();
                
                DB::table('order_details')->insert($dataSavetoOrderDetails);
                return redirect()->route('frontend.order_confirm')->with(['flash_message_succ' => 'Đặt hàng thành công. Cảm ơn bạn đã lựa chọn sản phẩm của Mỹ phẩm ABC'] );
            }else{
                return redirect()->back()->with(['flash_message_err' => 'Bạn chưa lựa chọn sản phẩm'])->withInput();
            }
        }
    }


    /**
     * @return list category with category_id_parent = 0 (root category)
     */    
    public function root_category(){       
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
    public function root_category_client(){       
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


    // CONTACT
    public function contact(){
        $data = array(
            'title' => 'Liên hệ',
            'menu' => $this->menu,
            
        );
        return view('frontend.contact', $data);
    }

    // SIGN-IN
    public function signin(){
        $data = array(
            'title' => 'Đăng nhập - Đăng ký',
            'menu' => $this->menu,
            
        );
        return view('frontend.sigin', $data);
    }

    // WISH-LIST
    public function wistlist(){
        $data = array(
            'title' => 'Yêu thích',
            'menu' => $this->menu,
            
        );
        return view('frontend.wistlist', $data);
    }

    // TERMS
    public function terms(){
        $data = array(
            'title' => 'Quy định',
            'menu' => $this->menu,
            
        );
        return view('frontend.terms', $data);
    }

    // TRACK ORDER
    public function order_track(){
        $data = array(
            'title' => 'Theo dõi đơn hàng',
            'menu' => $this->menu,
            
        );
        return view('frontend.order_track', $data);
    }

    // PRODUCT COMPARE
    public function product_compare(){
        $data = array(
            'title' => 'Theo dõi đơn hàng',
            'menu' => $this->menu,
            
        );
        return view('frontend.product_compare', $data);
    }

    // FAQ
    public function faq(){
        $data = array(
            'title' => 'Giải đáp thắc mắc',
            'menu' => $this->menu,
            
        );
        return view('frontend.faq', $data);
    }

    // 404
    public function error_404(){
        $data = array(
            'title' => '404!',
            'menu' => $this->menu,
            
        );
        return view('frontend.404', $data);
    }
}