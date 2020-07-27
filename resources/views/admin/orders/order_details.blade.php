@extends('layouts.adminLayout.admin_design')

@section('title')
Details Orders | Admin Hsn E-commerce
@endsection

@section('content')
@php
    use Carbon\Carbon;
@endphp

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif 

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<!--main-container-part-->
<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a
                href="{{$module->permalink}}" class="current">{{__('backend.orders')}}</a> </div>
        <h1>{{__('backend.orders')}} #{{$orderDetails->id}}</h1>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title min-width-cstm">
                            <h5>{{__('backend.order_details')}}</h5>
                        </div>
                        <div class="widget-content min-width-cstm">
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
                                                class="label label-info"
                                                style="background-color:RoyalBlue;">{{__('backend.new')}}</span>
                                            @elseif($orderDetails->order_status == "Pending") <span
                                                class="label label-warning">{{__('backend.pending')}}</span>
                                            @elseif($orderDetails->order_status == "Cancelled") <span
                                                class="label label-danger" style="background-color:Red;">
                                                {{__('backend.cancelled')}}</span>
                                            @elseif($orderDetails->order_status == "In_Process") <span
                                                class="label label-info"> {{__('backend.in_proces')}}</span>
                                            @elseif($orderDetails->order_status == "Shipped") <span
                                                class="label" style="background-color:#87CEFA;">
                                                {{__('backend.shipped')}}</span>
                                            @elseif($orderDetails->order_status == "Delivered") <span
                                                class="label label-success"> {{__('backend.delivered')}}</span>
                                            @elseif($orderDetails->order_status == "Paid") <span
                                                class="label" style="background-color:#008080;">
                                                {{__('backend.paid')}}</span>
                                            @else<span
                                                class="label label-inverse">{{$orderDetails->order_status}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="taskDesc">{{__('backend.order_total')}}</td>
                                        <td class="taskStatus">Rp {{is_number($orderDetails->grant_total,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskDesc">{{__('backend.shipping_charges')}}</td>
                                        <td class="taskStatus">Rp {{is_number($orderDetails->shipping_charges)}}</td>
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
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="responsif-costume">
                            <div class="accordion-heading">
                                <div class="widget-title min-width-cstm">
                                    <h5>{{__('backend.billing_address')}}</h5>
                                </div>
                            </div>
                            <div class="accordion-body in collapse" id="collapseGOne" style="">
                                <div class="widget-content min-width-cstm">
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
            </div>

            <div class="span6">
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title min-width-cstm">
                            <h5>{{__('backend.customer_details')}}</h5>
                        </div>
                        <div class="widget-content nopadding min-width-cstm">
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
                </div>
                
                @if($page->fetch_role('alter', $module) == true )
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="responsif-costume">
                            <div class="accordion-heading">
                                <div class="widget-title min-width-cstm">
                                    <h5>{{__('backend.update_order_status')}}</h5>
                                </div>
                            </div>
                            <div class="accordion-body in collapse" id="collapseGOne" style="">
                                <div class="widget-content min-width-cstm">
                                    <form action="{{url($module->permalink.'/update-order-status')}}" method="post"> 
                                    {{csrf_field()}}
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
                </div>
                @endif

                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="responsif-costume">
                            <div class="accordion-heading">
                                <div class="widget-title min-width-cstm">
                                    <h5>{{__('backend.shipping_address')}}</h5>
                                </div>
                            </div>
                            <div class="accordion-body in collapse" id="collapseGOne" style="">
                                <div class="widget-content min-width-cstm">
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
        </div>
        <hr>
        <div class="container-fluid">
            <div class="responsif-costume">
                <table id="example" class="table table-striped table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th style="text-align:center; width: 12%;">{{__('backend.product_code')}}</th>
                            <th style="text-align:center; width: 16%;">{{__('backend.product_name')}}</th>
                            <th style="text-align:center; width: 15%;">{{__('backend.product_size')}}</th>
                            <th class="center" >{{__('backend.product_color')}}</th>
                            <th class="center" >{{__('backend.product_price')}}</th>
                            <th class="center" >{{__('backend.product_qty')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails->orders as $pro)
                        <tr>
                            <td class="center" >{{$pro->product_code}}</td>
                            <td class="center" >{{$pro->product_name}}</td>
                            <td class="center" >{{$pro->product_size}}</td>
                            <td class="center" >{{$pro->product_color}}</td>
                            <td class="center" >Rp {{is_number($pro->product_price,2)}}</td>
                            <td class="center" >{{$pro->product_qty}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align:center; width: 9%;">{{__('backend.product_code')}}</th>
                            <th style="text-align:center; width: 14%;">{{__('backend.product_name')}}</th>
                            <th style="text-align:center; width: 15%;">{{__('backend.product_size')}}</th>
                            <th class="center" >{{__('backend.product_color')}}</th>
                            <th class="center" >{{__('backend.product_price')}}</th>
                            <th class="center" >{{__('backend.product_qty')}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!--main-container-part-->

@endsection