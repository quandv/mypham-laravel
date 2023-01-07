<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title')</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('images/icon/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.css')}}" type="text/css" media="all" />
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

    
   
</head>
<body>
    <!-- start header -->
    @include('frontend.layouts.header')

    <!-- SLIDER -->
    @include('frontend.layouts.slider')
    
    @yield('content')
    
    @include('frontend.layouts.footer')

    <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/modernizr.custom.28468.js') }}"></script>    
    <script type="text/javascript" src="{{ asset('js/jquery.cslider.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/move-top.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/easing.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/function.js') }}"></script>    

    <script type="text/javascript">
        $(function() {
            $('#da-slider').cslider();
        });

        $(document).ready(function() {
    
          $("#owl-demo").owlCarousel({
            items : 4,
            lazyLoad : true,
            autoPlay : true,
            navigation : true,
            navigationText : ["",""],
            rewindNav : false,
            scrollPerPage : false,
            pagination : false,
            paginationNumbers: false,
          });
    
        });
    </script>

    <!-- start top_js_button -->    
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){     
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
            });
        });
    </script>

    <!-- scroll_top_btn -->
    <script type="text/javascript">
        $(document).ready(function() {
        
            var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
            };
            
            
            $().UItoTop({ easingType: 'easeOutQuart' });
            
        });
    </script>
    
</body>
</html>