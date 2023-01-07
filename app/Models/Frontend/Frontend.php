<?php
namespace App\Models\Frontend;
use DB;
class Frontend
{
  public static function createOrder($dataSavetoOrder, $stockNum, $result=null){
    DB::transaction(function () use ($dataSavetoOrder, $stockNum, &$result) {
        $result = DB::table('order')->insertGetId($dataSavetoOrder);
        foreach( $stockNum as $spt_id => $qty ){
          DB::table('san_pham_tho')
          ->where('spt_id', $spt_id)
          ->decrement('spt_quantity', $qty);
        }        
    });
    return $result;
  }

  public static function recipeProduct($processStockProductID){
    return DB::table('product')
    ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'product.product_ctm_id')
    ->selectRaw("product.product_id as pid, ctm_id, ctm_details")
    ->where([
        ['product_ctm_id', '>', 0]
      ])
    ->whereIn('product_id', $processStockProductID)
    ->get();
  }

  public static function recipeOption($processStockOptionID){
    return DB::table('listoption')
    ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'listoption.ctm_id')
    ->selectRaw("listoption.id as pid, listoption.ctm_id as ctm_id, cong_thuc_mon.ctm_details as ctm_details")
    ->where([
        ['listoption.ctm_id', '>', 0]
      ])
    ->whereIn('id', $processStockOptionID)
    ->get();
  }

  public static function checkRemain($stockNum){
    $data = DB::table("san_pham_tho")
        ->select('spt_id','spt_quantity')
        ->whereIn('spt_id', array_keys($stockNum))
        ->get();
    $dataResult = array(
        'status' => true,
        'id_arr' => array()
      );
    
    foreach($data as $key => $val){
      if( $val->spt_quantity < $stockNum[$val->spt_id] ){
        $dataResult['status'] = false;
        $dataResult['id_arr'][] = $val->spt_id;
      }
    }
    return $dataResult;
  }

  public static function check_recipe($id_arr){
      $data = DB::table('cong_thuc_mon')->get();
      $result = array();
      $recipe = array();
      if(count($data) > 0){
          foreach($data as $key => $val){
              if( count( array_intersect($id_arr, array_keys(json_decode($val->ctm_details,true))) ) > 0 ){
                  $recipe[] = $val->ctm_id;
              }
          }
          if(count($recipe) > 0){
            //update status for product and option depend
            DB::table('product')->whereIn('product_ctm_id', $recipe)->update(['status' => 0]);
            DB::table('listoption')->whereIn('ctm_id', $recipe)->update(['status' => 0]);

            $product_over = DB::table('product')->select('product_id')->whereIn('product_ctm_id', $recipe)->get();
            $option_over = DB::table('listoption')
            ->join('option', 'option.option_id', '=', 'listoption.id')
            ->select('option.id')
            ->whereIn('listoption.ctm_id', $recipe)
            ->get();

            foreach($product_over as $k => $v){
              $result['product_over'][] = $v->product_id;
            }
            foreach($option_over as $k2 => $v2){
              $result['option_over'][] = $v2->id;
            }

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

  public static function getCategory($id){
    $cat = DB::table('category')
    ->select("category_name")
    ->where('category_id', $id)    
    ->first();

    return $cat->category_name;
  }

}