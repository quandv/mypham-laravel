@extends('backend.layouts.master',['page_title'=> 'Quản lý phòng máy(room)'])
@section ('title','Quản lý phòng máy(room)')
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
                <h3 class="box-title">Thêm mới Room</h3>
            </div>
            @if(count($details) > 0)
            <form role="form" id="addRoomForm" method="post" action="{!! route('admin.room.update', ['id' => $details->room_id]) !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Tên room <span class="required">*</span></label>
                        <div>
                            <input class="form-control" name="room_name" placeholder="Nhập tên room" type="text" value="{!! $details->room_name !!}">
                         </div>
                    </div>
                    <div class="form-group col-md-7 no-padding itemIP" style="overflow:hidden;">                          
                        @foreach($details->room_ip as $key => $item)
                          @if($key==0)
                            <div class="inputIP col-md-12 no-padding">
                              <div class="col-xs-10 col-sm-10 col-md-10 no-padding">
                                <label class="control-label">IP <span class="required">*</span></label>
                                <div>
                                    <input class="form-control marginBot5" name="room_ip[]" placeholder="Nhập IP room" type="text" value="{!! $item !!}">
                                 </div>
                              </div>
                              <div class="col-xs-2 col-sm-2 col-md-2">&nbsp;</div>
                            </div>
                          @else
                            <div class="inputIP inputIP-{!! $key !!} col-md-12 no-padding">
                              <div class="col-xs-10 col-sm-10 col-md-10 no-padding">                                    
                                <div>
                                    <input class="form-control marginBot5" name="room_ip[]" placeholder="Nhập IP room" type="text" value="{!! $item !!}">
                                 </div>
                              </div>
                              <div class="col-xs-2 col-sm-2 col-md-2"><button class="btn btn-danger btn-xs" type="button" onclick="closeIP({!! $key !!});"><i class="fa fa-close"></i></button></div>
                            </div>
                          @endif
                        @endforeach
                    </div>
                    
                    <div class="col-md-5 no-padding">
                      <label class="control-label hidden-sm">&nbsp;</label>
                      <div>
                        <button class="btn btn-primary btn-sm addRoom" type="button"><i class="fa fa-plus"></i> Thêm</button>
                      </div>
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
            @endif
        </div>    
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <form action="{!! route('admin.room.search') !!}" method="get" id="" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control borderRad3" name="stxt" placeholder="Nhập tên room hoặc room ip" type="text" value="" style="width:300px">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit" onclick="">
                                            <i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="table-responsive">                     
                    <table class="table table-bordered table-hover table-striped k-table-list">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Phòng máy</th>
                                <th>IP</th>                                
                                <th style="width: 100px">&nbsp;</th>
                            </tr>
                            @foreach($listRoom as $room)
                            <tr>
                                <td>{{$room->room_id}}</td>
                                <td>{{$room->room_name}}</td>
                                <td>
                                    <ul>
                                      @foreach($room->room_ip as $roomIP)
                                         <li>{!! $roomIP !!}</li>   
                                      @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.room.edit', ['id' => $room->room_id]) !!}"><i class="fa fa-pencil"></i></a>
                                    <form id="delete-form-{{$room->room_id}}" style="display:inline-block" action="{!! route('admin.room.destroy', ['id' => $room->room_id]) !!}" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:delItem({{$room->room_id}});"><i class="fa fa-minus-circle"></i></a>
                                    </form>                                    
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {!! $listRoom->appends(Request::only(['stxt']))->links() !!}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
    <script type="text/javascript">    
        function delItem(id){
            swal({
              title: 'Thông báo',
              text: "Bạn chắc chắn muốn xóa mục này?",
              type: 'warning',
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Đồng ý',
              cancelButtonText: 'Hủy',
              showCancelButton: true,
            }).then(function() {
              $('#delete-form-'+id).submit();
            });
        }

        $(document).ready(function(){
            $('.addRoom').on('click', function(){
              var sort = $('.itemIP .inputIP').length + 1;
                var html = '';
                html += '<div class="inputIP inputIP-'+sort+' col-md-12 no-padding">';
                html += '<div class="col-xs-10 col-sm-10 col-md-10 no-padding">';
                html += '<div><input class="form-control marginBot5" id="post_room_ip_" name="room_ip[]" placeholder="Nhập IP room" type="text" value=""></div>';
                html += '</div>';
                html += '<div class="col-xs-2 col-sm-2 col-md-2"><button class="btn btn-danger btn-xs" type="button" onclick="closeIP('+sort+');"><i class="fa fa-close"></i></button></div>';
                html += '</div>';
                $('#addRoomForm .itemIP').append(html);
            });            
        });

        function closeIP(sort){
          $('.inputIP-'+sort).remove();
        }
    </script>
@stop

                        
                            
                         