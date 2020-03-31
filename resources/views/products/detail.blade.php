@extends('layouts.frontLayout.front_design')

@section('content')

@php
 use App\Product;
  $currencyLocale = Session::get('currencyLocale');
  $getCurrencyRates = Product::currencyRate ($productDetails->price);
@endphp

	@if(Session::has('flash_message_error'))
	 <div class="alert alert-dark alert-block" style="width:18%; margin-left:55%; background-color:Tomato; color:white">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong> {{Session::get('flash_message_error')}}</strong>
		</div>
	@endif  
	@if(Session::has('flash_message_success'))
		<div class="alert alert-dark alert-block" style="width:18%; margin-left:55%; background-color:green; color:white">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong> {{Session::get('flash_message_success')}}</strong>
		</div>
	@endif
	<div id="loading"></div>
    <section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					@include('layouts.frontLayout.front_sidebar')
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details" style="padding-bottom:20px;"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
							  <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
							    <a href="{{ asset('images/backend_images/products/large/'.$productDetails->image)}}">
							    	<img style="width:335px;" class="mainImage" src="{{ asset('images/backend_images/products/medium/'.$productDetails->image)}}" alt=""/>
								</a>
							  </div>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="active thumbnails" style="width:100%;">
										@foreach($productAltImage as $altImage)
										 <a href="{{ asset('images/backend_images/products/large/'.$altImage->image)}}" data-standard="{{ asset('/images/backend_images/products/small/'.$altImage->image)}}">
										   <img class="changeImage" style="width:106px; cursor:pointer; " src="{{ asset('/images/backend_images/products/small/'.$altImage->image)}}" alt="">
									     </a>
										  @endforeach
									  </div>		
								 </div>
							</div>

						</div> 
						<div class="col-sm-7">
							<form action="{{url('/admin/add-cart')}}" method="post" name="addtocartForm" id="addtocartForm"> {{csrf_field()}}
								<input type="hidden" name="product_id" value="{{$productDetails->id}}">
								<input type="hidden" name="product_name" value="{{$productDetails->product_name}}">
								<input type="hidden" name="product_code" value="{{$productDetails->product_code}}">
								<input type="hidden" name="product_color" value="{{$productDetails->product_color}}">
								<input type="hidden" name="price" id="price" value="{{$productDetails->price}}">

								<div class="product-information"><!--/product-information-->
									<img src="" class="newarrival" alt="" />
									<h2>{{$productDetails->product_name}}</h2>
									<p>CODE: {{$productDetails->product_code}}</p>
									<p>
										<select name="size" id="selSize" style="width:150px;" required >
										<option value="">Select Size</option>
											@foreach($productDetails->attributes as $sizes)
											<option value="{{$productDetails->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
											@endforeach
										</select>
									</p>
									<img src="{{asset('images/frontend_images/product-details/rating.png')}}" alt="" />
									<span>
										<span id="getPrice" style="width:129px;"> {{$currencyLocale->currency_simbol.' '.is_number($getCurrencyRates,2)}}</span> <br> <br> <br> <br>
										<label>Quantity :</label>
										<input class="is-valid" type="number" name="quantity" value="1" required type="number" min="1" max="100"/>
										@if($total_stock > 0)
										<button type="submit" class="btn btn-fefault cart" id="cartButton">
											<i class="fa fa-shopping-cart"></i>
											Add to cart
										</button>
										@endif
									</span>
									<p><b>Availability :</b> @if($total_stock > 0) <span style="color:green;" id="Availability"><b>In Stock</b></span> @else <span style="color:red;" id="outAvailability"><b>Out Of Stock</b></span> @endif</p>
									<p><b>Condition : <span style="color:orange;">New</span></b> </p>
									<p><b>Delivery :</b>
									<input type="text" name="pincode" class="" id="chkPincode" placeholder="Check Pincode" required>
									<button type="button" class="" onclick=" return checkPincode()">Go</button>
									</p>
									<p id="pincodeResponse"></p>
									<a href="javascript:"><img src="https://images.vexels.com/media/users/3/136817/isolated/preview/c31f80ee80f25dddba49957fe5339e27-share-icon-outline-by-vexels.png" class="share img-responsive" width="42px" alt=""/></a>
								</div><!--/product-information-->
							</form>
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
							   <li class="active"><a href="#reviews" data-toggle="tab">Review</a></li>
								<li><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Material & Care</a></li>
								<li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
								<li><a href="#video" data-toggle="tab">Product Video</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="description" >
							    <div class="col-sm-12">
									<p>{{$productDetails->description}}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="care" >
							    <div class="col-sm-12">
									<p>{{$productDetails->care}}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="delivery" >
							    <div class="col-sm-12">
									<p>100% Original Product <br>
								       Cash on delivery</p>
								</div>
							</div>

							<div class="tab-pane fade" id="video" >
							    <div class="col-sm-12">
								 @if($productDetails->video)
								    <video src="{{asset('videos/'.$productDetails->video)}}" width="100%" controls> </video>
								  @else
								    <img src="{{asset('images/video-thumbnail.png')}}" width="100%" controls alt="alt-video-thumbnail" >
								  @endif
								</div>
							</div>
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									<p><b>Write Your Review</b></p>
									
									<form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
										<textarea name="" ></textarea>
										<b>Rating: </b> <img src="{{asset('images/frontend_images/product-details/rating.png')}}" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Submit
										</button>
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php $count=1; ?>
								@foreach($relatedProduct->chunk(3) as $chunk)
								<div <?php if($count==1) { ?> class="item active" <?php } else { ?> class="item" <?php } ?>>	
									@foreach($chunk as $item)
									@php $getCurrencyRates = Product::currencyRate ($item->price); @endphp
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img style="width:220px; margin-left:25px;" src="{{ asset('/images/backend_images/products/medium/'.$item->image)}}" alt="" />
													<h2> {{$currencyLocale->currency_simbol.' '.is_number($getCurrencyRates,2)}}</h2>
													<p>{{$item->product_name}}</p>
													<a href="{{$item->id}}">
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
													</a>
												</div>
											</div>
										</div>
									</div>
								@endforeach
								</div>
								<?php $count++; ?>
							    @endforeach
								
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>


@endsection