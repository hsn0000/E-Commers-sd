@extends('layouts.adminLayout.admin_design')
@section('title')
Edit Shipping | Admin Hsn E-commerce
@endsection
@section('content')

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">Shipping</a>
     <a href="#" class="current">Edit Shipping</a> </div>
    <h1>Shipping</h1>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Edit Shipping Charges</h5>
            </div>
            <form class="form-horizontal" action="{{ $module->permalink.'/update' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
              {{csrf_field()}}
              <div class="widget-content nopadding">
                <input type="hidden" name="id" id="id" value="{{$shippingDetails->id}}" >
                <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;">Country</label>
                    <div class="controls">
                      <input type="text" name="country" id="country" value="{{old('country') ?? $shippingDetails->country}}"  style=" @error('country') border-style: solid; border-color: orangered; @enderror ">
                      @error('country') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;">Country Code</label>
                    <div class="controls">
                      <input type="text" name="country_code" id="country_code" value="{{old('country_code')  ?? $shippingDetails->country_code}}"  style=" @error('country_code') border-style: solid; border-color: orangered; @enderror ">
                      @error('country_code') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;"> Charges </label>
                    <div class="controls">
                      <input type="text" class="price-input-Rp" name="shipping_charges" id="shipping_charges" value="{{old('shipping_charges')  ?? 'Rp'.is_number($shippingDetails->shipping_charges,2)}}"  style=" @error('shipping_charges') border-style: solid; border-color: orangered; @enderror ">
                      @error('shipping_charges') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;"> Charges (0g - 500g)</label>
                    <div class="controls">
                      <input type="text" class="numeric" name="shipping_charges0_500g" id="shipping_charges0_500g" value="{{old('shipping_charges0_500g')  ?? $shippingDetails->shipping_charges0_500g}}"  style=" @error('shipping_charges0_500g') border-style: solid; border-color: orangered; @enderror ">
                      @error('shipping_charges0_500g') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;"> Charges (501g - 1000g)</label>
                    <div class="controls">
                      <input type="text" class="numeric" name="shipping_charges501_1000g" id="shipping_charges501_1000g" value="{{old('shipping_charges501_1000g')  ?? $shippingDetails->shipping_charges501_1000g}}"  style=" @error('shipping_charges501_1000g') border-style: solid; border-color: orangered; @enderror ">
                      @error('shipping_charges501_1000g') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;"> Charges (1001g - 2000g)</label>
                    <div class="controls">
                      <input type="text" class="numeric" name="shipping_charges1001_2000g" id="shipping_charges1001_2000g" value="{{old('shipping_charges1001_2000g')  ?? $shippingDetails->shipping_charges1001_2000g}}"  style=" @error('shipping_charges1001_2000g') border-style: solid; border-color: orangered; @enderror ">
                      @error('shipping_charges1001_2000g') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required" style="width: 11vw; margin-right: 17px;"> Charges (2001g - 5000g)</label>
                    <div class="controls">
                      <input type="text" class="numeric" name="shipping_charges2001_5000g" id="shipping_charges2001_5000g" value="{{old('shipping_charges2001_5000g')  ?? $shippingDetails->shipping_charges2001_5000g}}"  style=" @error('shipping_charges2001_5000g') border-style: solid; border-color: orangered; @enderror ">
                      @error('shipping_charges2001_5000g') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <hr>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection