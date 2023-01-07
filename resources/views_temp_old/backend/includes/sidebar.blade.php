<!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                     @if(!empty(Auth::user()->avatar))
                        <img class="img-circle" src="{{ asset('uploads/users/'.Auth::user()->avatar) }}" alt="User profile picture" >
                    @else
                        <img src="{{ asset("/images/admin.png") }}" class="img-circle" alt="User Image" />
                    @endif
                    </div>
                    <div class="pull-left info">
                        <p>{!! Auth::user()->name !!}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online </a>
                    </div>
                </div>

                <!-- search form (Optional) -->
                <!-- <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form> -->
                <style type="text/css">
                    ul.sidebar-menu li.active>a>span>.fa-angle-left {
                        -webkit-transform: rotate(-90deg);
                        -ms-transform: rotate(-90deg);
                        -o-transform: rotate(-90deg);
                        transform: rotate(-90deg);
                    }
                </style>
                <!-- /.search form -->

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">
                   <!--  <li class="header"></li> -->
                    <!-- Optionally, you can add icons to the links -->
                    {{-- @role(1) @role('ten_role') --}}
                    @permission('dashboard')
                    <li class="{!! Request::is('admin/dashboard*') ? 'active' : '' !!}"><a href="{!! route('admin.dashboard') !!}"><span><i class="fa fa-home fa-2x"></i> Quản trị</span></a></li>
                    @endauth

                    @if(access()->hasPermission('manager-category') || access()->hasPermission('cap-nhat-het-hang') || access()->hasPermission('manager-option') )
                    <li class="treeview @if( Request::is('admin/category') || Request::is('admin/product*') || Request::is('admin/option*') || Request::is('admin/recipe*') ) active @endif">
                        <a href="#"><span><i class="fa fa-cube fa-2x" aria-hidden="true"></i> Sản phẩm </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-category')
                            <li class="{!! Request::is('admin/category') ? 'active' : '' !!}"><a href="{!! route('admin.category.index') !!}"><span>Danh mục</span></a></li>
                            @endauth
                            
                            @permission('cap-nhat-het-hang')
                            <li class="{!! Request::is('admin/product') ? 'active' : '' !!}"><a href="{!! route('admin.product.index') !!}"><span>Sản phẩm</span></a></li>
                            @endauth

                            @permission('manager-product')
                            <li class="{!! Request::is('admin/product/sort*') ? 'active' : '' !!}"><a href="{!! route('admin.product.sort') !!}"><span>Sắp xếp</span></a></li>
                            @endauth

                            @if( access()->hasPermission('manager-option') || access()->hasPermission('cap-nhat-het-hang'))
                            <li class="{!! Request::is('admin/option*') ? 'active' : '' !!}"><a href="{!! route('admin.option.index') !!}"><span>Option</span></a></li>
                            @endif
                            
                            @permission('manager-recipe')
                            <li class="{!! Request::is('admin/recipe*') ? 'active' : '' !!}"><a href="{!! route('recipe.index')!!}">Công thức món ăn</a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif
                    
                    @if(access()->hasPermission('manager-user') || access()->hasPermission('manager-role'))
                    <li class="treeview @if( Request::is('admin/user*') || Request::is('admin/role*') ) active @endif">
                        <a href="#"><span><i class="fa fa-user fa-2x" aria-hidden="true"></i> Phân quyền </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-user')
                            <li class="{!! Request::is('admin/user*') ? 'active' : '' !!}"><a href="{!! route('admin.user.index') !!}"><span>Tài khoản(User)</span></a></li>
                            @endauth
                            @permission('manager-role')
                            <li class="{!! Request::is('admin/role*') ? 'active' : '' !!}"><a href="{!! route('admin.role.index') !!}"><span>Phân quyền(Role)</span></a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif

                    @if(access()->hasPermission('manager-room') || access()->hasPermission('manager-client'))
                    <li class="treeview @if( Request::is('admin/room*') || Request::is('admin/client*') ) active @endif">
                        <a href="#"><span><i class="fa fa-laptop fa-2x" aria-hidden="true"></i> Phòng máy </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-room')
                            <li class="{!! Request::is('admin/room*') ? 'active' : '' !!}"><a href="{!! route('admin.room.index') !!}"><span>Phòng máy</span></a></li>
                            @endauth
                            @permission('manager-client')
                            <li class="{!! Request::is('admin/client*') ? 'active' : '' !!}"><a href="{!! route('admin.client.index') !!}"><span>Máy trạm</span></a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif
                    
                    @permission('manager-schedule')
                    <li class="{!! Request::is('admin/schedule*') ? 'active' : '' !!}"><a href="{!! route('admin.schedule.index') !!}"><span><i class="fa fa-calendar fa-2x" aria-hidden="true"></i> Quản lý ca</span></a></li>
                    @endauth
                    <li class="treeview {!! Request::is('admin/order*') ? 'active' : '' !!}">

                        <a href="#"><span><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i> Đơn hàng </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/order/listall*') ? 'active' : '' !!}"><a href="{!! route('admin.order.all')!!}"><span>Tất cả</span></a></li>
                            
                            {{--roles([2,3]) @endauth --}}
                            <li class="{!! Request::is('admin/order/listpending*') ? 'active' : '' !!}"><a href="{!! route('admin.order.pending') !!}"><span>Đang xử lý</span></a></li>
                            <li class="{!! Request::is('admin/order/listapproved*') ? 'active' : '' !!}"><a href="{!! route('admin.order.approved') !!}"><span>Đã thu tiền</span></a></li> 
                            <li class="{!! Request::is('admin/order/listdone*') ? 'active' : '' !!}"><a href="{!! route('admin.order.done') !!}"><span>Đã hoàn thành</span></a></li> 
                            <li class="{!! Request::is('admin/order/listdestroy*') ? 'active' : '' !!}"><a href="{!! route('admin.order.destroy') !!}"><span>Đã hủy </span></a></li>

                        </ul>
                    </li>

                    {{-- @role(1) --}}
                    @permission('manager-history')
                    <li class="treeview {!! Request::is('admin/history*') ? 'active' : '' !!}">

                        <a href="#"><span><i class="fa fa-history fa-2x" aria-hidden="true"></i> Lịch sử</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/history/list*') ? 'active' : '' !!}"><a href="{!! route('admin.history.list')!!}">Xử lý đơn hàng</a></li>
                            <li class="{!! Request::is('admin/history/reporthistory*') ? 'active' : '' !!}"><a href="{!! route('admin.history.report')!!}">Thời gian xử lý</a></li>
                            <li class="{!! Request::is('admin/history/addorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.addinput')!!}">Thêm hóa đơn nhập</a></li>
                            <li class="{!! Request::is('admin/history/editorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.editinput')!!}">Cập nhật hóa đơn nhập</a></li>
                            <li class="{!! Request::is('admin/history/statusproduct*') ? 'active' : '' !!}"><a href="{!! route('admin.history.statusproduct')!!}">Cập nhật trạng thái sản phẩm</a></li> 
                            <li class="{!! Request::is('admin/history/product*') ? 'active' : '' !!}"><a href="{!! route('admin.history.product')!!}">Sản phẩm</a></li>
                            <!-- <li><a href="#">Link in level 2</a></li> -->
                        </ul>
                    </li>                    
                    @endauth
                    
                    @permission('manager-report')
                    <li class="treeview {!! Request::is('admin/statistic*') ? 'active' : '' !!}">
                        <a href="#"><span><i class="fa fa-bookmark fa-2x" aria-hidden="true"></i> Báo cáo </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/statistic/statisticcategory*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.category') !!}">Sản phẩm bán chạy</a></li>
                            <li class="{!! Request::is('admin/statistic/day*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.day') !!}">Báo cáo ngày</a></li>
                            <li class="{!! Request::is('admin/statistic/month*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.month') !!}">Báo cáo tháng</a></li>
                            <li class="{!! Request::is('admin/statistic/year*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.year') !!}">Báo cáo năm</a></li>
                        </ul>
                    </li>
                    @endauth

                    {{-- @permissions(['view-backend', 'view-some-content'])--}}
                    @permission('manager-report')
                    <!-- <li class="treeview {!! Request::is('admin/report*') ? 'active' : '' !!}">
                        <a href="#"><span>Thống kê</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/report/reportcategory*') ? 'active' : '' !!}"><a href="{!! route('admin.report.category') !!}">Thống kê sản phẩm bán chạy</a></li>
                            <li class="{!! Request::is('admin/report/day*') ? 'active' : '' !!}"><a href="{!! route('admin.report.day') !!}">Thống kê ngày</a></li>
                            <li class="{!! Request::is('admin/report/month*') ? 'active' : '' !!}"><a href="{!! route('admin.report.month') !!}">Thống kê tháng</a></li>
                            <li class="{!! Request::is('admin/report/year*') ? 'active' : '' !!}"><a href="{!! route('admin.report.year') !!}">Thống kê năm</a></li>
                        </ul>
                    </li> -->
                    @endauth

                    @permission('manager-stock')
                    <li class="treeview @if( Request::is('admin/category_stock*') || Request::is('admin/stock*') || Request::is('admin/bill*') || Request::is('admin/unit*') ) active @endif">
                        <a href="#"><span><i class="fa fa-hdd-o fa-2x" aria-hidden="true"></i> Kho hàng </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/unit*') ? 'active' : '' !!}"><a href="{!! route('unit.index')!!}">Đơn vị hàng nhập</a></li>
                            <li class="{!! Request::is('admin/category_stock*') ? 'active' : '' !!}"><a href="{!! route('category_stock.index')!!}">Loại hàng nhập</a></li>
                            <li class="{!! Request::is('admin/stock*') ? 'active' : '' !!}"><a href="{!! route('stock.index')!!}">Sản phẩm nhập</a></li>
                            <li class="@if( Request::is('admin/bill') || Request::is('admin/bill/search') ) active @endif"><a href="{!! route('bill.index')!!}">Hóa đơn nhập</a></li>
                            <li class="{!! Request::is('admin/bill/statistic/month*') ? 'active' : '' !!}"><a href="{!! route('admin.bill.statisticMonth')!!}">Thống kê theo tháng</a></li>
                            <li class="{!! Request::is('admin/bill/statistic/year*') ? 'active' : '' !!}"><a href="{!! route('admin.bill.statisticYear')!!}">Thống kê theo năm</a></li>
                        </ul>

                    </li>
                    @endauth
                    @role(1)
                    <li class="treeview {!! Request::is('admin/setting*') ? 'active' : '' !!}">
                        <a href="{!! route('admin.get.setting') !!}"><span><i class="fa fa-cog fa-2x" aria-hidden="true"></i> Thiết lập </span></a>
                    </li>
                    @endauth
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>