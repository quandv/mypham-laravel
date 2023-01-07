<?php
namespace App\Models\Backend;

use DB;

class Category
{
    public static function insert($arr){
    	DB::table('category')->insert($arr);
    }
    public static function listCat($request,$option = null){
        if ($option == null) {
            return DB::table('category')->select('category_id','category_name','category_id_parent','category_status')
            ->orWhere(function ($query) use ($request){
                if ($request->search_cat != '') {
                    $query->orWhere('category_name', 'LIKE', '%'.$request->search_cat.'%');
                }
            })->get();
        }else{
             return DB::table('category')->select('category_id','category_name','category_id_parent','category_status')->get();
        }
    }

    public static function delete($id){
    	return DB::table('category')->where('category_id', '=', $id)->delete();
    }

    public static function update($arr,$id){
        return DB::table('category')
            ->where('category_id', $id)
            ->update($arr);
    }
    public static function getCatFromId($id){
        return DB::table('category')->where('category_id', '=', $id)->first();
    }

    public static function listCatRoot(){
        return DB::table('category')
        ->select('category_id','category_name','category_id_parent','category_status')
        ->where('category_id_parent', 0)
        ->get();
    }

    //process del one category
    public static function check_category_depend($id_parent){
        return DB::table('category')
        ->where('category_id_parent', $id_parent)
        ->get();
    }
    public static function update_category_depend($idArr, $id_new){
        //category info
        $catParentUpdate = DB::table('category')->where('category_id', $id_new)->first();
        $dataUpdate = array(
                'category_id_parent' => $catParentUpdate->category_id
            );
        //update list cat for new cat parent
        return DB::table('category')
        ->whereIn('category_id', $idArr)
        ->update($dataUpdate);
    }

    public static function check_product_depend($id_cat){
        return DB::table('product')
        ->select('product_id','product_name','product_image')
        ->where('category_id', $id_cat)
        ->get();
    }
    public static function update_product_depend($idArr, $id_new){        
        //update list cat for new cat parent
        return DB::table('product')
        ->whereIn('product_id', $idArr)
        ->update(['category_id' => $id_new]);
    }
    //process del one category
}
