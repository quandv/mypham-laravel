@extends('backend.layouts.master',['page_title' => 'Tất cả đơn hàng'])
@section ('title','Tất cả đơn hàng')
@section('content')
<link href="{{ asset("css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
 <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
             <div class="row">
<!--               <h3 class="box-title">Order</h3> -->
              <div class="col-xs-12 col-sm-4">
                <div class="" >
                <select name="select-option-chose" class="form-control pull-left borderRad3 marginRight3 marginBot5" style="width: 150px;" >
                  <option value="-1">--Xử lý--</option>
                  @permission('access-status-pending')
                    <option value="1">Đang xử lý</option>
                  @endauth
                  @permission('access-status-money')
                    <option value="2">Đã thu tiền</option>
                  @endauth
                  @permission('access-status-finish')
                    <option value="3">Đã hoàn thành</option>
                  @endauth
                  @permissions(['access-pendding-destroy','access-approved-destroy','access-done-destroy'])
                    <option value="4">Đã hủy</option>
                  @endauth

                </select>
                  <a id="apple-select" class="btn btn-default form-control pull-left marginBot5" style="width: 100px;text-align:center">Áp dụng</a>
                </div>
              </div>
              <div class="box-tools col-xs-12 col-sm-8">
               
                <div class="input-group pull-right marginLeft5" style="width: 220px;">
                  <input type="text" id="table_search" name="table_search" class="form-control pull-right marginBot5" placeholder="Tên máy, mã đơn hàng">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default marginBot5"><i class="fa fa-search"></i></button>
                  </div>
                </div>

                 <div class='input-group pull-right datetimepicker marginBot5 marginLeft5' id='datetimepicker2' style="width: 220px;">
                    <input type='text' class="form-control input-date marginBot5" name="time_end" id="time_end"  placeholder="Thời gian kết thúc" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                 <div class='input-group pull-right datetimepicker marginBot5 marginLeft5' id='datetimepicker1' style="width: 220px;">
                    <input type='text' class="form-control input-date" name="time_start" id="time_start" placeholder="Thời gian bắt đầu"   />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
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
             a.print{display: block; width: 85px;text-align: center; border-radius: 2px;margin-top: 10px;text-transform: capitalize;}
             a.print-popup{
                color: #fff;
                border: 0;
                box-shadow: none;
                font-size: 17px;
                font-weight: 500;
                border-radius: 3px;
                padding: 10px 32px;
                margin: 0 5px;
                cursor: pointer;
               background-color: rgb(48, 133, 214);
               border-left-color: rgb(48, 133, 214);
               border-right-color: rgb(48, 133, 214); 
             }

             .countup p {                    
                display: inline-block;
                padding: 5px 2px; 
                background: #FFA500;
                margin: 5px 0 5px;
                font-weight: bold;
                color: #fff;
              }

            </style>
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="order-table">
                <thead>
                <tr>
                  <th style="width:30px"><input type="checkbox" name="checkall-toogle"></th>
                  <th style="width:50px">ID</th>
                  <th style="width:110px;">Tên máy</th>
                  <th style="width:100px">Ngày tháng</th>
                  <th>Chi tiết</th>
                  <th style="width:120px">Tổng cộng</th>
                  <th style="max-width:100px;min-width: 80px;">Chú ý</th>
                  <th style="width:130px">Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix">
              <div class="col-md-6"  id="pagination-link">  

              </div>
              <div class="col-md-6">
                 <select name="select-page-number" id="select-page-number" class="form-control pull-right" style="width: 70px;margin: 20px 0px;" >
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="20">20</option>
                  <option value="25">25</option>
                </select>
              </div>
              {{-- $data->links() --}}
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /.box -->
        </div>

      </div>
      <!-- <audio id="myAudio">
          <source src="{!! asset('audio/thongbao.mp3')!!}" type="audio/mpeg">
                  Your browser does not support the audio element.
      </audio> -->
      <div class="display-image display-image-hide">
         <img src="{!! asset('images/icon/neworder.gif')!!}" alt="anh dong">
      </div>

@endsection

