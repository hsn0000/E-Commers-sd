@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a>
     <a href="{{url('/admin/view-categories')}}" class="current">View Category</a> </div>
    <h1>Categories</h1>
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block" style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert" >x</button>	
            <strong> {{Session::get('flash_message_drop')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:21%; margin-left:20px;">
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
            <h5>View Categories</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Category ID</th>
                  <th>Category Name</th>
                  <th>Category Level</th>
                  <th>Category URL</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($categories as $category)
                  {{-- url('/admin/delete-category/'.$category->id) --}}
                <tr class="gradeX">
                  <td>{{$category->id}}</td>
                  <td>{{$category->name}}</td>
                  <td>{{$category->parent_id}}</td>
                  <td>{{$category->url}}</td>
                  <td style="text-align:center;" class="center" width="25%">
                  <a href="{{url('/admin/edit-category/'.$category->id)}}" class="btn btn-warning btn-mini" style="margin:0 12px 0 0"><i class="icon-cogs" style="padding:0 4px"></i>Edit</a> 
                   <a rel="{{$category->id}}" rel1="delete-category" rel2="{{$category->name}}" href="javascript:" class="delCat btn btn-danger btn-mini delCat" id="" style="margin:0 0 0 9px"><i class="icon-remove" style="padding: 0 5px"></i>Delete</a>
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

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection