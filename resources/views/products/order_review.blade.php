@extends('layouts.frontLayout.front_design')
@section('content')

@php
 use App\Product;
  $currencyLocale = Session::get('currencyLocale');
@endphp

@if(Session::has('flash_message_error'))
<div class="alert alert-dark alert-block" style="background-color:red; color:white; width:19%; margin-left:27%;">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong> {{Session::get('flash_message_error')}}</strong>
</div>
@endif
@if(Session::has('flash_message_success'))
<div class="alert alert-dark alert-block" style="background-color:green; color:white; width:19%; margin-left:27%;">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong> {{Session::get('flash_message_success')}}</strong>
</div>
@endif
<div id="loading"></div>

<section id="cart_items" style="margin:20px 0px 5% 0;">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb" style="margin-bottom:30px;">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Order Review</li>
            </ol>
        </div>
        <div class="shopper-informations">
            <div class="row">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Billing Details</h2>
                    <div class="form-group">
                        {{$userDetails->name}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->address}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->city}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->state}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->country}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->pincode}}
                    </div>
                    <div class="form-group">
                        {{$userDetails->mobile}}
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <h2></h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Shipping Details</h2>
                    <div class="form-group">
                        {{$shippingDetails->name}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->address}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->city}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->state}}
                    </div>
                    <div class="form-group">
                        <{{$shippingDetails->country}} </div>
                            <div class="form-group">
                                {{$shippingDetails->pincode}}
                            </div>
                            <div class="form-group">
                                {{$shippingDetails->mobile}}
                            </div>
                    </div>
                </div>
            </div> 
        </div>

        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description">Description</td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach($userCart as $cart)
                    @php $getCurrencyRates = Product::currencyRate ($cart->price); @endphp
                    <tr>
                        <td class="cart_product">
                            <a href="javascript:"><img style="width:200px;" src="{{ asset('images/backend_images/products/medium/'.$cart->image) }}" onclick="popupGambar(this)" alt=""></a>
                        </td>
                        <td class=" cart_description">
                                <h4>{{$cart->product_name}}</h4> <br>
                                <p>Code : {{$cart->product_code}}</p>
                                <p>Size : {{$cart->size}} </p>
                                <p>Color : {{$cart->product_color}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{$currencyLocale->currency_simbol.' '.is_number($getCurrencyRates,2)}}</p>
                        </td>
                        <td class="cart_quantity">
                            {{$cart->quantity}}
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{$currencyLocale->currency_simbol.' '.is_number(($getCurrencyRates * $cart->quantity),2)}}</p>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + $getCurrencyRates * $cart->quantity ?>
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>{{$currencyLocale->currency_simbol.' '.is_number($total_amount,2)}}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost(+)</td>
                                    <td>{{$currencyLocale->currency_simbol.' '.is_number($shippingCharges)}}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Discount Amount(-)</td>
                                    <td> 
                                        @if (!empty(Session::get('CouponAmount'))) 
                                        @php $currencyRateCoupponAmoun = Product::currencyRate (Session::get('CouponAmount')); @endphp
                                        @else
                                        @php $currencyRateCoupponAmoun = "0"; @endphp
                                       @endif
                                        {{$currencyLocale->currency_simbol.' '.is_number($currencyRateCoupponAmoun,2)}}
                                     </td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <td><span>{{$currencyLocale->currency_simbol.' '.is_number($grant_total = ($total_amount + $shippingCharges) - $currencyRateCoupponAmoun,2)}}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form action="{{url('/place-order')}}" method="post" id="paymentForm" name="paymentForm">{{csrf_field()}}
            <div class="payment-options">
                <input type="hidden" name="grant_total" id="grant_total" value="{{$grant_total}}">
                <span>
                    <label><b  @error('payment_method') class="is-invalid"  @enderror>Select Payment Method :</b></label>
                @error('payment_method')
                  <span class="invalid-feedback" role="alert">
                    <strong style="color: orangered; margin-left: -21px; margin-right: 17px;"> Please select method payment ! </strong>
                  </span>
                @enderror
                </span>
                @if($codPincodeCount > 0)
                <span>
                    <label><b><input type="radio" name="payment_method" id="COD" name="COD" value="COD">COD</b></label>
                </span>
                @endif
                @if($prepaidPincodeCount > 0)
                <span>
                    <label><b><input type="radio" name="payment_method" id="Paypal" name="Paypal" value="Paypal">Paypal</b></label>
                </span>
                @endif
                <span style="float:right;">
                    <button type="submit" class="btn btn-warning" onclick="selectPaymentMethod();">Place Order</button>
                </span>
            </div>
        </form>
    </div>
</section>
<!--/#cart_items-->

@endsection