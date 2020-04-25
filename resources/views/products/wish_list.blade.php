@extends('layouts.frontLayout.front_design')
@section('content')

@php
 use App\Product;
  $userWislishCount = Product::userWislishCount();
  $currencyLocale = Session::get('currencyLocale');
@endphp

<section id="cart_items"> <!-- #wish_list_items --> 
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Wish List</li>
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
          @if(!empty($userWislishCount))
        <div class="table-responsive cart_info" style="width: 118%;">
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
                    @foreach($userWishList as $wishlist )
                    <?php  ?>
                    @php 
                        $product_price = Product::getProductPrice($wishlist->product_id, $wishlist->size);
                        $getCurrencyRates = Product::currencyRate ($product_price); 
                    @endphp
                    <tr>
                        <td class="cart_product">
                            <a href="{{url('/product/'.$wishlist->product_id)}}"><img style="width:200px;" src="{{ asset('images/backend_images/products/medium/'.$wishlist->image) }}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4>{{$wishlist->product_name}}</h4> <br>
                            <p>Code : {{$wishlist->product_code}}</p>
                            <p>Size : {{$wishlist->size}}</p>
                            <p>Color : {{$wishlist->product_color}}</p>
                        </td>
                        <td class="cart_price">
                            <p> {{$currencyLocale->currency_simbol.' '.is_number($getCurrencyRates,2)}}</p>
                        </td>
                        <td class="cart_quantity">
                            <p style="text-align: center;">{{$wishlist->quantity}}</p>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{$currencyLocale->currency_simbol.' '.is_number($getCurrencyRates * $wishlist->quantity,2)}}</p>
                        </td>
                        <td class="cart_delete">
                          <form action="{{url('/admin/add-cart')}}" method="post" name="addtocartForm" id="addtocartForm"> {{csrf_field()}}
                            <input type="hidden" name="product_id" value="{{$wishlist->product_id}}">
                            <input type="hidden" name="product_name" value="{{$wishlist->product_name}}">
                            <input type="hidden" name="product_code" value="{{$wishlist->product_code}}">
                            <input type="hidden" name="product_color" value="{{$wishlist->product_color}}">
                            <input type="hidden" name="size" value="{{$wishlist->id}}-{{$wishlist->size}}">
                            <input type="hidden" name="price" id="price" value="{{$wishlist->price}}">
                            <button type="submit" id="cartButtom" name="cartButtom" value="Add to Cart" class="btn btn-warning" href="{{url('/cart/delete-product-cart/'.$wishlist->id)}}" style="margin-right: 13px;"><i class="fa fa-shopping-cart"></i>&nbsp; Add to cart</button>
                            <a class="btn" href="{{url('/wish-list/delete-product/'.$wishlist->id)}}"><i class="fa fa-times"></i></a>
                          </form>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + ($getCurrencyRates * $wishlist->quantity); ?>
                    @endforeach
                </tbody>
            </table>
        </div>
          @else 
          <div class="emptyItem" style="">
              <span class="empty">The Item Is Still Empty !</span>
          </div>
          @endif
    </div>
</section> <!--/#wish_list_items-->

@endsection