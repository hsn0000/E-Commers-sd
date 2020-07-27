@extends('layouts.adminLayout.admin_design')
@section('title')
View Currencies | Admin Hsn E-commerce
@endsection

@section('content')

@php
 use Carbon\Carbon; 
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
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">Currencies</a>
     <a href="#" class="current">View Currencies</a> </div>
    <h1>Currencies</h1>

  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Currencies</h5>
            </div>
            <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
              @csrf
              <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                      <th>
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i>
                          </a>
                      @else
                          #
                      @endif
                      </th>
                      <th>Currency Name</th>
                      <th>Currency Simbol</th>
                      <th>Currency Code</th>
                      <th>Exchange Rate</th>
                      <th>{{__('backend.status')}}</th>
                      <th>{{__('backend.created_at')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $no = 0;
                    @endphp
                    @foreach($currencies as $currency)
                    <tr class="gradeX">
                      <th scope="row" class="center">
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$currency->id }}" name="data_id[{{ $currency->id }}]" onclick="checkInputValue(this)">
                              <label class="custom-control-label" for="{{ 'child-'.$currency->id }} "></label>
                          </div>
                      @else
                          {{ ++$no }}
                      @endif
                      </th>
                      <td class="center">{{$currency->currency_name}}</td>
                      <td class="center">{{$currency->currency_simbol}}</td>
                      <td class="center">{{$currency->currency_code}}</td>
                      <td class="center">{{'Rp '.is_number($currency->exchange_rate,2)}}</td>
                      <td class="center"> 
                      @if($currency->status == 1)
                        <span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes </span>
                      @else
                        <span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No </span>'
                      @endif
                      </td>
                      <td class="center">{{Carbon::parse($currency->created_at)->format('l, j F Y | H:i')}}</td>
                
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection