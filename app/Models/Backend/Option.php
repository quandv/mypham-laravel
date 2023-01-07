<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Option
{
    //
    public static function insert($arr){
    	DB::table('listoption')->insert($arr);
    }

    public static function update($id, $arr){
    	DB::table('listoption')
		->where('id', $id)
    	->update($arr);
    }


    public static function listOption(){
		return DB::table('listoption')
		->orderBy('id', 'desc')
		->paginate(10);
    }

    public static function details($id){
    	$listoption = DB::table('listoption')		
		->where('id', $id)
		->first();
		if( !empty($listoption) ){
			return $listoption;
		}else{
			return false;
		}
    }

    public static function delOption($id){
        $ctm = DB::table('listoption')->select('ctm_id')->where('id', $id)->first();
        if( $ctm->ctm_id != 0){
            DB::table('cong_thuc_mon')->where('ctm_id', $ctm->ctm_id)->delete();    
        }
        DB::table('option')->where('option_id', $id)->delete();
    	DB::table('listoption')->where('id', $id)->delete();
    }

    public static function searchOption($stxt){
		return DB::table('listoption')
		->where('listoption.name', 'like', "%".$stxt."%")
		->orderBy('id', 'desc')
		->paginate(20);
    }

    public static function updateStatus($listId, $status){
        return DB::table('listoption')
        ->whereIn('id', $listId)
        ->update(['status' => $status]);
    }
}
