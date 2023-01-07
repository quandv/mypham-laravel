<?php

namespace App\Models\Backend;

use DB;

class Room
{
    public static function insert($arr){
    	DB::table('room')->insert($arr);
    }

    public static function update($id, $arr){
    	DB::table('room')
		->where('room_id', $id)
    	->update($arr);
    }

    public static function listRoom(){
		return DB::table('room')
		->orderBy('room_id', 'asc')
		->paginate(20);
    }

    public static function details($id){
    	return DB::table('room')		
		->where('room_id', $id)
		->first();
    }

    public static function delRoom($id){
        DB::table('client')->where('room_id', $id)->delete();
        DB::table('room')->where('room_id', $id)->delete();
    }

    public static function searchRoom($stxt){
		return DB::table('room')
		->where('room.room_name', 'like', "%".$stxt."%")
        ->orWhere('room.room_ip', 'like', "%".$stxt."%")
		->orderBy('room_id', 'asc')
		->paginate(20);
    }
}
