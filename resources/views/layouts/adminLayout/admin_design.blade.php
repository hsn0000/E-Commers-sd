<!DOCTYPE html>
<html lang="en">  
<head>
<title>
 @yield('title')
</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{asset('css/backend_css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/bootstrap-responsive.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/backend_css/uniform.css')}}">
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
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; min-width: 13px; min-height: 11px;}
  .toggle.ios .toggle-handle { border-radius: 20rem; min-width: 13px; min-height: 11px; }
</style>
<!-- end togle switch custome bootsrap -->

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

@yield('script')

<script>
  $( function() {
    $( "#expiry_date" ).datepicker({ 
        minDate:0,
        dateFormat: 'yy-mm-dd'
      });
  });
</script>

@include('layouts.adminLayout.additional.adt_admin_design')

</body>
</html>
