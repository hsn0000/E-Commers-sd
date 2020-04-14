@extends('layouts.adminLayout.admin_design')

@section('content')

<?php
use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">Admins | Roles</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Admins</a> </div>
        <h1>Admins | Roles</h1>
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
                        <h5>View Admins</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="table_view_admin">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">ID</th>
                                        <th style="font-size:100%;">Username</th>
                                        <th style="font-size:100%;">Type</th>
                                        <th style="font-size:100%;">Roles</th>
                                        <th style="font-size:100%;">{{__('backend.status')}}</th>
                                        <th style="font-size:100%;">Created on</th>
                                        <th style="font-size:100%;">Updated on</th>
                                        <th style="font-size:100%;">{{__('backend.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $admin)
                                    @php 
                                          if($admin->type == "Admin") {
                                              $roles = "<span class='badge badge-pill' style='background-color: dodgerblue;'>All</span>";
                                          } else {
                                              $roles = "";
                                              if($admin->categories_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: deepskyblue;'>Categories </span> &nbsp;";
                                              } if($admin->products_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: palevioletred;'>Products </span> &nbsp;";
                                              } if($admin->order_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: mediumseagreen;'>Orders </span> &nbsp;";
                                              } if($admin->users_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: darkorange;'>Users </span> &nbsp;";
                                              } 
                                          }
                                    @endphp
                                    <tr class="">
                                        <td style="text-align:center;">{{$admin->id}}</td>
                                        <td style="text-align:center;">{{$admin->username}}</td>
                                        <td style="text-align:center;">{{$admin->type}}</td>
                                        <td style="">{!! $roles !!}</td>
                                        <td style="text-align:center;">
                                            @if($admin->status==1)
                                            <span class="badge badge-success">{{__('backend.active')}}</span>
                                            @else
                                            <span class="badge badge-danger" style="background-color:Crimson;">{{__('backend.inactive')}}</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{Carbon::parse($admin->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">{{Carbon::parse($admin->updated_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;"> <a href="{{url('/admin/edit-admins/'.$admin->id)}} " class="btn btn-warning btn-mini" title="Edit Roles"> <i class="icon-cogs" style="padding:0 4px"></i> {{__('backend.edit')}}</a> </td>
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

<script>
  $(document).ready(function() {
    $("#test").DataTable({ "order": [[6, "desc"]] });
  })
</script>

@endsection