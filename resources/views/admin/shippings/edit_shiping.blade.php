@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="loading"></div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">Shipping</a>
     <a href="{{url('/admin/add-category')}}" class="current">Edit Shipping</a> </div>
    <h1>Shipping</h1>
    @if(Session::has('flash_message_error'))
    <div class="alert alert-dark alert-block"
        style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
    </div>
    @endif
    @if(Session::has('flash_message_drop'))
    <div class="alert alert-success alert-block"
        style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
    </div>
    @endif
    @if(Session::has('flash_message_success'))
    <div class="alert alert-dark alert-block"
        style="background-color:forestgreen; color:white; width:21%; margin-left:20px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{__('backend.'.Session::get('flash_message_success'))}}</strong>
    </div>
    @endif
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Shipping Charges</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/edit-shipping/'.$shippingDetails->id)}}" name="edit_shipping" id="edit_shipping">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id" value="{{$shippingDetails->id}}" >
            <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Country</label>
                <div class="controls">
                  <input type="text" name="country" id="country" value="{{old('country') ?? $shippingDetails->country}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Country Code</label>
                <div class="controls">
                  <input type="text" name="country_code" id="country_code" value="{{old('country_code')  ?? $shippingDetails->country_code}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Shipping Charges </label>
                <div class="controls">
                  <input type="text" class="price-input" name="shipping_charges" id="shipping_charges" value="{{old('shipping_charges')  ?? 'Rp'.is_number($shippingDetails->shipping_charges,2)}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Shipping Charges (0g - 500g)</label>
                <div class="controls">
                  <input type="number" class="" name="shipping_charges0_500g" id="shipping_charges0_500g" value="{{old('shipping_charges0_500g')  ?? $shippingDetails->shipping_charges0_500g}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Shipping Charges (501g - 1000g)</label>
                <div class="controls">
                  <input type="number" class="" name="shipping_charges501_1000g" id="shipping_charges501_1000g" value="{{old('shipping_charges501_1000g')  ?? $shippingDetails->shipping_charges501_1000g}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Shipping Charges (1001g - 2000g)</label>
                <div class="controls">
                  <input type="number" class="" name="shipping_charges1001_2000g" id="shipping_charges1001_2000g" value="{{old('shipping_charges1001_2000g')  ?? $shippingDetails->shipping_charges1001_2000g}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" style="width: 11vw; margin-right: 17px;">Shipping Charges (2001g - 5000g)</label>
                <div class="controls">
                  <input type="number" class="" name="shipping_charges2001_5000g" id="shipping_charges2001_5000g" value="{{old('shipping_charges2001_5000g')  ?? $shippingDetails->shipping_charges2001_5000g}}" required>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit Shipping" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection