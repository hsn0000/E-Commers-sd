@extends('layouts.adminLayout.admin_design')

@section('title')
users reporting countries
@endsection

@section('content')

<script>
    window.onload = function () {
    var getUserCountiesCollecArray = <?php echo json_encode($getUserCountiesCollecArray); ?>;
    
    var chart = new CanvasJS.Chart("chartContainer", {
        exportEnabled: true,
        animationEnabled: true,
        title:{
            text: "user list by country"
            },
            legend:{
                cursor: "pointer",
                itemclick: explodePie
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{y}</strong>",
                indexLabel: "{name} - {y}",
                dataPoints: getUserCountiesCollecArray,
            }]
        });
      chart.render();
    }

    function explodePie (e) {
        if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
        } else {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
        }
        e.chart.render();

    }
</script>

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></iclass=>{{__('backend.home')}}</a> <a href="{{ $module->permalink }}">{{__('backend.users')}}</a>
            <a href="#" class="current">users reporting countries</a> </div>
        <h1>users countries</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>users reporting countries</h5>
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