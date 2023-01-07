<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\Access\User;
use App\Events\UserChatPrivate;
use DB;

class ChatController extends Controller
{
    //
    public function index(){

    	//$users = User::all();
        return view('chat/index');//,compact("users"));
    }

    public function roomChat(Request $request){
    	/*Redis::set('name','KKK');
	    return Redis::get('name');*/
	    // 1. Publish event with Redis
	    $client_ip = $request->input('ip');
	    $client = DB::table('client')
	        ->join('room', 'room.room_id', '=', 'client.room_id')
	        ->where('client_ip','=', $client_ip)
	        ->select('client_id','client_ip', 'client_name', 'room.room_name', 'room.room_id')
	        ->first();
	    $data = [
	      'event'=>'room',
	      'info'=>[
	        'id' => $client->client_id,
	        'ip' => $client->client_ip,
	        'room' => $client->room_name,
	        'avatar' =>asset('/images/1.jpg'),
	        'name' =>$client->client_name,
	        'created'=>date('d-m-Y h:i:s'),
	        'message'=> $request->input('message'),
	      ]
	    ];
	    //event(new UserChatPrivate('lllll'));
	    Redis::publish('room-channel',json_encode($data));
	    //return "DONE";
	    // 2. Node.js + Redis subscribes to the event
	    // 3. Use socket.io to emit to all clients
    }
    public function privateChat(Request $request){
    	/*Redis::set('name','KKK');
	    return Redis::get('name');*/
	    // 1. Publish event with Redis
	    //Thông tin người gửi
	    $info_sent = json_decode($request->info_sent);
	    if ($request->ajax()) {
	    	if (!empty($request->info) && !empty($request->info_sent)) {
	    		$data = [
			      'event'=>'private',
			      'info'=>[
			        'id' => $request->info['id'],
			        'ip' => $request->info['ip'],
			        'room' => $request->info['room'],
			        'avatar' => asset('/images/1.jpg'),
			        'name' =>$request->info['name'],
			        'created'=>date('d-m-Y h:i:s'),
			        'message'=> $request->info['message'],
			      ],
			      'info_sent'=> [
			      	'id' => $info_sent->id,
			        'ip' => $info_sent->ip,
			        'room' => $info_sent->room,
			        'avatar' =>asset('/images/1.jpg'),
			        'name' =>$info_sent->name,
			        /*'created'=>date('d-m-Y h:i:s'),
			        'message'=> $request->input('message'),*/
			      ]
		    	];
			    Redis::publish('private-channel',json_encode($data));
	    	} 
	    }else{
	    	return 'You can not permition';
	    }

	    //return "DONE";
	    // 2. Node.js + Redis subscribes to the event

	    // 3. Use socket.io to emit to all clients
    }
    public function userOnline(Request $request){
    	if ($request->ajax()) {
    		if (!empty($request->listip)) {
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
    			$listip = array_unique($request->listip);
    		    $users = DB::table('client')
		        ->join('room', 'room.room_id', '=', 'client.room_id')
		        ->whereIn('client_ip',$listip)
		        ->whereIn('room.room_id', $IDreturnArr)
		        ->select('client_id','client_ip', 'client_name', 'room.room_name', 'room.room_id')
		        ->get();
		        return $users;
    		}			
    	}else{
    		return 'You can not permition';
    	}

    }
}
