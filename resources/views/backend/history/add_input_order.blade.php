@extends('backend.layouts.master',['page_title'=>'Lịch sử nhập đơn hàng'])
@section ('title','Lịch sử nhập đơn hàng')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
	<div class="box box-primary">
            <div class="">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div> -->
                    <form class="form-inline" action="" method="get">
                       <div class="form-group">
                        <label for="day_from">Từ ngày : </label>
                        <input type="datetime" name="day_from" class="form-control datepicker  marginBot5" data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))){!!Request::input('day_from')!!}@endif">
                      </div>
                      <div class="form-group">
                        <label for="day_from">Đến ngày : </label>
                        <input type="datetime" name="day_to" class="form-control datepicker  marginBot5" data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))){!!Request::input('day_to')!!}@endif">
                      </div>   
                      <div class="form-group">
                        <input type="text" name="input_search" class="form-control borderRad4 marginBot5"  placeholder="Email,mã đơn hàng" value="@if(!empty(Request::input('input_search'))){!! trim(Request::input('input_search')) !!}@endif">
                      </div>       
                      <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                      {{ csrf_field() }}
                    </form>
                </div>
                <div class="box-body">
                
                <table class="table table-bordered table-hover table-striped">
                <tr>
                  <th>Mã hóa đơn</th>
                  <th style="width: 250px">Tên</th>
                  <th>Email</th> 
                  <th>
                    <div class="col-md-12 text-center">
                            Chi tiết đơn hàng
                    </div>
                    <div class="col-md-12">
                        <div class="tbl-head col-md-12 no-padding">
                          <div class="col-md-4"><strong>Nguyên liệu</strong></div>
                          <div class="col-md-4"><strong>Lượng</strong></div>
                          <div class="col-md-4"><strong>Giá</strong></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                  </th>
                  <th style="width: 200px">Ngày nhập</th>
                </tr>
                  @if(!empty($data))  
					@foreach($data as $val)
		                <tr>
		                  <td>{!! $val->entity_id!!}</td>
		                  <td>{!! $val->name!!}</td>
		                  <td>{!! $val->email !!}</td>
		                  <td>
                        <div class="col-md-12">
                          <div class="tbl-body col-md-12">
    	                  		@foreach($val->content as $k=>$v)
                            <div class="col-md-4"> {!! $v['hn_name'] !!} </div>  
                            <div class="col-md-4"> {!! $v['hn_quantity'] !!} </div>
                            <div class="col-md-4"> {!! number_format($v['hn_price'], 0, ',', '.') !!} </div>
    	                  		@endforeach
                         </div>
                        </div>
		                  </td>
		                  <td>{!! date('d-m-Y H:i:s',strtotime($val->created_at))!!}</td>

		                </tr>
		            @endforeach
		            
                  @endif
                 </table>
                 	{!!$data->links()!!}
                </div><!-- /.box-body -->
                <div class="box-footer">
                    
                    	
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
            <!-- /.box-body -->
          </div>
@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  <script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true
    });
  </script>
@stop



