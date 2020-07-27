@extends('layouts.adminLayout.admin_design')

@section('title')
View Banners | Admin Hsn E-commerce
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
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.banners')}}</a>
            <a href="#" class="current">{{__('backend.view_banner')}}</a> </div>
        <h1>{{__('backend.banners')}}</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>{{__('backend.view_banner')}}</h5>
                        </div>
                        <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                            @csrf
                            <div class="widget-content nopadding">
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
                                        @foreach($banners as $banner)
                                        <tr class="gradeX">
                                            <th scope="row" class="center">
                                            @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$banner->id }}" name="data_id[{{ $banner->id }}]" onclick="checkInputValue(this)">
                                                    <label class="custom-control-label" for="{{ 'child-'.$banner->id }} "></label>
                                                </div>
                                            @else
                                                {{ ++$no }}
                                            @endif
                                            </th>
                                            <td class="center">{{$banner->title}}</td>
                                            <td class="center" >{{$banner->link}}</td>
                                            <td class="center" >
                                            @if($banner->status==1)
                                                <span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes </span>
                                            @else
                                                <span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No </span>
                                            @endif
                                            </td>
                                            <td class="center"  width="25%">
                                                @if(!empty($banner->image))
                                            <a href="javascript:"> <img src="{{ file_exists('images/backend_images/banners/'.$banner->image) ? asset('images/backend_images/banners/'.$banner->image ) : $url_amazon.'banners/images/'.$banner->image }}" alt="image product" onclick="popupGambar(this)" width="300"> </a>
                                                @endif
                                            </td>
                                            <td class="center" >{{Carbon::parse($banner->created_at)->format('l, j F Y | H:i')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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