@extends('layouts.adminLayout.admin_design')
@section('title')
Edit Categories | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>  {{__('backend.home')}}</a> <a href="#"> {{__('backend.categories')}}</a>
     <a href="{{ $module->permalink.'/edit' }}" class="current"> {{__('backend.edit_category')}}</a> </div>
    <h1> {{__('backend.categories')}}</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>{{__('backend.edit_category')}}</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" action="{{ $module->permalink.'/update' }}" id="form-table" method="post" autocomplete="off">
                @csrf
                <div class="control-group">
                  <label class="control-label required">{{__('backend.category_name')}}</label>
                  <div class="controls">
                    <input type="text" name="category_name" id="category_name" value="{{old('category_name') ?? $categoryDetails->name}}" style=" @error('category_name') border-style: solid; border-color: orangered; @enderror ">
                    @error('category_name') {!! required_field($message) !!} @enderror
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label required">{{__('backend.category_level')}}</label>
                  <div class="controls">
                    <select name="parent_id" id="" style="width:220px;" @error('parent_id') border-style: solid; border-color: orangered; @enderror ">
                        <option value="0">{{__('backend.main_category')}}</option>
                        @foreach($levels as $val)
                            <option value="{{$val->id}}" @if($val->id == $categoryDetails->parent_id) selected @endif > {{$val->name}}</option>
                        @endforeach
                    </select>
                    @error('parent_id') {!! required_field($message) !!} @enderror
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">{{__('backend.description')}}</label> 
                  <div class="controls">
                  <textarea name="description" id="description">{{old('description') ?? $categoryDetails->description}}</textarea>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label required">{{__('backend.category_url')}}</label>
                  <div class="controls">
                    <input type="text" name="url" id="url" value="{{old('url') ?? $categoryDetails->url}}" style=" @error('url') border-style: solid; border-color: orangered; @enderror ">
                    @error('url') {!! required_field($message) !!} @enderror
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Title</label>
                  <div class="controls">
                    <input type="text" name="meta_title"  id="meta_title" value="{{old('meta_title') ?? $categoryDetails->meta_title}}">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Description</label>
                  <div class="controls">
                    <input type="text" name="meta_description" id="meta_description"  value="{{old('meta_description') ?? $categoryDetails->meta_description}}" >
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Meta Keywords</label>
                  <div class="controls">
                    <input type="text" name="meta_keywords" id="meta_keywords"  value="{{old('meta_keywords') ?? $categoryDetails->meta_keywords}}">
                  </div>
                </div>

                <div class="control-group">
                  <div class="controls">
                    <label class="control-input-content"> {{__('backend.enable')}} 
                        <div class="switch">
                            <input type="checkbox" name="status" id="status" value="1" @if($categoryDetails->status =="1") checked @endif class="toggle-switch-checkbox toggle-switch-primary">
                            <span class="slider round"></span>
                        </div>
                    </label>
                  </div>
                </div>

                <br>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection