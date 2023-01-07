<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/icon/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css')}}" />
    <link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script>
       console.log(Laravel.csrfToken);
        var base_url = "{{url('/')}}";
        var tokenvrf = "{{ csrf_token() }}";
        var config_pstatus = "{{ Config::get('vgmconfig.pstatus') }}";
    </script>
   
</head>
<body>  
    <header></header>
    
    <div id="main">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    
                    @include('frontend.layouts.leftbar')

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7 content">
                        <div class="title">
							<h1>
								@if (isset($title))
									{{$title}}
								@else
									menu
								@endif
							</h1>
						</div>
						<div class="menu-child">
							<ul class="nav nav-tabs no-padding" role="tablist">
								@if(isset($childs))
									@foreach ($childs as $child)
										<li>
											@if( $category_id == $child->category_id)
												<a class="category-active" href="{{ asset('category/'.$child->category_alias.'/'.$child->category_id) }}">{{ $child->category_name }} /</a>
											@else
												<a href="{{ asset('category/'.$child->category_alias.'/'.$child->category_id) }}">{{ $child->category_name }} /</a>
											@endif
										</li>
									@endforeach
								@endif
							</ul>
						</div>

						<div class="tab-content">
							<div class="food-list">
								@foreach( $products as $product )
								<div class="food-item row">
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">
										<img id="img-{{ $product->product_id }}" src="{{ asset('uploads/product/'.$product->product_image) }}" alt="">
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">
										<div class="main-content">
											<h3>{{ $product->product_name }}</h3>
											<p>{{ $product->product_desc }}</p>
										</div>
										
										@if(!in_array('',$product->option_id_group))
										<div class="sub-content sub-content-{{ $product->product_id }}">
											<form action="" class="option-form">				
												@foreach($product->option_id_group as $k => $v)
													@if($v > 0 && $product->option_status_group[$k] != 0)
														<div class="option-item option-item-{{ $product->product_id }}" data-opid="{{$v}}">
															<input class="option-input" type="checkbox" value="{{$v}}"> {{ $product->option_name_group[$k] }} ( {{ $product->option_price_group[$k] }} )
															<span class="count-option-{{$v}} hide">(<span class="num-{{$v}}">0</span>)</span>
															<button onclick="javascript:add1({{ $product->product_id }},{{ $v }});"  type="button" class="btn btn-default btn-xs add1-option add1-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">+1</button>
															<button onclick="javascript:down1({{ $product->product_id }},{{ $v }});" type="button" class="btn btn-default btn-xs down1-option down1-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">-1</button>
															<button onclick="javascript:delAll({{ $product->product_id }},{{ $v }});" type="button" class="btn btn-default btn-xs cancel-option cancel-option-{{$v}} hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff; font-weight:bold;">X</button>
														</div>
													@endif
												@endforeach	
											</form>	
										</div>
										@endif
									</div>
									<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">
										@if($product->status == 1)
											<button type="button" class="btn-enable btn-enable-{{ $product->product_id }}" onclick="javascript:add_cart_employee({{ $product->product_id }});"> {{ number_format($product->product_price, 0,',', '.') }} | <i class="glyphicon glyphicon-plus"></i> </button>
										@else
											<button type="button" class="btn-disable">Hết hàng</button>
										@endif
										@permission('manager-product')
											<div class="manager-product-edit"><a href="<?php echo URL::to('/').'/admin/product/'.$product->product_id.'/edit'; ?>"><span class="label label-info"><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a></div>
										@endauth

									</div>
								</div> <!-- end .food-item -->
								@endforeach

							</div><!-- end .food-list -->
							@if( count($products) == 4 )
								@if(isset($offset) && isset($limit))
									<div class="load-more text-center" data-id="{{$category_id}}" data-offset="{{$offset}}"><img src="{{ asset('images/icon/loadmore.png') }}" alt=""></div>
									<div class="loading text-center hide"><img src="{{ asset('images/icon/loading.gif') }}" alt=""></div>
								@else
									<div class="load-more text-center" data-id="{{$category_id}}" data-offset="{{$limit}}"><img src="{{ asset('images/icon/loadmore.png') }}" alt=""></span></div>
									<div class="loading text-center hide"><img src="{{ asset('images/icon/loading.gif') }}" alt=""></div>
									
								@endif	
							@endif	
						</div>
                    </div><!-- end .content -->

                    @include('frontend.layouts.cart_employee')
                    
                    
                </div>
            </div>
        </div>  
    </div>

    <footer>
    </footer>

	<!-- MODULE CHAT -->
  @include('chat.module')

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{!! asset('js/sweetalert2.min.js') !!}" ></script>
    <script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/function.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/libs.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script>
    <script type="text/javascript">
      var room_url = "{{route('api.redis.room')}}";
      var private_url = "{{route('api.redis.private')}}";
      var user_url = "{{ route('api.user.online') }}";
      var url_images = "{{asset('public/images')}}";
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      });
    </script>
    <script src="{!! asset('js/chat.js') !!}" type="text/javascript"></script>
    
    <script type="text/javascript">
    	function add_cart_employee(pid){
			var option = Array();
			$('.option-item-'+pid).each( function(){
				if( $(this).children('input').is(':checked') ){
					var opid = $(this).attr('data-opid');
					var num = $('.num-'+opid).text();
					option[opid] = parseInt(num);
					//option.push($(this).attr('data-opid'));
				}
			});
			
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			console.log(tokenvrf);
			$.ajax({
				url : base_url+"/add_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		            'product_id' : pid,
		            'option' : option,
		           // "_token": tokenvrf,
		        },
		        success : function (result){
		        	//effect add to cart
				    var cart = $('.cart-icon');
				    var imgtodrag = $('#img-'+pid);
				    console.log(imgtodrag);
				    if (imgtodrag) {
				        var imgclone = imgtodrag.clone()
				        .offset({
				            top: imgtodrag.offset().top,
				            left: imgtodrag.offset().left
				        })
				        .css({
				            'opacity': '0.5',
				            'position': 'absolute',
				            'height': '150px',
				            'width': '150px',
				            'z-index': '100'
				        })
				        .appendTo($('body'))
				        .animate({
				            'top': cart.offset().top + 10,
				            'left': cart.offset().left + 10,
				            'width': 75,
				            'height': 75
				        }, 1000, 'swing');
				        
				        /*setTimeout(function () {
				            cart.effect("shake", {
				                times: 2
				            }, 200);
				        }, 1500);*/

				        imgclone.animate({
				            'width': 0,
				            'height': 0
				        }, function () {
				            $(this).detach()
				        });
				    }
					//END-effect add to cart
		        	if(result.status){
		        		refresh_cart_employee();
		        	}
		        }
			});
		}

		function refresh_cart_employee(){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			$.ajax({
				url : base_url+"/refresh_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		           // "_token": tokenvrf,
		        },
		        success : function (result){
		        	console.log(result);
		        	if( result ){
		        		var html = '';
		        		var table = '';
		        		var total = 0;
		        		$.each(result['content'], function(index, item){
		        			html += '<div class="cart-list row">';
		        			html += '<div class="col-xs-3 col-sm-3 no-padd-right">'+item['name']+'</div>';
		        			html += '<div class="col-xs-4 col-sm-4 no-padd-right"><span class="down2" onclick="javascript:down_cart_employee(\''+item["rowId"]+'\', '+item["qty"]+');" >-</span> '+item['qty']+' <span class="up2" onclick="javascript:update_cart_employee(\''+item["rowId"]+'\', '+item["qty"]+');" data-rowid="'+item['rowId']+'" data-qty="'+item['qty']+'" >+</span></div>';
		        			html += '<div class="col-xs-3 col-sm-3 no-padd-right price-color">'+number_format( item['price']*item['qty'], 0,',', '.')+'<sup>đ</sup></div>';
		        			html += '<div class="col-xs-2 col-sm-2 no-padd-right"><span class="cancel" onclick="javascript:del_item_cart_employee(\''+item["rowId"]+'\');" data-rowid="'+item['rowId']+'">x</span></div>';
		        			html += '</div>';

		        			total += item['subtotal'];

		        			table += '<tr>';
		        				table += '<td>'+item['name']+'</td>';
		        				table += '<td class="text-center">'+item['qty']+'</td>';
		        				table += '<td class="text-center">'+number_format( item['price']*item['qty'], 0,',', '.')+'</td>';
		        			table += '</tr>';

		    				if(item['options'].length > 0){
			        			table += '<tr>';        			
			        				table += '<td colspan="3" class="option-css">';
			        				table += '<span class="option-add">Thêm: </span>';
			        				$.each(item['options'], function(index, item){
			        					var res = item.split(',');
			    						table += res['1']+'('+res[3]+')'+', ';
			        				});
			        				
			        				table += '</td>';        			
			        			table += '</tr>';
			        		}
		        		});

		        		$('.cart-list').html(html);
		        		$('.table-cart-list').html(table);
		        		$('.price-total').html(number_format( total, 0,',', '.')+'<sup>đ</sup>');
		        		$('.cart-count').html('<span>'+result['count']+'</span>');        		
					}
		        }
			});
		}

		function update_cart_employee(rowid, qty){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			$.ajax({
				url : base_url+"/update_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		            'rowId' : rowid,
		            //"_token": tokenvrf,
		            'qty'	: qty
		        },
		        success : function (result){
		        	if(result.status){
		        		refresh_cart_employee();
		        	}
		        }
			});
		}

		function down_cart_employee(rowid, qty){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			$.ajax({
				url : base_url+"/down_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		            'rowId' : rowid,
		            //"_token": tokenvrf,
		            'qty'	: qty
		        },
		        success : function (result){
		        	if(result.status){
		        		refresh_cart_employee();
		        	}
		        }
			});
		}

		function del_item_cart_employee(rowid){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			$.ajax({
				url : base_url+"/del_item_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		            'rowId' : rowid,
		            //"_token": tokenvrf,
		        },
		        success : function (result){
		        	if(result.status){
		        		refresh_cart_employee();
		        	}
		        }
			});
		}

		function remove_cart_employee(){
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': Laravel.csrfToken
		        }
			});
			$.ajax({
				url : base_url+"/remove_cart_employee",
		        type : "post",
		        dataType:"json",
		        data : {
		        	//"_token": tokenvrf,
		        },
		        success : function (result){
		        	if(result.status){
		        		$('.cart-notice-content').val('');
		        		refresh_cart_employee();
		        	}
		        }
			});
		}

		function insert_order_employee(notice){
			$('#modal_order_details').css({'display':'none'});
			$('.cancel-order').trigger('click');
			window.RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;   //compatibility for firefox and chrome
		    var pc = new RTCPeerConnection({iceServers:[]}), noop = function(){};
		    pc.createDataChannel("");    //create a bogus data channel
		    pc.createOffer(pc.setLocalDescription.bind(pc), noop);    // create offer and set local description
		    pc.onicecandidate = function(ice){  //listen for candidate events
		        if(!ice || !ice.candidate || !ice.candidate.candidate)  return;
		        var myIP = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec(ice.candidate.candidate)[1];
		        console.log('my IP: ', myIP);   
		        pc.onicecandidate = noop;
		        //my code
				$.ajaxSetup({
			        headers: {
			            'X-CSRF-TOKEN': Laravel.csrfToken
			        }
				});
				$.ajax({
					url : base_url+"/insert_order_employee",
			        type : "post",
			        dataType:"json",
			        data : {
			            'client_ip' : myIP,
			            'notice'	: notice,
			            'config_pstatus': config_pstatus
			            //"_token": tokenvrf,
			        },
			        success : function (result){
			        	if(result.status == 1){	        		
			        		remove_cart_employee();
			        		$('#new-order').removeClass('hide');
			        		if( $(window).width() <= 992 ){
				        		$('.cart form').addClass('hide');
				        	}
				        	if(result['pstatus'] == 1){
				        		console.log(result['option_over']);
				        		if(result['product_over'] && result['product_over'].length > 0){
				        			$.each(result['product_over'], function(index,value){
					        			$('.btn-enable-'+value).removeAttr('onclick').removeClass('btn-enable').addClass('btn-disable').text('Hết hàng');
					        		});
				        		}
				        		if(result['option_over'] && result['option_over'].length > 0){
				        			$.each(result['option_over'], function(index2,value2){
				        				$('.option-item[data-opid='+value2+']').addClass('hide');
					        		});	
				        		}
				        	}

			        	}else if(result.status == 2){
			        		alert('IP này không được hỗ trợ . Vui lòng liên hệ quản trị viên!');
			        	}else if(result.status == 3){
			        		alert('Sản phẩm này tạm hết. Vui lòng lựa chọn sản phẩm khác.');
		                }else if(result.status == 4){
		                  	alert('Bạn không có quyền thực hiện tác vụ này.');
		                }else{
			        		alert('Giỏ hàng của bạn đang trống. Vui lòng lựa chọn sản phẩm.');
			        	}	        	
			        }
				});
			};
		}

    </script>
</body>
</html>