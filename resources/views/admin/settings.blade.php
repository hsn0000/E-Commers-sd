@extends('layouts.adminLayout.admin_design')

@section('title')
Setting | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a><a href="#" class="current">{{__('backend.settings')}}</a>
    </div>
    <h1>{{__('backend.admin_settings')}}</h1>

    <div class="container-fluid">
        <hr> 
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span12">
                @include('layouts.adminLayout.actions.action')
                    <div class="widget-box">
                        <div class="responsif-costume">
                            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                                <h5>{{__('backend.update_password')}}</h5>
                            </div>
                            <div class="widget-content nopadding">
                                <form class="form-horizontal" method="post" action="{{url($module->permalink.'/update-pwd')}}" name="password_validate" id="password_validate" novalidate="novalidate">
                                    {{csrf_field()}}
                                    <div class="control-group">
                                        <label class="control-label">{{__('backend.username')}}</label>
                                        <div class="controls">
                                            <input type="text" value="{{$adminDetails->name}}" name="{{$adminDetails->name}}" readonly/>
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
                                        <button type="submit" class="btn btn-success">Save</button>
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
</div>


@endsection
