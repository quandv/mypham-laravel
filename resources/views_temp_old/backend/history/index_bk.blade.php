@extends('backend.layouts.master',['page_title'=>'Lịch sử'])
@section ('title','Lịch sử')
@section('content')
{{ Html::style(asset('css/datepicker.css')) }}
	<div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Lịch sử thay đổi trạng thái đơn hàng</h3> -->
              <div class="">
                <form class="form-inline" action="" method="get">
                  <div class="form-group">
                    <label for="day_from">Từ ngày : </label>
                    <input type="datetime" name="day_from" class="form-control datepicker" data-date-format="dd-mm-yyyy" id="day_from" value="@if(!empty(Request::input('day_from'))){!!Request::input('day_from')!!}@endif">
                  </div>
                  <div class="form-group">
                    <label for="day_from">Đến ngày : </label>
                    <input type="datetime" name="day_to" class="form-control datepicker" data-date-format="dd-mm-yyyy" id="" value="@if(!empty(Request::input('day_to'))){!!Request::input('day_to')!!}@endif">
                  </div>
                  <div class="form-group">
                    <input type="text" name="user" class="form-control"  placeholder="Tên,email,mã đơn hàng" value="@if(!empty(Request::input('user'))){!! trim(Request::input('user')) !!}@endif">
                  </div>
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                  
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 100px">History ID</th>
                  <th>User ID</th>
                  <th>Nội dung thay đổi</th>
                  <th >Ngày</th>
                </tr>
                @if(!empty($data))
                   @foreach($data as $val)
		                <tr>
		                  <td>{!!$val->id!!}</td>
		                  <td>{!! $val->user_id !!}</td>
		                  <td>
		                    {!!$val->text!!}
		                  </td>
		                  <td>
                            {!! date('d-m-Y H:i:s',strtotime($val->created_at))!!}
		                  </td>
		                </tr>
		            @endforeach
                @endif
                
              </table>
              {!!$data->links()!!}
            </div>
            <!-- /.box-body -->
          </div>
@endsection

@section('after-scripts-end')
  {{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  <script type="text/javascript">
    $('.datepicker').datepicker();    
  </script>
@stop



