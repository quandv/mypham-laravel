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
                <li class='active'>Đặt hàng</li>
            </ul>
        </div>
        <!-- /.breadcrumb-inner -->
    </div>
    <!-- /.container -->
</div>
<!-- /.breadcrumb -->
<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">
                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
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

                            <!-- panel-heading -->
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                    <span>1</span>Thông tin đặt hàng
                                    </a>
                                </h4>
                            </div>
                            <!-- panel-heading -->
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- already-registered-login -->
                                        <div class="col-md-12 col-sm-12 already-registered-login">
                                            <a href="/gio-hang"><button class="btn btn-default btn-xs"><i class="fa fa-arrow-circle-left"></i> Giỏ hàng của tôi</button></a><br><br>
                                            
                                            <form class="order-form" role="form" method="post" action="/insertorder">
                                                <div class="form-group">
                                                    <label class="info-title" for="order-name">Họ & Tên <span>*</span></label>
                                                    <input type="text" name="customer_name" class="form-control unicase-form-control text-input" id="order-name" placeholder="" value="{!! old('customer_name') !!}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="order-phone">Số điện thoại <span>*</span></label>
                                                    <input type="text" name="customer_phone" class="form-control unicase-form-control text-input" id="order-phone" placeholder="" value="{!! old('customer_phone') !!}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="order-email">Email</label>
                                                    <input type="text" name="customer_email" class="form-control unicase-form-control text-input" id="order-email" placeholder="" value="{!! old('customer_email') !!}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="order-address">Địa chỉ nhận hàng <span>*</span></label>
                                                    <textarea name="customer_address" class="form-control unicase-form-control" id="order-address" cols="30" rows="5">{!! old('customer_address') !!}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="info-title" for="order-notice">Ghi chú</label>
                                                    <textarea name="order_notice" class="form-control unicase-form-control" id="order-notice" cols="30" rows="5">{!! old('order_notice') !!}</textarea>
                                                </div>
                                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Đặt hàng</button>
                                            </form>
                                        </div>
                                        <!-- already-registered-login -->		
                                    </div>
                                </div>
                                <!-- panel-body  -->
                            </div>
                            <!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                        <!-- checkout-step-02  -->
                        <div class="panel panel-default checkout-step-02 hide">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
                                    <span>2</span>Billing Information
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                        <!-- checkout-step-02  -->

                        <!-- checkout-step-03  -->
                        <div class="panel panel-default checkout-step-03 hide">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseThree">
                                    <span>3</span>Shipping Information
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                        <!-- checkout-step-03  -->

                        <!-- checkout-step-04  -->
                        <div class="panel panel-default checkout-step-04 hide">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseFour">
                                    <span>4</span>Shipping Method
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                        <!-- checkout-step-04  -->

                        <!-- checkout-step-05  -->
                        <div class="panel panel-default checkout-step-05 hide">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseFive">
                                    <span>5</span>Payment Information
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                        <!-- checkout-step-05  -->

                        <!-- checkout-step-06  -->
                        <div class="panel panel-default checkout-step-06 hide">
                            <div class="panel-heading">
                                <h4 class="unicase-checkout-title">
                                    <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseSix">
                                    <span>6</span>Order Review
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                        <!-- checkout-step-06  -->

                    </div>
                    <!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar hide">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                </div>
                                <div class="">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        <li><a href="#">Billing Address</a></li>
                                        <li><a href="#">Shipping Address</a></li>
                                        <li><a href="#">Shipping Method</a></li>
                                        <li><a href="#">Payment Method</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- checkout-progress-sidebar -->				
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.checkout-box -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        <div id="brands-carousel" class="logo-slider wow fadeInUp">
            <div class="logo-slider-inner">
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item m-t-10">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand3.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand6.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand2.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand4.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand1.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                    <div class="item">
                        <a href="#" class="image">
                        <img data-echo="assets/images/brands/brand5.png" src="assets/images/blank.gif" alt="">
                        </a>	
                    </div>
                    <!--/.item-->
                </div>
                <!-- /.owl-carousel #logo-slider -->
            </div>
            <!-- /.logo-slider-inner -->
        </div>
        <!-- /.logo-slider -->
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->	
    </div>
    <!-- /.container -->
</div>
<!-- /.body-content -->

@stop
