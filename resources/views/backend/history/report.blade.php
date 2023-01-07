@extends('backend.layouts.master',['page_title'=>'Thống kê thời gian trung bình'])
@section ('title','Thời gian trung bình xử lý đơn hàng')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
	<div class="box box-primary">
            <div class="box-primary">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div> -->
                    <form class="form-inline" action="" method="get">
                       <div class="form-group">
                        <label for="day_from">Từ ngày : </label>
                        <input type="datetime" name="day_from" class="form-control datepicker  marginBot5" required data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))) {!!Request::input('day_from')!!} @endif">
                      </div>
                      <div class="form-group">
                        <label for="day_from">Đến ngày : </label>
                        <input type="datetime" name="day_to" class="form-control datepicker  marginBot5" required data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))) {!!Request::input('day_to')!!} @endif">
                      </div>
                       <div class="form-group">
                        <select class="form-control borderRad4  marginBot5" name="tang">
                          <option value="0">--Chọn tầng --</option>
                          <option value="2" @if(!empty(Request::input('tang')) && Request::input('tang') == 2) selected @endif >Tầng 2</option>
                          <option value="3"  @if(!empty(Request::input('tang')) && Request::input('tang') == 3) selected @endif>Tầng 3</option>
                          <option value="4"  @if(!empty(Request::input('tang')) && Request::input('tang') == 4) selected @endif>Tầng 4</option>
                          <option value="5"  @if(!empty(Request::input('tang')) && Request::input('tang') == 5) selected @endif>Tầng 5</option>
                        </select>
                      </div>      
                      <div class="form-group">
                        <select class="form-control borderRad4  marginBot5" name="case">
                          <option value="0">--Chọn ca--</option>
                          @foreach($schedule as $value)
                            <?php
                              $key = array_search($value->time_start, $timeInADay);
                            ?>                            
                            <option @if(!empty(Request::input('case')) && Request::input('case') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}} (@if(isset($key)){{$timeInADay_start[$key]}}@else{{$value->time_start}}@endif - {{$value->time_end}})</option>
                          @endforeach     
                        </select>
                      </div>                  
                      <button type="submit" class="btn btn-primary  marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                      {{ csrf_field() }}
                    </form>
                    </div>
                <div class="box-body">
                <table class="table table-striped">
                <tr>
                  <th style="width: 250px">Tên</th>
                  <th>Email</th>
                  <th>Thời gian xử lý từ lúc đặt hàng đến lúc hoàn thành</th>
                </tr>
                  @if(!empty($data))
                    <?php $count_id = 0; ?>
					@foreach($data as $val)
					  @if(!empty($val->list_order))
		                <tr>
		                  <td>{!! $val->name!!}</td>
		                  <td>{!! $val->email !!}</td>
		                  <td>
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
                              <?php if( $day > 0 ){ ?>
                                  <p>Mã đơn hàng : <strong>{!! $v['order_id'] !!}</strong> - Thời gian xử lý <small class="label label-danger"><i class="fa fa-clock-o"></i> {!! $time_process!!}</small>  </p>
                              <?php }else{ if( $hr > 2 ){ ?>
                                  <p>Mã đơn hàng : <strong>{!! $v['order_id'] !!}</strong> - Thời gian xử lý <small class="label label-danger"><i class="fa fa-clock-o"></i> {!! $time_process!!}</small>  </p>
                              <?php }else { if( $hr < 1 ){ ?>
                                <?php if( $min >= 10 ){ ?>
                                  <p>Mã đơn hàng : <strong>{!! $v['order_id'] !!}</strong> - Thời gian xử lý <small class="label label-warning"><i class="fa fa-clock-o"></i> {!! $time_process!!}</small>  </p>
                                <?php }else{ ?>
                                  <p>Mã đơn hàng : <strong>{!! $v['order_id'] !!}</strong> - Thời gian xử lý <small class="label label-success"><i class="fa fa-clock-o"></i> {!! $time_process!!}</small>  </p>
                                <?php } ?>
                              <?php }else{ ?>
                                  <p>Mã đơn hàng : <strong>{!! $v['order_id'] !!}</strong> - Thời gian xử lý <small class="label label-warning"><i class="fa fa-clock-o"></i> {!! $time_process!!}</small>  </p>
                              <?php } } } ?>
		                  		@endforeach

		                  		<?php 
                                $count_id += count($val->list_order);
		                  		?>	
		                   
		                  </td>
		                </tr>
		                 @endif
		            @endforeach
		            
                  @endif
                 </table>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <?php
                    if ($count_id > 0) : 
                    $d = floor($thoigian_tb/ 86400);
                    $h = floor(($thoigian_tb % 86400) / 3600);
                    $m = floor(($thoigian_tb % 3600) / 60);
                    $time_tb = '';
                    if ($d > 0 ) {
                      $time_tb= $d .' ngày ';
                    }
                    if ($h > 0) {
                      $time_tb .= $h .' giờ ';
                    }
                    if ($m >= 0) {
                      $time_tb .= $m .' phút ';
                    }
                  ?>

                  <?php if( $d > 0 ){ ?>
                      <div class="alert alert-danger" role="alert"><p>Thời gian xử lý trung bình 1 đơn hàng: <strong>{!! $time_tb !!}</strong></p></div>
                  <?php }else{ ?>
                    <?php if( $h > 2 ){ ?>
                      <div class="alert alert-danger" role="alert"><p>Thời gian xử lý trung bình 1 đơn hàng: <strong>{!! $time_tb !!}</strong></p></div>
                    <?php }else{ ?>
                      <?php if( $h < 1 ){ ?>
                        <?php if( $m >= 10 ){ ?>
                          <div class="alert alert-warning" role="alert"><p>Thời gian xử lý trung bình 1 đơn hàng: <strong>{!! $time_tb !!}</strong></p></div>
                        <?php }else{ ?>
                          <div class="alert alert-success" role="alert"><p>Thời gian xử lý trung bình 1 đơn hàng: <strong>{!! $time_tb !!}</strong></p></div>
                        <?php } ?>
                      <?php }else{ ?>
                        <div class="alert alert-warning" role="alert"><p>Thời gian xử lý trung bình 1 đơn hàng: <strong>{!! $time_tb !!}</strong></p></div>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>

                  <?php endif; ?>
                  {!!$data->links()!!}
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



