<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 cart no-padding">
    <div id="into-cart" class="col-xs-12 col-sm-4 col-md-4 col-lg-2 no-padding">
        @if(isset($cart))
        @if(isset($count))
            <div class="cart-icon cart-count click-toggle">
                <span>{{$count}}</span>
            </div>
        @endif
        <form action="">
        <div class="cart-content">
            
            <div class="cart-list">
                @foreach($cart as $cartItem)
                <div class="cart-list row">
                    <div class="col-xs-3 col-sm-3 no-padd-right">{{ $cartItem->name }}</div>
                    <div class="col-xs-4 col-sm-4 no-padd-right"><span class="down2" onclick="javascript:down_cart_employee('{{ $cartItem->rowId }}', {{ $cartItem->qty }});"  data-rowid="{{ $cartItem->rowId }}" data-qty="{{ $cartItem->qty }}">-</span> {{ $cartItem->qty }} <span class="up2" onclick="javascript:update_cart_employee('{{ $cartItem->rowId }}', {{ $cartItem->qty }});" data-rowid="{{ $cartItem->rowId }}" data-qty="{{ $cartItem->qty }}">+</span></div>
                    <div class="col-xs-3 col-sm-3 no-padd-right price-color"> {{ number_format($cartItem->price*$cartItem->qty, 0, ',', '.') }}<sup>đ</sup> </div>
                    <div class="col-xs-2 col-sm-2 no-padd-right"><span class="cancel" onclick="javascript:del_item_cart_employee('{{ $cartItem->rowId }}');" data-rowid="{{ $cartItem->rowId }}">x</span></div>
                </div>
                @endforeach
            </div>
            
            @if(isset($subtotal))
            <div class="cart-total row">
                <div class="col-xs-8 col-sm-8">Tổng</div>
                <div class="col-xs-4 col-sm-4 price-color price-total">{{$subtotal}}<sup>đ</sup></div>
            </div>
            @endif

            <div class="cart-notice row">
                <div class="col-xs-12 col-sm-12">
                    <textarea name="" id="order_notice" class="cart-notice-content" placeholder="Ghi chú"></textarea>
                </div>
            </div>

            @if(!empty($dataClient))
            <div class="row">
                <style>
                    span.select2 { width: 100% !important; }
                </style> 
            </div>            
            @endif

            <div class="cart-button row">
                <div class="col-xs-6 col-sm-6">                    
                </div>
                <div class="col-xs-6 col-sm-6 btn-ok">
                    <button type="button" class="pay" data-toggle="modal" data-target="#modal_order_details">Xác nhận</button>
                </div>
            </div>
        </div>
        </form>
        <style type="text/css">
        .customer-order-success{
            font-size: 20px;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
   
        </style>
        <div class="row hide hidden-xs" id="new-order">
            <div class="col-xs-12 text-center">
               <p class="customer-order-success">{!! Config::get('vgmconfig.order_notification'); !!}</p>
               <!--  <img src="{{--asset('images/icon/neworder.gif')--}}" alt=""> -->
            </div>
        </div>
    </div>
</div><!-- end .cart -->

<!-- modal order-detail -->
<div class="modal" id="modal_order_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Chi tiết đơn hàng</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Tên</td>
                            <td class="text-center">Số lượng</td>
                            <td class="text-center">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody class="table-cart-list">
                        @foreach($cart as $cartItem)
                            <tr>
                                <td>{{ $cartItem->name }}</td>
                                <td class="text-center">{{ $cartItem->qty }}</td>
                                <td class="text-center">{{ number_format($cartItem->price*$cartItem->qty, 0, ',', '.') }}</td>
                            </tr>
                            <?php $options = json_decode($cartItem->options); ?> 
                            @if(!empty($options))
                            <tr>                                                                
                                <td colspan="3" class="option-css">
                                    <span class="option-add">Thêm: </span> 
                                    @foreach( $options as $k => $optionItem )
                                        <?php $optionItem2 = explode(',', $optionItem); ?>
                                        {{ $optionItem2['1'].'('.$optionItem2['3'].'), ' }}
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                @if(isset($subtotal))
                <div class="cart-total row">
                    <div class="col-xs-8 col-sm-8">Tổng</div>
                    <div class="col-xs-4 col-sm-4 price-color price-total text-center">{{$subtotal}}<sup>đ</sup></div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancel-order" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="javascript:insert_order_employee($('#order_notice').val());" >Đồng ý</button>
            </div>
        </div>
    </div>
</div>

@endif