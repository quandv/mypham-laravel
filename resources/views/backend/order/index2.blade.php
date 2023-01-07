@extends('backend.layouts.master')
@section('content')
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Order</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" id="table_search" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên khách hàng</th>
                  <th>Ngày tháng</th>
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

@endsection

@section('after-scripts-end')
  <script type="text/javascript">

        function ajaxStatus(url){

          $.get(url, function(data){
            console.log(data);

             var element = 'a#change-status-'+ data['order_id']; 
             //var url = $(element).attr('data-href');
             var txt = 'pending';
             var classRemove = 'label-success';
             var classAdd  = 'label-warning';
             if (data['order_status'] != 1) {
                classRemove = 'label-warning';
                classAdd  = 'label-success';
                txt = 'Approved';
             }
             //$(element).attr('href', "javascript:ajaxStatus('"+data['link']+"')");
             $(element + ' span').removeClass(classRemove).addClass(classAdd);
             $(element + ' span').html(txt);
          },'json');

        }         
        function orderData(){
          $.get('{!!route('admin.order.list')!!}',function(data){  
             //$xhtml ='';
             /*if(data != '')
                  $.each(data,function(i,val)){
                    xhtml += '<tr>';
                    xhtml += '<td>'+val->order_id +'</td>';
                    xhtml += '<td>'+val->client_name +'</td>';
                    xhtml += '<td></td>';
                    xhtml += '<td>';
                    xhtml += '<div class="row">';
                    xhtml += '<div class="col-sm-3">Tên</div>';
                    xhtml += '<div class="col-sm-3">Số lượng</div>';
                    xhtml += '<div class="col-sm-3">Đơn giá</div>';
                    xhtml += '<div class="col-sm-3">Thành tiền</div>';
                       for(var i = 0 ; i < count(val.product_name_group); i++){
                         xhtml += '<div class="col-sm-3">'+val.product_name_group[$i]+'</div>';
                         xhtml += '<div class="col-sm-3">'+val.product_qty_group[$i] +'</div>';
                         xhtml += '<div class="col-sm-3">'+val.product_price_group[$i]+'</div>'
                         xhtml += '<div class="col-sm-3">'+val.price[$i]+'</div>';
                       }
                    xhtml += '</div>';
                    xhtml += '</td>';
                    xhtml += '<td>'+number_format(array_sum($val->price)) +'</td>';
                      if(val.order_status == 1) {
                        xhtml += '<td><a href="javascript:ajaxStatus('')" id="change-status-"'+val.order_id +'"><span class="label label-warning">Pendding</span></a></td>';
                      }else{
                        xhtml += '<td><span class="label label-success">Approved</span></td>';
                      }

                  }        
                  xhtml += '</tr>';*/
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);
          },'json');
        }

        orderData();
         
        var getdata = setInterval(orderData,2000);

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
               getdata = setInterval(orderData,2000);
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
            console.log(data);
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