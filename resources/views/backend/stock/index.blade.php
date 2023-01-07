@extends('backend.layouts.master', ['page_title' => 'Danh sách sản phẩm thô(nhập)'])
@section ('title','Quản lý sản phẩm thô(nhập)')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <!-- <h3 class="box-title">Danh sách sản phẩm thô(nhập)</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                    <div class="row">
                        <div class="col-sm-12 no-padding">
                          <div class="col-md-12">
                            <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: auto;max-width: 100px;" >
                              <option value="-1">--Xử lý--</option>
                              <option value="1">Xóa</option>
                            </select>
                            <a id="apply-select" class="btn btn-default form-control pull-left marginRight3 marginBot5" style="width: auto;max-width: 100px;text-align:center">Áp dụng</a>

                            <a href="{!! route('stock.create') !!}"><button type="button" class="btn btn-primary marginBot5"><i class="fa fa-plus"></i> Thêm mới</button></a>
                            <button type="button" class="btn btn-primary marginBot5" data-toggle="modal" data-target="#modal-pstatus"><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật trạng thái</button>
                          </div>
                        </div>

                        <div class="col-sm-12 pull-right">                          
                          <form class="form-inline pull-right" action="{!! route('admin.stock.search') !!}" method="get">
                            <select name="cat_id" class="form-control pull-left borderRad3 marginRight3 marginBot5">
                              <option value="">--Chọn danh mục--</option>
                              @if(count($category) > 0)
                                @foreach($category as $cat)
                                  <option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
                                @endforeach
                              @endif
                            </select>
                            <div class="form-group">
                              <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="Tên sản phẩm" type="text" value="">
                            </div>
                            <button class="btn btn-default marginBot5" type="submit" onclick=""><i class="fa fa-search"></i> Tìm kiếm</button>
                          </form>
                        </div>
                    </div>
                
                <br>
                <div>
                  @if (session('flash_message_err') != '')
                    <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <tr>
                            <th style="width: 50px;"><input name="checkall-toggle" type="checkbox" id="checkAll"></th>
                            <th width="100px">Ảnh</th>
                            <th style="min-width: 115px">Tên sản phẩm</th>
                            <th>Lượng</th>
                            <th>Danh mục</th>
                            <th>Mô tả</th>
                            <th style="width: 90px;">Trạng thái</th>
                            <th style="width: 70px;">Xử lý</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $product)
                          <tr>
                            <td><input type="checkbox" value="{{ $product->spt_id }}" class="id-checkbox check"></td>
                            <!-- <td>{{ $product->spt_id }}</td> -->
                            <td class="text-center"><img src="{{ asset('uploads/product_stock/'.$product->spt_image) }}" width="80%" height="80px" alt=""></td>
                            <td>{{ $product->spt_name }}</td>
                            <?php
                              /*if( $product->spt_quantity < 1 && $product->spt_quantity > -1 && $product->spt_quantity != 0){
                                $qtyRat = float2rat($product->spt_quantity);
                                $qty = $qtyRat['numTop'].'/'.$qtyRat['numBot'];
                              }else{
                                $qty = $product->spt_quantity;----- {{ $qty }} 
                              }*/
                            ?>
                            <td>{{ round($product->spt_quantity,6) }} ({{$product->unit_name}})</td>
                            <td>{{ $product->spt_category_name }}</td>
                            <td>{{ $product->spt_desc }}</td>
                            <td>
                              @if( $product->spt_quantity <= 0 )
                                <span class="label label-danger">Hết hàng</span>
                              @else
                                <span class="label label-success">Còn hàng</span>
                              @endif
                            </td>
                            <td>
                              
                              <a class="btn btn-info btn-xs marginBot5" href="{!! route('stock.edit', ['id' => $product->spt_id]) !!}"><i class="fa fa-pencil"></i></a>
                              <form id="delete-form-{{$product->spt_id}}" style="display:inline-block" action="{!! route('stock.destroy', ['id' => $product->spt_id]) !!}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_product({{$product->spt_id}});"><i class="fa fa-minus-circle"></i></a>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$products->links()}}
                </div>
            </div>
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

          <div class="modal fade modal-pstatus" tabindex="-1" role="dialog" id="modal-pstatus">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><strong>Danh sách sản phẩm hết hàng</strong></h4>
                </div>
                <div class="modal-body no-padding" style="overflow:hidden">
                  @if(isset($listProductOver) && count($listProductOver) > 0)
                    <div class="col-md-12 col-sm-12"><h4><strong>Sản phẩm</strong></h4></div>
                    @foreach($listProductOver as $kOver => $vOver)
                      <div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px;"> 
                          <div class="col-md-7 col-sm-7">
                            <img src="{!! asset('uploads/product/'.$vOver->product_image) !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5">
                            <span> {!! $vOver->product_name !!} </span>
                          </div>
                          <div class="col-md-5 col-sm-5 text-right">
                            <button class="btn btn-xs btn-warning pOver pOver-{!! $vOver->product_id !!}" onclick="stsOverProduct({!! $vOver->product_id !!},['{!! $vOver->product_id !!}']);"><i class="fa fa-exchange" aria-hidden="true"></i> Cập nhật hết hàng</button>
                            <img src="{!! asset('images/icon/processing01.gif') !!}" class="hide pOverGif pOverGif-{!! $vOver->product_id !!}">
                          </div>
                      </div>
                    @endforeach
                  @endif

                  @if(isset($listOptionOver) && count($listOptionOver) > 0)
                    <div class="col-md-12 col-sm-12"><h4><strong>Option</strong></h4></div>
                    @foreach($listOptionOver as $kOverOp => $vOverOp)
                      <div class="col-md-12 col-sm-12 no-padding" style="margin-bottom:5px;">
                          <div class="col-md-7 col-sm-7">
                            <img src="{!! asset('uploads/product_stock/1476239940.option.png') !!}" alt="" style="width:70px;max-height:50px;" class="border1ccc padding5">
                            <span>{!! $vOverOp->name !!}</span>
                          </div>
                          <div class="col-md-5 col-sm-5 text-right">
                            <button class="btn btn-xs btn-warning opOver opOver-{!! $vOverOp->id !!}" onclick="stsOverOption({!! $vOverOp->id !!},['{!! $vOverOp->id !!}']);"><i class="fa fa-exchange" aria-hidden="true"></i> Cập nhật hết hàng</button>
                            <img src="{!! asset('images/icon/processing01.gif') !!}" class="hide opOverGif opOverGif-{!! $vOverOp->id !!}">
                          </div>
                      </div>
                    @endforeach
                  @endif
                </div><div class="clearfix"></div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>
                  @if( (isset($listOptionOver) && count($listOptionOver) > 0) || (isset($listProductOver) && count($listProductOver) > 0) )
                  <button type="button" class="btn btn-primary stsOver" onclick="stsOver('{!! $listProductIdOver !!}','{!! $listOptionIdOver !!}');"><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật hết hàng</button>
                  @endif

                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

          <!-- /.modal-recipe -->
          <div class="modal" tabindex="-1" role="dialog" id="modal-recipe">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><strong>Danh sách công thức phụ thuộc</strong></h4>
                </div>
                <div class="modal-body">
                  <ul id="listRecipeDepend"></ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Đóng</button>
                  <button type="button" class="btn btn-primary" id="update-recipe"><i class="fa fa-paper-plane" aria-hidden="true"></i> Cập nhật công thức và xóa sản phẩm thô</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

    </section>
    <!-- /.content -->
