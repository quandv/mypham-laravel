@extends('frontend.layouts.master2')

@if (isset($title))
	@section('title',$title)
@else
	@section('title','Aditii')
@endif
@section('content')
{{ Html::style(asset('css/productviewgallery.css')) }}
{{ Html::script(asset('js/cloud-zoom.1.0.3.min.js')) }}
{{ Html::script(asset('js/jquery.fancybox.pack.js')) }}
{{ Html::script(asset('js/jquery.fancybox-buttons.js')) }}
{{ Html::script(asset('js/jquery.fancybox-thumbs.js')) }}
{{ Html::script(asset('js/productviewgallery.js')) }}

<!-- start main -->
<div class="main_bg">
<div class="wrap">	
	<div class="main">
	<!-- start content -->
	<div class="single">
			<!-- start span1_of_1 -->
			<div class="left_content">
			<div class="span1_of_1">
				<!-- start product_slider -->
				<div class="product-view">
				    <div class="product-essential">
				        <div class="product-img-box">
				    <div class="more-views" style="float:left;">
				        <div class="more-views-container">
				        <ul>
				        <?php if($details->product_image != ''){ 
				        	$img = json_decode($details->product_image);
				        	$arr = array('prod_1' => array());
				        	$json = '';
				        	foreach($img as $index => $imgItem){
				        		if($index ==0){
				        			$json .= '{"prod_1":{"main":{"orig":"/uploads/product/'. $imgItem .'","main":"/uploads/product/'. $imgItem .'","thumb":"/uploads/product/'. $imgItem .'","label":""},"gallery":{"item_0":{"orig":"/uploads/product/'. $imgItem .'","main":"/uploads/product/'. $imgItem .'","thumb":"/uploads/product/'. $imgItem .'","label":""}';
				        		}else{
				        			$json .= ',"item_'.$index.'":{"orig":"/uploads/product/'. $imgItem .'","main":"/uploads/product/'. $imgItem .'","thumb":"/uploads/product/'. $imgItem .'","label":""}';
				        		}
				        ?>
				            <li>
				            	<a class="cs-fancybox-thumbs" data-fancybox-group="thumb" style="width:64px;height:85px;" href=""  title="" alt="">
				            	<img src="/uploads/product/{{ $imgItem }}" src_main=""  title="" alt="" /></a>            
				            </li>
				        <?php } }
				        	$json .= '},"type":"simple","video":false}}';
				        	//echo $json;die;
				        ?>
				          </ul>
				        </div>
				    </div>
				    <div class="product-image"> 
				        <a class="cs-fancybox-thumbs cloud-zoom" rel="adjustX:30,adjustY:0,position:'right',tint:'#202020',tintOpacity:0.5,smoothMove:2,showTitle:true,titleOpacity:0.5" data-fancybox-group="thumb" href="" title="Women Shorts" alt="Women Shorts">
				           	<img src="" alt="Women Shorts" title="Women Shorts" />
				        </a>
				   </div>
					<script type="text/javascript">
						var prodGallery = jQblvg.parseJSON('<?php echo $json; ?>'),
						    gallery_elmnt = jQblvg('.product-img-box'),
						    galleryObj = new Object(),
						    gallery_conf = new Object();
						    gallery_conf.moreviewitem = '<a class="cs-fancybox-thumbs" data-fancybox-group="thumb" style="width:64px;height:85px;" href=""  title="" alt=""><img src="" src_main="" width="64" height="85" title="" alt="" /></a>';
						    gallery_conf.animspeed = 200;
						jQblvg(document).ready(function() {
						    galleryObj[1] = new prodViewGalleryForm(prodGallery, 'prod_1', gallery_elmnt, gallery_conf, '.product-image', '.more-views', 'http:');
						        jQblvg('.product-image .cs-fancybox-thumbs').absoluteClick();
						    jQblvg('.cs-fancybox-thumbs').fancybox({ prevEffect : 'none', 
						                             nextEffect : 'none',
						                             closeBtn : true,
						                             arrows : true,
						                             nextClick : true, 
						                             helpers: {
						                               thumbs : {
						                                   width: 64,
						                                   height: 85,
						                                   position: 'bottom'
						                               }
						                             }
						                             });
						    jQblvg('#wrap').css('z-index', '100');
						            jQblvg('.more-views-container').elScroll({type: 'vertical', elqty: 4, btn_pos: 'border', scroll_speed: 400 });
						        
						});
						
						function initGallery(a,b,element) {
						    galleryObj[a] = new prodViewGalleryForm(prods, b, gallery_elmnt, gallery_conf, '.product-image', '.more-views', '');
						};

						console.log(prodGallery);
					</script>
				</div>
				</div>
				</div>
				<!-- end product_slider -->
			</div>
			<!-- start span1_of_1 -->
			<div class="span1_of_1_des">
				  <div class="desc1">
					<h3>@if($details->product_name) {{ $details->product_name }} @endif </h3>
					<p>@if($details->product_desc) {{ $details->product_desc }} @endif</p>
					<h5>@if($details->product_price) {{ number_format($details->product_price,0,',','.') }} VND @endif</h5>
					<div class="available">
						<h4>Tùy chọn :</h4>
						<ul>							
							<li>Số lượng:
								<select>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
								</select>
							</li>
						</ul>
						<div class="btn_form">
							<form>
								<input type="submit" value="Mua hàng" title="" />
							</form>
						</div>
						<!-- <span class="span_right"><a href="#">login to save in wishlist </a></span> -->
						<div class="clear"></div>
					</div>
					<div class="share-desc">
						<div class="share">
							<h4>Chia sẻ với bạn bè:</h4>
							<ul class="share_nav">
								<li><a href="#"><img src="/images/facebook.png" title="facebook"></a></li>
								<li><a href="#"><img src="/images/twitter.png" title="Twiiter"></a></li>
								<li><a href="#"><img src="/images/rss.png" title="Rss"></a></li>
								<li><a href="#"><img src="/images/gpluse.png" title="Google+"></a></li>
				    		</ul>
						</div>
						<div class="clear"></div>
					</div>
			   	 </div>
			   	</div>

			   	<div class="clear"></div>
			   	<!-- start tabs -->
				   	<section class="tabs">
		            <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked">
			        <label for="tab-1" class="tab-label-1">Chi tiết sản phẩm</label>
			
		            <!-- <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2">
			        <label for="tab-2" class="tab-label-2">Bình luận</label> -->
			
		            <!-- <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3">
		            <label for="tab-3" class="tab-label-3">semiconductor</label> -->
	          
				    <div class="clear-shadow"></div>
					
			        <div class="content">
				        <div class="content-1">
				        	<?php 
								if($details->product_content){
									echo htmlspecialchars_decode($details->product_content);
								}
							?>
							<div class="clear"></div>
						</div>
				        <div class="content-2 hide">
							<div class="fb-comments" data-href="http://dantri.com" data-numposts="5"></div>
						</div>
				        <div class="content-3 hide">
				        	<p class="para top"><span>LOREM IPSUM</span> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined </p>
							<ul>
								<li>Research</li>
								<li>Design and Development</li>
								<li>Porting and Optimization</li>
								<li>System integration</li>
								<li>Verification, Validation and Testing</li>
								<li>Maintenance and Support</li>
							</ul>
							<div class="clear"></div>
						</div>
			        </div>
			        </section>
		         	<!-- end tabs -->
			   	</div>
			   	<!-- start sidebar -->
			 <div class="left_sidebar">
					<div class="sellers">
						<h4>Best Sellers</h4>
						<div class="single-nav">
			                <ul>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">The standard chunk of Lorem Ipsum</a></li>
			                    <li><a href="#">The standard chunk of Lorem Ipsum</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">The standard chunk of Lorem Ipsum</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">The standard chunk of Lorem Ipsum</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">Always free from repetition</a></li>
			                    <li><a href="#">Always free from repetition</a></li>			                    
			                </ul>
			              </div>
						  <div class="banner-wrap bottom_banner color_link">
								<a href="#" class="main_link">
								<figure><img src="images/delivery.png" alt=""></figure>
								<h5><span>Free Shipping</span><br> on orders over $99.</h5><p>This offer is valid on all our store items.</p></a>
						 </div>
						 <div class="brands">
							 <h1>Brands</h1>
					  		 <div class="field">
				                 <select class="select1">
				                   <option>Please Select</option>
										<option>Lorem ipsum dolor sit amet</option>
										<option>Lorem ipsum dolor sit amet</option>
										<option>Lorem ipsum dolor sit amet</option>
				                  </select>
				            </div>
			    		</div>
					</div>
				</div>
					<!-- end sidebar -->
          	    <div class="clear"></div>
	       </div>	
	<!-- end content -->
	</div>
</div>
</div>	

@stop