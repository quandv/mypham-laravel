@extends('backend.layouts.master', ['page_title' => 'Chỉnh sửa hóa đơn nhập'])
@section ('title','Chỉnh sửa hóa đơn nhập')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="row">        
        <div class="col-xs-12 col-md-12 bill">
          <div class="box  box-primary"> <!-- collapsed-box -->
            <div class="box-header with-border">
              <h3 class="box-title">Nhập hàng</h3>
              <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>                  
              </div>
            </div>
            @if (session('flash_message_err3') != '')
              <div class="alert alert-danger" role="alert">{!! session('flash_message_err3')!!}</div>
            @endif
            @if (session('flash_message_succ2') != '')
              <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ2') !!}</div>
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
              <form class="form-inline" action="{!! route('admin.bill.updateBill', ['hdn_id' => $hdn_id]) !!}" method="post" >
                <div class="">
                  <div class="form-group col-md-12 billCode">
                      <div class="form-group col-md-3 no-padding">
                        <label for="billName">Mã hóa đơn</label>
                        <input type="text" class="form-control" id="billName" placeholder="Mã hóa đơn" name="billName" value="@if(isset($hdn_code)){!!$hdn_code!!}@endif">
                      </div>
                      <div class="form-group col-md-9 no-padding">                        
                        <div class="col-md-12 nsxClass">
                          <div class="col-md-2 text-right"><label>Nhà sản xuất: </label></div>
                          <div class="col-md-9">
                            <select name="nsxOld" class="form-control">
                              <option value=""> -- Chọn nhà sản xuất --</option>
                              @if(!empty($listNsx) && count($listNsx) > 0)
                                @foreach($listNsx as $nsx)
                                  <option value="{!! $nsx->nsx_id !!}" @if( isset($hdn_nsx_id) && ($hdn_nsx_id == $nsx->nsx_id)) selected @endif >{!! $nsx->nsx_name !!}</option>
                                @endforeach
                              @endif
                            </select>
                            <button class="btn btn-primary btn-xs newNsx" type="button"><i class="fa fa-plus"></i> Nhà sản xuất mới</button>
                          </div>
                        </div>
                        <div class="col-md-12 nsxClass nsxNew">
                          <div class="col-md-2 text-right"><label>Nhà sản xuất mới: </label></div>
                          <div class="col-md-9">
                            <input type="text" class="form-control"  placeholder="Nhà sản xuất mới" name="nsxNew" value="{!! old('nsxNew') !!}">
                            <input type="text" class="form-control"  placeholder="Số điện thoại" name="nsxPhone" value="{!! old('nsxPhone') !!}">
                            <input type="email" class="form-control" placeholder="Email" name="nsxEmail" value="{!! old('nsxEmail') !!}">
                            <input type="text" class="form-control"  placeholder="Địa chỉ" name="nsxAddr" value="{!! old('nsxAddr') !!}" style="width:300px">
                          </div>
                        </div>
                      </div>
                    </div>
                </div><div class="clearfix"></div>

                <div class="listProductStock">
                  @if(isset($content))
                    @foreach($content as $key => $item)
                      <div class="productStockItem">
                        <div class="no-padding itemCss itemCancel">
                          @if( $item->options['hn_quantity'] != '' && $item->options['hn_quantity'] > 0 )
                            <a class="btn btn-danger btn-xs" onclick="del_item_cart_edit_bill('{!! $item->rowId !!}',{!! $hdn_id !!},{!! $item->id !!});"><i class="fa fa-times"></i></a>
                          @else
                            <a class="btn btn-danger btn-xs" onclick="del_item_cart_edit_bill('{!! $item->rowId !!}',{!! $hdn_id !!},0);"><i class="fa fa-times"></i></a>
                          @endif
                        </div>
                        <div class="form-group col-md-2 itemName">
                          <span>{!! $item->name !!}</span>
                        </div>
                        
                        <div class="col-md-2 itemCss">
                          <span class="required"><strong>&nbsp;(*)&nbsp;</strong></span><input required type="text" id="qty{!! $item->id !!}" class="form-control" placeholder="Lượng" name="productQuantity[]" value="@if(isset($item->options['hn_quantity'])){!! $item->options['hn_quantity'] !!}@endif"  style="width:70%"><span>&nbsp;@if(isset($item->options['unit'])) {!! $item->options['unit'] !!}@endif</span>
                        </div>

                        <div class="col-md-2 itemCss">
                          <span class="required"><strong>&nbsp;(*)&nbsp;</strong></span><input required type="text" id="price{!! $item->id !!}"class="form-control" placeholder="Giá" name="productPrice[]" value="@if(isset($item->options['hn_price'])){!! $item->options['hn_price'] !!}@endif" style="width:70%"><span>&nbsp;vnđ</span>
                        </div>
                      
                        <div class="col-md-2 itemCss">
                          <input type="datetime" class="form-control datepicker" data-date-format="yyyy-mm-dd" placeholder="Hạn dùng" name="productExpiry[]" style="width:90%" value="@if($item->options['hn_time_expiry'] != '0000-00-00'){!! $item->options['hn_time_expiry'] !!}@endif">
                        </div>
                        
                      </div><div class="clearfix"></div>
                      <!-- end .productStockItem -->
                    @endforeach
                  @endif
                </div><!-- end .listProductStock -->

                <div class="col-md-12 no-padding">
                  <br>
                  <p><strong>Lưu ý: </strong> Sử dụng <span class="required">dấu chấm(.)</span> để phân cách phần thập phân trong nhập liệu lượng và giá sản phẩm </p>
                </div>

                <div class="btnSubmit">
                  <button class="btn btn-primary" type="submit">Lưu</button>
                </div><!-- end .btnSubmit -->
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        </div> <!-- end .bill -->

        <div class="col-xs-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Danh sách sản phẩm(nhập)</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                    <div class="row">
                        <div class="col-sm-6">

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
                            <a href="{!! route('stock.create') !!}"><button type="button" class="btn btn-primary">Thêm mới sản phẩm thô</button></a>
                          </div>

                        </div>
                        <div class="col-sm-6">                          
                          <form class="form-inline pull-right" action="{!! route('admin.bill.search_edit') !!}" method="get">
                            <select name="cat_id" class="form-control pull-left">
                              <option value="">--Chọn danh mục--</option>
                              @if(count($category) > 0)
                                @foreach($category as $cat)
                                  <option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
                                @endforeach
                              @endif
                            </select>
                            <div class="form-group">
                              <input class="form-control" name="stxt" placeholder="Tên sản phẩm" type="text" value="">
                            </div>
                            <input type="hidden" name="hdn_id" value="{!! $hdn_id !!}">
                            <button class="btn btn-default" type="submit" onclick=""><i class="fa fa-search"></i> Tìm kiếm</button>
                          </form>
                        </div>
                    </div>                
                <br>
                <div>
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
                  @if (session('flash_message_err') != '')
                    <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
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
                            <td class="text-center"><img src="{{ asset('uploads/product_stock/'.$product->spt_image) }}" width="80%" height="80px" alt=""></td>
                            <td>{{ $product->spt_name }}</td>
                            <td>{{ round($product->spt_quantity,4) }} ({{$product->unit_name}})</td>
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
                              
                              <a class="btn btn-info btn-xs" href="{!! route('stock.edit', ['id' => $product->spt_id]) !!}"><i class="fa fa-pencil"></i></a>
                              <form id="delete-form-{{$product->spt_id}}" style="display:inline-block" action="{!! route('stock.destroy', ['id' => $product->spt_id]) !!}" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <a class="btn btn-danger btn-xs" onclick="javascript:del_product({{$product->spt_id}});"><i class="fa fa-minus-circle"></i></a>
                              </form>
                              <a class="btn btn-success btn-xs" onclick="add_cart_edit_bill({{ $product->spt_id }},{{ $hdn_id }});"><i class="fa fa-plus"></i> Thêm hàng</a>

                            </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$products->appends(Request::only(['stxt', 'cat_id', 'hdn_id']))->links()}}
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
      $('.nsxNew').hide();
      $('.newNsx').on('click', function(){
          var sts = $('.nsxNew');
          if (sts.is(':visible')) {
              sts.slideUp();
              $('.newNsx i').removeClass('fa-minus').addClass('fa-plus');
          } else {
              sts.slideDown();
              $('.newNsx i').removeClass('fa-plus').addClass('fa-minus');
          }
      });

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

  $(document).ready(function(){
      $('#action-product').on('click', function(){
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
                confirmButtonText: 'Đồng ý'
              }).then(function() {
                  if(parseInt(action) == 1){
                      $.ajaxSetup({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                      });
                      $.ajax({
                          url: base_url+"/product_stock/listProductStockInBill",
                          type: "post",
                          dataType: "json",
                          data: {
                            'idArr': idArr
                          },
                          success: function(result){
                          console.log(result);
                            if(result){
                                swal({
                                  title: 'Bạn có muốn lựa chọn sản phẩm khác trong hóa đơn này hóa đơn này?',
                                  text: '',
                                  type: 'success',
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Đồng ý',
                                  cancelButtonText: 'Xử lý hóa đơn',
                                  cancelButtonColor: '#3085d6',
                                }).then(function() {

                                }, function(dismiss) {
                                  
                                });
                                
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