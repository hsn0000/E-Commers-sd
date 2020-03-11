@extends('layouts.frontLayout.front_design')
@section('content')

  <section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white">
                <button type="button" class="close" data-dismiss="alert">X</button>	
                <strong> {{Session::get('flash_message_error')}}</strong>
            </div>
            @endif  
            @if(Session::has('flash_message_drop'))
            <div class="alert alert-success alert-block" style="background-color:#F08080; color:white">
                <button type="button" class="close" data-dismiss="alert" >X</button>	
                <strong> {{Session::get('flash_message_drop')}}</strong>
            </div>
        @endif
            @if(Session::has('flash_message_success'))
            <div class="alert alert-dark alert-block" style="background-color:green; color:white">
                <button type="button" class="close" data-dismiss="alert">X</button>	
                <strong> {{Session::get('flash_message_success')}}</strong>
            </div>
        @endif
        <div id="loading"></div>      
        <div class="table-responsive cart_info" >
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image" style="padding-left:10%;">Item</td>
                        <td class="description" style="padding-left:3%;">Description</td>
                        <td class="price" style="padding-left:2%;">Price</td>
                        <td class="quantity" style="padding-left:3%;">Quantity</td>
                        <td class="total" style="padding-left:3%;">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                <?php $total_amount = 0; ?>
                    @foreach($userCart as $cart )
                    <tr>
                        <td class="cart_product">
                            <a href="{{url('/product/'.$cart->product_id)}}"><img style="width:200px;" src="{{ asset('images/backend_images/products/medium/'.$cart->image) }}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4>{{$cart->product_name}}</h4>
                            <p>Code : {{$cart->product_code}}</p>
                            <p>Size : {{$cart->size}} | Color : {{$cart->product_color}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{'Rp'.' '.is_number($cart->price)}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="{{url('/cart/update-quantity/'.$cart->id.'/1')}}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                                @if($cart->quantity > 1)
                                <a class="cart_quantity_down" href="{{url('/cart/update-quantity/'.$cart->id.'/0')}}"> - </a>
                                @endif
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{'Rp'.' '.is_number($cart->price * $cart->quantity)}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{url('/cart/delete-product-cart/'.$cart->id)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + ($cart->price * $cart->quantity); ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                      <form action="{{ url('/cart/apply-coupon')}}" method="post"> {{csrf_field()}} 
                        <li>
                            <label>Use Coupon Code</label> 
                            <input type="text" name="coupon_code" required>
                            <input type="submit" value="Apply" class="btn btn-warning" style="width:20%;">
                        </li>
                        </form>
                    </ul>             
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                    @if(!empty(Session::get('CouponAmount')))
                        <li>Sub Total <span> {{'Rp'.' '.is_number($total_amount,2)}} </span></li>
                        <li>Coupon Discoun <span> {{'Rp'.' '.is_number(Session::get('CouponAmount'),2)}} </span></li>
                        <li>Grand Total <span> {{'Rp'.' '.is_number(($total_amount - Session::get('CouponAmount')),2)}} </span></li>
                    @else
                        <li>Total <span> {{'Rp'.' '.is_number($total_amount,2) }} </span></li>
                    @endif
                    </ul>
                        <a class="btn btn-default update" href="">Update</a>
                        <a class="btn btn-default check_out" href="{{url('/checkout')}}">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->

@endsection