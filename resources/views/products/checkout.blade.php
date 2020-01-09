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
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:18%; margin-left:27%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
	@endif
	<div id="loading"></div>
    <section id="form" style="margin:20px 0px 5% 0;"><!--form-->
		<div class="container">
          <div class="breadcrumbs">
                <ol class="breadcrumb" style="margin-bottom:30px;">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Check Out</li>
                </ol>
            </div>
            <form action="{{url('/checkout')}}" method="post"> {{csrf_field()}}
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
                        <h2>Bill To</h2>
                         <div class="form-group">
                            <input type="text" name="billing_name" id="billing_name" value="{{$userDetails->name}}" placeholder="Billing Name" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="text" name ="billing_address" id="billing_address" value="{{$userDetails->address}}" placeholder="Billing Address" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="text" name="billing_city" id="billing_city" value="{{$userDetails->city}}" placeholder="Billing City" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="text" name="billing_state" id="billing_state" value="{{$userDetails->state}}" placeholder="Billing State" class="form-control">
                         </div>
                         <div class="form-group">
                         <select class="form-control" name="billing_country" id="billing_country">
                                <option value="" >Select Country</option>
                              @foreach($countries as $country)
                                <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif >{{$country->country_name}}</option>
                              @endforeach
                         </select>
                         </div>
                         <div class="form-group">
                            <input type="text" name="billing_pincode" id="billing_pincode" value="{{$userDetails->pincode}}" placeholder="Billing Pincode" class="form-control">
                         </div>
                         <div class="form-group">
                            <input type="text" name="billing_mobile" id="billing_mobile" value="{{$userDetails->mobile}}" placeholder="Billing Mobile" class="form-control">
                         </div>
                         <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" value="{{$userDetails->name}}" id="billtoship">
                            <label class="custom-control-label" for="billtoship">Shipping Address same as Billing Address</label>
                        </div>
					</div>
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
                        <h2>Ship To</h2>
                        <div class="form-group">
                            <input type="text" name="shipping_name" id="shipping_name" placeholder="Shipping Name" value="{{ $shippingDetails->name ?? ''}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name ="shipping_address" id="shipping_address" placeholder="Shipping Address" value="{{$shippingDetails->address ?? ''}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="shipping_city" id="shipping_city" placeholder="Shipping City" value="{{$shippingDetails->city ?? ''}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="shipping_state" id="shipping_state" placeholder="Shipping State" value="{{$shippingDetails->state ?? ''}}" class="form-control">
                        </div>
                        <div class="form-group">
                        <select name="shipping_country" id="shipping_country" class="form-control">
                                <option value="" >Select Country</option>
                              @foreach($countries as $country)
                                <option value="{{$country->country_name}}" @if($country->country_name == (!empty($shippingDetails->country))) selected @endif >{{$country->country_name}}</option>
                              @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="shipping_pincode" id="shipping_pincode" placeholder="Shipping Pincode" value="{{$shippingDetails->pincode ?? ''}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="shipping_mobile" id="shipping_mobile" placeholder="Shipping Mobile" value="{{$shippingDetails->mobile ?? ''}}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Checkout</button>
					</div>
				</div>
            </div>
            </form>
		</div>
	</section><!--/form-->

@endsection

@section('script');
<script>
$().ready(function () {


});
</script>
@endsection