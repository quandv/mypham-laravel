@extends('backend.layouts.master',['page_title' => 'Quản trị'])
@section ('title','Quản trị')
@section('content')
{{ Html::style(asset('bower_components/AdminLTE/plugins/morris/morris.css')) }}
    <div class='row'>
    @if (session('flash_message_err') != '')
      <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
    @endif
    <style type="text/css">
      .clearfix{margin-bottom: 5px;}
      .label{line-height: 2;}
      
      #imgWatting{
        position: absolute;
        top: 40%;        
        width: 100%;        
      }

    </style>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin ngày: <strong> @if(!empty(Request::input('day'))) {!!Request::input('day')!!} @else {!! date('d-m-Y') !!} @endif</strong> </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div>
                </div>
                <div class="box-body">
                <form class="form-inline" action="" method="get">
                   <div class="form-group">
                    <input type="datetime" name="day" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))) {!!Request::input('day')!!} @endif">
                  </div>
                   <!-- <div class="form-group">
                       <select class="form-control" required="required" name="tang">
                         <option value="0">--Chọn tầng --</option>
                         <option value="2" @if(!empty(Request::input('tang')) && Request::input('tang') == 2) selected @endif >Tầng 2</option>
                         <option value="3"  @if(!empty(Request::input('tang')) && Request::input('tang') == 3) selected @endif>Tầng 3</option>
                         <option value="4"  @if(!empty(Request::input('tang')) && Request::input('tang') == 4) selected @endif>Tầng 4</option>
                         <option value="5"  @if(!empty(Request::input('tang')) && Request::input('tang') == 5) selected @endif>Tầng 5</option>
                       </select>
                                        </div>    -->   
                  <div class="form-group">
                    <select class="form-control borderRad4 marginBot5" name="case">
                      <option value="0">--Chọn ca--</option>
                      @foreach($data['schedule'] as $value)
                      <?php
                        $key = array_search($value->time_start, $data['timeInADay']);
                      ?>
                        <option @if(!empty(Request::input('case')) && Request::input('case') == $value->id) selected @endif value="{{$value->id}}">{{$value->name}} ( @if(isset($key)){{$data['timeInADay_start'][$key]}}@else{{$value->time_start}}@endif - {{$value->time_end}})</option>
                      @endforeach
                      
                    </select>
                  </div>                  
                  <button type="submit" class="btn btn-primary marginBot5"> <i class="fa fa-search"></i> Tìm kiếm</button>
                  {{ csrf_field() }}
                </form>
                   @if(!empty($data['all']))
                      <h4>  Giờ hiện tại - {!! date('h:i:s') !!} -
                       @if(!empty(Request::input('case') && Request::input('case') != 0))
                         Ca {!!Request::input('case') !!}
                       @else
                         Gồm 3 ca
                       @endif
                       </h4>
                      <br/>
                      <div class="row">
                        @foreach($data['all'] as $key => $val)
                          <div class="col-xs-12 col-sm-6 col-md-3">
                            <h4> Kết quả tầng {!! $key !!} </h4>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="label label-warning">Đang xử lý</span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span>{{ number_format($val[1], 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="label label-success">Đã thu tiền</span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format($val[2], 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="label label-success">Đã hoàn thành</span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format($val[3], 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="label label-danger">Đã hủy</span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format(($val[4] + $val[5]), 0, ',', '.') }}đ</span></div>
                            </div>
                             <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="required">Nạp tài khoản(*): </span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format($val['totalTk'], 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="required">Combo(*): </span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format(($val['totalCB']), 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="required">Dịch vụ(*): </span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format(($val[3] -  $val['totalTk'] - $val['totalCB']), 0, ',', '.') }}đ</span></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-xs-6 col-sm-6 col-md-6"><span class="required">Tổng cộng(*): </span></div>
                              <div class="col-xs-6 col-sm-6 col-md-6"><span >{{ number_format($val[3], 0, ',', '.') }}đ</span></div>
                            </div>
                          </div>
                        @endforeach
                            
                      </div>
                    @endif
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-md-12 d-div-priceTotal no-padding">
                         <?php 
                            $tang2 = isset($data['all'][2][3]) ? $data['all'][2][3] : 0;
                            $tang3 = isset($data['all'][3][3]) ? $data['all'][3][3] : 0;
                            $tang4 = isset($data['all'][4][3]) ? $data['all'][4][3] : 0;
                            $tang5 = isset($data['all'][5][3]) ? $data['all'][5][3] : 0;
                            $tang6 = isset($data['all'][6][3]) ? $data['all'][6][3] : 0;
                         ?>
                        <span><strong class="required">Tổng cộng (*)</strong> : {!! number_format(($tang2+$tang3+$tang4+$tang5+$tang6), 0, ',', '.')!!} đ </span>
                    </div>
                    <div class="col-md-12 d-div-price no-padding">
                        <strong class="">Lưu ý:</strong>
                        <p><strong class="required">(*)</strong>:  đơn hàng đã hoàn thành</p>
                    </div> <div class="clearfix"></div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->

        <div class="col-md-12 col-lg-8">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <div><h3 class="box-title">Thống kê kinh doanh </h3></div>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <br>
              <div class="clear-fix"></div>
              <div class="col-md-12 no-padding">
                <div class="pull-left marginRight4">
                  <input type="datetime" id="selectDay" class="datepicker form-control marginBot5" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(isset($data['today'])){!! $data['today'] !!}@elseif(!empty(Request::input('selectDay'))) {!!Request::input('selectDay')!!}@endif">
                </div>
                <div class="pull-left marginRight4 marginBot5">
                  <select name="" id="selectMonth" class="form-control borderRad4" style="width:130px">
                    <option value="1">Tháng 1</option>
                    <option value="2">Tháng 2</option>
                    <option value="3">Tháng 3</option>
                    <option value="4">Tháng 4</option>
                    <option value="5">Tháng 5</option>
                    <option value="6">Tháng 6</option>
                    <option value="7">Tháng 7</option>
                    <option value="8">Tháng 8</option>
                    <option value="9">Tháng 9</option>
                    <option value="10">Tháng 10</option>
                    <option value="11">Tháng 11</option>
                    <option value="12">Tháng 12</option>
                  </select>
                </div>
                <div class="pull-left marginRight4 marginBot5">
                  <select name="" id="selectYear" class="form-control borderRad4" style="width:130px">
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                  </select>
                </div>
              </div>
            </div>
            

            <div class="box-body chart-responsive">
              <div class="hide text-center" id="imgWatting"><img src="{!! asset('images/icon/hourglass.gif') !!}" alt="" ></div>
              <div class="chart" id="line-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-6 col-lg-4">
          <!-- DONUT CHART -->
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Thống kê số lượng đơn hàng</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                @if( array_sum($data['toTalStatus']) <= 0 )
                  <div class="alert alert-danger">Không có đơn hàng nào</div>
                @else
                  <canvas id="pieChart" style="height:250px"></canvas>
                @endif
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        <!-- <div class='col-md-6'>
            Box
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Second Box</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    A separate section to add any kind of widget. Feel free
                    to explore all of AdminLTE widgets by visiting the demo page
                    on <a href="https://almsaeedstudio.com">Almsaeed Studio</a>.
                </div>/.box-body
            </div>/.box
        </div>/.col -->

    </div><!-- /.row -->
@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  {{ Html::script(asset('bower_components/AdminLTE/plugins/chartjs/Chart.min.js')) }}
  {{ Html::script(asset('bower_components/AdminLTE/plugins/morris/morris.min.js')) }}
  {{ Html::script(asset('bower_components/AdminLTE/plugins/myfolder/raphael.min.js')) }}
  {{ Html::script(asset('bower_components/AdminLTE/plugins/fastclick/fastclick.js')) }}

  <script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true
    });
  </script>

  <script type="text/javascript">

    $(function () {
      "use strict";
      // LINE CHART
      var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: {!! $data['data2'] !!},
        xkey: 'dateTime',
        ykeys: ['toTalAll'],
        labels: ['Doanh thu'],
        lineColors: ['#3c8dbc'],
        hideHover: 'auto'
      });

      $('#selectDay').on('change', function(){
          $.ajax({
            url : base_url+"/dashboard/chartDay",
                type : "post",
                dataType:"json",
                data : {
                    "_token": tokenvrf,
                    'day' : $('#selectDay').val()
                },
                beforeSend: function(){
                  $('#imgWatting').removeClass('hide');
                  $('#line-chart').css('opacity','0.5');
                },
                success : function (result){
                  $('#imgWatting').addClass('hide');
                  $('#line-chart').css('opacity','1');
                  line.setData(result);                  
                }
                
          });
      });

      $('#selectMonth').on('change', function(){
          $.ajax({
            url : base_url+"/dashboard/chartMonth",
                type : "post",
                dataType:"json",
                data : {
                    "_token": tokenvrf,
                    'month' : $('#selectMonth option:selected').val(),
                    'year' : $('#selectYear option:selected').val()
                },
                beforeSend: function(){                  
                  $('#imgWatting').removeClass('hide');
                  $('#line-chart').css('opacity','0.5');
                },
                success : function (result){
                  $('#imgWatting').addClass('hide');
                  $('#line-chart').css('opacity','1');
                  var arr = $.map(result, function(el) { return el });
                  line.setData(arr);
                }
                
          });
      });

      $('#selectYear').on('change', function(){
          $.ajax({
            url : base_url+"/dashboard/chartYear",
                type : "post",
                dataType:"json",
                data : {
                    "_token": tokenvrf,
                    'year' : $('#selectYear option:selected').val()
                },
                beforeSend: function(){
                  $('#imgWatting').removeClass('hide');
                  $('#line-chart').css('opacity','0.5');
                },
                success : function (result){
                  $('#imgWatting').addClass('hide');
                  $('#line-chart').css('opacity','1');
                  var arr = $.map(result, function(el) { return el });
                  line.setData(arr);
                }
          });
      });
      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
      var pieChart = new Chart(pieChartCanvas);              
      var PieData = [
        {
          value: {!! $data['toTalStatus'][4]+$data['toTalStatus'][5] !!},
          color: "#f56954",
          highlight: "#f56954",
          label: "Đã hủy"
        },
        {
          value: {!! $data['toTalStatus'][3] !!},
          color: "#00a65a",
          highlight: "#00a65a",
          label: "Đã hoàn thành"
        },
        {
          value: {!! $data['toTalStatus'][1] !!},
          color: "#f39c12",
          highlight: "#f39c12",
          label: "Đang xử lý"
        },
        {
          value: {!! $data['toTalStatus'][2] !!},
          color: "#3c8dbc",
          highlight: "#3c8dbc",
          label: "Đã thu tiền"
        }
      ];
      var pieOptions = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        //String - The colour of each segment stroke
        segmentStrokeColor: "#fff",
        //Number - The width of each segment stroke
        segmentStrokeWidth: 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps: 100,
        //String - Animation easing effect
        animationEasing: "easeOutBounce",
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
      };
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      pieChart.Doughnut(PieData, pieOptions);

    });
  </script>

  <script type="text/javascript">
    
  </script>
@stop
