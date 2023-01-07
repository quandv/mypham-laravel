@extends('backend.layouts.master',['page_title'=> 'Quản lý máy trạm(client)'])
@section ('title','Quản lý máy trạm(client)')
@section('content')
<div class="row">
    <div class="col-xs-12 col-lg-5" id="category-box-form">
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
                <h3 class="box-title">Chỉnh sửa Client</h3>
            </div> 
            <form role="form" id="" method="post" action="{!! route('admin.client.update', ['id' => $details->client_id]) !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label class="control-label">Tên máy <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="post_client_name_" name="client_name" placeholder="Nhập tên máy..." type="text" value="{{$details->client_name}}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label">IP <span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="post_client_ip_" name="client_ip" placeholder="Nhập IP máy..." type="text" value="{{$details->client_ip}}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="client_parent" class="control-label">Chọn Phòng</label>
                        <div>
                            <select class="form-control" id="client_parent" name="room_id">
                                    <option value="0">--Chọn phòng máy--</option>
                                    @foreach($rooms as $room)
                                        @if( $room->room_id == $details->room_id )
                                            <option selected value="{{$room->room_id}}">{{$room->room_name}}</option>
                                        @else
                                            <option value="{{$room->room_id}}">{{$room->room_name}}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label">Cấu hình chat</label>
                        <div>
                            <!-- <input type="checkbox" name="chat_type" value="1" @if($details->chat_type == 1) checked @endif >Hiển thị trong tab quản trị -->
                            <input type="checkbox" name="chat_type" value="1" id="chat_type" @if($details->chat_type == 1) checked @endif > <label for="chat_type"  style="font-weight: 100">Hiển thị trong tab quản trị</label>
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
        </div>    
    </div>
    <div class="col-xs-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <form action="{!! route('admin.client.search') !!}" method="get" id="" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control" id=""  name="stxt" placeholder="Nhập tên máy hoặc IP" type="text" value="">
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
                                <th>Tên máy</th>
                                <th>IP</th>
                                <th>Phòng máy</th>
                                <th>Cấu hình chat</th>
                                <th style="width: 100px">&nbsp;</th>
                            </tr>
                            @foreach($clients as $client)
                            <tr>
                                <td>{{$client->client_id}}</td>
                                <td>{{$client->client_name}}</td>
                                <td>{{$client->client_ip}}</td>
                                <td>{{$client->room_name}}</td>
                                <td>
                                  @if($client->chat_type == 1)
                                    <span>Quản trị</span>
                                  @else
                                    <span>Khách hàng</span>
                                  @endif
                                </td>
                                <td>
                                    <a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.client.edit', ['id' => $client->client_id]) !!}"><i class="fa fa-pencil"></i></a>

                                    <form id="delete-client-{{$client->client_id}}" style="display:inline-block" action="{!! route('admin.client.destroy', ['id' => $client->client_id]) !!}" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_client({{$client->client_id}});"><i class="fa fa-minus-circle"></i></a>
                                    </form>                                    
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$clients->links()}}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

@endsection

@section('after-scripts-end')
    <script type="text/javascript">    
        function del_client(id){
            swal({
              title: 'Thông báo',
              text: "Bạn chắc chắc muốn xóa mục này?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Đồng ý',
              cancelButtonText: 'Hủy'
            }).then(function() {
                 $('#delete-client-'+id).submit();  
                swal(
                  'Thành công!',
                  '',
                  'success'
                );
            });
        }
    </script>
@stop