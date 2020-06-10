@extends('layouts.adminLayout.admin_design')

@section('link')
<style>
    body {
        background: #1B213B;
        color: #777;
        font-family: Montserrat, Arial, sans-serif;
    }

    .body-bg {
        background: #F3F4FA !important;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    strong {
        font-weight: 600;
    }

    .box .apexcharts-xaxistooltip {
        background: #1B213B;
        color: #fff;
    }

    .content-area {
        max-width: 1280px;
        margin: 0 auto;
    }

    .box {
        background-color: #262D47;
        /* padding: 25px 25px;  */
        border-radius: 4px;
    }

    .columnbox {
        padding-right: 15px;
    }

    .radialbox {
        max-height: 333px;
        margin-bottom: 60px;
    }

    .apexcharts-legend-series tspan:nth-child(3) {
        font-weight: bold;
        font-size: 20px;
    }
</style>

<script>
    window.onload = function() {
        /*chart users visit*/
        var chart = new CanvasJS.Chart("chartContainerUsers", {
            title: {
                text: "Active users of each country"
            },
            axisY: {
                title: "Users Visits (visitor)",
                suffix: " $"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,### (visitor)",
                indexLabel: "{y}",
                dataPoints: [{
                        label: "Indonesia",
                        y: 1010
                    },
                    {
                        label: "Kambodia",
                        y: 910
                    },
                    {
                        label: "Turkey",
                        y: 260
                    },
                    {
                        label: "Mesir",
                        y: 504
                    },
                    {
                        label: "Brunei",
                        y: 601
                    },
                    {
                        label: "Fhilipin",
                        y: 410
                    },
                    {
                        label: "India",
                        y: 206
                    },
                    {
                        label: "Malaysia",
                        y: 821
                    },
                    {
                        label: "Singapura",
                        y: 356
                    },
                    {
                        label: "Japan",
                        y: 704
                    },
                    {
                        label: "US America",
                        y: 122
                    },
                    {
                        label: "Rusia",
                        y: 80
                    }
                ]
            }]
        });

        var dataCountry = ["Indonesia", "Kambodia", "Turkey", "Mesir", "Brunei", "Fhilipin", "India", "Malaysia",
            "Singapura", "Japan", "US America", "Rusia"
        ];

        function updateChart() {
            var boilerColor, deltaY, yVal;
            var dps = chart.options.data[0].dataPoints;
            for (var i = 0; i < dps.length; i++) {
                deltaY = Math.round(9 + Math.random() * (-9 - 9));
                yVal = deltaY + dps[i].y > 0 ? dps[i].y + deltaY : 0;
                boilerColor = yVal > 1000 ? "#1E90FF" : yVal >= 900 ? "#FFD700" : yVal >= 800 ? "#008000" : yVal >=
                    700 ? "#20B2AA" : yVal >= 600 ? "#FAFAD2" : yVal >= 500 ? "#8A2BE2" : yVal >= 400 ? "#FA8072" :
                    yVal >= 300 ? "#FFFF00" : yVal >= 200 ? "#FFA500" : yVal >= 100 ? "#FF4500" : yVal <= 100 ?
                    "#FF0000" : null;
                dps[i] = {
                    label: dataCountry[i],
                    y: yVal,
                    color: boilerColor
                };
            }
            chart.options.data[0].dataPoints = dps;
            chart.render();
        };
        updateChart();

        setInterval(function() {
            updateChart()
        }, 400);
        /*endchartusers visit*/

    }
</script>

@endsection

@section('title')
Dashboard | Admin Hsn E-commerce
@endsection

@section('content')

@php
    use App\Product;
    $categoriesTotal = Product::categoriesTotal();
    $productTotal = Product::productTotal();
    $orderTotal = Product::orderTotal();
    $usersTotal = Product::usersTotal();
@endphp

<div id="loading"></div>

<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        @if(Session::has('flash_message_success'))
        <div id="gritter-item-1" class="gritter-item-wrapper"
            style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
            <a href="javascript:" class="closeToast"> <span
                    style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x
                </span> </a>
            <div class="gritter-top">
            </div>
            <div class="gritter-item" style="background: lightseagreen;">
                <div class="gritter-close" style="display: none;">
                </div><img src="{{url('images/done.png')}}" class="gritter-image"
                    style="width: 52px; height: 50px; padding-right: 9px;">
                <div class="gritter-with-image">
                    <span class="gritter-title"> <b>Is Permitted ! </b></span>
                    <p><b> {{Session::get('flash_message_success')}} </b></p>
                </div>
                <div style="clear:both">
                </div>
            </div>
            <div class="gritter-bottom">
            </div>
        </div>
        @endif
        @if(Session::has('flash_message_error'))
        <div id="gritter-item-1" class="gritter-item-wrapper"
            style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
            <a href="javascript:" class="closeToast"> <span
                    style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x
                </span> </a>
            <div class="gritter-top">
            </div>
            <div class="gritter-item" style="background: red;">
                <div class="gritter-close" style="display: none;">
                </div><img src="{{url('images/fail.jpg')}}" class="gritter-image"
                    style="width: 52px; height: 50px; padding-right: 9px;">
                <div class="gritter-with-image">
                    <span class="gritter-title"> <b>Forbidden ! </b></span>
                    <p><b> {{Session::get('flash_message_error')}} </b></p>
                </div>
                <div style="clear:both">
                </div>
            </div>
            <div class="gritter-bottom">
            </div>
        </div>
        @endif

        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><iclass="icon-home"></iclass=> Home</a></div>
    </div>
    <!--End-breadcrumbs-->

    <!--Action boxes-->
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                <li class="bg_lb"> <a href="{{url('/admin/dashboard')}}"> <i class="icon-dashboard"></i> <span class="label label-important">~</span> My Dashboard </a> </li>

                {{-- @if(Session::get('adminDetails')['categories_view_access'] == 1) --}}
                <li class="bg_ly"> <a href="{{url('/admin/view-categories')}}"> <i class="icon icon-th-list"></i><span class="label label-success">{{$categoriesTotal}}</span> Categories </a> </li>
                {{--  @endif --}}
                {{-- @if(Session::get('adminDetails')['products_access'] == 1) --}}
                <li class="bg_lo"> <a href="{{url('/admin/view-product')}}"> <i class="icon icon-book"></i><span class="label label-success">{{$productTotal}}</span> Products</a> </li>
                {{-- @endif --}}
                {{-- @if(Session::get('adminDetails')['order_access'] == 1) --}}
                <li class="bg_ls"> <a href="{{url('/admin/view-orders')}}"> <i class="icon icon-shopping-cart"></i><span class="label label-success">{{$orderTotal}}</span> Orders </a> </li>
                {{-- @endif --}}
                {{-- @if(Session::get('adminDetails')['users_access'] == 1) --}}
                <li class="bg_lr"> <a href="{{url('/admin/view-users')}}"> <i class="icon icon-user"></i><span class="label label-success">{{$usersTotal}}</span> Users </a> </li>
                {{-- @endif --}}
              <!-- <li class="bg_lg span3"> <a href="#"> <i class="icon-signal"></i> Charts</a> </li> -->
              <li class="bg_ly"> <a href="#"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
              <!--
              <li class="bg_lo"> <a href="#"> <i class="icon-th"></i> Tables</a> </li>
              <li class="bg_ls"> <a href="#"> <i class="icon-fullscreen"></i> Full width</a> </li>
              <li class="bg_lo span3"> <a href="#"> <i class="icon-th-list"></i> Forms</a> </li>
              <li class="bg_ls"> <a href="#"> <i class="icon-tint"></i> Buttons</a> </li>
              <li class="bg_lb"> <a href="#"> <i class="icon-pencil"></i>Elements</a> </li>
              <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li> 
              <li class="bg_lr"> <a href="#"> <i class="icon-info-sign"></i> Error</a> </li> -->

            </ul>
        </div>
        <!--End-Action boxes-->

        <!--Chart-box-->
        <div class="row-fluid">
            <div class="widget-box">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                    <h5>Users Analytics</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span9">
                            <div id="chartContainerUsers" style="height: 384px; width: 100;"></div>
                        </div>
                        <div class="span3">
                            <ul class="site-stats">
                                <li class="bg_lh"><i class="icon-user"></i> <strong>2540</strong> <small>Total
                                        Users</small></li>
                                <li class="bg_lh"><i class="icon-plus"></i> <strong>120</strong> <small>New Users
                                    </small></li>
                                <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>656</strong> <small>Total
                                        Shop</small></li>
                                <li class="bg_lh"><i class="icon-tag"></i> <strong>9540</strong> <small>Total
                                        Order1</small></li>
                                <li class="bg_lh"><i class="icon-repeat"></i> <strong>10</strong> <small>Pending
                                        Order2</small></li>
                                <li class="bg_lh"><i class="icon-globe"></i> <strong>8540</strong> <small>Online
                                        Order3</small></li>
                                <li class="bg_lh"><i class="icon-tag"></i> <strong>8540</strong> <small>Online
                                        Order4</small></li>
                                <li class="bg_lh"><i class="icon-plus"></i> <strong>8540</strong> <small>Online
                                        Order5</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- site analytics -->
            <div class="widget-box">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                    <h5>Site Analytics</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">

                            <div class="span12">
                                <div class="box columnbox mt-4">
                                    <div id="columnchart"> </div>
                                </div>
                            </div>
                            <div class="span6" style="margin-top: 24px; margin:18px 0 0 0">
                                <div class="box  mt-4">
                                    <div id="linechart"> </div>
                                </div>

                              <div class="widget-box">
                                <div class="widget-title"><span class="icon"><i class="icon-user"></i></span>
                                  <h5>Our Partner (Comming soon)</h5>
                                </div>
                                <div class="widget-content nopadding fix_hgt">
                                  <ul class="recent-posts">
                                    <li>
                                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{url('images/backend_images/demo/av1.jpg')}}"> </div>
                                      <div class="article-post"> <span class="user-info">John Deo</span>
                                        <p>Web Desginer &amp; creative Front end developer</p>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{url('images/backend_images/demo/av2.jpg')}}"> </div>
                                      <div class="article-post"> <span class="user-info">John Deo</span>
                                        <p>Web Desginer &amp; creative Front end developer</p>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{url('images/backend_images/demo/av4.jpg')}}"> </div>
                                      <div class="article-post"> <span class="user-info">John Deo</span>
                                        <p>Web Desginer &amp; creative Front end developer</p>
                                      </div>
                                  </li></ul>
                                </div>
                              </div>
                            </div>
                            
                            <!-- chat -->
                            <div class="span6">
                                <div class="widget-box widget-chat">
                                    <div class="widget-title bg_lb"> <span class="icon"> <i class="icon-comment"></i>
                                        </span>
                                        <h5>Chat Option</h5>
                                    </div>
                                    <div class="widget-content nopadding collapse in" id="collapseG4">
                                        <div class="chat-users panel-right2">
                                            <div class="panel-title">
                                                <h5>Online Users</h5>
                                            </div>
                                            <div class="panel-content nopadding">
                                                <ul class="contact-list">
                                                    <li id="user-Alex" class="online"><a href=""><img alt="" src="{{url('images/backend_images/demo/av1.jpg')}}"> <span>Fajar</span></a></li>
                                                    <li id="user-John" class="online new"><a href=""><img alt=""src="{{url('images/backend_images/demo/av3.jpg')}}"> <span>Jamaludin</span></a><span class="msg-count badge badge-info">4</span></li>
                                                    <li id="user-Mark" class="online"><a href=""><img alt="" src="{{url('images/backend_images/demo/av4.jpg')}}"> <span>Herman</span></a></li>
                                                    <li id="user-Maxi" class="online"><a href=""><img alt="" src="{{url('images/backend_images/demo/av5.jpg')}}"> <span>Ruslan</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="chat-content panel-left2">
                                            <div class="chat-messages" id="chat-messages">
                                                <div id="chat-messages-inner">
                                                    <p id="msg-1" class="user-linda" style="display: block;"><span class="msg-block"><img src="{{url('images/backend_images/demo/av2.jpg')}}" alt=""><strong>Linda</strong> <span class="time">-15:27</span><span class="msg">Hello Every one do u want to freindship with me?</span></span></p>
                                                    <p id="msg-2" class="user-mark" style="display: block;"><span class="msg-block"><img src="{{url('images/backend_images/demo/av3.jpg')}}" alt=""><strong>Admin</strong> <span class="time">-15:27</span><span class="msg">Yuppi! why not sirji!!.</span></span></p>
                                                    <p id="msg-3" class="user-linda" style="display: block;"><span class="msg-block"><img src="{{url('images/backend_images/demo/av2.jpg')}}" alt=""><strong>Linda</strong> <span class="time">-15:27</span><span class="msg">Thanks!!! See you soon than</span></span></p>
                                                    <p id="msg-4" class="user-mark" style="display: block;"><span class="msg-block"><img src="{{url('images/backend_images/demo/av3.jpg')}}" alt=""><strong>Admin</strong> <span class="time">-15:27</span><span class="msg">ok Bye than!!!.</span></span></p>
                                                    <p class="offline" id="msg-5" style="display: block;"><span>User Linda left the chat</span></p>
                                                </div>
                                            </div>
                                            <div class="chat-message well">
                                                <button class="btn btn-success">Send</button>
                                                <span class="input-box">
                                                    <input type="text" name="msg-box" id="msg-box">
                                                </span> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- endchat -->
                        </div>
                    </div>
                </div>
            </div>
             <!-- end site analytics -->
        </div>
        <!--End-Chart-box-->
        <hr />
    </div>
