@extends('layouts.adminLayout.admin_design')

@section('title')
Add Banners | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.banners')}}</a>
     <a href="#" class="current">{{__('backend.add_banner')}}</a> </div>
    <h1>{{__('backend.banners')}}</h1>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box">
          <div class="responsif-costume">
              <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                <h5>{{__('backend.add_banner')}}</h5>
              </div>
              <div class="widget-content nopadding">
                <form class="form-horizontal" action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
                  @csrf
                  <div class="control-group">
                      <label class="control-label required">{{__('backend.banner_image')}}</label>
                      <div class="controls">
                        <div class="uploader" id="uniform-undefined">
                          <input type="file" name="image" id="image" size="19" style="opcity: 0;" style=" @error('image') border-style: solid; border-color: orangered; @enderror "><span class="filename">{{__('backend.no_file_selected')}}</span><span class="action">{{__('backend.choose_file')}}</span>
                          @error('image') {!! required_field($message) !!} @enderror
                      </div>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label required">{{__('backend.title')}}</label>
                      <div class="controls">
                        <input type="text" name="title" id="title" value="" style=" @error('title') border-style: solid; border-color: orangered; @enderror ">
                        @error('title') {!! required_field($message) !!} @enderror
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label required">{{__('backend.link')}}</label>
                      <div class="controls" >
                        <input type="text" name="link" id="link" style=" @error('link') border-style: solid; border-color: orangered; @enderror ">
                        @error('link') {!! required_field($message) !!} @enderror
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
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection