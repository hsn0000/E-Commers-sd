@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
  <div id="content-header">
  <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Coupon</a>
     <a href="{{url('/admin/view-coupon')}}" class="current">View Coupon</a> </div>
    <h1>Coupons</h1>
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
            <h5>View Coupon</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th style="font-size:100%;">NO</th>
                  <th style="font-size:100%;">Coupon ID</th>
                  <th style="font-size:100%;">Coupon Code</th>
                  <th style="font-size:100%;">Amount</th>
                  <th style="font-size:100%;">Amount Type</th>
                  <th style="font-size:100%;">Expiry Date</th>
                  <th style="font-size:100%;">Create Date</th>
                  <th style="font-size:100%;">Status</th>
                  <th style="font-size:100%;">Actions</th>
                </tr>
              </thead>
              <tbody>
                  <?php $no = 0; ?>
                  @foreach($coupons as $coupon)
                <tr class="gradeX">
                  <td style="text-align:center;">{{++$no}}</td>
                  <td style="text-align:center;">{{$coupon->id}}</td>
                  <td style="text-align:center;">{{$coupon->coupon_code}}</td>
                  <td style="text-align:center;"> @if($coupon->amount_type == "Persentage") {{$coupon->amount}} % @else Rp {{is_number($coupon->amount)}} @endif</td>
                  <td style="text-align:center;">{{$coupon->amount_type}}</td>
                  <td style="text-align:center;">{{$coupon->expiry_date}}</td>
                  <td style="text-align:center;">{{$coupon->created_at}}</td>
                  <td style="text-align:center;"> @if($coupon->status==1)<span class="badge badge-success">Active</span>@else <span class="badge badge-danger" style="background-color:Crimson;">InActive</span>@endif</td>
                  <td class="center" style="text-align:center;" width="18%;">
                    <a href="{{url('/admin/edit-coupon/'.$coupon->id)}} " class="btn btn-warning btn-mini" style="margin:30px 0 0 10px;" title="Edit Product"> <i class="icon-cogs" style="padding:0 4px"></i> Edit</a> 
                    <a rel="{{$coupon->id}}" rel1="delete-coupon" rel2="{{$coupon->coupon_code}}" href="javascript:" class="deleteProd btn btn-danger btn-mini" style="margin:30px 0 0 10px;" title="Delete Product"> 
                      <i class="icon-remove" style="padding: 0 5px"></i>Delete</a>
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
  

@endsection