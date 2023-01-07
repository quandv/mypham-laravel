@extends('frontend.layouts.master')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','menu')
@endif

@section('content')

<div class="body-content outer-top-xs" id="top-banner-and-menu">
			<div class="container">
				<div class="row">
					<!-- ======= SIDEBAR ======= -->	
					<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
						
						<!-- ====== TOP NAVIGATION ====== -->
						@include('frontend.layouts.sidebar.menu')
						<!-- ====== TOP NAVIGATION: END ====== -->

						<!-- ======= HOT DEALS ======= -->
						@include('frontend.layouts.sidebar.hot-deal')
						<!-- ======= HOT DEALS: END ======= -->

						<!-- ======= SPECIAL OFFER ======= -->
						@include('frontend.layouts.sidebar.special-offer')
						<!-- ======= SPECIAL OFFER : END ======= -->

						<!-- ======= PRODUCT TAGS ======= -->
						@include('frontend.layouts.sidebar.product-tag')
						<!-- ======= PRODUCT TAGS : END ======= -->

						<!-- ======= SPECIAL DEALS ======= -->
						@include('frontend.layouts.sidebar.special-deal')
						<!-- ======= SPECIAL DEALS : END ======= -->

						<!-- ======= NEWSLETTER ======= -->
						@include('frontend.layouts.sidebar.newsletter')
						<!-- ======= NEWSLETTER: END ======= -->
					
						<!-- ======= Testimonials ======= -->
						@include('frontend.layouts.sidebar.testimonials')
						<!-- ======= Testimonials: END ======= -->

						<!-- ======= Home banner ======= -->
						@include('frontend.layouts.sidebar.home-banner')
						<!-- ======= Home banner: END ======= -->

					</div><!-- /.sidemenu-holder -->
					<!-- ======= SIDEBAR : END ======= -->

					<!-- ======= CONTENT ======= -->
					<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
						<!-- === SECTION – HERO == -->
						@include('frontend.layouts.slider')
						<!-- == SECTION – HERO : END == -->	

						<!-- ======= INFO BOXES ======= -->
						@include('frontend.layouts.info_box')
						<!-- ======= INFO BOXES : END ======= -->

						<!-- ======= NEW PRODUCT ======= -->
						@if(isset($new) && count($new) > 0)
						<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
						    <div class="more-info-tab clearfix ">
						        <h3 class="new-product-title pull-left">Sản phẩm mới</h3>
						        <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
						            <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">All</a></li>
						            <li><a data-transition-type="backSlide" href="#smartphone" data-toggle="tab">Clothing</a></li>
						            <li><a data-transition-type="backSlide" href="#laptop" data-toggle="tab">Electronics</a></li>
						            <li><a data-transition-type="backSlide" href="#apple" data-toggle="tab">Shoes</a></li>
						        </ul>
						        <!-- /.nav-tabs -->
						    </div>
						    <div class="tab-content outer-top-xs">
						        <div class="tab-pane in active" id="all">
						            <div class="product-slider">
						                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="4">
						                	@foreach($new as $newItem)
											<?php  $img = json_decode($newItem->product_image); ?>
						                    <div class="item item-carousel">
						                        <div class="products">
						                            <div class="product">
						                                <div class="product-image">
						                                    <div class="image">
						                                        <a href="/san-pham/<?php echo $newItem->product_id.'/'.$newItem->alias.'.html'; ?>"><img  src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $newItem->product_name }}"></a>
						                                    </div>
						                                    <!-- /.image -->			
						                                    <div class="tag new"><span>new</span></div>
						                                </div>
						                                <!-- /.product-image -->
						                                <div class="product-info text-left">
						                                    <h3 class="name"><a href="/san-pham/<?php echo $newItem->product_id.'/'.$newItem->alias.'.html'; ?>">{{ $newItem->product_name }}</a></h3>
						                                    <div class="rating rateit-small"></div>
						                                    <div class="description"></div>
						                                    <div class="product-price">	
						                                        <span class="price">{{ number_format($newItem->product_price, 0, ',', '.') }} VND</span>
						                                        <span class="price-before-discount">{{ number_format($newItem->product_price, 0, ',', '.') }} VND</span>
						                                    </div>
						                                    <!-- /.product-price -->
						                                </div>
						                                <!-- /.product-info -->
						                                <div class="cart clearfix animate-effect">
						                                    <div class="action">
						                                        <ul class="list-unstyled">
						                                            <li class="add-cart-button btn-group">
						                                                <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Mua" onclick="add_cart({{ $newItem->product_id }});">
						                                                <i class="fa fa-shopping-cart"></i>													
						                                                </button>
						                                                <button class="btn btn-primary cart-btn" type="button" onclick="add_cart({{ $newItem->product_id }});">Mua</button>
						                                            </li>
						                                            <li class="lnk wishlist">
						                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Yêu thích">
						                                                <i class="icon fa fa-heart"></i>
						                                                </a>
						                                            </li>
						                                            <li class="lnk">
						                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="So sánh">
						                                                <i class="fa fa-signal" aria-hidden="true"></i>
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
						                <!-- /.home-owl-carousel -->
						            </div>
						            <!-- /.product-slider -->
						        </div>
						        <!-- /.tab-pane -->
						    </div>
						    <!-- /.tab-content -->
						</div>
						@endif
						<!-- /.scroll-tabs -->
						<!-- ======= NEW PRODUCT : END ======= -->

						<!-- ======= WIDE PRODUCTS ======= -->
						<div class="wide-banners wow fadeInUp outer-bottom-xs">
						    <div class="row">
						        <div class="col-md-7 col-sm-7">
						            <div class="wide-banner cnt-strip">
						                <div class="image">
						                    <img class="img-responsive" src="/images/banners/home-banner1.jpg" alt="">
						                </div>
						            </div>
						            <!-- /.wide-banner -->
						        </div>
						        <!-- /.col -->
						        <div class="col-md-5 col-sm-5">
						            <div class="wide-banner cnt-strip">
						                <div class="image">
						                    <img class="img-responsive" src="/images/banners/home-banner2.jpg" alt="">
						                </div>
						            </div>
						            <!-- /.wide-banner -->
						        </div>
						        <!-- /.col -->
						    </div>
						    <!-- /.row -->
						</div>
						<!-- /.wide-banners -->
						<!-- ======= WIDE PRODUCTS : END ======= -->
						<!-- ======= FEATURED PRODUCTS ======= -->
						@if(isset($hot) && count($hot) > 0)
						<section class="section featured-product wow fadeInUp">
						    <h3 class="section-title">Sản phẩm nổi bật</h3>
						    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
								@foreach($hot as $hotItem)
								<?php  $img = json_decode($hotItem->product_image); ?>
						        <div class="item item-carousel">
						            <div class="products">
						                <div class="product">
						                    <div class="product-image">
						                        <div class="image">
						                            <a href="/san-pham/<?php echo $hotItem->product_id.'/'.$hotItem->alias.'.html'; ?>"><img  src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $hotItem->product_name }}"></a>
						                        </div>
						                        <!-- /.image -->			
						                        <div class="tag hot"><span>hot</span></div>
						                    </div>
						                    <!-- /.product-image -->
						                    <div class="product-info text-left">
						                        <h3 class="name"><a href="/san-pham/<?php echo $hotItem->product_id.'/'.$hotItem->alias.'.html'; ?>">{{ $hotItem->product_name }}</a></h3>
						                        <div class="rating rateit-small"></div>
						                        <div class="description"></div>
						                        <div class="product-price">	
						                            <span class="price">{{ number_format($hotItem->product_price, 0, ',', '.') }} VND</span>
						                            <span class="price-before-discount">{{ number_format($hotItem->product_price, 0, ',', '.') }} VND</span>
						                        </div>
						                        <!-- /.product-price -->
						                    </div>
						                    <!-- /.product-info -->
						                    <div class="cart clearfix animate-effect">
			                                    <div class="action">
			                                        <ul class="list-unstyled">
			                                            <li class="add-cart-button btn-group">
			                                                <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Mua" onclick="add_cart({{ $hotItem->product_id }});">
			                                                <i class="fa fa-shopping-cart"></i>													
			                                                </button>
			                                                <button class="btn btn-primary cart-btn" type="button" onclick="add_cart({{ $hotItem->product_id }});">Mua</button>
			                                            </li>
			                                            <li class="lnk wishlist">
			                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Yêu thích">
			                                                <i class="icon fa fa-heart"></i>
			                                                </a>
			                                            </li>
			                                            <li class="lnk">
			                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="So sánh">
			                                                <i class="fa fa-signal" aria-hidden="true"></i>
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
						    <!-- /.home-owl-carousel -->
						</section>
						@endif
						<!-- /.section -->
						<!-- ======= FEATURED PRODUCTS : END ======= -->
						<!-- ======= WIDE PRODUCTS ======= -->
						<div class="wide-banners wow fadeInUp outer-bottom-xs">
						    <div class="row">
						        <div class="col-md-12">
						            <div class="wide-banner cnt-strip">
						                <div class="image">
						                    <img class="img-responsive" src="/images/banners/home-banner.jpg" alt="">
						                </div>
						                <div class="strip strip-text">
						                    <div class="strip-inner">
						                        <h2 class="text-right">New Mens Fashion<br>
						                            <span class="shopping-needs">Save up to 40% off</span>
						                        </h2>
						                    </div>
						                </div>
						                <div class="new-label">
						                    <div class="text">NEW</div>
						                </div>
						                <!-- /.new-label -->
						            </div>
						            <!-- /.wide-banner -->
						        </div>
						        <!-- /.col -->
						    </div>
						    <!-- /.row -->
						</div>
						<!-- /.wide-banners -->
						<!-- ======= WIDE PRODUCTS : END ======= -->
						<!-- ======= BEST SELLER ======= -->
						@if(isset($sale) && count($sale) > 0)
						<div class="best-deal wow fadeInUp outer-bottom-xs">
						    <h3 class="section-title">Sản phẩm bán chạy</h3>
						    <div class="sidebar-widget-body outer-top-xs">
						        <div class="owl-carousel best-seller custom-carousel owl-theme outer-top-xs">						        	
									<?php 
										//print_r($sale);
										for($i = 0; $i < count($sale); $i += 2 ){
										$img1 = json_decode($sale[$i]->product_image);
									?>
						            <div class="item">
						                <div class="products best-product">
						                    <div class="product">
						                        <div class="product-micro">
						                            <div class="row product-micro-row">
						                                <div class="col col-xs-5">
						                                    <div class="product-image">
						                                        <div class="image">
						                                            <a href="/san-pham/<?php echo $sale[$i]->product_id.'/'.$sale[$i]->alias.'.html'; ?>">
						                                            <img src="{{ asset('/uploads/product/'.$img1[0]) }}" alt="{{ $sale[$i]->product_name }}">
						                                            </a>					
						                                        </div>
						                                        <!-- /.image -->
						                                    </div>
						                                    <!-- /.product-image -->
						                                </div>
						                                <!-- /.col -->
						                                <div class="col2 col-xs-7">
						                                    <div class="product-info">
						                                        <h3 class="name"><a href="/san-pham/<?php echo $sale[$i]->product_id.'/'.$sale[$i]->alias.'.html'; ?>">{{ $sale[$i]->product_name }}</a></h3>
						                                        <div class="rating rateit-small"></div>
						                                        <div class="product-price">	
						                                            <span class="price">{{ number_format($sale[$i]->product_price, 0, ',', '.') }} VND</span>
						                                        </div>
						                                        <!-- /.product-price -->
						                                    </div>
						                                </div>
						                                <!-- /.col -->
						                            </div>
						                            <!-- /.product-micro-row -->
						                        </div>
						                        <!-- /.product-micro -->
						                    </div>
						                    <?php if(array_key_exists($i+1, $sale)){
						                    	$img2 = json_decode($sale[$i+1]->product_image);
						                    ?>
						                    <div class="product">
						                        <div class="product-micro">
						                            <div class="row product-micro-row">
						                                <div class="col col-xs-5">
						                                    <div class="product-image">
						                                        <div class="image">
						                                            <a href="/san-pham/<?php echo $sale[$i+1]->product_id.'/'.$sale[$i+1]->alias.'.html'; ?>">
						                                            <img src="{{ asset('/uploads/product/'.$img2[0]) }}" alt="{{ $sale[$i+1]->product_name }}">
						                                            </a>					
						                                        </div>
						                                        <!-- /.image -->
						                                    </div>
						                                    <!-- /.product-image -->
						                                </div>
						                                <!-- /.col -->
						                                <div class="col2 col-xs-7">
						                                    <div class="product-info">
						                                        <h3 class="name"><a href="/san-pham/<?php echo $sale[$i+1]->product_id.'/'.$sale[$i+1]->alias.'.html'; ?>">{{ $sale[$i+1]->product_name }}</a></h3>
						                                        <div class="rating rateit-small"></div>
						                                        <div class="product-price">	
						                                            <span class="price">{{ number_format($sale[$i+1]->product_price, 0, ',', '.') }} VND</span>
						                                        </div>
						                                        <!-- /.product-price -->
						                                    </div>
						                                </div>
						                                <!-- /.col -->
						                            </div>
						                            <!-- /.product-micro-row -->
						                        </div>
						                        <!-- /.product-micro -->
						                    </div>
						                    <?php } ?>
						                </div>
						            </div>
						            <?php } ?>
						        </div>
						    </div>
						    <!-- /.sidebar-widget-body -->
						</div>
						@endif
						<!-- /.sidebar-widget -->
						<!-- ======= BEST SELLER : END ======= -->	
						<!-- ======= BLOG SLIDER ======= -->
						<section class="section latest-blog outer-bottom-vs wow fadeInUp">
						    <h3 class="section-title">Tin mới nhất</h3>
						    <div class="blog-slider-container outer-top-xs">
						        <div class="owl-carousel blog-slider custom-carousel">
						            <div class="item">
						                <div class="blog-post">
						                    <div class="blog-post-image">
						                        <div class="image">
						                            <a href="blog.html"><img src="/images/blog-post/post1.jpg" alt=""></a>
						                        </div>
						                    </div>
						                    <!-- /.blog-post-image -->
						                    <div class="blog-post-info text-left">
						                        <h3 class="name"><a href="#">Voluptatem accusantium doloremque laudantium</a></h3>
						                        <span class="info">By Jone Doe &nbsp;|&nbsp; 21 March 2016 </span>
						                        <p class="text">Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
						                        <a href="#" class="lnk btn btn-primary">Read more</a>
						                    </div>
						                    <!-- /.blog-post-info -->
						                </div>
						                <!-- /.blog-post -->
						            </div>
						            <!-- /.item -->
						            <div class="item">
						                <div class="blog-post">
						                    <div class="blog-post-image">
						                        <div class="image">
						                            <a href="blog.html"><img src="/images/blog-post/post2.jpg" alt=""></a>
						                        </div>
						                    </div>
						                    <!-- /.blog-post-image -->
						                    <div class="blog-post-info text-left">
						                        <h3 class="name"><a href="#">Dolorem eum fugiat quo voluptas nulla pariatur</a></h3>
						                        <span class="info">By Saraha Smith &nbsp;|&nbsp; 21 March 2016 </span>
						                        <p class="text">Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
						                        <a href="#" class="lnk btn btn-primary">Read more</a>
						                    </div>
						                    <!-- /.blog-post-info -->
						                </div>
						                <!-- /.blog-post -->
						            </div>
						            <!-- /.item -->
						            <!-- /.item -->
						            <div class="item">
						                <div class="blog-post">
						                    <div class="blog-post-image">
						                        <div class="image">
						                            <a href="blog.html"><img src="/images/blog-post/post1.jpg" alt=""></a>
						                        </div>
						                    </div>
						                    <!-- /.blog-post-image -->
						                    <div class="blog-post-info text-left">
						                        <h3 class="name"><a href="#">Dolorem eum fugiat quo voluptas nulla pariatur</a></h3>
						                        <span class="info">By Saraha Smith &nbsp;|&nbsp; 21 March 2016 </span>
						                        <p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
						                        <a href="#" class="lnk btn btn-primary">Read more</a>
						                    </div>
						                    <!-- /.blog-post-info -->
						                </div>
						                <!-- /.blog-post -->
						            </div>
						            <!-- /.item -->
						            <div class="item">
						                <div class="blog-post">
						                    <div class="blog-post-image">
						                        <div class="image">
						                            <a href="blog.html"><img src="/images/blog-post/post2.jpg" alt=""></a>
						                        </div>
						                    </div>
						                    <!-- /.blog-post-image -->
						                    <div class="blog-post-info text-left">
						                        <h3 class="name"><a href="#">Dolorem eum fugiat quo voluptas nulla pariatur</a></h3>
						                        <span class="info">By Saraha Smith &nbsp;|&nbsp; 21 March 2016 </span>
						                        <p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
						                        <a href="#" class="lnk btn btn-primary">Read more</a>
						                    </div>
						                    <!-- /.blog-post-info -->
						                </div>
						                <!-- /.blog-post -->
						            </div>
						            <!-- /.item -->
						            <div class="item">
						                <div class="blog-post">
						                    <div class="blog-post-image">
						                        <div class="image">
						                            <a href="blog.html"><img src="/images/blog-post/post1.jpg" alt=""></a>
						                        </div>
						                    </div>
						                    <!-- /.blog-post-image -->
						                    <div class="blog-post-info text-left">
						                        <h3 class="name"><a href="#">Dolorem eum fugiat quo voluptas nulla pariatur</a></h3>
						                        <span class="info">By Saraha Smith &nbsp;|&nbsp; 21 March 2016 </span>
						                        <p class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
						                        <a href="#" class="lnk btn btn-primary">Read more</a>
						                    </div>
						                    <!-- /.blog-post-info -->
						                </div>
						                <!-- /.blog-post -->
						            </div>
						            <!-- /.item -->
						        </div>
						        <!-- /.owl-carousel -->
						    </div>
						    <!-- /.blog-slider-container -->
						</section>
						<!-- /.section -->
						<!-- ======= BLOG SLIDER : END ======= -->	
						<!-- ======= FEATURED PRODUCTS ======= -->
						@if(isset($new) && count($new) > 0)
						<section class="section wow fadeInUp new-arriavls">
						    <h3 class="section-title">Khám phá</h3>
						    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">
						    	@foreach($new as $newItem)
								<?php $img = json_decode($newItem->product_image); ?>
						        <div class="item item-carousel">
						            <div class="products">
						                <div class="product">
						                    <div class="product-image">
						                        <div class="image">
						                            <a href="/san-pham/<?php echo $newItem->product_id.'/'.$newItem->alias.'.html'; ?>"><img  src="{{ asset('/uploads/product/'.$img[0]) }}" alt="{{ $newItem->product_name }}"></a>
						                        </div>
						                        <!-- /.image -->			
						                        <div class="tag new"><span>new</span></div>
						                    </div>
						                    <!-- /.product-image -->
						                    <div class="product-info text-left">
						                        <h3 class="name"><a href="/san-pham/<?php echo $newItem->product_id.'/'.$newItem->alias.'.html'; ?>">{{ $newItem->product_name }}</a></h3>
						                        <div class="rating rateit-small"></div>
						                        <div class="description"></div>
						                        <div class="product-price">	
						                            <span class="price">{{ number_format($newItem->product_price, 0, ',', '.') }} VND</span>
						                            <span class="price-before-discount">{{ number_format($newItem->product_price, 0, ',', '.') }} VND</span>
						                        </div>
						                        <!-- /.product-price -->
						                    </div>
						                    <!-- /.product-info -->
						                    <div class="cart clearfix animate-effect">
			                                    <div class="action">
			                                        <ul class="list-unstyled">
			                                            <li class="add-cart-button btn-group">
			                                                <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Mua" onclick="add_cart({{ $newItem->product_id }});">
			                                                <i class="fa fa-shopping-cart"></i>													
			                                                </button>
			                                                <button class="btn btn-primary cart-btn" type="button" onclick="add_cart({{ $newItem->product_id }});">Mua</button>
			                                            </li>
			                                            <li class="lnk wishlist">
			                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="Yêu thích">
			                                                <i class="icon fa fa-heart"></i>
			                                                </a>
			                                            </li>
			                                            <li class="lnk">
			                                                <a data-toggle="tooltip" class="add-to-cart" href="detail.html" title="So sánh">
			                                                <i class="fa fa-signal" aria-hidden="true"></i>
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
						    <!-- /.home-owl-carousel -->
						</section>
						@endif
						<!-- /.section -->
						<!-- ======= FEATURED PRODUCTS : END ======= -->

					</div><!-- /.homebanner-holder -->
					<!-- ======= CONTENT : END ======= -->

				</div><!-- /.row -->

				<!-- ======= BRANDS CAROUSEL ======= -->
				@include('frontend.layouts.brands')
				<!-- ======= BRANDS CAROUSEL : END ======= -->

			</div><!-- /.container -->
		</div><!-- /#top-banner-and-menu -->

@stop
