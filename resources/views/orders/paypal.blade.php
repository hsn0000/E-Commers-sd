@extends('layouts.frontLayout.front_design')
@section('content')


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
            <p>Your order number is <b style="color:green;">{{Session::get('order_id')}}</b> and total payable about is <b style="color:green;">Rp.{{Session::get('grant_total')}}</b></p>
             <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="business" value="sb-3fiwt853583@business.example.com">
                <input type="hidden" name="item_name" value="898">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="amount" value="1000">
                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Pay Now">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
    </div>
</section>
@endsection

