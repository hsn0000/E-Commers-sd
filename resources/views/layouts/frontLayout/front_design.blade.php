<!DOCTYPE html>
<html lang="{{Session::get('applocale')}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://cdn3.iconfinder.com/data/icons/social-media-2068/64/_shopping-512.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($meta_description))
    <meta name="description" content=" {{$meta_description}} "> 
    @endif
    @if(!empty($meta_keyword))
    <meta name="keywords" content=" {{$meta_keyword}} "> 
    @endif
    <title> @if(!empty($meta_title)) {{ $meta_title }} @else Home | E-Commerce @endif</title>
    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/easyzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/passtrength.css') }}" rel="stylesheet">
    <!-- breaking news tiket -->
    <link href="{{ asset('css/frontend_css/breaking-news-ticket.min.css') }}" rel="stylesheet">
    <!-- *wysihtml5* -->
    <!-- <link href="{{ asset('css/frontend_css/bootstrap3-wysihtml5.css') }}" rel="stylesheet"> -->
    <!-- custom css -->
    <link href="{{ asset('css/frontend_css/custome.css') }}" rel="stylesheet">
    <!-- [if lt IE 9]>
    <script src="{{ asset('js/frontend_js/html5shiv.js') }}"></script>
    <script src="{{ asset('js/frontend_js/respond.js') }}"></script>
    <![endif] -->
    <link rel="shortcut icon" href="{{ asset('images/frontend_images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('images/frontend_images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('images/frontend_images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('images/frontend_images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed"
        href="{{ asset('images/frontend_images/ico/apple-touch-icon-57-precomposed.png') }}">
        <!-- notify css -->
    <link rel="stylesheet" href="{{asset('css/backend_css/pnotify.css')}}">
    <!-- end not css -->
    @php
     $url = url()->current();
    @endphp
    
    @yield('style')
</head>
<!--/head-->

<body style="margin-bottom: 31px;">


    @include('layouts.frontLayout.front_header')

    @yield('content')

    @include('layouts.frontLayout.front_footer')


    <script src="{{ asset('js/frontend_js/jquery.js') }}"></script>
    <script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/price-range.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/frontend_js/main.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script> 
    <script src="{{ asset('js/frontend_js/passtrength.js') }}"></script>
    <script src="{{ asset('js/frontend_js/easyzoom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"> </script>
    <!-- notify -->
    <script src="{{asset('js/backend_js/pnotify.js')}}"></script> 
    <script src="{{asset('js/backend_js/notify.custome.js')}}"></script> 
    <!-- endnot -->
    <!-- * wysihtml5 * -->
    <!-- <script src="{{ asset('js/frontend_js/bootstrap3-wysihtml5.js') }}"></script> -->

    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e85681bbd750c55"></script> -->\

    <!-- www.sharethis.com -->
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e858d8c182c2700121b7779&product=sticky-share-buttons&cms=website' async='async'></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e858d8c182c2700121b7779&product=inline-share-buttons&cms=website' async='async'></script>
    <!-- *font awesome* -->
    <script src="https://kit.fontawesome.com/2af5e43179.js" crossorigin="anonymous"></script>
    <!-- end fa -->
    <!-- <script src="{{ asset('js/app.js')}}"></script> -->

    @yield('script')

    @include('layouts.frontLayout.additional.adt_front_design')

    <!-- msg -->
    @include('layouts.frontLayout.additional.adt_front_message')

</body>

</html>