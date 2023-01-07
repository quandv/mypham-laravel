@extends('backend.layouts.master', ['page_title' => 'Thống kê hàng nhập theo tháng'])
@section ('title','Thống kê hàng nhập')
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
                          <form class="form-inline" action="{!! route('admin.bill.statisticMonth') !!}" method="get">
                            <select name="month" class="form-control borderRad3 marginBot5">
                              <option value="0"> --Chọn tháng-- </option>
                              <option value="1" @if(isset($month) && $month == '1') selected @endif>&nbsp;1</option>
                              <option value="2" @if(isset($month) && $month == '2') selected @endif>&nbsp;2</option>
                              <option value="3" @if(isset($month) && $month == '3') selected @endif>&nbsp;3</option>
                              <option value="4" @if(isset($month) && $month == '4') selected @endif>&nbsp;4</option>
                              <option value="5" @if(isset($month) && $month == '5') selected @endif>&nbsp;5</option>
                              <option value="6" @if(isset($month) && $month == '6') selected @endif>&nbsp;6</option>
                              <option value="7" @if(isset($month) && $month == '7') selected @endif>&nbsp;7</option>
                              <option value="8" @if(isset($month) && $month == '8') selected @endif>&nbsp;8</option>
                              <option value="9" @if(isset($month) && $month == '9') selected @endif>&nbsp;9</option>
                              <option value="10" @if(isset($month) && $month == '10') selected @endif>&nbsp;10</option>
                              <option value="11" @if(isset($month) && $month == '11') selected @endif>&nbsp;11</option>
                              <option value="12" @if(isset($month) && $month == '12') selected @endif>&nbsp;12</option>
                            </select>
                            <select name="year" class="form-control borderRad3 marginBot5">
                              <option value="0"> --Chọn năm-- </option>
                              <option value="2016" @if(isset($year) && $year == '2016') selected @endif>&nbsp;2016</option>
                              <option value="2017" @if(isset($year) && $year == '2017') selected @endif>&nbsp;2017</option>
                              <option value="2018" @if(isset($year) && $year == '2018') selected @endif>&nbsp;2018</option>
                              <option value="2019" @if(isset($year) && $year == '2019') selected @endif>&nbsp;2019</option>
                              <option value="2020" @if(isset($year) && $year == '2020') selected @endif>&nbsp;2020</option>
                            </select>
                            <button class="btn btn-primary" type="submit" onclick=""><i class="fa fa-search"></i> Tìm kiếm</button>
                          </form>
                        </div>
                    </div>
                    <br>
      
                    <div class="row">
                      <div class="col-sm-12">
                          <div class="alert alert-success" role="alert">Thống kê tháng <strong>"{{$month}}-{{$year}}"</strong></div>
                        </div>
                    </div>
                
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped k-table-list">
                      <thead>
                          <tr>                            
                            <th>Tên hàng nhập</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php $sumTotal = 0; ?>
                      @if( count($listBill) > 0 )
                        @foreach($listBill as $bill)
                          <tr>
                            <td>{{ $bill->hn_name }}</td>
                            <td>{{ $bill->sumQty }} ({{ $bill->hn_unit }})</td>
                            <td>{{ number_format($bill->sumBill, '0', ',', '.') }}</td>
                          </tr>
                          <?php $sumTotal += $bill->sumBill; ?>
                          @endforeach
                        @endif
                      </tbody>
                      <tfoot>
                          <tr>                            
                            <th><span class="required"><strong>Tổng cộng</strong></span></th>
                            <th></th>
                            <th><span class="required"><strong>{{ number_format($sumTotal, '0', ',', '.') }} vnđ</strong></span></th>
                          </tr>
                      </tfoot>
                    </table>
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