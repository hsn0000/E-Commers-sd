@extends('layouts.adminLayout.admin_design')

@section('title')
view users
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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{url($module->permalink)}}">{{__('backend.users')}}</a>
            <a href="#" class="current">{{__('backend.view_users')}}</a> </div>
        <h1>{{__('backend.users')}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action')
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>{{__('backend.view_users')}}</h5>
                        @if($page->fetch_role('create', $module) == true )
                            <a href="{{url($module->permalink.'/export-users')}}" class="badge badge-success btn-mini export_ex" > <i class=" icon-screenshot" style="margin-right: 7px;"></i> export excel</a>
                        @endif
                        @if(!empty(isset($_data_table)))
                            <a href="{{url($module->permalink.'/view-users-countries-charts')}}" class="badge badge-info btn-mini export_ex" > <i class=" icon-screenshot" style="margin-right: 7px;"></i> countries charts </a>
                            <a href="{{url($module->permalink.'/view-users-charts')}}" class="badge badge-inverse btn-mini export_ex" > <i class=" icon-screenshot" style="margin-right: 7px;"></i> users chart </a>
                        @endif
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">#</th>
                                        <th style="font-size:100%;">{{__('backend.name')}}</th>
                                        <th style="font-size:100%;"> Avatar </th>
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
                                    @foreach($_data_table as $key => $user)
                                    <tr class="">
                                        <td style="text-align:center;">{{$user['no']}}</td>
                                        <td style="text-align:center;">{{$user['name']}}</td>
                                        <td style="text-align:center;">
                                            <a href="javascript:">
                                                <img src="{{ $user['avatar'] != '' ? (asset('/images/photo/profile/'.$user['avatar'])) : (asset('/images/backend_images/userss.png')) }}" class="rounded" alt="avatar" width="110" onclick="popupGambar(this)">
                                            </a>
                                        </td>
                                        <td style="text-align:center;">{{$user['address'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['city'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['state'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['country'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['pincode'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['mobile'] != null ? $user['address'] : '---' }}</td>
                                        <td style="text-align:center;">{{$user['email']}}</td>
                                        <td style="text-align:center;">{!! $user['status'] !!}</td>
                                        <td style="text-align:center;">{{$user['created_at']}}</td>
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