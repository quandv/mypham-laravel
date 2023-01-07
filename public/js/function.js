$(document).ready(function() {

	$(document).on('change', '.qtyitem', function(){
		let qty = $(this).val();
		let rowId = $(this).attr('data-rid');
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': Laravel.csrfToken
	        }
		});
		$.ajax({
			url : base_url+"/updatecart",
			type: 'post',
			dataType: 'json',
			data: {
				rowId: rowId,
				qty: qty,

			},success: function(results){
				if(results.status){
					alert(results.msg);
					$('.priceitem-'+rowId).text(results.price);
					$('#shopping-count').text(results.count);
					$('#shopping-subtotal').text(results.subTotal);

					refresh_cart();
				}else{
					alert(results.msg);
				}
			}
		})
	});

	$( window ).on('resize', function() {
		if( $(window).width() <= 992 ){
			//cart
			$('.cart-content').hide();
			var count = 0;
			$('.click-toggle').click( function() {
				if( count % 2 == 0 ){
					$('.cart-content').show();
					count++;
				}else{
					$('.cart-content').hide();
					count++;
				}
			});
			//menu
			$('.menu ul').hide();
			//food-item
			$('.food-item div').removeClass('no-padd-right');
		}else{
			//cart
			$('.cart-content').show();	
			//menu
			$('.menu ul').show();
			//food-item
			$('.food-item div').addClass('no-padd-right');
		}

		//------custom css		
		$('.left-bar').css({'min-height': '200px', 'height' : 'auto'});
	});

	if( $(window).width() <= 992 ){
		//cart
		$('.cart-content').hide();
		var count = 0;
		$('.click-toggle').click( function() {
			if( count % 2 == 0 ){
				$('.cart-content').show();
				count++;
			}else{
				$('.cart-content').hide();
				count++;
			}
		});
		//menu
		$('.menu ul').hide();
		//food-item
		$('.food-item div').removeClass('no-padd-right');		
		$('.left-bar').css({'min-height': '200px', 'height' : 'auto'});
	}


	//$('[data-toggle="popover"]').popover();   

