<?php

namespace App\Models\Backend;

use DB;
use PDO;
use Config;

class Bill
{
    //
    public static function insert($arr){
    	return DB::table('hoa_don_nhap')->insertGetId($arr);
    }

    public static function update($id, $arr){
    	DB::table('hoa_don_nhap')
		->where('hdn_id', $id)
    	->update($arr);
    }

    public static function listBill(){
		return DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        /*->leftJoin('san_pham_tho', 'san_pham_tho.spt_id', '=', 'chi_tiet_hoa_don_nhap.hn_spt_id')
        ->leftJoin('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')*/
        ->selectRaw("hoa_don_nhap.*, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_unit SEPARATOR ',') as unit_name_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_name SEPARATOR ',') as hn_name_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_price SEPARATOR ',') as hn_price_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_quantity SEPARATOR ',') as hn_quantity_group")
		->orderBy('hdn_id', 'desc')
        ->groupBy('hoa_don_nhap.hdn_id')
		->paginate(10);
    }

    public static function details($id){
    	$billDetails = DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        /*->join('san_pham_tho', 'san_pham_tho.spt_id', '=', 'chi_tiet_hoa_don_nhap.hn_spt_id')
        ->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')*/
        ->select('chi_tiet_hoa_don_nhap.*', 'hdn_id', 'hdn_code', 'hdn_nsx_id', 'hdn_nsx_name')
		->where('hoa_don_nhap.hdn_id', $id)
		->get();

		$dataReturn = array();
		if( !empty($billDetails) ){
			$dataReturn['billDetails'] = $billDetails;
			$dataReturn['hdn_code'] = $billDetails['0']->hdn_code;
			$dataReturn['hdn_nsx_id'] = $billDetails['0']->hdn_nsx_id;
		}
		return $dataReturn;
    }

    public static function delBill($id){
        DB::table('option')->where('hdn_id', $id)->delete();
    	DB::table('hoa_don_nhap')->where('hdn_id', $id)->delete();
    }

    public static function delBillDetails($id){
        //get info bill
        $bill = DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        ->select('chi_tiet_hoa_don_nhap.hn_spt_id', 'chi_tiet_hoa_don_nhap.hn_quantity')
        ->where('hn_hdn_id', $id)
        ->get();        

        $arr_id = array();
        $arr_quantity = array();
        foreach($bill as $k => $v){
            $arr_id[] = $v->hn_spt_id;
            $arr_quantity[] = $v->hn_quantity;
        }

    	if(DB::table('chi_tiet_hoa_don_nhap')->where('hn_hdn_id', $id)->delete()){
            self::updateSptDown($arr_id, $arr_quantity);
        }
    }

    public static function search($stxt,$day){
        $data = DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        /*->leftJoin('san_pham_tho', 'san_pham_tho.spt_id', '=', 'chi_tiet_hoa_don_nhap.hn_spt_id')
        ->leftJoin('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')*/
        ->selectRaw("DATE(hoa_don_nhap.hdn_create_time),hoa_don_nhap.*, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_unit SEPARATOR ',') as unit_name_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_name SEPARATOR ',') as hn_name_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_price SEPARATOR ',') as hn_price_group, GROUP_CONCAT(chi_tiet_hoa_don_nhap.hn_quantity SEPARATOR ',') as hn_quantity_group")
        ->where(function ($query) use ($day){
                if ($day != '') {
                    $query->whereRaw("DATE(hoa_don_nhap.hdn_create_time) = '".$day."'");
                }
            })
        ->where(function ($query) use ($stxt){
                if ($stxt != '') {
                    $query->where('hdn_code', 'like', "%".$stxt."%");
                    $query->orWhere('hdn_id', '=', $stxt);
                    $query->orWhere('hdn_name_employee', 'like', "%".$stxt."%");
                }
            })
        ->orderBy('hdn_id', 'desc')
        ->groupBy('hoa_don_nhap.hdn_id')
        ->paginate(10);        
        //->toSql();dd($data);
        
        return $data;
    }

    public static function updateStatus($listId, $status){
        return DB::table('hoa_don_nhap')
        ->whereIn('hdn_id', $listId)
        ->update(['status' => $status]);
    }
    
    public static function getCategory($id){
        return DB::table('danh_muc_spt')
        ->select('name')
        ->where('id', '=', $id)
        ->first();
    }
    
    //get nha_san_xuat info
    public static function listNsx(){
        return DB::table('nha_san_xuat')
        ->orderBy('nsx_id', 'asc')
        ->get();
    }

