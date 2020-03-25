@extends('layouts.adminLayout.admin_design')

@section('content')
@php
use Carbon\Carbon;
@endphp
<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.cms_pages')}}</a>
     <a href="{{url('/admin/view-categories')}}" class="current">{{__('backend.view_cms_page')}}</a> </div>
    <h1>{{__('backend.cms_pages')}}</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block" style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert" >x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color:seagreen; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{__('backend.'.Session::get('flash_message_success'))}}</strong>
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
            <h5>{{__('backend.view_cms_page')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <!-- <th style="font-size:100%;">{{__('backend.no')}}</th> -->
                  <th style="font-size:100%;">{{__('backend.page_id')}}</th>
                  <th style="font-size:100%;">{{__('backend.title')}}</th>
                  <th style="font-size:100%;">{{__('backend.url')}}</th>
                  <th style="font-size:100%;">{{__('backend.status')}}</th>
                  <th style="font-size:100%;">{{__('backend.created_at')}}</th>
                  <th style="font-size:100%;">{{__('backend.actions')}}</th>
                </tr>
              </thead>
              <tbody>
                  @php
                    $no = 0;
                  @endphp
                  @foreach($cmsPages as $page)
                <tr class="gradeX">
                  <!-- <td style="text-align:center;">{{++$no}}</td> -->
                  <td style="text-align:center;">{{$page->id}}</td>
                  <td style="text-align:center;">{{$page->title}}</td>
                  <td style="text-align:center;">{{$page->url}}</td>
                  <td style="text-align:center;" > @if ($page->status == 1) <span class="badge badge-success">{{__('backend.active')}}</span> @else <span class="badge" style="background-color: firebrick;">{{__('backend.inactive')}}</span>@endif</td>
                  <td style="text-align:center;">{{Carbon::parse($page->created_at)->format('l, j F Y | H:i')}}</td>
                  <td style="text-align:center;" width="24%;">
                    <a href="#myModal{{$page->id}}" data-toggle="modal" class="btn btn-success btn-mini" style="margin:0 0 0 0;" title=" {{__('backend.view')}}"> <i class="icon-eye-open" style="padding:0 4px"></i> {{__('backend.view')}}</a>
                    <a href="{{url('/admin/edit-cms-page/'.$page->id)}} " class="btn btn-warning btn-mini" style="margin:0 0 0 10px;" title="{{__('backend.edit')}}"> <i class="icon-cogs" style="padding:0 4px"></i>  {{__('backend.edit')}}</a> 
                    <a rel="{{$page->id}}" rel1="delete-cms-page" rel2="{{$page->title}}" href="javascript:" onclick="deleteProdt(this)" class="btn btn-danger btn-mini" data-del-id="{{$page->id}}" style="margin:0 0 0 10px;" title=" {{__('backend.delete')}}"> 
                      <i class="icon-trash" style="padding: 0 5px"></i> {{__('backend.delete')}}</a>
                 </td>
                  <div id="myModal{{$page->id}}" class="modal hide">
                     <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                          <h3>{{$page->title}} {{__('backend.full_details')}}</h3>
                        </div>
                         <div class="modal-body">
                           <p><b> {{__('backend.title')}}</b> : {{$page->title}}</p>
                           <p><b> {{__('backend.url')}}</b> : {{$page->url}}</p>
                           <p><b> {{__('backend.status')}}</b> : @if ($page->status == 1) <span class="badge badge-success">{{__('backend.active')}}</span> @else <span class="badge" style="background-color: firebrick;">{{__('backend.inactive')}}</span>@endif </p>
                           <p><b> {{__('backend.created_at')}}</b> : {{Carbon::parse($page->created_at)->format('l, j F Y | H:i')}}</p>
                           <p><b> {{__('backend.description')}}</b> : {{$page->description}}</p>
                        </div>
                    </div>
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

@endsection

@section('script')
  

@endsection