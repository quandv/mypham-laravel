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
        
        //$cartInfo = Cart::instance('kho_hang')->content();
      /*  $cartInfo = Session::get('kho_hang');

        if(count(Session::get('kho_hang')) > 0){            
            $data['countStock'] = count(Session::get('kho_hang'));
        }else{
            $data['countStock'] = 0;
        }*/
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
        
        Session::forget('bill_'.$id); 
        foreach( $details['billDetails'] as $key => $item){
            $addCartInfo[$item->hn_spt_id] = array(
                    'id'    => $item->hn_spt_id,
                    'name'  => $item->hn_name,
                    'qty'   => $item->hn_quantity,
                    'price' => $item->hn_price,
                    'expiry'=> $item->hn_time_expiry,
                    'unit'  => $item->hn_unit,
            );  
        }
        Session::put('bill_'.$id,$addCartInfo);
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
        $stxt = trim($request->stxt);
        $day = $request->day != '' ? DateTime::createFromFormat('d-m-Y', $request->day)->format('Y-m-d') : $request->day;

        $listBill = Bill::search($stxt,$day);
        foreach($listBill as $key => $val){
            $listBill[$key]->hn_name_group = explode(',', $val->hn_name_group);
            $listBill[$key]->hn_price_group = explode(',', $val->hn_price_group);
            $listBill[$key]->hn_quantity_group = explode(',', $val->hn_quantity_group);
            $listBill[$key]->unit_name_group = explode(',', $val->unit_name_group);
        }
        $data = array(
                'listBill'  => $listBill,
                'stxt'      => $stxt,
                'day'       => $request->day
            );

        return view('backend.bill.s_result', $data);
    }

    //CART BILL CREATE
    public function addcart_create(Request $request){
        $spt_id = $request->spt_id;
        //get product_stock info
        $product = Bill::getASpt($spt_id);
        if(!empty($product) && count($product) > 0){
            $cartInfo = Session::get('kho_hang'); 
            $quantity = 0;
            if (!isset($cartInfo[$spt_id])) { 
                $cartInfo[$spt_id] = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => $quantity,
                    'price' => 0,
                    'expiry'=> '',
                    'unit'  => $product->unit_name, 
                );
                $this->update_cart('kho_hang',$cartInfo);
            }else{
                $cartInfo[$spt_id]['qty'] = $cartInfo[$spt_id]['qty'] + 1;
                $this->update_cart('kho_hang',$cartInfo); 
            }
            //session()->flush(); 
            $statusReturn = true;    
        }else{
            $statusReturn = false;
        }
        
        $dataResult = array(
            'status' => $statusReturn,                
        );
        //echo (json_encode( $cartInfo  ))
       echo (json_encode($dataResult));
       
          
    }

    public function delitem_create(Request $request){

        $rowId = $request->rowId;
        $cartInfo =  Session::get('kho_hang');
        unset($cartInfo[$rowId]);
        $this->update_cart('kho_hang',$cartInfo);  
        $dataResult = array(
                'status' => true,
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart_create(){
        $info = Session::get('kho_hang');
        echo (json_encode($info));
    }

    public function savebill(Request $request){
        if(count(Session::get('kho_hang')) > 0){
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

                $cartInfo = Session::get('kho_hang');
                /*echo "<pre>";
                print_r($cartInfo);
                echo "</pre>";
                die();*/
                
                foreach ($cartInfo as $k => $val) {
                    $pStockInsert[] = array(
                        'hn_name'   => $val['name'],
                        'hn_spt_id' => $val['id'],
                        'hn_price'  => $val['price'],
                        'hn_quantity' => $val['qty'],
                        'hn_time_expiry' => $val['expiry'],
                        'hn_hdn_id' => $hdn_id,
                        'hn_status' => 1,
                        'hn_unit'   => $val['unit']
                    );

                    $pSptUpdate_id[] = $k;
                    $pSptUpdate_quantity[] = $val['qty'];
                }
                /*//xử lý cart info để đồng bộ với dữ liệu nhập từ form
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

                }*/

                if(Bill::createBillDetails($pStockInsert)){
                    if(Bill::updateSpt($pSptUpdate_id, $pSptUpdate_quantity)){
                        event(new OrderInputAdd($pStockInsert));
                        Session::forget('kho_hang');
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

        $product = Bill::getASpt($spt_id);
        if(!empty($product) && count($product) > 0){
            $cartInfo = Session::get('bill_'.$hdn_id); 
            $quantity = 0;
            if (!isset($cartInfo[$spt_id])) { 
                $cartInfo[$spt_id] = array(
                    'id'    => $spt_id,
                    'name'  => $product->spt_name,
                    'qty'   => $quantity,
                    'price' => 0,
                    'expiry'=> '',
                    'unit'  => $product->unit_name, 
                );
                $this->update_cart('bill_'.$hdn_id,$cartInfo);
            }else{
                $cartInfo[$spt_id]['qty'] = $cartInfo[$spt_id]['qty'] + 1;
                $this->update_cart('bill_'.$hdn_id,$cartInfo); 
            }
            //session()->flush(); 
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
        
        $rowId = $request->rowId;
        $hdn_id = $request->hdn_id;
        $hn_id = $request->hn_id;

        /*if( (int)$hn_id > 0 ){
            Bill::delBillDetailsItem($hdn_id, $hn_id);            
        }*/
        $cartInfo = Session::get('bill_'.$hdn_id); 
        unset($cartInfo[$rowId]);
        $this->update_cart('bill_'.$hdn_id,$cartInfo);
        $dataResult = array(
                'status' => true,                
            );
        echo (json_encode($dataResult));
    }

    public function refresh_cart(Request $request){
        $hdn_id = $request->hdn_id;
        $info = Session::get('bill_'.$hdn_id);
        $dataResult = array(
            'content'   => $info,
            'count'     => count($info),
        );
        echo (json_encode($dataResult));
    }

    public function updateBill(Request $request){
        $hdn_id = $request->hdn_id;
        if(Session::get('bill_'.$hdn_id) != null && count(Session::get('bill_'.$hdn_id)) > 0){
         
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

            $cartInfo = Session::get('bill_'.$hdn_id);

            foreach ($cartInfo as $k => $val) {
                $pStockInsert[] = array(
                    'hn_name'   => $val['name'],
                    'hn_spt_id' => $val['id'],
                    'hn_price'  => $val['price'],
                    'hn_quantity' => $val['qty'],
                    'hn_time_expiry' => $val['expiry'],
                    'hn_hdn_id' => $hdn_id,
                    'hn_status' => 1,
                    'hn_unit' => $val['unit']
                );

                $pSptUpdate_id[] = $k;
                $pSptUpdate_quantity[] = $val['qty'];
            }
        /*   echo "<pre>";
           print_r($cartInfo);
           echo "</pre>";*/
            if(Bill::createBillDetails($pStockInsert)){
                if(Bill::updateSptUp($pSptUpdate_id, $pSptUpdate_quantity)){
                    event(new OrderInputEdit($pStockInsert));
                    Session::forget('bill_'.$hdn_id);
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
            $cartContent = Session::get('kho_hang');  
            $cartContent[$rowid]['qty'] = $val;
            $this->update_cart('kho_hang',$cartContent);
        }else{
            $cartContent = Session::get('bill_'.$hdn_id);  
            $cartContent[$rowid]['qty'] = $val;          
            $this->update_cart('bill_'.$hdn_id,$cartContent);       
        }
    }

    public function update_price(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;        
        $hdn_id = $request->hdn_id;
        
        if( $hdn_id == 0 ){
            $cartContent = Session::get('kho_hang');  
            $cartContent[$rowid]['price'] = $val;
            $this->update_cart('kho_hang',$cartContent);   
        }else{  
            $cartContent = Session::get('bill_'.$hdn_id);  
            $cartContent[$rowid]['price'] = $val;          
            $this->update_cart('bill_'.$hdn_id,$cartContent);   
        }
    }

    public function update_expiry(Request $request){
        $rowid = $request->rowid;
        $val = $request->val;
        $hdn_id = $request->hdn_id;

        if( $hdn_id == 0 ){
            $cartContent = Session::get('kho_hang');  
            $cartContent[$rowid]['expiry'] = $val;
            $this->update_cart('kho_hang',$cartContent);   
        }else{          
            $cartContent = Session::get('bill_'.$hdn_id);  
            $cartContent[$rowid]['expiry'] = $val;          
            $this->update_cart('bill_'.$hdn_id,$cartContent);   
        }
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

    //STATISTIC
    //statistic for month
    public function statisticMonth(Request $request){
        if($request->month && $request->year && $request->month != 0 && $request->year != 0){
            $year = $request->year;
            $month = $request->month;
        }else{
            $year = date('Y');
            $month = date('m');
        }
        $listBill = Bill::statisticMonth($month,$year);
        $data = array(
                'listBill'  => $listBill,
                'year'      => $year,
                'month'     => $month
            );
        
        return view('backend.bill.statistic_month', $data);
    }

    //statistic for year
    public function statisticYear(Request $request){
        if($request->year && $request->year != 0){
            $year = $request->year;
        }else{
            $year = date('Y');            
        }
        $listBill = Bill::statisticYear($year);
        $data = array(
                'listBill'  => $listBill,
                'year'      => $year
            );
        
        return view('backend.bill.statistic_year', $data);
    }



}