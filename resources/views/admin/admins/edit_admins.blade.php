@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="loading"></div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">Admins / Roles</a>
     <a href="{{url('/admin/add-category')}}" class="current">Add Admins / Roles</a> </div>
    <h1> Edit Admins / Roles</h1>
@if(Session::has('flash_message_success')) 
  <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item" style="background: lightseagreen;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/done.png')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Successfully ! </b></span>
             <p><b> {{Session::get('flash_message_success')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
  </div>
@endif
@if(Session::has('flash_message_error')) 
 <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item" style="background: red;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/fail.jpg')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Failed ! </b></span>
             <p><b> {{Session::get('flash_message_error')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
  </div>
@endif
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Admins / Roles</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/edit-admins/'.$adminDetails->id)}}" name="edit_admin" id="edit_admin">
            {{csrf_field()}}
            <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls" style="width: 247px;">
                  <input type="text" name="type" id="type" value="{{$adminDetails->type}}" readonly>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name="username" id="username" value="{{$adminDetails->username}}" readonly>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password" value="" required>
                </div>
              </div>
              @if($adminDetails->type == "Sub Admin")
              <div class="control-group" id="access">
                 <label class="control-label">Access </label>
                <div class="controls">
                    <input type="checkbox" name="categories_view_access" id="categories_view_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="info" @if($adminDetails->categories_view_access == 1 ) checked @endif> &nbsp; View Categories Only &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" name="categories_edit_access" id="categories_edit_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="info" @if($adminDetails->categories_edit_access == 1 ) checked @endif> &nbsp; Edit Categories Only &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" name="categories_full_access" id="categories_full_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="info" @if($adminDetails->categories_full_access == 1 ) checked @endif> &nbsp; Full Categories &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" name="products_access" id="products_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="primary" @if($adminDetails->products_access == 1 ) checked @endif> &nbsp; Products &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" name="order_access" id="order_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="success" @if($adminDetails->order_access == 1 ) checked @endif> &nbsp; Order &nbsp; &nbsp; &nbsp;
                    <input type="checkbox" name="users_access" id="users_access" value="1" data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="warning" @if($adminDetails->users_access == 1 ) checked @endif> &nbsp; Users &nbsp; &nbsp; &nbsp;
                </div>
              </div>
              @endif
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1"  data-toggle="toggle" data-style="ios" data-style="slow" data-width="28px" data-height="2" data-onstyle="primary" @if($adminDetails->status == 1 ) checked @endif>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="{{__('backend.edit_admin')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection