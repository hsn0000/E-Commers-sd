@extends('layouts.adminLayout.admin_design')
@section('title') 
User Admin | Admin Hsn E-commerce
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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{ $module->permalink }}">User Admin</a>
            <a href="{{ $module->permalink }}" class="current">View User Admin</a> </div>
        <h1>User Admin</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                @include('layouts.adminLayout.actions.action')
                <div class="widget-box">
                    <div class="responsif-costume">
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
                                                <th>
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i>
                                                    </a>
                                                @else
                                                    #
                                                @endif
                                                </th> 
                                                <th style="font-size:100%;"> Name</th>
                                                <th style="font-size:100%;"> Group </th>
                                                <th style="font-size:100%;"> Status </th>                                 
                                                <th style="font-size:100%;"> Created </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data_table as $key => $val)
                                            <tr class="">
                                                <th scope="row" style="text-align:center;">
                                                @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$val['id'] }}" name="data_id[{{ $val['id'] }}]" onclick="checkInputValue(this)">
                                                        <label class="custom-control-label" for="{{ 'child-'.$val['id'] }}" ></label>
                                                    </div>
                                                @else
                                                    {{ ++$key }}
                                                @endif
                                                </th>
                                                <td style="text-align:center;"> {{ $val['name'] }} <br> <span class="span-bottom"> {{ $val['email'] }}</span> </td>
                                                <td style="text-align:center;"> {{ $val['gname'] }} </td>
                                                <td style="text-align:center;">
                                                @if($page->fetch_role('alter', $module) == TRUE)
                                                    <a href="javascript:void(0)" onclick="editStatusAdmin({{$val['id']}})" id="{{'status'.$val['id']}}"> {!! $val['status'] !!} </a>
                                                @else
                                                    {!! $val['status'] !!}
                                                @endif
                                                </td>
                                                <td style="text-align:center;"> {{ $val['join_date'] }} </td>
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
$(document).ready(function() {
    $('.DataTables_sort_icon, .css_right ui-icon, .ui-icon-triangle-1-n').remove()
})


function checkInputValue(e) {
    id = e.id
    $(".check_usergroup").prop('checked', false)
    $("#"+id).prop('checked', true)
}


function radioNetral() {
    $(".check_usergroup").prop('checked', false);
}


function editStatusAdmin(id) {
  /* ajax */ 
  $.ajax({
    type: 'get',
    url: '/user/admin/edit-status-admins',
    data: {
      id:id
    }, success: function(resp) {
      if(resp == "success1") {
        $('#status'+id).html('<span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No</span>')
        new PNotify({
            title: 'Success !',
            text: 'the status is changed to InActive',
            type: 'error',
            cornerclass: 'ui-pnotify-sharp'
                    });
      } else if (resp == "success0") {
        $('#status'+id).html('<span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes</span>');
        new PNotify({
            title: 'Success !',
            text: 'the status is changed to Active',
            type: 'success',
            cornerclass: 'ui-pnotify-sharp'
                   });
      }
     
    }, error: function(err) {
      console.log("error")
    }
  })
}


</script>


@endsection