@extends('layouts.adminLayout.admin_design')
@section('title')
Add Coupons | Admin Hsn E-commerce
@endsection

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.coupons')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.add_coupon')}} </a> </div>
    <h1>{{__('backend.coupons')}}</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong>{{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block" style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert" >x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_success'))}}</strong>
        </div>
    @endif
  </div>
  <div id="loading"></div>
  <div class="container-fluid"><hr> 
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_coupon')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/add-coupon')}}" name="add_coupon" id="add_coupon">
            {{csrf_field()}}
        
              <div class="control-group">
                <label class="control-label">{{__('backend.coupon_code')}}</label>
                <div class="controls">
                  <input type="text" name="coupon_code" id="product_name" maxlength="15" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.amount')}}</label>
                <div class="controls">
                  <input class="price-input-Rp" type="text" name="amount" id="amount" min="1" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.amount_type')}}</label>
                <div class="controls">
                   <select name="amount_type" id="amount_type" style="width:220px;">
                     <option value="Persentage">{{__('backend.persentage')}}</option>
                     <option value="Fixed">{{__('backend.fixed')}}</option>
                   </select> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.expiry_date')}}</label> 
                <div class="controls">
                 <input type="text" name="expiry_date" id="expiry_date" autocomplete="off" required> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                  </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="{{__('backend.add_coupon')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection