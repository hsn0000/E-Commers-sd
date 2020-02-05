@extends('layouts.adminLayout.admin_design')

@section('title')
view order
@endsection

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i> Home</a> <a href="#">Orders</a>
            <a href="{{url('/admin/view-categories')}}" class="current">View Orders</a> </div>
        <h1>Orders</h1>
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
    <div id="loading"></div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>View Orders</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th style="font-size:100%;">NO</th>
                                        <th style="font-size:100%;">Order ID</th>
                                        <th style="font-size:100%;">Order Date</th>
                                        <th style="font-size:100%;">Customer Name</th>
                                        <th style="font-size:100%;">Customer Email</th>
                                        <th style="font-size:100%;">Ordered Products</th>
                                        <th style="font-size:100%;">Order Amount</th>
                                        <th style="font-size:100%;">Order Status</th>
                                        <th style="font-size:100%;">Payment Method</th>
                                        <th style="font-size:100%;">Actions</th>
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
                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->user_email}}</td>
                                        <td>
                                            @foreach($order->orders as $pro)
                                            <li>{{$pro->product_code}} ({{$pro->product_qty}})<br>
                                            </li>
                                            @endforeach
                                        </td>
                                        <td>Rp {{is_number($order->grant_total)}}</td>
                                        <td>{{$order->order_status}}</td>
                                        <td>{{$order->payment_method}}</td>
                                        <td class="center" style="text-align:center;" width="">
                                            <a target="_blank" href="{{url('admin/view-order/'.$order->id)}}" class="btn btn-success btn-mini"> <i class="icon-eye-open"
                                                    style=""></i> View Order Details</a>
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