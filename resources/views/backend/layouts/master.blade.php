<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', "GengarGaming" )</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="icon" href="{{ asset('images/icon/favicon.png') }}" type="image/x-icon" />
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="{{ asset("css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />        
        
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-custom.css")}}" rel="stylesheet" type="text/css" />
       
        
              
        <link href="{{ asset("css/bstyle.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("css/sweetalert2.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("css/datepicker.css")}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css')}}" />
        <link href="{{ asset("css/chat.css") }}" rel="stylesheet" type="text/css" />
        <!-- <link href="{{ asset('css/jquery.smartmenus.bootstrap.css')}}" rel="stylesheet" type="text/css" /> -->
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            var base_url = "{{url('/admin/')}}";
            var tokenvrf = "{{ csrf_token() }}";
        </script>
          
    </head>
    <body class="skin-blue">
    <div class="wrapper">
      <style type="text/css">
        .input-focus:focus{border:2px solid red !important;}
      </style>

        <!-- Main Header -->
        @include('backend.includes.header')
        <!-- Sidebar -->
        @include('backend.includes.sidebar')
        

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                 <h1>
                    {{ $page_title or "Page Title" }}
                    <small>{{ $page_description or null }}</small>
                </h1>
                 <!-- You can dynamically generate breadcrumbs here -->
                 {{-- Breadcrumbs::render() require breadcrumbs --}}
                 {!! Breadcrumbs::renderIfExists() !!}
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <!-- Main Footer -->
        @include('backend.includes.footer')

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Xử lý đơn hàng<strong id="username"></strong></h4>
                    </div>
                    <div class="modal-body">
                        <div id="noidung"></div>
                    </div>
                </div>
            </div>
        </div>
        <audio id="neworder">
            <source src="{!! asset('audio/thongbao.mp3')!!}" type="audio/mpeg">
                  Your browser does not support the audio element.
        </audio>
        <audio id="money">
            <source src="{!! asset('audio/money.mp3')!!}" type="audio/mpeg">
                  Your browser does not support the audio element.
        </audio>
    </div><!-- ./wrapper -->   

    <!-- REQUIRED JS SCRIPTS -->
    <!-- jQuery 2.2.3 -->
    <script src="{!! asset('bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') !!}" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{!! asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') !!}" type="text/javascript"></script>

    <script src="{!! asset('bower_components/AdminLTE/bootstrap/js/bootstrap-confirmation.min.js') !!}" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="{!! asset('bower_components/AdminLTE/dist/js/app.min.js') !!}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{!! asset('js/bfunction.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/es6-promise.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/sweetalert2.min.js') !!}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <!-- Chat App -->
    <script src="{!! asset('js/socket.io-1.4.5.js') !!}"" type="text/javascript"></script>
    <script type="text/javascript">
      var room_url = "{{route('api.redis.room')}}";
      var private_url = "{{route('api.redis.private')}}";
      var user_url = "{{ route('api.user.online') }}";
      var url_images = "{{asset('public/images')}}";
    </script>
    <script src="{!! asset('js/chat.js') !!}" type="text/javascript"></script>


    <!-- <script src="{!! asset('js/jquery.smartmenus.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/jquery.smartmenus.bootstrap.min.js') !!}" type="text/javascript"></script> -->

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->  
    <script src="{!! asset('js/pusher.min.js') !!}"></script>
    <script>

         /* function pushOne(){
            if ( Date.now() > sessionStorage.getItem('storedWhen')) {
                sessionStorage.removeItem('pushone');
                sessionStorage.setItem('storedWhen', Date.now());
            }
          }*/
          function myOpenWindow(winURL, winName, winFeatures, winObj)
          {
            var theWin; // this will hold our opened window 

            // first check to see if the window already exists
            if (winObj != null)
            {
              // the window has already been created, but did the user close it?
              // if so, then reopen it. Otherwise make it the active window.
              if (!winObj.closed) {
                winObj.focus();
                return winObj;
              } 
              // otherwise fall through to the code below to re-open the window
            }

            // if we get here, then the window hasn't been created yet, or it
            // was closed by the user.
            theWin = window.open(winURL, winName, winFeatures).focus(); 
            return theWin;
          }
          var MyPopUp = false;
          function OpenWindow(url){
            //checks to see if window is open
            if(MyPopUp && !MyPopUp.closed)
            {
              winPop.focus(); //If already Open Set focus
            }
            else
            {
              MyPopUp = window.open(url,"MyPopUp");//Open a new PopUp window
            }
          }

          document.addEventListener('DOMContentLoaded', function () {
            if (Notification.permission !== "granted")
              Notification.requestPermission();
          });
          function notifyHethang(check,msg){
            if (!Notification) {
                    alert('Desktop notifications not available in your browser. Try Chromium.'); 
                    return;
            }

            if (Notification.permission !== "granted")
              Notification.requestPermission();
            else {
              if(check){
                  var notification = new Notification('Hết hàng', {
                    //icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                    icon: "{!! asset('images/logo-push.png')!!}",
                    body: msg,
                  });

                  notification.onclick = function () {
                    //window.open("http://stackoverflow.com/a/13328397/1269037");  
                    myOpenWindow("{!! route('stock.index')!!}","hethang");     
                  };
              }
            }
                    
          }
          function notifyMe() {
           /* if (typeof window.sessionStorage != undefined) {
               if (!sessionStorage.getItem('pushone')) {*/
                  if (!Notification) {
                    alert('Desktop notifications not available in your browser. Try Chromium.'); 
                    return;
                  }

                  if (Notification.permission !== "granted")
                    Notification.requestPermission();
                  else {
                    var notification = new Notification('Đơn hàng mới', {
                      //icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                      icon: "{!! asset('images/logo-push.png')!!}",
                      body: "Xin chào {!! Auth::user()->name !!}! Có đơn đặt hàng mới!",
                    });

                    notification.onclick = function () {
                      //window.open("http://stackoverflow.com/a/13328397/1269037");  
                      //window.open("{!! route('admin.order.pending')!!}");   
                      myOpenWindow("{!! route('admin.order.pending')!!}","open"); 
                      //OpenWindow("{!! route('admin.order.pending')!!}") ;
                    }; 
                    
                  }
                 /* sessionStorage.setItem('pushone', true);
                  sessionStorage.setItem('storedWhen', Date.now());
              }
            }*/
              
          }
            //var pusher = new Pusher("{{-- env(PUSHER_KEY) --}}");
            // Enable pusher logging - don't include this in production
            //Pusher.logToConsole = true;

           /* var pusher = new Pusher('422021dac7cbf8d59d02', {
              encrypted: true
            });*/

            var pusherKey = '{{Config::get('broadcasting.connections.pusher.key')}}';
            var permission6 = false;
            @permission('quan-ly-tang-6')
              permission6 =  true;
            @endauth
            var permission5 = false;
            @permission('quan-ly-tang-5')
              permission5 =  true;
            @endauth
            var permission4 = false;
            @permission('quan-ly-tang-4')
              permission4 =  true;
            @endauth
            var permission3 = false;
            @permission('quan-ly-tang-3')
              permission3 =  true;
            @endauth
            var permission2 = false;
            @permission('quan-ly-tang-2')
              permission2 =  true;
            @endauth

            var permissionProduct = false;
            @permission('manager-product')
              permissionProduct =  true;
            @endauth
            
            var permissChef = false;
            @permission('chef-do')
              permissChef = true;
            @endauth

            var pusher = new Pusher(pusherKey);

            var add_channel = pusher.subscribe('add_channel');
            var approved_channel = pusher.subscribe('approved_channel');
            var done_channel = pusher.subscribe('done_channel');
            var destroy_channel = pusher.subscribe('destroy_channel');
            var pending_channel = pusher.subscribe('pending_channel');
            add_channel.bind("App\\Events\\Frontend\\Cart\\CartAdd", function( data ) {
               //alert(data.notification);
               //console.log(data.notification.room_id);
               /*if (data.notification.room_id) {
                 sessionStorage.setItem('pushone','true'); 
               }*/ 
               console.log(data.notification);
               var audio = document.getElementById("neworder");
             /*  if (permission2 && permission3 && permission4 && permission5 && permission6) {
                   audio.play();
                   notifyMe(); 
               }else{*/
                   if(data.notification.room_id == 6 && permission6 == true) {  
                      audio.play();
                      notifyMe();  
                   }
                   if(data.notification.room_id == 5 && permission5 == true) {  
                      audio.play();
                      notifyMe();    
                   }
                   if(data.notification.room_id == 4 && permission4 == true) {   
                      audio.play();
                      notifyMe();
                      
                   }
                   if(data.notification.room_id == 3 && permission3 == true) {
                      audio.play();
                      notifyMe();
                   }
                   if(data.notification.room_id == 2 && permission2 == true) {  
                      audio.play();
                      notifyMe();  
                   }

                   if(permissChef == true && data.notification.checkChef == true && !(permission2 && permission3 && permission4 && permission5 && permission6) ){
                      audio.play();
                      notifyMe();
                   }

                  if(data.notification.check == true && permissionProduct == true) {
                      audio.play();
                      notifyHethang(data.notification.check,data.notification.messager);
                  }  
                   /*swal(
                      'Có đơn hàng mới !'
                    )*/
               //}
               
            });
            approved_channel.bind("App\\Events\\Backend\\Order\\OrderApproved", function( data ) {
                //alert(data.notification);
                //alert(data);
                var money = document.getElementById("money");
                if(data.check_chef_do == 0 && permissChef == true) {

                }else{
                  money.play();
                }
               /*swal(
                  'Có đơn hàng mới !'
                )*/
            });
      </script>  
     @yield('after-scripts-end')
    </body>
</html>