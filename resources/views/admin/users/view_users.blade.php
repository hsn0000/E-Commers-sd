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
                    class="icon-home"></i> Home</a> <a href="#">Users</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Users</a> </div>
        <h1>Users</h1>
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
                        <h5>View Users</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">Users ID</th>
                                        <th style="font-size:100%;">Name</th>
                                        <th style="font-size:100%;">Address</th>
                                        <th style="font-size:100%;">City</th>
                                        <th style="font-size:100%;">State</th>
                                        <th style="font-size:100%;">Country</th>
                                        <th style="font-size:100%;">Pincode</th>
                                        <th style="font-size:100%;">Mobile</th>
                                        <th style="font-size:100%;">Email</th>
                                        <th style="font-size:100%;">Status</th>
                                        <th style="font-size:100%;">Register on</th>
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
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger" style="background-color:Crimson;">InActive</span>
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