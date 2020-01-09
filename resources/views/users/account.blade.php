@extends('layouts.frontLayout.front_design')
@section('content')

    @if(Session::has('signup_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:18%; margin-left:50%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('signup_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('signup_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:18%; margin-left:50%;">
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
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:18%; margin-left:27%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
	@endif
	<div id="loading"></div>
    <section id="form" style="margin:20px 0px 5% 0;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--account form-->
						<h2>Update your Account</h2>
						<form action="{{url('/account')}}" id="accountForm" name="accountForm" method="post"> {{csrf_field()}}
							<input type="text" name="name" placeholder="Name" value="{{$userDetails->name}}" />
                            <input type="text" name="address" placeholder="Address" value="{{$userDetails->address}}" />
							<input type="text" name="city" placeholder="City" value="{{$userDetails->city}}" />
                            <input type="text" name="state" placeholder="State" value="{{$userDetails->state}}" />
							<select style="padding:10px;" name="country" id="country">
                                <option value="" >Select Country</option>
                              @foreach($countries as $country)
                                <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif >{{$country->country_name}}</option>
                              @endforeach
                            </select>
                            <input style="margin-top:10px;" type="text" name="pincode" placeholder="Pincode" value="{{$userDetails->pincode}}" />
							<input type="text" name="mobile" placeholder="Mobile" value="{{$userDetails->mobile}}" />
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Your Password </h2>
					    <form action="{{url('/update-user-pwd')}}" id="passswordForm" name="passswordForm" method="post">{{csrf_field()}}
                          <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password">
                          <span id="chkPwd"></span>
                          <input type="password" name="new_pwd" id="new_pwd" placeholder="New Passsword">
                          <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
                          <button type="submit" class="btn btn-default">Update</button>

                        </form>
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