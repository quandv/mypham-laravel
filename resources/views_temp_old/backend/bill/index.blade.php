@extends('backend.layouts.master', ['page_title' => 'Danh sách hóa đơn nhập'])
@section ('title','Quản lý hóa đơn nhập')
@section('content')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <!-- <h3 class="box-title">Danh sách hóa đơn</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">                
                    <div class="row">
                        <div class="col-sm-12">

                          <!-- <div class="col-md-5 no-padding">                          
                            <form action="">
                              <div class="">
                                <select name="select-option-chose" id="action-option" class="form-control pull-left" style="width: 150px;">
                                  <option value="-1">Xử lý</option>
                                  <option value="0">Hết hàng</option>
                                  <option value="1">Còn hàng</option>
                                </select>
                                <a id="action-product" class="btn btn-default form-control pull-left" style="width: 100px;text-align:center">Áp dụng</a>
                              </div>
                            </form>                          
                          </div> -->

                          <div class="col-md-4 no-padding">                          
                            <a href="{!! route('bill.create') !!}">
                              <button type="button" class="btn btn-primary marginBot5"><i class="fa fa-plus"></i> Thêm mới</button>
                            </a>                          
                          </div>

                        </div>
                        <div class="col-sm-12">                          
                          <form class="form-inline pull-right" action="{!! route('admin.bill.search') !!}" method="get">
                            <!-- <select name="cat_id" class="form-control pull-left">
                              <option value="">Chọn danh mục</option>                              
                            </select> -->
                            <div class="form-group">
                              <input type="datetime" name="day" class="form-control datepicker marginBot5" data-date-format="dd-mm-yyyy" id="" placeholder="Chọn ngày" value="@if(!empty(Request::input('day'))) {!!Request::input('day')!!} @endif">
                            </div>
                            <div class="form-group">
                              <input class="form-control borderRad3 marginBot5" name="stxt" placeholder="ID, Mã hóa đơn, người nhập" type="text" value="" style="width:300px">
                            </div>
                            <button class="btn btn-default marginBot5" type="submit" onclick=""><i class="fa fa-search"></i> Tìm kiếm</button>
                          </form>
                        </div>
                    </div>
                
                <br>
                <div>
                  @if (session('flash_message_err') != '')
                    <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
                  @elseif (session('flash_message_succ') != '')
                    <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ')!!}</div>
                  @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <tr>
                            <!-- <th></th> -->
                            <th style="width: 50px;">ID</th>
                            <th>Mã hóa đơn</th>
                            <th>
                              <div class="col-md-12">
                              Chi tiết
                              </div>
                              <div class="col-md-12">
                                <div class="tbl-head col-md-12 no-padding">
                                  <div class="col-md-4"><strong>Nguyên liệu</strong></div>
                                  <div class="col-md-3"><strong>Lượng</strong></div>
                                  <div class="col-md-3"><strong>Giá</strong></div>
                                  <div class="clearfix"></div>
                                </div>
                              </div>
                            </th>
                            <th>Thời gian tạo</th>
                            <th>Nhà sản xuất</th>
                            <th>Người nhập</th>
                            <th>Hành động</th>
                          </tr>
                      </thead>
                      <tbody>
                      @if( count($listBill) > 0 )
                        @foreach($listBill as $bill)
                          <tr>
                            <!-- <td><input type="checkbox" value="{{ $bill->hdn_id }}" class="pid-checkbox"></td> -->
                            <td>{{ $bill->hdn_id }}</td>
                            <td>{{ $bill->hdn_code }}</td>
                            <td>
                              <div class="col-md-12">
                                <div class="tbl-body col-md-12">
                                  @if( count($bill->hn_name_group) > 0 )
                                    @foreach($bill->hn_name_group as $key => $val)
                                      <div class="col-md-4"> {!! $val !!} </div>
                                      <div class="col-md-3"> @if(isset($bill->hn_quantity_group[$key])) {!! $bill->hn_quantity_group[$key] !!} @endif 
                                      @if(isset($bill->unit_name_group[$key]))({!! $bill->unit_name_group[$key] !!}) @endif</div>
                                      <div class="col-md-3"> @if(isset($bill->hn_price_group[$key])){!! number_format($bill->hn_price_group[$key], 0, ',', '.') !!} @endif </div>
                                      <div class="clearfix"></div>
                                    @endforeach
                                  @endif
                                </div>
                              </div>
                            </td>
                            
                            <td>
                              <?php
                                $hdn_create_time = new DateTime($bill->hdn_create_time);
                                echo $hdn_create_time->format('d-m-Y H:i');
                              ?>
                            </td>
                            <td>{{ $bill->hdn_nsx_name }}</td>
                            <td>{{ $bill->hdn_name_employee }}</td>                            
                            <td>                              
                              <a class="btn btn-info btn-xs" href="{!! route('bill.edit', ['id' => $bill->hdn_id]) !!}"><i class="fa fa-pencil"></i></a>
                              <!-- <form id="delete-form-{{$bill->hdn_id}}" style="display:inline-block" action="" method="post">
                                                             <input type="hidden" name="_method" value="DELETE">
                                                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                             <a class="btn btn-danger btn-xs" onclick="javascript:delItem({{$bill->hdn_id}});"><i class="fa fa-minus-circle"></i></a>
                                                           </form>  -->                             
                            </td>
                          </tr>
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix" id="pagination-link">
                  {{$listBill->links()}}
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
{{ Html::script(asset('js/bootstrap-datepicker.js')) }}

  <script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true,
    });

    function delItem(id){
      var del = confirm('Bạn chắc chắn muốn xóa hóa đơn này?');
      if( del ){
        $('#delete-form-'+id).submit();  
      }
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
                text: "Bạn chưa chọn hóa đơn",
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