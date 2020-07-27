@extends('layouts.adminLayout.admin_design')

@section('title')
View News Information | Admin Hsn E-commerce
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
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">News Information</a>
            <a href="#" class="current">View News</a> </div>
        <h1>News Information</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                  <div class="responsif-costume">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>View News</h5>
                    </div>
                    <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                      @csrf
                      <div class="widget-content nopadding">
                          <table class="table table-bordered data-table" id="news_info">
                              <thead>
                                  <tr>
                                      <th>
                                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                          <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i></a>
                                      @else
                                          #
                                      @endif
                                      </th>
                                      <th style="font-size:100%;">{{__('backend.description')}}</th>
                                      <th style="font-size:100%;">{{__('backend.url')}}</th>
                                      <th style="font-size:100%;">{{__('backend.enable')}}</th>
                                      <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                                  </tr>
                              </thead>
                              <tbody> 
                                  @php $no = 0; @endphp
                                  @foreach($newsInfoAll as $newsinfo)
                                  <tr class="">
                                      <th scope="row" class="center">
                                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                          <div class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$newsinfo->id }}" name="data_id[{{ $newsinfo->id }}]" onclick="checkInputValue(this)">
                                              <label class="custom-control-label" for="{{ 'child-'.$newsinfo->id }} "></label>
                                          </div>
                                      @else
                                          {{ ++$no }}
                                      @endif
                                      </th>
                                      <td class="center">{{$newsinfo->description}}</td>
                                      <td class="center">{{$newsinfo->url}}</td>
                                      <td class="center">
                                          @if($newsinfo->status==1)    
                                            @if($page->fetch_role('alter', $module) == TRUE)                              
                                              <a href="javascript:" id="{{$newsinfo->id}}"> <span class="badge badge-info" style="margin-right: 10px;" onclick="editStatusNews({{$newsinfo->id}})" ><i class="icon icon-ok"></i> Yes </span> </a> 
                                            @else
                                              <span class="badge badge-info" style="margin-right: 10px;" ><i class="icon icon-ok"></i> Yes </span>
                                            @endif
                                          @else
                                            @if($page->fetch_role('alter', $module) == TRUE)
                                              <a href="javascript:" id="{{$newsinfo->id}}"> <span class="badge badge-important" style="margin-right: 10px;" onclick="editStatusNews({{$newsinfo->id}})" ><i class="icon icon-ban-circle"></i> No </span> </a> 
                                            @else
                                              <span class="badge badge-important" style="margin-right: 10px;" ><i class="icon icon-ban-circle"></i> No </span>
                                            @endif
                                          @endif
                                      </td>
                                      <td class="center" >{{Carbon::parse($newsinfo->created_at)->format('l, j F Y | H:i A')}}</td>
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

<script>
    
function editStatusNews(id) {
  /* ajax */ 
  $.ajax({
    type: 'get',
    url: '/news-information/admin/edit-status-newsinfo',
    data: {
      id:id
    }, success: function(resp) {
      if(resp == "success1") {
        $('#'+id+'').html("<span class='badge badge-important' style='margin-right: 10px;' onclick='editStatusNews(\"" + id + "\")' ><i class='icon icon-ban-circle'></i> No </span>")
        new PNotify({
            title: 'Success !',
            text: 'the status is changed to No Active',
            type: 'error',
            cornerclass: 'ui-pnotify-sharp'
                    });
      } else if (resp == "success0") {
        $('#'+id+'').html("<span class='badge badge-info' style='margin-right: 10px;' onclick='editStatusNews(\"" + id + "\")' ><i class='icon icon-ok'></i> Yes </span>")
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