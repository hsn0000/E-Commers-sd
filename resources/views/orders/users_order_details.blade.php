@extends('layouts.frontLayout.front_design')
@section('content')


<div id="loading"></div>     
  <section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('/orders')}}">Orders</a></li>
                <li class="active">{{$orderDetails->id}}</li>
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
                <td style="text-align:center;">Rp.{{$pro->product_price}}</td>
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
</section>
@endsection

@section('script')
 
 <script>
  
 </script>

@endsection
