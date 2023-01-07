@extends('backend.layouts.master', ['page_title' => 'Thống kê sản phẩm bán chạy'])
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
<style>
  .btn-day-details{ 
    color: #fff;
    background: #46b8da;
    padding: 5px 15px;
  }
  .btn-day-details:hover{ 
    color: #ec0000;
  }

</style>
 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="col-xs-12 col-md-6">
                <form class="form-inline" action="{{ route('admin.report.category') }}" method="get">
                  <div class="form-group">
                    <input type="datetime" name="from" required class="form-control datepicker1" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày bắt đầu">
                  </div>
                  <div class="form-group">
                    <input type="datetime" name="to" required class="form-control datepicker2" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày kết thúc">
                  </div>

                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  <a class="btn btn-success" style="margin-left:2px;" href="{{ route('admin.report.exportexcel',['download'=>'excel','from'=>Request::input('from'),'to'=>Request::input('to')]) }}">Export Excel</a>
                  {{ csrf_field() }}
                </form>
                
              </div>
              <!-- <div class="col-xs-12 col-md-6">
                <div class="col-md-6">
                  <strong>Tổng số đơn hàng:
                    @if(isset($sumCount))
                    <span class="required">{{$sumCount}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong>Tổng tiền: 
                    @if(isset($sumTotal))
                    <span class="required">{{number_format($sumTotal, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
              </div> -->

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              @if(isset($error))
                <div class="alert alert-error" role="alert">{{$error}}</div>
              @elseif(isset($from) && isset($to))
                <div class="alert alert-success" role="alert">Thống kê sản phẩm bán chạy( từ ngày: <strong>{{$from}}</strong> đến ngày: <strong>{{$to}}</strong> )</div>
              @else
                <div class="alert alert-success" role="alert">Thống kê sản phẩm bán chạy(tính đến thời điểm hiện tại)</div>
              @endif
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>                                    
                  <th>Sản phẩm</th>
                  <th>Nhóm hàng</th>                  
                  <th>Số lượng</th>
                  <th>Đơn giá</th>
                  <th>Thành tiền</th>
                </tr>
                </thead>
                <tbody>
                  @if(isset($listProduct))                    
                      @foreach($listOder as $k => $v)
                        @foreach($listProduct as $key => $value)
                          @if( $v->product_id == $value->product_id )
                            <tr>
                              <td>{{$v->product_name}}</td>
                              <td>{{$value->category_name}}</td>                              
                              <td>{{$v->product_qty_group}}</td>
                              <td>{{number_format($value->product_price, '0', ',', '.')}}</td>
                              <td>{{number_format($value->product_price*$v->product_qty_group, '0', ',', '.')}}</td> 
                            </tr>                         
                          @endif
                        @endforeach
                      @endforeach
                    <tr>
                      <td class="required" colspan="4"> <strong>Tổng tiền Option:</strong> </td>
                      <td class="required" ><strong>{{number_format($optionTotalPrice, '0', ',', '.')}}đ</strong></td>
                    </tr>
                    <tr>
                      <td class="required" colspan="4"> <strong>Tổng tiền:</strong> </td>
                      <td class="required" ><strong>{{number_format($totalPrice, '0', ',', '.')}}đ</strong></td>
                    </tr>
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
    $('.datepicker1').datepicker({
      autoclose: true
    });
    $('.datepicker2').datepicker({
      autoclose: true
    });
  </script>
@stop

