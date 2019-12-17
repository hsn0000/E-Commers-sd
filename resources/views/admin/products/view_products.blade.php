@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Product</a>
     <a href="{{url('/admin/view-categories')}}" class="current">View Product</a> </div>
    <h1>Product</h1>
    @if(Session::has('flash_message_error'))
      <div class="alert alert-danger alert-block">
           <button type="button" class="close" data-dismiss="alert">×</button>	
             <strong> {{Session::get('flash_message_error')}}</strong>
         </div>
        @endif  
        @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
             <strong> {{Session::get('flash_message_success')}}</strong>
         </div>
      @endif
  </div>
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
                  <th>NO</th>
                  <th>Product ID</th>
                  <th>Category ID</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Actions</th>
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
                     <img src="{{ asset('images/backend_images/products/small/'.$product->image )}}" alt="" >
                   @endif
                  </td>
                  <td class="center" style="text-align:center;">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" style="margin:35px 0 0 0;">View</a>
                    <a href="{{url('/admin/edit-product/'.$product->id)}} " class="btn btn-primary btn-mini" style="margin:35px 0 0 12px;">Edit</a> 
                    <a href="{{url('/admin/delete-product-image/'.$product->id)}}" class="btn btn-danger btn-mini" id="delCat" style="margin:35px 0 0 12px;">Delete</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

</script>

@endsection