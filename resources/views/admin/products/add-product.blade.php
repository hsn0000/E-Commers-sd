@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="#">{{__('backend.products')}}</a>
     <a href="{{url('/admin/add-category')}}" class="current">{{__('backend.add_product')}}</a> </div>
    <h1>{{__('backend.products')}}</h1>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>{{__('backend.add_product')}}</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add-product')}}" name="add_product" id="add_product" novalidate="novalidate">
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
                  <input type="text" name="product_name" id="product_name">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_code')}}</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.product_color')}}</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color">
                </div>
              </div> 
              <div class="control-group">
                <label class="control-label">{{__('backend.description')}}</label> 
                <div class="controls">
                 <textarea name="description" id="description"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.material_care')}}</label> 
                <div class="controls">
                 <textarea name="care" id="care"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Sleeve</label>
                <div class="controls">
                  <select name="sleeve"  name="sleeve" id="sleeve" class="form-control" style="width:220px;">
                  <option selected disabled >Select Sleeve</option>
                  @foreach(config('customeArr.sleeveArray') as $sleeve)
                    <option value="{{$sleeve}}">{{$sleeve}}</option>
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
                    <option value="{{$patterns}}">{{$patterns}}</option>
                  @endforeach 
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">{{__('backend.price')}}</label>
                <div class="controls">
                  <input class="price-input-Rp" type="text" name="price" id="price" placeholder="Rp 0">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label ">Weight (g)</label>
                <div class="controls">
                  <input class="" type="number" name="weight" id="weight" placeholder="">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.image')}}</label>
                <div class="controls">
                  <input type="file" name="image" id="image">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Video</label>
                <div class="controls">
                  <input type="file" name="video" id="video">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.feature_item')}}</label>
                <div class="controls">
                  <input type="checkbox" name="feature_item" id="feature_item" value="1">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">{{__('backend.enable')}}</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="{{__('backend.add_product')}}" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection