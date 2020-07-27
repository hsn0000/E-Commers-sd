@extends('layouts.adminLayout.admin_design')
@section('title')
Add Images Products | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current"> {{__('backend.add_product_mages')}}</a> </div>
    <h1>{{__('backend.products_alternate_images')}}</h1>

  </div>
  <div id="loading"></div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>{{__('backend.add_product_mages')}}</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ $module->permalink.'/add-images/'.$productDetails->id }}" id="form-table" method="post" autocomplete="off" enctype="multipart/form-data" class="form-horizontal">
                {{csrf_field()}}
                <div class="control-group">
                  <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                  </div>
                  <div class="control-group">
                    <label class="control-label">{{__('backend.product_name')}} :</label>
                    <label for="" class="control-label"><b>{{$productDetails->product_name}}</b></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label">{{__('backend.product_code')}} :</label>
                    <label for="" class="control-label"><b>{{$productDetails->product_code}}</b></label>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.alternate_image')}} :</label>
                    <div class="controls">
                      <input type="file" name="image[]" id="image" multiple="multiple" value="{{ old('username') ?: '' }}" >
                      @error('image') {!! required_field($message) !!} @enderror
                    </div>
                  </div>  
                  <hr>            
              </form>
            </div>
          </div>
        </div>
      </div>

  <!-- end attr -->
  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{__('backend.view_images')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="font-size:100%;">#</th>
                  <th style="font-size:100%;">{{__('backend.image')}}</th>
                  <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                  @if($page->fetch_role('drop', $module) == true )
                    <th style="font-size:100%; width: 193px;">{{__('backend.actions')}}</th>
                  @endif
                </tr>
              </thead>
              <tbody>
               @php 
               $no = 0;
               @endphp
                @foreach($productsImages as $pimage)
                  <tr>
                     <td class="center" >{{++$no}}</td>
                     <td class="center" > <a href="javascript:"> <img class="rounded" src="/images/backend_images/products/small/{{$pimage->image}}" width="135" alt="Alternate Images" onclick="popupGambar(this)"></a></td>
                     <td class="center" >{{Carbon::parse($pimage->created_at)->format('l, j F Y | H:i')}}</td>
                     @if($page->fetch_role('drop', $module) == true )
                     <td class="center" ><a link="{{$module->permalink}}" rel="{{$pimage->id}}" rel1="/delete-alt-image/" href="javascript:" onclick="deleteAltImg(this)" class="btn btn-danger btn-mini" style="margin:50px; padding: 3px; width: 64px; " Title="{{__('backend.delete_product_image')}}">
                       <i class="icon-trash" style="padding: 0 8px"></i>{{__('backend.delete')}}</a></td>
                     @endif
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
</div>

@endsection