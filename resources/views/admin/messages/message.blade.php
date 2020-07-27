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

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"> <iclass="icon-home"></i>{{__('backend.home')}}
            </a> <a href="{{$module->permalink}}">Messages</a>
            <a href="#" class="current">Message</a> </div>
        <h1>Messages</h1>

    </div>
    <div class="container-fluid">
        <hr> 
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box widget-chat">
                    <div class="responsif-costume">
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

</div>

@endsection
