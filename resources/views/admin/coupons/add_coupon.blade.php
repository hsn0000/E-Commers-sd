@extends('layouts.adminLayout.admin_design')
@section('title')
Add Coupons | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.coupons')}}</a>
     <a href="#" class="current">{{__('backend.add_coupon')}} </a> </div>
    <h1>{{__('backend.coupons')}}</h1>

  </div>
  <div class="container-fluid"><hr> 
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>{{__('backend.add_coupon')}}</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ $module->permalink.'/add' }}" class="form-horizontal" id="form-table" method="post" autocomplete="off">
                {{csrf_field()}}
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.coupon_code')}}</label>
                    <div class="controls">
                      <input type="text" name="coupon_code" id="coupon_code" class="coupon_code" style=" width: 275px; @error('coupon_code') border-style: solid; border-color: orangered; @enderror ">
                        <div id="encode_coupon" style="display: contents; visibility: hidden;">
                          <input type="text" id="current_code" class="current_code" readonly style="margin-left: 10px; width: 275px;">
                          <a href="javascript:" class="btn btn-default current_code" id="btn_ok_bro" style="margin-left: 10px;">OK</a>
                        </div>
                      @error('coupon_code') {!! required_field($message) !!} @enderror
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label required">{{__('backend.amount_type')}}</label>
                    <div class="controls">
                      <select name="amount_type" id="amount_type" style=" width: 289px; @error('amount_type') border-style: solid; border-color: orangered; @enderror ">
                          <option value="null" selected="selected" > select data </option>
                          <option value="Persentage">{{__('backend.persentage')}}</option>
                          <option value="Fixed">{{__('backend.fixed')}}</option>
                      </select> 
                      @error('amount_type') {!! required_field($message) !!} @enderror
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label required">{{__('backend.amount')}}</label>
                    <div class="controls">
                      <input class="" type="text" name="amount" id="amount" min="" style=" width: 275px; @error('amount') border-style: solid; border-color: orangered; @enderror ">
                      @error('amount') {!! required_field($message) !!} @enderror
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label required">{{__('backend.expiry_date')}}</label> 
                    <div class="controls">
                    <input type="text" name="expiry_date" id="expiry_date" autocomplete="off" style=" width: 275px; @error('expiry_date') border-style: solid; border-color: orangered; @enderror "> 
                    @error('expiry_date') {!! required_field($message) !!} @enderror
                    </div>
                  </div>

                  <div class="control-group">
                    <div class="controls">
                        <label class="control-input-content"> Enable 
                            <div class="switch">
                                <input type="checkbox" name="status" id="status" value="1" class=" toggle-switch-primary" >
                                <span class="slider"></span>
                            </div>
                        </label>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
  
  <script>
  $(function(){

    $('#coupon_code').click(function() {
      $('#encode_coupon').attr('style','display: contents; visibility: visible;')
    })
    
    $('#coupon_code').keyup(function(e){
      var val = this.value

      if(val != '')
      {
        $.ajax({
               type: "post",
               url: '/coupons/admin/generate-coupons',
               data: {
                val: val
               },
               success:function(resp) {
                 if(resp)
                 {
                    $('#current_code').val(resp)
                    $('#btn_ok_bro').click(function() {
                      $('#coupon_code').val($('#current_code').val())
                      $('#encode_coupon').attr('style','display: contents; visibility: hidden;')
                    })
                 }
               },error:function(err) {
                   alert("error")
               }
           })
      }
      else
      {
        $('#current_code').val('')
      }

    })

    $('#amount_type').click(function()
    {

      if($('#amount_type').val() == 'Persentage')
      {
        // $('#amount').attr('maxlength',100.0)
        $('#amount').priceFormat({
          prefix: '',
          suffix: ' %',
          centsSeparator: '.',
          thousandsSeparator: ',',
          centsLimit: 1,
          maxlength: 100
        });

      } 
      else if ($('#amount_type').val() == 'Fixed')
      {
        $('#amount').priceFormat({
          prefix: 'Rp ',
          centsSeparator: '.',
          thousandsSeparator: ',',
          centsLimit:2
        });
      }
      else
      {
        $('#amount').val('please select amount type first !')
      }

    })




  })
  </script>

@endsection