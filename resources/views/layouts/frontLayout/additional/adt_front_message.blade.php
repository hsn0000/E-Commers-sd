<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<script>
var receiver_id = '';
var my_id = "{{ Auth::id() }}";
var my_id_admin = "{{ Session::get('adminID') }}"

var currentUrl = "{{ $url }}"
var front_messages_url = currentUrl.match(/front-messages/g)

$(document).ready(function() {
    var ntpCountId = $('#ntpCount'+my_id).attr('id');
    /* header ajax */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* pusher */
    Pusher.logToConsole = true;
    var pusher = new Pusher('01c70fb96706b1b73d19', {
        cluster: 'ap1',
        forceTLS: true,
        encrypted: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) { 
        // console.log(JSON.stringify(data))
        /*popup notification*/ 
        if(data.to == my_id_admin) {
            PNotify.desktop.permission();
                (new PNotify({
                    title: 'New Message',
                    text: 'You have a new message from users !',
                    type: 'info',
                    desktop: {
                        desktop: true
                    }
                })).get().click(function() {
                    window.location.href = "{{URL::to('/admin/messages')}}"
                });
        }
        /*end popup notification*/     

        /*check valid*/    
        if (my_id == data.from) {
            $("#" + data.to).click();
        } else if (my_id == data.to) {

        /*add in icon header not*/
        if(ntpCountId == 'ntpCount'+data.to) {  
            /*get data notification*/     
            $.ajax({
                type:"post",
                url:"{{URL::route('get-notification')}}",
                data: { to: data.to },
                cache:false,
                success:function(resp) { 
                    var ntpCount = parseInt($('#ntpCount'+my_id).find('.ntp_count_class').html())
                    if(ntpCount) {
                        if(!front_messages_url) {
                            $('#ntpCount'+data.to).find('.ntp_count_class').html(ntpCount+1)
                        }
                    } else {
                        if(!front_messages_url) {
                            $('#ntpCount'+data.to).find('.fa-bell').append('<span style="color:crimson;">( <span class="ntp_count_class"> 1 </span> )</span>')
                        }
                    }

                    /*read notif head*/ 
                    if(front_messages_url) {
                        if(front_messages_url[0] == "front-messages") {
                            $.ajax({
                                type:"post",
                                url:"{{URL::route('read-notification')}}",
                                data: {
                                    from:'users',
                                },
                                cache:false,
                                success: function(resp) {
                                    console.log(resp)
                                }, error: function(err) {
                                    console.log("error")
                                }
                            })                
                        } 
                    }
                    /*end read notif*/ 

                    $(".list_ntp_header_messsage").remove()
                    resp.map(function(data) {
                        var NtpName = data.name
                        var NtpTitle = data.title
                        var NtpBody = data.body
                        var NtpFrom = data.from
                        var NtpTo = data.to
                        var NtpIs_read = data.is_read
                        var NtpPage = data.page
                        var NtpCreated_at = data.created_at
                        var NtpCreated_ats = NtpCreated_at.toString().substr(0, 10)
                        
                        var arr_mount = <?php echo json_encode(config('customeArr.m_abb')); ?>; 
                        var arr_day = <?php echo json_encode(config('customeArr.day_list')); ?>;

                        var dates = new Date(NtpCreated_ats);
                        var day = dates.getDay()
                        var year = dates.getFullYear()
                        var mount = dates.getMonth()
                        var date = dates.getDate()
                        var hours = dates.getHours()
                        var arr_m = arr_mount[mount];
                        var arr_d = arr_day[day]
                        var timesPeriodEnd = date + ' ' + arr_m + ' ' + year

                        var NtpIs_reads = NtpIs_read == 0 ? "<span class='badge badge-pill' style=' position: absolute; background: indianred; margin-left: 2px;'>!</span>" : "<span> </span>"                
                        var notHtml = "<li class='list_ntp_header_messsage'> "+NtpIs_reads+" <a href='javascript:' onclick='clickNotMsg(\"" + NtpFrom + '.' + NtpTo + "\")' > <b <b style='margin-left: 1px;'> "+NtpTitle+" </b> <span> | "+NtpName+" </span> | <span style='font-size: small; font-style: italic;'>"+timesPeriodEnd+"</span></a></li>"
      
                        $("#ntp_header_messsage").append(notHtml)
                        })
                    }, error:function(err) {
                        console.log("error")
                    }
            })
            /*get data notification*/
        } 
        /*end add in icon header not*/ 

         /*list users message*/ 
            if (receiver_id == data.from) {
                $("#" + data.from).click();
            } else {
                var msgCount = parseInt($('#' + data.from).find('.msg-count').html())
                if (msgCount) {
                    $('#' + data.from).find('.msg-count').html(msgCount + 1)
                } else {
                    $('#msg-count-h'+ data.from).append('<span class="badge badge-pill badge-info msg-count" style="background-color:cornflowerblue">1</span>')
                }
            }
            /*end list users message*/
        }
          /*end check valid*/  
    });
    /* end pusher*/

    /*user class click*/
    $(".user").click(function() {
        $(".user").removeClass('active_chat');
        $(this).addClass('active_chat');
        $(this).find('.msg-count').remove();

        receiver_id = $(this).attr('id');
        $.ajax({
            type: "get",
            url: "/front-message/" + receiver_id,
            data: "",
            cache: false,
            success: function(data) {
                $("#messages").html(data);
                scrollToBottomFunc();
            }
        })
    })
    /*end user class*/

    /*keyup input*/
    $(document).on('keyup', '.write_msg', function(e) {
        var message = $(this).val()
        // check if enter key is pressed and message is not nul also received is selected
        if (e.keyCode == 13 && message != '' && receiver_id != '') {
            $(this).val(''); // while pressed enter text box will be empty

            var datastr = "receiver_id=" + receiver_id + "&message=" + message;
            $.ajax({
                type: "post",
                url: "/front-message",
                data: datastr,
                cache: false,
                success: function(data) {
                    // console.log(data)
                },
                error: function(jqXHR, status, err) {},
                complete: function() {
                    scrollToBottomFunc();
                }
            })

            /*add notification DB*/
            var dataNotificationAdmMessage = {
                from:my_id,
                to:receiver_id,
                title:"New Message",
                body:"You have a new message from users",
                page:"frontMessages",
                is_read:0
            }
            $.ajax({
                type: "post",
                url: "/front-addNotification-message",
                data: dataNotificationAdmMessage,
                cache: false,
                success: function(data) {
                    console.log(data)
                },
                error: function(jqXHR, status, err) {},
                complete: function() {
                    console.log('suksess')
                }
            }) 
            /*end add notification DB*/
        }
    })
    /* end keyup input */

    /*click if*/ 
    if(sessionStorage.getItem("fromNotmsg")) {
       $("#"+parseInt(sessionStorage.getItem("fromNotmsg"))).click();
    }
    sessionStorage.clear();
    /*endif*/ 

}) 

