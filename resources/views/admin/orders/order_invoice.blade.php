<!DOCTYPE html>
<html lang="en"> 

<head>
    @if(empty($hello))
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('backend.order_invoice')}}</title>
    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/backend_css/print.min.css')}}">
    @elseif(!empty($hello))
    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    @endif

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

    <div id="loading"></div>
    <div class="container" id="con">
        <div class="row">
            @if(empty($hello))
            <div class="col-xs-12" style=" background: currentColor; padding-bottom: 19px;">
                <div class="headajah" style=" float: right;">
                    <a href="{{ url($module->permalink.'/view-pdf-invoice/'.$orderDetails->id) }}" class="btn btn-danger btn-mini" style="margin-top: 5%;">
                        <i class="icon-eye-open" style=""></i>Export PDF Invoice</a>
                </div>
            </div>
            @endif
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>{{__('backend.order_invoice')}}</h2>
                    <h3 class="pull-right">{{__('backend.orders')}} # {{$orderDetails->orders[0]->order_id}} <span> {{-- DNS1D::getBarcodeHTML($orderDetails->orders[0]->order_id, 'C39'); --}} </span></h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>{{__('backend.billed_to')}} :</strong><br>
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
                            <strong>{{__('backend.shipped_to')}} :</strong><br>
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
                            <strong>{{__('backend.payment_method')}} :</strong><br>
                            {{$orderDetails->payment_method}} <br>
                        </address>
                    </div>
                    <div class="col-xs-6 text-right">
                        <address>
                            <strong>{{__('backend.order_date')}} :</strong><br>
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
                        <h3 class="panel-title"><strong>{{__('backend.order_summary')}}</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>{{__('backend.code')}}</strong></td>
                                        <td class="text-center"><strong>{{__('backend.name')}}</strong></td>
                                        <td class="text-center"><strong>{{__('backend.size')}}</strong></td>
                                        <td class="text-center"><strong>{{__('backend.color')}}</strong></td>
                                        <td class="text-center"><strong>{{__('backend.price')}}</strong></td>
                                        <td class="text-center"><strong>{{__('backend.qty')}}</strong></td>
                                        <td class="text-right"><strong>{{__('backend.totals')}}</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach($orderDetails->orders as $pro)
                                    <tr>
                                        <td class="">{{$pro->product_code}} <div class="testt"> {{-- echo DNS1D::getBarcodeHTML('4445', 'EAN13'); --}} </div> </td>
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
                                        <td class="thick-line text-right"><strong>{{__('backend.subtotal')}}</strong>
                                        </td>
                                        <td class="thick-line text-right">{{'Rp'.' '.is_number($subtotal,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>{{__('backend.shipping_changes')}}
                                                (+)</strong></td>
                                        <td class="no-line text-right">Rp 00</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>{{__('backend.coupon_discount')}}
                                                (-)</strong></td>
                                        <td class="no-line text-right">
                                            {{'Rp'.' '.is_number($orderDetails->coupon_amount,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>{{__('backend.grand_total')}}</strong>
                                        </td>
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

<script>
$(document).ready(function () {
    window.print();
});
</script>

</html>