@extends('layouts.adminLayout.admin_design')

@section('title')
Messages | Admin Hsn E-commerce
@endsection
@section('style')
<style>
.active {
    background: #eeeeee;
}
</style>
@endsection

@section('content')

<?php
 use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom">
                <iclass="icon-home"></i>{{__('backend.home')}}
            </a> <a href="#">Messages</a>
            <a href="{{url('/admin/view-categories')}}" class="current">Message</a> </div>
        <h1>Messages</h1>

        @if(Session::has('flash_message_success'))
        <div id="gritter-item-1" class="gritter-item-wrapper"
            style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
            <a href="javascript:" class="closeToast"> <span
                    style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x
                </span> </a>
            <div class="gritter-top">
            </div>
            <div class="gritter-item" style="background: lightseagreen;">
                <div class="gritter-close" style="display: none;">
                </div><img src="{{url('images/done.png')}}" class="gritter-image"
                    style="width: 52px; height: 50px; padding-right: 9px;">
                <div class="gritter-with-image">
                    <span class="gritter-title"> <b>Successfully ! </b></span>
                    <p><b> {{Session::get('flash_message_success')}} </b></p>
                </div>
                <div style="clear:both">
                </div>
            </div>
            <div class="gritter-bottom">
            </div>
        </div>
        @endif
        @if(Session::has('flash_message_error'))
        <div id="gritter-item-1" class="gritter-item-wrapper"
            style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
            <a href="javascript:" class="closeToast"> <span
                    style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x
                </span> </a>
            <div class="gritter-top">
            </div>
            <div class="gritter-item" style="background: red;">
                <div class="gritter-close" style="display: none;">
                </div><img src="{{url('images/fail.jpg')}}" class="gritter-image"
                    style="width: 52px; height: 50px; padding-right: 9px;">
                <div class="gritter-with-image">
                    <span class="gritter-title"> <b>Failed ! </b></span>
                    <p><b> {{Session::get('flash_message_error')}} </b></p>
                </div>
                <div style="clear:both">
                </div>
            </div>
            <div class="gritter-bottom">
            </div>
        </div>
        @endif
    </div>
    <div id="loading"></div>

    <div class="container-fluid">
        <hr> 
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box widget-chat">
                    <div class="widget-title"> <span class="icon"> <i class="icon-comment"></i> </span>
                        <h5>p</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="chat-users panel-right2">
                            <div class="panel-title">
                                <h5>Online Users</h5>
                            </div>
                            @foreach($usersAll as $user)
                            <div class="panel-content nopadding">
                                <ul class="contact-list">
                                    <li id="{{$user->id}}" class="user"><a href="javascript:"><img src="{{ $user->avatar != '' ? (asset('/images/photo/profile/'.$user->avatar)) : (asset('/images/backend_images/userss.png')) }}" alt="photo pfrofile"> <span>{{$user->name}}</span></a>
                                    @if($user->unread != 0)<span class="msg-count badge badge-info">{{$user->unread}}</span>@endif</li>
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        <div class="chat-content panel-left2" id="messages">
                          <!-- html -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
