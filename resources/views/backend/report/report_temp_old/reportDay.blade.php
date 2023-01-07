@extends('backend.layouts.master', ['page_title' => 'Báo cáo theo ngày'])
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
<style>
  .order-option{background:#f1f2f2 ;color: red;}
</style>
 <div class="row">
  <?php //echo '<pre>';print_r( getDays(8, 2016)); ?>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="col-xs-12 col-md-5">
                <form class="form-inline" action="{{ route('admin.report.reportday') }}" method="get">
                  <div class="form-group">
                    <input type="datetime" name="day" required class="form-control datepicker" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))) {!!Request::input('day')!!} @endif">
                  </div>
                  <div class="form-group">
                    <select class="form-control" name="case">
                      <option value="0">--Chọn ca--</option>
                      @foreach($schedule as $value)
                        <option @if(!empty(Request::input('case')) && Request::input('case') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}} ({{$value->time_start}} - {{$value->time_end}})</option>
                      @endforeach
                      
                    </select>
                  </div>                  
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  <a class="btn btn-success" style="margin-left:2px;" href="{{ route('admin.report.exportpdf',['download'=>'pdf','day'=>Request::input('day'),'case'=>Request::input('case')]) }}">Export PDF</a>
                  {{ csrf_field() }}
                </form>
                  

              </div>
              <div class="col-xs-12 col-md-7">
                <div class="col-md-6">
                  <strong>Tổng số (đơn hàng hoàn thành): 
                    @if(isset($sumCountSuccess))
                    <span class="required">{{$sumCountSuccess}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (đơn hàng hoàn thành): 
                    @if(isset($sumTotalSuccess))
                    <span class="required">{{number_format($sumTotalSuccess-$totalTK, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>

                <div class="col-md-6">                  
                </div>
                <div class="col-md-6">
                  <strong>Tổng tiền nạp tài khoản: 
                    @if(isset($totalTK))
                    <span class="required">{{number_format($totalTK, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>

                <div class="col-md-6">
                  <strong>Tổng số đơn hàng: 
                    @if(isset($sumCountAll))
                    <span class="required">{{$sumCountAll}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">**</span>Tổng tiền: 
                    @if(isset($sumTotalAll))
                    <span class="required">{{number_format($sumTotalAll, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>

                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <br>
                  <p><strong>Lưu ý:</strong></p>
                  <p><span class="required">(*)</span> tổng tiền dịch vụ (không bao gồm tiền nạp tài khoản)</p>
                  <p><span class="required">(**)</span> tổng tiền dịch vụ (bao gồm tất cả các đơn hàng)</p>
                </div>

              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              @if(isset($day))
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày: {{$day}}</div>
              @else
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày hôm nay</div>
              @endif
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
                                    @if(!empty($order->option[$i]))
                                      @foreach($order->option[$i] as $key => $val)
                                        <li>{{$val['1']}}({{number_format($val['2'], 0, ',', '.')}})({{$val['3']}})</li>
                                      @endforeach
                                    @endif
                                </ol>
                              </div>
                              
                              <div class="col-sm-3">{{ $order->qty_group[$i] }}</div>
                              <div class="col-sm-3">{{ number_format((float)$order->price_group[$i],0,",",".") }}</div>
                              <div class="col-sm-3">{{ number_format((float)($order->qty_group[$i]*$order->price_group[$i]),0,",",".") }}</div>
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
              {{ $data->appends(Request::only(['day', 'case']))->links() }}
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

