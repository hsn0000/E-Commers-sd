@extends('layouts.adminLayout.admin_design')

@section('content')
@php
use Carbon\Carbon;
@endphp
<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/view-categories')}}" class="current">{{__('backend.view_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>
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
            <h5>{{__('backend.view_product')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="font-size:100%;">{{__('backend.no')}}</th>
                  <th style="font-size:100%;">{{__('backend.product_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.category_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.category_name')}}</th>
                  <th style="font-size:100%;">{{__('backend.product_name')}}</th>
                  <th style="font-size:100%;">{{__('backend.product_code')}}</th>
                  <th style="font-size:100%;">{{__('backend.product_color')}}</th>
                  <th style="font-size:100%;">{{__('backend.price')}}</th>
                  <th style="font-size:100%;">{{__('backend.feature_item')}}</th>
                  <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                  <th style="font-size:100%;">{{__('backend.image')}}</th>
                  <th style="font-size:100%;">{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>
                  @php
                    $no = 0;
                  @endphp
                  @foreach($products as $product)
                <tr class="gradeX">
                  <td style="text-align:center;">{{++$no}}</td>
                  <td>{{$product->id}}</td>
                  <td>{{$product->category_id}}</td>
                  <td>{{$product->category_name}}</td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_code}}</td>
                  <td>{{$product->product_color}}</td>
                  <td>{{'Rp'.' '.is_number($product->price,2)}}</td>
                  <td  style="text-align:center;" > @if ($product->feature_item == 1) <span class="badge badge-success">{{__('backend.yes')}}</span> @else <span class="badge" style="background-color: firebrick;">{{__('backend.now')}}</span>@endif</td>
                  <td>{{Carbon::parse($product->created_at)->format('l, j F Y | H:i')}}</td>
                  <td style="text-align:center;">
                   @if(!empty($product->image))
                     <a href="javascript:"><img src="{{ asset('images/backend_images/products/small/'.$product->image )}}" alt="image product" width="110" onclick="popupGambar(this)"></a>
                   @endif
                  </td>
                  {{-- url('/admin/delete-product/'.$product->id) --}}
                  <td class="center" style="text-align:center;" width="24%;">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" style="margin:35px 0 0 0;" title=" {{__('backend.view')}}"> <i class="icon-eye-open" style="padding:0 4px"></i> {{__('backend.view')}}</a>
                    <a href="{{url('/admin/add-attribute/'.$product->id)}} " class="btn btn-primary btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.add_product_attributes')}}"> <i class="icon-plus" style="padding:0 4px"></i> {{__('backend.add')}} Attr</a>
                    <a href="{{url('/admin/add-images/'.$product->id)}} " class="btn btn-info btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.add_product_mages')}}"> <i class="icon-plus-sign" style="padding:0 4px"></i>  {{__('backend.add')}}  Img</a>
                    <a href="{{url('/admin/edit-product/'.$product->id)}} " class="btn btn-warning btn-mini" style="margin:35px 0 0 10px;" title="{{__('backend.edit_product')}}"> <i class="icon-cogs" style="padding:0 4px"></i>  {{__('backend.edit')}}</a> 
                    <a rel="{{$product->id}}" rel1="delete-product" rel2="{{$product->product_name}}" href="javascript:" class="btn btn-danger btn-mini" onclick="deleteProdt(this)" data-del-id="{{$product->id}}" style="margin:35px 0 0 10px;" title=" {{__('backend.delete')}}"> 
                      <i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
                 </td>
                  <div id="myModal{{$product->id}}" class="modal hide">
                     <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                          <h3>{{$product->product_name}} {{__('backend.full_details')}}</h3>
                        </div>
                         <div class="modal-body">
                           <p>{{__('backend.product_id')}} : {{$product->id}}</p>
                           <p>{{__('backend.category_id')}} : {{$product->category_id}}</p>
                           <p>{{__('backend.product_code')}} : {{$product->product_code}}</p>
                           <p>{{__('backend.product_color')}} : {{$product->product_color}}</p>
                           <p>Fabric :</p>
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