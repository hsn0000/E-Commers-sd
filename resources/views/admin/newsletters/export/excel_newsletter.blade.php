<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

@php
use Carbon\Carbon; 
@endphp
<div id="content">
    <div id="loading"></div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="newsletter_table">
                                <thead>
                                <tr class="from">
                                    <td class="text-center ems_from" colspan="3" style="font-weight: 900;"> Newsletter Export Excel </td>
                                </tr>
                                    <tr>
                                        <th style="font-size:100%;">{{__('backend.users_id')}}</th>
                                        <th style="font-size:100%;">{{__('backend.email')}}</th>
                                        <th style="font-size:100%;">{{__('backend.register_on')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscribersData as $newsletter)
                                    <tr class="">
                                        <td style="text-align:center;">{{$newsletter->id}}</td>
                                        <td style="text-align:center;">{{$newsletter->email}}</td>
                                        <td style="text-align:center;">{{Carbon::parse($newsletter->created_at)->format('l, j F Y | H:i A')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input style="margin:10 10 40 15;" class="btn btn-outline-info btn-sm btn-filte" type="button" onclick="tableToExcel('newsletter_table', 'W3C Example Table')" value="Export to Excel">

<script type="text/javascript">
    var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> <style> .ems_from {font-weight: 900;} .table {top : 20vh;border:1px solid  #999;font-family: sans-serif;color: #232323;border-collapse: collapse;text-align: center;margin-right:30px;font-size:11px;}.table, thead, tr, th, tbody, tr, td, th {border: 1px solid #999;padding: 8px 22px; text-align:center;}.thead-info {background-color: #ADD8E6;} .ems_from { background: white; font-weight: 900; height:30px;border:none;border:hidden;}.from {background: white;border:none; border:hidden;} </style></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        var a = document.createElement('a');
        a.href = uri + base64(format(template, ctx))
        a.download = 'newslatter.xls';
        a.click();
      }
    })()
 </script> 


