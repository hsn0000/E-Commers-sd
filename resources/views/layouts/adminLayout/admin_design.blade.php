<!DOCTYPE html>
<html lang="en">  
<head>
<link rel="shortcut icon" href="{{url('images/backend_images/admin.png')}}" />
<title>
 @yield('title')
</title> 
<meta charset="UTF-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{asset('css/backend_css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/bootstrap-responsive.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/uniform.css')}}">
<link rel="stylesheet" href="{{asset('css/backend_css/bootstrap-wysihtml5.css')}}">
<link rel="stylesheet" href="{{asset('css/backend_css/select2.css')}}">
<link rel="stylesheet" href="{{asset('css/backend_css/fullcalendar.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/matrix-style.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/matrix-media.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/font-awesome.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/jquery.gritter.css')}}" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- custom css -->
<link rel="stylesheet" href="{{asset('css/backend_css/custom.css')}}">
<!-- togle switch custome bootsrap -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{asset('css/backend_css/print.min.css')}}">
<!-- notify css -->
<link rel="stylesheet" href="{{asset('css/backend_css/pnotify.css')}}">
<!-- end not css -->
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; min-width: 13px; min-height: 11px;}
  .toggle.ios .toggle-handle { border-radius: 20rem; min-width: 13px; min-height: 11px; }
</style>
<!-- end togle switch custome bootsrap -->
@php
  $url = url()->current();
@endphp

@yield('link')
</head>
<body>

@include('layouts.adminLayout.admin_header')

@include('layouts.adminLayout.admin_sidebar')
 
@yield('content')

@include('layouts.adminLayout.admin_footer ')
<!--  -->


<script src="{{asset('js/backend_js/jquery.min.js')}}"></script> 
<!-- <script src="{{asset('js/backend_js/jquery.ui.custom.js')}}"></script> -->
<script src="{{asset('js/backend_js/bootstrap.min.js')}}"></script> 
<script src="{{asset('js/backend_js/jquery.uniform.js')}}"></script> 
<script src="{{asset('js/backend_js/select2.min.js')}}"></script> 
<script src="{{asset('js/backend_js/jquery.validate.js')}}"></script> 
<script src="{{asset('js/backend_js/matrix.js')}}"></script> 

<script src="{{asset('js/backend_js/wysihtml5-0.3.0.js')}}"></script> 
<script src="{{asset('js/backend_js/bootstrap-wysihtml5.js')}}"></script> 
<script src="{{asset('js/backend_js/fullcalendar.min.js')}}"></script> 
<script src="{{asset('js/backend_js/jquery.easy-pie-chart.js')}}"></script> 
<!-- <script src="{{asset('js/backend_js/matrix.calendar.js')}}"></script>  -->
<!-- <script src="{{asset('js/backend_js/matrix.charts.js')}}"></script>  -->
<!-- <script src="{{asset('js/backend_js/matrix.chat.js')}}"></script>  -->
<!-- <script src="{{asset('js/backend_js/matrix.dashboard.js')}}"></script>  -->
<!-- <script src="{{asset('js/backend_js/matrix.interface.js')}}"></script>  -->
<!-- <script src="{{asset('js/backend_js/jquery.wizard.js')}}"></script>  -->

<script src="{{asset('js/backend_js/matrix.form_validation.js')}}"></script>
<script src="{{asset('js/backend_js/matrix.tables.js')}}"></script>
<script src="{{asset('js/backend_js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/backend_js/matrix.popover.js')}}"></script>
<script src="{{asset('js/backend_js/jquery.price_format.js')}}"></script> 
<script src="{{asset('js/backend_js/custom.js')}}"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- togle switch custome bootsrap -->
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="{{asset('js/backend_js/print.min.js')}}"></script> 
<!-- notify -->
<script src="{{asset('js/backend_js/pnotify.js')}}"></script> 
<script src="{{asset('js/backend_js/notify.custome.js')}}"></script> 
<!-- endnot -->
@yield('script')

<script>
 /*datepicker*/  
  $( function() {
    $( "#expiry_date" ).datepicker({ 
        minDate:0,
        dateFormat: 'yy-mm-dd'
      });
  });
  /*wysihtml5*/
  $('.some-textarea').wysihtml5(); 
  $('.some-textarea1').wysihtml5();
</script>

@include('layouts.adminLayout.additional.adt_admin_design')
@include('layouts.adminLayout.additional.adt_adm_message')

</body>
</html>
