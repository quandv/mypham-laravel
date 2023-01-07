<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Recipe
{
    //
    public static function insert($arr){
    	return DB::table('cong_thuc_mon')->insertGetId($arr);
    }

    public static function update($id, $arr){
    	return DB::table('cong_thuc_mon')
		->where('ctm_id', $id)
    	->update($arr);
    }


    public static function listRecipe(){
		return DB::table('cong_thuc_mon')        
        ->leftJoin('product', 'product_ctm_id', '=', 'cong_thuc_mon.ctm_id')
        ->leftJoin('listoption', 'listoption.ctm_id', '=', 'cong_thuc_mon.ctm_id')
        ->select('cong_thuc_mon.*','product_id','product_name','product_image', 'id', 'name')
		->orderBy('cong_thuc_mon.ctm_id', 'asc')
		->paginate(10);
    }

    public static function details($id){
    	$recipeDetails = DB::table('cong_thuc_mon')
		->where('ctm_id', $id)
		->first();
		
		return $recipeDetails;
    }

    public static function delRecipe($id,$pid,$is_option){
        DB::table('cong_thuc_mon')->where('ctm_id', $id)->delete();
        if( $is_option == 0 ){
            DB::table('product')->where('product_id', $pid)->update(['product_ctm_id' => 0]);
        }elseif( $is_option == 1 ){            
            DB::table('listoption')->where('id', $pid)->update(['ctm_id' => 0]);
        }
    	
    }

    public static function search($stxt){        
        $data = DB::table('cong_thuc_mon')
        ->leftJoin('product', 'product_ctm_id', '=', 'cong_thuc_mon.ctm_id')
        ->leftJoin('listoption', 'listoption.ctm_id', '=', 'cong_thuc_mon.ctm_id')
        ->select('cong_thuc_mon.*','product_id','product_name','product_image', 'id', 'name')
        ->where('ctm_name', 'like', "%".$stxt."%")
        ->orWhere('product_name', 'like', "%".$stxt."%")
        ->orderBy('ctm_id', 'asc')
        ->paginate(10);
        
        return $data;
    }

    public static function searchRecipe($stxt, $category_id=null){
        if( $category_id != null ){
            $data = DB::table('san_pham_tho')
            ->join('danh_muc_spt', 'san_pham_tho.spt_category_id', '=', 'danh_muc_spt.id')
            ->select('san_pham_tho.*', 'unit_name')            
            ->where([
                ['san_pham_tho.spt_name', 'like', "%".$stxt."%"],
                ['danh_muc_spt.id', '=', $category_id]
            ])
            ->orderBy('spt_id', 'asc')
            ->paginate(2);
        }else{
            $data = DB::table('san_pham_tho')
            ->join('danh_muc_spt', 'san_pham_tho.spt_category_id', '=', 'danh_muc_spt.id')
            ->select('san_pham_tho.*', 'unit_name')
            ->where('san_pham_tho.spt_name', 'like', "%".$stxt."%")
            ->orderBy('spt_id', 'asc')
            ->paginate(2);
        }
        return $data;
		
    }

    public static function updateStatus($listId, $status){
        return DB::table('cong_thuc_mon')
        ->whereIn('ctm_id', $listId)
        ->update(['status' => $status]);
    }
    
    public static function getCategory($id){
        return DB::table('danh_muc_spt')
        ->select('name')
        ->where('id', '=', $id)
        ->first();
    }

    public static function listProduct($request = null){
		return DB::table('san_pham_tho')
		->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
		->select('san_pham_tho.*', 'danh_muc_spt.unit_name')
        ->where(function($query) use ($request){
            if ( !empty($request->cat_id) ) {
                $query->where('san_pham_tho.spt_category_id', $request->cat_id);
            }
            if (!empty($request->stxt)) {
                $query->where('san_pham_tho.spt_name', 'like', '%'.$request->stxt.'%');
            }
        })
		->orderBy('spt_id', 'asc')
		->paginate(10);
    }

    public static function listCategory(){
    	return DB::table('danh_muc_spt')
		->select('id', 'name', 'unit_name')
		->get();
    }

    public static function delRecipeDetailsItem($ctm_id, $hn_id){
        //get info recipe
        $recipe = DB::table('cong_thuc_mon')
        ->select('ctm_id', 'ctm_details', 'ctm_details_name')
        ->where([
            ['ctm_id', $ctm_id],
        ])
        ->first();

        $ctm_details = json_decode($recipe->ctm_details);
        unset($ctm_details->$hn_id);
        $ctm_details_name = json_decode($recipe->ctm_details_name);
        unset($ctm_details_name->$hn_id);
        
        $arr = array(
                'ctm_details'       => json_encode($ctm_details),
                'ctm_details_name'  => json_encode($ctm_details_name)
            );

        self::update($ctm_id, $arr);
        
    }

    //update số lượng sản phẩm thô
    public static function updateSptUp($arr_id, $arr_quantity){
        foreach( $arr_id as $k => $id ){
            DB::table('san_pham_tho')->where('spt_id', $id)->increment('spt_quantity', $arr_quantity[$k]);
        }
        return true;
    }

    public static function updateSptDown($arr_id, $arr_quantity){
        foreach( $arr_id as $k => $id ){
            DB::table('san_pham_tho')->where('spt_id', $id)->decrement('spt_quantity', $arr_quantity[$k]);
        }
        return true;
    }

    //get product info
    public static function getASpt($spt_id){
        return DB::table('san_pham_tho')
        ->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
        ->where('spt_id', $spt_id)
        ->select('spt_name', 'unit_name')
        ->first();
    }

    //insert công thức mới
    public static function createRecipe($arr){
        return DB::table('cong_thuc_mon')->insertGetId($arr);
    }

    //get product info
    public static function getprodSale($pid){
        return DB::table('product')
        ->where('product_id', $pid)
        ->first();
    }
    
    //get option info
    public static function getOptionSale($pid){
        return DB::table('listoption')
        ->where('id', $pid)
        ->first();
    }

    //update ctm_id trong product
    public static function updateCtmIdProduct($id, $arr){
        return DB::table('product')
        ->where('product_id', $id)
        ->update($arr);
    }

    //update ctm_id trong option
    public static function updateCtmIdOption($id, $arr){
        return DB::table('listoption')
        ->where('id', $id)
        ->update($arr);
    }

    //get unit
    public static function getUnit(){
        $data = DB::table('san_pham_tho')
        ->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
        ->select('spt_id','unit_name')
        ->get();

        $result = array();
        foreach($data as $val){
            $result[$val->spt_id] = $val->unit_name;
        }

        return $result;
    }

    //del-more
    public static function del_more($listId){
        return DB::transaction(function () use ($listId){
            DB::table('product')->whereIn('product_ctm_id', $listId)->update(['product_ctm_id' => 0]);
            DB::table('listoption')->whereIn('ctm_id', $listId)->update(['ctm_id' => 0]);
            DB::table('cong_thuc_mon')->whereIn('ctm_id', $listId)->delete();
        });
    }

    public static function float2rat($n, $tolerance = 1.e-6) {
        if($n == 0){
            $result = array(
                'numTop' => 0,
                'numBot' => 1,
            );
            return $result;
        }

        $h1=1; $h2=0;
        $k1=0; $k2=1;
        $b = 1/$n;
        do {
            $b = 1/$b;
            $a = floor($b);
            $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
            $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
            $b = $b-$a;
        } while (abs($n-$h1/$k1) > $n*$tolerance);

        $result = array(
                'numTop' => $h1,
                'numBot' => $k1,
            );
        return $result;
    }

    public static function getProOp(){
        $product = DB::table('product')
        ->select('product_id','product_name','product_image')
        ->where('product_ctm_id', 0)
        ->get();

        $option = DB::table('listoption')
        ->select('id','name')
        ->where('ctm_id', 0)
        ->get();        

        return array(
                'product'   => $product,
                'option'    => $option
            );
    }
}
