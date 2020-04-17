@extends('layouts.adminLayout.admin_design')

@section('title')
view users
@endsection

@section('content')

<?php
use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.users')}}</a>
            <a href="{{url('/admin/view-categories')}}" class="current">{{__('backend.view_users')}}</a> </div>
        <h1>{{__('backend.users')}}</h1>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block"
            style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_drop')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block"
            style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
        @endif
    </div>
    <div id="loading"></div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>{{__('backend.view_users')}}</h5>
                        <a href="{{url('/admin/export-users')}}" class="btn btn-success btn-xm" style="float: right; margin-right: 18px;"> <i class=" icon-screenshot" style="margin-right: 7px;"></i> Export Excel</a>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">{{__('backend.users_id')}}</th>
                                        <th style="font-size:100%;">{{__('backend.name')}}</th>
                                        <th style="font-size:100%;">{{__('backend.address')}}</th>
                                        <th style="font-size:100%;">{{__('backend.city')}}</th>
                                        <th style="font-size:100%;">{{__('backend.state')}}</th>
                                        <th style="font-size:100%;">{{__('backend.country')}}</th>
                                        <th style="font-size:100%;">{{__('backend.pincode')}}</th>
                                        <th style="font-size:100%;">{{__('backend.mobile')}}</th>
                                        <th style="font-size:100%;">{{__('backend.email')}}</th>
                                        <th style="font-size:100%;">{{__('backend.status')}}</th>
                                        <th style="font-size:100%;">{{__('backend.register_on')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="">
                                        <td style="text-align:center;">{{$user->id}}</td>
                                        <td style="text-align:center;">{{$user->name}}</td>
                                        <td style="text-align:center;">{{$user->address}}</td>
                                        <td style="text-align:center;">{{$user->city}}</td>
                                        <td style="text-align:center;">{{$user->state}}</td>
                                        <td style="text-align:center;">{{$user->country}}</td>
                                        <td style="text-align:center;">{{$user->pincode}}</td>
                                        <td style="text-align:center;">{{$user->mobile}}</td>
                                        <td style="text-align:center;">{{$user->email}}</td>
                                        <td style="text-align:center;">
                                            @if($user->status==1)
                                            <span class="badge badge-success">{{__('backend.active')}}</span>
                                            @else
                                            <span class="badge badge-danger" style="background-color:Crimson;">{{__('backend.inactive')}}</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{Carbon::parse($user->created_at)->format('l, j F Y | H:i A')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')


@endsection