/*enter send*/
function sendMsgFront(r) {
    var message = $('.write_msg').val()
    // check if enter key is pressed and message is not nul also received is selected
        if (message != '' && receiver_id != '') {
            $('.write_msg').val(''); // while pressed enter text box will be empty
        var datastr = "receiver_id=" + receiver_id + "&message=" + message;
        $.ajax({
            type: "post",
            url: "/front-message",
            data: datastr,
            cache: false,
            success: function(data) {
                // console.log(data)
            },
            error: function(jqXHR, status, err) {},
            complete: function() {
                scrollToBottomFunc();
            }
        })

        /*add notification DB*/
        var dataNotificationAdmMessage = {
            from:my_id,
            to:receiver_id,
            title:"New Message",
            body:"You have a new message from users",
            page:"frontMessages",
            is_read:0
        }
        $.ajax({
            type: "post",
            url: "/front-addNotification-message",
            data: dataNotificationAdmMessage,
            cache: false,
            success: function(data) {
                console.log(data)
            },
            error: function(jqXHR, status, err) {},
            complete: function() {
                console.log('suksess')
            }
        }) 
        /*end add notification DB*/
    }
}
/*end enter send*/ 


// make a function to scroll down auto
function scrollToBottomFunc() {
    $('.msg_history').animate({
        scrollTop: $('.msg_history').get(0).scrollHeight
    }, 50)
}


/*image input*/ 
function imageMessage() {
    $('#input_image').click()
    $('#input_image').bind('change', function() {
        var valueImg = $(this).val()

        if (valueImg != '' && receiver_id != '') {
            $('.write_msg').val(''); // while pressed enter text box will be empty
            /*valid extention*/    
            var extension = valueImg.split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1)
            {
                new PNotify({
                    title: 'Invalid',
                    text: 'invalid image file !',
                    type: 'error',
                });
                $('#input_image').val('');
                $('#input_image').unbind()
                return false;
            }
            /*end valid extention*/ 

        $('#receiver_id_fron').val(receiver_id)

        var form = document.forms.namedItem("upload_img_front"); // high importance!, here you need change "yourformname" with the name of your form
        var formData = new FormData(form);
            $.ajax({
                method: "POST",
                url: "{{ route('uploadImgFron')}}",
                dataType:'JSON',
                data:formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                },
                error: function(jqXHR, status, err) {},
                complete: function() {
                    scrollToBottomFunc();
                }
            })

            /*add notification DB*/
            var dataNotificationAdmMessage = {
                from:my_id,
                to:receiver_id,
                title:"New Message",
                body:"You have a new message from users",
                page:"frontMessages",
                is_read:0
            }
            $.ajax({
                type: "post",
                url: "/front-addNotification-message",
                data: dataNotificationAdmMessage,
                cache: false,
                success: function(data) {
                    console.log(data)
                },
                error: function(jqXHR, status, err) {},
                complete: function() {
                    console.log('suksess')
                }
            }) 
            /*end add notification DB*/
        }
        
        $('#input_image').unbind()
    })

} 
/*end imginpt*/ 

function clickNotMsg(NotMsg) {
    var data = NotMsg.split(".")
    var from = parseInt(data[0])
    var to = parseInt(data[1])

    sessionStorage.setItem("fromNotmsg",from);
    window.location.href = "front-messages"
}


</script>