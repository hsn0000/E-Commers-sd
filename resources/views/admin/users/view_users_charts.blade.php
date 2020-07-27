<?php

use Carbon\Carbon; 

$currrent_month = date('F');
$last_month = date('F',strtotime("-1 month"));
$last_to_last_month = date('F',strtotime("-2 month"));
$thre_month_back = date('F',strtotime("-3 month"));
$four_month_back = date('F',strtotime("-4 month"));
$five_month_back = date('F',strtotime("-5 month"));

$dataPoints = array(
    array("y" => $five_month_back_users, "label" => $five_month_back),
    array("y" => $four_month_back_users, "label" => $four_month_back),
    array("y" => $thre_month_back_users, "label" => $thre_month_back),
    array("y" => $last_to_last_mount_users, "label" => $last_to_last_month),
    array("y" => $last_mount_users, "label" => $last_month),
    array("y" => $current_mount_users, "label" => $currrent_month),
 );
 
?>

@extends('layouts.adminLayout.admin_design')

@section('title')
view users reporting
@endsection

@section('content')

<script>
    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "users reporting join / semester "
        },
        axisY: {
            title: "calculation"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
    
    }
</script>

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="content">
  <div id="loading"></div>
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></iclass=>{{__('backend.home')}}</a> <a href="{{ $module->permalink }}">{{__('backend.users')}}</a>
            <a href="#" class="current"> view users reporting</a> </div>
        <h1>users reporting</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>view users reporting</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                         <div id="chartContainer" style="height: 570px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

@endsection