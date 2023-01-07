@extends('frontend.layouts.master')

@if (isset($title))
@section('title',$title)
@else
@section('title','menu')
@endif

@section('content')

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="/">Trang chủ</a></li>
                <li class='active'>Giỏ hàng của bạn</li>
            </ul>
        </div>
        <!-- /.breadcrumb-inner -->
    </div>
    <!-- /.container -->
</div>
<!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row ">
            <div class="shopping-cart">
                <div class="shopping-cart-table ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-romove item">Xóa</th>
                                    <th class="cart-description item">Ảnh</th>
                                    <th class="cart-product-name item">Tên</th>
                                    <th class="cart-qty item">Số lượng</th>
                                    <th class="cart-sub-total item">Giá</th>
                                    <th class="cart-total last-item">Tổng</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div class="shopping-cart-btn">
                                            <span class="">
                                            <a href="/" class="btn btn-upper btn-primary outer-left-xs">Tiếp tục mua hàng</a>
                                            <!-- <a href="javascript:update_cart2()" class="btn btn-upper btn-primary pull-right outer-right-xs">Cập nhật giỏ hàng</a> -->
                                            </span>
                                        </div>
                                        <!-- /.shopping-cart-btn -->
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if(isset($cart))
                                    @foreach($cart as $cartItem)
                                        <tr>
                                            <td class="romove-item"><a href="javascript:del_item_cart('{{ $cartItem->rowId }}');" title="cancel" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                            <td class="cart-image">
                                                <a class="entry-thumbnail" href="detail.html">
                                                <img src="/uploads/product/{{ $cartItem->options['img'] }}" alt="">
                                                </a>
                                            </td>
                                            <td class="cart-product-name-info">
                                                <h4 class='cart-product-description'><a href="detail.html">{{ $cartItem->name }}</a></h4>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="rating rateit-small"></div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="reviews">
                                                            (06 Reviews)
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                                <div class="cart-product-info">
                                                    <span class="product-color">COLOR:<span>Blue</span></span>
                                                </div>
                                            </td>                                    
                                            <td class="cart-product-quantity">
                                                <div class="quant-input">
                                                    <!-- <div class="arrows">
                                                        <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
                                                        <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
                                                    </div> -->
                                                    <input type="text" onchange="update_cart('{{ $cartItem->rowId }}',this.value);" value="{{ $cartItem->qty }}">
                                                </div>
                                            </td>
                                            <td class="cart-product-sub-total"><span class="cart-sub-total-price">{{ number_format($cartItem->price, 0, ',', '.') }}</span></td>
                                            <td class="cart-product-grand-total"><span class="cart-grand-total-price">{{ number_format($cartItem->price*$cartItem->qty, 0, ',', '.') }}</span></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <!-- /tbody -->
                        </table>
                        <!-- /table -->
                    </div>
                </div>
                <!-- /.shopping-cart-table -->				
                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                    <table class="table hide">
                        <thead>
                            <tr>
                                <th>
                                    <span class="estimate-title">Estimate shipping and tax</span>
                                    <p>Enter your destination to get shipping and tax.</p>
                                </th>
                            </tr>
                        </thead>
                        <!-- /thead -->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="info-title control-label">Country <span>*</span></label>
                                        <select class="form-control unicase-form-control selectpicker">
                                            <option>--Select options--</option>
                                            <option>India</option>
                                            <option>SriLanka</option>
                                            <option>united kingdom</option>
                                            <option>saudi arabia</option>
                                            <option>united arab emirates</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="info-title control-label">State/Province <span>*</span></label>
                                        <select class="form-control unicase-form-control selectpicker">
                                            <option>--Select options--</option>
                                            <option>TamilNadu</option>
                                            <option>Kerala</option>
                                            <option>Andhra Pradesh</option>
                                            <option>Karnataka</option>
                                            <option>Madhya Pradesh</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="info-title control-label">Zip/Postal Code</label>
                                        <input type="text" class="form-control unicase-form-control text-input" placeholder="">
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn-upper btn btn-primary">GET A QOUTE</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.estimate-ship-tax -->
                <div class="col-md-4 col-sm-12 estimate-ship-tax">
                    <table class="table hide">
                        <thead>
                            <tr>
                                <th>
                                    <span class="estimate-title">Mã giảm giá</span>
                                    <p>Nhập mã giảm giá nếu bạn có..</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control unicase-form-control text-input" id="coupon" placeholder="mã giảm giá..">
                                    </div>
                                    <!-- <div class="clearfix pull-right">
                                        <button type="submit" class="btn-upper btn btn-primary">Áp dụng</button>
                                    </div> -->
                                </td>
                            </tr>
                        </tbody>
                        <!-- /tbody -->
                    </table>
                    <!-- /table -->
                </div>
                <!-- /.estimate-ship-tax -->
                <div class="col-md-4 col-sm-12 cart-shopping-total">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="cart-sub-total">
                                        Subtotal<span class="inner-left-md">{{ $subtotal }}</span>
                                    </div>
                                    <div class="cart-grand-total">
                                        Grand Total<span class="inner-left-md">{{ $subtotal }}</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- /thead -->
                        <tbody>
                            <tr>
                                <td>
                                    <div class="cart-checkout-btn pull-right">
                                        <a href="/dat-hang"><button type="button" class="btn btn-primary checkout-btn">ĐẶT HÀNG</button></a>
                                        <!-- <span class="">Checkout with multiples address!</span> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <!-- /tbody -->
                    </table>
                    <!-- /table -->
                </div>
                <!-- /.cart-shopping-total -->			
            </div>
            <!-- /.shopping-cart -->
        </div>
        <!-- /.row -->

        <!-- ======= BRANDS CAROUSEL ======= -->
		@include('frontend.layouts.brands')
		<!-- ======= BRANDS CAROUSEL : END ======= -->
		
    </div>
    <!-- /.container -->
</div>
<!-- /.body-content -->

@stop
