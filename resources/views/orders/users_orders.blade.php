@extends('layouts.frontLayout.front_design')
@section('content')


<div id="loading"></div>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="active">Orders</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading">

            <table id="example" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th style="text-align:center; width: 9%;">Order ID</th>
                        <th style="text-align:center; width: 18%;">Ordered Products</th>
                        <th style="text-align:center; width: 20%;">Payment Method</th>
                        <th style="text-align:center;">Grant Total</th>
                        <th style="text-align:center;">Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td style="text-align:center;">{{$order->id}}</td>
                        <td style="text-align:center;">
                            @foreach($order->orders as $pro)
                            <li><a href="{{url('/orders/'.$order->id)}}">{{$pro->product_code}}</a> <br></li>
                            @endforeach
                        </td>
                        <td style="text-align:center;">{{$order->payment_method}}</td>
                        <td style="text-align:center;">Rp {{is_number($order->grant_total,2)}}</td>
                        <td style="text-align:center;">{{$order->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th style="text-align:center; width: 9%;">Order ID</th>
                        <th style="text-align:center; width: 14%;">Ordered Products</th>
                        <th style="text-align:center; width: 15%;">Payment Method</th>
                        <th style="text-align:center;">Grant Total</th>
                        <th style="text-align:center;">Created On</th>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</section>
@endsection

@section('script')

<script>

</script>

@endsection