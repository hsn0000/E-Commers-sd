@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i> Home</a> <a href="#">Banners</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Banner</a> </div>
        <h1>Banners</h1>
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
                        <h5>View Banner</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped no-footer data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">NO</th>
                                        <th style="font-size:100%;">Banner ID</th>
                                        <th style="font-size:100%;">Title</th>
                                        <th style="font-size:100%;">Link</th>
                                        <th style="font-size:100%;">Status</th>
                                        <th style="font-size:100%;">Image</th>
                                        <th style="font-size:100%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 0;
                                    @endphp
                                    @foreach($banners as $banner)
                                    <tr class="gradeX">
                                        <td style="text-align:center;">{{++$no}}</td>
                                        <td style="text-align:center; width:9%">{{$banner->id}}</td>
                                        <td style="text-align:center;">{{$banner->title}}</td>
                                        <td style="text-align:center;">{{$banner->link}}</td>
                                        <td style="text-align:center;"> @if($banner->status==1)<span class="badge badge-success">Active</span>@else <span class="badge badge-danger" style="background-color:Crimson;">InActive</span>@endif</td>
                                        <td style="text-align:center;" width="25%">
                                            @if(!empty($banner->image))
                                            <img src="{{ asset('images/backend_images/banners/'.$banner->image )}}"
                                                alt="image product">
                                            @endif
                                        </td>
                                        <td class="center" style="text-align:center;" width="14%;">
                                            <a href="{{url('/admin/edit-banner/'.$banner->id)}} "
                                                class="btn btn-warning btn-mini" style="margin:35px 0 0 10px;"
                                                title="Edit Banner"> <i class="icon-cogs" style="padding:0 4px"></i>
                                                Edit</a>
                                            <a rel="{{$banner->id}}" rel1="delete-banner" rel2="{{$banner->title}}"
                                                href="javascript:" class="deleteProd btn btn-danger btn-mini"
                                                data-del-id="{{$banner->id}}" style="margin:35px 0 0 10px;"
                                                title="Delete Banner">
                                                <i class="icon-remove" style="padding: 0 5px"></i>Delete</a>
                                        </td>
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