@extends('layouts.adminLayout.admin_design')
@section('title')
Add Products | Admin Hsn E-commerce
@endsection
@section('content')

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
     <a href="{{url($module->permalink.'/add')}}" class="current">{{__('backend.add_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_product')}}</h5>
          </div>
          <div class="widget-content nopadding">
          <form class="form-horizontal" action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
            @csrf
            <div class="control-group">
                <label class="control-label required">{{__('backend.under_category')}} </label>
                <div class="controls">
                   <select name="category_id" id="category_id" style="width:220px; @error('category_id') border-style: solid; border-color: orangered; @enderror ">
                    <?php echo $categories_dropdown ?>
                   </select> 
                   @error('category_id') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label required">{{__('backend.product_name')}}</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" style=" @error('product_name') border-style: solid; border-color: orangered; @enderror ">
                  @error('product_name') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label required">{{__('backend.product_code')}}</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code" style=" @error('product_code') border-style: solid; border-color: orangered; @enderror ">
                  @error('product_code') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_color')}}</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color">
                </div>
              </div> 
              <div class="control-group">
                <label class="control-label required">{{__('backend.description')}}</label> 
                <div class="controls">
                 <textarea name="description" id="description" class="some-textarea span5"  rows="10" style=" @error('description') border-style: solid; border-color: orangered; @enderror "></textarea>
                 @error('description') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label required ">{{__('backend.material_care')}}</label> 
                <div class="controls">
                 <textarea name="care" id="care" class="some-textarea1 span5"  rows="10" style=" @error('care') border-style: solid; border-color: orangered; @enderror "></textarea>
                 @error('care') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Sleeve</label>
                <div class="controls">
                  <select name="sleeve"  name="sleeve" id="sleeve" class="form-control" style="width:220px;">
                  <option selected disabled >Select Sleeve</option>
                  @foreach(config('customeArr.sleeveArray') as $sleeve)
                    <option value="{{$sleeve}}">{{$sleeve}}</option>
                  @endforeach 
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Pattern</label>
                <div class="controls">
                  <select name="pattern"  name="pattern" id="pattern" class="form-control" style="width:220px;">
                  <option selected disabled >Select Pattern</option>
                  @foreach(config('customeArr.patternArray') as $patterns)
                    <option value="{{$patterns}}">{{$patterns}}</option>
                  @endforeach 
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label required ">{{__('backend.price')}}</label>
                <div class="controls">
                  <input class="price-input-Rp" type="text" name="price" id="price" placeholder="Rp 0" style=" @error('price') border-style: solid; border-color: orangered; @enderror ">
                  @error('price') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Weight (g)</label>
                <div class="controls">
                  <input class="numeric" type="text" name="weight" id="weight" placeholder="">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label required">Image</label>
                <div class="controls">
                  <input type="file" name="image" id="image" style=" @error('image') border-style: solid; border-color: orangered; @enderror ">
                  @error('image') {!! required_field($message) !!} @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Video</label>
                <div class="controls">
                  <input type="file" name="video" id="video">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.feature_item')}}</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" value="1">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
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

@endsection