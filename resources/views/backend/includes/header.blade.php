<!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <!-- <a href="" class="logo"><b>Gengar</b>Gaming</a> -->

            <a href="{!!url('/')!!}" class="logo text-center"><!-- <img src="{{ asset('/images/logo-push.png') }}" alt="" style="width:30px;max-height:30px;"> --><img src="{{ asset('/images/logo-dashboard.png') }}" alt="" style="width:100%;"></a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="float:left;">
                    <span class="sr-only">Gengar Gaming</span>
                </a>
                <div class="nav nav-custom" style="float:left;">
                    <nav class="">
                        <div class="container-fluid">
                            <!-- <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div> -->
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus-square" style="font-size:18px;"></i> Menu <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            @permission('dashboard')
                                            <li class="dropdown">
                                                <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home" style="font-size:18px;"></i> Qu???n tr???</a>
                                            </li>
                                            @endauth
                                            
                                            @if(access()->hasPermission('manager-category') || access()->hasPermission('cap-nhat-het-hang') || access()->hasPermission('manager-option'))
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.product.index') !!}"><i class="fa fa-cube" style="font-size:18px;"></i> S???n ph???m</span></a>
                                                <ul class="dropdown-menu">
                                                    @permission('manager-category')
                                                    <li class="{!! Request::is('admin/category*') ? 'active' : '' !!}"><a href="{!! route('admin.category.index') !!}"><span>Danh m???c</span></a></li>
                                                    @endauth
                                                    @permission('cap-nhat-het-hang')
                                                    <!-- <li class="{!! Request::is('admin/product*') ? 'active' : '' !!}"><a href="{!! route('admin.product.index') !!}"><span>S???n ph???m</span></a></li> -->
                                                    <li class="{!! Request::is('admin/product*') ? 'active' : '' !!} dropdown-submenu"><a href=""><span>S???n ph???m</span></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="{!! route('admin.product.index') !!}">S???n ph???m</a></li>
                                                            <li class="{!! Request::is('admin/product/sort*') ? 'active' : '' !!}"><a href="{!! route('admin.product.sort') !!}">S???p x???p s???n ph???m</a></li>
                                                        </ul>
                                                    </li>
                                                    @endauth
                                                    @permission('manager-option')
                                                    <li class="{!! Request::is('admin/option*') ? 'active' : '' !!}"><a href="{!! route('admin.option.index') !!}"><span>Option</span></a></li>
                                                    @endauth
                                                </ul>
                                            </li>
                                            @endif

                                            @if(access()->hasPermission('manager-user') || access()->hasPermission('manager-role'))
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.role.index') !!}"><i class="fa fa-user" style="font-size:18px;"></i> Ph??n quy???n</a>
                                                <ul class="dropdown-menu">
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
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.room.index') !!}"><i class="fa fa-laptop" style="font-size:18px;"></i> Ph??ng m??y</a>
                                                <ul class="dropdown-menu">
                                                    @permission('manager-room')
                                                    <li class="{!! Request::is('admin/room*') ? 'active' : '' !!}"><a href="{!! route('admin.room.index') !!}"><span>Ph??ng m??y(Room)</span></a></li>
                                                    @endauth
                                                    @permission('manager-client')
                                                    <li class="{!! Request::is('admin/client*') ? 'active' : '' !!}"><a href="{!! route('admin.client.index') !!}"><span>M??y tr???m(Client)</span></a></li>
                                                    @endauth
                                                </ul>
                                            </li>
                                            @endif

                                            @permission('manager-schedule')
                                            <li class="dropdown">
                                                <a href="{!! route('admin.schedule.index') !!}"><i class="fa fa-calendar" style="font-size:18px;"></i> Qu???n l?? ca</span></a>
                                            </li>
                                            @endauth

                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.order.all')!!}"><i class="fa fa-shopping-cart" style="font-size:18px;"></i> ????n h??ng</a>
                                                <ul class="dropdown-menu">
                                                    <li class="{!! Request::is('admin/order/listall*') ? 'active' : '' !!}"><a href="{!! route('admin.order.all')!!}"><span>T???t c??? ????n h??ng</span></a></li>
                                                    {{--roles([2,3]) @endauth --}}
                                                    <li class="{!! Request::is('admin/order/listpending*') ? 'active' : '' !!}"><a href="{!! route('admin.order.pending') !!}"><span>??ang x??? l??</span></a></li>
                                                    <li class="{!! Request::is('admin/order/listapproved*') ? 'active' : '' !!}"><a href="{!! route('admin.order.approved') !!}"><span>???? thu ti???n</span></a></li> 
                                                    <li class="{!! Request::is('admin/order/listdone*') ? 'active' : '' !!}"><a href="{!! route('admin.order.done') !!}"><span>???? ho??n th??nh</span></a></li> 
                                                    @role(1)
                                                    <li class="{!! Request::is('admin/order/listdestroy*') ? 'active' : '' !!}"><a href="{!! route('admin.order.destroy') !!}"><span>???? h???y </span></a></li>
                                                    @endauth
                                                </ul>
                                            </li>

                                            @role(1)
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.history.list')!!}"><i class="fa fa-history" style="font-size:18px;"></i> L???ch s???</span></a>
                                                <ul class="dropdown-menu">
                                                    <li class="{!! Request::is('admin/history/list*') ? 'active' : '' !!}"><a href="{!! route('admin.history.list')!!}">X??? l?? ????n h??ng</a></li>
                                                    <li class="{!! Request::is('admin/history/reporthistory*') ? 'active' : '' !!}"><a href="{!! route('admin.history.report')!!}">Th???i gian x??? l??</a></li>
                                                    <li class="{!! Request::is('admin/history/addorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.addinput')!!}">Th??m h??a ????n nh???p</a></li>
                                                    <li class="{!! Request::is('admin/history/editorderinput*') ? 'active' : '' !!}"><a href="{!! route('admin.history.editinput')!!}">C???p nh???t h??a ????n nh???p</a></li>
                                                    <li class="{!! Request::is('admin/history/statusproduct*') ? 'active' : '' !!}"><a href="{!! route('admin.history.statusproduct')!!}">C???p nh???t tr???ng th??i s???n ph???m</a></li>
                                                </ul>
                                            </li>
                                            @endauth

                                            @permission('manager-report')
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('admin.statistic.day') !!}"><i class="fa fa-bookmark" style="font-size:18px;"></i> B??o c??o</span></a>
                                                <ul class="dropdown-menu">
                                                    <li class="{!! Request::is('admin/statistic/statisticcategory*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.category') !!}">Th???ng k?? s???n ph???m b??n ch???y</a></li>
                                                    <li class="{!! Request::is('admin/statistic/day*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.day') !!}">B??o c??o ng??y</a></li>
                                                    <li class="{!! Request::is('admin/statistic/month*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.month') !!}">B??o c??o th??ng</a></li>
                                                    <li class="{!! Request::is('admin/statistic/year*') ? 'active' : '' !!}"><a href="{!! route('admin.statistic.year') !!}">B??o c??o n??m</a></li>
                                                </ul>
                                            </li>
                                            @endauth

                                            @permission('manager-stock')
                                            <li class="dropdown-submenu">
                                                <a href="{!! route('stock.index')!!}"><i class="fa fa-hdd-o" style="font-size:18px;"></i> Kho h??ng</span></a>
                                                <ul class="dropdown-menu">
                                                    <li class="{!! Request::is('admin/category_stock*') ? 'active' : '' !!}"><a href="{!! route('category_stock.index')!!}">Lo???i h??ng nh???p</a></li>
                                                    <li class="{!! Request::is('admin/stock*') ? 'active' : '' !!}"><a href="{!! route('stock.index')!!}">S???n ph???m nh???p</a></li>
                                                    <li class="{!! Request::is('admin/bill*') ? 'active' : '' !!}"><a href="{!! route('bill.index')!!}">H??a ????n nh???p</a></li>
                                                    <li class="{!! Request::is('admin/unit*') ? 'active' : '' !!}"><a href="{!! route('unit.index')!!}">????n v??? h??ng nh???p</a></li>
                                                    <li class="{!! Request::is('admin/recipe*') ? 'active' : '' !!}"><a href="{!! route('recipe.index')!!}">C??ng th???c m??n ??n</a></li>
                                                </ul>
                                            </li>
                                            @endauth

                                            @role(1)
                                            <li class="dropdown">
                                                <a href="{!! route('admin.get.setting') !!}"><i class="fa fa-cog" style="font-size:18px;"></i> Setting</a>
                                            </li>
                                            @endauth

                                        </ul>
                                    </li>
                                    

                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart" style="font-size:18px;"></i> ????n h??ng <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li class="{!! Request::is('admin/order/listall*') ? 'active' : '' !!}"><a href="{!! route('admin.order.all')!!}"><span>T???t c??? ????n h??ng</span></a></li>
                                            {{--roles([2,3]) @endauth --}}
                                            <li class="{!! Request::is('admin/order/listpending*') ? 'active' : '' !!}"><a href="{!! route('admin.order.pending') !!}"><span>????n h??ng ??ang x??? l??</span></a></li>
                                            <li class="{!! Request::is('admin/order/listapproved*') ? 'active' : '' !!}"><a href="{!! route('admin.order.approved') !!}"><span>????n h??ng ???? thu ti???n</span></a></li> 
                                            <li class="{!! Request::is('admin/order/listdone*') ? 'active' : '' !!}"><a href="{!! route('admin.order.done') !!}"><span>????n h??ng ???? ho??n th??nh</span></a></li> 
                                            @role(1)
                                            <li class="{!! Request::is('admin/order/listdestroy*') ? 'active' : '' !!}"><a href="{!! route('admin.order.destroy') !!}"><span>????n h??ng ???? h???y </span></a></li>
                                            @endauth
                                        </ul>
                                    </li>

                                    

                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- <li class="dropdown messages-menu">
                            Menu toggle button
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    inner menu: contains the messages
                                    <ul class="menu">
                                        <li>start message
                                            <a href="#">
                                                <div class="pull-left">
                                                    User Image
                                                    <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image"/>
                                                </div>
                                                Message title and timestamp
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                The message
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>end message
                                    </ul>/.menu
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>/.messages-menu -->

                        <!-- Notifications Menu -->
                        <!-- <li class="dropdown notifications-menu">
                            Menu toggle button
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    Inner Menu: contains the notifications
                                    <ul class="menu">
                                        <li>start notification
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li>end notification
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li> -->
                        <!-- Tasks Menu -->
                        <!-- <li class="dropdown tasks-menu">
                            Menu Toggle Button
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    Inner menu: contains the tasks
                                    <ul class="menu">
                                        <li>Task item
                                            <a href="#">
                                                Task title and progress text
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                The progress bar
                                                <div class="progress xs">
                                                    Change the css width attribute to simulate progress
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>end task item
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                @if(!empty(Auth::user()->avatar))
                                    <img class="user-image" src="{{ asset('uploads/users/'.Auth::user()->avatar) }}" alt="User profile picture" >
                                @else
                                    <img src="{{ asset("/images/admin.png") }}" class="user-image" alt="User Image"/>
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">Xin ch??o, {!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if(!empty(Auth::user()->avatar))
                                        <img class="img-circle" src="{{ asset('uploads/users/'.Auth::user()->avatar) }}" alt="User profile picture" >
                                    @else
                                        <img src="{{ asset("/images/admin.png") }}" class="img-circle" alt="User Image" />
                                    @endif
                                    <p>
                                        {!!  Auth::user()->name !!}
                                        <small>Th??nh vi??n t??? - {!! date('d-m-Y',strtotime(Auth::user()->created_at)) !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li> -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('admin.profile') !!}" class="btn btn-default btn-flat">H??? s??</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! route('admin.logout') !!}" class="btn btn-default btn-flat">????ng xu???t</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>