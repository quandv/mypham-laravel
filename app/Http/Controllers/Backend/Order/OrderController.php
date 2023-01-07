<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use Auth;
use App\Events\Backend\Order\OrderStatusEvent;
use App\Events\Backend\Order\OrderApproved;
use App\Events\Backend\Order\OrderDone;
use App\Events\Backend\Order\OrderDestroy;
use App\Events\Backend\Order\OrderPending;
use Event;
use PDF;
use DB;
use App;
use Response;
use SPDF;

class OrderController extends Controller
{
    //
    public function getListOrderAll(Request $request){
    	return view('backend.order.index');
    }
    public function getListPending(Request $request){
        return view('backend.order.pending');
    }
    public function getListDone(Request $request){
        return view('backend.order.done');
    }

    public function getListDestroy(Request $request){
        return view('backend.order.destroy');
    }

    public function getListApproved(Request $request){
    	return view('backend.order.approved');
    }
    
    public function ajaxStatus(Request $request){
    	if ($request->ajax()) {
            $info = array(
                'order_id'=>$request->input('order_id'),
                'order_status'=>$request->input('order_status'),
                'order_date'  =>$request->input('order_time'),
                'room_id'  =>$request->input('room_id'),
                'back_stock' => $request->input('back_stock'),
                'order_chef_do' => $request->input('order_chef_do')
            );
            if ($request->input('order_status') == 1) {
                event(new OrderApproved("Vừa thu tiền một đơn hàng", $request->input('order_chef_do')));
            }
            if ($request->input('order_status') == 2) {
                event(new OrderDone("Vừa hoàn thành một đơn hàng"));
            }
            if ($request->input('order_status') == 3) {
                event(new OrderDestroy("Vừa hủy một đơn hàng"));
            }
            if ($request->input('order_status') == 4 || $request->input('order_status') == 5) {
                event(new OrderPending("Vừa chuyển một đơn hàng sang pending"));
            }
            /*if( $request->input('order_chef_do') == 0 && access()->hasPermission('chef-do')){

            }else{*/
                Event::fire(new OrderStatusEvent(Auth::user(),$info));
            //}
            
    		$result = Order::ajaxStatus($request->input('order_id'),$request->input('order_status'),$request->input('order_time'),$request->input('room_id'));
    		echo json_encode($result);
    	}else{
    		//return 'You can not permitsion';
    	}
    }

    public function ajaxStatus2Approved(Request $request){
        if ($request->ajax()) {
            $info = array(
                'order_id'=>$request->input('order_id'),
                'order_status'=>$request->input('order_status'),
                'order_date'  =>$request->input('order_time'),
                'room_id'  =>$request->input('room_id'),
                'back_stock' => $request->input('back_stock'),
                'order_chef_do' => $request->input('order_chef_do')
            );
            event(new OrderApproved("Vừa thu tiền một đơn hàng", $request->input('order_chef_do')));
            Event::fire(new OrderStatusEvent(Auth::user(),$info));
            $result = Order::ajaxStatus2Approved($request->input('order_id'),$request->input('order_status'),$request->input('order_time'),$request->input('room_id'));
            echo json_encode($result);
        }else{
            //return 'You can not permitsion';
        }
    }

