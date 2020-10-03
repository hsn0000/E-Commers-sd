@extends('layouts.adminLayout.admin_design')
@section('title') 
Summary order | Admin Hsn E-commerce
@endsection  
 
@section('link')
<style>

</style>
@endsection

@section('content')

<?php
    use Carbon\Carbon; 
?>

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>{{__('backend.home')}}</a> <a href="#">Report</a>
            <a href="{{ $module->permalink }}" class="current"> Summary Order</a> </div>
        <h1>Summary</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12 ">
                <div class="action actions-prod">
                    @if($page->fetch_role('create', $module) == true )
                        <a href="javascript:" data-link="{{url($module->permalink.'/view-order-detail')}}" class="btn  btn-info btn export_ex btn-order-details"> <i class="icon-eye-open" style="margin-right: 6px;" ></i>order detail</a> <br>
                {{-- @if($order->order_status == "Shipped" || $order->order_status == "Delivered" || $order->order_status == "Paid") --}}
                        <a href="javascript:" data-link="{{url($module->permalink.'/view-order-invoice')}}" class="btn  btn-success btn export_ex btn-order-invoice" > <i class="icon-book" style="margin-right: 6px;"></i>order invoice</a>
                {{-- @endif --}}
                    @endif
                </div>
                @include('layouts.adminLayout.actions.action')
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Summary Order</h5>
                            @if($page->fetch_role('view', $module) == TRUE)
                            <form action="{{$module->permalink}}" method="post" autocomplete="off"> 
                                @csrf
                                <select name="order_status" id="order_status" class="order_status">
                                        <option value="all" selected >All</option>
                                    @foreach($order_status as $key => $val)
                                        <option value="{{ $val->order_status }}" @if (isset($_order_status)) @if($_order_status === $val->order_status) selected="selected" @endif @endif >{{ $val->order_status }}</option>
                                    @endforeach
                                </select>
                                <div class="search-periode-fluids">
                                    <input type="text" class="form-control" name="picked_date" id="picked_date" value="@if(isset($_picked_date)) {{ $_picked_date }} @endif" placeholder="Search Periode .." > 
                                    <div class="close-search-periode" style="display: none;">
                                        X
                                    </div>
                                </div>
                                <input class="btn-search-periode" type="submit" value="Search..">
                            </form>
                            @endif
                        </div>
                        <form action="{{ $module->permalink.'/add' }}" id="form-table" method="post" autocomplete="off">
                            @csrf
                            <div class="widget-content nopadding">
                                <table class="table table-bordered data-table" >
                                    <thead class="thead-dark">
                                        <tr>
                                        <th>
                                            @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                <a href="javascript:" class="radio-netral-thead" onclick="radioNetral()"> <i class="icon icon-minus" style="color: cornflowerblue;"></i> </a>
                                            @else
                                                #
                                            @endif
                                            </th> 
                                            <th style="font-size:100%;"> Name</th>
                                            <th style="font-size:100%;"> address </th>   
                                            <th style="font-size:100%;"> city </th>                                 
                                            <th style="font-size:100%;"> State </th>   
                                            <th style="font-size:100%;"> Pincode </th>   
                                            <th style="font-size:100%;"> Country </th>
                                            <th style="font-size:100%;"> Mobile </th>
                                            <th style="font-size:100%;"> Shipping Charges </th>
                                            <th style="font-size:100%;"> Coupon Code </th>
                                            <th style="font-size:100%;"> Coupon Amount </th>
                                            <th style="font-size:100%;"> Order Status </th>
                                            <th style="font-size:100%;"> Payment Method </th>
                                            <th style="font-size:100%;"> Grant Total </th>
                                            <th style="font-size:100%;"> Date </th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $total_All_grand_tot = $total_coupon = $total_shipping_charge = 0; $val = ''; @endphp
                                        @foreach($orders_summary as $key => $val)

                                        @php
                                            $total_All_grand_tot += $val->grant_total;
                                            $total_coupon += $val->coupon_amount;
                                            $total_shipping_charge += $val->shipping_charges;
                                            $val = $val;
                                        @endphp

                                        <tr class="">
                                            <th scope="row" class="center">
                                            @if($page->fetch_role('alter', $module) == TRUE || $page->fetch_role('drop', $module) == TRUE)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input check_usergroup child-check" id="{{ 'child-'.$val->id }}" name="data_id[{{ $val->id }}]" onclick="checkInputValue(this)">
                                                    <label class="custom-control-label" for="{{ 'child-'.$val->id }}" ></label>
                                                </div>
                                            @else
                                                {{ ++$key }}
                                            @endif
                                            </th>
                                            <td class="center"> {{ $val->name }} <br> <span class="span-bottom"> {{ $val->user_email }}</span> </td>
                                            <td class="center"> {{ $val->address }} </td>
                                            <td class="center"> {{ $val->city }} </td>
                                            <td class="center"> {{ $val->state }} </td>
                                            <td class="center"> {{ $val->pincode }} </td>
                                            <td class="center"> {{ $val->country }} </td>
                                            <td class="center"> {{ $val->mobile }} </td>
                                            <td class="center"> {{ 'Rp '.is_number($val->shipping_charges,2) }} </td>
                                            <td class="center"> {{ $val->coupon_code }} </td>
                                            <td class="center"> {{ 'Rp '.is_number($val->coupon_amount,2) }} </td>
                                            <td class="taskStatus">
                                                @if($val->order_status == "New") <span
                                                    class="label label-info"
                                                    style="background-color:RoyalBlue;">{{__('backend.new')}}</span>
                                                @elseif($val->order_status == "Pending") <span
                                                    class="label label-warning">{{__('backend.pending')}}</span>
                                                @elseif($val->order_status == "Cancelled") <span
                                                    class="label label-danger" style="background-color:Red;">
                                                    {{__('backend.cancelled')}}</span>
                                                @elseif($val->order_status == "In_Process") <span
                                                    class="label label-info"> {{__('backend.in_proces')}}</span>
                                                @elseif($val->order_status == "Shipped") <span
                                                    class="label" style="background-color:#87CEFA;">
                                                    {{__('backend.shipped')}}</span>
                                                @elseif($val->order_status == "Delivered") <span
                                                    class="label label-success"> {{__('backend.delivered')}}</span>
                                                @elseif($val->order_status == "Paid") <span
                                                    class="label" style="background-color:#008080;">
                                                    {{__('backend.paid')}}</span>
                                                @else<span
                                                    class="label label-inverse">{{$val->order_status}}</span>
                                                @endif
                                            </td>
                                            <td class="center"> {{ $val->payment_method }} </td>
                                            <td class="center"> {{ 'Rp '.is_number($val->grant_total,2) }} </td>
                                            <td class="center"> {{ Carbon::parse($val->created_at)->format('l, j F Y')}} </td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                    @if($val !== '')
                                    <tfoot> 
                                        <td class="text-right bold-lable" colspan="5"> <span class="label-dangers"> </span> Total Shipping Charges </td>
                                        <td class="text-right bold-lable" colspan="2"> {{ 'Rp '.is_number($total_shipping_charge,2) }}</td>
                                        <td class="text-right bold-lable" colspan="2"> <span class="label-dangers"> </span> Total Coupon Amount </td>
                                        <td class="text-right bold-lable" colspan="2"> {{ 'Rp '.is_number($total_coupon,2) }}</td>
                                        <td class="text-right bold-lable" colspan="2"> <span class="label-dangers"> </span> All Grand Total </td>
                                        <td class="text-right bold-lable" colspan="2"> <u><p> {{ 'Rp '.is_number($total_All_grand_tot,2) }} </p></u> </td>
                                    </tfoot>
                                    @endif
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')

<script>

$(document).ready(function() {
    $("#picked_date").datepicker({ changeYear: true, changeMonth: true, format: 'MM-YYYY' });
})

</script>


@endsection