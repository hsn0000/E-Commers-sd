@extends('layouts.adminLayout.admin_design')
@section('title')
View Billboard | Admin Hsn E-commerce
@endsection

@section('content')
@php
use Carbon\Carbon;
@endphp

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.billboards')}}</a>
            <a href="#" class="current">{{__('backend.view_billboard')}}</a> </div>
        <h1>{{__('backend.billboards')}}</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>{{__('backend.view_billboard')}}</h5>
                        </div>
                        <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                            @csrf
                            <div class="widget-content nopadding">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped no-footer data-table">
                                        <thead>
                                            <tr>
                                                <th>
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i>
                                                    </a>
                                                @else
                                                    #
                                                @endif
                                                </th>
                                                <th style="font-size:100%;">{{__('backend.title')}}</th>
                                                <th style="font-size:100%;">{{__('backend.link')}}</th>
                                                <th style="font-size:100%;">{{__('backend.status')}}</th>
                                                <th style="font-size:100%;">{{__('backend.image')}}</th>
                                                <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no = 0;
                                            @endphp
                                            @foreach($billboard as $bill)
                                            <tr class="gradeX">
                                                <th scope="row" class="center">
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$bill->id }}" name="data_id[{{ $bill->id }}]" onclick="checkInputValue(this)">
                                                        <label class="custom-control-label" for="{{ 'child-'.$bill->id }} "></label>
                                                    </div>
                                                @else
                                                    {{ ++$no }}
                                                @endif
                                                </th>
                                                <td class="center">{{$bill->title}}</td>
                                                <td class="center">{{$bill->link}}</td>
                                                <td class="center" >
                                                @if($bill->status==1)
                                                    <span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes </span>
                                                @else
                                                    <span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No </span>'
                                                @endif
                                                </td>
                                     
                                                <td class="center" >
                                                    @if(!empty($bill->image))
                                                    <a href="javascript:"> <img width="110" src="{{ file_exists('images/backend_images/banners/'.$bill->image) ? asset('images/backend_images/banners/'.$bill->image ) : $url_amazon.'billboard/images/'.$bill->image }}" alt="image billboard" onclick="popupGambar(this)"> </a>
                                                    @endif
                                                </td>
                                                <td class="center">{{Carbon::parse($bill->created_at)->format('l, j F Y | H:i')}}</td>
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
    </div>
</div>

@endsection

@section('script')


@endsection