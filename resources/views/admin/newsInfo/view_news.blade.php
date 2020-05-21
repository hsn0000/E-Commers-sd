@extends('layouts.adminLayout.admin_design')

@section('title')
@endsection

@section('content')

<?php
 use Carbon\Carbon; 
?>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></i>{{__('backend.home')}}</a> <a href="#">News Information</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View News</a> </div>
        <h1>News Information</h1>

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
                        <h5>View News</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="news_info">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">No</th>
                                        <th style="font-size:100%;">{{__('backend.description')}}</th>
                                        <th style="font-size:100%;">{{__('backend.url')}}</th>
                                        <th style="font-size:100%;">{{__('backend.enable')}}</th>
                                        <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                                        <th style="font-size:100%; width:190px">{{__('backend.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @php $no = 0; @endphp
                                    @foreach($newsInfoAll as $newsinfo)
                                    @php $no++ @endphp
                                    <tr class="">
                                        <td style="text-align:center;">{{$no}}</td>
                                        <td style="text-align:center;">{{$newsinfo->description}}</td>
                                        <td style="text-align:center;">{{$newsinfo->url}}</td>
                                        <td style="text-align:center;">
                                            @if($newsinfo->status==1)
                                               <a href="javascript:"><span class="badge badge-success" onclick="editStatusNews({{$newsinfo->id}})" id="{{$newsinfo->id}}" >{{__('backend.active')}}</span> </a> 
                                            @else
                                               <a href="javascript:"><span class="badge badge-danger" onclick="editStatusNews({{$newsinfo->id}})" id="{{$newsinfo->id}}" style="background-color:Crimson;">{{__('backend.inactive')}}</span> </a> 
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{Carbon::parse($newsinfo->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td style="text-align:center;">
                                         <a class="btn btn-danger btn-xm "  data-toggle="modal" data-target="#exampleModal" data-id="{{$newsinfo->id}}" onclick="modalNewsInfo(this)"><i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
                                         <a href="{{url('/admin/edit-news/'.$newsinfo->id)}}" class="btn btn-warning btn-xm "><i class="icon-cogs" style="padding: 0 5px"></i> {{__('backend.edit')}}</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Delete This News Info !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -32px;">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
      Are you sure you want to delete this News Info ?
      </div>
      <div class="modal-footer"> 
        <input type="hidden" id="idnewsinfo" value="">
        <button type="button" class="btn btn-primary" style="background: black;" data-dismiss="modal"> <i class="icon-arrow-left" style=""></i>&nbsp; Cancel</button>
        <a hreft="javascript:" class="btn btn-danger" onclick="deleteNewsInfo()"><i class="icon-trash"></i>&nbsp; {{__('backend.delete')}}</a>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script>
  $(document).ready(function() { {{-- $('#news_info').DataTable({ ordering: false,  responsive: true, }) --}} }) 
</script>

<script>
  function modalNewsInfo(resp) {
      var id = $(resp).data("id")
      $("#idnewsinfo").val(id)
  }   

  function deleteNewsInfo() {
      var id = $("#idnewsinfo").val()
      window.location.href ="/admin/delete-news-info/"+id;
  }


function editStatusNews(id) {
  /* ajax */ 
  $.ajax({
    type: 'get',
    url: '/admin/edit-status-newsinfo',
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