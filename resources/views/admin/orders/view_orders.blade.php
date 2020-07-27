@extends('layouts.adminLayout.admin_design')

@section('title') 
View Orders | Admin Hsn E-commerce
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

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i>{{__('backend.home')}}</a> <a href="{{$module->permalink}}">{{__('backend.orders')}}</a>
            <a href="#" class="current">{{__('backend.view_orders')}}</a> </div>
        <h1>{{__('backend.orders')}}</h1>

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
            @include('layouts.adminLayout.actions.action') 
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>{{__('backend.view_orders')}}</h5>
                            <a href="{{url($module->permalink.'/view-orders-charts')}}" class="badge badge-fill btn-mini export_ex" > <i class=" icon-screenshot" style="margin-right: 7px;"></i> order chart </a>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
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
                                        <th scope="row" class="center"> {{ ++$no }} </th>
                                        <td class="center">{{$order->id}}</td>
                                        <td class="center">{{Carbon::parse($order->created_at)->format('l, j F Y | H:i A')}}</td>
                                        <td class="center">{{$order->name}}</td>
                                        <td class="center">{{$order->user_email}}</td>
                                        <td class="center">
                                            @foreach($order->orders as $pro)
                                            <li>
                                                {{$pro->product_code}} ({{$pro->product_qty}})<br>
                                            </li>
                                            @endforeach
                                        </td>
                                        <td class="center">Rp {{is_number($order->grant_total,2)}}</td>
                                        <td class="center">{{$order->order_status}}</td>
                                        <td class="center">{{$order->payment_method}}</td>
                                
                                        <td class="center" style="text-align:center;" width="">
                                            <a target="_blank" href="{{url($module->permalink.'/view-order/'.$order->id)}}" class="label  label-info btn-mini"> <i class="icon-eye-open" style="margin-right: 6px;" ></i>order detail</a> <br>
                                            @if($order->order_status == "Shipped" || $order->order_status == "Delivered" || $order->order_status == "Paid") 
                                            <a target="_blank" href="{{url($module->permalink.'/view-order-invoice/'.$order->id)}}" class="label  label-inverse btn-mini" style="margin-top: 5%;"> <i class="icon-book" style="margin-right: 6px;"></i>order invoice</a>
                                            @endif
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