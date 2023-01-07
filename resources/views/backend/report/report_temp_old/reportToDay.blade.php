@extends('backend.layouts.master', ['page_title' => 'Báo cáo theo ngày'])
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
<style>
  .order-option{background:#f1f2f2 ;color: red;}
</style>
 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
				<form class="form-inline" action="{{!! route('admin.report.reportday') !!}}" method="post">
					<div class="form-group">
						<input type="text" name="day" class="form-control datepicker" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày">
					</div>
          <div class="form-group">
            <select class="form-control">
              <option value="1">Ca 1</option>
              <option value="2">Ca 2</option>
              <option value="3">Ca 3</option>
            </select>
          </div>
					<button type="submit" class="btn btn-primary">Tìm kiếm</button>
          {{ csrf_field() }}
				</form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>                  
                  <th>ID Đơn hàng</th>
                  <th>Tên khách hàng</th>                  
                  <th>Ngày tháng</th>
                  <th>Chi tiết</th>
                   <th>Tổng cộng</th>
                   <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>

                  @if($status)
                    @foreach($data as $order)
                    <tr>
                      <td>{{$order->order_id}}</td>
                      <td>{{$order->client_name}}</td>
                      <td>{{$order->order_create_time}}</td>
                      <td>
                            
                            <div class="row">
                              <div class="col-sm-3">&nbsp;</div>
                              <div class="col-sm-3">Số lượng</div>
                              <div class="col-sm-3">Đơn giá</div>
                              <div class="col-sm-3">Thành tiền</div>
                            </div>
                            
                              @for($i=0; $i < count($order->name_group); $i++)
                              <div class="row">                              
                              <div class="col-sm-3">
                                {{ $order->name_group[$i] }}
                                <ol class="order-option">
                                    @foreach((array)$order->option as $k => $v)
                                      <li>{{$v['1']}}({{number_format($v['2'], 0, ',', '.')}})({{$v['3']}})</li>
                                    @endforeach
                                </ol>
                              </div>
                              
                              <div class="col-sm-3">{{ $order->qty_group[$i] }}</div>
                              <div class="col-sm-3">{{ number_format($order->price_group[$i],0,",",".") }}</div>
                              <div class="col-sm-3">{{ number_format($order->qty_group[$i]*$order->price_group[$i],0,",",".") }}</div>
                              </div>
                              @endfor
                          
                      </td>
                      <td>{{ number_format($order->order_price,0,",",".") }}</td>
                      <td>
                          @if($order->order_status == 1)
                            <a><span class="label label-warning">Đang xử lý</span></a>                      
                          @elseif($order->order_status == 2)
                            <a><span class="label label-success">Đã thu tiền</span></a>                        
                          @elseif($order->order_status == 3)
                            <a><span class="label label-success">Đã hoàn thành</span></a>                        
                          @elseif($order->order_status == 4)
                            <a><span class="label label-danger">Đã hủy</span></a>
                          @endif
                      </td>
                    </tr>
                    @endforeach                    
                  @else
                    <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                  @endif
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix" id="pagination-link">
              
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /.box -->
        </div>

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

