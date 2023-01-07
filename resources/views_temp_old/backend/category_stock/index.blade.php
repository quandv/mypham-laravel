@extends('backend.layouts.master',['page_title'=> 'Loại hàng nhập'])
@section ('title','Loại hàng nhập')
@section('content')
<!-- Select2 -->
{{ Html::style(asset('bower_components/AdminLTE/plugins/select2/select2.min.css')) }}

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
                <h3 class="box-title">Thêm mới Loại hàng nhập</h3>
            </div> 
            <form role="form" method="post" action="{!! route('category_stock.store') !!}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group ">
                        <label for="post_name_" class="control-label">Loại hàng nhập<span class="required">*</span></label>
                        <div>
                            <input class="form-control" id="post_name_" name="name" placeholder="Loại hàng nhập" type="text" value="{!! old('name')!!}">
                         </div>
                    </div>

                    <div class="form-group">
                      <label>Đơn vị: </label>
                      @if(!empty($unit))
                        @foreach($unit as $dv)
                          <label class="radio-inline">
                            <input type="radio" name="unit" value="{!! $dv->dv_id !!}"> {!! $dv->dv_name !!}
                          </label>
                        @endforeach
                      @endif
                    </div>

                    <div class="form-group ">
                        <label for="description_" class="control-label">Mô tả</label>
                        <div>
                            <textarea class="form-control" id="description_" name="desc" rows="7" placeholder="Mô tả">{!! old('desc')!!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <label>Trạng thái: </label>
                      <label class="radio-inline">
                        <input type="radio" name="status" value="1" checked> Hiện
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="status" value="0"> Ẩn
                      </label>
                    </div>

                    <!-- <div class="form-group">
                          <label for="fileImage">Ảnh</label>
                          <input type="file" id="fileImage" name="fileImage">
                          <p class="help-block">Ảnh Loại hàng nhập.</p>
                    </div> -->
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
    <div class="col-sm-12 col-lg-7">
        <div class="box box-primary">
            <div class="box-body">
                <form action="{!! route('admin.category_stock.search') !!}" method="get" id="post_search_form" class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-sm-6">
                          <div class="">
                            <select name="select-option-chose" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: 150px;" >
                              <option value="-1">--Xử lý--</option>
                                <option value="1">Xóa</option>                              
                            </select>
                            <a id="apply-select" class="btn btn-default form-control pull-left marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                          </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <div class="input-group">
                                      <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="Loại hàng nhập" type="text" value="{!! Request::get('stxt')!!}">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default marginBot5" type="submit">
                                            <i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="table-responsive">                     
                  <table class="table table-bordered table-hover table-striped k-table-list" id="tbl_cat_stock">
                      <thead>
                          <th style="width: 50px;"><input name="checkall-toggle" type="checkbox" id="checkAll"></th>
                          <th>Loại hàng nhập</th>
                          <th>Đơn vị</th>
                          <th>Mô tả</th>
                          <!-- <th>Trạng thái</th> -->
                          <th style="width: 100px">Xử lý</th>
                      </thead>
                      <tbody>
                        @if(!empty($list))
                          @foreach($list as $item)
                            <tr>
                              <td><input type='checkbox' value='{!! $item->id !!}'  class="catStock-checkbox check"></td>
                              <td>{!! $item->name !!}</td>
                              <td>{!! $item->unit_name !!}</td>
                              <td>{!! $item->desc !!}</td>
                              <!-- <td>
                                @if( $item->status == 0 )
                                  <span class="label label-default">Ẩn</span>
                                @else
                                  <span class="label label-success">Hiện</span>
                                @endif
                              </td> -->
                              <td>
                                <a class="btn btn-info btn-xs" href="{!! route('category_stock.edit', ['id' => $item->id]) !!}"><i class="fa fa-pencil"></i></a>
                                  <form id="delete-form-{{$item->id}}" style="display:inline-block" action="{!! route('category_stock.destroy', ['id' => $item->id]) !!}" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a class="btn btn-danger btn-xs" onclick="javascript:del_unit({{$item->id}});"><i class="fa fa-minus-circle"></i></a>
                                  </form>
                              </td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                  </table>            
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$list->links()}}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>

<div class="modal fade modal-pstatus" tabindex="-1" role="dialog" id="modal-stock-depend">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Danh sách sản phẩm thô phụ thuộc</strong></h4>
      </div>
      <div class="modal-body no-padding" style="overflow:hidden">          
            <div class="col-md-12 col-sm-12" style="padding-top:10px; padding-bottom:10px;">
                <div class="col-md-8 col-sm-8 no-padding" style="" id="list_stock_depend">
                  <!-- list stock depend -->
                </div>
                <div class="col-md-4 col-sm-4 no-padding" style="">
                  <div class="form-group">
                    <label>Danh mục cập nhật</label>
                    <select class="form-control select2" style="width: 100%;" id="dm_spt_update">
                      <option value="0" disabled>--Chọn danh mục mới--</option>
                      @if(count($list_dm_spt) > 0)                        
                        @foreach($list_dm_spt as $dm_spt)                        
                          <option class="dm_spt dm_spt_{!! $dm_spt->id !!}" value="{!! $dm_spt->id !!}">{!! $dm_spt->name !!}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
            </div>
      </div><div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>        
        <button type="button" class="btn btn-primary update_cat_stock" ><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật danh mục và xóa</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


@endsection


@section('after-scripts-end')
{{ Html::script(asset('bower_components/AdminLTE/plugins/select2/select2.full.min.js')) }}
<script type="text/javascript">
  function del_unit(id){
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
      $.ajax({
          url: base_url+"/category_stock/check_stock_depend",
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
              $.each(result['list_spt'], function(index,value){
                idArr.push(value['spt_id']);
                html += '<div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px">';
                html += '<img src="{!! asset("uploads/product_stock/'+value['spt_image']+'") !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5 marginRight10">';
                html += '<span>'+value['spt_name']+'</span>';
                html += '</div>';
              });

              $('#list_stock_depend').html(html);              
              $('.dm_spt_'+id).attr('disabled','disabled');
              $('.update_cat_stock').attr('onclick', 'updateCatStock('+id+',\''+idArr+'\')');
              $('#modal-stock-depend').modal('show');
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
      
    })
  }

  function updateCatStock(idDel,idArr){
    var id_new = $('#dm_spt_update').val();
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
            url: base_url+"/category_stock/update_stock_depend",
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

  //DELETE MORE CATEGORY STOCK
  function checkStockMore(idDelArr){ console.log(idDelArr);
    $.ajax({
          url: base_url+"/category_stock/check_stock_more_depend",
          type: "post",
          dataType: "json",
          data: {
            '_token': tokenvrf,
            'idDelArr': idDelArr
          },
          success: function(result){
            if( result['status'] == 2){
              swal({
                title: 'Lỗi',
                text: "Đang có sản phẩm phụ thuộc, vui lòng không xóa tất cả các danh mục đang có.",
                type: 'error',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
              }).then(function() {});
            }else{
              if(result['status'] == 1){
                var idArr = new Array();
                var html = '';
                $.each(result['data'], function(index,value){
                  idArr.push(value['spt_id']);
                  html += '<div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px">';
                  html += '<img src="{!! asset("uploads/product_stock/'+value['spt_image']+'") !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5 marginRight10">';
                  html += '<span>'+value['spt_name']+'</span>';
                  html += '</div>';
                });

                $('#list_stock_depend').html(html);
                $('.dm_spt').removeAttr('disabled');
                $.each(idDelArr, function(index,value){
                  $('.dm_spt_'+value).attr('disabled','disabled');
                });
                $('.update_cat_stock').attr('onclick', 'updateCatStockMore(\''+idDelArr+'\',\''+idArr+'\')');
                $('#modal-stock-depend').modal('show');
              }else{
                del_more(idDelArr);
              }
            }
            
          }
      });
  }

  function updateCatStockMore(idDelArr,idArr){
    var id_new = $('#dm_spt_update').val();
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
            url: base_url+"/category_stock/update_stock_more_depend",
            type: "post",
            dataType: "json",
            data: {
              '_token': tokenvrf,
              'idArr': idArr,
              'id_new': id_new
            },
            success: function(result){
              if(result['status']){
                del_more(idDelArr);
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

  function del_more(idArr){
    $.ajax({
        url: base_url+"/category_stock/del_more",
        type: "post",
        dataType: "json",
        data: {
          '_token': tokenvrf,
          'idArr': idArr
        },
        success: function(result){  
        console.log(result);
          if(result){
              swal({
                title: 'Thành công',
                text: '',
                type: 'success'
              });
              location.href = base_url+'/category_stock';
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

  //process del-more
  $(document).ready(function(){
      //check all checkbox
      $("#checkAll").click(function () {
          $(".check").prop('checked', $(this).prop('checked'));
      });
      //process select box
      $('#apply-select').on('click',function(){
        var action = $('select[name=select-option-chose]').val();
        if(parseInt(action) < 0){
          swal({
            title: 'Lỗi',
            text: "Bạn chưa chọn hành động",
            type: 'error',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            timer: 2000
          }).then(function() {});

        }else{
          var idArr = new Array();
          $('.catStock-checkbox').each(function(){
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
                //check stock for cat stock                
                checkStockMore(idArr);
                  
              });            
          }          
        }

      });  
    });
    //END -- DELETE MORE CATEGORY STOCK
</script>
@stop