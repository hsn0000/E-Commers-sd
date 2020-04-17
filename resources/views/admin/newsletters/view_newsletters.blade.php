@extends('layouts.adminLayout.admin_design')

@section('title')

@endsection

@section('content')

<?php
use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="#">Newsletter Subscribers</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Newsletter</a> </div>
        <h1>Newsletter Subscribers</h1>
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
                        <h5>Newsletter</h5>
                        <a href="{{url('/admin/export-newsletter-emails')}}" class="btn btn-success btn-xm" style="float: right; margin-right: 18px;"> <i class=" icon-screenshot" style="margin-right: 7px;"></i> Export Excel</a>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">{{__('backend.users_id')}}</th>
                                        <th style="font-size:100%;">{{__('backend.email')}}</th>
                                        <th style="font-size:100%;">{{__('backend.status')}}</th>
                                        <th style="font-size:100%;">{{__('backend.register_on')}}</th>
                                        <th style="font-size:100%;">{{__('backend.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($newsletters as $newsletter)
                                    <tr class="">
                                        <td style="text-align:center;">{{$newsletter->id}}</td>
                                        <td style="text-align:center;">{{$newsletter->email}}</td>
                                        <td style="text-align:center;">
                                            @if($newsletter->status==1)
                                               <a href="{{url('/admin/update-newsletter-status/'.$newsletter->id.'/0')}}"><span class="badge badge-success">{{__('backend.active')}}</span> </a> 
                                            @else
                                               <a href="{{url('/admin/update-newsletter-status/'.$newsletter->id.'/1')}}"><span class="badge badge-danger" style="background-color:Crimson;">{{__('backend.inactive')}}</span> </a> 
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{Carbon::parse($newsletter->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">
                                         <a href="javascript:" class="btn btn-danger btn-xm deleteNewsletter"  data-toggle="modal" data-target="#exampleModal" data-id="{{$newsletter->id}}" onclick="modalNewsletter(this)"><i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete Newsletter !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -32px;">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this Newsletter ?
      </div>
      <div class="modal-footer"> 
        <input type="hidden" id="idnewsleter" value="">
        <button type="button" class="btn btn-primary" style="background: black;" data-dismiss="modal"> <i class="icon-arrow-left" style=""></i>&nbsp; Cancel</button>
        <a hreft="javascript:"  class="btn btn-danger" onclick="deleteNewsletter()"><i class="icon-trash" style="" ></i>&nbsp; {{__('backend.delete')}}</a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')


@endsection