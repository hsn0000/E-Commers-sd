@extends('layouts.adminLayout.admin_design')
@section('title')
Index Categories | Admin Hsn E-commerce
@endsection

@section('content')

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.categories')}}</a>
     <a href="{{ $module->permalink }}" class="current">{{__('backend.view_category')}}</a> </div>
    <h1>{{__('backend.categories')}}</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box">
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>{{__('backend.view_category')}}</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                @csrf
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                      <th>
                      @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                          <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i></a>
                      @else
                          #
                      @endif
                      </th>
                      <th>{{__('backend.category_name')}}</th>
                      <th>Category</th>
                      <th>{{__('backend.category_url')}}</th>
                      <th>{{__('backend.status')}}</th>
                      <th>{{__('backend.created_at')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($_data_table as $key => $category)
                      <tr class="">
                        <th scope="row" style="text-align:center;">
                        @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$category['id'] }}" name="data_id[{{ $category['id'] }}]" onclick="checkInputValue(this)">
                                <label class="custom-control-label" for="{{ 'child-'.$category['id'] }} "></label>
                            </div>
                        @else
                            {{ ++$key }}
                        @endif
                        </th>
                        <td class="center" >{!! $category['name'] !!}</td>
                        <td class="center" >{!! $category['maincategori'] !!}</td>
                        <td class="center">{{$category['url']}}</td>
                        <td class="center" > {!! $category['status'] !!} </td>
                        <td class="center">{{$category['created_at']}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')


@endsection