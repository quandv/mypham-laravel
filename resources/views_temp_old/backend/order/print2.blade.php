<!DOCTYPE html>
<html lang="vi">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Hóa đơn tính tiền</title>
</head>
<style type="text/css">
.page-break {
    page-break-after: always;
}
@page {margin:0;}
/* @page { size: 360pt 360pt; } */
/* @page {
    size: 72.20pt 50.70pt;
    margin: 0px;
} */
body { font-family:Arial,DejaVu Sans, sans-serif !important; }

</style>
<body>

<div class="container">
	<!-- <div class="header clearfix">
		<div class="logo " style="width: 20%">
			<img width="80" height="80" src="{!! asset('images/logo_order.png')!!}">
		</div>
		<div class="logo-right" style="width: 80%">
			<img src="{!! asset('images/webname.png')!!}">
			<h4 class="text-center">ĐC: Số 10 Hoàn Cầu Mới - Đống Đa - Hà Nội</h4>
		</div>
	</div> 
	<div class="clearfix" style="clear: both;"></div>
	-->
	 <table style="width: 100%;max-width: 100%;margin-bottom: 20px;">
     	<tr>	
     		<td><img width="80" height="80" src="{!! public_path().'/images/logo_order.png'!!}"></td>
     		<td><img src="{!! public_path().'/images/webname.png'!!}">
			<h4 class="text-center">ĐC: Số 10 Hoàn Cầu Mới - Đống Đa - Hà Nội</h4></td>
     	</tr>
         	
    </table>
	<h1 class="text-center">Hóa đơn tính tiền</h1>
    <div class="main-order">
    @if(!empty($data))

         <table style="width: 100%;max-width: 100%;margin-bottom: 20px;">
         	<tr>
         		<td style="border: none;">Số hóa đơn : {!! $data['order_id']!!} </td>
         		<td style="border: none;"">Ngày: {!! date('d-m-Y H:i:s') !!} </td>
         	</tr>
         	<tr>
         		<td style="border-top: none;">Phòng :{!! $data['room']!!} </td>
         		<td style="border-top: none;">Máy: {!! $data['client_name'] !!} </td>
         	</tr>
         </table>

	     <table class="table" style="width:100%">
	     	<thead style="border-top: 2px solid #000;border-bottom: 1px solid #000">
	        <tr style="border-top: 2px solid #000;border-bottom: 1px solid #000">
		          <td>STT</td>
		          <td>Tên hàng</td>
		          <td>Số lượng</td>
		          <td>Đơn giá</td>
		          <td>Thành tiền</td>
	        </tr> 
	        </thead>
	        <tbody>
		        @for($i=0; $i < count($data['product_name_group']); $i++)
		        <tr>
		          <td>
		          	{!! $i+1 !!}
		          </td>                              
		          <td>
		            {{ $data['product_name_group'][$i] }}
		            <ol class="order-option">
		                @if(!empty($data['product_option_group'][$i]))
		                  @foreach($data['product_option_group'][$i] as $key => $val)
		                    <li>{{$val['1']}}({{number_format($val['2'], 0, ',', '.')}})({{$val['3']}})</li>
		                  @endforeach
		                @endif
		            </ol>
		          </td>                             
		          <td >{{ $data['product_qty_group'][$i] }}</td>
		          <td >{{ number_format($data['product_price_group'][$i],0,",",".") }}</td>
		          <td >{{ number_format($data['product_qty_group'][$i]*$data['product_price_group'][$i],0,",",".") }}</td>
	            </tr> 
	        @endfor  
	        </tbody>
	        <tfoot>
             <tr>
             	<td colspan="4"><strong>Thành tiền</strong></td>
             	<td><strong>{!! number_format($data['sumPrice'],0,",",".") !!}</strong></td>
             </tr>
            </tfoot> 
	      </table> 
	      <h4 class="text-center">Cảm ơn Quý khách, hẹn gặp lại !  </h4>
        @endif
    </div>
</div>		
</body>
</html>