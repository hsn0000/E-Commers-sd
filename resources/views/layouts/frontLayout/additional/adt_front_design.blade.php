<!-- frontend -->
<script>
    $(document).ready(function() {

        // Change Price & stock with Size
        $("#selSize").change(function () {
            var idSize = $(this).val();
            if(idSize == "")
            {
                return false;
            }
            $.ajax({
                type:'post',
                url:'/get-product-price',
                data:{idSize:idSize},
                success:function (resp) {
                    var arr = resp.split('#');
                    // var arr1 = arr[0][0]
                    var arr2 = arr[0].split('-')
                    var arr3 = arr2[0]
                    // console.log(arr2,arr3,arr2[1])
                    var stylout = "color:red; font-weight:bold;"
                    var stylin = "color:green; font-weight:bold;"
                    var currencyLoc = <?php echo json_encode(Session::get('currencyLocale')); ?>;
                    var currencySimbol = currencyLoc.currency_simbol
                    // console.log(currencyLoc, currencySimbol)
                    $("#getPrice").html(currencySimbol+' '+arr3);
                    $("#price").val(arr2[1]);
                    if(arr[0]==0)
                    {
                        $("#cartButton").hide();
                        $("#Availability").attr("style",stylout);
                        $("#Availability").text("Out OF Stock");
                    }else{
                        $("#cartButton").show();
                        $("#Availability").attr("style",stylin);
                        $("#Availability").text("In Stock");
                    }
                    // alert(resp);
                },error:function (err) {
                    alert("Error");
                }
                
            });

        });


    })
</script>


<script>
    /* overlay zoom image */ 
    var $overlay = $('<div id="overlay"></div>');
    var $image = $("<img>");
    var $caption = $("<p></p>");
    /* add the elements onto each other */
    $overlay.append($image);
    $overlay.append($caption);
    $("body").append($overlay);
    /* click event */
    function popupGambar(event) {
        var imageLocation = event["src"];
        $image.attr("src", imageLocation);
        var captionText = event["alt"];
        $caption.text(captionText);
        $overlay.show(); 
    };
    /* click event */
    $overlay.click(function() {
        $overlay.hide();
    }); 

        /* pincode check*/
    function checkPincode() {

        var pincode = $('#chkPincode').val()
        
        if(pincode == "") {
            var notEmpty  = "<span class='badge' style='background: darkorange; margin-left: 59px;'>Please Enter Pincode</span>";
            $("#chkPincode").attr("class", "is-invalid")
            $("#pincodeResponse").html(notEmpty)
        }

        if(pincode) {
            $.ajax({
                type:"post",
                data: {
                    pincode:pincode,
                },
                url:"/check-pincode",
                success:function(resp) {
                    var notAvailables  = "<span class='badge' style='background: firebrick; margin-left: 59px;'>This pincode is not available for delivery</span>";
                    var availables  = "<span class='badge' style='background: green; margin-left: 59px;'>This pincode is available for delivery</span>";
                    if(resp == true) {
                        $("#chkPincode").attr("class", "valid")
                        $("#pincodeResponse").html(availables)
                    } else if ( resp == false) {
                        $("#pincodeResponse").html(notAvailables)
                    }
                },error:function(e) {
                    alert('error')
                }
            })
        }

    }

    function checkSubscriber() {
        var subscriber_email = $("#subscriber_email").val()
		   $.ajax({
               type: "post",
               url: '/check-subscriber-email',
               data: {
                   subscriber_email: subscriber_email
               },
               success:function(resp) {
                   if(resp=="exists1") {
                       $("#modalkitabersama").click()
                       $(".modal-title").text("Email exists !")
                       $(".modal-body").text("Subscriber email already exists !")
                       $(".modal-content").attr('style',"background-color: orangered; color: white; border-color: white;");
                       $(".modal-footer").hide()
                       $("#statusSubscribe").show()
                       $("#statusSubscribe").attr('style',"color: red; margin-top: 14px;")
                       $("#statusSubscribe").text("Error : Subscriber email already exists !")
                       $("#btnSubmit").hide()
                   }
                    //    $("#modalkitabersama").click()
                    // alert(resp)
               },error:function(err) {
                   alert("error")
               }
           })
    }


    function enableSubscriber() {
        $("#btnSubmit").show()
        $("#statusSubscribe").hide()
    }
       
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
   })

</script>
