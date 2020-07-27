@extends('layouts.adminLayout.admin_design')
@section('link')
<style>
  .wysihtml5-sandbox {
    width: 578.569px;
    height: 198.9653px;
}
</style>
@endsection
@section('title')
Edit Products | Admin Hsn E-commerce
@endsection

@section('content')

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url($module->permalink.'/edit')}}" class="current">{{__('backend.edit_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>

  </div>
  <div id="loading"></div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>{{__('backend.edit_product')}}</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" action="{{ $module->permalink.'/update' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
                {{csrf_field()}}
                <div class="control-group">
                    <label class="control-label required">{{__('backend.under_category')}} </label>
                    <div class="controls">
                      <select name="category_id" id="category_id" style=" width:220px; @error('category_id') border-style: solid; border-color: orangered; @enderror ">
                        <?php echo $categories_dropdown ?> 
                      </select> 
                      @error('category_id') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.product_name')}}</label>
                    <div class="controls">
                      <input type="text" name="product_name" id="product_name" value="{{ old('product_name') ?: $productDetails->product_name}}" style=" @error('product_name') border-style: solid; border-color: orangered; @enderror ">
                      @error('product_name') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.product_code')}}</label>
                    <div class="controls">
                      <input type="text" name="product_code" id="product_code" value="{{ old('product_code') ?: $productDetails->product_code}}" style=" @error('product_code') border-style: solid; border-color: orangered; @enderror ">
                      @error('product_code') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">{{__('backend.product_color')}}</label>
                    <div class="controls">
                      <input type="text" name="product_color" id="product_color" value="{{ old('product_color') ?? $productDetails->product_color}}">
                    </div>
                  </div> 
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.description')}}</label> 
                    <div class="controls">
                    <textarea name="description" id="description" class="some-textarea span5 " rows="10" style=" @error('description') border-style: solid; border-color: orangered; @enderror ">{{ old('description') ?: $productDetails->description}}</textarea>
                    @error('description') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.material_care')}}</label> 
                    <div class="controls">
                    <textarea name="care" id="care" class="some-textarea1 span5"  rows="10" style=" @error('care') border-style: solid; border-color: orangered; @enderror ">{{ old('care') ?? $productDetails->care}}</textarea>
                    @error('care') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label ">Sleeve</label>
                    <div class="controls">
                      <select name="sleeve" name="sleeve" id="sleeve" class="form-control" style="width:220px;">
                      <option selected disabled>Select Sleeve</option>
                      @foreach(config('customeArr.sleeveArray') as $sleeve)
                        <option value="{{$sleeve}}" @if(!empty($productDetails->sleeve) && $productDetails->sleeve == $sleeve) selected @endif>{{$sleeve}}</option>
                      @endforeach 
                      </select> 
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label ">Pattern</label>
                    <div class="controls">
                      <select name="pattern" name="pattern" id="pattern" class="form-control" style="width:220px;">
                      <option selected disabled >Select Pattern</option>
                      @foreach(config('customeArr.patternArray') as $patterns)
                        <option value="{{$patterns}}" @if(!empty($productDetails->pattern) && $productDetails->pattern == $patterns) selected @endif>{{$patterns}}</option>
                      @endforeach 
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.price')}}</label>
                    <div class="controls">
                      <input class="price-input-Rp" type="text" name="price" id="price" value="{{ old('price') ?? $productDetails->price}}" style=" @error('price') border-style: solid; border-color: orangered; @enderror ">
                      @error('price') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label ">Weight (g)</label>
                    <div class="controls">
                      <input class="" type="number" name="weight" id="weight" value="{{ old('weight') ?? $productDetails->weight}}">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.old_image')}}</label>
                    <div class="controls">
                      @if(!empty($productDetails->image))
                        <a href="javascript:"> <img src="{{ file_exists('images/backend_images/products/small/'.$productDetails->image) ? asset('images/backend_images/products/small/'.$productDetails->image ) : $url_amazon.'product/images/small/'.$productDetails->image }}" alt="{{__('backend.old_image')}}" style="width:217px; height:219px;" onclick="popupGambar(this)"> </a>
                        @if($page->fetch_role('drop', $module) == true )
                        &nbsp; | | <a rel="{{$productDetails->id}}" link="{{ $module->permalink }}" rel1="/delete-product-image/" rel2="{{__('backend.old_image')}}" href="javascript:" class="btn btn-danger btn-mini" id="" onclick="deleteProdt(this)"><i class="icon-trash" ></i> {{__('backend.delete')}}</a>
                        @endif
                      @else
                        <img src="{{asset('images/null.jpg')}}" alt="{{__('backend.old_image')}}" style="width:219px;" >
                      @endif
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">{{__('backend.new_image')}}</label>
                    <div class="controls">
                      <input type="file" name="image" id="image"> 
                      <input type="hidden" name="current-image" value="{{$productDetails->image}}"> 
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label"> Old Video </label>
                    <div class="controls">
                      @if(!empty($productDetails->video))
                        <video class="video-prod" src="{{asset('videos/'.$productDetails->video)}}" controls> </video>
                      @else
                        <img src="{{asset('images/video-thumbnail.png')}}" width="217" height="185" controls alt="" >
                      @endif
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">New Video</label>
                    <div class="controls">
                      <input type="file" name="video" id="video"> 
                      <input type="hidden" name="current-video" value="{{$productDetails->video}}">
                      @if(!empty($productDetails->video))
                        @if($page->fetch_role('drop', $module) == true )
                          | |  <a rel="{{$productDetails->id}}" link="{{ $module->permalink }}" rel1="/delete-product-video/" rel2="{{$productDetails->video}}" href="javascript:" class="btn btn-danger btn-mini" onclick="deleteProdt(this)" data-del-id="{{$productDetails->id}}" title=" {{__('backend.delete')}}">  <i class="icon-trash" ></i> Delete Old Video </a> </a> 
                        @endif
                      @endif
                    </div>
                  </div>

                  <div class="control-group">
                    <div class="controls">
                      <label class="control-input-content"> {{__('backend.feature_item')}} 
                            <div class="switch">
                                <input type="checkbox" name="feature_item" id="feature_item" value="1" class="toggle-switch-checkbox toggle-switch-info" @if($productDetails->feature_item =="1") checked @endif >
                                <span class="slider round"></span>
                            </div>
                      </label>
                    </div>
                  </div>

                  <div class="control-group">
                    <div class="controls">
                      <label class="control-input-content"> {{__('backend.enable')}} 
                            <div class="switch">
                                <input type="checkbox" name="status" id="status" value="1" class="toggle-switch-checkbox toggle-switch-primary" @if($productDetails->status =="1") checked @endif >
                                <span class="slider round"></span>
                            </div>
                      </label>
                    </div>
                  </div>

                <hr>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection