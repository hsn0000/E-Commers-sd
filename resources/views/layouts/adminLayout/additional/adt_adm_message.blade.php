
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
 
    <script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";
    var my_id_admin = "{{ Session::get('adminID') }}"

    var currentUrl = "{{ $url }}"
    var adm_messages_url = currentUrl.match(/messages/g)

    $(document).ready(function() {

        var ntpCountId = $('#ntpCount'+my_id_admin).attr('id');
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
            if(data.to == my_id) {
            PNotify.desktop.permission(); 
                (new PNotify({
                    title: 'New Message',
                    text: 'You have a new message from admin !',
                    type: 'info',
                    desktop: {
                        desktop: true
                    }
                })).get().click(function() {
                    window.location.href = "{{URL::to('front-messages')}}"
                });
            }
            /*end popup notification*/ 

            /*check valid*/ 
            if(my_id_admin == data.from) {
                $("#"+data.to).click();
            } else if (my_id_admin == data.to) {

            /*add in icon header not*/
            if(ntpCountId == 'ntpCount'+data.to) {  
                /*get data notification*/ 
                $.ajax({
                    type:"post",
                    url:"{{URL::route('get-notification')}}",
                    data: { to: data.to },
                    cache:false,
                    success:function(resp) { 
                        var ntpCount = parseInt($('#ntpCount'+my_id_admin).find('.ntp_count_class').html())
                        if(ntpCount) {
                            if(!adm_messages_url) {
                                $('#ntpCount'+data.to).find('.ntp_count_class').html(ntpCount+1)
                            }
                        } else {
                            if(!adm_messages_url) {
                                $('#ntpCount'+data.to).find('.notiheader-admin').append('<span class="label label-important ntp_count_class">1</span>')
                            }
                        }

                        /*read notif head*/ 
                        if(adm_messages_url) {
                            if(adm_messages_url[0] == "messages") {
                                $.ajax({
                                    type:"post",
                                    url:"{{URL::route('read-notification')}}",
                                    data: {
                                        from:'admin',
                                    },
                                    cache:false,
                                    success: function(resp) {
                                        // console.log(resp)
                                    }, error: function(err) {
                                        console.log("error")
                                    }
                                })                
                            } 
                        }
                        /*end read notif*/ 

                        $(".list_ntp_header_messsage").remove()
                        resp.map(function(datares) {
                            var NtpName = datares.name
                            var NtpTitle = datares.title
                            var NtpBody = datares.body
                            var NtpFrom = datares.from
                            var NtpTo = datares.to
                            var NtpIs_read = datares.is_read
                            var NtpPage = datares.page
                            var NtpCreated_at = datares.created_at
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

                            var NtpIs_reads = NtpIs_read == 0 ? "<span class='badge badge-pill' style=' position: absolute; background: indianred; margin-left: 2px'>!</span>" : "<span> </span>"                
                            var notHtml = "<li class='list_ntp_header_messsage'> "+NtpIs_reads+" <a href='javascript:' onclick='clickNotMsgAdm(\"" + NtpFrom + '.' + NtpTo + "\")' > &nbsp;&nbsp;&nbsp;&nbsp; <b> "+NtpTitle+" </b> <span> | "+NtpName+" </span> | <span style='font-size: small; font-style: italic;'>"+timesPeriodEnd+"</span></a></li> <li class='divider list_ntp_header_messsage'></li>"
        
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
                if(receiver_id == data.from) {
                $("#"+data.from).click();
                } else {
                    var msgCount = parseInt($('#'+data.from).find('.msg-count').html())
                    if(msgCount) {
                        $('#'+data.from).find('.msg-count').html(msgCount+1)
                    } else {
                        $('#' + data.from).append('<span class="msg-count badge badge-info">1</span>')
                    }
                }
                /*end list users message*/
            } 
        });
        /* end pusher*/

        /*user class click*/
        $(".user").click(function() {
            $(".user").removeClass('new online');
            $(this).addClass('new online');
            $(this).find('.msg-count').remove();

            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "/admin/message/" + receiver_id,
                data: "",
                cache: false,
                success: function(data) {
                    //  console.log(data)
                    $("#messages").html(data);
                    scrollToBottomFunc();
                }
            })
        })
        /*end user class*/

        /*keyup input*/
        $(document).on('keyup', '.input-texts', function(e) {
            var message = $(this).val()
            // check if enter key is pressed and message is not nul also received is selected
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "/admin/message",
                    data: datastr,
                    cache: false,
                    success: function(data) {
                        //  console.log(data)
                    },
                    error: function(jqXHR, status, err) {},
                    complete: function() {
                        scrollToBottomFunc();
                    }
                })

                /*add notification DB*/
                var dataNotificationAdmMessage = {
                    from:my_id_admin,
                    to:receiver_id,
                    title:"New Message",
                    body:"You have a new message from admin",
                    page:"adminMessages",
                    is_read:0
                }
                $.ajax({
                    type: "post",
                    url: "/admin/addNotification-message",
                    data: dataNotificationAdmMessage,
                    cache: false,
                    success: function(data) {
                        // console.log(data)
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
        if(sessionStorage.getItem("fromNotmsgAdm")) {
            $("#"+parseInt(sessionStorage.getItem("fromNotmsgAdm"))).click();
        }
        sessionStorage.clear();
        /*endif*/ 

    })

    /*enter send*/
    function sendMsgAdm(r) {
        var message = $('.input-texts').val()
        // check if enter key is pressed and message is not nul also received is selected
            if (message != '' && receiver_id != '') {
                $('.input-texts').val(''); // while pressed enter text box will be empty
            var datastr = "receiver_id=" + receiver_id + "&message=" + message;
            $.ajax({
                type: "post",
                url: "/admin/message",
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
                from:my_id_admin,
                to:receiver_id,
                title:"New Message",
                body:"You have a new message",
                page:"adminMessages",
                is_read:0
            }
            $.ajax({
                type: "post",
                url: "/admin/addNotification-message",
                data: dataNotificationAdmMessage,
                cache: false,
                success: function(data) {
                    // console.log(data)
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

    //    make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.chat-messages').animate({
            scrollTop: $('.chat-messages').get(0).scrollHeight
        }, 50)
    }

    /*image input*/ 
    function imageMessageAdm() {

        $('#input_image_adm').click()
        $('#input_image_adm').bind('change', function() {
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
                    $('#input_image_adm').val('');
                    $('#input_image_adm').unbind()
                    return false;
                }
                /*end valid extention*/ 

            $('#receiver_id_adm').val(receiver_id)

            var form = document.forms.namedItem("upload_img_adm"); // high importance!, here you need change "yourformname" with the name of your form
            var formData = new FormData(form);
        
                $.ajax({
                    type: "POST",
                    url: "{{ route('uploadImgAdm')}}",
                    dataType:'JSON',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
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
                    from:my_id_admin,
                    to:receiver_id,
                    title:"New Message",
                    body:"You have a new message from admin",
                    page:"adminMessages",
                    is_read:0
                }
                $.ajax({
                    type: "post",
                    url: "/front-addNotification-message",
                    data: dataNotificationAdmMessage,
                    cache: false,
                    success: function(data) {
                        // console.log(data)
                    },
                    error: function(jqXHR, status, err) {},
                    complete: function() {
                        console.log('suksess')
                    }
                }) 
                /*end add notification DB*/
            }
            
            $('#input_image_adm').unbind()
        })

    } 
    /*end imginpt*/ 


    function clickNotMsgAdm(NotMsgAdm) {
        var data = NotMsgAdm.split(".")
        var from = parseInt(data[0])
        var to = parseInt(data[1])

        sessionStorage.setItem("fromNotmsgAdm",from);
        window.location.href = "/messages/admin/messages"
    }

    </script>
