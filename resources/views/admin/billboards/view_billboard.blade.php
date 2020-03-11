@extends('layouts.adminLayout.admin_design')

@section('content')
@php
use Carbon\Carbon;
@endphp
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i> Home</a> <a href="#">Billboards</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Billboard</a> </div>
        <h1>Billboards</h1>
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
                        <h5>View Billboard</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped no-footer data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">NO</th>
                                        <th style="font-size:100%;">Title</th>
                                        <th style="font-size:100%;">Link</th>
                                        <th style="font-size:100%;">Status</th>
                                        <th style="font-size:100%;">Create Date</th>
                                        <th style="font-size:100%; width:156px;">Image</th>
                                        <th style="font-size:100%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 0;
                                    @endphp
                                    @foreach($billboard as $bill)
                                    <tr class="gradeX">
                                        <td style="text-align:center;">{{++$no}}</td>
                                        <td style="text-align:center;">{{$bill->title}}</td>
                                        <td style="text-align:center;">{{$bill->link}}</td>
                                        <td style="text-align:center;"> @if($bill->status==1)<span class="badge badge-success">Active</span>@else <span class="badge badge-danger" style="background-color:Crimson;">InActive</span>@endif</td>
                                        <td style="text-align:center;">{{Carbon::parse($bill->created_at)->format('l, j F Y | H:i')}}</td>
                                        <td style="text-align:center;" style="width: 166px; height: 215px;">
                                            @if(!empty($bill->image))
                                            <img src="{{ asset('images/backend_images/banners/'.$bill->image )}}"
                                                alt="image billboard">
                                            @endif
                                        </td>
                                        <td class="center" style="text-align:center;" width="14%;">
                                            <a href="{{url('/admin/edit-billboard/'.$bill->id)}} "
                                                class="btn btn-warning btn-mini" style="margin:35px 0 0 10px;"
                                                title="Edit Billboard"> <i class="icon-cogs" style="padding:0 4px"></i>
                                                Edit</a>
                                            <a rel="{{$bill->id}}" rel1="delete-billboard" rel2="{{$bill->title}}"
                                                href="javascript:" class="deleteProd btn btn-danger btn-mini"
                                                data-del-id="{{$bill->id}}" style="margin:35px 0 0 10px;"
                                                title="Delete Billboard">
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