@extends('backend.layouts.master',['page_title' => 'Tất cả đơn hàng'])
@section('content')
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
             <div class="row">
<!--               <h3 class="box-title">Order</h3> -->
<a href="{{ route('admin.order.pdfview',['download'=>'pdf']) }}">Download PDF</a>
              <div class="col-sm-6">
                <div class="" >
                <select name="select-option-chose" class="form-control pull-left" style="width: 150px;" >
                  <option value="-1">Bulk Actions</option>
                  <option value="1">Đang xử lý</option>
                  <option value="2">Đã thu tiền</option>
                  <option value="3">Đã hoàn thành</option>
                  <option value="4">Đã hủy</option>
                </select>
                  <a id="apple-select" class="btn btn-default form-control pull-left" style="width: 100px;text-align:center">Apply</a>
                </div>
              </div>
              <div class="box-tools col-sm-6">
                <div class="input-group input-group-sm pull-right" style="width: 150px;">
                  <input type="text" id="table_search" name="table_search" class="form-control pull-right" placeholder="Tìm kiếm">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
              </div>
            </div>
            <!-- /.box-header -->
            <style type="text/css">
            ul.order-option{
              background: #f1f2f2;
              color: red;
            }
            .display-image{ 
                position: fixed;
                right: 20px;
                bottom: 30px;
             }
             .display-image-visible {
                display: block !important;
             }

             .display-image-hide{
                display: none;
             }
            </style>
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>
                  <th style="width:30px"><input type="checkbox" name="checkall-toogle"></th>
                  <th style="width:50px">ID</th>
                  <th style="width:130px;">Tên khách hàng</th>
                  <th style="width:100px">Ngày tháng</th>
                  <th>Chi tiết</th>
                   <th>Tổng cộng</th>
                   <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix" id="pagination-link">
              {{-- $data->links() --}}
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /.box -->
        </div>

      </div>
      <div class="display-image display-image-hide">
         <img src="{!! asset('images/icon/neworder.gif')!!}" alt="anh dong">
      </div>

@endsection

@section('after-scripts-end')
  <script type="text/javascript"> 
        var checkbox_arr = [];
        var timeing = 10000;
        function ajaxStatus(url){
          bootbox.confirm("Thay đổi trạng thái đơn hàng?", function(result) {
              if (result) {
                  $.get(url, function(data){ 
                    if (!data) {
                       return false;
                    }
                   var element = 'a#change-status-'+ data['order_id']; 
                   //var url = $(element).attr('data-href');
                   var txt = 'Đang xử lý';
                   var classRemove = 'label-success';
                   var classAdd  = 'label-warning';
                   if (data['order_status'] == 1) {
                      classRemove = 'label-success';
                      classAdd  = 'label-warning';
                      txt = 'Đang xử lý';          
                   }
                   if(data['order_status'] == 2){
                      classRemove = 'label-warning';
                      classAdd  = 'label-success';
                      txt = 'Đã thu tiền';
                   }
                   if(data['order_status'] == 3){
                      classRemove = 'label-warning';
                      classAdd  = 'label-success';
                      txt = 'Đã hoàn thành';
                   }
                    if(data['order_status'] == 4){
                      classRemove = 'label-success';
                      classAdd  = 'label-danger';
                      txt = 'Đã hủy';
                   }
                   $(element).attr('href', "javascript:ajaxStatus('"+data['link']+"')");
                   $(element + ' span').removeClass(classRemove).addClass(classAdd);
                   $(element + ' span').html(txt);
                },'json');
             }
          });
        }         
        function orderData(){
          $.get('{!!route('admin.order.list')!!}',function(data){  
             if (data.check_new_order) {
                $('.display-image').addClass('display-image-visible');
             }else{
                $('.display-image').removeClass('display-image-visible');
             }
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);
             $("#order-table tbody input[type='checkbox']").change(function(){
                 checkbox_arr = [];
                 $.each($("#order-table tbody input[type='checkbox']:checked"), function(i,v){
                      checkbox_arr.push($(this).val()); 
                  });
              });
          },'json');
        }

        orderData();
         
        var getdata = setInterval(orderData,timeing);
 
        $('input[name=checkall-toogle]').change(function(){
            var checkStatus = this.checked;
            if (checkStatus) {
                clearInterval(getdata);
            }else{
               getdata = setInterval(orderData,timeing);
            }
            $('#order-table tbody').find(':checkbox').each(function(){
                this.checked = checkStatus; 
            });     
        });
        
        $('select[name=select-option-chose]').change(function(){
              checkbox_arr = [];
              var checked_box = $('#order-table tbody').find(':checkbox:checked');
              if (checked_box.length == 0 ) {
                  alert('Vui lòng chọn đơn hàng trước');
                  $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
              }
             $.each($("#order-table tbody input[type='checkbox']:checked"), function(i,v){
                  checkbox_arr.push($(this).val());
                  //checkbox_arr[i] = $(this).val();
              });
          });
        $('#apple-select').click(function(){
            var select_option = $('select[name=select-option-chose]').val();  
            if (select_option != -1) {
               var result = confirm("Are you sure ?");
                if (result) {
                  $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                  });
                  $.ajax({
                    url: '{!! route('admin.order.status.two') !!}',
                    type: 'POST',
                    data: { 'arr' : checkbox_arr,'status' : select_option},
                    dataType: 'html',
                  }).done(function(data){
                     $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
                     $('input[name=checkall-toogle]').prop("checked", false);
                     orderData();        
                  });
                }

            }else{
               alert('Vui lòng chọn action');
            }      
            
        });

        /*==================== PAGINATION =========================*/
        $(window).on('hashchange',function(){
          page = window.location.hash.replace('#','');
          getOrders(page);
        });
        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            if (page != 1) {
               clearInterval(getdata);
            }else{
               getdata = setInterval(orderData,timeing);
               $('#table_search').val('');
            }
            getOrders(page);
            location.hash = page;

        });
        function getOrders(page=''){
          var str ='';
          var s =  $('#table_search').val();
          if (s.length >= 1) {
              str='&table_search='+s;
          }
          $.ajax({
            url: '{!!route('admin.order.list')!!}?page=' + page + str,
            type: 'GET',
            dataType: 'json'
          }).done(function(data){
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);

          });
        }
        /**/
        function getSearchOrders(s){
          $.ajax({
            url: '{!! route('admin.order.search') !!}',
            type: 'GET',
            data:{ 'table_search' : s},
            dataType: 'json',
          }).done(function(data){
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);
             
          });
        }
        $('#table_search').on('input propertychange',function(){
            var s = $(this).val();
            if (s.length >= 1) { 
              clearInterval(getdata);
              fnDelay(function() {
                getSearchOrders(s);
              }, 400);
            }else{
               orderData();
              
            }
        });
        var fnDelay = (function(){
          var timer = 0;
          return function(callback, ms){
          clearTimeout (timer);
          timer = setTimeout(callback, ms);
          };
        })();
  </script>
@stop