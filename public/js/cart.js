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
        		console.log(result);
        		$.each(result['content'], function(index, item){
        			// html += '<li class="cart-item">';
	        		// 	html += '<img src="/uploads/product/'+ item['options']['img'] +'" alt="">';
	        		// 	html += '<p>'+ item['name'] +' </p>';
	        		// 	html += '<p>';
	        		// 	html += '<span>'+ item['qty']+'</span>';
	        		// 	html += '<span onclick="del_item_cart(\''+ item['rowId'] +'\');" >Xóa</span>';
	        		// 	html += '</p>';
        			// html += '</li>';
        			total += item['subtotal'];

        			html += '<div class="cart-item product-summary">';
                        html += '<div class="row">';
                            html += '<div class="col-xs-4">';
                                html += '<div class="image">';
                                    html += '<a href="detail.html"><img src="/uploads/product/'+ item['options']['img'] +'" alt=""></a>';
                                html += '</div>';
                            html += '</div>';
                            html += '<div class="col-xs-7">';
                                html += '<h3 class="name"><a href="index.php?page-detail">'+ item['name'] +'</a></h3>';
                                html += '<div class="price">'+number_format(item['price'], 0,',', '.')+' X '+item['qty']+'</div>';
                            html += '</div>';
                            html += '<div class="col-xs-1 action">';
                                html += '<a href="javascript:del_item_cart(\''+ item['rowId'] +'\');"><i class="fa fa-trash"></i></a>';
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';

        		});

        		$('#cart-list').html(html);
        		$('.cart-sum').html(number_format( total, 0,',', '.')+'<sup>đ</sup>');
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
        		window.location.reload();
                //refresh_cart();
        	}else{
                alert(result.msg);
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
                window.location.reload();
                //refresh_cart();
            }else{
                alert(result.msg);
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

// SUPPORT FUNCTIONS
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