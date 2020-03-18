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
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a
                href="#" class="current">{{__('backend.orders')}}</a> </div>
        <h1>{{__('backend.orders')}} #{{$orderDetails->id}}</h1>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{__('backend.'.Session::get('flash_message_error'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block"
            style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{__('backend.'.Session::get('flash_message_drop'))}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block"
            style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{__('backend.'.Session::get('flash_message_success'))}}</strong>
        </div>
        @endif
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>{{__('backend.order_details')}}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">{{__('backend.order_date')}}</td>
                                    <td class="taskStatus">{{Carbon::parse($orderDetails->created_at)->format('l, j F Y | H:i')}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.order_status')}}</td>
                                    <td class="taskStatus">
                                        @if($orderDetails->order_status == "New") <span
                                            class="badge badge-pill badge-primary"
                                            style="background-color:blue;">{{__('backend.new')}}</span>
                                        @elseif($orderDetails->order_status == "Pending") <span
                                            class="badge badge-pill badge-warning">{{__('backend.pending')}}</span>
                                        @elseif($orderDetails->order_status == "Cancelled") <span
                                            class="badge badge-pill badge-danger" style="background-color:Red;">
                                            {{__('backend.cancelled')}}</span>
                                        @elseif($orderDetails->order_status == "In_Process") <span
                                            class="badge badge-pill badge-info"> {{__('backend.in_proces')}}</span>
                                        @elseif($orderDetails->order_status == "Shipped") <span
                                            class="badge badge-pill badge" style="background-color:#87CEFA;">
                                            {{__('backend.shipped')}}</span>
                                        @elseif($orderDetails->order_status == "Delivered") <span
                                            class="badge badge-pill badge-success"> {{__('backend.delivered')}}</span>
                                        @elseif($orderDetails->order_status == "Paid") <span
                                            class="badge badge-pill badge-success" style="background-color:#008080;">
                                            {{__('backend.paid')}}</span>
                                        @else<span
                                            class="badge badge-pill badge-dark">{{$orderDetails->order_status}}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.order_total')}}</td>
                                    <td class="taskStatus">Rp {{is_number($orderDetails->grant_total,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.shipping_charges')}}</td>
                                    <td class="taskStatus">{{$orderDetails->shipping_changes}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.coupon_code')}}</td>
                                    <td class="taskStatus">{{$orderDetails->coupon_code}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.coupon_amount')}}</td>
                                    <td class="taskStatus">Rp {{is_number($orderDetails->coupon_amount,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.payment_method')}}</td>
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
                                <h5>{{__('backend.billing_address')}}</h5>
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
                        <h5>{{__('backend.customer_details')}}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">{{__('backend.customer_name')}}</td>
                                    <td class="taskStatus">{{$orderDetails->name}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">{{__('backend.customer_email')}}</td>
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
                                <h5>{{__('backend.update_order_status')}}</h5>
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
                                                        selected @endif>{{__('backend.new')}}</option>
                                                    <option value="Pending" @if($orderDetails->order_status ==
                                                        "Pending") selected @endif>{{__('backend.pending')}}</option>
                                                    <option value="Cancelled" @if($orderDetails->order_status ==
                                                        "Cancelled") selected @endif>{{__('backend.cancelled')}}</option>
                                                    <option value="In_Process" @if($orderDetails->order_status ==
                                                        "In_Process") selected @endif>{{__('backend.in_proces')}}</option>
                                                    <option value="Shipped" @if($orderDetails->order_status ==
                                                        "Shipped") selected @endif>{{__('backend.shipped')}}</option>
                                                    <option value="Delivered" @if($orderDetails->order_status ==
                                                        "Delivered") selected @endif>{{__('backend.delivered')}}</option>
                                                    <option value="Paid" @if($orderDetails->order_status == "Paid")
                                                        selected @endif>{{__('backend.paid')}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" value="{{__('backend.update_status')}}">
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
                                <h5>{{__('backend.shipping_address')}}</h5>
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
                        <th style="text-align:center; width: 12%;">{{__('backend.product_code')}}</th>
                        <th style="text-align:center; width: 16%;">{{__('backend.product_name')}}</th>
                        <th style="text-align:center; width: 15%;">{{__('backend.product_size')}}</th>
                        <th style="text-align:center;">{{__('backend.product_color')}}</th>
                        <th style="text-align:center;">{{__('backend.product_price')}}</th>
                        <th style="text-align:center;">{{__('backend.product_qty')}}</th>
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
                        <th style="text-align:center; width: 9%;">{{__('backend.product_code')}}</th>
                        <th style="text-align:center; width: 14%;">{{__('backend.product_name')}}</th>
                        <th style="text-align:center; width: 15%;">{{__('backend.product_size')}}</th>
                        <th style="text-align:center;">{{__('backend.product_color')}}</th>
                        <th style="text-align:center;">{{__('backend.product_price')}}</th>
                        <th style="text-align:center;">{{__('backend.product_qty')}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<!--main-container-part-->

@endsection