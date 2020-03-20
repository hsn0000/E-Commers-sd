@extends('layouts.frontLayout.front_design')
@section('content')

    @if(Session::has('signup_error'))
        <div class="alert alert-dark alert-block" style="background-color:red; color:white; width:16%; margin-left:51%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('signup_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('signup_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:16%; margin-left:51%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('signup_success')}}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:red; color:white; width:18%; margin-left:27%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color: cornflowerblue;color: white;width: 19%;margin-left: 51%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
	@endif
	
	<div id="loading"></div>
    <section id="form" style="margin:20px 0px 5% 0;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--forget pw form-->
						<h2>Forgot Password</h2>
						<form action="{{url('/forgot-password')}}" id="forgotPasswordForm" name="forgotPasswordForm" method="post"> {{csrf_field()}}
							 <input type="email" name="email" placeholder="Email Address" required/>
							 <button type="submit" class="btn btn-default">Submit</button>
						</form>
					</div><!--/forget pw form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="{{url('/user-register')}}" method="post" id="registerForm" name="registerForm"> {{csrf_field()}}
							<input name="name" type="text" placeholder="Name" />
							<input name="email" type="email" placeholder="Email Address" />
							<input name="password" type="password" placeholder="Password" id="myPassword" />
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection

@section('script');
<script>
$().ready(function () {


});
</script>
@endsection