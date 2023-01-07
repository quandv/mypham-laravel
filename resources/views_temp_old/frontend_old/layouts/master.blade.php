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
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
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
                        @yield('content')
                    </div><!-- end .content -->

                    @include('frontend.layouts.cart')
                    
                    
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
    
    <script src="{!! asset('js/socket.io-1.4.5.js') !!}"" type="text/javascript"></script>
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
</body>
</html>