@extends('layouts.adminLayout.admin_design')

@section('title')
View Newsletters | Admin Hsn E-commerce
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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">Newsletter Subscribers</a>
            <a href="#" class="current">View Newsletter</a> </div>
        <h1>Newsletter Subscribers</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                  <div class="responsif-costume">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Newsletter</h5>
                        @if($page->fetch_role('alter', $module) == TRUE)    
                          <a href="{{url($module->permalink.'/export-newsletter-emails')}}" class="badge badge-success btn-mini export_ex" > <i class=" icon-screenshot" style="margin-right: 7px;"></i> Export Excel</a>
                        @endif
                    </div>
                    <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                      @csrf
                      <div class="widget-content nopadding">
                          <div class="table-responsive">
                              <table class="table table-bordered data-table" id="newsletter_subscribers">
                                  <thead>
                                      <tr>
                                          <th>
                                          @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                              <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i> </a>
                                          @else
                                              #
                                          @endif
                                          </th>
                                          <th style="font-size:100%;">{{__('backend.email')}}</th>
                                          <th style="font-size:100%;">{{__('backend.status')}}</th>
                                          <th style="font-size:100%;">{{__('backend.register_on')}}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @php
                                          $no = 0;
                                      @endphp
                                      @foreach($newsletters as $newsletter)
                                      <tr class="">
                                          <th scope="row" class="center">
                                          @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                              <div class="custom-control custom-checkbox">
                                                  <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$newsletter->id }}" name="data_id[{{ $newsletter->id }}]" onclick="checkInputValue(this)">
                                                  <label class="custom-control-label" for="{{ 'child-'.$newsletter->id }} "></label>
                                              </div>
                                          @else
                                              {{ ++$no }}
                                          @endif
                                          </th>
                                          <td class="center" >{{$newsletter->email}}</td>
                                          <td class="center">
                                            @if($newsletter->status==1)    
                                              @if($page->fetch_role('alter', $module) == TRUE)                              
                                                <a href="javascript:" id="{{$newsletter->id}}"> <span class="badge badge-info" style="margin-right: 10px;" onclick="editStatusNewsletter({{$newsletter->id}})" ><i class="icon icon-ok"></i> Yes </span> </a> 
                                              @else
                                                <span class="badge badge-info" style="margin-right: 10px;" ><i class="icon icon-ok"></i> Yes </span>
                                              @endif
                                            @else
                                              @if($page->fetch_role('alter', $module) == TRUE)
                                                <a href="javascript:" id="{{$newsletter->id}}"> <span class="badge badge-important" style="margin-right: 10px;" onclick="editStatusNewsletter({{$newsletter->id}})" ><i class="icon icon-ban-circle"></i> No </span> </a> 
                                              @else
                                                <span class="badge badge-important" style="margin-right: 10px;" ><i class="icon icon-ban-circle"></i> No </span>
                                              @endif
                                            @endif
                                          </td>
                                          <td class="center">{{Carbon::parse($newsletter->created_at)->format('l, j F Y | H:i A')}}</td>
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

  function editStatusNewsletter(id) {
    $.ajax({
      type: 'get',
      url:"{{URL::route('edit-status-newsletter')}}",
      data: {id:id },
      cache:false,
      success: function(resp) {
        if(resp == "success1") {
          $('#'+id+'').html("<span class='badge badge-important' style='margin-right: 10px;' onclick='editStatusNewsletter(\"" + id + "\")' ><i class='icon icon-ban-circle'></i> No </span>")
          new PNotify({
              title: 'Success !',
              text: 'the status is changed to No Active',
              type: 'error',
              cornerclass: 'ui-pnotify-sharp'
                      });
        } else if (resp == "success0") {
          $('#'+id+'').html("<span class='badge badge-info' style='margin-right: 10px;' onclick='editStatusNewsletter(\"" + id + "\")' ><i class='icon icon-ok'></i> Yes </span>")
          new PNotify({
              title: 'Success !',
              text: 'the status is changed to Actived',
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