@endsection

@section('after-scripts-end')
{{ Html::script(asset('js/bfunction.js')) }}
{{ Html::script(asset('js/bootstrap-datepicker.js')) }}
  <script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true
    });
    $(document).ready(function(){
      $('.newNsx').on('click', function(){
        $('.nsxNew').removeClass('hide');
      });

      $("#checkAll").click(function () {
          $(".check").prop('checked', $(this).prop('checked'));
      });
    });
  </script>

  <script type="text/javascript">    
    function del_product(id){
      swal({
        title: 'Thông báo',
        text: "Bạn chắc chắn thực hiện hành động này?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy',
      }).then(function() {
          $.ajax({
              url: base_url+"/stock/check_recipe",
              type: "post",
              dataType: "json",
              data: {
                "_token": tokenvrf,
                'spt_id': id
              },
              success: function(result){
                if(result['success']){
                  var html = '';
                  var idArr = new Array();
                  $.each(result['data'], function( index, value ) {
                    html += '<li>'+value['ctm_name']+'</li>';
                    idArr.push(value['ctm_id']);
                    
                  });
                  console.log(idArr);
                  $('#listRecipeDepend').html(html);
                  $('#update-recipe').attr('onclick', 'updateRecipeDepend(\''+id+'\',\''+idArr+'\')');
                  $('#modal-recipe').modal('show');

                }else{
                    $('#delete-form-'+id).submit();
                }
                
              }
          });
      });
    }

    function updateRecipeDepend(id,idArr){
      $.ajax({
            url: base_url+"/stock/update_recipe_depend",
            type: "post",
            dataType: "json",
            data: {
              "_token": tokenvrf,
              'spt_id': id,
              'idArr': idArr
            },
            success: function(result){
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
                  $('#delete-form-'+id).submit();
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

    function checkRecipeAjax(listIdStock){
      $.ajax({
          url: base_url+"/stock/check_recipe_more",
          type: "post",
          dataType: "json",
          data: {
            "_token": tokenvrf,
            'listIdStock': listIdStock
          },
          success: function(result){
            if(result['success']){
              var html = '';
              var idArr = new Array();
              $.each(result['data'], function( index, value ) {
                html += '<li>'+value['ctm_name']+'</li>';
                idArr.push(value['ctm_id']);
                
              });
              console.log(idArr);
              $('#listRecipeDepend').html(html);
              $('#update-recipe').attr('onclick', 'updateRecipeDependMore(\''+listIdStock+'\',\''+idArr+'\')');
              $('#modal-recipe').modal('show');
            }else{
                delMoreAjax(listIdStock);
            }
            
          }
      });
    }

    function updateRecipeDependMore(listIdStock,idArr){
      $.ajax({
            url: base_url+"/stock/update_recipe_depend_more",
            type: "post",
            dataType: "json",
            data: {
              "_token": tokenvrf,
              'listIdStock': listIdStock,
              'idArr': idArr
            },
            success: function(result){
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
                  var listIdStock2 = listIdStock.split(",");
                  delMoreAjax(listIdStock2);
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

    function delMoreAjax(idArr){
        $.ajax({
            url: base_url+"/stock/del_more",
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
                  location.href = base_url+'/stock';
                  
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
                      console.log(idArr);
                      checkRecipeAjax(idArr);
                  }
              });            
          }          
        }
      });

    });
  </script>
@stop