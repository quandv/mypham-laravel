@extends('backend.layouts.master',['page_title' => 'Đơn hàng đã thu tiền'])
@section ('title','Đơn hàng đã thu tiền')
@section('content')
<style type="text/css">
  ul.nav-tabs li.active a { background-color: #a70e13 !important; color: #fff !important; }
</style>
 <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><strong>Đơn hàng của khách</strong></a></li>
            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><strong>Đơn hàng của nhân viên</strong></a></li>
          </ul>

          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
              <div class="box box-primary">
                <div class="box-header">
                   <div class="row">
                   <!-- <div class="col-md-12" style="margin-bottom: 10px;padding-top:5px;padding-bottom: 5px;">
                     <h3 class="box-title"><strong>Đơn hàng của khách</strong></h3>
                   </div> -->
                  <div class="col-sm-6">
                    <div class="" >
                    <select name="select-option-chose" class="form-control pull-left borderRad3 marginRight3" style="width: 150px;" >
                      <option value="-1">Xử lý</option>
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
                      <a id="apple-select" class="btn btn-default form-control pull-left" style="width: 100px;text-align:center">Áp dụng</a>
                    </div>
                  </div>
                  <div class="box-tools col-sm-6">
                    <div class="input-group input-group-sm pull-right" style="width: 220px;">
                      <input type="text" id="table_search" name="table_search" class="form-control pull-right" placeholder="Tên máy hoặc mã đơn hàng">
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <style type="text/css">
                
                 @media screen and (min-width: 992px){
                    #show-total-sum{padding-left: 60px}
                 } 
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
                  
                  .countup{
                  font-family: sans-serif;
                  color: #fff;
                  display: inline-block;
                  font-weight: 100;
                  text-align: center;
                  font-size: 14px;
                  margin-top: 5px;
                }

                .countup > div{
                  padding: 3px;
                  border-radius: 3px;
                  background: #00BF96;
                  display: inline-block;
                  margin-right: 5px;
                }

                .countup div > span{
                  padding: 5px;
                  border-radius: 3px;
                  background: #00816A;
                  display: inline-block;
                  font-weight: bold;
                }

                .countup .timeRefDays, .countup .timeRefHours, .countup .timeRefMinutes, .countup .timeRefSeconds{
                    padding-top: 5px;
                    font-size: 14px;
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
                      <th >Chi tiết</th>
                      <th style="width:120px">Tổng cộng</th>
                      <th style="max-width:150px;min-width: 80px;">Chú ý</th>
                      <th style="width:150px">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                  </table>
                </div>
                <div class="box-footer clearfix" >   
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
                 
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

            </div>

            <div role="tabpanel" class="tab-pane" id="profile">
              <div class="box box-primary">
                <div class="box-header">
                   <div class="row">
                   <!-- <div class="col-md-12" style="margin-bottom: 10px;padding-top:5px;padding-bottom: 5px;">
                     <h3 class="box-title"><strong>Đơn hàng của nhân viên</strong></h3>
                   </div> -->
                  
                  <div class="col-sm-6">
                    <div class="" >
                    <select name="select-option-chose-2" class="form-control pull-left borderRad3 marginRight3" style="width: 150px;" >
                      <option value="-1">Xử lý</option>
                      @permission('access-status-pending')
                        <option value="1">Đang xử lý</option>
                      @endauth
                      @permission('access-status-finish')
                        <option value="3">Đã hoàn thành</option>
                      @endauth
                      @permissions(['access-pendding-destroy','access-approved-destroy','access-done-destroy'])
                        <option value="4">Đã hủy</option>
                      @endauth
                    </select>
                      <a id="apple-select-2" class="btn btn-default form-control pull-left" style="width: 100px;text-align:center">Áp dụng</a>
                    </div>
                  </div>
                  <div class="box-tools col-sm-6">
                    <div class="input-group input-group-sm pull-right" style="width: 220px;">
                      <input type="text" id="table_search_2" name="table_search_2" class="form-control pull-right" placeholder="Tên máy hoặc mã đơn hàng">
                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
                <!-- /.box-header -->
                <style type="text/css">
                
                 @media screen and (min-width: 992px){
                    #show-total-sum{padding-left: 60px}
                 } 
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

                
                </style>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="order-employee">
                    <thead>
                    <tr>
                      <th style="width:30px"><input type="checkbox" name="checkall-toogle-2"></th>
                      <th style="width:50px">ID</th>
                      <th style="width:110px;">Tên máy</th>
                      <th style="width:100px">Ngày tháng</th>
                      <th >Chi tiết</th>
                      <th style="width:120px">Tổng cộng</th>
                      <th style="max-width:150px;min-width: 80px;">Chú ý</th>
                      <th style="width:150px">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                  </table>
                </div>
                <div class="box-footer clearfix" >   
                   <div class="col-md-6"  id="pagination-link-2">

                  </div>
                  <div class="col-md-6">
                     <select name="select-page-number-2" id="select-page-number-2" class="form-control pull-right" style="width: 70px;margin: 20px 0px;" >
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                      <option value="25">25</option>
                    </select>
                  </div>
                 
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

            </div>
          </div>

          

          

        </div>

      </div>
     <!--  <audio id="myAudio">
        <source src="{!! asset('audio/thongbao.mp3')!!}" type="audio/mpeg">
        Your browser does not support the audio element.
     </audio> -->
      <div class="display-image display-image-hide">
         <img src="{!! asset('images/icon/neworder.gif')!!}" alt="anh dong">
      </div>
@endsection

@section('after-scripts-end')
  <script type="text/javascript">
        //audio
        var audio = document.getElementById("myAudio");
        var checkbox_arr = [];
        var status_arr = [];
        var date_arr = [];
        var room_arr = [];
        var timeing = 10000;
        var flag;
        var realtime = {!! Config::get('vgmconfig.realtime') !!};
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
        function ajaxStatus(url){
          var status = $.urlParam(url,'order_status');
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
                         $(element + ' span').removeClass(classRemove).addClass(classAdd);
                         $(element + ' span').html(txt);
                      },'json');
                    swal({
                      title: 'Thay đổi trạng thái thành công!',
                      timer: 1000
                    });
                }).done();
          }else{
              swal({
                  title: 'Lý do hủy đơn hàng !',
                  html: '<textarea class="form-control" rows="3" name="resonDestroy"></textarea><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio1" value="1"  checked> Hoàn trả nguyên liệu</label><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio2" value="0"> Không hoàn trả nguyên liệu</label>',
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
          
        } 
        function getRandomInt(min, max) {
          return Math.floor(Math.random() * (max - min + 1) + min);
        }
        orderData();
        if (realtime) {
           clearInterval(getdata);
           timeing = 9000000000;
           var time_rand = getRandomInt(1000,2000);
           approved_channel.bind("App\\Events\\Backend\\Order\\OrderApproved", function( data ) { 
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
           done_channel.bind("App\\Events\\Backend\\Order\\OrderDone", function( data ) {
             fnDelay(function() {
                orderData();
              }, time_rand);
           });
        }
        var getdata = setInterval(orderData,timeing);

        function orderData(){
          var page_num = 5;
          if($('#select-page-number').val() != 5){
             page_num = $('#select-page-number').val();
          }
          var page_num2 = 5;
          if($('#select-page-number-2').val() != 5){
             page_num2 = $('#select-page-number-2').val();
          }
          $.get('{!!route('order.ajax.approved')!!}',{ 'pnum' : page_num, 'pnum2' : page_num2 },function(data){ 
             /*if (data.check_new_order) {
                console.log(data.check_new_order);
                $('.display-image').addClass('display-image-visible');
                audio.play();
             }else{
                $('.display-image').removeClass('display-image-visible');
                audio.pause();
             }*/
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);

             //Order for employee
             $('#order-employee tbody').html(data.html2);
             $('#pagination-link-2').html(data.pagi2);

             /*$('.orderItem').each(function(index,item){
                var countTo = parseInt($(this).attr('data-updated_at'));
                var order_id = $(this).attr('data-id');
                upTime(countTo,order_id);
              });*/

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

        
         
        $('input[name=checkall-toogle]').change(function(){
            var checkStatus = this.checked;
            if (checkStatus) {
                clearInterval(getdata);
            }else{
               getdata = setInterval(orderData,timeing);
            }
            $('#order-table tbody').find(':checkbox').each(function(){
                this.checked = checkStatus;
                clearInterval(getdata);
            });
        });

        $('select[name=select-option-chose]').change(function(){
            checkbox_arr = [];
            status_arr = [];
            date_arr = [];
            room_arr = [];
            var checked_box = $('#order-table tbody').find(':checkbox:checked');
            if (checked_box.length == 0 ) {               
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
                      data: { 'arr' : checkbox_arr,'status' : select_option,'arr_status' : status_arr,'arr_date' : date_arr ,'arr_room' : room_arr},
                      dataType: 'html',
                    }).done(function(data){
                       $('select[name=select-option-chose] option[value=-1]').prop("selected", true);
                       $('input[name=checkall-toogle]').prop("checked", false);
                       orderData();        
                    });
                    swal({
                      //'Deleted!',
                      //'Your file has been deleted.',
                      //'success'
                      title: 'Thay đổi trạng thái thành công!',
                      //text: 'I will close in 2 seconds.',
                      timer: 1000
                    });
                }).done();

            }else if(select_option == 4){
                swal({
                  title: 'Lý do hủy đơn hàng !',
                  html: '<textarea class="form-control" rows="3" name="resonDestroy"></textarea><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio1" value="1"  checked> Hoàn trả nguyên liệu</label><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio2" value="0"> Không hoàn trả nguyên liệu</label>',
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
                      data: { 'arr' : checkbox_arr,'status' : select_option,'message' : result[0],'arr_status' : status_arr,'arr_date' : date_arr,'arr_room' : room_arr, 'back_stock' : result[1]},
                      dataType: 'json',
                    }).done(function(data){
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
                }).done();
            }else{
               swal(
                  'Oops...',
                  'Vui lòng chọn action!',
                  'error'
                ).done();
            }    
            
        });

$('input[name=checkall-toogle-2]').change(function(){
  var checkStatus = this.checked;
  if (checkStatus) {
      clearInterval(getdata);
  }else{
     getdata = setInterval(orderData,timeing);
  }
  $('#order-employee tbody').find(':checkbox').each(function(){
      this.checked = checkStatus;
      clearInterval(getdata);
  });
});

$('select[name=select-option-chose-2]').change(function(){
  checkbox_arr = [];
  status_arr = [];
  date_arr = [];
  room_arr = [];
  var checked_box = $('#order-employee tbody').find(':checkbox:checked');
  if (checked_box.length == 0 ) {     
      swal(
          'Oops...',
          'Vui lòng chọn đơn hàng trước!',
          'error'
      ).done();
      $('select[name=select-option-chose-2] option[value=-1]').prop("selected", true);
  }
 $.each($("#order-employee tbody input[type='checkbox']:checked"), function(i,v){
     checkbox_arr.push($(this).val());
     status_arr.push($(this).attr('data-status'));
     date_arr.push($(this).attr('data-time'));
     room_arr.push($(this).attr('data-room'));
  });
});

$('#apple-select-2').click(function(){
  var select_option = $('select[name=select-option-chose-2]').val();  
  if (select_option != -1 && select_option != 4) {
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
            data: { 'arr' : checkbox_arr,'status' : select_option,'arr_status' : status_arr,'arr_date' : date_arr ,'arr_room' : room_arr},
            dataType: 'html',
          }).done(function(data){
             $('select[name=select-option-chose-2] option[value=-1]').prop("selected", true);
             $('input[name=checkall-toogle-2]').prop("checked", false);
             orderData();        
          });
          swal({
            //'Deleted!',
            //'Your file has been deleted.',
            //'success'
            title: 'Thay đổi trạng thái thành công!',
            //text: 'I will close in 2 seconds.',
            timer: 1000
          });
      }).done();

  }else if(select_option == 4){
      swal({
        title: 'Lý do hủy đơn hàng !',
        html: '<textarea class="form-control" rows="3" name="resonDestroy"></textarea><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio1" value="1"  checked> Hoàn trả nguyên liệu</label><label class="radio-inline"><input type="radio" name="backStock" id="inlineRadio2" value="0"> Không hoàn trả nguyên liệu</label>',
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
            data: { 'arr' : checkbox_arr,'status' : select_option,'message' : result[0],'arr_status' : status_arr,'arr_date' : date_arr,'arr_room' : room_arr, 'back_stock' : result[1]},
            dataType: 'json',
          }).done(function(data){
             $('select[name=select-option-chose-2] option[value=-1]').prop("selected", true);
             $('input[name=checkall-toogle-2]').prop("checked", false);
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
      }).done();
  }else{
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
           var page_num = $('#select-page-number').val();

           var s2 = $('#table_search_2').val();
           var page_num2 = $('#select-page-number-2').val();
           getSearchOrders(page,s,page_num,s2,page_num2);
        });
        $(document).on('click','#pagination-link .pagination a', function(e){
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
            getSearchOrders1(page,s,page_num);
            //location.hash = page;
        });
        $(document).on('click','#pagination-link-2 .pagination a', function(e){
            e.preventDefault();
            //var page = $(this).attr('href').split('page=')[1];
            var page_url = $(this).attr('href');
            var page =  $.urlParam(page_url,'page');
            var page_num = $.urlParam(page_url,'pnum2');
            var s =  $('#table_search_2').val();

            if (page != 1) {
               clearInterval(getdata);
            }else{
               getdata = setInterval(orderData,timeing);
               $('#table_search_2').val('');
            }
            getSearchOrders2(page,s,page_num);
            //location.hash = page;
        });
        /**/
        function getSearchOrders(page,s,page_num,s2,page_num2){
          $.ajax({
            url: '{!! route('order.ajax.approved') !!}',
            type: 'GET',
            data:{  'page' : page,'table_search' : s,'pnum' : page_num,'table_search_2' : s2,'pnum2' : page_num2 },
            dataType: 'json',
          }).done(function(data){
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);

             $('#order-employee tbody').html(data.html2);
             $('#pagination-link-2').html(data.pagi2);
/*
             $('.orderItem').each(function(index,item){
                var countTo = parseInt($(this).attr('data-updated_at'));
                var order_id = $(this).attr('data-id');
                upTime(countTo,order_id);
              });*/
          });
        }

        function getSearchOrders1(page,s,page_num){
          $.ajax({
            url: '{!! route('order.ajax.approved1') !!}',
            type: 'GET',
            data:{  'page' : page,'table_search' : s,'pnum' : page_num},
            dataType: 'json',
          }).done(function(data){console.log(data);
             $('#order-table tbody').html(data.html);
             $('#pagination-link').html(data.pagi);

             /*$('.orderItem').each(function(index,item){
                var countTo = parseInt($(this).attr('data-updated_at'));
                var order_id = $(this).attr('data-id');
                upTime(countTo,order_id);
              });*/
          });
        }

        function getSearchOrders2(page,s,page_num){
          $.ajax({
            url: '{!! route('order.ajax.approved2') !!}',
            type: 'GET',
            data:{  'page' : page,'table_search_2' : s,'pnum2' : page_num },
            dataType: 'json',
          }).done(function(data){
             $('#order-employee tbody').html(data.html2);
             $('#pagination-link-2').html(data.pagi2);
/*
             $('.orderItem').each(function(index,item){
                var countTo = parseInt($(this).attr('data-updated_at'));
                var order_id = $(this).attr('data-id');
                upTime(countTo,order_id);
              });*/
          });
        }

        $('#table_search').on('input propertychange',function(){
            var s = $(this).val();
            var page_num = $('#select-page-number').val();
            //var page = window.location.hash.replace('#','');
            if (s.length >= 1) { 
              clearInterval(getdata);
              fnDelay(function() {
                getSearchOrders1('',s,page_num);
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
             var page_num = $(this).val();
             if ( page_num != 5 ) {
                clearInterval(getdata);
                fnDelay(function() {
                  getSearchOrders1('',s,page_num);
                }, 600);
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

        $('#table_search_2').on('input propertychange',function(){
            var s = $(this).val();
            var page_num = $('#select-page-number-2').val();
            //var page = window.location.hash.replace('#','');
            if (s.length >= 1) { 
              clearInterval(getdata);
              fnDelay(function() {
                getSearchOrders2('',s,page_num);
              }, 600);
            }else{
               orderData();  
            }
           if (s2 == '') {  
              fnDelay(function() {
                orderData();
              }, 600);
            }
        });
         $('select[name=select-page-number-2]').change(function(){
             var s =  $('#table_search_2').val();
             var page_num = $(this).val();
             if ( page_num != 5 ) {
                clearInterval(getdata);
                fnDelay(function() {
                  getSearchOrders2('',s,page_num);
                }, 600);
             }else{
               orderData();
             }
        });
  </script>

  <!-- Count time -->
  <script>
    
    $( document ).ajaxSuccess(function() {
      $('.orderItem').each(function(index,item){
        var countTo = parseInt($(this).attr('data-updated_at'));
        var order_id = $(this).attr('data-id');
        upTime(countTo,order_id);
      });
    });
    function upTime(countTo,order_id) {
      var difference = countTo;
      var days=Math.floor(difference/(60*60*24));
      var hours=Math.floor((difference/(60 * 60)) % 24);
      var mins=Math.floor((difference/60) % 60);
      var secs=Math.floor(difference % 60);
      /*
      var days_html  = document.getElementById('#days-'+order_id);
      var hours_html = document.getElementById('#hours-'+order_id);
      var mins_html  = document.getElementById('#minutes-'+order_id);
      var secs_html  = document.getElementById('#seconds-'+order_id);

      days_html.innerHTML  = days;
      hours_html.innerHTML  = hours;
      mins_html.innerHTML  = mins;
      secs_html.innerHTML  = secs;*/

      var days_html  = $('#days-'+order_id);
      var hours_html = $('#hours-'+order_id);
      var mins_html  = $('#minutes-'+order_id);
      var secs_html  = $('#seconds-'+order_id);
      var countup    = $('.countup-'+order_id+ ' div');

      days_html.text(days);
      hours_html.text(hours);
      mins_html.text(mins);
      secs_html.text(secs);
      
      if(days >= 1){
        $('div.days-'+order_id).removeClass('hide');
        $('div.seconds-'+order_id).addClass('hide');
      }
      if(days == 0 && hours == 0 && mins < 5){

      }else{
        days_html.css({'background-color':'#930D0D'});
        hours_html.css({'background-color':'#930D0D'});
        mins_html.css({'background-color':'#930D0D'});
        secs_html.css({'background-color':'#930D0D'});
        countup.css({'background-color':'#d9534f'});
      }
      countTo = countTo + 1;
      clearTimeout(upTimeto);
      var upTimeto =setTimeout(function(){ upTime(countTo,order_id); },1000);
    }

  </script>
@stop