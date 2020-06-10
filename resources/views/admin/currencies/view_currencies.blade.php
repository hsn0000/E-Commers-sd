@extends('layouts.adminLayout.admin_design')
@section('title')
View Currencies | Admin Hsn E-commerce
@endsection

@section('content')

@php
 use Carbon\Carbon; 
@endphp

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">Currencies</a>
     <a href="{{url('/admin/view-categories')}}" class="current">View Currencies</a> </div>
    <h1>Currencies</h1>
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
            <h5>View Currencies</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>{{__('backend.category_id')}}</th>
                  <th>Currency Name</th>
                  <th>Currency Simbol</th>
                  <th>Currency Code</th>
                  <th>Exchange Rate</th>
                  <th>{{__('backend.status')}}</th>
                  <th>{{__('backend.created_at')}}</th>
                  <th>{{__('backend.actions')}}</th>
                </tr>
              </thead>exchange_rate
              <tbody>
                  @foreach($currencies as $currency)
                <tr class="gradeX">
                  <td>{{$currency->id}}</td>
                  <td>{{$currency->currency_name}}</td>
                  <td>{{$currency->currency_simbol}}</td>
                  <td>{{$currency->currency_code}}</td>
                  <td>{{is_number($currency->exchange_rate,2)}}</td>
                  <td style="text-align:center;"> @if($currency->status==1)<span class="badge badge-success">{{__('backend.active')}}</span>@else <span class="badge badge-danger" style="background-color:Crimson;">{{__('backend.inactive')}}</span>@endif</td>
                  <td style="text-align:center;">{{Carbon::parse($currency->created_at)->format('l, j F Y | H:i')}}</td>
                  <td style="text-align:center;" class="center" width="25%">
                   <a href="{{url('/admin/edit-currencies/'.$currency->id)}}" class="btn btn-warning btn-mini" style="margin:0 12px 0 0"><i class="icon-cogs" style="padding:0 4px"></i>{{__('backend.edit')}}</a> 
                   <a rel="{{$currency->id}}" rel1="delete-currencies" rel2="{{$currency->currency_name}}" href="javascript:" class=" btn btn-danger btn-mini" onclick='deleteThis(this)' style="margin:0 0 0 9px"><i class="icon-trash" style="padding: 0 5px"></i>{{__('backend.delete')}}</a>
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