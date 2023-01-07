<?php

namespace App\Http\Controllers\Backend\Bill;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Bill;
use App\Mylibs\Mylibs;
use Validator;
use DateTime;
use App\Events\Backend\OrderInput\OrderInputAdd;
use App\Events\Backend\OrderInput\OrderInputEdit;
use Cart;
use Auth;
use Session;


class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listBill = Bill::listBill();
        foreach($listBill as $key => $val){
            $listBill[$key]->hn_name_group = explode(',', $val->hn_name_group);
            $listBill[$key]->hn_price_group = explode(',', $val->hn_price_group);
            $listBill[$key]->hn_quantity_group = explode(',', $val->hn_quantity_group);
            $listBill[$key]->unit_name_group = explode(',', $val->unit_name_group);
        }
        $data = array(
                'listBill' => $listBill
            );

        return view('backend.bill.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   //$request->session()->flush();die;
        $listProduct = Bill::listProduct();
        $listCategory = Bill::listCategory();
        $listNsx = Bill::listNsx();

        $data = array(
                'products' => $listProduct,
                'category' => $listCategory,
                'listNsx'  => $listNsx
            );
        
        $cartInfo = Cart::instance('kho_hang')->content();
        
        if(Cart::instance('kho_hang')->count() > 0){            
            $data['countStock'] = Cart::instance('kho_hang')->count();
        }else{
            $data['countStock'] = 0;
        }
        //$data['content'] = $cartInfo;
        return view('backend.bill.create', $data);
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
    public function edit($id)
    {
        $details = Bill::details($id);
        $listNsx = Bill::listNsx();
        $listProduct = Bill::listProduct();
        $listCategory = Bill::listCategory();
        
        Cart::instance('bill_'.$id)->destroy();
        if( Cart::instance('bill_'.$id)->count() <= 0 ){
            $sort = 1;
            foreach( $details['billDetails'] as $key => $item){
                if($item->hn_quantity < 0.00001){
                    $item->hn_quantity = 0.00001;
                }
                $addCartInfo = array(
                        'id'    => $item->hn_spt_id,
                        'name'  => $item->hn_name,
                        'qty'   => $item->hn_quantity,
                        'price' => $item->hn_price,
                        'options'=> [
                                'expiry'    => $item->hn_time_expiry,
                                'unit'      => $item->unit_name,
                                'sort'      => $sort
                            ]
                    );
                Cart::instance('bill_'.$id)->add($addCartInfo);
                $sort++;
            }
        }

        $data = array(
                'listNsx'   => $listNsx,
                //'content'   => Cart::instance('bill_'.$id)->content(),
                'hdn_nsx_id'=> $details['hdn_nsx_id'],
                'hdn_code'  => $details['hdn_code'],
                'products'  => $listProduct,
                'category'  => $listCategory,
                'hdn_id'    => $id
            );

        return view('backend.bill.edit', $data);
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
            'pname'     =>'required|min:3',
            'pquantity' =>'required|numeric',
            'pimage'    =>'file|image|mimes:jpeg,jpg,png|max:5000'
        ];
        $messages = [
            'unit.required'     =>'Bạn chưa chọn danh mục sản phẩm',
            'pname.required'    =>'Bạn chưa nhập tên sản phẩm',
            'pquantity.required'=>'Bạn chưa nhập lượng sản phẩm',
            'pquantity.numeric' =>'Định dạng lượng sản phẩm chưa đúng',
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
                'spt_quantity'  => $request->pquantity,
                'spt_desc'      => $request->pdesc,
                'spt_status'    => $request->pstatus,
                'spt_image'     => $filename,
                'spt_category_id'   => $request->unit,

            ];
            $spt_catname = Bill::getCategory($request->unit);
            if(count($spt_catname) > 0){
                $arr['spt_category_name'] = $spt_catname->name;
            }

            $checkProduct = Bill::checkOld($id,$request->pname);
            if( empty($checkProduct) ){
                Bill::update($id,$arr);
                return redirect()->back()->with(['flash_message_succ' => 'Sửa thông tin thành công']);
            }else{
                return redirect()->back()->with(['flash_message_err' => 'Tên sản phẩm bị trùng lặp']);
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
        Bill::delBill($id);
        return redirect()->route('bill.index')->with(['flash_message_succ' => 'Xóa thành công']);
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
        
        $listBill = Bill::search($stxt);
        $data = array(
                'listBill'  => $listBill,
                'stxt'      => $stxt
            );

        return view('backend.bill.s_result', $data);
    }

    //CART BILL CREATE
    public function addcart_create(Request $request){
        $spt_id = $request->spt_id;

        //get product_stock info
        $product = Bill::getASpt($spt_id);
        if(!empty($product) && count($product) > 0){
            $cartInfo = Cart::instance('kho_hang')->content();
            $max = 0;
            if( count($cartInfo) > 0 ){                
                foreach($cartInfo as $opKey => $opVal){
                    if( $opVal->options['sort'] >= $max ){
                        $max = $opVal->options['sort'];
                    }
                }
            }
            $cart = array(
                'id'    => $spt_id,
                'name'  => $product->spt_name,
                'qty'   => 0.00001,
                'price' => 0,
                'options'   => [
                    'expiry'=> '',
                    'unit'  => $product->unit_name,
                    'sort'  => ((int)$max+1)
                ]
            );

            $cartInfo = Cart::instance('kho_hang')->content();
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
                Cart::instance('kho_hang')->add($cart);
                $statusReturn = true;    
            }
            
        }else{
            $statusReturn = false;
        }
        
        $dataResult = array(
            'status' => $statusReturn,                
        );
        echo (json_encode($dataResult));        
    }

    public function delitem_create(Request $request){

        $rowId = $request->rowId;
        Cart::instance('kho_hang')->remove($rowId);
        
        $dataResult = array(
                'status' => true,
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart_create(){
        $info = Cart::instance('kho_hang')->content();
        $sort = array();
        foreach($info as $inKey => $inVal){
            $sort[] = $inVal->options['sort'];
        }
        sort($sort);
        $dataResult = array(
                'content'   => $info,
                'count'     => count($info),
                'sort'      => $sort
            );
        echo (json_encode($dataResult));
    }

    public function search_create(Request $request)
    {        
        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        
        $listProduct = Bill::searchSpt($stxt, $category_id);
        $listCategory = Bill::listCategory();
        $listNsx = Bill::listNsx();

        $data = array(
                'products'  => $listProduct,
                'stxt'      => $stxt,
                'category_id' => $category_id,
                'category'  => $listCategory,
                'listNsx'   => $listNsx
            );
        $cat_name = Bill::getCategory($category_id);
        if( $cat_name != false ){
            $data['category_name'] = $cat_name->name;
        }else{
            $data['category_name'] = false;
        }
        //xử lý cart info để đồng bộ với dữ liệu nhập từ form
        $cartInfo = Cart::instance('kho_hang')->content();
        $cartInfo2 = array();
        foreach($cartInfo as $cartItem){
            $cartInfo2[] = $cartItem;
        }
        if($cartInfo != null && Cart::instance('kho_hang')->count() > 0){
            $data['content'] = $cartInfo2;
            $data['countStock'] = Cart::instance('kho_hang')->count();
        }else{
            $data['countStock'] = 0;
        }
        return view('backend.bill.s_create', $data);
    }

    public function savebill(Request $request){
        if(Cart::instance('kho_hang')->count() > 0){
            // tạo mới || lấy thông tin nhà sản xuất
            $date = new DateTime();

            if($request->productQuantity){
                $rules = [
                    'productQuantity.*' => ['regex:/^(\d+|\d+\.{1}\d+)$/'],
                    'productPrice.*'    => ['regex:/^(\d+|\d+\.{1}\d+)$/']
                ];
                $messages = [
                    'productQuantity.*.regex'   => 'Định dạng lượng sản phẩm không đúng!',
                    'productPrice.*.regex'      => 'Định dạng giá sản phẩm không đúng!'
                ];

                $validator = Validator::make($request->all(),$rules,$messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            if($request->nsxNew){
                $rules = [
                    'nsxEmail'  => 'email',
                    'nsxNew'    => 'unique:nha_san_xuat,nsx_name'
                ];
                $messages = [
                    'nsxEmail.email'    =>'Định dạng email chưa đúng!',
                    'nsxNew.unique'     =>'Nhà sản xuất này đã tồn tại!'
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $nsxInsert = array(
                            'nsx_name'      => $request->nsxNew,
                            'nsx_address'   => $request->nsxAddr,
                            'nsx_phone'     => $request->nsxPhone,
                            'nsx_email'     => $request->nsxEmail,
                            'nsx_create_time' => $date->format('Y-m-d H:i:s'),
                            'nsx_status'    => 1
                        );
                    $nsx_id = Bill::createNsx($nsxInsert);
                    $nsx_name = $request->nsxNew;
                }
            }else{
                $nsx_id = $request->nsxOld;
                if($nsx_id == 0){
                    return redirect()->route('bill.create')->with(['flash_message_err' => 'Bạn chưa chọn nhà sản xuất!'])->withInput();
                }else{
                    $nsx_name = Bill::getNameNsx($nsx_id);
                }                
            }

            // tạo hóa đơn mới
            if($request->billName){
                $rules = [
                    'billName'    => 'unique:hoa_don_nhap,hdn_code'
                ];
                $messages = [
                    'billName.unique'     =>'Tên hóa đơn bị trùng lặp!'
                ];  
                $validator = Validator::make($request->all(),$rules,$messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $billName = $request->billName;
                }
            }else{
                $billName = '';
            }

            $billInsert = array(
                'hdn_code'          => $billName,
                'hdn_create_time'   => $date->format('Y-m-d H:i:s'),
                'hdn_id_employee'   => Auth::user()->id,
                'hdn_name_employee' => Auth::user()->name,
                'hdn_nsx_id'        => $nsx_id,
                'hdn_nsx_name'      => $nsx_name,
                'hdn_status'        => 1
            );
            
            $hdn_id = Bill::createBill($billInsert);

            if($hdn_id){                
                $pStockInsert = array();
                $pSptUpdate_id = array();
                $pSptUpdate_quantity = array();

                $cartInfo = Cart::instance('kho_hang')->content();
                
                //xử lý cart info để đồng bộ với dữ liệu nhập từ form
                $cartInfo2 = array();
                foreach($cartInfo as $cartItem){
                    $cartInfo2[] = $cartItem;
                }
                $productQuantity = $request->productQuantity;
                $productPrice = $request->productPrice;
                $productExpiry = $request->productExpiry;
                for($i=0; $i<count($cartInfo); $i++){
                    $pStockInsert[] = array(
                        'hn_name'   => $cartInfo2[$i]->name,
                        'hn_spt_id' => $cartInfo2[$i]->id,
                        'hn_price'  => $productPrice[$i],
                        'hn_quantity' => $productQuantity[$i],
                        'hn_time_expiry' => $productExpiry[$i],
                        'hn_hdn_id' => $hdn_id,
                        'hn_status' => 1
                    );

                    $pSptUpdate_id[] = $cartInfo2[$i]->id;
                    $pSptUpdate_quantity[] = $productQuantity[$i];

                }

                if(Bill::createBillDetails($pStockInsert)){
                    if(Bill::updateSpt($pSptUpdate_id, $pSptUpdate_quantity)){
                        event(new OrderInputAdd($pStockInsert));
                        Cart::instance('kho_hang')->destroy();
                        return redirect()->route('bill.index')->with(['flash_message_succ' => 'Lưu trữ hóa đơn thành công!']);    
                    }else{
                        return redirect()->route('bill.create')->with(['flash_message_err' => 'Lưu trữ sản phẩm thô thất bại!'])->withInput();
                    }
                }else{
                    return redirect()->route('bill.create')->with(['flash_message_err' => 'Lưu trữ chi tiết hóa đơn thất bại!'])->withInput();
                }
            }else{
                return redirect()->route('bill.create')->with(['flash_message_err' => 'Đã có lỗi xảy ra vui lòng thử lại!'])->withInput();
            }

        }else{
            return redirect()->route('bill.create')->with(['flash_message_err' => 'Bạn chưa chọn sản phẩm nào!'])->withInput();
        }
    }
    //END -- CART BILL CREATE

    //CART BILL EDIT
    public function addcart(Request $request){
        $spt_id = $request->spt_id;
        $hdn_id = $request->hdn_id;

        $billInfo = Cart::instance('bill_'.$hdn_id)->content();        
        $max = 0;
        if( count($billInfo) > 0 ){                
            foreach($billInfo as $opKey => $opVal){
                if( $opVal->options['sort'] >= $max ){
                    $max = $opVal->options['sort'];
                }
            }
        }

        $checkItemBill = false;
        foreach($billInfo as $k => $v){
            if( $v->id == $spt_id){
                $checkItemBill = true; break;
            }
        }
        if( $checkItemBill ){
            $dataResult = array(
                'status' => 0,
            );
            die (json_encode($dataResult));
        }else{
            //get product_stock info
            $product = Bill::getASpt($spt_id);
            if(!empty($product) && count($product) > 0){
                $cart = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => 0.00001,
                    'price' => 0,
                    'options'=> [
                                'expiry'=> '0000-00-00',
                                'unit'  => $product->unit_name,
                                'sort'  => ((int)$max+1)
                            ]
                );            
                Cart::instance('bill_'.$hdn_id)->add($cart);
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
        $hdn_id = $request->hdn_id;
        $hn_id = $request->hn_id;

        /*if( (int)$hn_id > 0 ){
            Bill::delBillDetailsItem($hdn_id, $hn_id);            
        }*/
        Cart::instance('bill_'.$hdn_id)->remove($rowId);        
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart(Request $request){
        $hdn_id = $request->hdn_id;
        $info = Cart::instance('bill_'.$hdn_id)->content();
        $sort = array();
        foreach($info as $inKey => $inVal){
            $sort[] = $inVal->options['sort'];
        }
        sort($sort);
        $dataResult = array(
                'content'   => $info,
                'count'     => count($info),
                'sort'      => $sort
            );
        echo (json_encode($dataResult));
    }

    public function search_edit(Request $request)
    {        
        $stxt = $request->stxt;
        $category_id = $request->cat_id;
        $hdn_id = $request->hdn_id;
        
        $listProduct = Bill::searchSpt($stxt, $category_id);
        $listCategory = Bill::listCategory();
        $listNsx = Bill::listNsx();
        $details = Bill::details($hdn_id);

        $data = array(
                'products'  => $listProduct,
                'stxt'      => $stxt,
                'category_id' => $category_id,
                'category'  => $listCategory,
                'listNsx'   => $listNsx,
                'hdn_id'    => $hdn_id,
                'hdn_nsx_id'=> $details['hdn_nsx_id'],
                'hdn_code'  => $details['hdn_code'],
            );
        $cat_name = Bill::getCategory($category_id);
        if( $cat_name != false ){
            $data['category_name'] = $cat_name->name;
        }else{
            $data['category_name'] = false;
        }
        //xử lý cart info để đồng bộ với dữ liệu nhập từ form
        $cartInfo = Cart::instance('bill_'.$hdn_id)->content();
        $cartInfo2 = array();
        foreach($cartInfo as $cartItem){
            $cartInfo2[] = $cartItem;
        }
        if($cartInfo != null && Cart::instance('bill_'.$hdn_id)->count() > 0){
            $data['content'] = $cartInfo2;
        }
        return view('backend.bill.s_edit', $data);
    }

    public function updateBill(Request $request){
        $hdn_id = $request->hdn_id;
        if(Cart::instance('bill_'.$hdn_id)->content() != null && Cart::instance('bill_'.$hdn_id)->count() > 0){
            // tạo mới || lấy thông tin nhà sản xuất
            $date = new DateTime();
            if($request->productQuantity){
                $rules = [
                    'productQuantity.*' => ['regex:/^(\d+|\d+\.{1}\d+)$/'],
                    'productPrice.*'    => ['regex:/^(\d+|\d+\.{1}\d+)$/']
                ];
                $messages = [
                    'productQuantity.*.regex'   => 'Định dạng lượng sản phẩm không đúng!',
                    'productPrice.*.regex'      => 'Định dạng giá sản phẩm không đúng!'
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            
            if($request->nsxNew){
                $rules = [
                    'nsxEmail'  => 'email',
                    'nsxNew'    => 'unique:nha_san_xuat,nsx_name'
                ];
                $messages = [
                    'nsxEmail.email'    =>'Định dạng email chưa đúng!',
                    'nsxNew.unique'     =>'Nhà sản xuất này đã tồn tại!'
                ];
                $validator = Validator::make($request->all(),$rules,$messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $nsxInsert = array(
                            'nsx_name'      => $request->nsxNew,
                            'nsx_address'   => $request->nsxAddr,
                            'nsx_phone'     => $request->nsxPhone,
                            'nsx_email'     => $request->nsxEmail,
                            'nsx_create_time' => $date->format('Y-m-d H:i:s'),
                            'nsx_status'    => 1
                        );
                    $nsx_id = Bill::createNsx($nsxInsert);
                    $nsx_name = $request->nsxNew;
                }
            }else{
                $nsx_id = $request->nsxOld;
                if($nsx_id == 0){
                    return redirect()->route('bill.edit', ['id' => $hdn_id])->with(['flash_message_err3' => 'Bạn chưa chọn nhà sản xuất!'])->withInput();
                }else{
                    $nsx_name = Bill::getNameNsx($nsx_id);
                }                
            }

            // update thông tin hóa đơn
            $billInsert = array(
                'hdn_code'          => $request->billName,
                'hdn_update_time'   => $date->format('Y-m-d H:i:s'),
                'hdn_id_employee'   => Auth::user()->id,
                'hdn_name_employee' => Auth::user()->name,
                'hdn_nsx_id'        => $nsx_id,
                'hdn_nsx_name'      => $nsx_name,
            );

            $update_bill = Bill::update($hdn_id, $billInsert);            
            //delete old details
            Bill::delBillDetails($hdn_id);

            //add new details
            $pStockInsert = array();
            $pSptUpdate_id = array();
            $pSptUpdate_quantity = array();

            $cartInfo = Cart::instance('bill_'.$hdn_id)->content();
            //xử lý cart info để đồng bộ với dữ liệu nhập từ form
            $cartInfo2 = array();
            foreach($cartInfo as $cartItem){
                $cartInfo2[] = $cartItem;
            }
            $productQuantity = $request->productQuantity;
            $productPrice = $request->productPrice;
            $productExpiry = $request->productExpiry;
            for($i=0; $i<count($cartInfo); $i++){
                $pStockInsert[] = array(
                    'hn_name'   => $cartInfo2[$i]->name,
                    'hn_spt_id' => $cartInfo2[$i]->id,
                    'hn_price'  => $productPrice[$i],
                    'hn_quantity' => $productQuantity[$i],
                    'hn_time_expiry' => $productExpiry[$i],
                    'hn_hdn_id' => $hdn_id,
                    'hn_status' => 1
                );

                $pSptUpdate_id[] = $cartInfo2[$i]->id;
                $pSptUpdate_quantity[] = $productQuantity[$i];
            }

            if(Bill::createBillDetails($pStockInsert)){
                if(Bill::updateSptUp($pSptUpdate_id, $pSptUpdate_quantity)){
                    event(new OrderInputEdit($pStockInsert));
                    Cart::instance('bill_'.$hdn_id)->destroy();
                    //return redirect()->route('bill.edit', ['id' => $hdn_id])->with(['flash_message_succ2' => 'Chỉnh sửa hóa đơn thành công!']);
                    return redirect()->route('bill.index')->with(['flash_message_succ' => 'Chỉnh sửa hóa đơn thành công!']); 
                }else{
                    return redirect()->route('bill.edit', ['id' => $hdn_id])->with(['flash_message_err3' => 'Lưu trữ sản phẩm thô thất bại!'])->withInput();
                }
            }else{
                return redirect()->route('bill.edit', ['id' => $hdn_id])->with(['flash_message_err3' => 'Lưu trữ chi tiết hóa đơn thất bại!'])->withInput();
            }

        }else{
            return redirect()->route('bill.edit', ['id' => $hdn_id])->with(['flash_message_err3' => 'Bạn chưa chọn sản phẩm nào!'])->withInput();
        }
    }
    //END CART BILL EDIT

    public function getProduct(Request $request){
        $pid = $request->pid;
        $products = Bill::listProduct($request);
        $xhtm = "";
        foreach($products as $product) {
            $xhtm .= "<tr> 
                <td class='text-center'><img src='". asset('uploads/product_stock/'.$product->spt_image) ."' width='80%' max-height='80px' alt=''></td>
                <td>".$product->spt_name ."</td>
                <td>". round($product->spt_quantity,4) . "(" .  $product->unit_name .")</td>
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
           
            $xhtm .= "<a class='btn btn-success btn-xs' onclick='add_cart_stock(".$product->spt_id.");'><i class='fa fa-plus'></i> Thêm hàng</a></td></tr>";
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
        $hdn_id = $request->id;
        $products = Bill::listProduct($request);
        $xhtm = "";
        foreach($products as $product) {
            $xhtm .= "<tr> 
                <td class='text-center'><img src='". asset('uploads/product_stock/'.$product->spt_image) ."' width='80%' max-height='80px' alt=''></td>
                <td>".$product->spt_name ."</td>
                <td>". round($product->spt_quantity,4) . "(" .  $product->unit_name .")</td>
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
           
            $xhtm .= "<a class='btn btn-success btn-xs' onclick='add_cart_edit_bill(".$product->spt_id.",".$hdn_id.");'><i class='fa fa-plus'></i> Thêm hàng</a></td></tr>";
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

    public function update_qty(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;
        $hdn_id = $request->hdn_id;

        if( $hdn_id == 0 ){
            $cartContent = Cart::instance('kho_hang')->content();            
            Cart::instance('kho_hang')->update($rowid, ['qty' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $cartContent["$rowid"]->options['expiry'],
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }else{
            $cartContent = Cart::instance('bill_'.$hdn_id)->content();            
            Cart::instance('bill_'.$hdn_id)->update($rowid, ['qty' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $cartContent["$rowid"]->options['expiry'],
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }
    }

    public function update_price(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;        
        $hdn_id = $request->hdn_id;
        
        if( $hdn_id == 0 ){
            $cartContent = Cart::instance('kho_hang')->content();            
            Cart::instance('kho_hang')->update($rowid, ['price' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $cartContent["$rowid"]->options['expiry'],
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }else{
            $cartContent = Cart::instance('bill_'.$hdn_id)->content();            
            Cart::instance('bill_'.$hdn_id)->update($rowid, ['price' => $val, 'options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $cartContent["$rowid"]->options['expiry'],
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }
    }

    public function update_expiry(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;
        $hdn_id = $request->hdn_id;

        if( $hdn_id == 0 ){
            $cartContent = Cart::instance('kho_hang')->content();            
            Cart::instance('kho_hang')->update($rowid, ['options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $val,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }else{
            $cartContent = Cart::instance('bill_'.$hdn_id)->content();            
            Cart::instance('bill_'.$hdn_id)->update($rowid, ['options' => [
                    'unit'   => $cartContent["$rowid"]->options['unit'],
                    'expiry' => $val,
                    'sort'   => $cartContent["$rowid"]->options['sort']
                ]]);
        }
    }
}