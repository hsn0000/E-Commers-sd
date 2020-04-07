/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});


$(document).ready(function () { 
	// var isNumberScript = "<php echo is_number ?>"
	// console.log(isNumberScript)

// Replace main image with alternate image
   $(".changeImage").click(function () {
	  var image = $(this).attr('src');
      $(".mainImage").attr("src",image);

   });


// Instantiate EasyZoom instances
	var $easyzoom = $('.easyzoom').easyZoom();
	// Setup thumbnails example
	var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

	$('.thumbnails').on('click', 'a', function(e) {
		var $this = $(this);
		e.preventDefault();
		// Use EasyZoom's `swap` method
		api1.swap($this.data('standard'), $this.attr('href'));
	});
	// Setup toggles example
	var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

	$('.toggle').on('click', function() {
		var $this = $(this);

		if ($this.data("active") === true) {
			$this.text("Switch on").data("active", false);
			api2.teardown();
		} else {
			$this.text("Switch off").data("active", true);
			api2._init();
		}
	});


 // animate loading
 // var loading = document.getElementById('loading');
	window.addEventListener('load', function () {
	
		$("#loading").delay(1100).fadeOut("slow");
		// loading.style.display="none";
	});


 // validate register form on keyup and submit
	$("#registerForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+",
			},
			password:{
				required: true,
				minlength: 6, 
			},
			email:{
				required:true,
				email:true,
				remote:"/check-email",
			},
		},
		messages:{
			name:{
				required:"Please enter your name",
				minlength:"Your name must be atleast 2 characters long",
				accept:"Your name must contain only letters",	
			},
			password:{
				required:"Please provide your password",
				minlength:"Your password must be atleast 6 characters long",
			},
			email:{
				required: "Please enter your email",
				email: "Please enter valid Email",
				remote: "Email Already Exist !"
			}
		}
		
	});

 // password strength script register user
	$(document).ready(function($) {
		$('#myPassword').passtrength({
			minChars: 6,
			passwordToggle: true,
			tooltip: true,
			eyeImg:"/images/frontend_images/eye.svg"
		});
	});


 // validate login form on keyup and submit
	$("#loginForm").validate({
		rules:{
			password:{
				required: true,
			},
			email:{
				required:true,
				email:true,
			},
		},
		messages:{
			password:{
				required:"Please provide your password",
				minlength:"Your password must be atleast 6 characters long",
			},
			email:{
				required: "Please enter your email",
			}
		}
		
	});


 // validate acount form update on keyup and submit user
	$("#accountForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+",
			},
			address:{
				required: true,
				minlength:10,
			},
			city:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+",
			},
			state:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+",
			},
			country:{
				required:true,
			},
			pincode:{
				required:true,
			},
			mobile:{
				required:true,
				accept:"[0-9]+",
			},
			
		},
		messages:{
			name:{
				required:"Please enter your Name",
				minlength:"Your name must be atleast 2 characters long",
				accept:"Your name must contain only letters",	
			},
			address:{
				required:"Please enter your Address",
				minlength:"Your name must be atleast 10 characters long",
			},
			city:{
				required:"Please enter your City",
				minlength:"Your name must be atleast 2 characters long",
				accept:"Your name must contain only letters",	
			},
			state:{
				required:"Please enter your State",
				minlength:"Your name must be atleast 2 characters long",
				accept:"Your name must contain only letters",	
			},
			country:{
				required:"Please select your Country",
			},
			pincode:{
				required:"Please enter your Pincode",
			},
			mobile:{
				required:"Please enter your Mobile",
				accept:"Your mobile must contain only number",	
			},
		}
		
	});


 // check current password user
	$("#current_pwd").keyup(function() {
		var current_pwd = $(this).val();
		
		$.ajax({
		   type:'POST',
		   url:'/check-user-pwd',
		   data:{
			   current_pwd:current_pwd,
			   "_token": $('meta[name="csrf-token"]').attr('content')
		},
		   dataType: "JSON", 
		   success:function(resp){
			   if(!resp)
			   {
				   $("#chkPwd").html("<span style='color:red'>Current Password Is Correct</span>")
			   }else if(resp) 
			   {
				   $("#chkPwd").html("<span style='color:green'>Current Password Is Correct</span>")
			   }
		   },error:function(err){
               alert("error");
		   }
		});
	}); 


 // validate password acount user form update on keyup and submit
	$("#passswordForm").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		messages:{
			current_pwd:{
				required:"Please enter your current password",
				minlength:"Your name must be atleast 6 characters long",
			},
			new_pwd:{
				required:"Please enter your new password",
				minlength:"Your password must be atleast 6 characters long",
			},
			confirm_pwd:{
				required:"Please enter confirm your password",
				minlength:"Your password must be atleast 6 characters long",
				equalTo:"Please enter the same password",
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	
	// billing address to shipping address script Checkout user\
	$("#billtoship").click(function() {
       if(this.checked){
		  $("#shipping_name").val($("#billing_name").val())
		  $("#shipping_address").val($("#billing_address").val())
		  $("#shipping_city").val($("#billing_city").val())
		  $("#shipping_state").val($("#billing_state").val())
		  $("#shipping_country").val($("#billing_country").val())
		  $("#shipping_pincode").val($("#billing_pincode").val())
		  $("#shipping_mobile").val($("#billing_mobile").val())
	   
		}else{
			$("#shipping_name").val('');
			$("#shipping_address").val('');
			$("#shipping_city").val('');
			$("#shipping_state").val('');
			$("#shipping_country").val('');
			$("#shipping_pincode").val('');
			$("#shipping_mobile").val('');
		}
	});

	

});


function selectPaymentMethod()
{
	if($("#Paypal").is(':checked') || $("#COD").is(':checked')) {
		// alert('check')
	}else{
		// alert("Please Select Payment Method")
	}
}








