@extends('backend.layouts.master', ['page_title' => 'Thống kê theo ngày'])
@section ('title','Thống kê theo ngày')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
{{ Html::style(asset('css/quan-datetimepicker.min.css')) }}
{{ Html::style(asset('css/quan-statistic.css')) }}
<style>
  .order-option{background:#f1f2f2 ;color: red;}
  #label_search_day_hour{font-weight: 100;}
  .datetimepicker{ margin-top: 0px;}

  btn-day-details{ 
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
  <?php //echo '<pre>';print_r( getDays(8, 2016)); ?>
        @if (session('flash_message_succ') != '')
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
      @endif
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <div class="col-xs-12 col-md-12 no-padding">
                @if(isset($error_day))
                  <div class="alert alert-danger" role="alert">{{$error_day}}</div>
                @endif
                <form class="form-inline" action="{{ route('admin.statistic.statisticday') }}" method="get">
                  <div class="col-xs-12 col-md-12  no-padding">
                    @if(!empty(Request::input('search_day_hour')))
                      <div class="form-group" id="day_hour_from">
                        <input type="datetime" name="day_hour_from" class="form-control datetimepicker marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Ngày giờ(bắt đầu)" value="@if(!empty(Request::input('day_hour_from'))){!!Request::input('day_hour_from')!!}@endif">
                      </div>
                      <div class="form-group" id="day_hour_to">
                        <input type="datetime" name="day_hour_to" class="form-control datetimepicker marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Ngày giờ(kết thúc)" value="@if(!empty(Request::input('day_hour_to'))){!!Request::input('day_hour_to')!!}@endif">
                      </div>

                      <div class="form-group hide" id="day">
                        <input type="datetime" name="day" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))){!!Request::input('day')!!}@endif">
                      </div>
                      <div class="form-group hide" id="case">
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
                      <div class="col-xs-12 col-md-12 no-padding">
                        <div class="form-group">
                          <input type="checkbox" name="search_day_hour" value="1" checked id="search_day_hour"> <label for="search_day_hour" id="label_search_day_hour">Tìm kiếm theo ngày giờ</label>
                        </div>
                      </div>
                    @else
                      <div class="form-group hide" id="day_hour_from">
                        <input type="datetime" name="day_hour_from" class="form-control datetimepicker marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Ngày giờ(bắt đầu)" value="@if(!empty(Request::input('day_hour_from'))){!!Request::input('day_hour_from')!!}@endif">
                      </div>
                      <div class="form-group hide" id="day_hour_to">
                        <input type="datetime" name="day_hour_to" class="form-control datetimepicker marginBot5" data-date-format="dd-mm-yyyy hh:ii" id="" placeholder="Ngày giờ(kết thúc)" value="@if(!empty(Request::input('day_hour_to'))){!!Request::input('day_hour_to')!!}@endif">
                      </div>

                      <div class="form-group" id="day">                    
                        <input type="datetime" name="day" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))){!!Request::input('day')!!}@endif">
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
                      <div class="col-xs-12 col-md-12 no-padding">
                        <div class="form-group">
                          <input type="checkbox" name="search_day_hour" value="1" id="search_day_hour"> <label for="search_day_hour" id="label_search_day_hour">Tìm kiếm theo ngày giờ</label>
                        </div>
                      </div>
                    @endif
                    
                    <div class="form-group">
                      <select class="form-control borderRad4 marginBot5" name="order_status">
                        <option value="0" @if(isset($order_status) && $order_status == 0) selected @endif >--Trạng thái--</option>
                        <option value="1" @if(isset($order_status) && $order_status == 1) selected @endif >Đang xử lý</option>
                        <option value="2" @if(isset($order_status) && $order_status == 2) selected @endif >Đã thu tiền</option>
                        <option value="3" @if(isset($order_status) && $order_status == 3) selected @endif >Đã hoàn thành</option>
                        <option value="4" @if(isset($order_status) && ($order_status == 4 || $order_status == 5)) selected @endif >Đã hủy</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                    <a class="btn btn-success marginBot5" style="margin-left:2px;" href="{{ route('admin.statistic.exportpdf',['download'=>'pdf','day'=>Request::input('day'),'case'=>Request::input('case') ,'order_status'=>Request::input('order_status'),'search_day_hour'=>Request::input('search_day_hour'),'day_hour_from'=>Request::input('day_hour_from'),'day_hour_to'=>Request::input('day_hour_to')]) }}"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
                    <a class="btn btn-success marginBot5" style="margin-left:2px;" href="{{ route('admin.statistic.sendEmailNow',['download'=>'pdf','day'=>Request::input('day'),'case'=>Request::input('case') ,'order_status'=>Request::input('order_status'),'search_day_hour'=>Request::input('search_day_hour'),'day_hour_from'=>Request::input('day_hour_from'),'day_hour_to'=>Request::input('day_hour_to')]) }}"><i class="fa fa-send" aria-hidden="true"></i> Sent Mail</a>
                    {{ csrf_field() }}
                  </div>

                  <!-- <div class="col-xs-12 col-md-12 no-padding">
                    <div class="form-group">
                      <select class="form-control borderRad4" name="order_status">
                        <option value="0" @if(isset($order_status) && $order_status == 0) selected @endif >--Trạng thái--</option>
                        <option value="1" @if(isset($order_status) && $order_status == 1) selected @endif >Đang xử lý</option>
                        <option value="2" @if(isset($order_status) && $order_status == 2) selected @endif >Đã thu tiền</option>
                        <option value="3" @if(isset($order_status) && $order_status == 3) selected @endif >Đã hoàn thành</option>
                        <option value="4" @if(isset($order_status) && ($order_status == 4 || $order_status == 5)) selected @endif >Đã hủy</option>
                      </select>
                    </div>
                  </div> -->
                  <div class="clearfix"></div>
                  
                </form>
                  <br>

              </div>
              <div class="col-xs-12 col-md-12 pull-right no-padding">
                <!-- <div class="col-xs-4 col-sm-3 col-md-3 col-lg-2"></div> -->
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
                                <span>@if(isset($sumTotalSuccess)) {{number_format((float)($sumTotalSuccess-$totalTK-$totalCombo), 0, ',', '.')}} @else 0 @endif </span>
                                Dịch vụ
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-orange"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                <span>@if(isset($totalCombo)) {{number_format($totalCombo, 0, ',', '.')}} @else 0 @endif </span>
                                Combo
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-dollar"></i></span>
                            <div class="sm-st-info">
                                <span>@if(isset($totalTK)) {{number_format($totalTK, 0, ',', '.')}} @else 0 @endif </span>
                                Tài khoản
                            </div>
                            <i class="fa fa-check-square statistic_status status_success" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Đơn hàng hoàn thành"></i>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng số đơn hàng (hoàn thành): 
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
                    <span class="required">{{number_format((float)($sumTotalSuccess-$totalTK-$totalCombo), 0, ',', '.')}}đ</span>
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
                    <span class="required">{{number_format($totalTK, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                <div class="col-md-6">                  
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (combo): 
                    @if(isset($totalTK))
                    <span class="required">{{number_format($totalCombo, 0, ',', '.')}}đ</span>
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
                  <strong><span class="required">**</span>Tổng tiền: 
                    @if(isset($sumTotalAll))
                    <span class="required">{{number_format($sumTotalAll, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>
                
                
                <div class="col-md-12">
                  <br>
                  <p><strong>Lưu ý:</strong></p>
                  <p><i class="fa fa-check"></i> <span class="required"><strong>(*)</strong></span>: Đơn hàng hoàn thành</p>
                  <p><i class="fa fa-check"></i> <span class="required"><strong>(**)</strong></span>:Tất cả đơn hàng (hoàn thành + chưa hoàn thành)</p>
                </div> -->

              </div>

            </div>
            <!-- /.box-header -->
            @if(isset($day))
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày: <strong>{{$day}}</strong></div>
              @else
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày <strong>hôm nay</strong></div>
              @endif

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><strong>Đơn hàng của khách</strong></a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><strong>Đơn hàng của nhân viên</strong></a></li>
          </ul>

          <div class="tab-content">
            <!-- start tab #home -->
            <div role="tabpanel" class="tab-pane active" id="home">

              <div class="box-body table-responsive">
                <table class="table table-hover" id="order-table">
                  <thead>
                  <tr>                  
                    <th style="width:80px">ID</th>
                    <th style="width:150px;">Tên máy</th>
                    <th style="width:200px">Ngày</th>
                    <th>Chi tiết</th>
                    <th style="width:120px">Tổng cộng</th>
                    <th style="max-width:150px;min-width: 80px;">Lý do hủy</th>
                    <th style="width:150px">Trạng thái</th>
                  </tr>
                  </thead>
                  <tbody>

                    @if($status && isset($data) && count($data) >0)
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
                        <td>{{ $order->message_destroy }}</td>
                        <td>
                            @if($order->order_status == 1)
                              <a><span class="label label-warning">Đang xử lý</span></a>                      
                            @elseif($order->order_status == 2)
                              <a><span class="label label-success">Đã thu tiền</span></a>                        
                            @elseif($order->order_status == 3)
                              <a><span class="label label-success">Đã hoàn thành</span></a>                        
                            @elseif($order->order_status == 4)
                              <a><span class="label label-danger">Đã hủy</span></a>
                            @elseif($order->order_status == 5)
                              <a><span class="label label-danger">Đã hủy(hoàn trả)</span></a>
                            @endif
                        </td>
                      </tr>
                      @endforeach                    
                    @else
                      <!-- <div class="alert alert-danger" role="alert">Không có đơn hàng nào trong mục này.</div> -->
                    @endif
                  </tbody>
                </table>
              </div>
              <div class="box-footer clearfix" id="pagination-link">
                @if($status && isset($data) && count($data) >0)
                  {{-- $data->appends(Request::only(['day', 'case', 'order_status']))->links() --}}
                  {{ $data->setPath('getAjaxStatisticDay1')->appends(Request::all())->links() }}
                @endif
              </div>
              <!-- /.box-body -->
              </div><!-- end #home -->

              <div role="tabpanel" class="tab-pane" id="profile">
                <!-- Order of employee -->
          <div class="">
            <div class="box-header with-border">
              <div class="col-xs-12 col-md-5 no-padding">
                <!-- <h3 class="box-title"><strong>Đơn hàng của nhân viên</strong></h3> -->
                <!-- <form class="form-inline" action="{{ route('admin.statistic.statisticday') }}" method="get">
                  <div class="form-group">
                    <input type="datetime" name="day" required class="form-control datepicker" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))) {!!Request::input('day')!!} @endif">
                  </div>
                  <div class="form-group">
                    <select class="form-control borderRad4" name="case">
                      <option value="0">--Chọn ca--</option>
                      @foreach($schedule as $value)
                        <option @if(!empty(Request::input('case')) && Request::input('case') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}} ({{$value->time_start}} - {{$value->time_end}})</option>
                      @endforeach                      
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="form-control borderRad4" name="order_status">
                      <option value="0" @if(isset($order_status) && $order_status == 0) selected @endif >--Trạng thái--</option>
                      <option value="1" @if(isset($order_status) && $order_status == 1) selected @endif >Đang xử lý</option>
                      <option value="2" @if(isset($order_status) && $order_status == 2) selected @endif >Đã thu tiền</option>
                      <option value="3" @if(isset($order_status) && $order_status == 3) selected @endif >Đã hoàn thành</option>
                      <option value="4" @if(isset($order_status) && ($order_status == 4 || $order_status == 5)) selected @endif >Đã hủy</option>
                    </select>
                  </div>
                  <div class="clearfix"></div>
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  <a class="btn btn-success" style="margin-left:2px;" href="{{ route('admin.statistic.exportpdf',['download'=>'pdf','day'=>Request::input('day'),'case'=>Request::input('case') ,'order_status'=>Request::input('order_status')]) }}">Export PDF</a>
                  <a class="btn btn-success" style="margin-left:2px;" href="{{ route('admin.statistic.sendEmailNow',['download'=>'pdf','day'=>Request::input('day'),'case'=>Request::input('case') ,'order_status'=>Request::input('order_status')]) }}">Sent Mail</a>
                  {{ csrf_field() }}
                </form> -->
              </div>
              <div class="col-xs-12 col-md-7">
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng số đơn hàng (hoàn thành):
                    @if(isset($sumCountSuccess2))
                    <span class="required">{{$sumCountSuccess2}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">*</span>Tổng tiền (đơn hàng hoàn thành): 
                    @if(isset($sumTotalSuccess2))
                    <span class="required">{{number_format((float)($sumTotalSuccess2), 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>

                <!-- <div class="col-md-6">                  
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
                </div>
                <div class="col-md-6">
                  <strong>Tổng tiền Combo: 
                    @if(isset($totalTK))
                    <span class="required">{{number_format($totalCombo, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div> -->

                <div class="col-md-6">
                  <strong><span class="required">**</span>Tổng số đơn hàng: 
                    @if(isset($sumCountAll2))
                    <span class="required">{{$sumCountAll2}}</span>
                    @else
                    <span class="required">0</span>
                    @endif
                  </strong>
                </div>
                <div class="col-md-6">
                  <strong><span class="required">**</span>Tổng tiền: 
                    @if(isset($sumTotalAll2))
                    <span class="required">{{number_format($sumTotalAll2, 0, ',', '.')}}đ</span>
                    @else
                    <span class="required">0 đ</span>
                    @endif
                  </strong>
                </div>

                <!-- <div class="col-md-6"></div>
                <div class="col-md-6">
                  <br>
                  <p><strong>Lưu ý:</strong></p>
                  <p><span class="required">(*)</span> tổng tiền dịch vụ (không bao gồm tiền nạp tài khoản và combo)</p>
                  <p><span class="required">(**)</span> tổng tiền dịch vụ (bao gồm tất cả các đơn hàng)</p>
                </div> -->

              </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <!-- @if(isset($day))
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày: <strong>{{$day}}</strong></div>
              @else
              <div class="alert alert-success" role="alert">Danh sách đơn hàng trong ngày <strong>hôm nay</strong></div>
              @endif -->
              <table class="table table-hover" id="order-employee">
                <thead>
                <tr>                  
                  <th style="width:80px">ID</th>
                  <th style="width:150px;">Tên máy</th>
                  <th style="width:200px">Ngày</th>
                  <th>Chi tiết</th>
                  <th style="width:120px">Tổng cộng</th>
                  <th style="max-width:150px;min-width: 80px;">Lý do hủy</th>
                  <th style="width:150px">Trạng thái</th>
                </tr>
                </thead>
                <tbody>

                  @if(isset($data2) && count($data2) > 0)
                    @foreach($data2 as $order2)
                    <tr>
                      <td>{{$order2->order_id}}</td>
                      <td>{{$order2->client_name}}</td>
                      <td>{{$order2->order_create_time}}</td>
                      <td>
                            
                            <div class="row">
                              <div class="col-sm-3">&nbsp;</div>
                              <div class="col-sm-3">Số lượng</div>
                              <div class="col-sm-3">Đơn giá</div>
                              <div class="col-sm-3">Thành tiền</div>
                            </div>
                            
                              @for($i=0; $i < count($order2->name_group); $i++)
                              <div class="row">                              
                              <div class="col-sm-3">
                                {{ $order2->name_group[$i] }}
                                <ol class="order-option">
                                    @if(!empty($order2->option[$i]))
                                      @foreach($order2->option[$i] as $key => $val)
                                        <li>{{$val['1']}}({{number_format($val['2'], 0, ',', '.')}})({{$val['3']}})</li>
                                      @endforeach
                                    @endif
                                </ol>
                              </div>
                              <div class="col-sm-3">{{ $order2->qty_group[$i] }}</div>
                              <div class="col-sm-3">{{ number_format((float)$order2->price_group[$i],0,",",".") }}</div>                              
                              <div class="col-sm-3">{{ number_format((float)($order2->qty_group[$i]*$order2->price_group[$i]),0,",",".") }}</div>

                              </div>
                              @endfor
                          
                      </td>
                      <td>{{ number_format($order2->order_price,0,",",".") }}</td>
                      <td>{{ $order2->message_destroy }}</td>
                      <td>
                          @if($order2->order_status == 1)
                            <a><span class="label label-warning">Đang xử lý</span></a>
                          @elseif($order2->order_status == 2)
                            <a><span class="label label-success">Đã thu tiền</span></a>
                          @elseif($order2->order_status == 3)
                            <a><span class="label label-success">Đã hoàn thành</span></a>
                          @elseif($order2->order_status == 4)
                            <a><span class="label label-danger">Đã hủy</span></a>
                          @elseif($order2->order_status == 5)
                            <a><span class="label label-danger">Đã hủy(hoàn trả)</span></a>
                          @endif
                      </td>
                    </tr>
                    @endforeach                    
                  @else
                    <!-- <div class="alert alert-warning" role="alert">Không có đơn hàng nào trong mục này.</div> -->
                  @endif
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix" id="pagination-link-2">
              @if(isset($data2) && count($data2) > 0)
                {{ $data2->setPath('getAjaxStatisticDay2')->appends(Request::all())->links() }}
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
              </div><!-- end #profile -->

              </div><!-- end content tab -->
          </div>
          <!-- /.box -->

          

        </div>

      </div>

@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  {{ Html::script(asset('js/quan-datetimepicker.min.js')) }}
  <script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true
    });
    
    $('.datetimepicker').datetimepicker({
      autoclose: true
    });
    $('.datetimepicker-minutes').hide();
    $.urlParam = function(url,name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
        //var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
           return null;
        }
        else{
           return results[1] || 0;
        }
    }

    $(document).on('click','#pagination-link .pagination a', function(e){
        e.preventDefault();
        var page_url = $(this).attr('href');
        var day =  $.urlParam(page_url,'day');
        var case2 =  $.urlParam(page_url,'case');
        var order_status =  $.urlParam(page_url,'order_status');
        var page =  $.urlParam(page_url,'page');

        var search_day_hour =  $.urlParam(page_url,'search_day_hour');
        var day_hour_from =  $.urlParam(page_url,'day_hour_from');
        var day_hour_to =  $.urlParam(page_url,'day_hour_to');

        $.ajax({
            url: '{!! route('admin.statistic.employee_day1') !!}',
            type: 'GET',
            data:{ 'page' : page,'day' : day,'case' : case2,'order_status' : order_status,'search_day_hour' : search_day_hour,'day_hour_from' : day_hour_from,'day_hour_to' : day_hour_to
            },
            dataType: 'json',
        }).done(function(data){
            $('#order-table tbody').html(data.html);
            $('#pagination-link').html(data.pagi);
        });
    });

    $(document).on('click','#pagination-link-2 .pagination a', function(e){
        e.preventDefault();
        var page_url = $(this).attr('href');
        var day =  $.urlParam(page_url,'day');
        var case2 =  $.urlParam(page_url,'case');
        var order_status =  $.urlParam(page_url,'order_status');
        var page =  $.urlParam(page_url,'page');

        var search_day_hour =  $.urlParam(page_url,'search_day_hour');
        var day_hour_from =  $.urlParam(page_url,'day_hour_from');
        var day_hour_to =  $.urlParam(page_url,'day_hour_to');

        $.ajax({
            url: '{!! route('admin.statistic.employee_day2') !!}',
            type: 'GET',
            data:{ 'page' : page,'day' : day,'case' : case2,'order_status' : order_status,'search_day_hour' : search_day_hour,'day_hour_from' : day_hour_from,'day_hour_to' : day_hour_to,
             },
            dataType: 'json',
        }).done(function(data){
            $('#order-employee tbody').html(data.html);
            $('#pagination-link-2').html(data.pagi);
        });
    });

//search for day & hour || day & case
$('#search_day_hour').on('click', function(){
  if($('#search_day_hour').prop('checked')) {
        $('#day_hour_from').removeClass('hide');
        $('#day_hour_to').removeClass('hide');
        $('#day').addClass('hide');
        $('#case').addClass('hide');
    } else {
        $('#day_hour_from').addClass('hide');
        $('#day_hour_to').addClass('hide');
        $('#day').removeClass('hide');
        $('#case').removeClass('hide');
    }
});

  </script>
@stop

