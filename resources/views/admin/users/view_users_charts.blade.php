<?php

use Carbon\Carbon; 

$currrent_month = date('F');
$last_month = date('F',strtotime("-1 month"));
$last_to_last_month = date('F',strtotime("-2 month"));
$thre_month_back = date('F',strtotime("-3 month"));

$dataPoints = array(
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
            text: "Users Reporting"
        },
        axisY: {
            title: "Number of Users"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
    
    }
</script>

<div id="content">
  <div id="loading"></div>
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></iclass=>{{__('backend.home')}}</a> <a href="#">users reporting</a>
            <a href="{{url('/admin/view-categories')}}" class="current">view users reporting</a> </div>
        <h1>users reporting</h1>
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