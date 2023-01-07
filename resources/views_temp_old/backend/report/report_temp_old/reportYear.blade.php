@extends('backend.layouts.master', ['page_title' => 'Báo cáo theo năm'])
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
              <div class="col-xs-12 col-md-4">
                <form class="form-inline" action="{{ route('admin.report.year') }}" method="get">
                  <div class="form-group">
                    <select name="year" id="" class="form-control">
                      <option value="0">--Chọn năm--</option>
                      <?php
                        for($i=date("Y")-2;$i<=date("Y");$i++) {
                           if (!empty(Request::input('year'))) {
                              $sel = ($i == Request::input('year')) ? 'selected' : '';
                            }else{
                              $sel = ($i == date('Y')) ? 'selected' : '';
                            }    
                            echo "<option value=".$i." ".$sel.">".$i."</option>";  // here I have changed      
                        }
                        ?>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  {{ csrf_field() }}
                </form>
              </div>
              <div class="col-xs-12 col-md-8">
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
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong năm: {{$year}}</div>              
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>                  
                  <th>Tháng</th>
                  <th>Tổng số đơn hàng</th>                  
                  <th>Số đơn hàng đã hoàn thành</th>
                  <th>Số đơn hàng đã hủy</th>
                  <th>Số đơn hàng đang xử lý</th>  
                  <th>Tổng cộng</th>
                  <th>Chi tiết</th>
                </tr>
                </thead>
                <tbody>

                  @if(!empty($data) && $status)
                    @for( $i = 1; $i <= 12; $i++ )
                    <tr>
                      <td>Tháng {{$i}}/{{$year}}</td>
                      @foreach($data as $key => $value)             
                        @if( $i == $value->month )
                          <td>{{$value->sumCount}}</td>
                          <td>{{$value->sumFinish}}</td>
                          <td>{{$value->sumCancel}}</td>
                          <td>{{$value->sumWait+$value->sumPay}}</td>
                          <td>{{number_format($value->sumTotal, 0, ',', '.')}}</td>
                          <td><a class="btn-day-details" href="{{ route('admin.report.month', ['year' => $year, 'month' => $i]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>                       
                        @endif
                      @endforeach
                    </tr>
                    @endfor
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

