@extends('layouts.adminLayout.admin_design')
@section('title')
Edit News Information | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{$module->permalink}}">News Info</a>
     <a href="#" class="current">Edit News</a> </div> 
    <h1>News Info</h1> 

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box"> 
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Edit News</h5>
            </div>
            <form class="form-horizontal" action="{{ $module->permalink.'/update' }}" id="form-table" method="post" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data" >
              @csrf
              <div class="widget-content nopadding">
                  <div class="control-group">
                    <label class="control-label required">{{__('backend.description')}}</label> 
                    <div class="controls">
                    <textarea name="description" @error('description') id="is-invalid-title"  @enderror> {{ old('description') ?? $newsDetail->description}}</textarea>
                    @error('description') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label required">News URL</label>
                    <div class="controls">
                      <input type="text" name="url" value="{{old('url') ?? $newsDetail->url }}" style=" @error('url') border-style: solid; border-color: orangered; @enderror ">
                      @error('url') {!! required_field($message) !!} @enderror
                    </div>
                  </div>
                  <div class="control-group">
                    <div class="controls">
                      <label class="control-input-content"> {{__('backend.enable')}} 
                            <div class="switch">
                                <input type="checkbox" name="status" id="status" value="1" class="toggle-switch-checkbox toggle-switch-primary" @if($newsDetail->status == 1) checked @endif>
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