@section('after-scripts-end')
{{ Html::script(asset('js/moment.min.js')) }}
{{--Html::script(asset('js/moment-with-locales.min.js')) --}}
{{ Html::script(asset('js/bootstrap-datetimepicker.min.js')) }}

  <script type="text/javascript"> 
        $(function () {
          $('.datetimepicker').datetimepicker({
             // locale: 'vi',
             // format:'DD/MM/YYYY HH:mm:ss',
              format:'DD/MM/YYYY HH:mm',
              // sideBySide: true,
              toolbarPlacement: 'default',
              showTodayButton: true,
              showClear: true,
              showClose: true,
              widgetPositioning: {
                  horizontal: 'auto',
                  vertical: 'auto'
              },
              keepOpen:true,
              focusOnShow:true,
              allowInputToggle:true,
          });

          $("#datetimepicker1").on("dp.change", function (e) {
            var page_num = $('#select-page-number').val();
            if (e.date) {
                var time_start = e.date.format('YYYY-MM-DD HH:mm:00');
                var time_end   = $('#datetimepicker2').data("DateTimePicker");
                var s = $('#table_search').val();
                if (time_end.date() != null) {
                   time_end = time_end.date().format('YYYY-MM-DD HH:mm:00');
                }else{
                   time_end ='';
                }
               
                fnDelay(function() {
                  getSearchOrders('',time_start,time_end,s,page_num);
                }, 1000);   
            }else{
              fnDelay(function() {
                getSearchOrders('','','','',page_num);
              }, 1000);
            }
                   
          });
          $("#datetimepicker2").on("dp.change", function (e) {
            var page_num = $('#select-page-number').val();
            if (e.date) {
              var time_end = e.date.format('YYYY-MM-DD HH:mm:00');
              var time_start   = $('#datetimepicker1').data("DateTimePicker");
              var s = $('#table_search').val();
              if (time_start.date() != null) {
                 time_start = time_start.date().format('YYYY-MM-DD HH:mm:00');
              }else{
                 time_start ='';
              }
              fnDelay(function() {
                getSearchOrders('',time_start,time_end,s,page_num);
              }, 1000);
            }else{
              fnDelay(function() {
                getSearchOrders('','','','',page_num);
              }, 1000);
            } 
          });
       });
       function getSearchOrders(page,time_start,time_end,s,page_num){
          $.ajax({
            url: '{!! route("admin.order.listall") !!}',
            type: 'GET',
            data:{ 'page' : page,'time_start' : time_start, 'time_end':time_end ,'table_search' : s,'pnum' : page_num },
            dataType: 'json',
          }).done(function(data){
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);
             
          });
        }

 
        $.urlParam = function(url,name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            //var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results==null){
               return null;
            }
            else{
               return results[1] || 0;
            }
        }
        //audio
        //var audio = document.getElementById("myAudio");
        var checkbox_arr = [];
        var status_arr = [];
        var room_arr = [];
        var date_arr = [];
        var timeing = 10000;
        var flag;
        var realtime = {!! Config::get('vgmconfig.realtime') !!};
        
        function ajaxStatus(url){ 
          var status = $.urlParam(url,'order_status');
          var order_id = $.urlParam(url,'order_id');
          var order_id = $.urlParam(url,'order_id');
          var room_id = $.urlParam(url,'room_id');
          var link_print = "{!! url('admin/order/print/') !!}" + '/'+room_id + '/' + order_id;
          var xtitle = '';
          if(status == 1){
              xtitle = 'Thay đổi đơn hàng thành đã thu tiền';
          }
          if (status == 2) {
              xtitle = 'Thay đổi đơn hàng thành đã hoàn thành';
          }
          if (status == 3) {
              xtitle = 'Thay đổi đơn hàng sang trạng thái hủy';
          }
          if (status == 4) {
              xtitle = 'Thay đổi đơn hàng từ hủy thành đang xử lý';
          }
          if (status != 3 ) {
              swal({
                    title: 'Thông báo ?',
                    type: 'warning',
                    html:
                      '<p>'+ xtitle + '</p>'+
                      'In hóa đơn, ' +
                      '<a href="'+ link_print+ '" class="print-popup">Print</a>',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                  }).then(function() {
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
                         console.log(txt);
                         console.log(classRemove);
                         console.log(classAdd);
                         $(element + ' span').removeClass(classRemove).addClass(classAdd);
                         $(element + ' span').html(txt);
                          swal({
                            title: 'Thay đổi trạng thái thành công !',
                            timer: 1000
                          }).done();
                             
                      },'json');
                     
                    
                }).done();
          }else{
              swal({
                  title: 'Lý do hủy đơn hàng !',
                  html: '<textarea class="form-control" rows="3" name="resonDestroy"></textarea><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio1" value="1" checked> Hoàn trả nguyên liệu</label><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio2" value="0"> Không hoàn trả nguyên liệu</label>',
                  showCancelButton: true,
                  preConfirm: function() {
                    return new Promise(function(resolve, reject) {
                      if ( $('textarea[name=resonDestroy]').val() != '' ) {
                        resolve([
                          $('textarea[name=resonDestroy]').val(),
                          $('input[name=backStock]:checked').val()
                        ]);
                      } else {
                        reject('Bạn phải viết lý do hủy đơn hàng!');
                      }
                    });
                  }
                }).then(function(result) {
                     url = url+'&back_stock='+result[1] ;
                     $.get(url, function(data){ 
                         if (!data) {
                             return false;
                         }
                         var element = 'a#change-status-'+ data['order_id']; 
                         //var url = $(element).attr('data-href');
                         $(element).attr('href', "javascript:ajaxStatus('"+data['link']+"')");
                         $(element + ' span').removeClass('label-success').addClass('label-danger');
                         if(result[1] == 1){
                            $(element + ' span').html('Đã hủy(hoàn trả)');  
                         }else{
                            $(element + ' span').html('Đã hủy'); 
                         }
                         
                      },'json');
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      $.ajax({
                        url: '{!! route('admin.order.status.message') !!}',
                        type: 'POST',
                        data: { 'order_id' : order_id,'status' : status, 'message' : result[0], 'back_stock' : result[1] },
                        dataType: 'html',
                      }).done(function(data){
                          console.log(data);
                          swal({
                              type: 'success',
                              html: 'Đơn hàng đã được hủy thành công với lý do: <br />' + result[0]
                          }).done();
                      });
                      
                      
              }).done();
          }
          /*bootbox.confirm(xtitle, function(result) {
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
          });*/
        }         
        function orderData(){
          var page_num = 5;
          if($('#select-page-number').val() != 5){
             page_num = $('#select-page-number').val();
          }
          $.get("{!!route('admin.order.listall')!!}",{ 'pnum' : page_num },function(data){  
             /*if (data.check_new_order) {
                $('.display-image').addClass('display-image-visible');
                audio.play();
             }else{
                $('.display-image').removeClass('display-image-visible');
                audio.pause();
             }*/
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);

             $('.orderItem').each(function(index,item){
                var countTo = parseInt($(this).attr('data-updated_at'));
                var order_id = $(this).attr('data-id');
                upTime(countTo,order_id);
              });

             $("#order-table tbody input[type='checkbox']").change(function(){
                  flag = this.checked;
                  if (flag) {
                     clearInterval(getdata);
                  }else{
                     getdata = setInterval(orderData,timeing);
                  }
                 checkbox_arr = [];
                 status_arr = [];
                 date_arr = [];
                 room_arr = [];
                 $.each($("#order-table tbody input[type='checkbox']:checked"), function(i,v){
                      checkbox_arr.push($(this).val()); 
                      status_arr.push($(this).attr('data-status'));
                      date_arr.push($(this).attr('data-time'));
                      room_arr.push($(this).attr('data-room'));
                 });

              });
          },'json');
        }
        function getRandomInt(min, max) {
          return Math.floor(Math.random() * (max - min + 1) + min);
        }
        orderData();
        if (realtime) {
           clearInterval(getdata);
           timeing = 9000000000;
           var time_rand = getRandomInt(1000,2000);
           add_channel.bind("App\\Events\\Frontend\\Cart\\CartAdd", function( data ) {
             console.log('Thêm sản phẩm');
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
           approved_channel.bind("App\\Events\\Backend\\Order\\OrderApproved", function( data ) { 
             console.log('Đã thu tiền');
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
           done_channel.bind("App\\Events\\Backend\\Order\\OrderDone", function( data ) {
             console.log('Đã hoàn thành');
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
           destroy_channel.bind("App\\Events\\Backend\\Order\\OrderDestroy", function( data ) {
             console.log('Đã hủy');
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
           pending_channel.bind("App\\Events\\Backend\\Order\\OrderPending", function( data ) {
             console.log('Chuyển sang pending');
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
        }
        
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
              status_arr = [];
              date_arr = [];
              room_arr = [];
              var checked_box = $('#order-table tbody').find(':checkbox:checked');
              if (checked_box.length == 0 ) {
                  //alert('Vui lòng chọn đơn hàng trước');
                  swal(
                    'Oops...',
                    'Vui lòng chọn đơn hàng trước!',
                    'error'
                  ).done();
                  $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
              }
             $.each($("#order-table tbody input[type='checkbox']:checked"), function(i,v){
                  checkbox_arr.push($(this).val());
                  status_arr.push($(this).attr('data-status'));
                  date_arr.push($(this).attr('data-time'));
                  room_arr.push($(this).attr('data-room'));
                  //checkbox_arr[i] = $(this).val();
              });
          });
        $('#apple-select').click(function(){
            var select_option = $('select[name=select-option-chose]').val();  
            if (select_option != -1 && select_option != 4) {
               /*var result = confirm("Are you sure ?");
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
                }*/
                var xtitle = '';
                if(select_option == 1){
                    xtitle = 'Thay đổi đơn hàng thành đang xử lý';
                }
                if (select_option == 2) {
                    xtitle = 'Thay đổi đơn hàng thành đã thu tiền';
                }
                if (select_option == 3) {
                    xtitle = 'Thay đổi đơn hàng thành đã hoàn thành';
                }
                swal({
                    title: 'Thông báo ?',
                    text: xtitle,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                  }).then(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                    });
                    $.ajax({
                      url: '{!! route('admin.order.status.two') !!}',
                      type: 'POST',
                      data: { 'arr' : checkbox_arr,'status' : select_option,'arr_status' : status_arr,'arr_date' : date_arr,'arr_room' : room_arr},
                      dataType: 'html',
                    }).done(function(data){
                       $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
                       $('input[name=checkall-toogle]').prop("checked", false);
                       orderData(); 
                       swal({
                          //'Deleted!',
                          //'Your file has been deleted.',
                          //'success'
                          title: 'Thay đổi trạng thái thành công!',
                          //text: 'I will close in 2 seconds.',
                          timer: 1000
                        });       
                    });
                    
                }).done();

            }else if(select_option == 4){
                swal({
                  title: 'Lý do hủy đơn hàng !',
                  html: '<textarea class="form-control" rows="3" name="resonDestroy"></textarea><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio1" value="1" checked> Hoàn trả nguyên liệu</label><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio2" value="0"> Không hoàn trả nguyên liệu</label>',
                  showCancelButton: true,
                  preConfirm: function() {
                    return new Promise(function(resolve, reject) {
                      if ( $('textarea[name=resonDestroy]').val() != '' ) {
                        resolve([
                          $('textarea[name=resonDestroy]').val(),
                          $('input[name=backStock]:checked').val()
                        ]);
                      } else {
                        reject('Bạn phải viết lý do hủy đơn hàng!');
                      }
                    });
                  }
                }).then(function(result) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                    });
                    $.ajax({
                      url: '{!! route('admin.order.status.two') !!}',
                      type: 'POST',
                      data: { 'arr' : checkbox_arr,'status' : select_option,'message' : result[0],'arr_status': status_arr,'arr_date': date_arr , 'arr_room' : room_arr, 'back_stock' : result[1]},
                      dataType: 'json',
                    }).done(function(data){
                       //console.log(data);
                       $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
                       $('input[name=checkall-toogle]').prop("checked", false);
                       var message_err = '';
                       var message_succ = '';
                       if (data.message_err != '') {
                         message_err = "<p style='color:red'>" + data.message_err + "</p>";
                       }
                       if (data.message_succ != '') {
                          message_succ = "<p>" + data.message_succ + "</p>";
                       }
                       orderData(); 
                       swal({
                            type: 'success',
                            //html: 'Đơn hàng đã được hủy thành công với lý do: <br />' + result[0]
                            html: message_succ + message_err,
                        }).done();        
                    });
                   /* swal(
                      'Hủy đơn hàng!',
                      'Đơn hàng đã được hủy .',
                      'Thành công'
                    ); */ 
                      
                }).done();
            }else{
               //alert('Vui lòng chọn action');
               swal(
                  'Oops...',
                  'Vui lòng chọn action!',
                  'error'
                ).done();
            }      
            
        });

        /*==================== PAGINATION =========================*/
        $(window).on('hashchange',function(){
           page = window.location.hash.replace('#','');
           var s = $('#table_search').val();
           var time_start = $('#datetimepicker1').data('DateTimePicker');
           var time_end = $('#datetimepicker2').data('DateTimePicker');
           var page_num = $('#select-page-number').val();
            if (time_start.date() != null) {
                 time_start = time_start.date().format('YYYY-MM-DD HH:mm:00');
            }else{
                 time_start ='';
            }
            if (time_end.date() != null) {
                 time_end = time_end.date().format('YYYY-MM-DD HH:mm:00');
            }else{
                 time_end ='';
            }  
           //fnDelay(function() {
              getSearchOrders(page,time_start,time_end,s,page_num);
            //}, 600);
           
        });
        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            //var page = $(this).attr('href').split('page=')[1];
            var page_url = $(this).attr('href');
            var page =  $.urlParam(page_url,'page');
            var page_num = $.urlParam(page_url,'pnum');
            var s =  $('#table_search').val();
            if (page != 1) {
               clearInterval(getdata);
            }else{
               getdata = setInterval(orderData,timeing);
               $('#table_search').val('');
            }
            //getSearchOrders(page,s,page_num);
            location.hash = page;
        });
        /**/
       /* function getSearchOrders(page,s,page_num){
          $.ajax({
            url: '{!! route('admin.order.listall') !!}',
            type: 'GET',
            data:{ 'page' : page,'table_search' : s,'pnum' : page_num },
            dataType: 'json',
          }).done(function(data){
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);    
          });
        }*/
        $('#table_search').on('input propertychange',function(){
             var s = $(this).val();
             var time_start = $('#datetimepicker1').data('DateTimePicker');
             var time_end = $('#datetimepicker2').data('DateTimePicker');
             var page_num = $('#select-page-number').val();
              if (time_start.date() != null) {
                   time_start = time_start.date().format('YYYY-MM-DD HH:mm:00');
              }else{
                   time_start ='';
              }
              if (time_end.date() != null) {
                   time_end = time_end.date().format('YYYY-MM-DD HH:mm:00');
              }else{
                   time_end ='';
              }  
            //var page = window.location.hash.replace('#','');
            if (s.length >= 1) { 
              clearInterval(getdata);
              fnDelay(function() {
                getSearchOrders('',time_start,time_end,s,page_num);
              }, 600);
            }else{
               orderData();  
            }
            if (s == '') {  
              fnDelay(function() {
                orderData();
              }, 600);
            }
        });
        $('select[name=select-page-number]').change(function(){
             var s =  $('#table_search').val();
             var time_start = $('#datetimepicker1').data('DateTimePicker');
             var time_end = $('#datetimepicker2').data('DateTimePicker');
              var page_num = $(this).val();
              if (time_start.date() != null) {
                   time_start = time_start.date().format('YYYY-MM-DD HH:mm:00');
              }else{
                   time_start ='';
              }
              if (time_end.date() != null) {
                   time_end = time_end.date().format('YYYY-MM-DD HH:mm:00');
              }else{
                   time_end ='';
              }   
             
             if (s.length >=1 ) {
                clearInterval(getdata);
                fnDelay(function() {
                  getSearchOrders('',time_start,time_end,s,page_num);
                }, 600);
             }else{
               fnDelay(function() {
                  getSearchOrders('',time_start,time_end,'',page_num);
                }, 500);
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