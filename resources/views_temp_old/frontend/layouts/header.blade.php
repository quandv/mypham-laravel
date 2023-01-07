<!-- start header -->
    <div class="header_bg">
    <div class="wrap">
        <div class="header">
            <div class="logo">
                <a href="/"><img src="/images/logo.png" alt=""/> </a>
            </div>
            <div class="h_icon">
                <ul class="icon1 sub-icon1">
                    <li><a class="active-icon c1" href="#"><i id="cart-count">@if(isset($count)) {{ $count }} @endif</i></a>
                        <ul class="sub-icon1 list" id="cart-list">
                        @if(isset($count) && $count > 0)
                            @foreach($cart as $cartItem)
                                <li class="cart-item">
                                    @if(isset($cartItem->options['img']))
                                    <img src="/uploads/product/{{ $cartItem->options['img'] }}" alt="{{ $cartItem->name }}">
                                    @endif
                                    <p>{{ $cartItem->name }}</p>
                                    <p class="text-right">
                                        <span class="label label-success">{{ $cartItem->qty }}</span>
                                        <span class="label label-danger cursor" onclick="del_item_cart('{{ $cartItem->rowId }}');">Xóa</span>
                                    </p>
                                </li>
                            @endforeach
                            <li class="text-right">Tổng: <span id="cart-total">@if(isset($subtotal)) {{ $subtotal }} @else 0 @endif</span></li>
                            <li class="text-right"><a href="/dat-hang.html" class="btn btn-primary">Thanh toán</a></li>
                        @else
                            <li><h3>shopping cart empty</h3><a href=""></a></li>
                        @endif
                        </ul>

                    </li>
                </ul>
            </div>
            <div class="h_search">
                <form method="get" action="{{route('frontend.search')}}">
                    <input type="text" name="s">
                    <input type="submit" value="">
                    {!! csrf_field() !!}
                </form>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    </div>
    <div class="header_btm">
    <div class="wrap">
        <div class="header_sub">
            <div class="h_menu">
                <ul>
                    <li class="active"><a href="/">Trang chủ</a></li> |
                    @if($menu)
                        @foreach($menu as $menuItem)
                            <li><a href="/danh-muc/{{ $menuItem->category_id }}/{{$menuItem->category_alias }}.html">{{$menuItem->category_name}}</a></li> |
                        @endforeach
                    @endif
                    <li><a href="/gioi-thieu.html">Giới thiệu</a></li> |
                    <li><a href="/lien-he.html">Liên hệ</a></li>
                </ul>
            </div>
            <div class="top-nav">
                  <nav class="nav">             
                    <a href="#" id="w3-menu-trigger"> </a>
                          <ul class="nav-list" style="">
                                <li class="nav-item"><a class="active" href="index.html">Home</a></li>
                                <li class="nav-item"><a href="sale.html">Sale</a></li>
                                <li class="nav-item"><a href="handbags.html">Handbags</a></li>
                                <li class="nav-item"><a href="accessories.html">Accessories</a></li>
                                <li class="nav-item"><a href="shoes.html">Shoes</a></li>
                                <li class="nav-item"><a href="service.html">Services</a></li>
                                <li class="nav-item"><a href="contact.html">Contact</a></li>
                         </ul>
                   </nav>
                     <div class="search_box">
                    <form>
                       <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}"><input type="submit" value="">
                    </form>
                </div>
                  <div class="clear"> </div>
                  <script src="js/responsive.menu.js"></script>
             </div>       
        <div class="clear"></div>
    </div>
    </div>
    </div>