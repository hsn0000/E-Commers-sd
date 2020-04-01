@extends('layouts.frontLayout.front_design')
@section('content')

@php
 use App\Product;
 use App\Order;
  $currencyLocale = Session::get('currencyLocale');
@endphp

<div id="loading"></div>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Paypal</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading" style="text-align:center;">
            <h3>YOUR ORDER HAS BEEN PLACED</h3>
            <img style="width:170px; height:90px;" src="{{asset('/images/frontend_images/Than.jpg')}}" alt="">
            <p>Please make payment by clicking on below Payment Button</p>
            <?php 
             $orderDetails = Order::getOrderDetails(Session::get('order_id')); 
             $orderDetails = json_decode(json_encode($orderDetails)); 
             $nameArr = explode(' ',$orderDetails->name);
             $getCountryCode = Order::getCountryCode($orderDetails->country); 
                  ?>

            <p>Your order number is <b style="color:green;">{{Session::get('order_id')}}</b> and total payable about is
                <b style="color:green;">{{$currencyLocale->currency_simbol.' '.is_number(Session::get('grant_total'),2)}}</b></p>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> {{csrf_field()}}
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="Muhamad.husin0412.com">
                <input type="hidden" name="item_name" value="{{Session::get('order_id')}}">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="amount" value="{{Session::get('grant_total')}}">
                <input type="hidden" name="first_name" value="{{$nameArr[0]}}">
                <input type="hidden" name="last_name" value="{{$nameArr[1]}}">
                <input type="hidden" name="address1" value="{{$orderDetails->address}}">
                <input type="hidden" name="address2" value="">
                <input type="hidden" name="city" value="{{$orderDetails->city}}">
                <input type="hidden" name="state" value="{{$orderDetails->state}}">
                <input type="hidden" name="zip" value="{{$orderDetails->pincode}}">
                <input type="hidden" name="email" value="{{$orderDetails->user_email}}">
                <input type="hidden" name="country" value="{{$getCountryCode->country_code}}">
                <input type="hidden" name="return" value="{{url('paypal/thanks')}}">
                <input type="hidden" name="cancel_return" value="{{url('paypal/cancel')}}">
                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png"
                    alt="Pay Now">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
    </div>
</section>
@endsection
