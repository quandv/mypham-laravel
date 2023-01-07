<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('/images/icon/favicon.png') }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    
   
</head>
<body>
    <!-- start header -->
    @include('frontend.layouts.header')

    @yield('content')
    
    @include('frontend.layouts.footer')

    <script type="text/javascript" src="{{ asset('js/move-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/easing.js') }}"></script>       

    <!-- start top_js_button -->    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){     
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
            });
        });
    </script>

    
</body>
</html>