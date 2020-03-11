<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.js') }}"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>

    body {
        margin-top: 27px;
        background-color: currentColor;
    }
    .container {
        background-color: white;
        margin-top: 3%;
    }
    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }
    </style>
</head>

<body>
@php
use Carbon\Carbon;
@endphp

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Order Invoice</h2>
                    <h3 class="pull-right">Order # {{$orderDetails->orders[0]->order_id}}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Billed To :</strong><br>
                            {{$userDetails->name}} <br>
                            {{$userDetails->address}} <br>
                            {{$userDetails->city}} <br>
                            {{$userDetails->state}}<br>
                            {{$userDetails->country}} <br>
                            {{$userDetails->pincode}}<br>
                            {{$userDetails->mobile}}<br>
                            {{$userDetails->email}}<br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Shipped To :</strong><br>
                            {{$orderDetails->name}} <br>
                            {{$orderDetails->address}} <br>
                            {{$orderDetails->city}} <br>
                            {{$orderDetails->state}} <br>
                            {{$orderDetails->country}} <br>
                            {{$orderDetails->pincode}} <br>
                            {{$orderDetails->mobile}} <br>
                            {{$orderDetails->user_email}} <br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>Payment Method :</strong><br>
                            {{$orderDetails->payment_method}} <br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>Order Date :</strong><br>
                            {{Carbon::parse($orderDetails->created_at)->format('l, j F Y')}}<br><br>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Code</strong></td>
                                        <td class="text-center"><strong>Name</strong></td>
                                        <td class="text-center"><strong>Size</strong></td>
                                        <td class="text-center"><strong>Color</strong></td>
                                        <td class="text-center"><strong>Price</strong></td>
                                        <td class="text-center"><strong>Qty</strong></td>
                                        <td class="text-right"><strong>Totals</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach($orderDetails->orders as $pro)
                                    <tr>
                                        <td class="">{{$pro->product_code}}</td>
                                        <td class="text-center">{{$pro->product_name}}</td>
                                        <td class="text-center">{{$pro->product_size}}</td>
                                        <td class="text-center">{{$pro->product_color}}</td>
                                        <td class="text-center">{{'Rp'.' '.is_number($pro->product_price,2)}}</td>
                                        <td class="text-center">{{$pro->product_qty}}</td>
                                        <td class="text-right">
                                            {{'Rp'.' '.is_number($pro->product_price * $pro->product_qty,2)}}</td>
                                    </tr>
                                    @endforeach
                                    @php $subtotal = $subtotal + ($pro->product_price * $pro->product_qty) @endphp
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"><strong>Subtotal</strong></td>
                                        <td class="thick-line text-right">{{'Rp'.' '.is_number($subtotal,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>Shipping Changes (+)</strong></td>
                                        <td class="no-line text-right">Rp 00</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>Coupon Discount (-)</strong></td>
                                        <td class="no-line text-right">
                                            {{'Rp'.' '.is_number($orderDetails->coupon_amount,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>Grand Total</strong></td>
                                        <td class="no-line text-right">
                                            {{'Rp'.' '.is_number($orderDetails->grant_total,2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>