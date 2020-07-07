@extends('layouts.adminLayout.admin_design')
@section('title')
User Group | Admin Hsn E-commerce
@endsection

@section('link')
<style>

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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{ $module->permalink }}">User Group</a>
            <a href="{{ $module->permalink }}" class="current">View User Group</a> </div>
        <h1>User Group</h1>
    </div>
    @if($get_data->count() > 0)
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>View User Group</h5>
                    </div>
                    <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                        @csrf
                        <div class="widget-content nopadding">
                            <div class="table-responsive">
                                <table class="table table-bordered data-table" >
                                    <thead class="thead-dark">
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle">
                                            @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i>
                                                </a>
                                            @else
                                                #
                                            @endif
                                            </th>
                                            <th rowspan="2" style="font-size:100%; vertical-align: middle">Group Name</th>
                                            <th rowspan="2" style="font-size:100%; vertical-align: middle">Total User</th>
                                            <th colspan="4" style="font-size:100%;">Module</th>
                                        </tr>
                                        <tr>
                                            <th style="font-size:100%;">View</th>
                                            <th style="font-size:100%;">Create</th>
                                            <th style="font-size:100%;">Alter</th>
                                            <th style="font-size:100%;">Drop</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp  
                                    @foreach($get_data->get() as $key => $val )
                                    @php
                                        $_roles = $val->roles ? json_decode($val->roles) : null;
                                    @endphp         
                                        <tr class="">
                                            <th scope="row" style="text-align:center;">
                                            @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$val->guid }}" name="data_id[{{ $val->guid }}]" onclick="checkInputValue(this)">
                                                    <label class="custom-control-label" for="{{ 'child-'.$val->guid }} "></label>
                                                </div>
                                            @else
                                                {{ ++$key }}
                                            @endif
                                            </th>
                                            <td style="text-align:center;">{{$val->gname}}</td>
                                            <td style="text-align:center;">{{ $query->get_total_user_group($val->guid) }}</td>
                                            <td style="text-align:center;">{{ $_roles != null && isset($_roles->view) ? count(explode(',', $_roles->view)) : 0 }}</td>
                                            <td style="text-align:center;">{{ $_roles != null && isset($_roles->create ) ? count(explode(',', $_roles->create)) : 0 }}</td>
                                            <td style="text-align:center;">{{ $_roles != null && isset($_roles->alter ) ? count(explode(',', $_roles->alter)) : 0 }}</td>
                                            <td style="text-align:center;">{{ $_roles != null && isset($_roles->drop ) ? count(explode(',', $_roles->drop)) : 0 }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endif

</div>

@endsection

@section('script')


@endsection