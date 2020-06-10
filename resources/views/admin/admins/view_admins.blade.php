@extends('layouts.adminLayout.admin_design')
@section('title')
View Admins | Admin Hsn E-commerce
@endsection

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
                                        <th style="font-size:100%;">No</th>
                                        <th style="font-size:100%;">Username</th>
                                        <th style="font-size:100%;">Avatar</th>
                                        <th style="font-size:100%;">Type</th>
                                        <th style="font-size:100%;">Roles</th>
                                        <th style="font-size:100%;">{{__('backend.status')}}</th>
                                        <th style="font-size:100%;">Created on</th>
                                        <th style="font-size:100%;">Updated on</th>
                                        <th style="font-size:100%;">{{__('backend.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $no = 1; @endphp
                                    @foreach($admins as $admin)
                                    @php 
                                          if($admin->type == "Admin") {
                                              $roles = "<span class='badge badge-pill' style='background-color: dodgerblue;'>All</span>";
                                          } else {
                                              $roles = "";
                                              if($admin->categories_view_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: deepskyblue;'>View Categories Only </span> &nbsp;";
                                              } if($admin->categories_edit_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: darkslategrey;'> Edit Categories Only</span> &nbsp;";
                                              } if($admin->categories_full_access == 1) {
                                                  $roles .= "<span class='badge badge-pill' style='background-color: darkorchid;'>Full Categories </span> &nbsp;";
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
                                        <td style="text-align:center;">{{$no++}}</td>
                                        <td style="text-align:center;">{{$admin->username}}</td>
                                        @if($admin->avatar == "")
                                        <td style="text-align:center;"> <img width ="80" height="80" src="{{ asset('images/backend_images/admin.png') }}" alt="kosong"></td>
                                        @else 
                                        <td style="text-align:center;"> <img width ="80" height="80" src="{{ asset('images/backend_images/avatar/'.$admin->avatar ) }}" alt="kosong"></td>
                                        @endif
                                        <td style="text-align:center;">{{$admin->type}}</td>
                                        <td style="">{!! $roles !!}</td>
                                        <td style="text-align:center;">
                                            @if($admin->status==1)
                                            <a class="badge badge-success" id="{{$admin->id}}" onclick="editStatusAdmin({{$admin->id}})">{{__('backend.active')}}</a>
                                            @else
                                            <a class="badge badge-danger" id="{{$admin->id}}" style="background-color:Crimson;" onclick="editStatusAdmin({{$admin->id}})">{{__('backend.inactive')}}</a>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{Carbon::parse($admin->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">{{Carbon::parse($admin->updated_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">
                                         <a href="{{url('/admin/edit-admins/'.$admin->id)}} " class="btn btn-warning btn-mini" title="Edit Roles"> <i class="icon-cogs" style="padding:0 4px"></i> {{__('backend.edit')}}</a> 
                                         <a class="btn btn-danger btn-mini "  data-toggle="modal" data-target="#exampleModal" data-id="{{$admin->id}}" onclick="modalAdmins(this)"><i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
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

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete This Role !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -32px;">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this Role ?
      </div>
      <div class="modal-footer"> 
        <input type="hidden" id="id_value" value="">
        <button type="button" class="btn btn-primary" style="background: black;" data-dismiss="modal"> <i class="icon-arrow-left" style=""></i>&nbsp; Cancel</button>
        <a hreft="javascript:" class="btn btn-danger" onclick="deleteAdmins()"><i class="icon-trash"></i>&nbsp; {{__('backend.delete')}}</a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script>
  function modalAdmins(resp) {
      var id = $(resp).data("id")
      $("#id_value").val(id)
  }   

  function deleteAdmins() {
      var id = $("#id_value").val()
      window.location.href ="/admin/delete-admins/"+id;
  }


function editStatusAdmin(id) {
  /* ajax */ 
  $.ajax({
    type: 'get',
    url: '/admin/edit-status-admins',
    data: {
      id:id
    }, success: function(resp) {
      if(resp == "success1") {
        $('#'+id+'').text('In Active')
        $('#'+id+'').attr('style','background-color:Crimson;')
        new PNotify({
            title: 'Success !',
            text: 'the status is changed to InActive',
            type: 'error',
            cornerclass: 'ui-pnotify-sharp'
                    });
      } else if (resp == "success0") {
        $('#'+id+'').text('Active')
        $('#'+id+'').attr('style','background-color:#468847;')
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