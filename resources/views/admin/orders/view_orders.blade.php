@extends('layouts.adminLayout.admin_design')

@section('title')
view order
@endsection

@section('content')

@php
use Carbon\Carbon;
@endphp

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">{{__('backend.orders')}}</a>
            <a href="{{url('/admin/view-orders')}}" class="current">{{__('backend.view_orders')}}</a> </div>
        <h1>{{__('backend.orders')}}</h1>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>  {{__('backend.'.Session::get('flash_message_error'))}} </strong>
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
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>>{{__('backend.view_orders')}}</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">{{__('backend.no')}}</th>
                                        <th style="font-size:100%;">{{__('backend.order_id')}}</th>
                                        <th style="font-size:100%;">{{__('backend.order_date')}}</th>
                                        <th style="font-size:100%;">{{__('backend.customer_name')}}</th>
                                        <th style="font-size:100%;">{{__('backend.customer_email')}}</th>
                                        <th style="font-size:100%;">{{__('backend.ordered_products')}}</th>
                                        <th style="font-size:100%;">{{__('backend.order_amount')}}</th>
                                        <th style="font-size:100%;">{{__('backend.order_status')}}</th>
                                        <th style="font-size:100%;">{{__('backend.payment_method')}}</th>
                                        <th style="font-size:100%;">{{__('backend.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 0;
                                    @endphp
                                    @foreach($orders as $order)
                                    <tr class="gradeX">
                                        <td style="text-align:center;">{{++$no}}</td>
                                        <td>{{$order->id}}</td>
                                        <td>{{Carbon::parse($order->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->user_email}}</td>
                                        <td>
                                            @foreach($order->orders as $pro)
                                            <li>{{$pro->product_code}} ({{$pro->product_qty}})<br>
                                            </li>
                                            @endforeach
                                        </td>
                                        <td>Rp {{is_number($order->grant_total,2)}}</td>
                                        <td>{{$order->order_status}}</td>
                                        <td>{{$order->payment_method}}</td>
                                        <td class="center" style="text-align:center;" width="">
                                            <a target="_blank" href="{{url('admin/view-order/'.$order->id)}}" class="btn btn-primary btn-mini"> <i class="icon-eye-open" style=""></i>{{__('backend.view_order_details')}}</a> <br>
                                            <a target="_blank" href="{{url('admin/view-order-invoice/'.$order->id)}}" class="btn btn-info btn-mini" style="margin-top: 5%;"> <i class="icon-book" style=""></i>{{__('backend.view_order_invoice')}}</a>
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

@section('script')


@endsection