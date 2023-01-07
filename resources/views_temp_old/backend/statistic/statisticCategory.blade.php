@extends('backend.layouts.master', ['page_title' => 'Thống kê sản phẩm bán chạy'])
@section ('title','Thống kê sản phẩm bán chạy')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
{{ Html::style(asset('css/quan-datetimepicker.min.css')) }}
<style type="text/css">
  .btn-day-details{ 
    color: #fff;
    background: #46b8da;
    padding: 5px 15px;
  }
  .btn-day-details:hover{ 
    color: #ec0000;
  }

  ul.nav-tabs li.active a { background-color: #3c8dbc !important; color: #fff !important; }

</style>
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <div class="col-xs-12 col-md-12 no-padding">
                <form class="form-inline" action="{{ route('admin.statistic.category') }}" method="get">
                  <div class="form-group">
                    <input type="datetime" name="from" class="form-control datepicker1 borderRad3 marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Chọn ngày bắt đầu" value="@if(!empty(Request::input('from'))){!!Request::input('from')!!}@endif">
                  </div>
                  <div class="form-group">
                    <input type="datetime" name="to" class="form-control datepicker2 borderRad3 marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Chọn ngày kết thúc" value="@if(!empty(Request::input('to'))){!!Request::input('to')!!}@endif">
                  </div>

                  <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                  <a class="btn btn-success marginBot5" style="margin-left:2px;" href="{{ route('admin.statistic.exportexcel',['download'=>'excel','from'=>Request::input('from'),'to'=>Request::input('to')]) }}"><i class="fa fa-file-pdf-o"></i> Export Excel</a>
                  {{ csrf_field() }}
                </form>                
              </div>

            </div>
            <!-- /.box-header -->
            @if(isset($error))
              <div class="alert alert-error" role="alert">{{$error}}</div>
            @elseif(isset($from) && isset($to))
              @if($from == $to)
                <div class="alert alert-success" role="alert">Thống kê sản phẩm bán chạy( ngày: <strong>{{$from}}</strong> )</div>
              @else
                <div class="alert alert-success" role="alert">Thống kê sản phẩm bán chạy( từ ngày: <strong>{{$from}}</strong> đến ngày: <strong>{{$to}}</strong> )</div>
              @endif
            @else
              <div class="alert alert-success" role="alert">Thống kê sản phẩm bán chạy(tính đến thời điểm hiện tại)</div>
            @endif

            <div>
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#reportCatProduct" aria-controls="reportCatProduct" role="tab" data-toggle="tab"><strong>Sản phẩm</strong></a></li>
                <li role="presentation"><a href="#reportCatOption" aria-controls="reportCatOption" role="tab" data-toggle="tab"><strong>Options</strong></a></li>    
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="reportCatProduct">
                  <div class="box-body table-responsive no-padding">                    
                    <table class="table table-hover" id="order-table">
                      <thead>
                      <tr>                                    
                        <th>Sản phẩm</th>
                        <th>Nhóm hàng</th>                  
                        <th>Số lượng</th>
                        <!-- <th>Đơn giá</th>
                        <th>option</th> -->
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                      </tr>
                      </thead>
                      <tbody>
                        @if(isset($listProduct) && isset($listOder) )
                            @foreach($listOder as $k => $v)
                              @foreach($listProduct as $key => $value)
                                @if( $v->product_id == $value->product_id )
                                  <tr>
                                    <td>{{$v->product_name}}</td>
                                    <td>{{$value->category_name}}</td>
                                    <td>{{$v->qtyTotal}}</td>
                                    <!-- <td>{{number_format($value->product_price, '0', ',', '.')}}</td>
                                    <td>{{number_format($v->priceOption, '0', ',', '.')}}</td> -->
                                    <td>{{number_format(($v->priceTotal-$v->priceOption), '0', ',', '.')}}</td>
                                    <td><span class="label label-success">Đang kinh doanh</span></td>
                                  </tr>
                                @endif
                              @endforeach

                              @if(!in_array($v->product_id,(array)$listIdProduct))
                                <tr>
                                  <td>{{$v->product_name}}</td>
                                  <td></td>
                                  <td>{{$v->qtyTotal}}</td>
                                  <!-- <td>{{number_format($value->product_price, '0', ',', '.')}}</td> -->
                                  <td>{{number_format(($v->priceTotal-$v->priceOption), '0', ',', '.')}}</td>
                                  <td><span class="label label-warning">Ngừng kinh doanh</span></td>
                                </tr>
                              @endif
                            @endforeach
                          <tr>
                            <td class="required" colspan="3"> <strong>Tổng tiền Option:</strong> </td>
                            <td class="required" ><strong>{{number_format($optionTotalPrice, '0', ',', '.')}}đ</strong></td>
                          </tr>
                          <tr>
                            <td class="required" colspan="3"> <strong>Tổng tiền </strong>(không bao gồm tiền nạp tài khoản và combo)<strong>:</strong> </td>
                            <td class="required" ><strong>{{number_format(($totalPrice - $totalTK - $totalCombo), '0', ',', '.')}}đ</strong></td>
                          </tr>
                          <tr>
                            <td class="required" colspan="3"> <strong>Tổng tiền:</strong> </td>
                            <td class="required" ><strong>{{number_format($totalPrice, '0', ',', '.')}}đ</strong></td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <div class="box-footer clearfix" id="pagination-link"></div>
                  <!-- /.box-body -->
                </div>
                <div role="tabpanel" class="tab-pane" id="reportCatOption">
                  <div class="box-body table-responsive no-padding">                    
                    <table class="table table-hover" id="order-table">
                      <thead>
                      <tr>                                    
                        <th>Options</th>                 
                        <th>Số lượng</th>
                        <!-- <th>Đơn giá</th> -->
                        <th>Thành tiền</th>
                        <th>Trạng thái</th>
                      </tr>
                      </thead>
                      <tbody>
                        @if(isset($listOption))
                          @foreach($listOption as $key2 => $value2)
                            @if(in_array($key2,$listIdOptions))
                                <tr>
                                  <td>{{$value2['name']}}</td>
                                  <td>{{$value2['qty']}}</td>
                                  <!-- <td>{{number_format($value2['price'], '0', ',', '.')}}</td> -->
                                  <!-- <td>{{number_format($value2['price']*$value2['qty'], '0', ',', '.')}}</td> -->
                                  <td>{{number_format($value2['total'], '0', ',', '.')}}</td>
                                  <td><span class="label label-success">Đang kinh doanh</span></td>
                                </tr>
                            @else
                              <tr>
                                  <td>{{$value2['name']}}</td>
                                  <td>{{$value2['qty']}}</td>
                                  <!-- <td>{{number_format($value2['price'], '0', ',', '.')}}</td> -->
                                  <!-- <td>{{number_format($value2['price']*$value2['qty'], '0', ',', '.')}}</td> -->
                                  <td>{{number_format($value2['total'], '0', ',', '.')}}</td>
                                  <td><span class="label label-warning">Ngừng kinh doanh</span></td>
                              </tr>
                            @endif
                          @endforeach
                          <tr>
                            <td class="required" colspan="2"> <strong>Tổng tiền Option:</strong> </td>
                            <td class="required" ><strong>{{number_format($optionTotalPrice, '0', ',', '.')}}đ</strong></td>
                          </tr>                          
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <div class="box-footer clearfix" id="pagination-link"></div>
                  <!-- /.box-body -->
                </div>
              </div>

            </div>
            
          </div>

          <!-- /.box -->
        </div>

      </div>

@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  {{ Html::script(asset('js/quan-datetimepicker.min.js')) }}
  <script type="text/javascript">
    $('.datepicker1').datetimepicker({
      autoclose: true
    });
    $('.datepicker2').datetimepicker({
      autoclose: true
    });
  </script>
@stop

