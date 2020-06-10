@extends('layouts.adminLayout.admin_design')
@section('title')
Add Currencies | Admin Hsn E-commerce
@endsection

@section('content')

<div id="loading"></div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">Currencies</a>
     <a href="{{url('/admin/add-category')}}" class="current">Add Currency</a> </div>
    <h1>Currencies</h1>
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
            <h5>Add Currency</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/add-currencies')}}" name="add_currencies" id="add_currencies">
            {{csrf_field()}}
            <div class="control-group">
                <label class="control-label">Currency Name</label>
                <div class="controls">
                  <input type="text" name="currency_name" id="currency_name" value="{{old('currency_name')}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Currency Simbol</label>
                <div class="controls">
                  <input type="text" name="currency_simbol" id="currency_simbol" value="{{old('currency_simbol')}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Currency Code</label>
                <div class="controls">
                  <input type="text" name="currency_code" id="currency_code" value="{{old('currency_code')}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Exchange Rate</label>
                <div class="controls">
                  <input type="text" class="price-input" name="exchange_rate" id="exchange_rate" value="{{old('exchange_rate')}}" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Add Currency" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection