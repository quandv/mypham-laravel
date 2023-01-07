@extends('frontend.layouts.master')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','menu')
@endif

@section('content')
<!-- start main1 -->

<style>
body{
	font-family: arial;
}
	.title {
	    float: left;
	    position: relative;
	    width: 100%;
	    margin-bottom: 15px;
	    font-size: 24px;
	    color: #2f2f2f;
	    font-weight: 300;
	    padding-bottom: 5px;
	}
	.shop-table {
    position: relative;
    width: 100%;
    border-collapse: separate;
}
.shop-table tr {
    width: 100%;
    display: table;
    margin-bottom: 15px;
}
.shop-table th:first-child, .shop-table td:first-child {
    width: 15%;
}

.shop-table th {
    font-size: 16px;
    padding: 5px;
    text-align: center;
}
.shop-table tbody tr td:first-child {
    border-left: 1px solid #E1E1E1;
    -webkit-border-radius: 10px 0 0 10px;
    border-radius: 10px 0 0 10px;
}

.shop-table th:first-child, .shop-table td:first-child {
    width: 15%;
}

.shop-table tbody td {
    text-align: center;
    border: 1px solid #E1E1E1;
    vertical-align: middle;
    padding: 10px;
    border-left: none;
}
.shop-details {
    position: relative;
    text-align: left;
    padding: 0 10px;
}
.shop-details .productname {
    text-align: left;
    font-weight: 400;
}
.productname {
    float: left;
    width: 100%;
    text-align: center;
    font-size: 16px;
    color: #2f2f2f;
    margin-bottom: 10px;
    color: #333333;
}
.shop-table th:nth-child(2), .shop-table td:nth-child(2) {
    width: 45%;
}
.shop-table th:nth-child(3), .shop-table td:nth-child(3), .shop-table th:nth-child(4), .shop-table td:nth-child(4), .shop-table th:nth-child(5), .shop-table td:nth-child(5), .shop-table th:nth-child(6), .shop-table td:nth-child(6) {
    width: 10%;
}
.checkout-steps {
    position: relative;
    width: 100%;
    float: left;
}
.checkout-steps .steps {
    float: left;
    width: 100%;
    border: 1px solid #cccccc;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
}
.checkout-steps .step-title {
    float: left;
    width: 100%;
    padding: 15px 25px;
    font-size: 14px;
    margin: 0;
    background: url(../images/down-arow-2.png) right 25px top 22px no-repeat;
    text-transform: uppercase;
    font-weight: 400;
    cursor: pointer;
}
.step-description {
    float: left;
    width: 100%;
    border-top: 1px solid #cccccc;
    padding: 30px;
}
.form-row {
    position: relative;
    overflow: hidden;
    margin-bottom: 10px;
    width: 100%;
}
.form-row .lebel-abs {
    left: 20px;
    position: absolute;
    top: 12px;
}
.red {
    color: #ff3a3a;
}
.form-row .input[type="text"], .form-row .input[type="email"], .form-row .input[type="password"], .form-row .input[type="tel"], .form-row .input[type="number"] {
    width: 100%;
    padding: 10px 10px 10px 100px;
}
input[type="text"], input[type="email"], input[type="number"], input[type="password"], input[type="tel"], textarea {
    background: #fff;
    padding: 8px 15px;
    border: 1px solid #cccccc;
    font-size: 14px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
.step-description h5 {
    font-weight: 400;
    font-size: 16px;
    margin-bottom: 15px;
}
p {
    font-size: 12px;
    font-weight: 300;
    margin: 0 0 15px 0;
    line-height: 18px;
}
.input-radio {
    float: left;
    position: relative;
    display: inline-block;
    padding-right: 10px;
}

</style>

<div class="main_bg1">
<div class="wrap">	
	<div class="main1">
		<h2>GIỎ HÀNG CỦA BẠN</h2>
	</div>
</div>
</div>
<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
	@if(isset($cart))
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
			        <table class="shop-table">
			          <thead>
			            <tr>
			              <th>
			                Ảnh
			              </th>
			              <th>
			                Sản phẩm
			              </th>
			              <th>
			                Giá
			              </th>
			              <th>
			                Số lượng
			              </th>
			              <th>
			                Tổng
			              </th>
			              <th>
			                Xóa
			              </th>
			            </tr>
			          </thead>
			          <tbody>
			            @foreach($cart as $cartItem)
			            <tr class="shopping-item shopping-item-{{ $cartItem->rowId }}">
			              <td>
			                <img src="/uploads/product/{{ $cartItem->options['img'] }}" alt="{{ $cartItem->name }}">
			              </td>
			              <td>
			                <div class="shop-details">
			                  <div class="productname">
			                    {{ $cartItem->name }}
			                  </div>
			                </div>
			              </td>
			              <td>
			                <h5>
			                  {{ number_format($cartItem->price, 0, ',', '.') }}
			                </h5>
			              </td>
			              <td>
			                <input class="qtyitem qtyitem-{{ $cartItem->rowId }}" data-rid="{{ $cartItem->rowId }}" type="text" name="quantity" value="{{ $cartItem->qty }}"  style="width:60px;" />
			              </td>
			              <td>
			                <h5>
			                  <strong class="red priceitem priceitem-{{ $cartItem->rowId }}">
			                    {{ number_format($cartItem->price*$cartItem->qty, 0, ',', '.') }}
			                  </strong>
			                </h5>
			              </td>
			              <td>
			                <a href="javascript:del_item_shopping('{{ $cartItem->rowId }}');" style="color:red" >
			                  <img src="/images/remove.png" alt="">
			                </a>
			              </td>
			            </tr>
			            @endforeach
			            <tr>
			              <td></td>
			              <td></td>
			              <td></td>
			              <td id="shopping-count">
			                @if(isset($count)) {{ $count }} @else 0 @endif
			              </td>
			              <td>
			                <h5>
			                  <strong class="red"  id="shopping-subtotal">
			                    @if(isset($subtotal)) {{ $subtotal }} @else 0 @endif
			                  </strong>
			                </h5>
			              </td>
			              <td>
			                
			              </td>
			            </tr>
			          </tbody>
			          <tfoot>
			          	@if (session('flash_message_err') != '')
						<div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
						@endif
						@if (session('flash_message_succ') != '')
						<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span> {!! session('flash_message_succ') !!}</div>
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
			            <tr>
			              <td colspan="6">
			              <ol class="checkout-steps">
			                <li class="steps">
					            <span class="step-title" style="color: #eea236">
					              thông tin đặt hàng
					            </span>
					            <div class="step-description step-description1">
					              <form method="post" action="/insertorder">
					                <div class="row">
					                  <div class="col-md-6 col-sm-6">
					                    <div class="your-details">
					                      <h5>
					                        Thông tin khách hàng
					                      </h5>
					                      <div class="form-row">
					                        <label class="lebel-abs">
					                          Họ tên 
					                          <strong class="red">
					                            *
					                          </strong>
					                        </label>
					                        <input type="text" class="input namefild" name="customer_name" id="customer_name" value="{!! old('customer_name') !!}" />
					                      </div>
					                      <div class="form-row">
					                        <label class="lebel-abs">
					                          Điện thoại 
					                          <strong class="red">
					                            *
					                          </strong>
					                        </label>
					                        <input type="text" class="input namefild" name="customer_phone" id="customer_phone" value="{!! old('customer_phone') !!}">
					                      </div>
					                      <div class="form-row">
					                        <label class="lebel-abs">
					                          Email
					                        </label>
					                        <input type="text" class="input namefild" name="customer_email" id="customer_email" value="{!! old('customer_email') !!}">
					                      </div>
					                      <div class="form-row">
					                        <label class="lebel-abs">
					                          Địa chỉ 
					                          <strong class="red">
					                            *
					                          </strong>
					                        </label>
					                        <input type="text" class="input namefild" name="customer_address" id="customer_address" value="{!! old('customer_address') !!}">
					                      </div>

					                      <div class="form-row">
					                        <label class="lebel-abs">
					                          Tin nhắn
					                        </label>
					                        <textarea type="text" class="input namefild" rows="10" name="order_notice" id="order_notice">{!! old('order_notice') !!}</textarea>
					                      </div>

					                      <button class="btn btn-warning" id="sub-order" type="submit">Đặt hàng</button>
					                      
					                    </div>
					                  </div>
					                  <!-- <div class="col-md-6 col-sm-6">
					                    <div class="your-details">
					                      <h5>
					                        Phương thức vận chuyển
					                      </h5>
					                      <p>
					                        <span class="input-radio">
					                          <input type="radio" name="transtype" value="1" checked="checked">
					                        </span>
					                        <span class="text">
					                          Nhân viên giao hàng trực tiếp
					                        </span>
					                      </p>
					                      <p>
					                        <span class="input-radio">
					                          <input type="radio" name="transtype" value="2">
					                        </span>
					                        <span class="text">
					                          Thông qua đường bưu điện
					                        </span>
					                      </p>
					                    </div>
					                  					  
					                    <div class="your-details">
					                      <h5>
					                        Phương thức thanh toán
					                      </h5>
					                      <p>
					                        <span class="input-radio">
					                          <input type="radio" name="paytype" value="1" checked="checked">
					                        </span>
					                        <span class="text">
					                          Thanh toán trực tiếp khi nhận hàng
					                        </span>
					                      </p>
					                      <p>
					                        <span class="input-radio">
					                          <input type="radio" name="paytype" value="2">
					                        </span>
					                        <span class="text">
					                          Thanh toán thông qua tài khoản ngân hàng
					                        </span>
					                      </p>
					                    </div>
					                    <p class="privacy">
					                      <span class="input-radio">
					                        <input type="checkbox" name="accept" id="accept" value="1" checked="checked" />
					                      </span>
					                      <span class="text">
					                        Tôi chấp nhận các điều khoản của
					                        <a href="#" class="red">
					                          Privacy Policy
					                        </a>
					                      </span>
					                    </p>
					                    <button id="sub-order" type="button">
					                      Đặt hàng
					                    </button>
					                  </div>
					                  					                </div> -->
					              </form>
					            </div>
					          </li>
					      </ol>
			              </td>
			            </tr>
			          </tfoot>
			        </table>
			        <div class="clearfix"></div>
			      </div>
						</div>
					</div>
				</div>
	@endif
</div>
</div>

@stop