// load products by ajax
$('.load-more').on('click', function(){
	$('.load-more').hide();
	$('.loading').removeClass('hide');
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/product",
        type : "post",
        dataType:"json",
        data : {
            'category_id': $('.load-more').attr('data-id'),
            'offset': $('.load-more').attr('data-offset'),
            //"_token": tokenvrf,
        },
        success : function (result){
        	var html = '';
            $.each(result.products, function(i, product) {
			    html += '<div class="food-item row">';
			    html += '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padd-right food-item-img">';
			    html += '<img src="'+base_url+'/uploads/product/'+product.product_image +'" alt="" id="img-'+product.product_id+'">';
			    html += '</div>';
			    html += '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padd-right food-item-content">';
			    html += '<div class="main-content">';
			    html += '<h3>'+ product.product_name +'</h3>';
			    html += '<p>'+ product.product_desc +'</p></div>';			    

			    if( jQuery.inArray( "", product.option_id_group ) != 0 ){
			    	html += '<div class="sub-content sub-content-'+product.product_id+'"><form action="" class="option-form">';
			    	$.each(product.option_id_group, function(key,item){
			    		if( product.option_status_group[key] != 0 ){
			    			html += '<div class="option-item option-item-'+product.product_id+'" data-opid="'+item+'">';
			    			html += '<input type="checkbox" value="'+item+'"> '+product.option_name_group[key]+' ( '+product.option_price_group[key]+' )';
			    			html += '<span class="count-option-'+item+' hide">(<span class="num-'+item+'">0</span>)</span>';
							html += '<button onclick="javascript:add1('+product.product_id+','+item+');" type="button" class="btn btn-default btn-xs add1-option add1-option-'+item+' hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">+1</button>';
							html +=	'<button onclick="javascript:down1('+product.product_id+','+item+');" type="button" class="btn btn-default btn-xs down1-option down1-option-'+item+' hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff;">-1</button>';
							html += '<button onclick="javascript:delAll('+product.product_id+','+item+');" type="button" class="btn btn-default btn-xs cancel-option cancel-option-'+item+' hide" style="background:rgba(0, 0, 0, 0) linear-gradient(#ec0000, #b10000) repeat scroll 0 0; color:#fff; font-weight:bold;">X</button>';
			    			html += '</div>';
			    		}
			    	});
			    	html += '</form></div>';
			    }		
									
			    html += '</div>';
			    html += '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 no-padd-right food-item-price">';
			    if(product.status == 1){
			    	html += '<button type="button" class="btn-enable btn-enable-'+ product.product_id +'" onclick="javascript:add_cart('+ product.product_id +');" class="add-item" data-pid="'+ product.product_id +'">'+ number_format( product.product_price , 0,',', '.') +' | <i class="glyphicon glyphicon-plus"></i> </button>';
			    }else{
			    	html += '<button type="button" class="btn-disable">Hết hàng</button>';
			    }

			    if(result.managerProduct){
		    		html += '<div class="manager-product-edit"><a href="'+base_url+'/admin/product/'+ product.product_id +'/edit"><span class="label label-info"><i class="glyphicon glyphicon-edit"></i> Chỉnh sửa</span></a></div>';
			    }
			    
			    html += '<span class="option-show hide" data-pid="'+ product.product_id +'" >option</span>';
			    html += '</div></div>';
			});
			if( result.products.length < result.limit ){
				$('.load-more').hide();
			}else{
				$('.load-more').show();
				$('.load-more').attr({'data-id': result.category_id, 'data-offset': result.offset});
			}
			
			$('.food-list').append(html);
			$('.loading').addClass('hide');
			
			$('.left-bar').css({'min-height': '200px', 'height' : 'auto'});

			// add option
			$('.option-item input').click(function() {
				var num;
				var opid = $(this).val();
			    if($(this).is(':checked')) {
			    	$('.num-'+opid).text(1);
			        $('.count-option-'+opid).removeClass('hide');
					$('.add1-option-'+opid).removeClass('hide');
					$('.down1-option-'+opid).removeClass('hide');
					$('.cancel-option-'+opid).removeClass('hide');
			    } else {
			        $('.num-'+opid).text(0);
			    	$('.count-option-'+opid).addClass('hide');
					$('.add1-option-'+opid).addClass('hide');
					$('.down1-option-'+opid).addClass('hide');
					$('.cancel-option-'+opid).addClass('hide');
			    }
			});
			// end- add option
			
        }
	});
});

//add option
$('.option-item input').click(function() {
	var num;
	var opid = $(this).val();
    if($(this).is(':checked')) {
    	$('.num-'+opid).text(1);
        $('.count-option-'+opid).removeClass('hide');
		$('.add1-option-'+opid).removeClass('hide');
		$('.down1-option-'+opid).removeClass('hide');
		$('.cancel-option-'+opid).removeClass('hide');		
    } else {
        $('.num-'+opid).text(0);
    	$('.count-option-'+opid).addClass('hide');
		$('.add1-option-'+opid).addClass('hide');
		$('.down1-option-'+opid).addClass('hide');
		$('.cancel-option-'+opid).addClass('hide');
    }
});
//end- add option

}); // End document-ready

$.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
    var token = Laravel.csrfToken; // or _token, whichever you are using
     console.log(token);
     console.log('====================');
    if (token) {
        return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
    }
});

function add1(pid, opid){
	var num = $('.num-'+opid).text();
	$('.num-'+opid).text(parseInt(num)+1);
}

function down1(pid, opid){	
	var num = $('.num-'+opid).text();
	if(num > 1){
		$('.num-'+opid).text(num-1);
	}else{
		$('.num-'+opid).text(1);
	}
}

function delAll(pid, opid){	
	$('.num-'+opid).text(1);
}

function add_cart(pid){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	console.log(tokenvrf);
	$.ajax({
		url : base_url+"/addcart",
        type : "post",
        dataType:"json",
        data : {
            'product_id' : pid
           // "_token": tokenvrf,
        },
        success : function (result){
        	//effect add to cart
		    /*var cart = $('.h-icon');
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

		        imgclone.animate({
		            'width': 0,
		            'height': 0
		        }, function () {
		            $(this).detach()
		        });
		    }*/
			//END-effect add to cart
        	if(result.status){
        		alert('Thêm vào giỏ hàng thành công');
        		refresh_cart();
        	}
        }
	});
}

function refresh_cart(){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/refresh_cart",
        type : "post",
        dataType:"json",
        data : {
           // "_token": tokenvrf,
        },
        success : function (result){
        	console.log(result);
        	if( result ){
        		var html = '', total = 0;
        		$.each(result['content'], function(index, item){
        			html += '<li class="cart-item">';
	        			html += '<img src="/uploads/product/'+ item['options']['img'] +'" alt="">';
	        			html += '<p>'+ item['name'] +' </p>';
	        			html += '<p class="text-right">';
	        			html += '<span class="label label-success">'+ item['qty']+'</span> ';
	        			html += '<span class="label label-danger cursor" onclick="del_item_cart(\''+ item['rowId'] +'\');" >Xóa</span>';
	        			html += '</p>';
        			html += '</li>';

        			total += item['subtotal'];
        		});

        		html += '<li class="text-right">Tổng: <span id="cart-total">'+number_format( total, 0,',', '.')+'</span></li>';
				html += '<li class="text-right"><a href="/dat-hang.html" class="btn btn-primary">Thanh toán</a></li>';

        		$('#cart-list').html(html);
        		$('#cart-count').html(result['count']);
        		
			}
        }
	});
}

function update_cart(rowid, qty){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/updatecart",
        type : "post",
        dataType:"json",
        data : {
            'rowId' : rowid,
            //"_token": tokenvrf,
            'qty'	: qty
        },
        success : function (result){
        	if(result.status){
        		refresh_cart();
        	}
        }
	});
}

function down_cart(rowid, qty){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/downcart",
        type : "post",
        dataType:"json",
        data : {
            'rowId' : rowid,
            //"_token": tokenvrf,
            'qty'	: qty
        },
        success : function (result){
        	if(result.status){
        		refresh_cart();
        	}
        }
	});
}

function del_item_cart(rowid){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/delitem",
        type : "post",
        dataType:"json",
        data : {
            'rowId' : rowid,
            //"_token": tokenvrf,
        },
        success : function (result){
        	if(result.status){
        		refresh_cart();
        	}
        }
	});
}

function del_item_shopping(rowid){
	let confirm_del = confirm('Bạn chắc chắn muốn thực hiện hành động này?');
	if(confirm_del){
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': Laravel.csrfToken
	        }
		});
		$.ajax({
			url : base_url+"/delitem",
	        type : "post",
	        dataType:"json",
	        data : {
	            'rowId' : rowid,
	            //"_token": tokenvrf,
	        },
	        success : function (results){
	        	if(results.status){
					alert(results.msg);
					$('#shopping-count').text(results.count);
					$('#shopping-subtotal').text(results.subTotal);
					$('.shopping-item-'+rowid).remove();
					refresh_cart();
				}else{
					alert(results.msg);
				}
	        }
		});
	}
}

function remove_cart(){
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        }
	});
	$.ajax({
		url : base_url+"/removecart",
        type : "post",
        dataType:"json",
        data : {
        	//"_token": tokenvrf,
        },
        success : function (result){
        	if(result.status){
        		$('.cart-notice-content').val('');
        		refresh_cart();
        	}
        }
	});
}

//libraries
function number_format (number, decimals, decPoint, thousandsSep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	var n = !isFinite(+number) ? 0 : +number
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''

	var toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec)
		return '' + (Math.round(n * k) / k)
		.toFixed(prec)
	}

	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
	}

	return s.join(dec)
}