    //get nsx_name
    public static function getNameNsx($nsx_id){
        $nsx = DB::table('nha_san_xuat')
        ->select('nsx_name')
        ->where('nsx_id', $nsx_id)
        ->first();
        return $nsx->nsx_name;
    }

    //insert nhà sản xuất
    public static function createNsx($arr){
        return DB::table('nha_san_xuat')->insertGetId($arr);
    }

    //insert hóa đơn mới
    public static function createBill($arr){
        return DB::table('hoa_don_nhap')->insertGetId($arr);
    }

    //insert chi tiết hóa đơn mới
    public static function createBillDetails($arr){
        return DB::table('chi_tiet_hoa_don_nhap')->insert($arr);
    }

    //update số lượng sản phẩm thô
    public static function updateSpt($arr_id, $arr_quantity){
        foreach( $arr_id as $k => $id ){
            DB::table('san_pham_tho')->where('spt_id', $id)->increment('spt_quantity', $arr_quantity[$k]);
        }

        //if(Config::get('vgmconfig.pstatus') == 1){
            //update trạng thái sản phẩm và option theo công thức
            ///// lấy danh sách sản phẩm thô => array( spt_id => spt_qty )
            $spt = DB::table('san_pham_tho')
            ->select('spt_id', 'spt_quantity')
            ->get();
            $stock = array();
            foreach($spt as $val){
                $stock[$val->spt_id] = $val->spt_quantity;
            }
            
            ///// duyệt qua các sản phẩm + option đang hết hàng để lấy ra công thức <=> check với kho hàng
            $recipe = array();
            $recipeId = array();

            $product_recipe = DB::table('product')
            ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'product.product_ctm_id')
            ->select('cong_thuc_mon.ctm_id','cong_thuc_mon.ctm_details')
            ->where('product.status', 0)
            ->get();

            $option_recipe = DB::table('listoption')
            ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'listoption.ctm_id')
            ->select('cong_thuc_mon.ctm_id','cong_thuc_mon.ctm_details')
            ->where('listoption.status', 0)
            ->get();

            if(count($product_recipe) > 0){
                foreach($product_recipe as $pval){
                    $recipe[$pval->ctm_id] = json_decode($pval->ctm_details, true);
                }    
            }
            if(count($product_recipe) > 0){
                foreach($option_recipe as $opval){
                    $recipe[$opval->ctm_id] = json_decode($opval->ctm_details, true);
                }
            }
            if(count($recipe) > 0){
                foreach($recipe as $rkey => $rval){
                    $checkRecipe = true;
                    foreach($rval as $rkey2 => $rval2){
                        if( !isset($stock[$rkey2]) || $stock[$rkey2] < $rval2 ){
                            $checkRecipe = false; break;
                        }
                    }
                    if( $checkRecipe == true ){
                        $recipeId[] = $rkey;
                    }
                }
            }

            ///// update trạng thái sản phẩm + option => còn hàng
            if(count($recipeId) > 0){
                DB::table('product')->whereIn('product_ctm_id', $recipeId)->update(['status' => 1]);
                DB::table('listoption')->whereIn('ctm_id', $recipeId)->update(['status' => 1]);
            }
        //}

        return true;
    }

    public static function listProduct($request=null){
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
        ->paginate(5);
    }

    public static function listCategory(){
    	return DB::table('danh_muc_spt')
		->select('id', 'name', 'unit_name')
		->get();
    }

    public static function delBillDetailsItem($hdn_id, $hn_id){
        //get info bill
        $bill = DB::table('chi_tiet_hoa_don_nhap')
        ->select('hn_spt_id', 'hn_quantity')
        ->where([
            ['hn_hdn_id', $hdn_id],
            ['hn_spt_id', $hn_id],
        ])
        ->first();

        $arr_id = array($bill->hn_spt_id);
        $arr_quantity = array($bill->hn_quantity);

        if( DB::table('chi_tiet_hoa_don_nhap')->where([['hn_hdn_id', $hdn_id],['hn_spt_id', $hn_id]])->delete() ){
            self::updateSptDown($arr_id, $arr_quantity);
        }
    }

    //update số lượng sản phẩm thô
    public static function updateSptUp($arr_id, $arr_quantity){
        foreach( $arr_id as $k => $id ){
            DB::table('san_pham_tho')->where('spt_id', $id)->increment('spt_quantity', $arr_quantity[$k]);
        }

        //if(Config::get('vgmconfig.pstatus') == 1){
            //update trạng thái sản phẩm và option theo công thức
            ///// lấy danh sách sản phẩm thô => array( spt_id => spt_qty )
            $spt = DB::table('san_pham_tho')
            ->select('spt_id', 'spt_quantity')
            ->get();
            $stock = array();
            foreach($spt as $val){
                $stock[$val->spt_id] = $val->spt_quantity;
            }
            
            ///// duyệt qua các sản phẩm + option để lấy ra công thức <=> check với kho hàng
            $recipe = array();
            $recipeId = array(); // mảng id công thức => update sang còn hàng
            $recipeIdOver = array(); // mảng id công thức => update sang hết hàng

            $product_recipe = DB::table('product')
            ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'product.product_ctm_id')
            ->select('cong_thuc_mon.ctm_id','cong_thuc_mon.ctm_details')
            ->get();

            $option_recipe = DB::table('listoption')
            ->join('cong_thuc_mon', 'cong_thuc_mon.ctm_id', '=', 'listoption.ctm_id')
            ->select('cong_thuc_mon.ctm_id','cong_thuc_mon.ctm_details')
            ->get();

            if(count($product_recipe) > 0){
                foreach($product_recipe as $pval){
                    $recipe[$pval->ctm_id] = json_decode($pval->ctm_details, true);
                }    
            }
            if(count($product_recipe) > 0){
                foreach($option_recipe as $opval){
                    $recipe[$opval->ctm_id] = json_decode($opval->ctm_details, true);
                }
            }
            if(count($recipe) > 0){
                foreach($recipe as $rkey => $rval){
                    $checkRecipe = true;
                    foreach($rval as $rkey2 => $rval2){
                        if( !isset($stock[$rkey2]) || $stock[$rkey2] < $rval2 ){
                            $checkRecipe = false; break;
                        }
                    }
                    if( $checkRecipe == true ){
                        $recipeId[] = $rkey;
                    }else{
                        $recipeIdOver[] = $rkey;
                    }
                }
            }

            ///// update trạng thái sản phẩm + option => còn hàng
            if(count($recipeId) > 0){
                DB::table('product')->whereIn('product_ctm_id', $recipeId)->update(['status' => 1]);
                DB::table('listoption')->whereIn('ctm_id', $recipeId)->update(['status' => 1]);
            }
            ///// update trạng thái sản phẩm + option => hết hàng
            if(count($recipeIdOver) > 0){
                DB::table('product')->whereIn('product_ctm_id', $recipeIdOver)->update(['status' => 0]);
                DB::table('listoption')->whereIn('ctm_id', $recipeIdOver)->update(['status' => 0]);
            }
        //}

        return true;
    }

    public static function updateSptDown($arr_id, $arr_quantity){
        foreach( $arr_id as $k => $id ){
            DB::table('san_pham_tho')->where('spt_id', $id)->decrement('spt_quantity', $arr_quantity[$k]);
        }
        return true;
    }

    //get spt info
    public static function getASpt($spt_id){
        return DB::table('san_pham_tho')
        ->join('danh_muc_spt', 'danh_muc_spt.id', '=', 'san_pham_tho.spt_category_id')
        ->where('spt_id', $spt_id)
        ->select('spt_name', 'unit_name')
        ->first();
    }

    //STATISTIC
    //statistic for month
    public static function statisticMonth($month,$year){
        return DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        ->selectRaw("hn_name, hn_unit, SUM(chi_tiet_hoa_don_nhap.hn_price) as sumBill, SUM(chi_tiet_hoa_don_nhap.hn_quantity) as sumQty")
        ->whereRaw("MONTH(hdn_create_time) = '".$month."' AND YEAR(hdn_create_time) = '".$year."'")
        ->orderBy('hdn_id', 'asc')
        ->groupBy('chi_tiet_hoa_don_nhap.hn_spt_id')
        ->get();
        //->toSql();die;
    }

    //statistic for year
    public static function statisticYear($year){
        return DB::table('hoa_don_nhap')
        ->join('chi_tiet_hoa_don_nhap', 'chi_tiet_hoa_don_nhap.hn_hdn_id', '=', 'hoa_don_nhap.hdn_id')
        ->selectRaw("hn_name, hn_unit, SUM(chi_tiet_hoa_don_nhap.hn_price) as sumBill, SUM(chi_tiet_hoa_don_nhap.hn_quantity) as sumQty")
        ->whereRaw("YEAR(hdn_create_time) = '".$year."'")
        ->orderBy('hdn_id', 'asc')
        ->groupBy('chi_tiet_hoa_don_nhap.hn_spt_id')
        ->get();
    }
}
