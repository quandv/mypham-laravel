@extends('backend.layouts.master', ['page_title' => 'Quản lý sản phẩm'])
@section ('title','Quản lý sản phẩm')
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
                
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                          <div class="col-md-12 no-padding">
                            @if($hethang)
                            <form>
                              <div>
                                <select name="select-option-chose" id="action-option" class="form-control pull-left borderRad3 marginBot5 marginRight3" style="width: 150px;">
                                  <option value="-1">Xử lý</option>
                                  <option value="0">Hết hàng</option>
                                  <option value="1">Còn hàng</option>
                                </select>
                                <a id="action-product" class="btn btn-default form-control pull-left marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                              </div>
                            </form>
                            @endif

                            @if($managerProduct)
                            <a href="{!! route('admin.product.create') !!}" class="marginLeft3 marginBot5">
                              <button type="button" class="btn btn-primary marginBot5"><i class="fa fa-plus"></i> Thêm mới</button>
                            </a>
                            @endif
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <form class="form-inline pull-right" action="{!! route('admin.product.search') !!}" method="get">
                            <select name="cat_id" class="form-control pull-left borderRad3 marginBot5 marginRight3">
                              <option value="">--Chọn danh mục--</option>
                              {!! $select_cat !!}
                            </select>
                            <div class="form-group">
                              <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="Tên sản phẩm" type="text" value="@if($stxt){{$stxt}}@endif">
                            </div>
                            <button class="btn btn-default marginBot5" type="submit" onclick=""><i class="fa fa-search"></i> Tìm kiếm</button>
                          </form>
                        </div>
                    </div>

                <br>
                <div>
                  @if ($stxt != '')
                    @if($category_name != false)
                      <div class="alert alert-success" role="alert">Kết quả tìm kiếm với danh mục <strong>"{{$category_name}}"</strong> và từ khóa <strong>"{{$stxt}}"</strong></div>
                    @else
                      <div class="alert alert-success" role="alert">Kết quả tìm kiếm với từ khóa <strong>"{{$stxt}}"</strong></div>
                    @endif
                  @else
                    @if($category_name != false)
                      <div class="alert alert-success" role="alert">Kết quả tìm kiếm với danh mục <strong>"{{$category_name}}"</strong></div>
                    @endif
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                     	<thead>
    			                <tr>
                            <th></th>
    			                  <th style="width: 50px;">ID</th>
    			                  <th>Ảnh</th>
    			                  <th>Tên sản phẩm</th>
    			                  <th>Giá sản phẩm</th>
    			                  <th>Danh mục</th>
    			                  <th style="width: 350px;">Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Xử lý</th>
    			                </tr>
    			            </thead>
    			            <tbody>
                        @foreach($products as $product)
    			                <tr>
                            <td><input type="checkbox" value="{{ $product->product_id }}" class="pid-checkbox"></td>
    			                  <td>{{ $product->product_id }}</td>
    			                  <td><img src="{{ asset('uploads/product/'.$product->product_image) }}" width="100px" alt=""></td>
    			                  <td>
                                <div class="col-md-12 no-padding">
                                    <strong>{{ $product->product_name }}</strong>
                                </div>
                                @if( isset($product->option_name_group) && count($product->option_name_group) > 0 )
                                <div class="col-md-12">
                                  <ul>
                                    @foreach( $product->option_name_group as $optionItem )
                                    <li>{!! $optionItem !!}</li>
                                    @endforeach
                                  </ul>
                                </div>
                                @endif
                            </td>
    			                  <td>{{ number_format($product->product_price, '0', ',', '.' ) }}</td>
    			                  <td>{{ $product->category_name }}</td>
                            <td>{{ $product->product_desc }}</td>
                            <td>
                              @if( $product->status == 0 )
                                <span class="label label-danger">Hết hàng</span>
                              @else
                                <span class="label label-success">Còn hàng</span>
                              @endif
                            </td>
                            <td>
                              @if($managerProduct)
                              <a class="btn btn-info btn-xs marginBot5" href="{!! route('admin.product.edit', ['id' => $product->product_id]) !!}"><i class="fa fa-pencil"></i></a>
                              <form id="delete-product-{{$product->product_id}}" style="display:inline-block" action="{!! route('admin.product.destroy', ['id' => $product->product_id]) !!}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="btn btn-danger btn-xs marginBot5" onclick="javascript:del_product({{$product->product_id}});"><i class="fa fa-minus-circle"></i></a>
                              </form>
                              @endif
                              
                              @if($managerRecipe)
                                @if($product->product_ctm_id > 0)
                                  <a class="btn btn-warning btn-xs marginBot5" href="{!! route('recipe.edit', ['ctm_id' => $product->product_ctm_id, 'pid' => $product->product_id]) !!}"><i class="fa fa-pencil"></i> Chỉnh sửa công thức</a>
                                @else
                                  <a class="btn btn-primary btn-xs marginBot5" href="{!! route('recipe.create', ['pid' => $product->product_id]) !!}"><i class="fa fa-plus"></i> Tạo công thức</a>
                                @endif
                              @endif

                            </td>
    			                </tr>
                          @endforeach
    			            </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$products->appends(Request::only(['stxt', 'cat_id']))->links()}}
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
    function del_product(id){
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
        $('#delete-product-'+id).submit();  
      });
    }

    $(document).ready(function(){
      $('#action-product').on('click', function(){
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
                      url: base_url+"/product/updatestatus",
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