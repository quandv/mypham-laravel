@extends('backend.layouts.master', ['page_title' => 'Danh sách công thức món ăn'])
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
                            <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: 100px;" >
                              <option value="-1">--Xử lý--</option>
                                <option value="1">Xóa</option>
                            </select>
                            <a id="apply-select" class="btn btn-default form-control pull-left marginRight3 marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                            <button type="button" class="btn btn-primary marginBot5" onclick="get_pro_op();">
                              <i class="fa fa-plus"></i> Thêm mới
                            </button>
                          </div>

                        </div>
                        <div class="col-sm-12 pull-right">                          
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
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <tr>
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
                          </tr>
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
                                <a class="btn btn-info btn-xs marginBot5" href="{!! route('recipe.edit', ['id' => $recipe->ctm_id,'pid'=>$recipe->product_id,'token_' => 0]) !!}"><i class="fa fa-pencil"></i></a>
                                <form id="delete-form-{{$recipe->ctm_id}}" style="display:inline-block" action="{!! route('recipe.destroy', ['id' => $recipe->ctm_id,'pid'=>$recipe->product_id,'token_' => 0]) !!}" method="post">
                                   <input type="hidden" name="_method" value="DELETE">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   <input type="hidden" name="token_" value="0">
                                   <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:delItem({{$recipe->ctm_id}});"><i class="fa fa-minus-circle"></i></a>
                                </form>                            
                              @elseif(isset($recipe->id))
                                <a class="btn btn-info btn-xs marginBot5" href="{!! route('recipe.edit', ['id' => $recipe->ctm_id,'pid'=>$recipe->id,'token_' => 1]) !!}"><i class="fa fa-pencil"></i></a>
                                <form id="delete-form-{{$recipe->ctm_id}}" style="display:inline-block" action="{!! route('recipe.destroy', ['id' => $recipe->ctm_id,'pid'=>$recipe->id,'token_' => 1]) !!}" method="post">
                                   <input type="hidden" name="_method" value="DELETE">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                   <input type="hidden" name="token_" value="1">
                                   <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:delItem({{$recipe->ctm_id}});"><i class="fa fa-minus-circle"></i></a>
                                </form> 
                              @endif
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$listRecipe->links()}}
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
        <h4 class="modal-title" id="myModalLabel"><strong>Danh sách sản phẩm và option</strong></h4>
      </div>
      <div class="modal-body no-padding" style="overflow:hidden;">
        <div class="col-md-6 col-xs-12" id="list-product">
          <h4>Sản phẩm</h4>
          <div class="list-item"></div>
        </div>
        <div class="col-md-6 col-xs-12" id="list-option">
          <h4>Option</h4>
          <div class="list-item"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>
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

    function get_pro_op(){
      $.ajax({
        url: base_url+"/recipe/get_pro_op",
        type: "post",
        dataType: "json",
        data: {
          "_token": tokenvrf
        },
        success: function(result){
          var html = '';
          $.each(result.product, function(index,value){
            var route = base_url+'/recipe/create?pid='+value.product_id;
            html += '<div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px">';
            html += '<img src="{!! asset("uploads/product/'+value.product_image+'") !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5 marginRight10">';
            html += '<span>'+value.product_name+'</span>';
            html += '<span class="label label-primary pull-right padding5"><a href="'+route+'" style="color:#fff;"><i class="fa fa-plus"></i> Tạo công thức</a></span>';
            html += '</div>';
          });

          var html2 = '';
          $.each(result.option, function(index,value){
            var route2 = base_url+'/recipe/create?token_=1&pid='+value.id;
            html2 += '<div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px">';
            html2 += '<img src="{!! asset("uploads/product/option.png") !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5 marginRight10">';
            html2 += '<span>'+value.name+'</span>';
            html2 += '<span class="label label-primary pull-right padding5"><a href="'+route2+'" style="color:#fff;"><i class="fa fa-plus"></i> Tạo công thức</a></span>';
            html2 += '</div>';
          });

          $('#list-product .list-item').html(html);
          $('#list-option .list-item').html(html2);
          $('#pro-op').modal('show');
        }
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
          console.log(idArr);
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