@extends('backend.layouts.master', ['page_title' => 'Tìm kiếm công thức món ăn'])
@section ('title','Công thức món ăn')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <!-- <h3 class="box-title">Danh sách công thức món ăn</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                    <div class="row">
                        <div class="col-sm-12">

                          <div class="">
                            <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: 150px;" >
                              <option value="-1">--Xử lý--</option>
                                <option value="1">Xóa</option>                              
                            </select>
                            <a id="apply-select" class="btn btn-default form-control pull-left marginRight3 marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                            <button type="button" class="btn btn-primary marginBot5" data-toggle="modal" data-target="#pro-op">
                              <i class="fa fa-plus"></i> Thêm mới
                            </button>
                          </div>

                        </div>
                        <div class="col-sm-12">                          
                          <form class="form-inline pull-right" action="{!! route('admin.recipe.search') !!}" method="get">
                            <div class="input-group">
                                  <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="Tên công thức, sản phẩm" type="text" value="" style="width:250px;">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default marginBot5" type="submit" onclick="">
                                        <i class="fa fa-search"></i></button>
                                </span>
                            </div>
                          </form>
                        </div>
                    </div>
                
                <br>
                <div>
                  @if ($stxt != '')
                    <div class="alert alert-success" role="alert">Kết quả tìm kiếm với từ khóa <strong>"{{$stxt}}"</strong></div>                    
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <th style="width: 50px;"><input name="checkall-toggle" type="checkbox" id="checkAll"></th>
                          <!-- <th style="width: 50px;">ID</th> -->
                          <th width="150px">Tên công thức</th>
                          <th>Sản phẩm</th>
                          <th><div class="col-md-12">Chi tiết</div>
                              <div class="col-md-12">
                                <div class="col-md-5"><strong>Nguyên liệu</strong></div>
                                <div class="col-md-5"><strong>Lượng</strong></div>
                                <div class="clearfix"></div>
                              </div>
                          </th>
                          <th>Mô tả</th>
                          <th>Xử lý</th>
                      </thead>
                      <tbody>
                        @foreach($listRecipe as $recipe)
                          <tr>
                            <td><input type="checkbox" value="{{ $recipe->ctm_id }}" class="id-checkbox check"></td>
                            <!-- <td>{{ $recipe->ctm_id }}</td> -->
                            <td>{{ $recipe->ctm_name }}</td>
                            <td>
                              <div class="col-md-12 no-padding">
                                @if(isset($recipe->product_name ))
                                <div style="float:left;width:100px">
                                  <img src="{{ asset('uploads/product/'.$recipe->product_image) }}" alt="" style="width:80%;max-height:60px">
                                </div>
                                <div class="col-md-8">
                                  {!! $recipe->product_name !!}
                                </div>
                                @else
                                  @if(isset($recipe->name)) {!! $recipe->name !!} <span class="required">(option)</span> @endif                                    
                                @endif                                
                              </div>
                            </td>
                            <td>
                              <div class="col-md-12">                                
                                <div class="tbl-body col-md-12">
                                  @foreach($recipe->ctm_details as $k => $ctmDetails)
                                    <div class="col-md-5"> {!! $recipe->ctm_details_name->$k !!} </div>
                                    <div class="col-md-5"> {!! $ctmDetails !!} ({!! $unit[$k] !!}) </div>
                                    <div class="clearfix"></div>
                                  @endforeach
                                </div>
                              </div>
                            </td>
                            <td>{{ $recipe->ctm_desc }}</td>
                            <td>
                              @if(isset($recipe->product_id))
                                <a class="btn btn-info btn-xs" href="{!! route('recipe.edit', ['id' => $recipe->ctm_id,'pid'=>$recipe->product_id,'token_' => 0]) !!}"><i class="fa fa-pencil"></i></a>
                                <form id="delete-form-{{$recipe->ctm_id}}" style="display:inline-block" action="{!! route('recipe.destroy', ['id' => $recipe->ctm_id,'pid'=>$recipe->product_id,'token_' => 0]) !!}" method="post">
                                   <input type="hidden" name="_method" value="DELETE">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   <input type="hidden" name="token_" value="0">
                                   <a class="btn btn-danger btn-xs" onclick="javascript:delItem({{$recipe->ctm_id}});"><i class="fa fa-minus-circle"></i></a>
                                </form>                            
                              @elseif(isset($recipe->id))
                                <a class="btn btn-info btn-xs" href="{!! route('recipe.edit', ['id' => $recipe->ctm_id,'pid'=>$recipe->id,'token_' => 1]) !!}"><i class="fa fa-pencil"></i></a>
                                <form id="delete-form-{{$recipe->ctm_id}}" style="display:inline-block" action="{!! route('recipe.destroy', ['id' => $recipe->ctm_id,'pid'=>$recipe->id,'token_' => 1]) !!}" method="post">
                                   <input type="hidden" name="_method" value="DELETE">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   <input type="hidden" name="token_" value="1">
                                   <a class="btn btn-danger btn-xs" onclick="javascript:delItem({{$recipe->ctm_id}});"><i class="fa fa-minus-circle"></i></a>
                                </form> 
                              @endif
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$listRecipe->appends(Request::only(['stxt']))->links()}}
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

<!-- Modal -->
<div class="modal fade" id="pro-op" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('after-scripts-end')
  <script type="text/javascript">

    $(document).ready(function(){
      $("#checkAll").click(function () {
          $(".check").prop('checked', $(this).prop('checked'));
      });
    });

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
      $('#apply-select').on('click', function(){
        var action = $('#action-option').val();        
        if(parseInt(action) < 0){
          swal({
            title: 'Thông báo',
            text: "Bạn chưa chọn hành động",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý'
          }).then(function() {});

        }else{
          var idArr = new Array();
          $('.id-checkbox').each(function(){
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
                confirmButtonText: 'Đồng ý'
              }).then(function() {});
          }else{
              swal({
                title: 'Thông báo',
                text: "Bạn chắc chắn thực hiện hành động này?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
              }).then(function() {
                  if(parseInt(action) == 1){
                      $.ajax({
                          url: base_url+"/recipe/del_more",
                          type: "post",
                          dataType: "json",
                          data: {
                            "_token": tokenvrf,
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
                                  confirmButtonText: 'Đồng ý',
                                  timer: 1000
                                });
                                location.href = base_url+'/recipe';
                                
                            }else{
                              swal({
                                title: 'Lỗi',
                                text: "Đã có lỗi xảy ra, vui lòng thử lại",
                                type: 'error',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Đồng ý',
                                timer: 1000
                              }).then(function() {});
                            }
                          }
                      });
                  }
              });            
          }          
        }
      });

    });

  </script>
@stop