@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Product</a>
     <a href="{{url('/admin/view-categories')}}" class="current">View Product</a> </div>
    <h1>Product</h1>
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
                  <th style="font-size:100%;">NO</th>
                  <th style="font-size:100%;">Product ID</th>
                  <th style="font-size:100%;">Category ID</th>
                  <th style="font-size:100%;">Category Name</th>
                  <th style="font-size:100%;">Product Name</th>
                  <th style="font-size:100%;">Product Code</th>
                  <th style="font-size:100%;">Product Color</th>
                  <th style="font-size:100%;">Price</th>
                  <th style="font-size:100%;">Image</th>
                  <th style="font-size:100%;">Actions</th>
                </tr>
              </thead>
              <tbody>
                  @php
                    $no = 0;
                  @endphp
                  @foreach($products as $product)
                <tr class="gradeX">
                  <td style="text-align:center;">{{++$no}}</td>
                  <td>{{$product->id}}</td>
                  <td>{{$product->category_id}}</td>
                  <td>{{$product->category_name}}</td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_code}}</td>
                  <td>{{$product->product_color}}</td>
                  <td>{{'Rp.'.$product->price}}</td>
                  <td style="text-align:center;">
                   @if(!empty($product->image))
                     <img src="{{ asset('images/backend_images/products/small/'.$product->image )}}" alt="image product" width="110">
                   @endif
                  </td>
                  {{-- url('/admin/delete-product/'.$product->id) --}}
                  <td class="center" style="text-align:center;" width="24%;">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" style="margin:35px 0 0 0;" title="View Product"> <i class="icon-eye-open" style="padding:0 4px"></i> View</a>
                    <a href="{{url('/admin/add-attribute/'.$product->id)}} " class="btn btn-primary btn-mini" style="margin:35px 0 0 10px;" title="Add Attributes"> <i class="icon-plus" style="padding:0 4px"></i> Add_attr</a>
                    <a href="{{url('/admin/add-images/'.$product->id)}} " class="btn btn-info btn-mini" style="margin:35px 0 0 10px;" title="Add Images"> <i class="icon-plus-sign" style="padding:0 4px"></i> Add_img</a>
                    <a href="{{url('/admin/edit-product/'.$product->id)}} " class="btn btn-warning btn-mini" style="margin:35px 0 0 10px;" title="Edit Product"> <i class="icon-cogs" style="padding:0 4px"></i> Edit</a> 
                    <a rel="{{$product->id}}" rel1="delete-product" rel2="{{$product->product_name}}" href="javascript:" class="deleteProd btn btn-danger btn-mini" data-del-id="{{$product->id}}" style="margin:35px 0 0 10px;" title="Delete Product"> 
                      <i class="icon-remove" style="padding: 0 5px"></i>Delete</a>
                 </td>
                  <div id="myModal{{$product->id}}" class="modal hide">
                     <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">×</button>
                          <h3>{{$product->product_name}} Full Details</h3>
                        </div>
                         <div class="modal-body">
                           <p>Product ID: {{$product->id}}</p>
                           <p>Category ID: {{$product->category_id}}</p>
                           <p>Product Code: {{$product->product_code}}</p>
                           <p>Product Color: {{$product->product_color}}</p>
                           <p>Facric:</p>
                           <p>Material:</p>
                           <p>Price: {{'Rp.'.$product->price}}</p>
                           <p>Description: {{$product->description}}</p>
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