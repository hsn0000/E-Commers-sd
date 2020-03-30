<!-- *** -->
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


</script>