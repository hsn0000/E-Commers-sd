<!DOCTYPE html>
<html lang="en">

<head>
    <title>Husin E-comerce Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/backend_css/matrix-login.css')}}" />
    <!-- <link rel="stylesheet" href="{{ asset('fonts/backend_fonts/css/font-awesome/font-awesome.css')}}" /> -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style>
    #loading {
        position: fixed;
        float: left;
        width: 100%;
        height: 100%;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin-right: 50%;
        z-index: 1000;
        overflow: visible;
        background: black url(/images/frontend_images/load4.gif) no-repeat center center;

    }
    </style>

</head>

<body>
    <div id="loading"></div>
    <div id="loginbox">
        @if(Session::has('flash_message_error'))
        @php $error = Session::get('flash_message_error') @endphp
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:40%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block"
            style="background-color:green; color:white; width:40%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{__('backend.'.Session::get('flash_message_success'))}}</strong>
        </div>
        @endif
        <form id="loginform" class="form-vertical" method="post" action="{{url('admin')}}" style="height: 448px"> {{csrf_field()}}
            <div class="control-group normal_text">
                <h3 style="color: aqua;">Husin E-comerce Admin</h3>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username"
                            placeholder="{{__('backend.username')}}" required>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password"
                            name="password" placeholder="{{__('backend.password')}}" required>
                    </div>
                </div>
            </div>
            <div class="form-actions">
             <a href="#" class="flip-link btn btn-info  pull-left" id="to-recover">{{__('backend.lost_password')}}</a>
             <span class="pull-right"><input type="submit" value="{{__('backend.login')}}" class="btn btn-success" /></span>

                <div class="dropdown pull-left ml-5" style="margin-left: 24px;">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('backend.language')}}
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li> <a href="{{url('/language/id')}}" class="sAdd" ><i class="icon-flag"></i>Indonesia </a></li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li><a class="sAdd" title="" href="{{url('/language/en')}}"><i class="icon-flag"></i>English</a></li>
                        <li class="divider"></li>
                        <li><a class="sAdd" title="" href="{{url('/language/khmer')}}"><i class="icon-flag"></i>Kambodia</a></li>
                    </ul>
                </div>

            </div>
        </form>
        <form id="recoverform" action="#" class="form-vertical">
            <p class="normal_text">{{__('backend.paragrafEmail')}}.</p>
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text"
                        placeholder="{{__('backend.e_mail_address')}}">
                </div>
            </div>
            <div class="form-actions">
                <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; {{__('backend.back_to_login')}}</a></span>
                <span class="pull-right"><a class="btn btn-info">{{__('backend.reecover')}}</a></span>
            </div>
        </form>
    </div>

    <script src="{{asset('js/backend_js/jquery.min.js')}}"></script>
    <script src="{{asset('js/backend_js/matrix.login.js')}}"></script>
    <script src="{{asset('js/backend_js/bootstrap.min.js')}}"></script>
    <script>
    $(document).ready(function() {
        // animate loading
        window.addEventListener('load', function() {
            $("#loading").delay(500).fadeOut("slow");
            // loading.style.display="none";
        });
    })
    </script>
</body>

</html>