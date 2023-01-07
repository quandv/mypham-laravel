<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Category_stock
{
    //
    public static function insert($arr){
        DB::table('danh_muc_spt')->insert($arr);
    }

    public static function update($id, $arr){
        DB::table('danh_muc_spt')
        ->where('id', $id)
        ->update($arr);
    }

    public static function delete($id){
        return DB::table('danh_muc_spt')->where('id', $id)->delete();
    }

    public static function listItem(){
        return DB::table('danh_muc_spt')
        ->orderBy('id', 'asc')
        ->paginate(20);
    }

    public static function details($id){
        $details = DB::table('danh_muc_spt')
        ->where('id', $id)
        ->first();
        return $details;
    }

    public static function search($stxt){
        return DB::table('danh_muc_spt')
        ->where('name', 'like', "%".$stxt."%")
        ->orWhere('id', 'like', "%".$stxt."%")
        ->orderBy('id', 'desc')
        ->paginate(10);
    }

    public static function checkNew($name){
        return DB::table('danh_muc_spt')
        ->where([
            ['name', '=', $name]
        ])
        ->first();
    }

    public static function checkOld($id, $name){
        return DB::table('danh_muc_spt')
        ->where([
            ['name', '=', $name],
            ['id', '<>', $id],
        ])
        ->first();
    }

    public static function listUnit(){
        return DB::table('don_vi')
        ->orderBy('dv_id', 'asc')
        ->get();
    }
    public static function detailsUnit($id){
        $details = DB::table('don_vi')
        ->where('dv_id', $id)
        ->first();
        return $details;
    }

    public static function del_more($listId){
        return DB::table('danh_muc_spt')->whereIn('id', $listId)->delete();
    }

    public static function list_dm_spt(){
        return DB::table('danh_muc_spt')
        ->orderBy('id', 'asc')
        ->get();
    }

    //process del one category stock
    public static function check_stock_depend($id){
        return DB::table('san_pham_tho')
        ->select('spt_id', 'spt_name', 'spt_image')
        ->where('spt_category_id', $id)
        ->get();
    }

    public static function update_stock_depend($idArr, $id_new){
        //category stock info
        $catStockUpdate = DB::table('danh_muc_spt')->where('id', $id_new)->first();        
        $dataUpdate = array(
                'spt_category_id' => $catStockUpdate->id,
                'spt_category_name' => $catStockUpdate->name
            );
        //update list stock for cat stock new
        return DB::table('san_pham_tho')        
        ->whereIn('spt_id', $idArr)
        ->update($dataUpdate);        
    }
    //process del one category stock

    //process del more category stock
    public static function check_stock_more_depend($idDelArr){

        $data =  DB::table('san_pham_tho')
        ->select('spt_id', 'spt_name', 'spt_image', 'spt_category_id', 'spt_category_name')
        ->whereIn('spt_category_id', $idDelArr)
        ->get();

        $result = array();
        $countAllSpt = DB::table('danh_muc_spt')->count();
        
        if(count($idDelArr) < $countAllSpt){
            $result['status'] = true;
            $result['data'] = $data;
        }else{
            $result['status'] = false;
            $result['data'] = $data;
        }
        return $result;
    }

    public static function update_stock_more_depend($idArr, $id_new){
        //category stock info
        $catStockUpdate = DB::table('danh_muc_spt')->where('id', $id_new)->first();
        $dataUpdate = array(
                'spt_category_id' => $catStockUpdate->id,
                'spt_category_name' => $catStockUpdate->name
            );
        //update list stock for cat stock new
        return DB::table('san_pham_tho')        
        ->whereIn('spt_id', $idArr)
        ->update($dataUpdate);        
    }
    //process del more category stock
}
