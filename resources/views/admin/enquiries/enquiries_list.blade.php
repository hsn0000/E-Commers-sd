@extends('layouts.adminLayout.admin_design')

@section('title')
Enquiries List| Admin Hsn E-commerce
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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">Enquiries Users</a>
            <a href="#" class="current">Enquiries List</a> </div>
        <h1>Enquiries Users</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action')
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Enquiries List</h5>
                        </div>
                        <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                            @csrf
                            <div class="widget-content nopadding">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table" id="news_info">
                                        <thead>
                                            <tr>
                                                <th>
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i> </a>
                                                @else
                                                    #
                                                @endif
                                                </th>
                                                <th style="font-size:100%;">Name</th>
                                                <th style="font-size:100%;">Email</th>
                                                <th style="font-size:100%;">Subject</th>
                                                <th style="font-size:100%;">Message</th>
                                                <th style="font-size:100%; width:190px">Created</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            @php $no = 0; @endphp
                                            @foreach($enquiriesList as $enqlist)
                                            @php $no++ @endphp
                                            <tr class="">
                                                <th scope="row" class="center">
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$enqlist->id }}" name="data_id[{{ $enqlist->id }}]" onclick="checkInputValue(this)">
                                                        <label class="custom-control-label" for="{{ 'child-'.$enqlist->id }} "></label>
                                                    </div>
                                                @else
                                                    {{ ++$no }}
                                                @endif
                                                </th>
                                                <td class="center">{{$enqlist->name}}</td>
                                                <td class="center">{{$enqlist->email}}</td>
                                                <td class="center">{{$enqlist->subject}}</td>
                                                <td class="center">{{$enqlist->message}}</td>
                                                <td class="center">{{Carbon::parse($enqlist->created_at)->format('l, j F Y | H:i A')}}</td>
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
    <script>
        function replyEnquiries(id) {
            new PNotify({
                title: 'Sorry !',
                text: 'the page will be available soon',
                type: 'info',
                cornerclass: 'ui-pnotify-sharp'
                    });
        }
    </script>
@endsection