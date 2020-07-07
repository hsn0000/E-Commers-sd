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
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{__('backend.view_product')}}</h5> 
              <div class="action">
              @if($page->fetch_role('create', $module) == true )
                <a href="{{url($module->permalink.'/export-products')}}" class="badge badge-success btn-mini export_ex"> <i class=" icon-screenshot" style="margin-right: 7px;"></i> Exp Excel</a>
                <a href="javascript:" data-link="{{$module->permalink.'/add-attribute/'}}" class="badge badge-info btn-mini export_ex btn-add-attribute" title="{{__('backend.add_product_attributes')}}"> <i class="icon-plus" style="padding:0 4px"></i> attr</a>
                <a href="javascript:" data-link="{{$module->permalink.'/add-images/'}}" class="badge badge-info btn-mini export_ex btn-add-image" title="{{__('backend.add_product_mages')}}"> <i class="icon-plus-sign" style="padding:0 4px"></i> image</a>
                <a href="#myModal" data-toggle="modal" class="badge badge-inverse btn-mini export_ex btn-view" title=" {{__('backend.view')}}"> <i class="icon-eye-open" style="padding:0 4px"></i> view </a>
                @endif
            </div>
          </div>
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
                     <a href="javascript:"><img src="{{ asset('images/backend_images/products/small/'.$product->image )}}" class="rounded" alt="image product" width="110" onclick="popupGambar(this)"></a>
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
                  {{-- 
                  <td class="center" style="text-align:center;" width="24%;">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" style="margin:35px 0 0 0;" title=" {{__('backend.view')}}"> <i class="icon-eye-open" style="padding:0 4px"></i> {{__('backend.view')}}</a>
                    <a href="{{url('/admin/add-attribute/'.$product->id)}} " class="btn btn-primary btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.add_product_attributes')}}"> <i class="icon-plus" style="padding:0 4px"></i> {{__('backend.add')}} Attr</a>
                    <a href="{{url('/admin/add-images/'.$product->id)}} " class="btn btn-info btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.add_product_mages')}}"> <i class="icon-plus-sign" style="padding:0 4px"></i>  {{__('backend.add')}}  Img</a>
                    <a href="{{url('/admin/edit-product/'.$product->id)}} " class="btn btn-warning btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.edit_product')}}"> <i class="icon-cogs" style="padding:0 4px"></i>  {{__('backend.edit')}}</a> 
                    <a rel="{{$product->id}}" rel1="delete-product" rel2="{{$product->product_name}}" href="javascript:" class="btn btn-danger btn-mini" onclick="deleteProdt(this)" data-del-id="{{$product->id}}" style="margin:35px 0 0 10px;" title=" {{__('backend.delete')}}"> 
                      <i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
                 </td> 
                 --}}

                  <div id="myModal{{$product->id}}" class="modal hide">
                     <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                          <h3>{{$product->product_name}} {{__('backend.full_details')}}</h3>
                        </div>
                         <div class="modal-body">
                           <p>{{__('backend.product_code')}} : {{$product->product_code}}</p>
                           <p>{{__('backend.product_color')}} : {{$product->product_color}}</p>
                           <p>Fabric : </p>
                           <p>{{__('backend.material')}} :</p>
                           <p>{{__('backend.price')}} : {{'Rp'.' '.is_number($product->price)}}</p>
                           <p>{{__('backend.description')}} : {{$product->description}}</p>
                        </div>
                    </div>

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