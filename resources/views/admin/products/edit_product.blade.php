@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.edit_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>
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
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong>  {{__('backend.'.Session::get('flash_message_success'))}}</strong>
        </div>
    @endif
  </div>
  <div id="loading"></div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.edit_product')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/edit-product/'.$productDetails->id)}}" name="edit_product" id="edit_product" novalidate="novalidate">
            {{csrf_field()}}
            <div class="control-group">
                <label class="control-label">{{__('backend.under_category')}} </label>
                <div class="controls">
                   <select name="category_id" id="category_id" style="width:220px;">
                    <?php echo $categories_dropdown ?> 
                   </select> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_name')}}</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="{{$productDetails->product_name}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_code')}}</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code" value="{{$productDetails->product_code}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_color')}}</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color" value="{{$productDetails->product_color}}">
                </div>
              </div> 
              <div class="control-group">
                <label class="control-label">{{__('backend.description')}}</label> 
                <div class="controls">
                 <textarea name="description" id="description">{{$productDetails->description}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.material_care')}}</label> 
                <div class="controls">
                 <textarea name="care" id="care">{{$productDetails->care}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Sleeve</label>
                <div class="controls">
                  <select name="sleeve"  name="sleeve" id="sleeve" class="form-control" style="width:220px;">
                  <option selected disabled>Select Sleeve</option>
                  @foreach(config('customeArr.sleeveArray') as $sleeve)
                    <option value="{{$sleeve}}" @if(!empty($productDetails->sleeve) && $productDetails->sleeve == $sleeve) selected @endif>{{$sleeve}}</option>
                  @endforeach 
                  </select> 
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Pattern</label>
                <div class="controls">
                  <select name="pattern"  name="pattern" id="pattern" class="form-control" style="width:220px;">
                  <option selected disabled >Select Pattern</option>
                  @foreach(config('customeArr.patternArray') as $patterns)
                    <option value="{{$patterns}}" @if(!empty($productDetails->pattern) && $productDetails->pattern == $patterns) selected @endif>{{$patterns}}</option>
                  @endforeach 
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">{{__('backend.price')}}</label>
                <div class="controls">
                  <input class="price-input-Rp" type="text" name="price" id="price" value="{{$productDetails->price}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.old_image')}}</label>
                <div class="controls">
               @if(!empty($productDetails->image))
                 <img src="{{asset('images/backend_images/products/small/'.$productDetails->image)}}" alt="{{__('backend.old_image')}}" style="width:217px; height:219px;">
                 &nbsp; | | <a rel="{{$productDetails->id}}" rel1="delete-product-image" rel2="{{__('backend.old_image')}}" href="javascript:" class="btn btn-danger btn-mini" id="" onclick="deleteProdt(this)"><i class="icon-trash" ></i> {{__('backend.delete')}}</a>
               @endif
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.new_image')}}</label>
                <div class="controls">
                  <input type="file" name="image" id="image"> 
                  <input type="hidden" name="current-image" value="{{$productDetails->image}}"> 
                </div>
              </div>

              <div class="control-group">
                <label class="control-label"> Old Video </label>
                <div class="controls">
                  @if(!empty($productDetails->video))
                    <video src="{{asset('videos/'.$productDetails->video)}}" style="border-style: solid;border-color: darkred; width:217px; height:185px;" controls> </video>
                  @else
                    <img src="{{asset('images/video-thumbnail.png')}}" width="217" height="185" controls alt="" >
                  @endif
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">New Video</label>
                <div class="controls">
                  <input type="file" name="video" id="video"> 
                  <input type="hidden" name="current-video" value="{{$productDetails->video}}">
                   @if(!empty($productDetails->video))
                    | |  <a href="{{url('videos/'.$productDetails->video)}}" target="blank_" class="btn btn-info btn-mini"><i class="icon-eye-open"></i> View Old Video </a> 
                    | |  <a rel="{{$productDetails->id}}" rel1="delete-product-video" rel2="{{$productDetails->video}}" href="javascript:" class="btn btn-danger btn-mini" onclick="deleteProdt(this)" data-del-id="{{$productDetails->id}}" title=" {{__('backend.delete')}}">  <i class="icon-trash" ></i> Delete Old Video </a> </a> 
                   @endif
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">{{__('backend.feature_item')}}</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" @if($productDetails->feature_item =="1") checked @endif value="1">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($productDetails->status =="1") checked @endif value="1">
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" value="{{__('backend.edit_category')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection