<?php

namespace App\Models\Backend;

use DB;
use PDO;

class Product
{
    public static function insert($arr){
    	return DB::table('product')->insertGetId($arr);
    }

    public static function update($id, $arr){
    	DB::table('product')
		->where('product_id', $id)
    	->update($arr);
    }

    public static function listProduct(){
		return DB::table('product')
		->join('category', 'product.category_id', '=', 'category.category_id')
		->orderBy('product.product_id', 'asc')
		->paginate(10);
    }

    public static function listCategory(){
    	return DB::table('category')
    	->where('category_id_parent', '!=', 0 )
		->select('category_id', 'category_name')
		->get();
    }

    // add option
    public static function insertOption($pid,$arrOption){
        //var_dump($arrOption);die;
        $products = DB::table('listoption')
        ->whereIn('id', $arrOption)
        ->get();
        //print_r($products);die;
        $arr_option = array();
        foreach($products as $product){
            $arr_option[] = array(
                                'product_id' => $pid,
                                'option_id'  => $product->id,
                                'option_name'=> $product->name,
                                'option_price'=> $product->price,
                            );
        }

        DB::table('option')->insert($arr_option);
    }

    public static function updateOption($pid,$arrOption){
        DB::table('option')->where('product_id', $pid)->delete();
        Product::insertOption($pid,$arrOption);
    }

    public static function updateOption2($pid){
        DB::table('option')->where('product_id', $pid)->delete();
    }

    public static function listOption(){
        return DB::table('listoption')
        ->get();
    }
    //end add option

    public static function details($id){
    	$product = DB::table('product')
		->where('product.product_id', $id)
		->first();
		if( !empty($product) ){
			return $product;
		}else{
			return false;
		}
    }

    public static function delProduct($id){
        // $ctm = DB::table('product')->select('product_ctm_id')->where('product_id', $id)->first();
        // if( $ctm->product_ctm_id != 0){
        //     DB::table('cong_thuc_mon')->where('ctm_id', $ctm->product_ctm_id)->delete();    
        // }
        // DB::table('option')->where('product_id', $id)->delete();
    	DB::table('product')->where('product_id', $id)->delete();
    }

    public static function searchProduct($stxt, $category_id=null){
        if( $category_id != null ){
            $data = DB::table('product')
            ->join('category', 'product.category_id', '=', 'category.category_id')
            ->leftJoin('option', 'option.product_id', '=', 'product.product_id')
            ->select('product.*', 'category.category_name as category_name')
            ->selectRaw("GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group")
            ->where([
                ['product.product_name', 'like', "%".$stxt."%"],
                ['category.category_id', '=', $category_id]
            ])
            ->orWhere([
                ['category.category_id_parent', '=', $category_id],
                ['product.product_name', 'like', "%".$stxt."%"]
            ])
            ->groupBy('product.product_id')
            ->orderBy('product_id', 'desc')
            ->paginate(20);
        }else{
            $data = DB::table('product')
            ->join('category', 'product.category_id', '=', 'category.category_id')
            ->leftJoin('option', 'option.product_id', '=', 'product.product_id')
            ->select('product.*', 'category.category_name as category_name')
            ->selectRaw("GROUP_CONCAT(option.option_name SEPARATOR ',') as option_name_group")
            ->where('product.product_name', 'like', "%".$stxt."%")
            ->groupBy('product.product_id')
            ->orderBy('product_id', 'desc')
            ->paginate(20);
        }
        return $data;
    }

    public static function updateStatus($listId, $status){
        return DB::table('product')
        ->whereIn('product_id', $listId)
        ->update(['status' => $status]);
    }

    //support for search by category
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

    public static function getCategory($category_id){
        $cat = DB::table('category')
        ->select('category_name')
        ->where('category_id', '=', $category_id)
        ->first();
        if(empty($cat)){
            return false;
        }else{
            return $cat->category_name;
        }
    }

    public static function listCatRoot(){
        return DB::table('category')
        ->select('category_id', 'category_name')
        ->where('category_id_parent', 0)
        ->get();
    }

    public static function listProductCat($category_id_parent){
        return DB::table('product')
        ->join('category', 'product.category_id', '=', 'category.category_id')
        ->where('category.category_id_parent', $category_id_parent)
        ->orderBy('product.sort', 'asc')
        ->get();
    }

    public static function update_sort($idArr,$sortArr){
        $result = false;
        foreach($idArr as $key => $val){
            if( DB::table('product')->where('product_id', $val)->update(['sort' => $sortArr[$key]]) ){
                $result = true;
            }
        }
        return $result;
    }
    
}
