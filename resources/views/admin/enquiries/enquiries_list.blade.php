@extends('layouts.adminLayout.admin_design')

@section('title')
Enquiries List| Admin Hsn E-commerce
@endsection

@section('content')

<?php
 use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="#">Enquiries Users</a>
            <a href="{{url('/admin/view-categories')}}" class="current">Enquiries List</a> </div>
        <h1>Enquiries Users</h1>

@if(Session::has('flash_message_success')) 
  <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item" style="background: lightseagreen;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/done.png')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Successfully ! </b></span>
             <p><b> {{Session::get('flash_message_success')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
  </div>
@endif
@if(Session::has('flash_message_error')) 
 <div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
     <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
  <div class="gritter-top">
  </div>
      <div class="gritter-item" style="background: red;">
        <div class="gritter-close" style="display: none;">
          </div><img src="{{url('images/fail.jpg')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
            <div class="gritter-with-image">
              <span class="gritter-title"> <b>Failed ! </b></span>
             <p><b> {{Session::get('flash_message_error')}} </b></p>
           </div ><div style="clear:both">
          </div>
         </div>
       <div class="gritter-bottom">
     </div>
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
                        <h5>Enquiries List</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="news_info">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">No</th>
                                        <th style="font-size:100%;">Name</th>
                                        <th style="font-size:100%;">Email</th>
                                        <th style="font-size:100%;">Subject</th>
                                        <th style="font-size:100%;">Message</th>
                                        <th style="font-size:100%; width:190px">Created</th>
                                        <th style="font-size:100%; width: 200px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @php $no = 0; @endphp
                                    @foreach($enquiriesList as $enqlist)
                                    @php $no++ @endphp
                                    <tr class="">
                                        <td style="text-align:center;">{{$no}}</td>
                                        <td style="text-align:center;">{{$enqlist->name}}</td>
                                        <td style="text-align:center;">{{$enqlist->email}}</td>
                                        <td style="text-align:center;">{{$enqlist->subject}}</td>
                                        <td style="text-align:center;">{{$enqlist->message}}</td>
                                        <td style="text-align:center;">{{Carbon::parse($enqlist->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">
                                         <a href="javacript:" class="btn btn-info btn-xm " onclick="replyEnquiries({{$enqlist->id}})"><i class="icon-cogs" style="padding: 0 5px"></i>Reply</a>
                                         <a hreft="javascript:" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-id="{{$enqlist->id}}" onclick="modalEnquiriesUsers(this)"><i class="icon-trash"></i>&nbsp; {{__('backend.delete')}}</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete This Enquiries Users !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -32px;">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this Enquiries Users ?
      </div>
      <div class="modal-footer"> 
        <input type="hidden" id="enquiriesId" value="">
        <button type="button" class="btn btn-primary" style="background: black;" data-dismiss="modal"> <i class="icon-arrow-left" style=""></i>&nbsp; Cancel</button>
        <a hreft="javascript:" class="btn btn-danger" onclick="deleteEnquiriesUsers()"><i class="icon-trash"></i>&nbsp; {{__('backend.delete')}}</a>
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

        function modalEnquiriesUsers(resp) {
            var id = $(resp).data("id")
            $("#enquiriesId").val(id)
        }   

        function deleteEnquiriesUsers() {
            var id = $("#enquiriesId").val()
            window.location.href ="/admin/delete-enquiries-users/"+id;
        }


    </script>
@endsection