@extends('layouts.adminLayout.admin_design')
@section('title')
View Products | Admin Hsn E-commerce
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
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{ $module->permalink }}" class="current">{{__('backend.view_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">

      <div class="action actions-prod">
          @if($page->fetch_role('create', $module) == true )
            <a href="{{url($module->permalink.'/export-products')}}" class="btn btn-success btn-mini export_ex"> <i class=" icon-screenshot" style="margin-right: 7px;"></i> exp excel</a>
            <a href="javascript:" data-link="{{$module->permalink.'/add-attribute/'}}" class="btn btn-info btn-mini export_ex btn-add-attribute" title="{{__('backend.add_product_attributes')}}"> <i class="icon-plus" style="padding:0 4px"></i> attribute</a>
            <a href="javascript:" data-link="{{$module->permalink.'/add-images/'}}" class="btn btn-primary btn-mini export_ex btn-add-image" title="{{__('backend.add_product_mages')}}"> <i class="icon-plus-sign" style="padding:0 4px"></i> image</a>
          @endif
      </div>

      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>{{__('backend.view_product')}}</h5> 
          
            </div> 
            <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
              @csrf
              <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                    <tr>
                      <th>
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i> </a>
                      @else
                          #
                      @endif
                      </th> 
                      <th style="font-size:100%;">{{__('backend.category_name')}}</th>
                      <th style="font-size:100%;">{{__('backend.product_name')}}</th>
                      <th style="font-size:100%;">{{__('backend.product_code')}}</th>
                      <th style="font-size:100%;">{{__('backend.product_color')}}</th>
                      <th style="font-size:100%;">{{__('backend.price')}}</th>
                      <th style="font-size:100%;">{{__('backend.image')}}</th>
                      <th style="font-size:100%;">{{__('backend.feature_item')}}</th>
                      <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                      @php
                        $no = 0;
                      @endphp
                      @foreach($products as $key => $product)
                    <tr class="gradeX">
                      <th scope="row" class="center">
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$product->id }}" name="data_id[{{ $product->id }}]" onclick="checkInputValue(this)">
                              <label class="custom-control-label" for="{{ 'child-'.$product->id }}" ></label>
                          </div>
                      @else
                          {{ ++$key }}
                      @endif
                      </th>
                      <td class="center">{{$product->name}}</td>
                      <td class="center">{{$product->product_name}}</td>
                      <td class="center">{{$product->product_code}}</td>
                      <td class="center">{{$product->product_color}}</td>
                      <td class="center">{{'Rp'.' '.is_number($product->price,2)}}</td>
                      <td class="center">
                      @if(!empty($product->image))
                        <a href="javascript:"><img data-src="{{ file_exists('images/backend_images/products/small/'.$product->image) ? asset('images/backend_images/products/small/'.$product->image ) : $url_amazon.'product/images/small/'.$product->image }}" class="rounded lazy" alt="image product" width="110" onclick="popupGambar(this)"></a>
                      @endif
                      </td>
                      <td class="center" > 
                        @if ($product->feature_item == 1) 
                          <span class="badge badge-info" style="margin-right: 10px;"> <i class="icon icon-ok"></i> {{__('backend.yes')}} </span> 
                        @else 
                          <span class="badge badge-important" style="margin-right: 10px;"> <i class="icon icon-ban-circle"></i> {{__('backend.now')}} </span>
                        @endif
                      </td>
                      <td class="center" >{{Carbon::parse($product->created_at)->format('l, j F Y | H:i')}}</td>

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

<script>
    window.addEventListener("scroll", function() { onScrollDiv() });
    window.document.getElementById('form-table').addEventListener("load", function() { onScrollDiv() });

    window.addEventListener("scroll", function() { onLoadDiv() });
    window.addEventListener("load", function() { onLoadDiv() });
</script>

@endsection