@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="loading"></div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.categories')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.add_category')}}</a> </div>
    <h1>{{__('backend.categories')}}</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_category')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/add-category')}}" name="add_category" id="add_category" novalidate="novalidate">
            {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">{{__('backend.category_name')}}</label>
                <div class="controls">
                  <input type="text" name="category_name" id="category_name">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.category_level')}}</label>
                <div class="controls">
                   <select name="parent_id" id="" style="width:220px;">
                       <option value="0">{{__('backend.main_category')}}</option>
                       @foreach($levels as $val)
                          <option value="{{$val->id}}">{{$val->name}}</option>
                       @endforeach
                   </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.description')}}</label> 
                <div class="controls">
                 <textarea name="description" id="description"></textarea>
                </div>
              </div> 
              <div class="control-group">
                <label class="control-label">{{__('backend.category_url')}}</label>
                <div class="controls">
                  <input type="text" name="url" id="url">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="{{__('backend.add_category')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection