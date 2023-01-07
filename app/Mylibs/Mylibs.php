<?php 
namespace App\Mylibs;
class Mylibs {
	protected static $_data;
	protected static $_result ='';
	public static function alias($cs){

		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
		"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
		,"ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
		,"ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
		,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
		,"Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ"," ");

		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
		,"a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o"
		,"o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d",
		"A","A","A","A","A","A","A","A","A","A","A","A"
		,"A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O"
		,"O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D","-");
		return str_replace($marTViet,$marKoDau,$cs);
	}
	public static function callProcessSelect($data, $parent = 0,$text = '',$select=0){
   	    foreach ($data as $k => $value){
			if ($value->category_id_parent == $parent) {
				$id = $value->category_id;
				if ($select != 0 && $value->category_id == $select) {
					self::$_result .= '<option value="'.$value->category_id.'" selected="selected">' .$text.$value->category_name.'</option>';
				}else{
				 	self::$_result .= '<option value="'.$value->category_id.'">' .$text.$value->category_name.'</option>';
				}
				//unset($data[$k]);
				self::callProcessSelect($data,$id,$text.'--',$select);
			}
   		}
   		return self::$_result;

	}

	public static function callProcessSelect2($data,$text = ''){
		$_result = '';
   	    foreach ($data as $k => $value){
			if ($value->category_id_parent != 0) {
				$_result .= '<option value="'.$value->category_id.'" selected="selected">' .$text.$value->category_name.'</option>';
			}
   		}
   		return $_result;

	}

	/*public static function resortCat($arr,$option = null){
		$resortArr = array();
	   	if ($option == null) {
	   		foreach ($arr as $value) {
		   		$parent_id = $value['category_id_parent'];
		   		$resortArr[$parent_id][] = $value;
		   		
	   		}
	   	}
	   	return $resortArr;
   }*/

   public static function displayCat($arr,$parent = 0,$text = ''){
   		foreach ($arr as $key => $value) {
   			if ($value->category_id_parent == $parent) {
   				$id = $value->category_id;
   				self::$_data     .= '<tr>';
				//self::$_data     .= '<td>
			                            //<input type="checkbox" name="cid[]" value="'.$value->category_id.'">
			                        //</td>';
                self::$_data     .= '<td>';
			    self::$_data     .= $text.$value->category_name.'</td>';
			    self::$_data	 .= '<td>';
			    if($value->category_status == 1){
			    	self::$_data	 .= '<span class="label label-success">Đang hiện</span>';
			    }else{
			    	self::$_data	 .= '<span class="label label-default">Đang ẩn</span>';
			    }
			    
			    self::$_data	 .= '</td>';
			    self::$_data     .= '<td>
		                                <a class="btn btn-info btn-xs" href="'.route('admin.category.edit',['cat_id'=>$value->category_id]).'" data-href="'.$value->category_id.'"><i class="fa fa-pencil"></i></a> 
		                                <form id="delete-form-'.$value->category_id.'" style="display:inline-block" action="'.route('admin.category.destroy',['cat_id'=>$value->category_id]).'" method="POST" name="delete_item_cat"  >
		                                    <input type="hidden" name="_method" value="DELETE">
		                                    <input name="_token" type="hidden" value="'.csrf_token().'">
		                                    <a class="btn btn-danger btn-xs delete-catrgory" onclick="javascript:formSubmit('.$value->category_id.','.$value->category_id_parent.')"><i class="fa fa-minus-circle"></i></a>
										</form>
		                            </td>';
			    self::displayCat($arr,$id,$text.'__');
			    self::$_data     .='</tr>';
   			}

   		}
   		return self::$_data;
   		/* Or using
			<script>
			    function ConfirmDelete()
			    {
			      var x = confirm("Are you sure you want to delete?");
			      if (x)
			          return true;
			      else
			        return false;
			    }
			</script>    

			<button Onclick="return ConfirmDelete();" type="submit" name="actiondelete" value="1"><img src="images/action_delete.png" alt="Delete"></button>
   		*/
   }


	public static function getDays($month, $year){
		// Start of Month
		$start = new \DateTime("{$year}-{$month}-01");
		$month = $start->format('F');
		// Prepare results array
		$results = array();
		// While same month
		while($start->format('F') == $month){
			// Add to array
			$day              = $start->format('l');
			//$day = sw_get_current_weekday($day);
			$date             = $start->format('j');
			$results[$date]   = $day;
			// Next Day
			$start->add(new \DateInterval("P1D"));
		}
		// Return results
		return $results;
	}

	/*
	* return list time in a day with space = 30p
	*/
	public static function timeInADay(){
		$results = array();
		for($i = 0; $i < 24; $i++){
			if( $i < 10 ){
				$results[] = '0'.$i.':00:00';
				$results[] = '0'.$i.':30:00';
			}else{
				if($i == 23 ){
					$results[] = $i.':00:00';
					$results[] = $i.':30:00';
					$results[] = $i.':59:00';
				}else{
					$results[] = $i.':00:00';
					$results[] = $i.':30:00';
				}
			}
		}
		return $results;
	}

	public static function timeInADay_start(){
		$results = array();
		for($i = 0; $i < 24; $i++){
			if( $i < 10 ){
				$results[] = '0'.$i.':00:01';
				$results[] = '0'.$i.':30:01';
			}else{
				if($i == 23 ){
					$results[] = $i.':00:01';
					$results[] = $i.':30:01';
					$results[] = $i.':59:01';
				}else{
					$results[] = $i.':00:01';
					$results[] = $i.':30:01';
				}
			}
		}
		return $results;
	}

	

}
	

?>