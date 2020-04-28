@extends('layouts.adminLayout.admin_design')

@section('content')

@php 
use App\Product;
 $categoriesTotal = Product::categoriesTotal();
 $productTotal = Product::productTotal();
 $orderTotal = Product::orderTotal();
 $usersTotal = Product::usersTotal();
@endphp


<div id="loading"></div>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
@if(Session::has('flash_message_success')) 
  <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item" style="background: lightseagreen;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/done.png')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Is Permitted ! </b></span>
             <p><b> {{Session::get('flash_message_success')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
  </div>
@endif 
@if(Session::has('flash_message_error')) 
 <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item"  style="background: red;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/fail.jpg')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Forbidden ! </b></span>
             <p><b> {{Session::get('flash_message_error')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
  </div>
@endif

    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lb"> <a href="{{url('/admin/dashboard')}}"> <i class="icon-dashboard"></i> <span class="label label-important">~</span> My Dashboard </a> </li>

        @if(Session::get('adminDetails')['categories_view_access'] == 1)
        <li class="bg_ly"> <a href="{{url('/admin/view-categories')}}"> <i class="icon icon-th-list"></i><span class="label label-success">{{$categoriesTotal}}</span> Categories </a> </li>
        @endif
        @if(Session::get('adminDetails')['products_access'] == 1)
        <li class="bg_lo"> <a href="{{url('/admin/view-product')}}"> <i class="icon icon-book"></i><span class="label label-success">{{$productTotal}}</span> Products</a> </li>
        @endif
        @if(Session::get('adminDetails')['order_access'] == 1)
        <li class="bg_ls"> <a href="{{url('/admin/view-orders')}}"> <i class="icon icon-shopping-cart"></i><span class="label label-success">{{$orderTotal}}</span> Orders </a> </li>
        @endif
        @if(Session::get('adminDetails')['users_access'] == 1)
        <li class="bg_lr"> <a href="{{url('/admin/view-users')}}"> <i class="icon icon-user"></i><span class="label label-success">{{$usersTotal}}</span> Users </a> </li>
        @endif

        <!-- <li class="bg_lg span3"> <a href="#"> <i class="icon-signal"></i> Charts</a> </li>
        <li class="bg_ly"> <a href="#"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
        <li class="bg_lo"> <a href="#"> <i class="icon-th"></i> Tables</a> </li>
        <li class="bg_ls"> <a href="#"> <i class="icon-fullscreen"></i> Full width</a> </li>
        <li class="bg_lo span3"> <a href="#"> <i class="icon-th-list"></i> Forms</a> </li>
        <li class="bg_ls"> <a href="#"> <i class="icon-tint"></i> Buttons</a> </li>
        <li class="bg_lb"> <a href="#"> <i class="icon-pencil"></i>Elements</a> </li>
        <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li> 
        <li class="bg_lr"> <a href="#"> <i class="icon-info-sign"></i> Error</a> </li> -->

      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Site Analytics</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span9">
              <div class="chart"></div>
            </div>
            <div class="span3">
              <ul class="site-stats">
                <li class="bg_lh"><i class="icon-user"></i> <strong>2540</strong> <small>Total Users</small></li>
                <li class="bg_lh"><i class="icon-plus"></i> <strong>120</strong> <small>New Users </small></li>
                <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>656</strong> <small>Total Shop</small></li>
                <li class="bg_lh"><i class="icon-tag"></i> <strong>9540</strong> <small>Total Orders</small></li>
                <li class="bg_lh"><i class="icon-repeat"></i> <strong>10</strong> <small>Pending Orders</small></li>
                <li class="bg_lh"><i class="icon-globe"></i> <strong>8540</strong> <small>Online Orders</small></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box--> 
    <hr/>
  </div>
</div>

<!--end-main-container-part-->

@endsection

