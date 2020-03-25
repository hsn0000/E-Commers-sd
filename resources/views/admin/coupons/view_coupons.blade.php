@extends('layouts.adminLayout.admin_design')

@section('content')
@php
use Carbon\Carbon
@endphp
<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.coupons')}}</a>
     <a href="{{url('/admin/view-coupon')}}" class="current">{{__('backend.view_coupon')}}</a> </div>
    <h1>{{__('backend.coupons')}}</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong>  {{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block" style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert" >x</button>	
            <strong>  {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
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
            <h5>{{__('backend.view_coupon')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="font-size:100%;">{{__('backend.no')}}</th>
                  <th style="font-size:100%;">{{__('backend.coupon_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.coupon_code')}}</th>
                  <th style="font-size:100%;">{{__('backend.amount')}}</th>
                  <th style="font-size:100%;">{{__('backend.amount_type')}}</th>
                  <th style="font-size:100%;">{{__('backend.expiry_date')}}</th>
                  <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                  <th style="font-size:100%;">{{__('backend.status')}}</th>
                  <th style="font-size:100%;">{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>
                  <?php $no = 0; ?>
                  @foreach($coupons as $coupon)
                <tr class="gradeX">
                  <td style="text-align:center;">{{++$no}}</td>
                  <td style="text-align:center;">{{$coupon->id}}</td>
                  <td style="text-align:center;">{{$coupon->coupon_code}}</td>
                  <td style="text-align:center;"> @if($coupon->amount_type == "Persentage") {{$coupon->amount}} % @else Rp {{is_number($coupon->amount,2)}} @endif</td>
                  <td style="text-align:center;">{{$coupon->amount_type}}</td>
                  <td style="text-align:center;">{{$coupon->expiry_date}}</td>
                  <td style="text-align:center;">{{Carbon::parse($coupon->created_at)->format('l, j F Y | H:i')}}</td>
                  <td style="text-align:center;"> @if($coupon->status==1)<span class="badge badge-success">{{__('backend.active')}}</span>@else <span class="badge badge-danger" style="background-color:Crimson;">{{__('backend.inactive')}}</span>@endif</td>
                  <td class="center" style="text-align:center;" width="18%;">
                    <a href="{{url('/admin/edit-coupon/'.$coupon->id)}} " class="btn btn-warning btn-mini" style="margin:30px 0 0 10px;" title="{{__('backend.edit')}}"> <i class="icon-cogs" style="padding:0 4px"></i> {{__('backend.edit')}}</a> 
                    <a rel="{{$coupon->id}}" rel1="delete-coupon" rel2="{{$coupon->coupon_code}}" href="javascript:" onclick="deleteProdt(this)" class="btn btn-danger btn-mini" style="margin:30px 0 0 10px;" title="{{__('backend.delete')}}"> 
                      <i class="icon-trash" style="padding: 0 5px"></i>{{__('backend.delete')}}</a>
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
  

@endsection