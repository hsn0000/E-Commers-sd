

<script>
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