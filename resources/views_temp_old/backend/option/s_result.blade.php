@extends('backend.layouts.master', ['page_title' => 'Quản lý Option'])
@section ('title','Quản lý Option')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Kết quả tìm kiếm</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{!! route('admin.option.search') !!}" method="get" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                          @if($hethang)
                            <form>
                              <div>
                                <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: 150px;">
                                  <option value="-1">--Xử lý--</option>
                                  <option value="0">Hết hàng</option>
                                  <option value="1">Còn hàng</option>
                                </select>
                                <a id="apply-option" class="btn btn-default form-control pull-left marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                              </div>
                            </form>
                            @endif

                            @if($managerOption)
                            <a href="{!! route('admin.option.create') !!}">
                              <button type="button" class="btn btn-primary marginLeft3 marginBot5"><i class="fa fa-plus"></i> Thêm mới</button>
                            </a>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="Tên option" type="text" value="@if(Request::input('stxt')){{Request::input('stxt')}}@endif">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default marginBot5" type="submit" onclick="">
                                            <i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div>
                  @if ($stxt)
                    <div class="alert alert-success" role="alert">Kết quả tìm kiếm với từ khóa "<strong>{{$stxt}}</strong>"</div>
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                     	<thead>
    			                <tr>
                            <th style="width: 50px;"><input name="checkall-toggle" type="checkbox" id="checkAll"></th>
                            <th>ID</th>
    			                  <th>Tên option</th>
    			                  <th>Giá option</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
    			                </tr>
    			            </thead>
    			            <tbody>
                        @foreach($options as $option)
    			                <tr>
                            <td><input type="checkbox" value="{{ $option->id }}" class="pid-checkbox check"></td>
                            <td>{{ $option->id }}</td>
    			                  <td>{{ $option->name }}</td>
    			                  <td>{{ $option->price }}</td>
                            <td>
                              @if( $option->status == 0 )
                                <span class="label label-danger">Hết hàng</span>
                              @else
                                <span class="label label-success">Còn hàng</span>
                              @endif
                            </td>
                            <td>
                              @if($managerOption)
                                <a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.option.edit', ['id' => $option->id]) !!}"><i class="fa fa-pencil"></i></a>                              
                                <form id="delete-option-{{$option->id}}" style="display:inline-block" action="{!! route('admin.option.destroy', ['id' => $option->id]) !!}" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_option({{$option->id}});"><i class="fa fa-minus-circle"></i></a>
                                </form>
                              @endif
                              @if(access()->hasPermission('manager-recipe'))
                                <a class="btn btn-primary btn-xs marginBot5" href="{!! route('recipe.create', ['pid' => $option->id,'token_' => '1']) !!}"><i class="fa fa-plus"></i> Tạo công thức</a>
                              @endif
                            </td>
    			                </tr>
                          @endforeach
    			            </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$options->appends(Request::only('stxt'))->links()}}
                </div>
            </div>
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('after-scripts-end')
  <script type="text/javascript">    
    function del_option(id){
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
           $('#delete-option-'+id).submit();  
          swal(
            'Thành công!',
            '',
            'success'
          );
      });
    }

    $(document).ready(function(){
      //check all
      $("#checkAll").click(function () {
          $(".check").prop('checked', $(this).prop('checked'));
      });
      //process
      $('#apply-option').on('click', function(){
        var action = $('#action-option').val();        
        if(parseInt(action) < 0){
          swal({
            title: 'Lỗi',
            text: "Bạn chưa chọn hành động",
            type: 'error',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then(function() {});

        }else{
          var idArr = new Array();
          $('.pid-checkbox').each(function(){
            if($(this).is(':checked')){            
              idArr.push($(this).val());
            }
          });
          if(idArr.length < 1){
              swal({
                title: 'Thông báo',
                text: "Bạn chưa chọn sản phẩm",
                type: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then(function() {});
          }else{
              swal({
                title: 'Thông báo',
                text: "Bạn chắc chắn thực hiện hành động này?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
              }).then(function() {
                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: base_url+"/option/updatestatus",
                      type: "post",
                      dataType: "json",
                      data: {
                        'action' : action,
                        'idArr': idArr
                      },
                      success: function(result){  
                      console.log(result);
                        if(result){
                            swal({
                              title: 'Thành công',
                              text: '',
                              type: 'success',
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'OK',
                              timer: 1000
                            });
                            location.reload();
                        }else{
                          swal({
                            title: 'Lỗi',
                            text: "Đã có lỗi xảy ra, vui lòng thử lại",
                            type: 'error',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes',
                            timer: 1000
                          }).then(function() {});
                        }
                      }
                  });
              });            
          }          
        }

      });  
    });
  </script>
@stop