@extends('layouts.adminLayout.admin_design')

@section('title')
View Shipping | Admin Hsn E-commerce
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

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">Shipping</a>
     <a href="#" class="current">View Shipping</a> </div>
    <h1>Shipping Charges</h1>

  </div>
  <div id="loading"></div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Shipping Charges</h5>
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
                      <th>Country Code</th>
                      <th>Country</th>
                      <th>Shipping Charges</th>
                      <th>0g to 500g</th>
                      <th>5001g to 1000g/th>
                      <th>1001g to 2000g</th>
                      <th>2001g to 5000g</th>
                      <th>Updated at</th>
                    </tr>
                  </thead>
                  <tbody>
                      @php
                        $no = 0;
                      @endphp
                      @foreach($shipping_charge as $shipping)
                    <tr class="gradeX">
                      <th scope="row" class="center">
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$shipping->id }}" name="data_id[{{ $shipping->id }}]" onclick="checkInputValue(this)">
                              <label class="custom-control-label" for="{{ 'child-'.$shipping->id }} "></label>
                          </div>
                      @else
                          {{ ++$no }}
                      @endif
                      </th>
                      <td class="center">{{$shipping->country_code}}</td>
                      <td class="center">{{$shipping->country}}</td>
                      <td class="center">Rp {{is_number($shipping->shipping_charges)}}</td>
                      <td class="center">{{$shipping->shipping_charges0_500g}} g</td>
                      <td class="center">{{$shipping->shipping_charges501_1000g}} g</td>
                      <td class="center">{{$shipping->shipping_charges1001_2000g}} g</td>
                      <td class="center">{{$shipping->shipping_charges2001_5000g}} g</td>
                      <td class="center">{{Carbon::parse($shipping->updated_at)->format('l, j F Y | H:i')}}</td>       
                    
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