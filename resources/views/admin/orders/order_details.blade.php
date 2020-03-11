@extends('layouts.adminLayout.admin_design')

@section('title')
order details
@endsection

@section('content')
@php
use Carbon\Carbon;
@endphp
<!--main-container-part-->
<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a
                href="#" class="current">Orders</a> </div>
        <h1>Order #{{$orderDetails->id}}</h1>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block"
            style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_drop')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block"
            style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Order Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">Order Date</td>
                                    <td class="taskStatus">{{Carbon::parse($orderDetails->created_at)->format('l, j F Y | H:i')}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Order Status</td>
                                    <td class="taskStatus">
                                        @if($orderDetails->order_status == "New") <span
                                            class="badge badge-pill badge-primary"
                                            style="background-color:blue;">New</span>
                                        @elseif($orderDetails->order_status == "Pending") <span
                                            class="badge badge-pill badge-warning">Pending</span>
                                        @elseif($orderDetails->order_status == "Cancelled") <span
                                            class="badge badge-pill badge-danger" style="background-color:Red;">
                                            Cancelled</span>
                                        @elseif($orderDetails->order_status == "In_Process") <span
                                            class="badge badge-pill badge-info"> In Process</span>
                                        @elseif($orderDetails->order_status == "Shipped") <span
                                            class="badge badge-pill badge" style="background-color:#87CEFA;">
                                            Shipped</span>
                                        @elseif($orderDetails->order_status == "Delivered") <span
                                            class="badge badge-pill badge-success"> Delivered</span>
                                        @elseif($orderDetails->order_status == "Paid") <span
                                            class="badge badge-pill badge-success" style="background-color:#008080;">
                                            Paid</span>
                                        @else<span
                                            class="badge badge-pill badge-dark">{{$orderDetails->order_status}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Order Total</td>
                                    <td class="taskStatus">Rp {{is_number($orderDetails->grant_total,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Shipping Charges</td>
                                    <td class="taskStatus">{{$orderDetails->shipping_changes}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Coupon Code</td>
                                    <td class="taskStatus">{{$orderDetails->coupon_code}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Coupon Amount</td>
                                    <td class="taskStatus">Rp {{is_number($orderDetails->coupon_amount,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Payment Method</td>
                                    <td class="taskStatus">{{$orderDetails->payment_method}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Billing Address</h5>
                            </div>
                        </div>
                        <div class="accordion-body in collapse" id="collapseGOne" style="">
                            <div class="widget-content">
                                <li>{{$userDetails->name}}</li> <br>
                                <li>{{$userDetails->address}}</li> <br>
                                <li>{{$userDetails->city}}</li> <br>
                                <li>{{$userDetails->state}}</li> <br>
                                <li>{{$userDetails->country}}</li> <br>
                                <li>{{$userDetails->pincode}}</li> <br>
                                <li>{{$userDetails->mobile}}</li> <br>
                                <li>{{$userDetails->email}}</li> <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Customer Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">Customer Name</td>
                                    <td class="taskStatus">{{$orderDetails->name}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Customer Email</td>
                                    <td class="taskStatus">{{$orderDetails->user_email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Update Order Status</h5>
                            </div>
                        </div>
                        <div class="accordion-body in collapse" id="collapseGOne" style="">
                            <div class="widget-content">
                                <form action="{{url('admin/update-order-status')}}" method="post"> {{csrf_field()}}
                                    <input type="hidden" name="order_id" value="{{$orderDetails->id}}">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <select name="order_status" id="order_status" class="control-label"
                                                    required="">
                                                    <option value="New" @if($orderDetails->order_status == "New")
                                                        selected @endif>New</option>
                                                    <option value="Pending" @if($orderDetails->order_status ==
                                                        "Pending") selected @endif>Pending</option>
                                                    <option value="Cancelled" @if($orderDetails->order_status ==
                                                        "Cancelled") selected @endif>Cancelled</option>
                                                    <option value="In_Process" @if($orderDetails->order_status ==
                                                        "In_Process") selected @endif>In Process</option>
                                                    <option value="Shipped" @if($orderDetails->order_status ==
                                                        "Shipped") selected @endif>Shipped</option>
                                                    <option value="Delivered" @if($orderDetails->order_status ==
                                                        "Delivered") selected @endif>Delivered</option>
                                                    <option value="Paid" @if($orderDetails->order_status == "Paid")
                                                        selected @endif>Paid</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" value="Update Status">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Shipping Address</h5>
                            </div>
                        </div>
                        <div class="accordion-body in collapse" id="collapseGOne" style="">
                            <div class="widget-content">
                                <li>{{$orderDetails->name}}</li> <br>
                                <li>{{$orderDetails->address}}</li> <br>
                                <li>{{$orderDetails->city}}</li> <br>
                                <li>{{$orderDetails->state}}</li> <br>
                                <li>{{$orderDetails->country}}</li> <br>
                                <li>{{$orderDetails->pincode}}</li> <br>
                                <li>{{$orderDetails->mobile}}</li> <br>
                                <li>{{$orderDetails->user_email}}</li> <br>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="container-fluid">
            <table id="example" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th style="text-align:center; width: 12%;">Product Code</th>
                        <th style="text-align:center; width: 16%;">Product Name</th>
                        <th style="text-align:center; width: 15%;">Product Size</th>
                        <th style="text-align:center;">Product Color</th>
                        <th style="text-align:center;">Product Price</th>
                        <th style="text-align:center;">Product Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails->orders as $pro)
                    <tr>
                        <td style="text-align:center;">{{$pro->product_code}}</td>
                        <td style="text-align:center;">{{$pro->product_name}}</td>
                        <td style="text-align:center;">{{$pro->product_size}}</td>
                        <td style="text-align:center;">{{$pro->product_color}}</td>
                        <td style="text-align:center;">Rp {{is_number($pro->product_price,2)}}</td>
                        <td style="text-align:center;">{{$pro->product_qty}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align:center; width: 9%;">Product Code</th>
                        <th style="text-align:center; width: 14%;">Product Name</th>
                        <th style="text-align:center; width: 15%;">Product Size</th>
                        <th style="text-align:center;">Product Color</th>
                        <th style="text-align:center;">Product Price</th>
                        <th style="text-align:center;">Product Qty</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!--main-container-part-->

@endsection