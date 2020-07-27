@extends('layouts.adminLayout.admin_design')
@section('title')
Edit Currencies | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">Currencies</a>
     <a href="#" class="current">Edit Currency</a> </div>
    <h1>Currencies</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Edit Currency</h5>
            </div>
            <form class="form-horizontal" action="{{ $module->permalink.'/update' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
              @csrf
              <div class="widget-content nopadding">
                <div class="control-group">
                    <label class="control-label required">Currency Name</label>
                    <div class="controls">
                      <input type="text" name="currency_name" id="currency_name" value="{{old('currency_name') ?: $currencyDetail->currency_name}}"  style=" @error('currency_name') border-style: solid; border-color: orangered; @enderror ">
                      @error('currency_name') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">Currency Simbol</label>
                    <div class="controls">
                      <input type="text" name="currency_simbol" id="currency_simbol" value="{{old('currency_simbol') ?: $currencyDetail->currency_simbol}}"  style=" @error('currency_simbol') border-style: solid; border-color: orangered; @enderror ">
                      @error('currency_simbol') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">Currency Code</label>
                    <div class="controls">
                      <input type="text" name="currency_code" id="currency_code" value="{{old('currency_code')  ?: $currencyDetail->currency_code}}"  style=" @error('currency_code') border-style: solid; border-color: orangered; @enderror ">
                      @error('currency_code') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">Exchange Rate</label>
                    <div class="controls">
                      <input type="text" class="price-input-Rp" name="exchange_rate" id="exchange_rate" value="{{old('exchange_rate')  ?: $currencyDetail->exchange_rate}}"  style=" @error('exchange_rate') border-style: solid; border-color: orangered; @enderror ">
                      @error('exchange_rate') {!! required_field($message) !!} @enderror
                    </div>
                  </div>

                  <div class="control-group">
                    <div class="controls">
                      <label class="control-input-content"> {{__('backend.enable')}} 
                          <div class="switch">
                              <input type="checkbox" name="status" id="status" value="1" class="toggle-switch-checkbox toggle-switch-primary" @if($currencyDetail->status == 1) checked @endif>
                              <span class="slider round"></span>
                          </div>
                      </label>
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