@extends('backend.layouts.master',['page_title'=>'Lịch sử'])
@section ('title','Lịch sử sản phẩm nhập')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
  <div class="box box-primary">
          <div class="box-primary">
            <div class="box-header with-border">
              <!-- <div class="">
                <h3 class="box-title">Lịch sử thay đổi trạng thái đơn hàng</h3>
              </div> -->
                <form class="form-inline" action="" method="get">
                  <div class="form-group">
                    <label for="day_from">Từ ngày : </label>
                    <input type="datetime" name="day_from" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))){!!Request::input('day_from')!!}@endif">
                  </div>
                  <div class="form-group">
                    <label for="day_from">Đến ngày : </label>
                    <input type="datetime" name="day_to" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))){!!Request::input('day_to')!!}@endif">
                  </div>
                  <div class="form-group">
                    <select class="form-control borderRad3 marginBot5" name="select_type">
                    	 <option value="">--Chọn--</option>
                    	 @if(!empty($select_box))
                    	   @foreach($select_box as $k=>$v)
                    	   	 <option value="{!! $k !!}" @if(Request::input('select_type') == $k) selected="selected" @endif>{!! $v !!}</option>
                    	   @endforeach
                    	 @endif
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="text" name="search_item" class="form-control borderRad3 marginBot5"  placeholder="Tên sản phẩm,mã sản phẩm" value="@if(!empty(Request::input('search_item'))){!! Request::input('search_item') !!}@endif" style="width:250px">
                  </div>
                  <div class="form-group">
                    <input type="text" name="user_item" class="form-control borderRad3 marginBot5"  placeholder="Tên user, email" value="@if(!empty(Request::input('user_item'))){!! Request::input('user_item') !!}@endif">
                  </div>
                  <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                  
                </form>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped">
                <tr>
                  <!-- <th style="width: 100px">History ID</th> -->
                  <th style="width: 100px">User ID</th>
                  <th style="width: 150px">User Name</th>
                  <th>Email</th>
                  <th>Mã sản phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Options</th>
                  <th>Giá Sp</th>
                  <th>Trạng thái</th>
                  <th>Sự kiện</th>
                  <th>Ngày</th>
                </tr>
                @if(!empty($data))
                   @foreach($data as $val)
		             <tr>
			              <td>{!! $val->user_id !!}</td>
		                  <td>{!! $val->name !!}</td>
		                  <td>{!! $val->email !!}</td>
		                  <td>{!! $val->entity_id!!}</td>
		                  <td>{!! $val->entity_name!!}</td>
		                  <td>
		                    @if(!empty($val->entity_option))
		                      <ul>
			                      @foreach($val->entity_option as $k=>$v)  
			                         <li>{!! $v['option_name'] !!} - {!! number_format($v['option_price'],0,",",".")!!}</li>        
			                      @endforeach
		                      </ul>    
		                    @endif
		                  </td>
		                  <td>{!! number_format((float)$val->entity_value,0,",",".") !!}</td>
		                  <td>
		                  	     @if ($val->entity_status == 1) 
                                <span class="label label-success">Còn hàng</span>
                             @else
                                <span class="label label-danger">Hết hàng</span>
                             @endif	
		                  </td>
                      <td>
                        @if($val->type_id == 3)
                            <span class="label label-success">Thêm sản phẩm</span>
                        @endif
                        @if($val->type_id == 4)
                            <span class="label label-warning">Sửa sản phẩm</span>
                        @endif
                        @if($val->type_id == 5)
                            <span class="label label-danger">Xóa sản phẩm</span>
                        @endif
                      </td>
		                  <td>         
		                  {!! date('d-m-Y H:i:s',strtotime($val->created_at))!!}
		                  </td>
		             </tr>
		            @endforeach
                @endif
                
              </table>
              {!!$data->appends(Request::only(['day_to', 'day_from','select_type','search_item','user_item']))->links()!!}
            </div>
            <!-- /.box-body -->
          </div>
        </div>
@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  <script type="text/javascript">
    $('.datepicker').datepicker({autoclose:true});    
  </script>
@stop
