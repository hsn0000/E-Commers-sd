@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.cms_pages')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.edit_cms_page')}}</a> </div> 
    <h1>{{__('backend.cms_pages')}}</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong>{{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block" style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert" >x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color:seagreen; color:white; width:21%; margin-left:20px;">
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
            <h5>{{__('backend.edit_cms_page')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/edit-cms-page/'.$cmsPage->id)}}" name="edit_cms_page" id="edit_cms_page" novalidate="novalidate">
            {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">{{__('backend.title')}}</label>
                <div class="controls">
                  <input type="text" name="title"  @error('title') id="is-invalid-title" @enderror value="{{ old('title') ?: $cmsPage->title }}" class="@error('title') is-invalid @enderror" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color: orangered;"> Title cannot be empty  !</strong>
                            </span>
                        @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">CMS Page URL</label>
                <div class="controls">
                  <input type="text" name="url" @error('title') id="is-invalid-title" @enderror value="{{ old('url') ?: $cmsPage->url }}" class="@error('title') is-invalid @enderror" required>
                      @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong style="color: orangered;"> URL cannot be empty ! </strong>
                            </span>
                      @enderror
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.description')}}</label> 
                <div class="controls">
                 <textarea name="description" id="description">{{$cmsPage->description}}</textarea>
                 <!-- <input type="hidden" name="description" id="" value="{{$cmsPage->description}}"> -->
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" @if($cmsPage->status == "1") checked @endif>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="{{__('backend.edit_cms_page')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection