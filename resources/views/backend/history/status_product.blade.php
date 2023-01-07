@extends('backend.layouts.master',['page_title'=>'Lịch sử cập nhật trạng thái sản phẩm'])
@section ('title','Lịch sử cập nhật trạng thái sản phẩm')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
	<div class="box box-primary">
            <div class="">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> 
                    </div> -->
                    <form class="form-inline" action="" method="get">
                      <div class="form-group">
                        <label for="day_from">Từ ngày : </label>
                        <input type="datetime" name="day_from" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))){!!Request::input('day_from')!!}@endif">
                      </div>
                      <div class="form-group">
                        <label for="day_from">Đến ngày : </label>
                        <input type="datetime" name="day_to" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))){!!Request::input('day_to')!!}@endif">
                      </div>   
                      <div class="form-group">
                        <input type="text" name="input_search" class="form-control borderRad4 marginBot5"  placeholder="Email, tên nhân viên" value="@if(!empty(Request::input('input_search'))){!! trim(Request::input('input_search')) !!}@endif">
                      </div>
                      <div class="form-group">
                        <select name="input_status" id="" class="form-control borderRad4 marginBot5">
                          <option value="">Tất cả</option>
                          <option value="0" @if(Request::input('input_status') == 0 && Request::input('input_status') != '') selected @endif>Hết hàng</option>
                          <option value="1" @if(Request::input('input_status') == 1) selected @endif>Còn hàng</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary marginBot5"><i class="fa fa-search"></i> Tìm kiếm</button>
                      {{ csrf_field() }}
                    </form>
                </div>
                <div class="box-body">
                
                @if(!empty($data))
                  <table class="table table-bordered table-hover table-striped">
                    <tr>
                      <th style="width:175px">Tên</th>
                      <th style="width:175px">Email</th> 
                      <th>Nội dung cập nhật</th>
                      <th>Ngày cập nhật</th>
                    </tr>
                    
                      @foreach($data as $val)
                      <tr>                      
                        <td>{!! $val->name!!}</td>
                        <td>{!! $val->email !!}</td>
                        <td>
                          <div class="col-md-12 no-padding">
                            <div class="tbl-body col-md-12 no-padding">
                              <?php 
                                if($val->text != '') { 
                                  $products = json_decode($val->text,true);
                              ?>
                              <div class="col-md-7 no-padding">                              
                                <ul>                                  
                                  @foreach($products as $pid=>$pname)
                                  <li>{!! $pname !!}</li>
                                  @endforeach
                                </ul>
                              </div>
                              <div class="col-md-5">
                                <p>chuyển sang trạng thái: 
                                @if($val->order_status == 1)
                                  <span class="label label-xs label-success">Còn hàng</span>
                                @else
                                  <span class="label label-xs label-danger">Hết hàng</span>
                                @endif
                                </p>
                              </div>
                              <?php } ?>
                            </div>                            
                          </div>
                        </td>
                        <td>{!! date('d-m-Y H:i:s',strtotime($val->created_at))!!}</td>
                      </tr>
                      @endforeach
                    
                  </table>
                 	{!!$data->appends(['day_from'=>$day_from,'day_to'=>$day_to,'input_search'=>$input_search,'input_status'=>$input_status])->links()!!}
                @endif
                </div><!-- /.box-body -->
                <div class="box-footer">
                    
                    	
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