    public function ajaxStatusTwo(Request $request){
        if ($request->ajax()) {
            if (empty($request->message)) {
               $info = array(
                    'order_id' =>$request->arr,
                    'order_status' =>$request->status,
                    'arr_status' => $request->arr_status,
                    'arr_date' => $request->arr_date,
                    'arr_room' => $request->arr_room,
                    //'order_chef_do' => $request->order_chef_do
                );

            }else{
                $info = array(
                    'order_id' =>$request->arr,
                    'order_status' =>$request->status,
                    'arr_status' => $request->arr_status,
                    'arr_date' => $request->arr_date,
                    'arr_room' => $request->arr_room,
                    'message_destroy' => $request->message,
                    'back_stock' => $request->back_stock,
                    //'order_chef_do' => $request->order_chef_do
                );
            }
            if ($request->status == 1) {
                event(new OrderPending("Vừa thay đổi trạng thái đơn hàng sang pending"));
            }
            if ($request->status == 2) {
                if(isset($request->chef_do)){
                    event(new OrderApproved("Vừa thu tiền đơn hàng",$request->chef_do));
                }else{
                    event(new OrderApproved("Vừa thu tiền đơn hàng"));
                }
                
            }
            if ($request->status == 3) {
                event(new OrderDone("Vừa hoàn thành đơn hàng"));
            }
            if ($request->status == 4) {
                event(new OrderDestroy("Vừa hủy đơn hàng"));
            }
            
            $result = Order::ajaxStatusTwo($request->arr,$request->status,$info);
            echo json_encode($result);
        }
        
    }
    public function ajaxStatusMessage(Request $request){
        if ($request->ajax()) {
            $result = Order::ajaxStatusMessage($request->order_id,$request->status,$request->message,$request->back_stock);            
            echo $result;
        }

    }
    public function getAjaxList(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrder($request);
            return json_encode($data);  
        }else{
            return 'You dont have permission!';
        } 
    }
    /**/
    //Order for client + employee
    public function getAjaxListApproved(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderApproved($request);
            return json_encode($data);
        }else{
            return 'You dont have permission!';
        }
    }
    //Order for client
    public function getAjaxListApproved1(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderApproved1($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //Order for employee
    public function getAjaxListApproved2(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderApproved2($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //END -- Order for employee
    public function getAjaxListPending(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderPending($request);
            return json_encode($data);
        }else{
            return 'You dont have permission!';
        }
    }
    public function getAjaxListPending1(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderPending1($request);
            return json_encode($data);
        }else{
            return 'You dont have permission!';
        }
    }
    public function getAjaxListPending2(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderPending2($request);
            return json_encode($data);
        }else{
            return 'You dont have permission!';
        }
    }

    public function getAjaxListDone(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDone($request);
            return json_encode($data); 
        }else{
            return 'You dont have permission!';
        }  
    }
    //Order for client
    public function getAjaxListDone1(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDone1($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //Order for employee
    public function getAjaxListDone2(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDone2($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //END -- Order for employee
    public function getAjaxListDestroy(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDestroy($request);
            return json_encode($data);
        }else{
            return 'You dont have permission!';
        }
    }
    //Order for client
    public function getAjaxListDestroy1(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDestroy1($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //Order for employee
    public function getAjaxListDestroy2(Request $request){
        if ($request->ajax()) {
            $data = Order::listOrderDestroy2($request);
            return json_encode($data);
        }else{
            return 'You can not permitsion';
        }
    }
    //END -- Order for employee

    public function pdfview(Request $request){
        $data = Order::listOrder($request);
        if($request->has('download')){
            $pdf = PDF::loadView('demo',['data'=>$data])->setPaper('a4', 'landscape');
            return $pdf->download('order.pdf');
        }
        //return view('demo',['data'=>$data]);
    }
    
    public function getPrint($room_id,$order_id){
       /* $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();*/
        $data = Order::printOrder($room_id,$order_id);
        //$customPaper = array(0,0,73.70,104.88); // a10 ; array(0,0, 12 * 72, 12 * 72) //12" X 12"
        //$pdf = PDF::loadView('backend.order.print',['data'=> $data]);//->setPaper(array(0,0,87.87,124.72), 'landscape');
        //$pdf = PDF::loadView('backend.order.print2',['data'=> $data])->setPaper('a10', 'portrait');
        //return $pdf->stream();
       // return $pdf->download('invoice.pdf');  
        //return view('backend.order.print',['data'=> $data]);
        //Using orther pdf
        $pdf = SPDF::loadView('backend.order.print',['data'=> $data])->setOption('margin-left','1')->setOption('margin-right','1')->setOption('page-width', '57')->setOption('page-height', '139.7')->setOption('zoom','0.78125');//->setOption('page-size','C5E');
        //->setOption('page-width', '100.9')->setOption('page-height', '139.7')
        return $pdf->inline('invoice.pdf');
    }

}
