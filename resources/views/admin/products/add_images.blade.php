@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current"> {{__('backend.add_product_mages')}}</a> </div>
    <h1>{{__('backend.products_alternate_images')}}</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong>  {{__('backend.'.Session::get('flash_message_error'))}}</strong>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_product_mages')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add-images/'.$productDetails->id)}}" name="add_image" id="add_image">
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
                <label class="control-label">{{__('backend.alternate_image')}} :</label>
                <div class="controls">
                  <input type="file" name="image[]" id="image" multiple="multiple">
                </div>
              </div>              
              <div class="form-actions">
                <input type="submit" value="{{__('backend.add_product_mages')}}" class="btn btn-success">
              </div>
            </form>
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
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="font-size:100%;">{{__('backend.no')}}</th>
                  <th style="font-size:100%;">{{__('backend.images_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.product_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.image')}}</th>
                  <th style="font-size:100%;">{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>
               @php
               $no = 0;
               @endphp
                @foreach($productsImages as $pimage)
                  <tr>
                     <td style="text-align:center; width:20px;">{{++$no}}</td>
                     <td style="text-align:center; width:50px;">{{$pimage->id}}</td>
                     <td style="text-align:center; width:50px;">{{$pimage->product_id}}</td>
                     <td style="text-align:center; width:150px;"><img src="/images/backend_images/products/small/{{$pimage->image}}" alt="Alternate Images"></td>
                     <td style="text-align:center; width:70px;"><a rel="{{$pimage->id}}" rel1="delete-alt-image" href="javascript:" class="del-alt-img btn btn-danger" style="margin:40px; padding:8px" Title="{{__('backend.delete_product_image')}}">
                       <i class="icon-remove" style="padding: 0 8px"></i>{{__('backend.delete')}}</a></td>
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