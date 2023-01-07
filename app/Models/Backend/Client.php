<?php
namespace App\Models\Backend;

use DB;
use PDO;

class Client
{
    public static function insert($arr){
    	DB::table('client')->insert($arr);
    }

    public static function update($id, $arr){
    	DB::table('client')
		->where('client_id', $id)
    	->update($arr);
    }

    public static function listClient(){
		return DB::table('client')
		->join('room', 'client.room_id', '=', 'room.room_id')
		->select('client.*', 'room.room_name as room_name')
		->orderBy('client_id', 'desc')
		->paginate(20);
    }

    public static function listRoom(){
    	return DB::table('room')
		->select('room_id', 'room_name')
		->get();
    }

    public static function details($id){
    	$client = DB::table('client')		
		->where('client_id', $id)
		->first();
		if( !empty($client) ){
			return $client;
		}else{
			return false;
		}
    }

    public static function delClient($id){
    	DB::table('client')->where('client_id', $id)->delete();
    }

    public static function searchclient($stxt){
		return DB::table('client')
		->join('room', 'client.room_id', '=', 'room.room_id')
		->select('client.*', 'room.room_name as room_name')
		->where('client.client_name', 'like', "%".$stxt."%")
        ->orWhere('client.client_ip', 'like', "%".$stxt."%")
		->orderBy('client_id', 'desc')
		->paginate(10);
    }
    
}