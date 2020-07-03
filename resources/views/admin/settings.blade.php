@extends('layouts.adminLayout.admin_design')

@section('title')
Setting | Admin Hsn E-commerce
@endsection

@section('content')

<div id="content">
<div id="content-header">
    <div id="breadcrumb"> <a href="{{url('admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                class="icon-home"></i> {{__('backend.home')}}</a><a href="{{url('/admin/settings')}}" class="current">{{__('backend.settings')}}</a>
    </div>
    <h1>{{__('backend.admin_settings')}}</h1>
    @if(Session::has('flash_message_error'))
    <div class="alert alert-dark alert-block"
        style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
    </div>
    @endif
    @if(Session::has('flash_message_drop'))
    <div class="alert alert-success alert-block"
        style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
    </div>
    @endif
    @if(Session::has('flash_message_success'))
    <div class="alert alert-dark alert-block"
        style="background-color:green; color:white; width:21%; margin-left:20px;"> 
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong> {{__('backend.'.Session::get('flash_message_success'))}}</strong>
    </div>
    @endif
    <div id="loading"></div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                            <h5>{{__('backend.update_password')}}</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{url('/admin/update-pwd')}}"
                                name="password_validate" id="password_validate" novalidate="novalidate">
                                {{csrf_field()}}
                                <div class="control-group">
                                    <label class="control-label">{{__('backend.username')}}</label>
                                    <div class="controls">
                                        <input type="text" value="{{$adminDetails->username}}" name="{{$adminDetails->username}}" readonly/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{__('backend.current_password')}}</label>
                                    <div class="controls">
                                        <input type="password" name="current_pwd" id="current_pwd" />
                                        <span id="chkPwd"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{__('backend.new_password')}}</label>
                                    <div class="controls">
                                        <input type="password" name="new_pwd" id="new_pwd" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{__('backend.confirm_password')}}</label>
                                    <div class="controls">
                                        <input type="password" name="confirm_pwd" id="confirm_pwd" />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="{{__('backend.update_password')}}" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
