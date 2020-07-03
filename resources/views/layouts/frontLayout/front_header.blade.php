@php 
 use App\Http\Controllers\Controller;
 use App\Product;
 use Carbon\Carbon;
    $cartCount = Product::cartCount();
    $notifycationMsg = Product::notifycationMsg();
    $notifycationMsgCount = Product::notifycationMsgCount();
    $userWislishCount = Product::userWislishCount();
    $mainCategories = Controller::mainCategories(); 
@endphp 

<header id="header">
    <!--header-->
    <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +628 0188 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@ecommerce.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header_top--> 

    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{url('./')}}"><img src="{{asset('images/frontend_images/home/logo2.jpeg') }}"alt="" /></a>
                    </div>
                    <div class="btn-group pull-right"> 
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">@if (Session::get('applocale') == "id") Indonesia @elseif (Session::get('applocale') == "en")  US  @elseif (Session::get('applocale') == "khmer") Kambodia @else Indonesia @endif <span class="caret"></span> </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('/language/id')}}">Indonesia</a></li>
                                <li><a href="{{url('/language/en')}}">US</a></li>
                                <li><a href="{{url('/language/khmer')}}">Kambodia</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown"> @if (Session::get('applocale') == "id") Rupiah @elseif (Session::get('applocale') == "en") Dollar US  @elseif (Session::get('applocale') == "khmer") Real Khme @else Rupiah @endif  <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Rupiah</a></li>
                                <li><a href="#">Dollar US</a></li>
                                <li><a href="#">Real Khmer</a></li>
                            </ul>
                        </div>
                        @if(!empty(Auth::check()))
                        <div class="btn-group">
                               <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown" id="{{'ntpCount'.Auth::id() }}" > <i class="fas fa-bell"> @if($notifycationMsgCount != 0)&nbsp; <span style="color:crimson;">( <span class="ntp_count_class"> {{$notifycationMsgCount}} </span> )</span> @endif</i></button>
                            @if(count($notifycationMsg) > 0)
                            <ul class="dropdown-menu" id="ntp_header_messsage" style="overflow-y: scroll; max-height: 15vw; height: auto;">
                            @foreach($notifycationMsg as $key => $notyMsg)
                                <li class="list_ntp_header_messsage">
                                @if($notyMsg->is_read == 0) <span class="badge badge-pill" style=" position: absolute; background: indianred; margin-left: 2px;">!</span> @else <span> </span> @endif
                                  <a href="javascript:" onclick='clickNotMsg({{"' $notyMsg->from.$notyMsg->to '"}})' > <b style="margin-left: 1px;">{{$notyMsg->title}}</b> <span> | {{$notyMsg->name}}</span> | <span style="font-size: small; font-style: italic;">{{Carbon::parse($notyMsg->created_at)->format('j F Y')}}</span></a>
                                  <hr style="margin: 4px 19px; padding: 0;">
                                </li>
                            @endforeach
                            </ul>
                            @endif
                        </div> 
                        @endif
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ url('/wish-list')}}"<?php  if(preg_match("/wish-list/i", $url)) { ?> class="active" <?php } ?> ><i class="fa fa-star"></i>{{__('frontend.wishlist')}} @if(!empty($userWislishCount)) (<span style="color:chocolate">{{ $userWislishCount }}</span>) @endif</a></li>
                            <li><a href="{{url('/orders')}}" <?php  if(preg_match("/orders/i", $url)) { ?> class="active" <?php } ?> ><i class="fa fa-crosshairs" aria-hidden="true"></i>
                            {{__('frontend.orders')}}</a></li>
                            <li><a href="{{url('/cart')}}" class="enter_link <?php  if(preg_match("/cart/i", $url)) { ?> active <?php } ?>"><i class="fa fa-shopping-cart"></i>Cart @if(!empty($cartCount)) (<span style="color:chocolate">{{ $cartCount }}</span>) @endif</a></li>
                            @if(empty(Auth::check()))
                            <li><a href="{{url('/login-register')}}" <?php  if(preg_match("/login-register/i", $url)) { ?> class="active" <?php } ?>><i class="fa fa-lock"></i>{{__('frontend.login')}}</a></li>
                            @else
                            <li><a href="{{url('/account')}}" <?php  if(preg_match("/account/i", $url)) { ?> class="active" <?php } ?>><i class="fa fa-user"></i> {{__('frontend.account')}}</a></li>
                            <li><a href="{{url('/user-logout')}}" <?php  if(preg_match("/user-logout/i", $url)) { ?> class="active" <?php } ?>><i class="fa fa-sign-out"></i> {{__('frontend.logout')}}</a></li>
                            @endif
                        </>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->
    <div class="header-bottom">
        <!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar">p</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{url('/')}}" @foreach(config('customeArr.link') as $links) @if($url == "$links") class="active" @endif @endforeach >{{__('frontend.home')}}</a></li>
                            <li class="dropdown"><a href="#" <?php  if(preg_match("/products/i", $url)) { ?> class="active" <?php } ?>>{{__('frontend.shop')}}<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach($mainCategories as $cat)
                                    @if($cat->status == "1")
                                    <li><a href="{{'/products/'.$cat->url}}">{{$cat->name}}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="#">Blog List</a></li>
                                    <li><a href="#">Blog Single</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#" <?php if(preg_match("/contact/i", $url)) { ?> class="active" <?php } ?> <?php if(preg_match("/front-messages/i", $url)) { ?> class="active" <?php } ?> >Contact<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{url('front-messages')}}" <?php if(preg_match("/front-messages/i", $url)) { ?> class="active" <?php } ?> >Message</a></li>
                                    <li><a href="{{url('/pages/contact')}}" <?php  if(preg_match("/contact/i", $url)) { ?> class="active" <?php } ?>> Contact Us </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <form action="{{url('/search-products')}}" method="post"> {{csrf_field()}}
                            <input type="text" placeholder="{{__('frontend.search_product')}}" name="product" required />
                            <button type="submit" class="btn btn-info">{{__('frontend.search')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
</header>
<!--/header-->