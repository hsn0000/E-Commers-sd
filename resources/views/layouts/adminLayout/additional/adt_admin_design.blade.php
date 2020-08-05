<script>
$(document).ready(function() {
    /*
        select
    */ 
    $('.DataTables_sort_icon, .css_right ui-icon, .ui-icon-triangle-1-n').remove()

    /*Admin Roles*/ 
    $("#type").change(function() {
        var type = $("#type").val();
        if(type == "Admin") {
            $("#access").hide();
        } else {
            $("#access").show();
        }
    })

    var type = $("#type").val();
        if(type == "Admin") {
            $("#access").hide();
        } else {
            $("#access").show();
        }
    /*end admin Roles*/ 
    
        // logout  admin
        $(".logoutUser").click(function() {
            Swal.fire({ 
                title: "{{__('validation.are_you_sure')}}",
                text: "{{__('validation.you_want_to_logout_this_page')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{__('validation.yes_logout_it')}}"
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        "{{__('validation.logout_Page')}}",
                        "{{__('validation.your_has_been_logout_this_page')}}",
                        "{{__('validation.success')}}",
                    )
                    window.location.href = "/logout"
                }
            })

        });

        // password lama setting
        $("#current_pwd").keyup(function() {
            var inCorect =
                "<span class='badge badge' style='background-color: firebrick;position: static;'>{{__('validation.passIncorect')}}</span>"
            var isCorect =
                "<span class='badge badge-success' style='position: static;'>{{__('validation.passIscorrect')}}</span>"
            var current_pwd = $("#current_pwd").val();
            $.ajax({
                type: 'get',
                url: '/profile-usr/admin/check-pwd',
                data: {
                    current_pwd: current_pwd
                },
                success: function(resp) {
                    if (resp == "false") {
                        $("#chkPwd").html(inCorect);
                    } else if (resp == "true") {
                        $("#chkPwd").html(isCorect);
                    }
                },
                error: function(error) {
                    alert(error);
                }
            });
        });

        // password validate admin
        $("#password_validate").validate({
            rules: {
                current_pwd: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                new_pwd: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                },
                confirm_pwd: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                    equalTo: "#new_pwd"
                }
            },
            messages: {
                current_pwd: {
                    required: "<span class='badge badge' style='background-color: orange; position: absolute;left: 200px;margin-top: 5px;'{{__('validation.please_enter_your_current_password')}}</span>",
                    minlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_atleast_6_characters_long')}}</span>",
                    maxlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_at_most_20_characters')}}</span>",
                },
                new_pwd: {
                    required: "<span class='badge badge' style='background-color: orange; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.please_enter_your_new_password')}}</span>",
                    minlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_atleast_6_characters_long')}}</span>",
                    maxlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_at_most_20_characters')}}</span>",
                },
                confirm_pwd: {
                    required: "<span class='badge badge' style='background-color: orange; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.please_confirm_your_new_password')}}</span>",
                    minlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_must_be_atleast_6_characters_long')}}</span>",
                    maxlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_must_be_at_most_20_characters')}}</span>",
                    equalTo: "<span class='badge badge' style='background-color: firebrick; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_is_not_the_same')}}</span>",
                }
            }

        });


        // password validate add user admin
        $("#form-data").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                repassword: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "<span class='badge badge' style='background-color: orange; position: absolute;left: 200px;margin-top: 5px;'{{__('validation.please_enter_your_current_password')}}</span>",
                    minlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_atleast_6_characters_long')}}</span>",
                    maxlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px;margin-top: 5px;'>{{__('validation.your_password_must_be_at_most_20_characters')}}</span>",
                },
                repassword: {
                    required: "<span class='badge badge' style='background-color: orange; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.please_confirm_your_new_password')}}</span>",
                    minlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_must_be_atleast_6_characters_long')}}</span>",
                    maxlength: "<span class='badge badge' style='background-color: orangered; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_must_be_at_most_20_characters')}}</span>",
                    equalTo: "<span class='badge badge' style='background-color: firebrick; position: absolute;left: 200px; margin-top: 3px;'>{{__('validation.your_password_is_not_the_same')}}</span>",
                }
            }

        });

        // load image function
        onLoadDiv()

        setTimeout(() => {
            onScrollDiv()
        }, 1700);
        // end load

        // tema 
        if(sessionStorage.getItem("tema_template") == "maronTema")
        {
            maronTema()
        }

    });

    /* overlay */ 
    var $overlay = $("<div id='overlay' class='tumb-image'> </div>");
    var $image = $("<img class='lazy'>");
    var $caption = $('<p></p>');
    //add the elements onto each other
    $overlay.append($image);

    $("body").append($overlay);
    //click event
    function popupGambar(event) { 

        var imageLocation = event["src"];
        $image.attr("src", '/images/gif/loading_card5.gif');
        
        setTimeout(()=>{
            $image.attr("src", imageLocation);

        }, 800)
        var captionText = event["alt"];
        // $caption.text(captionText);
        $overlay.show();

    };
    //click event
    $overlay.click(function() {
        $overlay.hide();
    });


    // /* overlay zoom image */ 
    // var $overlay = $('<div id="overlay"></div>');
    // var $image = $("<img>");
    // var $caption = $("<p></p>");
    // //add the elements onto each other
    // $overlay.append($image);
    // $overlay.append($caption);
    // $("body").append($overlay);
    // //click event 
    // function popupGambar(event) {
    //     var imageLocation = event["src"];
    //     $image.attr("src", imageLocation);
    //     var captionText = event["alt"];
    //     $caption.text(captionText);
    //     $overlay.show(); 
    // };
    // //click event
    // $overlay.click(function() {
    //     $overlay.hide();
    // }); 

   //   delete category
   function deleteThis(even) {
    var id = $(even).attr('rel');
    var name = $(even).attr('rel2');
    var deleteFunction = $(even).attr('rel1');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: "{{__('validation.are_you_sure')}}",
        text: '{{__("validation.you_want_to_delete_this")}}"' + name + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{__('validation.yes_delete_it')}}",
        cancelButtonText: "{{__('validation.no_cancel')}}",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.deleted')}}",
                '"' + name +
                '" {{__("validation.your")}} {{__("validation.has_been_deleted")}}',
                "{{__('validation.success')}}",
            )

            window.location.href = "/admin/" + deleteFunction + "/" + id;

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.cancelled')}}",
                '' + name + ' {{__("validation.your")}} {{__("validation.is_safe")}})',
                'error'
            )
        }
    })

  };

    // delete attribut 
    function deleteAttr(event) {
    var id = $(event).attr('rel');
    var deleteFunction = $(event).attr('rel1');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: "{{__('validation.are_you_sure')}}",
        text: "{{__('validation.you_want_to_delete_this_attribute')}}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{__('validation.yes_delete_it')}}",
        cancelButtonText: "{{__('validation.no_cancel')}}",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.deleted')}}",
                "{{__('validation.your_attribute_has_been_deleted')}}",
                "{{__('validation.success')}}"
            )

            window.location.href = "/admin/" + deleteFunction + "/" + id;

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.deleted')}}",
                "{{__('validation.your_attribute_is_safe')}} :)",
                'error'
            )
        }
    })

  }

    // delete product
    function deleteProdt(event) {

    var id = $(event).attr('rel');
    var name = $(event).attr('rel2');
    var link = $(event).attr('link');
    var deleteFunction = $(event).attr('rel1');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: "{{__('validation.are_you_sure')}}",
        text: '{{__("validation.you_want_to_delete_this")}} "' + name + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{__("validation.deleted")}} ' + name + '',
        cancelButtonText: "{{__('validation.no_cancel')}}",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.deleted')}}",
                '' + name +
                ' {{__("validation.your")}} {{__("validation.has_been_deleted")}} ',
                '{{__("validation.success")}} '
            )

            window.location.href = link + deleteFunction + id;

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.cancelled')}}",
                '{{__("validation.your")}} "' + name +
                '" {{__("validation.is_safe")}}  :)',
                'error'
            )
        }
    })

  }

    // delete Alternate Images
    function deleteAltImg(event) {

    var id = $(event).attr('rel'),link=$(event).attr('link'),deleteFunction = $(event).attr('rel1');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: "{{__('validation.are_you_sure')}}",
        text: "{{__('validation.you_want_to_delete_this_images')}}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "{{__('validation.yes_delete_it')}}",
        cancelButtonText: "{{__('validation.no_cancel')}}",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.deleted')}}",
                "{{__('validation.your_images_has_been_deleted')}}",
                "{{__('validation.success')}}",
            )

            window.location.href = link+deleteFunction+id;

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                "{{__('validation.cancelled')}}",
                "{{__('validation.your_images_is_safe')}}",
                'error'
            )
        }
    })

 }
   
  /*modal newsletter*/
  function modalNewsletter(resp) {
      var id = $(resp).data("id")
      $("#idnewsleter").val(id)
  }   
  /*delete newslatter email*/
  function deleteNewsletter() {
      var id = $("#idnewsleter").val()
      window.location.href ="/admin/delete-newslatter-emai/"+id;
  }   

    /*
        select
    */   
    function checkInputValue(e) {
        id = e.id
        $(".check_usergroup").prop('checked', false)
        $("#"+id).prop('checked', true)
    }


    function radioNetral() {
        $(".check_usergroup").prop('checked', false);
    }

    /* 
        load image function
    */ 
    function onLoadDiv() {
        var images = document.querySelectorAll('.lazy');

        for (var i = 0, nb = images.length; i < nb; i++) {
            var img = images[i]
            var rect = img.getBoundingClientRect();
            var isVisible = ((rect.top - window.innerHeight) < 500 && (rect.bottom) > -50) ? true : false;

            if (isVisible) {
                if (!img.termuat) {
                    img.src = '/images/gif/loading_card5.gif';
                }
            }
        }
    } 

    function onScrollDiv() {
        var images = document.querySelectorAll('.lazy');
        setTimeout(() => {
            for (var i = 0, nb = images.length; i < nb; i++) {
                var img = images[i]
                // console.log(images);
                var rect = img.getBoundingClientRect();
                var isVisible = ((rect.top - window.innerHeight) < 500 && (rect.bottom) > -50) ? true : false;

                if (isVisible) {
                    if (!img.termuat) {

                        img.src = img.dataset.src;
                        img.alt = img.dataset.alt;
                        img.termuat = true;

                    }
                }
            }
        }, 1700);
    } 

    /*
        end load
    */ 
    
    // tema
    function maronTema() {
        $(function() {
            $('body').attr('style','background: #7b0000; color: grey; font-family: Montserrat, Arial, sans-serif;')
            $('#header').attr('style','background-color: #7b0000; margin-top: 10px; height: 77px; position: relative; width: 100%; z-index: -9;')
            $('#sidebar > ul li ul').attr('style','background-color: firebrick')
            $('#sidebar > ul > li').attr('style','border-top: 1px solid #27a9e3; border-bottom: 1px solid #27a9e3;')
            $('#sidebar > ul > li > a').attr('style','padding: 10px 0 10px 15px; display: block; color: #ffffff;')
            $('.navbar-inverse .nav>li>a').attr('style','color: #fff; text-shadow: 0 -1px 0 rgba(0,0,0,0.25);')
            $('#user-nav > ul > li').attr('style','float: left; list-style-type: none; margin: 0; position: relative; padding: 0; border-left: 1px solid #27a9e3; border-right: 1px solid #27a9e3;')
            sessionStorage.setItem("tema_template", "maronTema");
        })
    }

    function defaultTema()
    {
        $(function() {
            $('body').attr('style','background: #2E363F; color: 666; font-family: Montserrat, Arial, sans-serif;')
            $('#header').attr('style','background-color: #1f262d; margin-top: 10px; height: 77px; position: relative; width: 100%; z-index: -9;')
            $('#sidebar > ul li ul').attr('style','background-color: #1e242b')
            $('#sidebar > ul > li').attr('style','border-top: 1px solid #37414b; border-bottom: 1px solid #1f262d;')
            $('#sidebar > ul > li > a').attr('style','padding: 10px 0 10px 15px; display: block; color: #939da8;')
            $('.navbar-inverse .nav>li>a').attr('style','color: #999; text-shadow: 0 -1px 0 rgba(0,0,0,0.25);')
            $('#user-nav > ul > li').attr('style','float: left; list-style-type: none; margin: 0; position: relative; padding: 0; border-left: 1px solid #2e363f; border-right: 1px solid #000;')
            sessionStorage.removeItem("tema_template");
        })
    }

</script>

