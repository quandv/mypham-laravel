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
                    <li><a href="#">Home</a></li>
                    <li class='active'>Handbags</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row'>
                <div class='col-md-3 sidebar'>
                    <!-- ====== TOP NAVIGATION ====== -->
					@include('frontend.layouts.sidebar.menu')
					<!-- ====== TOP NAVIGATION: END ====== -->

                    <div class="sidebar-module-container">
                        <div class="sidebar-filter">
                            <!-- ====== CAT-CATEGORY ===== -->
                            @include('frontend.layouts.sidebar.cat-category')
                            <!-- ====== CAT-CATEGORY: END ====== -->

                            <!-- ====== PRICE-SLIDER ===== -->
                            @include('frontend.layouts.sidebar.price-slider')
                            <!-- ====== PRICE-SLIDER: END ====== -->

                            <!-- ====== MANUFACTURES ===== -->
                            @include('frontend.layouts.sidebar.manufactures')
                            <!-- ====== MANUFACTURES: END ====== -->

                            <!-- ====== COLOR ===== -->
                            @include('frontend.layouts.sidebar.color')
                            <!-- ====== COLOR: END ====== -->

                            <!-- ====== COMPARE ===== -->
                            @include('frontend.layouts.sidebar.compare')
                            <!-- ====== COMPARE: END ====== -->

                            <!-- ======= PRODUCT TAGS ======= -->
							@include('frontend.layouts.sidebar.product-tag')
							<!-- ======= PRODUCT TAGS : END ======= -->

                            <!-- ======= Testimonials ======= -->
							@include('frontend.layouts.sidebar.testimonials')
							<!-- ======= Testimonials: END ======= -->

                        </div>
                        <!-- /.sidebar-filter -->
                    </div>
                    <!-- /.sidebar-module-container -->
                </div>
                <!-- /.sidebar -->
                <div class='col-md-9'>
                    <!-- ========================================== SECTION – HERO ========================================= -->
                    <div id="category" class="category-carousel hidden-xs">
                        <div class="item">
                            <div class="image">
                                <img src="/images/banners/cat-banner-1.jpg" alt="" class="img-responsive">
                            </div>
                            <div class="container-fluid">
                                <div class="caption vertical-top text-left">
                                    <div class="big-text">
                                        Big Sale
                                    </div>
                                    <div class="excerpt hidden-sm hidden-md">
                                        Save up to 49% off
                                    </div>
                                    <div class="excerpt-normal hidden-sm hidden-md">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit
                                    </div>
                                </div>
                                <!-- /.caption -->
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                    </div>
                    <!-- ========================================= SECTION – HERO : END ========================================= -->
                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <div class="col col-sm-6 col-md-2">
                                <div class="filter-tabs">
                                    <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                        <li class="active">
                                            <a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th-large"></i>Lưới</a>
                                        </li>
                                        <li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i>Danh sách</a></li>
                                    </ul>
                                </div>
                                <!-- /.filter-tabs -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-12 col-md-6">
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    <div class="lbl-cnt">
                                        <span class="lbl">Sắp xếp</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                Position <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">position</a></li>
                                                    <li role="presentation"><a href="#">Price:Lowest first</a></li>
                                                    <li role="presentation"><a href="#">Price:HIghest first</a></li>
                                                    <li role="presentation"><a href="#">Product Name:A to Z</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                                <div class="col col-sm-3 col-md-6 no-padding hide">
                                    <div class="lbl-cnt">
                                        <span class="lbl">Show</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                1 <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">1</a></li>
                                                    <li role="presentation"><a href="#">2</a></li>
                                                    <li role="presentation"><a href="#">3</a></li>
                                                    <li role="presentation"><a href="#">4</a></li>
                                                    <li role="presentation"><a href="#">5</a></li>
                                                    <li role="presentation"><a href="#">6</a></li>
                                                    <li role="presentation"><a href="#">7</a></li>
                                                    <li role="presentation"><a href="#">8</a></li>
                                                    <li role="presentation"><a href="#">9</a></li>
                                                    <li role="presentation"><a href="#">10</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-6 col-md-4 text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->		
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        @foreach($products as $item)
                                        <?php $img = json_decode($item->product_image); ?>
                                        <div class="col-sm-6 col-md-4 wow fadeInUp">
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <a href="/san-pham/<?php echo $item->product_id.'/'.$item->alias.'.html'; ?>"><img  src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $item->product_name }}"></a>
                                                        </div>
                                                        <!-- /.image -->			
                                                        <div class="tag new"><span>new</span></div>
                                                    </div>
                                                    <!-- /.product-image -->
                                                    <div class="product-info text-left">
                                                        <h3 class="name"><a href="/san-pham/<?php echo $item->product_id.'/'.$item->alias.'.html'; ?>">{{ $item->product_name }}</a></h3>
                                                        <div class="rating rateit-small"></div>
                                                        <div class="description"></div>
                                                        <div class="product-price">	
                                                            <span class="price">{{ number_format($item->product_price, 0, ',', '.') }} VND</span>
                                                            <span class="price-before-discount">{{ number_format($item->product_price, 0, ',', '.') }} VND</span>
                                                        </div>
                                                        <!-- /.product-price -->
                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div class="cart clearfix animate-effect">
                                                        <div class="action">
                                                            <ul class="list-unstyled">
                                                                <li class="add-cart-button btn-group">
                                                                    <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                                                    <i class="fa fa-shopping-cart"></i>													
                                                                    </button>
                                                                    <button class="btn btn-primary cart-btn" type="button" onclick="add_cart({{ $item->product_id }});">Mua</button>
                                                                </li>
                                                                <li class="lnk wishlist">
                                                                    <a class="add-to-cart" href="detail.html" title="Yêu thích">
                                                                    <i class="icon fa fa-heart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="lnk">
                                                                    <a class="add-to-cart" href="detail.html" title="So sánh">
                                                                    <i class="fa fa-signal"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- /.action -->
                                                    </div>
                                                    <!-- /.cart -->
                                                </div>
                                                <!-- /.product -->
                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.category-product -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane "  id="list-container">
                                <div class="category-product">
                                    @foreach($products as $item)
                                    <?php $img = json_decode($item->product_image); ?>
                                    <div class="category-product-inner wow fadeInUp">
                                        <div class="products">
                                            <div class="product-list product">
                                                <div class="row product-list-row">
                                                    <div class="col col-sm-4 col-lg-4">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <img src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $item->product_name }}">
                                                            </div>
                                                        </div>
                                                        <!-- /.product-image -->
                                                    </div>
                                                    <!-- /.col -->
                                                    <div class="col col-sm-8 col-lg-8">
                                                        <div class="product-info">
                                                            <h3 class="name"><a href="/san-pham/<?php echo $item->product_id.'/'.$item->alias.'.html'; ?>">{{ $item->product_name }}</a></h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="product-price">	
                                                                <span class="price">{{ number_format($item->product_price, 0, ',', '.') }} VND</span>
                                                                <span class="price-before-discount">{{ number_format($item->product_price, 0, ',', '.') }} VND</span>
                                                            </div>
                                                            <!-- /.product-price -->
                                                            <div class="description m-t-10">Suspendisse posuere arcu diam, id accumsan eros pharetra ac. Nulla enim risus, facilisis bibendum gravida eget, lacinia id purus. Suspendisse posuere arcu diam, id accumsan eros pharetra ac. Nulla enim risus, facilisis bibendum gravida eget.</div>
                                                            <div class="cart clearfix animate-effect">
                                                                <div class="action">
                                                                    <ul class="list-unstyled">
                                                                        <li class="add-cart-button btn-group">
                                                                            <button class="btn btn-primary icon" data-toggle="dropdown" type="button">
                                                                            <i class="fa fa-shopping-cart"></i>													
                                                                            </button>
                                                                            <button class="btn btn-primary cart-btn" type="button" onclick="add_cart({{ $item->product_id }});">Mua</button>
                                                                        </li>
                                                                        <li class="lnk wishlist">
                                                                            <a class="add-to-cart" href="detail.html" title="Yêu thích">
                                                                            <i class="icon fa fa-heart"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li class="lnk">
                                                                            <a class="add-to-cart" href="detail.html" title="So sánh">
                                                                            <i class="fa fa-signal"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /.action -->
                                                            </div>
                                                            <!-- /.cart -->
                                                        </div>
                                                        <!-- /.product-info -->	
                                                    </div>
                                                    <!-- /.col -->
                                                </div>
                                                <!-- /.product-list-row -->
                                                <div class="tag new"><span>new</span></div>
                                            </div>
                                            <!-- /.product-list -->
                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    @endforeach
                                </div>
                                <!-- /.category-product -->
                            </div>
                            <!-- /.tab-pane #list-container -->
                        </div>
                        <!-- /.tab-content -->
                        <div class="clearfix filters-container">
                            <div class="text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->						    
                            </div>
                            <!-- /.text-right -->
                        </div>
                        <!-- /.filters-container -->
                    </div>
                    <!-- /.search-result-container -->
                </div>
                <!-- /.col -->
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
