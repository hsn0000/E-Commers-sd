@extends('layouts.frontLayout.front_design')
@section('content')


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
            <h3>YOUR PAYPAL ORDER HAS BEEN  CANCELLED</h3>
            <p>Please contact us if there is any enquiry.</p>
        </div>
    </div>
</section>
@endsection

@php
Session::forget('order_id');
Session::forget('grant_total');
@endphp