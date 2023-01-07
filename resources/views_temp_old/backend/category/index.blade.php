@extends('backend.layouts.master',['page_title'=> 'Danh mục'])
@section ('title','Danh mục')
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-5" id="category-box-form">
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
                <h3 class="box-title">Thêm mới danh mục</h3>
            </div> 
            <form role="form" id="post_category_add_form" method="post" action="{!! route('admin.category.store') !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="post_category_name_" class="control-label">Tên danh mục <span class="red-star">*</span></label>
                        <div>
                            <input class="form-control" id="post_category_name_" name="category_name" placeholder="Tên danh mục" type="text" value="{!! old('category_name')!!}">
                         </div>
                    </div>
                    <div class="form-group ">
                        <label for="category_parent" class="control-label">Danh mục cha</label>
                        <div>
                            <select class="form-control" id="category_parent" name="category_parent">
                                    <option value="">--Chọn danh mục--</option>
                                    {!! $select_cat !!}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Loại: </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_type" value="0" checked> Không hiển thị ở menu chính
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_type" value="1"> Hiển thị ở menu chính
                      </label>
                    </div>

                    <div class="form-group ">
                        <label for="category_description_" class="control-label">Mô tả</label>
                        <div>
                            <textarea class="form-control" id="category_description_" name="category_description" rows="7" placeholder="Mô tả">{!! old('category_description')!!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Trạng thái: </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_status" value="1" checked> Hiện
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="category_status" value="0"> Ẩn
                      </label>
                    </div>

                    <div class="form-group">
                          <label for="fileImage">Ảnh</label>
                          <input type="file" id="fileImage" name="fileImage">
                          <p class="help-block">Ảnh danh mục.</p>
                    </div>
                     <div class="form-group">
                          <label for="fileImageHover">Ảnh(khi được chọn)</label>
                          <input type="file" id="fileImageHover" name="fileImageHover">
                          <p class="help-block">Ảnh danh mục(khi được chọn).</p>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit" name="add">Lưu</button>
                    </div>
                </div>
                {!! csrf_field() !!}

            </form>
        </div>    
    </div>
    <div class="col-sm-12 col-md-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <form action="" method="get" id="post_category_search_form" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control borderRad3" name="search_cat" placeholder="Tên danh mục" type="text" value="{!! Request::get('search_cat')!!}">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
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
                                   <!--  <th style="width: 50px;"><input name="checkall-toggle" type="checkbox"></th> -->
                                    <th>Tên danh mục</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 100px">Xử lý</th>
                                </tr>
                                
                                {!! $display_cat !!}
                              
                        </table> 
                 
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<div class="modal fade modal-pstatus" tabindex="-1" role="dialog" id="modal-category-depend">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Danh sách danh mục con</strong></h4>
      </div>
      <div class="modal-body no-padding" style="overflow:hidden">          
            <div class="col-md-12 col-sm-12" style="padding-top:10px; padding-bottom:10px;">
                <div class="col-md-8 col-sm-8 no-padding" style="" id="list_category_depend">
                  <!-- list category depend -->
                </div>
                <div class="col-md-4 col-sm-4 no-padding" style="">
                  <div class="form-group">
                    <label>Danh mục cập nhật</label>
                    <select class="form-control select2" style="width: 100%;" id="cat_parent_update">
                      <option value="0" disabled>--Chọn danh mục cha mới--</option>
                      @if(count($listCatRoot) > 0)                        
                        @foreach($listCatRoot as $cat_parent)                        
                          <option class="cat_parent cat_parent{!! $cat_parent->category_id !!}" value="{!! $cat_parent->category_id !!}">{!! $cat_parent->category_name !!}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
            </div>
      </div><div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>        
        <button type="button" class="btn btn-primary update_cat_parent" ><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật danh mục và xóa</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /.modal product depend -->
<div class="modal fade modal-pstatus" tabindex="-1" role="dialog" id="modal-product-depend">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Danh sách sản phẩm phụ thuộc</strong></h4>
      </div>
      <div class="modal-body no-padding" style="overflow:hidden">          
            <div class="col-md-12 col-sm-12" style="padding-top:10px; padding-bottom:10px;">
                <div class="col-md-8 col-sm-8 no-padding" style="" id="list_product_depend">
                  <!-- list product depend -->
                </div>
                <div class="col-md-4 col-sm-4 no-padding" style="">
                  <div class="form-group">
                    <label>Danh mục cập nhật</label>
                    <select class="form-control select2" style="width: 100%;" id="cat_update">
                          <option value="">--Chọn danh mục--</option>
                          {!! $select_cat2 !!}
                    </select>
                  </div>
                </div>
            </div>
      </div><div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>        
        <button type="button" class="btn btn-primary update_cat" ><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật danh mục và xóa</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('after-scripts-end')
  <script type="text/javascript">
    function formSubmit(id,id_parent){
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
        //$('#delete-form-'+id).submit();
        if(id_parent == 0){
          check_category_depend(id);  
        }else{
          check_product_depend(id);
        }
        
      });
    }

    function check_category_depend(id){
      $.ajax({
          url: base_url+"/category/check_category_depend",
          type: "post",
          dataType: "json",
          data: {
            '_token': tokenvrf,
            'id': id
          },
          success: function(result){
            if(result['status']){
              var idArr = new Array();
              var html = '';
              html += '<ul>';
              $.each(result['data'], function(index,value){
                idArr.push(value['category_id']);                
                html += '<li>'+value['category_name']+'</li>';                
              });
              html += '</ul>';

              $('#list_category_depend').html(html);              
              $('.cat_parent'+id).attr('disabled','disabled');
              $('.update_cat_parent').attr('onclick', 'updateCatParent('+id+',\''+idArr+'\')');
              $('#modal-category-depend').modal('show');
            }else{
              $('#delete-form-'+id).submit();
              swal(
                'Thành công!',
                '',
                'success'
              );
            }
          }
      });      
    }

    function updateCatParent(idDel,idArr){
      var id_new = $('#cat_parent_update').val();
      if( id_new == null ){
        swal({
          title: 'Lỗi',
          text: "Danh mục cập nhật không hợp lệ!",
          type: 'error',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          timer: 1000
        }).then(function() {});
      }else{
        $.ajax({
              url: base_url+"/category/update_category_depend",
              type: "post",
              dataType: "json",
              data: {
                '_token': tokenvrf,
                'idArr': idArr,
                'id_new': id_new
              },
              success: function(result){
                if(result['status']){
                  $('#delete-form-'+idDel).submit();
                  swal(
                    'Thành công!',
                    '',
                    'success'
                  );
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
    }

    function check_product_depend(id){
      $.ajax({
          url: base_url+"/category/check_product_depend",
          type: "post",
          dataType: "json",
          data: {
            '_token': tokenvrf,
            'id': id
          },
          success: function(result){
            if(result['status']){
              var idArr = new Array();
              var html = '';
              html += '<ul>';
              $.each(result['data'], function(index,value){
                idArr.push(value['product_id']);
                html += '<div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px">';
                html += '<img src="{!! asset("uploads/product/'+value['product_image']+'") !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5 marginRight10">';
                html += '<span>'+value['product_name']+'</span>';
                html += '</div>';
              });
              html += '</ul>';

              $('#list_product_depend').html(html);              
              $('#cat_update option[value='+id+']').attr('disabled','disabled');
              $('.update_cat').attr('onclick', 'update_product_depend('+id+',\''+idArr+'\')');
              $('#modal-product-depend').modal('show');
            }else{
              $('#delete-form-'+id).submit();
              swal(
                'Thành công!',
                '',
                'success'
              );
            }
          }
      });      
    }

    function update_product_depend(idDel,idArr){
      var id_new = $('#cat_update').val();
      if( id_new == null ){
        swal({
          title: 'Lỗi',
          text: "Danh mục cập nhật không hợp lệ!",
          type: 'error',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          timer: 1000
        }).then(function() {});
      }else{
        $.ajax({
              url: base_url+"/category/update_product_depend",
              type: "post",
              dataType: "json",
              data: {
                '_token': tokenvrf,
                'idArr': idArr,
                'id_new': id_new
              },
              success: function(result){
                if(result['status']){
                  $('#delete-form-'+idDel).submit();
                  swal(
                    'Thành công!',
                    '',
                    'success'
                  );
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
    }

  </script>
@stop