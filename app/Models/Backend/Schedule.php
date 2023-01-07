<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Schedule
{
    public static function insert($arr){
    	DB::table('scheduletime')->insert($arr);
    }

    public static function update($id, $arr){
    	DB::table('scheduletime')
		->where('id', $id)
    	->update($arr);
    }


    public static function listSchedule(){
		return DB::table('scheduletime')->get();
    }

    public static function details($id){
    	$schedule = DB::table('scheduletime')		
		->where('id', $id)
		->first();
		if( !empty($schedule) ){
			return $schedule;
		}else{
			return false;
		}
    }

    public static function delSchedule($id){
    	DB::table('scheduletime')->where('id', $id)->delete();
    }

    public static function searchclient($stxt){
		return DB::table('scheduletime')
		->join('room', 'client.room_id', '=', 'room.room_id')
		->select('client.*', 'room.room_name as room_name')
		->where('client.client_name', 'like', "%".$stxt."%")
        ->orWhere('client.client_ip', 'like', "%".$stxt."%")
		->orderBy('client_id', 'desc')
		->paginate(2);
    }
}
