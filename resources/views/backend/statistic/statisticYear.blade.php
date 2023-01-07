@extends('backend.layouts.master', ['page_title' => 'Thống kê theo năm'])
@section ('title','Thống kê theo năm')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
{{ Html::style(asset('css/quan-statistic.css')) }}
<style>
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
                <form class="form-inline" action="{{ route('admin.statistic.year') }}" method="get">
                  <div class="form-group">
                    <select name="year" id="" class="form-control borderRad4 marginBot5">
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
                  <div class="form-group" id="case">
                      <select class="form-control borderRad4 marginBot5" name="case">
                        <option value="0">--Chọn ca--</option>
                        @foreach($schedule as $value)
                          <?php
                            $key = array_search($value->time_start, $timeInADay);
                          ?>
                          <option @if(!empty(Request::input('case')) && Request::input('case') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}} (@if(isset($key)){{$timeInADay_start[$key]}}@else{{$value->time_start}}@endif - {{$value->time_end}})</option>
                        @endforeach
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                  {{ csrf_field() }}
                </form>
                <br>
              </div>

              <div class="col-xs-12 col-md-12 no-padding">
                <div class="row" style="margin-bottom:5px;">
                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green"><i class="fa fa-shopping-cart"></i></span>
                            <div class="sm-st-info">
                                <span>@if(isset($sumCountSuccess)) {{$sumCountSuccess}} @else 0 @endif </span>
                                Tổng số đơn( hoàn thành )
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                <span>@if(isset($sumTotalSuccess)){{number_format((float)($sumTotalSuccess), 0, ',', '.')}}@else 0 @endif </span>
                                Tổng tiền( hoàn thành )
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-shopping-cart"></i></span>
                            <div class="sm-st-info">
                                <span>@if(isset($sumCountAll)) {{$sumCountAll}} @else 0 @endif </span>
                                Tổng số đơn( toàn bộ )
                            </div>
                            <i class="fa fa-window-close statistic_status status_warning" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Toàn bộ đơn hàng"></i>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                      <div class="sm-st clearfix">
                          <span class="sm-st-icon st-blue"><i class="fa fa-dollar"></i></span>
                          <div class="sm-st-info">
                              <span>@if(isset($sumTotalAll)){{number_format((float)($sumTotalAll), 0, ',', '.')}}@else 0 @endif </span>
                              Tổng tiền( toàn bộ )
                          </div>
                          <i class="fa fa-window-close statistic_status status_warning" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Toàn bộ đơn hàng"></i>
                      </div>
                    </div>

                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                @if(isset($sumTotalSuccess))
                                    @if($checkCase)
                                      <span>{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo-$totalTK3-$totalCombo3), 0, ',', '.') !!}</span>
                                    @else
                                      <span>{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo), 0, ',', '.') !!}</span>
                                    @endif
                                @else
                                <span>0 đ</span>
                                @endif
                                Dịch vụ
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-orange"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                @if(isset($totalCombo))
                                  @if($checkCase && isset($totalCombo3))
                                    <span>{{number_format($totalCombo+$totalCombo3, 0, ',', '.')}}đ</span>
                                  @else
                                    <span>{{number_format($totalCombo, 0, ',', '.')}}đ</span>
                                  @endif
                                @else
                                <span>0 đ</span>
                                @endif
                                Combo
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                @if(isset($totalTK))
                                  @if($checkCase && isset($totalTK3))
                                    <span>{{number_format($totalTK+$totalTK3, 0, ',', '.')}}đ</span>
                                  @else
                                    <span>{{number_format($totalTK, 0, ',', '.')}}đ</span>
                                  @endif
                                @else
                                <span>0 đ</span>
                                @endif
                                Tài khoản
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng số đơn hàng:
                    @if(isset($sumCountSuccess))
                    <span class="required">{{$sumCountSuccess}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (dịch vụ):
                    @if(isset($sumTotalSuccess))
                        @if($checkCase)
                          <span class="required">{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo-$totalTK3-$totalCombo3), 0, ',', '.') !!}</span>
                        @else
                          <span class="required">{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo), 0, ',', '.') !!}</span>
                        @endif
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6">                  
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (nạp tài khoản): 
                    @if(isset($totalTK))
                      @if($checkCase && isset($totalTK3))
                        <span class="required">{{number_format($totalTK+$totalTK3, 0, ',', '.')}}đ</span>
                      @else
                        <span class="required">{{number_format($totalTK, 0, ',', '.')}}đ</span>
                      @endif
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6">                  
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (combo): 
                    @if(isset($totalCombo))
                      @if($checkCase && isset($totalCombo3))
                        <span class="required">{{number_format($totalCombo+$totalCombo3, 0, ',', '.')}}đ</span>
                      @else
                        <span class="required">{{number_format($totalCombo, 0, ',', '.')}}đ</span>
                      @endif
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6">                  
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (DV+TK+CB): 
                    @if(isset($totalTK))
                    <span class="required">{{number_format($sumTotalSuccess, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6">
                  <strong><span class="required">**</span>Tổng số đơn hàng:
                    @if(isset($sumCountAll))
                    <span class="required">{{$sumCountAll}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">**</span>Tổng tiền (tất cả): 
                    @if(isset($sumTotalAll))
                    <span class="required">{{number_format($sumTotalAll, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <br>
                  <p><strong>Lưu ý:</strong></p>
                  <p><i class="fa fa-check"></i> <span class="required"><strong>(*)</strong></span>: Đơn hàng hoàn thành</p>
                  <p><i class="fa fa-check"></i> <span class="required"><strong>(**)</strong></span>:Tất cả đơn hàng (hoàn thành + chưa hoàn thành)</p>
                </div> -->

              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">             
              <div class="alert alert-success" role="alert">Thống kê doanh số năm: <strong>{!! $year !!}</strong></div>
              
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><strong>Đơn hàng của khách</strong></a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><strong>Đơn hàng của nhân viên</strong></a></li>
              </ul>

          <div class="tab-content">
            <!-- start tab #home -->
            <div role="tabpanel" class="tab-pane active" id="home">
              <table class="table table-hover" id="order-table">
                <thead>
                  <tr>
                    <th>Tháng</th>
                    <th>Tổng số đơn</th>
                    <th>Đã hoàn thành</th>
                    <th>Đã hủy</th>
                    <th>Đang xử lý</th>
                    <th>Đã thu tiền</th>
                    <th><span class="required">*</span>Tổng cộng(dịch vụ)</th>
                    <th><span class="required">*</span>Tổng cộng(DV+TK+CB)</th>
                    <th>Chi tiết</th>
                  </tr>
                </thead>
                <tbody>
                @if($case == 0)
                  @if(!empty($data) && $status)
                    @foreach($data as $key => $value)
                    <tr>
                        @foreach($data2 as $key2 => $value2)
                            @if($value2->year == $value->year)
                                @if(($value2->month-1) == $value->month )                                  
                                  <?php
                                      $value->sumCount += $value2->sumCount;
                                      $value->sumFinish += $value2->sumFinish;
                                      $value->sumCancel += $value2->sumCancel;
                                      $value->sumWait += $value2->sumWait;
                                      $value->sumPay += $value2->sumPay;
                                      $value->sumFinishPrice += $value2->sumFinishPrice;
                                      $value->sumTotal += $value2->sumTotal;
                                  ?>
                                @endif
                                @if(($value2->month) == $value->month && $value->month != 1)
                                  <?php
                                      $value->sumCount -= $value2->sumCount;
                                      $value->sumFinish -= $value2->sumFinish;
                                      $value->sumCancel -= $value2->sumCancel;
                                      $value->sumWait -= $value2->sumWait;
                                      $value->sumPay -= $value2->sumPay;
                                      $value->sumFinishPrice -= $value2->sumFinishPrice;
                                      $value->sumTotal -= $value2->sumTotal;
                                  ?>
                                @endif                                
                            @endif
                            @if(($value2->year-1) == $value->year && $value2->month == 1 && $value->month == 12)
                              <?php
                                  $value->sumCount += $value2->sumCount;
                                  $value->sumFinish += $value2->sumFinish;
                                  $value->sumCancel += $value2->sumCancel;
                                  $value->sumWait += $value2->sumWait;
                                  $value->sumPay += $value2->sumPay;
                                  $value->sumFinishPrice += $value2->sumFinishPrice;
                                  $value->sumTotal += $value2->sumTotal;
                              ?>
                            @endif
                        @endforeach
                          @if($value->year == $year)
                          <td>Tháng {{$value->month}}/{{$year}}</td>
                          <td>{!! $value->sumCount !!}</td>
                          <td>{!! $value->sumFinish !!}</td>
                          <td>{!! $value->sumCancel !!}</td>
                          <td>{!! $value->sumWait !!}</td>
                          <td>{!! $value->sumPay !!}</td>
                          <td>
                            <?php
                                if(count($taikhoan2) > 0){
                                  foreach( $taikhoan2 as $tkKey => $tkVal ){
                                    if(($tkKey-1) == $value->month ){
                                      if(isset($taikhoan[$value->month])){
                                        $taikhoan[$value->month] += $tkVal;
                                      }else{
                                        $taikhoan[$value->month] = $tkVal;
                                      }
                                    }
                                    if(($tkKey) == $value->month && $value->month != 1){                                      
                                      if(isset($taikhoan[$value->month])){
                                        $taikhoan[$value->month] -= $tkVal;
                                      }else{
                                        $taikhoan[$value->month] = 0;
                                      }
                                    }
                                  }
                                }
                                if(count($combo2) > 0){
                                  foreach( $combo2 as $cbKey => $cbVal ){
                                    if(($cbKey-1) == $value->month ){                                      
                                      if(isset($taikhoan[$value->month])){
                                        $combo[$value->month] += $cbVal;
                                      }else{
                                        $combo[$value->month] = $cbVal;
                                      }
                                    }
                                    if(($cbKey) == $value->month && $value->month != 1){                                      
                                      if(isset($taikhoan[$value->month])){
                                        $combo[$value->month] -= $cbVal;
                                      }else{
                                        $combo[$value->month] = 0;
                                      }
                                    }
                                  }
                                }
                            ?>
                            {!! number_format((float)($value->sumFinishPrice - (isset($taikhoan[$value->month]) ? $taikhoan[$value->month] : 0) - (isset($combo[$value->month]) ? $combo[$value->month] : 0)), 0, ',', '.') !!}</td>
                            <td>{!! number_format($value->sumFinishPrice, 0, ',', '.') !!}</td>
                          <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                        @endif
                      @endforeach
                    </tr>                
                  @else
                    <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                  @endif
                @else <!-- case != 0 -->
                  @if(!$checkCase)
                    @if(!empty($data) && $status)
                      @foreach($data as $key => $value)
                      <tr>
                            <td>Tháng {{$value->month}}/{{$year}}</td>
                            <td>{!! $value->sumCount !!}</td>
                            <td>{!! $value->sumFinish !!}</td>
                            <td>{!! $value->sumCancel !!}</td>
                            <td>{!! $value->sumWait !!}</td>
                            <td>{!! $value->sumPay !!}</td>
                            <td>
                              {!! number_format((float)($value->sumFinishPrice - (isset($taikhoan[$value->month]) ? $taikhoan[$value->month] : 0) - (isset($combo[$value->month]) ? $combo[$value->month] : 0)), 0, ',', '.') !!}
                            </td>
                            <td>{!! number_format($value->sumFinishPrice, 0, ',', '.') !!}</td>
                            <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                        @endforeach
                      </tr>                
                    @else
                      <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                    @endif
                  @else <!-- checkCase == true -->                  
                    @if(!empty($data) && $status)
                      @foreach($data as $key => $value)
                      <tr>
                          @foreach($data3 as $key3 => $value3)
                            <?php
                              if($value3->year == $year && $value3->month == $value->month){
                                $value->sumCount += $value3->sumCount;
                                $value->sumFinish += $value3->sumFinish;
                                $value->sumCancel += $value3->sumCancel;
                                $value->sumWait += $value3->sumWait;
                                $value->sumPay += $value3->sumPay;
                                $value->sumFinishPrice += $value3->sumFinishPrice;
                                $value->sumTotal += $value3->sumTotal;
                              }
                            ?>
                          @endforeach

                          @foreach($data2 as $key2 => $value2)
                            <?php
                                if($value2->year == $year && $value2->month == $value->month){
                                  $value->sumCount -= $value2->sumCount;
                                  $value->sumFinish -= $value2->sumFinish;
                                  $value->sumCancel -= $value2->sumCancel;
                                  $value->sumWait -= $value2->sumWait;
                                  $value->sumPay -= $value2->sumPay;
                                  $value->sumFinishPrice -= $value2->sumFinishPrice;
                                  $value->sumTotal -= $value2->sumTotal;
                                }
                                if( ( $value2->year == $year && ($value2->month-1) == $value->month ) || ( ($value2->year-1) == $year && $value->month == 12 && $value2->month == 1) ){
                                  $value->sumCount += $value2->sumCount;
                                  $value->sumFinish += $value2->sumFinish;
                                  $value->sumCancel += $value2->sumCancel;
                                  $value->sumWait += $value2->sumWait;
                                  $value->sumPay += $value2->sumPay;
                                  $value->sumFinishPrice += $value2->sumFinishPrice;
                                  $value->sumTotal += $value2->sumTotal;
                                }

                            ?>
                          @endforeach
                        
                            <td>Tháng {{$value->month}}/{{$year}}</td>
                            <td>{!! $value->sumCount !!}</td>
                            <td>{!! $value->sumFinish !!}</td>
                            <td>{!! $value->sumCancel !!}</td>
                            <td>{!! $value->sumWait !!}</td>
                            <td>{!! $value->sumPay !!}</td>
                            <td>
                              <?php
                                  // TÀI kHOAN
                                  if(count($taikhoan3) > 0){
                                    foreach( $taikhoan3 as $tkKey3 => $tkVal3 ){
                                      if($tkKey3 == $value->month){
                                        if(isset($taikhoan[$value->month])){
                                          $taikhoan[$value->month] += $tkVal3;
                                        }else{
                                          $taikhoan[$value->month] = $tkVal3;
                                        }
                                      }
                                    }
                                  }
                                  if(count($taikhoan2) > 0){
                                    foreach( $taikhoan2 as $tkKey2 => $tkVal2 ){                                      
                                      if( (($tkKey2-1) == $value->month && $value->month != 1) || ($value->month == 12 && $tkKey2 == 1) ){
                                        if(isset($taikhoan[$value->month])){
                                          $taikhoan[$value->month] += $tkVal2;
                                        }
                                      }
                                      if($tkKey2 == $value->month && $value->month != 1){
                                        if(isset($taikhoan[$value->month])){
                                          $taikhoan[$value->month] -= $tkVal2;
                                        }
                                      }
                                    }
                                  }

                                  // COMBO
                                  if(count($combo3) > 0){
                                    foreach( $combo3 as $cbKey3 => $cbVal3 ){
                                      if($cbKey3 == $value->month){
                                        if(isset($combo[$value->month])){
                                          $combo[$value->month] += $cbVal3;
                                        }else{
                                          $combo[$value->month] = $cbVal3;
                                        }
                                      }
                                    }
                                  }
                                  if(count($combo2) > 0){
                                    foreach( $combo2 as $cbKey2 => $cbVal2 ){
                                      if( (($cbKey2-1) == $value->month && $value->month != 1) || ($value->month == 12 && $cbKey2 == 1)){
                                        if(isset($combo[$value->month])){
                                          $combo[$value->month] += $cbVal2;
                                        }
                                      }
                                      if($cbKey2 == $value->month && $value->month != 1){
                                        if(isset($combo[$value->month])){
                                          $combo[$value->month] -= $cbVal2;
                                        }
                                      }
                                    }
                                  }

                              ?>
                              
                              {!! number_format((float)($value->sumFinishPrice - (isset($taikhoan[$value->month]) ? $taikhoan[$value->month] : 0) - (isset($combo[$value->month]) ? $combo[$value->month] : 0)), 0, ',', '.') !!}
                              </td>
                              <td>{!! number_format($value->sumFinishPrice, 0, ',', '.') !!}</td>
                            <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                        @endforeach
                      </tr>                
                    @else
                      <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                    @endif
                  @endif
                @endif

                  <tr>
                    <td><strong><span class="required">Tổng cộng</span></strong></td>
                    <td><strong>
                      @if(isset($sumCountAll))
                      <span class="required">{!! $sumCountAll !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountSuccess))
                      <span class="required">{!! $sumCountSuccess !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountCancel))
                      <span class="required">{!! $sumCountCancel !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountWait))
                      <span class="required">{!! $sumCountWait !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountPay))
                      <span class="required">{!! $sumCountPay !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumTotalSuccess))
                        @if($checkCase)
                          <span class="required">{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo-$totalTK3-$totalCombo3), 0, ',', '.') !!}</span>
                        @else
                          <span class="required">{!! number_format((float)($sumTotalSuccess-$totalTK-$totalCombo), 0, ',', '.') !!}</span>
                        @endif
                      @else
                      <span class="required">0 đ</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumTotalAll))
                      <span class="required">{!! number_format($sumTotalSuccess, 0, ',', '.') !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong></strong></td>
                  </tr>

                </tbody>

                <tfoot>
                  <tr>
                    <th>Tháng</th>
                    <th>Tổng số đơn</th>
                    <th>Đã hoàn thành</th>
                    <th>Đã hủy</th>
                    <th>Đang xử lý</th>
                    <th>Đã thu tiền</th>
                    <th><span class="required">*</span>Tổng cộng(dịch vụ)</th>
                    <th><span class="required">*</span>Tổng cộng(DV+TK+CB)</th>
                    <th>Chi tiết</th>
                  </tr>
                </tfoot>

              </table>
          </div>
          <!-- end tab #home -->

          <!-- start tab #profile -->
            <div role="tabpanel" class="tab-pane" id="profile">
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Tổng số đơn</th>
                    <th>Đã hoàn thành</th>
                    <th>Đã hủy</th>
                    <th>Đang xử lý</th>
                    <th>Đã thu tiền</th>
                    <th><span class="required">*</span>Tổng cộng</th>
                    <th><span class="required">**</span>Tổng cộng</th>
                    <th>Chi tiết</th>
                  </tr>
                </thead>
                <tbody>
                @if($case == 0)
                  @if(!empty($data) && $status)
                    @foreach($data as $key => $value)
                    <tr>
                        @foreach($data2 as $key2 => $value2)
                            @if($value2->year == $value->year)
                                @if(($value2->month-1) == $value->month )                                  
                                  <?php
                                      $value->sumCount2 += $value2->sumCount2;
                                      $value->sumFinish2 += $value2->sumFinish2;
                                      $value->sumCancel2 += $value2->sumCancel2;
                                      $value->sumWait2 += $value2->sumWait2;
                                      $value->sumPay2 += $value2->sumPay2;
                                      $value->sumFinishPrice2 += $value2->sumFinishPrice2;
                                      $value->sumTotal2 += $value2->sumTotal2;
                                  ?>
                                @endif
                                @if(($value2->month) == $value->month && $value->month != 1)
                                  <?php
                                      $value->sumCount2 -= $value2->sumCount2;
                                      $value->sumFinish2 -= $value2->sumFinish2;
                                      $value->sumCancel2 -= $value2->sumCancel2;
                                      $value->sumWait2 -= $value2->sumWait2;
                                      $value->sumPay2 -= $value2->sumPay2;
                                      $value->sumFinishPrice2 -= $value2->sumFinishPrice2;
                                      $value->sumTotal2 -= $value2->sumTotal2;
                                  ?>
                                @endif
                                
                            @endif
                        @endforeach
                      
                          <td>Tháng {{$value->month}}/{{$year}}</td>
                          <td>{!! $value->sumCount2 !!}</td>
                          <td>{!! $value->sumFinish2 !!}</td>
                          <td>{!! $value->sumCancel2 !!}</td>
                          <td>{!! $value->sumWait2 !!}</td>
                          <td>{!! $value->sumPay2 !!}</td>
                          <td>
                            {!! number_format($value->sumFinishPrice2, 0, ',', '.') !!}</td>
                            <td>{!! number_format($value->sumTotal2, 0, ',', '.') !!}</td>
                          <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                      @endforeach
                    </tr>                
                  @else
                    <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                  @endif
                @else
                  @if(!$checkCase)
                    @if(!empty($data) && $status)
                      @foreach($data as $key => $value)
                      <tr>
                            <td>Tháng {{$value->month}}/{{$year}}</td>
                            <td>{!! $value->sumCount2 !!}</td>
                            <td>{!! $value->sumFinish2 !!}</td>
                            <td>{!! $value->sumCancel2 !!}</td>
                            <td>{!! $value->sumWait2 !!}</td>
                            <td>{!! $value->sumPay2 !!}</td>
                            <td>{!! number_format($value->sumFinishPrice2, 0, ',', '.') !!}</td>
                            <td>{!! number_format($value->sumTotal2, 0, ',', '.') !!}</td>
                            <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                        @endforeach
                      </tr>                
                    @else
                      <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                    @endif
                  @else <!-- checkCase == true -->                  
                    @if(!empty($data) && $status)
                      @foreach($data as $key => $value)
                      <tr>
                          @foreach($data3 as $key3 => $value3)
                            <?php
                              if($value3->year == $year && $value3->month == $value->month){
                                $value->sumCount2 += $value3->sumCount2;
                                $value->sumFinish2 += $value3->sumFinish2;
                                $value->sumCancel2 += $value3->sumCancel2;
                                $value->sumWait2 += $value3->sumWait2;
                                $value->sumPay2 += $value3->sumPay2;
                                $value->sumFinishPrice2 += $value3->sumFinishPrice2;
                                $value->sumTotal2 += $value3->sumTotal2;
                              }
                            ?>
                          @endforeach

                          @foreach($data2 as $key2 => $value2)
                            <?php
                                if($value2->year == $year && $value2->month == $value->month){
                                  $value->sumCount2 -= $value2->sumCount2;
                                  $value->sumFinish2 -= $value2->sumFinish2;
                                  $value->sumCancel2 -= $value2->sumCancel2;
                                  $value->sumWait2 -= $value2->sumWait2;
                                  $value->sumPay2 -= $value2->sumPay2;
                                  $value->sumFinishPrice2 -= $value2->sumFinishPrice2;
                                  $value->sumTotal2 -= $value2->sumTotal2;
                                }
                                if( ( $value2->year == $year && ($value2->month-1) == $value->month ) || ( ($value2->year-1) == $year && $value->month == 12 && $value2->month == 1) ){
                                  $value->sumCount2 += $value2->sumCount2;
                                  $value->sumFinish2 += $value2->sumFinish2;
                                  $value->sumCancel2 += $value2->sumCancel2;
                                  $value->sumWait2 += $value2->sumWait2;
                                  $value->sumPay2 += $value2->sumPay2;
                                  $value->sumFinishPrice2 += $value2->sumFinishPrice2;
                                  $value->sumTotal2 += $value2->sumTotal2;
                                }

                            ?>
                          @endforeach
                        
                            <td>Tháng {{$value->month}}/{{$year}}</td>
                            <td>{!! $value->sumCount2 !!}</td>
                            <td>{!! $value->sumFinish2 !!}</td>
                            <td>{!! $value->sumCancel2 !!}</td>
                            <td>{!! $value->sumWait2 !!}</td>
                            <td>{!! $value->sumPay2 !!}</td>
                            <td>
                              {!! number_format($value->sumFinishPrice2, 0, ',', '.') !!}</td>
                            <td>{!! number_format($value->sumTotal2, 0, ',', '.') !!}</td>
                            <td><a class="btn-day-details" href="{{ route('admin.statistic.month', ['year' => $year, 'month' => $value->month, 'case' => $case]) }}">Chi tiết <i class="glyphicon glyphicon-chevron-right"></i></a></td>
                        @endforeach
                      </tr>                
                    @else
                      <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div>
                    @endif
                  @endif
                @endif

                  <tr>
                    <td><strong><span class="required">Tổng cộng</span></strong></td>
                    <td><strong>
                      @if(isset($sumCountAll2))
                      <span class="required">{!! $sumCountAll2 !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountSuccess2))
                      <span class="required">{!! $sumCountSuccess2 !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountCancel2))
                      <span class="required">{!! $sumCountCancel2 !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountWait2))
                      <span class="required">{!! $sumCountWait2 !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumCountPay2))
                      <span class="required">{!! $sumCountPay2 !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumTotalSuccess2))
                      <span class="required">{!! number_format($sumTotalSuccess2, 0, ',', '.') !!}</span>
                      @else
                      <span class="required">0 đ</span>
                      @endif
                    </strong></td>
                    <td><strong>
                      @if(isset($sumTotalAll2))
                      <span class="required">{!! number_format($sumTotalAll2, 0, ',', '.') !!}</span>
                      @else
                      <span class="required">0</span>
                      @endif
                    </strong></td>
                    <td><strong></strong></td>
                  </tr>

                </tbody>

                <tfoot>
                  <tr>
                    <th>Tháng</th>
                    <th>Tổng số đơn</th>
                    <th>Đã hoàn thành</th>
                    <th>Đã hủy</th>
                    <th>Đang xử lý</th>
                    <th>Đã thu tiền</th>
                    <th><span class="required">*</span>Tổng cộng</th>
                    <th><span class="required">**</span>Tổng cộng</th>
                    <th>Chi tiết</th>
                  </tr>
                </tfoot>

              </table>
          </div>
          <!-- end tab #profile -->

        </div>  
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

