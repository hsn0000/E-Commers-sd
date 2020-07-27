@extends('layouts.adminLayout.admin_design')
@section('title')
Add CMS Page | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.cms_pages')}}</a>
     <a href="#" class="current">{{__('backend.add_cms_page')}}</a> </div> 
    <h1>{{__('backend.cms_pages')}}</h1>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box"> 
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>{{__('backend.add_cms_page')}}</h5>
            </div>
            <form class="form-horizontal" action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
              @csrf
              <div class="widget-content nopadding">
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.title')}}</label>
                    <div class="controls">
                      <input type="text" name="title" @error('title') id="is-invalid-title"  @enderror value="{{old('title')}}" required>
                      @error('title')
                          <span class="invalid-feedback" role="alert">
                              <strong style="color: orangered;"> Title cannot be empty ! </strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">CMS Page URL</label>
                    <div class="controls">
                      <input type="text" name="url" @error('url') id="is-invalid-url"  @enderror value="{{old('url')}}" required >
                      @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color: orangered;"> URL cannot be empty ! </strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.description')}}</label> 
                    <div class="controls">
                    <textarea name="description" id="description" style="opcity: 0;" style=" @error('description') border-style: solid; border-color: orangered; @enderror "></textarea>
                    @error('description') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Title</label>
                    <div class="controls">
                      <input type="text" name="meta_title" value="{{old('meta_title')}}" >
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Description</label>
                    <div class="controls">
                      <input type="text" name="meta_description" value="{{old('meta_description')}}" >
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Keywords</label>
                    <div class="controls">
                      <input type="text" name="meta_keywords" value="{{old('meta_keywords')}}" >
                    </div>
                  </div>

                    <div class="control-group">
                      <div class="controls">
                        <label class="control-input-content"> {{__('backend.enable')}} 
                              <div class="switch">
                                  <input type="checkbox" name="status" id="status" value="1" class="toggle-switch-checkbox toggle-switch-primary">
                                  <span class="slider round"></span>
                              </div>
                        </label>
                      </div>
                    </div>
                  <hr>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection