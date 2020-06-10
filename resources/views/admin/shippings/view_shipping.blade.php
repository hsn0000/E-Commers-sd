@extends('layouts.adminLayout.admin_design')

@section('title')
View Shipping | Admin Hsn E-commerce
@endsection

@section('content')

@php
 use Carbon\Carbon; 
@endphp

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">Shipping</a>
     <a href="{{url('/admin/view-categories')}}" class="current">View Shipping</a> </div>
    <h1>Shipping Charges</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Shipping Charges</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Country Code</th>
                  <th>Country</th>
                  <th>Shipping Charges</th>
                  <th>0g to 500g</th>
                  <th>5001g to 1000g/th>
                  <th>1001g to 2000g</th>
                  <th>2001g to 5000g</th>
                  <th>Updated at</th>
                  <th >{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($shipping_charge as $shipping)
                <tr class="gradeX">
                  <td>{{$shipping->id}}</td>
                  <td>{{$shipping->country_code}}</td>
                  <td>{{$shipping->country}}</td>
                  <td>Rp {{is_number($shipping->shipping_charges)}}</td>
                  <td>{{$shipping->shipping_charges0_500g}} g</td>
                  <td>{{$shipping->shipping_charges501_1000g}} g</td>
                  <td>{{$shipping->shipping_charges1001_2000g}} g</td>
                  <td>{{$shipping->shipping_charges2001_5000g}} g</td>
                  <td style="text-align:center;">{{Carbon::parse($shipping->updated_at)->format('l, j F Y | H:i')}}</td>       
                  <td style="text-align:center;" class="center" width="">
                    <a href="{{url('/admin/edit-shipping/'.$shipping->id)}}" class="btn btn-warning btn-mini"><i class="icon-cogs" style="padding:0 4px"></i>{{__('backend.edit')}}</a> 
                 </td>
                </tr>
                 @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection