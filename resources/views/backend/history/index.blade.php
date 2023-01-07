@extends('backend.layouts.master',['page_title'=>'Lịch sử'])
@section ('title','Lịch sử')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
	<div class="box box-primary">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">Lịch sử thay đổi trạng thái đơn hàng</h3> -->
              <div class="">
                <form class="form-inline" action="" method="get">
                  <div class="form-group">
                    <label for="day_from">Từ ngày : </label>
                    <input type="datetime" name="day_from" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))){!!Request::input('day_from')!!}@endif">
                  </div>
                  <div class="form-group">
                    <label for="day_from">Đến ngày : </label>
                    <input type="datetime" name="day_to" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))){!!Request::input('day_to')!!}@endif">
                  </div>
                  <div class="form-group marginBot5">
                    <input type="text" name="user" class="form-control borderRad4 marginBot5"  placeholder="Tên,email,mã đơn hàng" value="@if(!empty(Request::input('user'))){!! trim(Request::input('user')) !!}@endif" style="width:200px;">
                  </div>
                  <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                  
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped">
                <tr>
                  <!-- <th style="width: 100px">History ID</th> -->
                  <th style="width: 100px">User ID</th>
                  <th style="width: 150px">User Name</th>
                  <th>Email</th>
                  <th>                   
                      <div class="col-md-12 no-padding">
                        <div class="col-md-3"><strong>Mã đơn hàng</strong></div>
                        <div class="col-md-3"><strong>Trạng thái cũ</strong></div>
                        <div class="col-md-3"><strong>Thời gian xử lý</strong></div>
                        <div class="col-md-3"><strong>Trạng thái mới</strong></div>
                        <div class="clearfix"></div>
                      </div>     
                    </th>
                  <th>Ngày</th>
                </tr>
                @if(!empty($data))
                   @foreach($data as $val)
		                <tr>
		                <!--   <td>{{--$val->id --}}</td> -->
		                  <td>{!! $val->user_id !!}</td>
                      <td>{!! $val->name !!}</td>
                      <td>{!! $val->email !!}</td>
		                  <td>
                        <div class="col-md-12">
                        @if(!empty($val->list_order))
                        @foreach($val->list_order as $k=>$v)
                            <?php              
                              $day = floor($v['timestamp_process'] / 86400);
                              $hr = floor(($v['timestamp_process'] % 86400) / 3600);
                              $min = floor(($v['timestamp_process'] % 3600) / 60);
                              $time_process = '';
                              if ($day> 0 ) {
                                $time_process = $day .' ngày ';
                              }
                              if ($hr > 0) {
                                $time_process .= $hr .' giờ ';
                              }
                              if ($min >= 0) {
                                $time_process .= $min .' phút ';
                              }
                            ?>
                          <div class="col-md-3">
                            {!! $k !!} 
                          </div> 
                          <div class="col-md-3">
                            @if ((isset($v['order_status']) && $v['order_status'] == 1) || (isset($v['status']) && $v['status'] == 1)) 
                                <span class="label label-warning">Đang xử lý</span>
                            @endif
                            @if ((isset($v['order_status']) && $v['order_status'] == 2) || (isset($v['status']) && $v['status'] == 2))
                               <span class="label label-success">Đã thu tiền</span>
                            @endif
                            @if ((isset($v['order_status']) && $v['order_status'] == 3) || (isset($v['status']) && $v['status'] == 3)) 
                                <span class="label label-success">Đã hoàn thành</span>
                            @endif
                            @if ((isset($v['order_status']) && $v['order_status'] == 4) || (isset($v['status']) && $v['status'] == 4)) 
                                <span class="label label-danger">Đã hủy</span>
                            @endif
                             @if ((isset($v['order_status']) && $v['order_status'] == 5) || (isset($v['status']) && $v['status'] == 5)) 
                                <span class="label label-danger">Đã hủy(hoàn trả)</span>
                            @endif
                          </div>
                          <div class="col-md-3">
                            {!! $time_process!!} 
                          </div>
                          <div class="col-md-3">
                            @if ($v['status_changed'] == 1) 
                                <span class="label label-warning">Đang xử lý</span>
                            @endif
                            @if ($v['status_changed'] == 2)
                               <span class="label label-success">Đã thu tiền</span>
                            @endif
                            @if ($v['status_changed'] == 3) 
                                <span class="label label-success">Đã hoàn thành</span>
                            @endif
                            @if ($v['status_changed'] == 4) 
                                <span class="label label-danger">Đã hủy</span>
                            @endif
                            @if ($v['status_changed'] == 5)
                                <span class="label label-danger">Đã hủy(hoàn trả)</span>
                            @endif 
                          </div>  
                          <div class="clearfix"></div>                  
                          @endforeach
                         @endif
                        </div>
		                  </td>
		                  <td>         
                          {!! date('d-m-Y H:i:s',strtotime($val->created_at))!!}
		                  </td>
		                </tr>
		            @endforeach
                @endif
                
              </table>
              {!!$data->links()!!}
            </div>
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



