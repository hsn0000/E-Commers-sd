@extends('layouts.adminLayout.admin_design')

@section('title')
order details
@endsection

@section('content')


<!--main-container-part-->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a
                href="#" class="current">Orders</a> </div>
        <h1>Order #{{$orderDetails->id}}</h1>
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
                                    <td class="taskStatus">{{$orderDetails->created_at}}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc"> Order Status</td>
                                    <td class="taskStatus">{{$orderDetails->order_status}}</td>
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
                            <div class="widget-content"> Billing details will come here.. </div>
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
                                <h5>Shipping Address</h5>
                            </div>
                        </div>
                        <div class="accordion-body in collapse" id="collapseGOne" style="">
                            <div class="widget-content"> Shipping address will come here.. </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
<!--main-container-part-->


@endsection