</div>

<!--end-main-container-part-->

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script>
    window.Apex = {
        chart: {
            foreColor: '#fff',
            toolbar: {
                show: false
            },
        },
        colors: ['#FCCF31', '#17ead9', '#f02fc2'],
        stroke: {
            width: 3
        },
        dataLabels: {
            enabled: false
        },
        grid: {
            borderColor: "#40475D",
        },
        xaxis: {
            axisTicks: {
                color: '#333'
            },
            axisBorder: {
                color: "#333"
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                gradientToColors: ['#F55555', '#6078ea', '#6094ea']
            },
        },
        // tooltip: {
        //     theme: 'dark',
        //     x: {
        //         formatter: function(val) {
        //             return moment(new Date(val)).format("HH:mm:ss")
        //         }
        //     }
        // },
        yaxis: {
            decimalsInFloat: 2,
            opposite: true,
            labels: {
                offsetX: -10
            }
        }
    };

    var trigoStrength = 3
    var iteration = 11

    function getRandom() {
        var i = iteration;
        return (Math.sin(i / trigoStrength) * (i / trigoStrength) + i / trigoStrength + 1) * (trigoStrength * 2)
    }

    function getRangeRandom(yrange) {
        return Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
    }

    function generateMinuteWiseTimeSeries(baseval, count, yrange) {
        var i = 0;
        var series = [];
        while (i < count) {
            var x = baseval;
            var y = ((Math.sin(i / trigoStrength) * (i / trigoStrength) + i / trigoStrength + 1) * (trigoStrength * 2))

            series.push([x, y]);
            baseval += 300000;
            i++;
        }
        return series;
    }



    function getNewData(baseval, yrange) {
        var newTime = baseval + 300000;
        return {
            x: newTime,
            y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
        }
    }

    var optionsColumn = {
        chart: {
            height: 350,
            type: 'bar',
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
            // dropShadow: {
            //   enabled: true,
            //   left: -14,
            //   top: -10,
            //   opacity: 0.05
            // },
            events: {
                animationEnd: function(chartCtx) {
                    const newData = chartCtx.w.config.series[0].data.slice()
                    newData.shift()
                    window.setTimeout(function() {
                        chartCtx.updateOptions({
                            series: [{
                                data: newData
                            }],
                            xaxis: {
                                min: chartCtx.minX,
                                max: chartCtx.maxX
                            },
                            subtitle: {
                                text: parseInt(getRangeRandom({
                                    min: 1,
                                    max: 20
                                })).toString() + '%',
                            }
                        }, false, false)
                    }, 300)
                }
            },
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 0,
        },
        series: [{
            name: 'Load Average',
            data: generateMinuteWiseTimeSeries(new Date("12/12/2016 00:20:00").getTime(), 12, {
                min: 10,
                max: 110
            })
        }],
        title: {
            text: 'Load Average',
            align: 'left',
            style: {
                fontSize: '12px'
            }
        },
        subtitle: {
            text: '20%',
            floating: true,
            align: 'right',
            offsetY: 0,
            style: {
                fontSize: '22px'
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.5,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 0.8,
                stops: [0, 100]
            }
        },
        xaxis: {
            type: 'datetime',
            range: 2700000
        },
        legend: {
            show: true
        },
    }



    var chartColumn = new ApexCharts(
        document.querySelector("#columnchart"),
        optionsColumn
    );
    chartColumn.render()

    /*linechart*/
    var optionsLine = {
        chart: {
            height: 350,
            type: 'line',
            stacked: true,
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 5000
                }
            },
            dropShadow: {
                enabled: true,
                opacity: 0.3,
                blur: 5,
                left: -7,
                top: 22
            },
            events: {
                animationEnd: function(chartCtx) {
                    const newData1 = chartCtx.w.config.series[0].data.slice()
                    newData1.shift()
                    const newData2 = chartCtx.w.config.series[1].data.slice()
                    newData2.shift()
                    window.setTimeout(function() {
                        chartCtx.updateOptions({
                            series: [{
                                data: newData1
                            }, {
                                data: newData2
                            }],
                            subtitle: {
                                text: parseInt(getRandom() * Math.random()).toString(),
                            }
                        }, false, false)
                    }, 300)
                }
            },
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 5,
        },
        grid: {
            padding: {
                left: 0,
                right: 0
            }
        },
        markers: {
            size: 0,
            hover: {
                size: 0
            }
        },
        series: [{
            name: 'Running',
            data: generateMinuteWiseTimeSeries(new Date("12/12/2016 00:20:00").getTime(), 12, {
                min: 30,
                max: 110
            })
        }, {
            name: 'Waiting',
            data: generateMinuteWiseTimeSeries(new Date("12/12/2016 00:20:00").getTime(), 12, {
                min: 30,
                max: 110
            })
        }],
        xaxis: {
            type: 'datetime',
            range: 2700000
        },
        title: {
            text: 'Processes',
            align: 'left',
            style: {
                fontSize: '12px'
            }
        },
        subtitle: {
            text: '20',
            floating: true,
            align: 'right',
            offsetY: 0,
            style: {
                fontSize: '22px'
            }
        },
        legend: {
            show: true,
            floating: true,
            horizontalAlign: 'left',
            onItemClick: {
                toggleDataSeries: false
            },
            position: 'top',
            offsetY: -33,
            offsetX: 60
        },
    }

    var chartLine = new ApexCharts(
        document.querySelector("#linechart"),
        optionsLine
    );
    chartLine.render()

    /*endlinechart*/

    window.setInterval(function() {

        iteration++;

        chartColumn.updateSeries([{
            data: [...chartColumn.w.config.series[0].data,
                [
                    chartColumn.w.globals.maxX + 210000,
                    getRandom()
                ]
            ]
        }])

        chartLine.updateSeries([{
            data: [...chartLine.w.config.series[0].data,
                [
                    chartLine.w.globals.maxX + 300000,
                    getRandom()
                ]
            ]
        }, {
            data: [...chartLine.w.config.series[1].data,
                [
                    chartLine.w.globals.maxX + 300000,
                    getRandom()
                ]
            ]
        }])



    }, 3000)
</script>

@endsection