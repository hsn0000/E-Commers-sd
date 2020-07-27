@extends('layouts.adminLayout.admin_design')
@section('title')
View Coupons | Admin Hsn E-commerce
@endsection

@section('content')
@php
use Carbon\Carbon
@endphp

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.coupons')}}</a>
     <a href="#" class="current">{{__('backend.view_coupon')}}</a> </div>
    <h1>{{__('backend.coupons')}}</h1>

  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>{{__('backend.view_coupon')}}</h5>
            </div>
            <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
              @csrf
              <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                    <th>
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i> </a>
                      @else
                          #
                      @endif
                      <th style="font-size:100%;">{{__('backend.coupon_code')}}</th>
                      <th style="font-size:100%;">{{__('backend.amount')}}</th>
                      <th style="font-size:100%;">{{__('backend.amount_type')}}</th>
                      <th style="font-size:100%;"> Status is used</th>
                      <th style="font-size:100%;">{{__('backend.expiry_date')}}</th>
                      <th style="font-size:100%;">{{__('backend.status')}}</th>
                      <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $no = 0; ?>
                      @foreach($coupons as $coupon)
                    <tr class="gradeX">
                      <th scope="row" style="text-align:center;">
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$coupon->id }}" name="data_id[{{ $coupon->id}}]" onclick="checkInputValue(this)">
                              <label class="custom-control-label" for="{{ 'child-'.$coupon->id }} "></label>
                          </div>
                      @else
                          {{ ++$key }}
                      @endif
                      </th>
                      <td class="center" >{{$coupon->coupon_code}}</td>
                      <td class="center" > @if($coupon->amount_type == "Persentage") {{$coupon->amount}} % @else Rp {{is_number($coupon->amount,2)}} @endif</td>
                      <td class="center" >{{$coupon->amount_type}}</td>
                    
                      <td class="center" > 
                        @if($coupon->in_use == 1)
                          <span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> already </span>
                        @else
                          <span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> not yet </span>
                        @endif
                      </td>
                    
                      <td class="center" >{{Carbon::parse($coupon->expiry_date)->format('l, j F Y')}}</td>

                      <td class="center" > 
                        @if($coupon->status==1)
                          <span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> {{__('backend.yes')}} </span>
                        @else
                          <span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> {{__('backend.now')}} </span>
                        @endif
                      </td>
                      <td class="center" >{{Carbon::parse($coupon->created_at)->format('l, j F Y | H:i')}}</td>

                      {{-- 
                      <td class="center" width="18%;">
                        <a href="{{url('/admin/edit-coupon/'.$coupon->id)}} " class="btn btn-warning btn-mini" style="margin:30px 0 0 10px;" title="{{__('backend.edit')}}"> <i class="icon-cogs" style="padding:0 4px"></i> {{__('backend.edit')}}</a> 
                        <a rel="{{$coupon->id}}" rel1="delete-coupon" rel2="{{$coupon->coupon_code}}" href="javascript:" onclick="deleteProdt(this)" class="btn btn-danger btn-mini" style="margin:30px 0 0 10px;" title="{{__('backend.delete')}}"> 
                          <i class="icon-trash" style="padding: 0 5px"></i>{{__('backend.delete')}}</a>
                      </td>
                    --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
  

@endsection