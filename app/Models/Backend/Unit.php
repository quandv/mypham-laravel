<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Unit
{
    public static function insert($arr){
        DB::table('don_vi')->insert($arr);
    }

    public static function update($id, $arr){
        DB::table('don_vi')
        ->where('dv_id', $id)
        ->update($arr);

        $dm_spt = DB::table('danh_muc_spt')->where('unit_id', $id)->first();
        if(!empty($dm_spt) && count($dm_spt) > 0){
            DB::table('danh_muc_spt')
            ->where('unit_id', $id)
            ->update(['unit_id' => $id, 'unit_name' => $arr['dv_name']]);
        }
    }

    public static function listUnit(){
        return DB::table('don_vi')
        ->orderBy('dv_id', 'asc')
        ->paginate(20);
    }

    public static function details($id){
        $unit = DB::table('don_vi')
        ->where('dv_id', $id)
        ->first();
        return $unit;
    }

    public static function delete($id){
        return DB::table('don_vi')->where('dv_id', $id)->delete();
    }

    public static function searchunit($stxt){
        return DB::table('don_vi')
        ->where('dv_name', 'like', "%".$stxt."%")        
        ->orderBy('dv_id', 'asc')
        ->paginate(10);
    }
}
