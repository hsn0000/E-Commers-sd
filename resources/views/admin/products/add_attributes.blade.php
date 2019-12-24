@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a>
     <a href="{{url('/admin/add-category')}}" class="current">Add Product Attributes</a> </div>
    <h1>Products Attributes</h1>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Product Attributes</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add-attribute/'.$productDetails->id)}}" name="add_attribute" id="add_attribute">
            {{csrf_field()}}
            <div class="control-group">
              <input type="hidden" value="{{$productDetails->id}}">
              </div>
              <div class="control-group">
                <label class="control-label">Product Name :</label>
                <label for="" class="control-label"><b>{{$productDetails->product_name}}</b></label>
              </div>
              <div class="control-group">
                <label class="control-label">Product Code :</label>
                <label for="" class="control-label"><b>{{$productDetails->product_code}}</b></label>
              </div>
              <div class="control-group">
                <label class="control-label">Product Color :</label>
                <label for="" class="control-label"><b>{{$productDetails->product_color}}</b></label>
              </div>        
              <div class="control-group">
                <label class="control-label">Price :</label>
                <label for="" class="control-label"><b>{{'Rp.'.$productDetails->price}}</b></label>
              </div>               
            <div class="control-group">
              <label class="control-label"></label>
                <div class="field_wrapper">
                    <div>
                        <input type="text" name="sku[]" id="sku" value="" placeholder="SKU" style="width:130px;" required/>
                        <input type="text" name="size[]" id="size" value="" placeholder="Size" style="width:130px;" required/>
                        <input type="text" name="price[]" id="price" value="" placeholder="Price" style="width:130px;" required/>
                        <input type="text" name="stock[]" id="stock" value="" placeholder="Stock" style="width:130px;" required/>
                        <a href="javascript:void(0);" class="add_button" title="Add field"><i class="icon-plus" style="margin: 0 0 0 10px;"></i></a>
                    </div>
                </div>
              </div>           
              <div class="form-actions">
                <input type="submit" value="Add Attribute" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>

  <!-- end attr -->
  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Attributes</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="font-size:100%;">NO</th>
                  <th style="font-size:100%;">Attribute ID</th>
                  <th style="font-size:100%;">SKU</th>
                  <th style="font-size:100%;">Size</th>
                  <th style="font-size:100%;">Price</th>
                  <th style="font-size:100%;">Stock</th>
                  <th style="font-size:100%;">Actions</th>
                </tr>
              </thead>
              <tbody>
               @php
               $no = 0;
               @endphp
                  @foreach($productDetails['attributes'] as $attribute)
                <tr class="gradeX">
                  <td style="text-align:center;">{{++$no}}</td>
                  <td>{{$attribute->id}}</td>
                  <td>{{$attribute->sku}}</td>
                  <td>{{$attribute->size}}</td>
                  <td>{{$attribute->price}}</td>
                  <td>{{$attribute->stock}}</td>
                  <td class="center" style="text-align:center;" width="">
                    <a rel="{{$attribute->id}}" rel1="delete-attribute" href="javascript:" class="del-attribute btn btn-danger btn-mini" style=""><i class="icon-remove" style="padding: 0 5px"></i>Delete</a>
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

@endsection