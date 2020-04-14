@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="loading"></div>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
  @if(Session::has('flash_message_success'))
    <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="true" data-delay="7000"
        style="width: 400vw; position: fixed;z-index: 100; background: darkturquoise;color: white;">
        <div class="toast-header">
            <img src="{{url('okk.png')}}" width="50" class="rounded mr-2" alt="">
            <strong class="mr-auto">{{Session::get('flash_message_success')}}</strong>
            <small id="from"> </small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="par">
        </div>
    </div>
    @endif
@if(Session::has('flash_message_error'))
 <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/forb.png')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
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
        <li class="bg_lb"> <a href="{{url('/admin/dashboard')}}"> <i class="icon-dashboard"></i> <span class="label label-important">22</span> My Dashboard </a> </li>
        <li class="bg_lg span3"> <a href="#"> <i class="icon-signal"></i> Charts</a> </li>
        <li class="bg_ly"> <a href="#"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
        <li class="bg_lo"> <a href="#"> <i class="icon-th"></i> Tables</a> </li>
        <li class="bg_ls"> <a href="#"> <i class="icon-fullscreen"></i> Full width</a> </li>
        <li class="bg_lo span3"> <a href="#"> <i class="icon-th-list"></i> Forms</a> </li>
        <li class="bg_ls"> <a href="#"> <i class="icon-tint"></i> Buttons</a> </li>
        <li class="bg_lb"> <a href="#"> <i class="icon-pencil"></i>Elements</a> </li>
        <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li>
        <li class="bg_lr"> <a href="#"> <i class="icon-info-sign"></i> Error</a> </li>

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

