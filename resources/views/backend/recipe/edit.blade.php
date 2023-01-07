@extends('backend.layouts.master', ['page_title' => 'Chỉnh sửa công thức món ăn'])
@section ('title','Công thức món ăn')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="row">        
        <div class="col-xs-12 col-md-12 recipe">
          <div class="box  box-success"> <!-- collapsed-box -->
            <div class="box-header with-border">
              <h3 class="box-title">Công thức món ăn</h3>
              <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>                  
              </div>
            </div>
            @if (session('flash_message_err3') != '')
              <div class="alert alert-danger" role="alert">{!! session('flash_message_err3')!!}</div>
            @endif
            @if (session('flash_message_succ3') != '')
              <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ3') !!}</div>
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
            
            <div class="box-body">
              <form class="form-inline" action="{!! route('admin.recipe.updateRecipe', ['ctm_id' => $ctm_id]) !!}" method="post" id="saverecipe">
                <div class="">
                  <div class="form-group col-md-12 recipeName">
                      <div class="form-group col-md-3 no-padding">
                        <label for="recipeName">Tên công thức</label>
                        <input type="text" class="form-control" id="recipeName" placeholder="Tên công thức" name="recipeName" value="{!! $ctm_name !!}" >
                      </div>

                      <div class="form-group col-md-5 no-padding">
                        <textarea class="form-control" id="recipeDesc" placeholder="Mô tả" name="recipeDesc" style="width:80%" rows="3">{!! $ctm_desc !!}</textarea>
                      </div>

                      @if(isset($prodSale))
                        <div class="form-group col-md-4 no-padding">
                            <div class="" style="float:left;margin-right:10px;">
                              @if(isset($prodSale->product_image))
                                <img src="{!! asset('uploads/product/'.$prodSale->product_image) !!}" alt="" style="width:80px;max-height:80px;">
                              @else
                                <img src="{!! asset('uploads/product/'.'option.png') !!}" alt="" style="width:80px;max-height:80px;">
                              @endif
                            </div>
                            <div class="">                                
                              @if(isset($prodSale->product_name))
                                <h3>{!! $prodSale->product_name !!}</h3>
                              @else
                                <h3>{!! $prodSale->name !!}</h3>
                              @endif
                            </div>
                        </div>
                        @if(isset($prodSale->product_id))
                          <input type="hidden" name="pid" value="{!! $prodSale->product_id !!}">
                        @else 
                          <input type="hidden" name="pid" value="{!! $prodSale->id !!} ">
                          <input type="hidden" name="token_" value="1">
                        @endif
                    @endif
                  </div>
                </div><div class="clearfix"></div>

                <div class="listProductRecipe">
                  <!-- @if(isset($content))
                    @foreach($content as $key => $item)
                      <div class="productRecipeItem">
                        <div class="no-padding itemCss itemCancel">
                          @if( $item->qty != '' && (float)$item->qty > 0 )
                            <a class="btn btn-danger btn-xs" onclick="del_item_cart_edit_recipe('{!! $item->rowId !!}',{!! $ctm_id !!},{!! $item->id !!});"><i class="fa fa-times"></i></a>
                          @else
                            <a class="btn btn-danger btn-xs" onclick="del_item_cart_edit_recipe('{!! $item->rowId !!}',{!! $ctm_id !!},0);"><i class="fa fa-times"></i></a>
                          @endif
                        </div>
                        <div class="form-group col-md-2 itemName">
                          <span>{!! $item->name !!}</span>
                          <input type="hidden" name="idRecipe[]" value="{!! $item->id !!}">
                          <input type="hidden" name="nameRecipe[]" value="{!! $item->name !!}">
                        </div>
                        
                        <div class="col-md-2 itemCss itemCss1 itemCss1-{!! $key !!}">
                          <span class="required"><strong>&nbsp;(*)&nbsp;</strong></span><input required type="text" class="form-control" placeholder="Lượng" name="qtyRecipe[]" value="{!! $item->qty !!}"  style="width:70%" onblur="updatCartFunctionEdit('{!! $ctm_id !!}','{!! $item->rowId !!}',this.value)"><span>&nbsp;@if(isset($item->options['unit'])){!! $item->options['unit'] !!}@endif</span>
                        </div>
                  
                        <div class="col-md-2 itemCss itemCss2 itemCss2-{!! $key !!} hide">
                          <span class="required"><strong>&nbsp;(*)&nbsp;</strong></span>
                          <input type="hidden" name="qtyRecipe[]" value="{!! $item->qty !!}">
                          <input required type="text" class="form-control" placeholder="Lượng" name="qtyRecipeTop[]" value="{!! $item->options['numTop'] !!}"  style="width:30%" onblur="updatCartFunctionEdit2('{!! $ctm_id !!}','{!! $item->rowId !!}',this.value)"><span style="text-align: center;"> / </span>
                          <input required type="text" class="form-control" placeholder="Lượng" name="qtyRecipeBot[]" value="{!! $item->options['numBot'] !!}"  style="width:30%" onblur="updatCartFunctionEdit3('{!! $ctm_id !!}','{!! $item->rowId !!}',this.value)"><span>&nbsp;@if(isset($item->options['unit'])){!! $item->options['unit'] !!}@endif</span>
                        </div>
                  
                        <div class="col-md-2 itemCss">
                          <span id="changeType-{!! $key !!}" onclick="changeType(1,'{!! $key !!}')" class="label label-primary" style="cursor: pointer;"><i class="fa fa-exchange"></i> Phân số</span>
                        </div>
                  
                      </div><div class="clearfix"></div>
                      end .productStockItem
                    @endforeach
                  @endif -->
                </div><!-- end .listProductStock -->

                <div class="col-md-12 no-padding">
                  <br>
                  <p><strong>Lưu ý: </strong> Sử dụng <span class="required">dấu chấm(.)</span> để phân cách phần thập phân trong nhập liệu lượng và giá sản phẩm </p>
                </div>

                <div class="btnSubmit">
                  <button class="btn btn-primary" id="saverecipe-btn" type="button">Lưu</button>
                </div><!-- end .btnSubmit -->
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        </div> <!-- end .recipe -->

        <div class="col-xs-12 col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Danh sách sản phẩm(nhập)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                    <div class="row">
                        <div class="col-sm-6 no-padding">

                          <!-- <div class="col-md-5 no-padding">                          
                            <form action="">
                              <div class="">
                                <select name="select-option-chose" id="action-option" class="form-control pull-left" style="width:120px;">
                                  <option value="-1">Xử lý</option>
                                  <option value="1">Thêm hàng</option>
                                </select>
                                <a id="action-product" class="btn btn-default form-control pull-left" style="width: 100px;text-align:center">Áp dụng</a>
                              </div>
                            </form>                          
                          </div> -->

                          <div class="col-md-7">                          
                            <a href="{!! route('stock.create') !!}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới sản phẩm thô</button></a>
                          </div>

                        </div>
                        <div class="col-sm-6">                          
                          <form class="form-inline pull-right" action="" method="get">
                            <select name="cat_id" class="form-control pull-left borderRad3 marginRight3">
                              <option value="">--Chọn danh mục--</option>
                              @if(count($category) > 0)
                                @foreach($category as $cat)
                                  <option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
                                @endforeach
                              @endif
                            </select>
                            <div class="form-group">
                              <input class="form-control borderRad3" name="stxt" placeholder="Tên sản phẩm" type="text" value="">
                            </div>
                            <input type="hidden" name="ctm_id" value="{!! $ctm_id !!}">                            
                            @if(isset($prodSale->product_id))
                              <input type="hidden" name="pid" value="{!! $prodSale->product_id !!}">
                              <input type="hidden" name="token_" value="0">
                            @elseif(isset($prodSale->id)) 
                              <input type="hidden" name="pid" value="{!! $prodSale->id !!}">
                              <input type="hidden" name="token_" value="1">
                            @endif
                            <button class="btn btn-default searchProRecipe" type="submit" onclick="return false;"><i class="fa fa-search"></i> Tìm kiếm</button>
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
                    <table id="list-product" class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <tr>
                            <!-- <th></th> -->
                            <!-- <th style="width: 50px;">ID</th> -->
                            <th width="100px">Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Lượng</th>
                            <th>Danh mục</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $product)
                          <tr>
                            <!-- <td><input type="checkbox" value="{{ $product->spt_id }}" class="pid-checkbox"></td> -->
                            <!-- <td>{{ $product->spt_id }}</td> -->
                            <td class="text-center"><img src="{{ asset('uploads/product_stock/'.$product->spt_image) }}" width="80%" max-height="80px" alt=""></td>
                            <td>{{ $product->spt_name }}</td>
                            <td>{{ round($product->spt_quantity,4,PHP_ROUND_HALF_EVEN) }} ({{$product->unit_name}})</td>
                            <td>{{ $product->spt_category_name }}</td>
                            <td>{{ $product->spt_desc }}</td>
                            <td>
                              @if( $product->spt_quantity <= 0.0001 )
                                <span class="label label-danger">Hết hàng</span>
                              @else
                                <span class="label label-success">Còn hàng</span>
                              @endif
                            </td>
                            <td>
                              <!-- <a class="btn btn-info btn-xs" href="{!! route('stock.edit', ['id' => $product->spt_id]) !!}"><i class="fa fa-pencil"></i></a>
                              <form id="delete-form-{{$product->spt_id}}" class="" style="display:inline-block" action="{!! route('stock.destroy', ['id' => $product->spt_id]) !!}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="btn btn-danger btn-xs" onclick="javascript:del_product({{$product->spt_id}});"><i class="fa fa-minus-circle"></i></a>
                              </form> -->
                              <a class="btn btn-success btn-xs marginRight3" onclick="add_cart_edit_recipe({{ $product->spt_id }},{{ $ctm_id }})"><i class="fa fa-plus"></i> Thêm vào công thức</a>

                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$products->appends(Request::only(['pid']))->links()}}
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

      $('#saverecipe-btn').on('click', function(){
        $(this).hide();
        $('#saverecipe').submit();
      });

      refresh_cart_edit_recipe({!! $ctm_id !!});
    });


  </script>

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
      cancelButtonText: 'Hủy',
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false
    }).then(function() {
      $('#delete-form-'+id).submit();  
      swal(
        'Đã xóa!',
        '',
        'success'
      );
    })
  }

  $(window).on('hashchange',function(){
          page = window.location.hash.replace('#','');
          //getProducts(page);
    });
    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var id = $(this).attr('href').split('id=')[1];
        $(this).parents().parents().find('li.active').removeClass('active');
        $(this).parents().addClass('active');
        getProductEdit(page,{!! $id !!});
        location.hash = page;
    });

    $(document).on('click','.searchProRecipe', function(e){
        e.preventDefault();
        getProductEdit(1,{!! $id !!});
        location.hash = 1;
    });

    function getProductEdit(page,id){
      console.log(page);
      var xhtml ="";
       $.ajax({
          url: '{!!route('admin.recipe.getProductEdit')!!}?id='+id+'&page='+page+'&pid='+{!! Request::input('pid') !!}+'&cat_id='+$('select[name=cat_id]').val()+'&stxt='+$('input[name=stxt]').val()+'&token_='+$('input[name=token_]').val(),
          type: 'GET',
          //dataType: 'json'
      }).done(function(data){
          if (data) {
             $("#list-product tbody").html(data.html);
             $("#pagination-link").html(data.pagi);
          }
      });
    }
    //getProductEdit(1,{!! $id !!});
  </script>
@stop