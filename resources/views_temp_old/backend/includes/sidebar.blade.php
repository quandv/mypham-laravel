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
                    <li class="{!! Request::is('admin/dashboard*') ? 'active' : '' !!}"><a href="{!! route('admin.dashboard') !!}"><span><i class="fa fa-home fa-2x"></i> Qu???n tr???</span></a></li>
                    @endauth

                    @if(access()->hasPermission('manager-category') || access()->hasPermission('cap-nhat-het-hang') || access()->hasPermission('manager-option') )
                    <li class="treeview @if( Request::is('admin/category') || Request::is('admin/product*') || Request::is('admin/option*') || Request::is('admin/recipe*') ) active @endif">
                        <a href="#"><span><i class="fa fa-cube fa-2x" aria-hidden="true"></i> S???n ph???m </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-category')
                            <li class="{!! Request::is('admin/category') ? 'active' : '' !!}"><a href="{!! route('admin.category.index') !!}"><span>Danh m???c</span></a></li>
                            @endauth
                            
                            @permission('cap-nhat-het-hang')
                            <li class="{!! Request::is('admin/product') ? 'active' : '' !!}"><a href="{!! route('admin.product.index') !!}"><span>S???n ph???m</span></a></li>
                            @endauth

                            @permission('manager-product')
                            <li class="{!! Request::is('admin/product/sort*') ? 'active' : '' !!}"><a href="{!! route('admin.product.sort') !!}"><span>S???p x???p</span></a></li>
                            @endauth

                            @if( access()->hasPermission('manager-option') || access()->hasPermission('cap-nhat-het-hang'))
                            <li class="{!! Request::is('admin/option*') ? 'active' : '' !!}"><a href="{!! route('admin.option.index') !!}"><span>Option</span></a></li>
                            @endif
                            
                            @permission('manager-recipe')
                            <li class="{!! Request::is('admin/recipe*') ? 'active' : '' !!}"><a href="{!! route('recipe.index')!!}">C??ng th???c m??n ??n</a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif
                    
                    @if(access()->hasPermission('manager-user') || access()->hasPermission('manager-role'))
                    <li class="treeview @if( Request::is('admin/user*') || Request::is('admin/role*') ) active @endif">
                        <a href="#"><span><i class="fa fa-user fa-2x" aria-hidden="true"></i> Ph??n quy???n </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-user')
                            <li class="{!! Request::is('admin/user*') ? 'active' : '' !!}"><a href="{!! route('admin.user.index') !!}"><span>T??i kho???n(User)</span></a></li>
                            @endauth
                            @permission('manager-role')
                            <li class="{!! Request::is('admin/role*') ? 'active' : '' !!}"><a href="{!! route('admin.role.index') !!}"><span>Ph??n quy???n(Role)</span></a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif

                    @if(access()->hasPermission('manager-room') || access()->hasPermission('manager-client'))
                    <li class="treeview @if( Request::is('admin/room*') || Request::is('admin/client*') ) active @endif">
                        <a href="#"><span><i class="fa fa-laptop fa-2x" aria-hidden="true"></i> Ph??ng m??y </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @permission('manager-room')
                            <li class="{!! Request::is('admin/room*') ? 'active' : '' !!}"><a href="{!! route('admin.room.index') !!}"><span>Ph??ng m??y</span></a></li>
                            @endauth
                            @permission('manager-client')
                            <li class="{!! Request::is('admin/client*') ? 'active' : '' !!}"><a href="{!! route('admin.client.index') !!}"><span>M??y tr???m</span></a></li>
                            @endauth
                        </ul>
                    </li>
                    @endif
                    
                    @permission('manager-schedule')
                    <li class="{!! Request::is('admin/schedule*') ? 'active' : '' !!}"><a href="{!! route('admin.schedule.index') !!}"><span><i class="fa fa-calendar fa-2x" aria-hidden="true"></i> Qu???n l?? ca</span></a></li>
                    @endauth
                    <li class="treeview {!! Request::is('admin/order*') ? 'active' : '' !!}">

                        <a href="#"><span><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i> ????n h??ng </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/order/listall*') ? 'active' : '' !!}"><a href="{!! route('admin.order.all')!!}"><span>T???t c???</span></a></li>
                            
                            {{--roles([2,3]) @endauth --}}
                            <li class="{!! Request::is('admin/order/listpending*') ? 'active' : '' !!}"><a href="{!! route('admin.order.pending') !!}"><span>??ang x??? l??</span></a></li>
                            <li class="{!! Request::is('admin/order/listapproved*') ? 'active' : '' !!}"><a href="{!! route('admin.order.approved') !!}"><span>???? thu ti???n</span></a></li> 
                            <li class="{!! Request::is('admin/order/listdone*') ? 'active' : '' !!}"><a href="{!! route('admin.order.done') !!}"><span>???? ho??n th??nh</span></a></li> 
                            <li class="{!! Request::is('admin/order/listdestroy*') ? 'active' : '' !!}"><a href="{!! route('admin.order.destroy') !!}"><span>???? h???y </span></a></li>

                        </ul>
                    </li>

                    {{-- @role(1) --}}
                    @permission('manager-history')
                    <li class="treeview {!! Request::is('admin/history*') ? 'active' : '' !!}">

                        <a href="#"><span><i class="fa fa-history fa-2x" aria-hidden="true"></i> L???ch s???</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/history/list*') ? 'active' : '' !!}"><a href="{!! route('admin.history.list')!!}">X??? l?? ????n h??ng</a></li>
                            <li class="{!! Request::is('admin/history/reporthistory*') ? 'active' : '' !!}"><a href="{!! route('admin.history.report')!!}">Th???i gian x??? l??</a></li>
                            <li class="{!! Request::is('admin/history/addorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.addinput')!!}">Th??m h??a ????n nh???p</a></li>
                            <li class="{!! Request::is('admin/history/editorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.editinput')!!}">C???p nh???t h??a ????n nh???p</a></li>
                            <li class="{!! Request::is('admin/history/statusproduct*') ? 'active' : '' !!}"><a href="{!! route('admin.history.statusproduct')!!}">C???p nh???t tr???ng th??i s???n ph???m</a></li> 
                            <li class="{!! Request::is('admin/history/product*') ? 'active' : '' !!}"><a href="{!! route('admin.history.product')!!}">S???n ph???m</a></li>
                            <!-- <li><a href="#">Link in level 2</a></li> -->
                        </ul>
                    </li>                    
                    @endauth
                    
                    @permission('manager-report')
                    <li class="treeview {!! Request::is('admin/statistic*') ? 'active' : '' !!}">
                        <a href="#"><span><i class="fa fa-bookmark fa-2x" aria-hidden="true"></i> B??o c??o </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/statistic/statisticcategory*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.category') !!}">S???n ph???m b??n ch???y</a></li>
                            <li class="{!! Request::is('admin/statistic/day*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.day') !!}">B??o c??o ng??y</a></li>
                            <li class="{!! Request::is('admin/statistic/month*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.month') !!}">B??o c??o th??ng</a></li>
                            <li class="{!! Request::is('admin/statistic/year*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.year') !!}">B??o c??o n??m</a></li>
                        </ul>
                    </li>
                    @endauth

                    {{-- @permissions(['view-backend', 'view-some-content'])--}}
                    @permission('manager-report')
                    <!-- <li class="treeview {!! Request::is('admin/report*') ? 'active' : '' !!}">
                        <a href="#"><span>Th???ng k??</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/report/reportcategory*') ? 'active' : '' !!}"><a href="{!! route('admin.report.category') !!}">Th???ng k?? s???n ph???m b??n ch???y</a></li>
                            <li class="{!! Request::is('admin/report/day*') ? 'active' : '' !!}"><a href="{!! route('admin.report.day') !!}">Th???ng k?? ng??y</a></li>
                            <li class="{!! Request::is('admin/report/month*') ? 'active' : '' !!}"><a href="{!! route('admin.report.month') !!}">Th???ng k?? th??ng</a></li>
                            <li class="{!! Request::is('admin/report/year*') ? 'active' : '' !!}"><a href="{!! route('admin.report.year') !!}">Th???ng k?? n??m</a></li>
                        </ul>
                    </li> -->
                    @endauth

                    @permission('manager-stock')
                    <li class="treeview @if( Request::is('admin/category_stock*') || Request::is('admin/stock*') || Request::is('admin/bill*') || Request::is('admin/unit*') ) active @endif">
                        <a href="#"><span><i class="fa fa-hdd-o fa-2x" aria-hidden="true"></i> Kho h??ng </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></i></a>
                        <ul class="treeview-menu">
                            <li class="{!! Request::is('admin/unit*') ? 'active' : '' !!}"><a href="{!! route('unit.index')!!}">????n v??? h??ng nh???p</a></li>
                            <li class="{!! Request::is('admin/category_stock*') ? 'active' : '' !!}"><a href="{!! route('category_stock.index')!!}">Lo???i h??ng nh???p</a></li>
                            <li class="{!! Request::is('admin/stock*') ? 'active' : '' !!}"><a href="{!! route('stock.index')!!}">S???n ph???m nh???p</a></li>
                            <li class="@if( Request::is('admin/bill') || Request::is('admin/bill/search') ) active @endif"><a href="{!! route('bill.index')!!}">H??a ????n nh???p</a></li>
                            <li class="{!! Request::is('admin/bill/statistic/month*') ? 'active' : '' !!}"><a href="{!! route('admin.bill.statisticMonth')!!}">Th???ng k?? theo th??ng</a></li>
                            <li class="{!! Request::is('admin/bill/statistic/year*') ? 'active' : '' !!}"><a href="{!! route('admin.bill.statisticYear')!!}">Th???ng k?? theo n??m</a></li>
                        </ul>

                    </li>
                    @endauth
                    @role(1)
                    <li class="treeview {!! Request::is('admin/setting*') ? 'active' : '' !!}">
                        <a href="{!! route('admin.get.setting') !!}"><span><i class="fa fa-cog fa-2x" aria-hidden="true"></i> Thi???t l???p </span></a>
                    </li>
                    @endauth
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>