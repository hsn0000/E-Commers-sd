<?php 

return [
    'color' => [
        'Blue',
        'Black',
        'Red',
        'Green',
        // 'Brown',
        // 'Gray',
        // 'Orange',
        // 'Rainbow',
        'White'
    ],

    'link' => [
         'http://localhost:9000',
         'http://localhost:8000',
         'http://localhost:7000',
         'http://localhost:6000',
         'http://localhost:5000',
         'http://localhost:4000',
         'http://localhost:3000',
         'http://localhost:2000',
         'http://localhost:1000',
         'http://localhost:900',
         'http://localhost:800',
         'http://localhost:700',
         'http://localhost:600',
         'http://localhost:500',
         'http://localhost:400',
         'http://localhost:300',
         'http://localhost:200',
         'http://localhost:100'
    ],

    'sleeveArray' => [
        'Full Sleeve',
        'Half Sleeve',
        'Short Sleeve',
        'Sleeveless'
    ],

    'patternArray' => [
        'Checked',
        'Plain',
        'Printed',
        'Self',
        'Solid'
    ],

    'm_list' => [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
     ],
  
     'm_abb' => [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Ags',
        'Sep',
        'Okt',
        'Nov',
        'Dec'
     ],
  
     'day_list' => [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
     ],

         'messages_error' => [
             "<div id='gritter-item-1' class='gritter-item-wrapper' style='position: fixed;z-index: 500;float: right; right: 14px; top: 55px;'>
             <a href='javascript:' class='closeToast'> <span style='background-color: black; float: right; width: 23px; text-align: center; color: white;'> x </span> </a>
             <div class='gritter-top'>
             </div>
             <div class='gritter-item' style='background: orangered;'>
                 <div class='gritter-close' style='display: none;'>
                 </div><img src='{{ url('images/fail.jpg') }}' class='gritter-image' style='width: 52px; height: 50px; padding-right: 9px;'>
                 <div class='gritter-with-image'>
                     <span class='gritter-title'> <b> Error ! </b></span>
                     <p><b> <?php echo Session::get('msg_error') ?> </b></p>
                 </div>
                 <div style='clear:both'>
                 </div>
             </div>
             <div class='gritter-bottom'>
             </div>
         </div> ",
         
         ],

         'messages_success' => [
             'kosong'
         ]
     
]



?>