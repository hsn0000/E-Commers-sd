@extends('layouts.frontLayout.front_design')
@section('content')

@php
 use App\Product;
  $currencyLocale = Session::get('currencyLocale');
@endphp

<div id="loading"></div>     
  <section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Thanks</li>
            </ol>
        </div> 
    </div>
</section> 

<section id="do_action">
    <div class="container">
        <div class="heading" style="text-align:center;">
            <h3>YOUR COD ORDER HAS BEEN PLACED</h3>
            <img style="width:170px; height:90px;" src="{{asset('/images/frontend_images/Than.jpg')}}" alt="">
            <p>Your order number is <b style="color:green;">{{Session::get('order_id')}}</b> and total payable about is <b style="color:green;"> {{$currencyLocale->currency_simbol.' '.is_number(Session::get('grant_total'),2)}}</b></p>
        </div>
    </div>
</section>
@endsection

@php
Session::forget('order_id');
Session::forget('grant_total');
@endphp