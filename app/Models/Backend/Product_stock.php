<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Product_stock
{
    public static function insert($arr){
    	return DB::table('san_pham_tho')->insertGetId($arr);
    }

    public static function update($id, $arr){
    	DB::table('san_pham_tho')
		->where('spt_id', $id)
    	->update($arr);
    }


    public static function listProduct(){
		return DB::table('san_pham_tho')
		->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
		->select('san_pham_tho.*', 'danh_muc_spt.unit_name')
		->orderBy('spt_id', 'asc')
		->paginate(10);
    }

    public static function listCategory(){
    	return DB::table('danh_muc_spt')
		->select('id', 'name', 'unit_name')
		->get();
    }

    public static function details($id){
    	return DB::table('san_pham_tho')    
		->where('spt_id', $id)
		->first();
    }

    public static function delProduct($id){
	   

       DB::table('san_pham_tho')->where('spt_id', $id)->delete();

    }

    public static function searchProduct($stxt, $category_id=null){
        if( $category_id != null ){
            $data = DB::table('san_pham_tho')
            ->join('danh_muc_spt', 'san_pham_tho.spt_category_id', '=', 'danh_muc_spt.id')
            ->select('san_pham_tho.*', 'unit_name')            
            ->where([
                ['san_pham_tho.spt_name', 'like', "%".$stxt."%"],
                ['danh_muc_spt.id', '=', $category_id]
            ])
            ->orderBy('spt_id', 'asc')
            ->paginate(10);
        }else{
            $data = DB::table('san_pham_tho')
            ->join('danh_muc_spt', 'san_pham_tho.spt_category_id', '=', 'danh_muc_spt.id')
            ->select('san_pham_tho.*', 'unit_name')
            ->where('san_pham_tho.spt_name', 'like', "%".$stxt."%")
            ->orderBy('spt_id', 'asc')
            ->paginate(10);
        }
        return $data;		
    }

    public static function getCategory($id){
        return DB::table('danh_muc_spt')
        ->select('name')
        ->where('id', '=', $id)
        ->first();
    }
    
    // START -- cập nhật trạng thái hết hàng dựa vào lượng sản phẩm thô
    public static function listStockOver(){
        return DB::table('san_pham_tho')        
        ->select('spt_id', 'spt_quantity')
        ->where('spt_quantity', '<=', 0)
        ->get();
    }

    public static function listRecipe(){
        return DB::table('cong_thuc_mon')        
        ->select('ctm_id', 'ctm_details')
        ->get();
    }

    public static function listProductOver($recipeId){
        return DB::table('product')        
        ->select('product_id','product_name','product_image')
        ->where('status', '<>', 0)
        ->whereIn('product_ctm_id', $recipeId)
        ->get();
    }

    public static function listOptionOver($recipeId){
        return DB::table('listoption')        
        ->select('id','name')
        ->where('status', '<>', 0)
        ->whereIn('ctm_id', $recipeId)
        ->get();
    }

    public static function stsover($idArrProduct, $idArrOption, $status = 0){
        $pOverResult = true;
        $opOverResult = true;
        if( !empty($idArrProduct) && count($idArrProduct) > 0){
            $pOver = DB::table('product')
            ->whereIn('product_id', $idArrProduct)
            ->update(['status' => $status]);
            if($pOver){
                $pOverResult = true;
            }else{
                $pOverResult = false;
            }
        }
        if( !empty($idArrOption) && count($idArrOption) > 0){
            $opOver = DB::table('listoption')
            ->whereIn('id', $idArrOption)
            ->update(['status' => $status]);
            if($opOver){
                $opOverResult = true;
            }else{
                $opOverResult = false;
            }
        }
        if( $opOverResult && $opOverResult ){
            return true;
        }else{
            return false;
        }
    }
    // END -- cập nhật trạng thái hết hàng dựa vào lượng sản phẩm thô

    public static function del_more($listId){
        return DB::table('san_pham_tho')->whereIn('spt_id', $listId)->delete();
    }

    public static function check_recipe($spt_id){
        $data = DB::table('cong_thuc_mon')->get();
        $result = array();
        $recipe = array();
        if(count($data) > 0){
            foreach($data as $key => $val){
                if( array_key_exists($spt_id, json_decode($val->ctm_details,true)) ){
                    $recipe[] = $val;
                }
                //$data[$key]->ctm_details = json_decode($val->ctm_details,true);
                //$data[$key]->ctm_details_name = json_decode($val->ctm_details_name,true);
            }
            if(count($recipe) > 0){
                $result['success'] = true;
            }else{
                $result['success'] = false;
            }
        }else{
            $result['success'] = false;
        }
        $result['data'] = $recipe;
        return $result;
    }

    public static function update_recipe_depend($spt_id,$idArr){
        $idArr = explode(',', $idArr);
        $data = DB::table('cong_thuc_mon')
        ->whereIn('ctm_id', $idArr)
        ->get();

        $result = array('success' => true);
        if(count($data) > 0){
            foreach($data as $key => $val){
                $update = array();
                $ctm_details = json_decode($val->ctm_details,true);
                $ctm_details_name = json_decode($val->ctm_details_name,true);
                unset($ctm_details[$spt_id]);
                unset($ctm_details_name[$spt_id]);
                if( count($ctm_details) > 0 ){
                    $update['ctm_details'] = json_encode($ctm_details);
                }else{
                    $update['ctm_details'] = '';
                }
                
                if( count($ctm_details_name) > 0 ){
                    $update['ctm_details_name'] = json_encode($ctm_details_name);
                    if(DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->update($update)){
                        continue;
                    }else{
                        $result['success'] = false;
                        break;
                    }
                }else{
                    $ctm_product = DB::table('product')->where('product_ctm_id', $val->ctm_id)->count();
                    $ctm_option = DB::table('listoption')->where('ctm_id', $val->ctm_id)->count();

                    /*$ctm_product = DB::table('product')->whereExists(function ($query) {
                        $query->from('product')->where('product_ctm_id', $val->ctm_id);
                    });
                    $ctm_option = DB::table('listoption')->whereExists(function ($query) {
                        $query->from('product')->where('ctm_id', $val->ctm_id);
                    })*/

                    //DB::transaction(function (){
                        if( $ctm_product > 0 ){
                            DB::table('product')->where('product_ctm_id', $val->ctm_id)->update(['product_ctm_id' => 0]);
                            //delete ctm
                            DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->delete();
                        }else if( $ctm_option > 0 ){
                            DB::table('listoption')->where('ctm_id', $val->ctm_id)->update(['ctm_id' => 0]);
                            //delete ctm
                            DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->delete();
                        }else{
                            $result['success'] = false;
                        }
                    //});
                    /*if($transac){                        
                        continue;
                    }else{
                        $result['success'] = false;
                        break;
                    }*/
                }
                
            }
            
        }else{
            $result['success'] = false;
        }
        
        return $result;
    }

    public static function check_recipe_more($listIdStock){
        $data = DB::table('cong_thuc_mon')->get();
        $result = array();
        $recipe = array();
        if(count($data) > 0){
            foreach($data as $key => $val){
                foreach($listIdStock as $spt_id){
                    if( array_key_exists($spt_id, json_decode($val->ctm_details,true)) ){
                        $recipe[] = $val;
                        break;
                    }
                }
            }
            if(count($recipe) > 0){
                $result['success'] = true;
            }else{
                $result['success'] = false;
            }
        }else{
            $result['success'] = false;
        }
        $result['data'] = $recipe;
        return $result;
    }

    public static function update_recipe_depend_more($listIdStock,$idArr){
        $idArr = explode(',', $idArr);
        $listIdStock = explode(',', $listIdStock);

        $data = DB::table('cong_thuc_mon')->whereIn('ctm_id', $idArr)->get();

        $result = array('success' => true);
        if(count($data) > 0){
            foreach($data as $key => $val){
                $update = array();
                $ctm_details = json_decode($val->ctm_details,true);
                $ctm_details_name = json_decode($val->ctm_details_name,true);
                foreach($listIdStock as $spt_id){
                    if(isset($ctm_details[$spt_id])){
                        unset($ctm_details[$spt_id]);
                    }
                    if(isset($ctm_details_name[$spt_id])){
                        unset($ctm_details_name[$spt_id]);
                    }
                }
                if( count($ctm_details) > 0 ){
                    $update['ctm_details'] = json_encode($ctm_details);
                }else{
                    $update['ctm_details'] = '';
                }
                
                if( count($ctm_details_name) > 0 ){
                    $update['ctm_details_name'] = json_encode($ctm_details_name);
                    if(DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->update($update)){
                        continue;
                    }else{
                        $result['success'] = false;
                        break;
                    }
                }else{
                    $ctm_product = DB::table('product')->where('product_ctm_id', $val->ctm_id)->count();
                    $ctm_option = DB::table('listoption')->where('ctm_id', $val->ctm_id)->count();

                    //DB::transaction(function (){
                        if( $ctm_product > 0 ){
                            DB::table('product')->where('product_ctm_id', $val->ctm_id)->update(['product_ctm_id' => 0]);
                            //delete ctm
                            DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->delete();
                        }else if( $ctm_option > 0 ){
                            DB::table('listoption')->where('ctm_id', $val->ctm_id)->update(['ctm_id' => 0]);
                            //delete ctm
                            DB::table('cong_thuc_mon')->where('ctm_id', $val->ctm_id)->delete();
                        }else{
                            $result['success'] = false;
                        }
                    //});
                    /*if($transac){                        
                        continue;
                    }else{
                        $result['success'] = false;
                        break;
                    }*/
                }
                
            }
            
        }else{
            $result['success'] = false;
        }
        
        return $result;
    }
}
