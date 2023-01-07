@extends('backend.layouts.master', ['page_title' => 'Quản lý ca'])
@section ('title','Quản lý ca')
@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-5" id="category-box-form">
     @if (session('flash_message_err') != '')
      <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
    @endif
     @if (session('flash_message_succ') != '')
      <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
    @endif
    @if(count($errors) > 0)
      <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
      @endif
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Chỉnh sửa ca</h3>
            </div> 
            <form role="form" method="post" action="{!! route('admin.schedule.update', ['id' => $details->id]) !!}">
                <div class="box-body">
                    <div class="form-group ">
                        <label class="control-label">Tên ca <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="schedule_name" name="schedule_name" placeholder="Nhập tên ca..." type="text" value="{{$details->name}}">
                         </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 sm-right0" style="padding-left:0;">
                        <label for="schedule_parent" class="control-label">Bắt đầu:<span class="required">*</span></label>
                        <div>
                            <select class="form-control" id="schedule_parent" name="time_start">
                                @foreach($timeInADay_start as $key => $value)
                                <option value="{{$timeInADay[$key]}}" <?php if($details->time_start == $timeInADay[$key]) echo 'selected'; ?> >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 sm-left0" style="padding-right:0;">
                        <label for="schedule_parent" class="control-label">Kết thúc:<span class="required">*</span></label>
                        <div>
                            <select class="form-control" id="schedule_parent" name="time_end">                                
                                @foreach($timeInADay as $value)
                                    <option value="{{$value}}" <?php if($details->time_end == $value) echo 'selected'; ?> >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <p><span class="required"><strong>*Lưu ý:</strong></span> Nếu bạn chọn thời gian bắt đầu lớn hơn thời gian kết thúc, mặc định chương trình sẽ hiểu rằng thời gian kết thúc sẽ sang ngày hôm sau.</p>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
                    </div>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
        </div>    
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <!-- <form action="{!! route('admin.schedule.search') !!}" method="get" id="" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control" id=""  name="stxt" placeholder="Tìm theo tên ca" type="text" value="">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit" onclick="">
                                            <i class="fa fa-search"></i> Tìm kiếm</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> -->
                <br>
                <div class="table-responsive">                     
                    <table class="table table-bordered table-hover table-striped k-table-list">
                            <tr>
                                <!-- <th style="width: 50px;">ID</th> -->
                                <th>Tên ca</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th style="width: 100px">Xử lý</th>
                            </tr>
                            @if(!empty($schedules))
                                @foreach($schedules as $value)
                                <?php
                                    $timeKey = -1;
                                    if(in_array($value->time_start, $timeInADay)){
                                      $timeKey = array_search("$value->time_start", $timeInADay);
                                    }
                                ?>
                                <tr>
                                    <!-- <td>{{$value->id}}</td> -->
                                    <td>{{$value->name}}</td>
                                    <td>@if(isset($timeInADay_start[$timeKey])){{ $timeInADay_start[$timeKey] }}@endif</td>
                                    <!-- <td>{{substr_replace($value->time_start,'1', -1)}}</td> -->
                                    <td>{{$value->time_end}}</td>
                                    <td>
                                        <a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.schedule.edit', ['id' => $value->id]) !!}"><i class="fa fa-pencil"></i></a>

                                        <form id="delete-schedule-{{$value->id}}" style="display:inline-block" action="{!! route('admin.schedule.destroy', ['id' => $value->id]) !!}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_value({{$value->id}});"><i class="fa fa-minus-circle"></i></a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
    <script type="text/javascript">        
        function del_value(id){
           /* var delschedule = confirm('Bạn chắc chắn muốn xóa mục này?');
            if( delschedule ){
            $('#delete-schedule-'+id).submit();  
            }*/
            swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false
            }).then(function() {
              $('#delete-schedule-'+id).submit();    
              swal(
                'Deleted!',
                'Your data has been deleted.',
                'success'
              );
            }, function(dismiss) {
              // dismiss can be 'cancel', 'overlay',
              // 'close', and 'timer'
              if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
                );
              }
            })
        }
    </script>
@stop