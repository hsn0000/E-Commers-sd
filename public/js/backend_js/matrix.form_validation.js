
// settings validation
$(document).ready(function(){

    // logout
	$(".logoutUser").click(function() 
	{
		Swal.fire({
		title: 'Are you sure?',
		text: "You want to logout this page !",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, logout it!'
		}).then((result) => {
		if (result.value) {
			Swal.fire(
			'Logout Page!',
			'Your has been logout this page.',
			'success'
			)
			window.location.href="/logout"
		}
	  })

	});

	// password lama
	$("#current_pwd").keyup(function() {
		 var current_pwd = $("#current_pwd").val();
		 $.ajax({
			 type:'get',
			 url:'/admin/check-pwd',
			 data:{current_pwd:current_pwd},
			 success:function(resp) {
				//  alert(resp);
				if(resp == "false") {
					$("#chkPwd").html("<font color='red'>Current Password is Incorrect </font>");
				}else if (resp=="true"){
                    $("#chkPwd").html("<font color='green'>Current Password is Correct </font>");
				}
			 },error:function() {
				 alert("Error");
			 }
		 });
	});
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
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

	// Add category Validation
    $("#add_category").validate({
		rules:{
			required:{
				required:true
			},
			category_name:{
				required:true,
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
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

		// edit category Validation
	$("#edit_category").validate({
		rules:{
			required:{
				required:true
			},
			category_name:{
				required:true,
			},
			description:{
				required:true,
			},
			url:{
				required:true,
			}
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
	
	// Add product Validation
	$("#add_product").validate({
		rules:{
			required:{
				required:true
			},
			category_id:{
				required:true,
			},
			product_name:{
				required:true,
			},
			product_code:{
				required:true,
			},
			product_color:{
				required:true,
			},
			price:{
				required:true,
				number:true
			},
			image:{
				required:true,
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

	// Edit product Validation
	$("#edit_product").validate({
		rules:{
			required:{
				required:true
			},
			category_id:{
				required:true,
			},
			product_name:{
				required:true,
			},
			product_code:{
				required:true,
			},
			product_color:{
				required:true,
			},
			price:{
				required:true,
				number:true
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

//
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
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
	
	// password validate admin
	$("#password_validate").validate({
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

//   delete category
	$(".delCat").click(function() 
	{
		var id = $(this).attr('rel');
		var name = $(this).attr('rel2');
		var deleteFunction = $(this).attr('rel1');

		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		})
		
		swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: 'you want to delete this  "'+name+'"?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it',
			cancelButtonText: 'No, cancel',
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
			swalWithBootstrapButtons.fire(
				'Deleted!',
				'Your "'+name+'" has been deleted.',
				'success'
			)

			window.location.href="/admin/"+deleteFunction+"/"+id;
			
			} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
			) {
			swalWithBootstrapButtons.fire(
				'Cancelled',
				'Your '+name+' is safe :)',
				'error'
			)
		  }
	   })

	});

   // Add atribute 
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><div class="control-group"><label class="control-label"></label><input type="text" name="sku[]" id="sku" value="" placeholder="SKU" style="width:130px; margin:7px 0;" required/><input type="text" name="size[]" id="size" value="" placeholder="Size" style="width:130px; margin:7px 3px;" required/><input type="text" name="price[]" id="price" value="" placeholder="Price" style="width:130px; margin:7px 0;" required/><input type="text" name="stock[]" id="stock" value="" placeholder="Stock" style="width:130px; margin:7px 3px;" required/><a href="javascript:void(0);" class="remove_button"><i class="icon-minus" style="margin: 0 0 0 10px;"></i></a></div></div></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	
	//Once add button is clicked
	$(addButton).click(function()
	{
		//Check maximum number of input fields
		if(x < maxField){ 
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); //Add field html
		}
	});	
	//Once remove button is clicked
	$(wrapper).on('click', '.remove_button', function(e){
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});


		// delete attribut 
		$(".del-attribute").click(function(e) 
		{
			var id = $(this).attr('rel');
			var deleteFunction = $(this).attr('rel1');

			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
				  confirmButton: 'btn btn-success',
				  cancelButton: 'btn btn-danger'
				},
				buttonsStyling: false
			  })
			  
			  swalWithBootstrapButtons.fire({
				title: 'Are you sure?',
				text: "you want to delete this attribute?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it',
				cancelButtonText: 'No, cancel',
				reverseButtons: true
			  }).then((result) => {
				if (result.value) {
				  swalWithBootstrapButtons.fire(
					'Deleted!',
					'Your Attribute has been deleted.',
					'success'
				  )
	
				  window.location.href="/admin/"+deleteFunction+"/"+id;
				  
				} else if (
				  /* Read more about handling dismissals below */
				  result.dismiss === Swal.DismissReason.cancel
				) {
				  swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your attribute is safe :)',
					'error'
				  )
				}
			 })
	
		});


	// delete product
	$(".deleteProd").click(function(e) 
	{
		var id = $(this).attr('rel');
		var name = $(this).attr('rel2');
		var deleteFunction = $(this).attr('rel1');
		// alert(name);
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
			  confirmButton: 'btn btn-success',
			  cancelButton: 'btn btn-danger'
			},
			buttonsStyling: false
		  })
		  
		  swalWithBootstrapButtons.fire({
			title: 'Are you sure?',
			text: 'you want to delete this "'+name+'"?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete '+name+'',
			cancelButtonText: 'No, cancel',
			reverseButtons: true
		  }).then((result) => {
			if (result.value) {
			  swalWithBootstrapButtons.fire(
				'Deleted!',
				'Your '+name+' has been deleted.',
				'success'
			  )

			  window.location.href="/admin/"+deleteFunction+"/"+id;
			  
			} else if (
			  /* Read more about handling dismissals below */
			  result.dismiss === Swal.DismissReason.cancel
			) {
			  swalWithBootstrapButtons.fire(
				'Cancelled',
				'Your "'+name+'" is safe :)',
				'error'
			  )
			}
		 })

	});


		// delete Alternate Images
		$(".del-alt-img ").click(function(e) 
		{
			var id = $(this).attr('rel');
			var deleteFunction = $(this).attr('rel1');

			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
				  confirmButton: 'btn btn-success',
				  cancelButton: 'btn btn-danger'
				},
				buttonsStyling: false
			  })
			  
			  swalWithBootstrapButtons.fire({
				title: 'Are you sure?',
				text: "you want to delete this Images?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it',
				cancelButtonText: 'No, cancel',
				reverseButtons: true
			  }).then((result) => {
				if (result.value) {
				  swalWithBootstrapButtons.fire(
					'Deleted!',
					'Your Images has been deleted.',
					'success'
				  )
	
				  window.location.href="/admin/"+deleteFunction+"/"+id;
				  
				} else if (
				  /* Read more about handling dismissals below */
				  result.dismiss === Swal.DismissReason.cancel
				) {
				  swalWithBootstrapButtons.fire(
					'Cancelled',
					'Your Images is safe :)',
					'error'
				  )
				}
			 })
	
		});



});
