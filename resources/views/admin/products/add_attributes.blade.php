@extends('layouts.adminLayout.admin_design')

@section('title')
Add Attribute Products | Admin Hsn E-commerce
@endsection

@section('content')
@php
  $currencyLocale = Session::get('currencyLocale');
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.add_product_attributes')}}</a> </div>
    <h1>{{__('backend.products_attributes')}}</h1>
  </div> 
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_product_attributes')}}</h5>
          </div>
          <div class="widget-content nopadding">
          <form action="{{ $module->permalink.'/add-attribute/'.$productDetails->id }}" id="form-table" method="post" autocomplete="off" enctype="multipart/form-data" class="form-horizontal">
            {{csrf_field()}}
            <div class="control-group">
              <input type="hidden" value="{{$productDetails->id}}">
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
                <label class="control-label">{{__('backend.product_color')}} :</label>
                <label for="" class="control-label"><b>{{$productDetails->product_color}}</b></label>
              </div>        
              <div class="control-group">
                <label class="control-label">{{__('backend.price')}} :</label>
                <label for="" class="control-label"><b> {{$currencyLocale->currency_simbol.' '.is_number($productDetails->price,2)}} </b></label>
              </div>               
            <div class="control-group">
              <label class="control-label"></label>
                <div class="field_wrapper">
                    <div>
                        <input type="text" name="sku[]" id="sku" value="" placeholder="SKU" style="width:130px;" />
                        <input type="text" class="numeric" name="size[]" id="size" value="" placeholder="Size" style="width:130px;" />
                        <input type="text" class="price-input-Rp" name="price[]" id="price" value="" placeholder="Price" style="width:130px;" />
                        <input type="text" class="numeric" name="stock[]" id="stock" value="" placeholder="Stock" style="width:130px;" />
                        <a href="javascript:void(0);" class="add_button" title="Add field"><i class="icon-plus" style="margin: 0 0 0 10px;"></i></a>
                    </div>
                </div>
            </div>           
              <hr>
            </form>
          </div>
        </div>
      </div>

  <!-- end attr -->
  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>{{__('backend.view_attributes')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form action="{{ $module->permalink.'/edit-attribute/'.$productDetails->id }}" method="post" name="edit_attribute">
            {{csrf_field()}}
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th style="font-size:100%;">#</th>
                  <th style="font-size:100%;">SKU</th>
                  <th style="font-size:100%;">{{__('backend.size')}}</th>
                  <th style="font-size:100%;">{{__('backend.price')}}</th>
                  <th style="font-size:100%;">{{__('backend.stock')}}</th>
                  <th style="font-size:100%;">{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>   
               @php
               $no = 0;
               @endphp
                  @foreach($productDetails['attributes'] as $attribute)
                <tr class="gradeX">
                <input type="hidden" class="hidden" name="idAttr[]" value="{{$attribute->id}}" >
                  <td style="text-align:center;">{{++$no}}</td>
                  <td>{{$attribute->sku}}</td>
                  <td>{{$attribute->size}}</td>
                  <td><input type="text" class="price-input-Rp" name="price[]" value="{{$currencyLocale->currency_simbol.' '.is_number($attribute->price,2)}}"></td>
                  <td><input type="text" class="numeric" name="stock[]" value="{{$attribute->stock}}"></td>
                  <td class="center" style="text-align:center;" width="">
                    @if($page->fetch_role('alter', $module) == true )
                      <a href="javascript:"><i class="icon-cogs" style="padding:0 4px"></i> <input type="submit" value="Update" class="btn btn-warning btn-mini"></a>
                    @endif
                    @if($page->fetch_role('drop', $module) == true )
                      <a href="{{url($module->permalink.'/delete-attribute/'.$attribute->id)}}" class=" btn btn-danger btn-mini" style="margin:0 7px"><i class="icon-trash" style="padding: 0 5px"></i>Delete</a>
                    @endif
                 </td>
                 </td>
                </tr>
                 @endforeach
              </tbody>
            </table>
            </form>
          </div>
        </div>
      </div>
    </div>

  
    </div>
  


  </div>
</div>

@endsection