@extends('layouts.frontLayout.front_design')
@section('content')

    @if(Session::has('signup_error'))
        <div class="alert alert-dark alert-block" style="background-color:Tomato; color:white; width:18%; margin-left:50%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('signup_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('signup_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:18%; margin-left:50%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('signup_success')}}</strong>
        </div>
    @endif
    @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block" style="background-color:red; color:white; width:21%; margin-left:24%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif  
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block" style="background-color:green; color:white; width:21%; margin-left:24%;">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
	@endif
	<div id="loading"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-sm-offset-1" id="photo-profile-front">
                   <a href="javascript:"> <img class="image-profile-front" src="{{ $userDetails->avatar != '' ? (asset('/images/photo/profile/'.$userDetails->avatar)) : (asset('/images/backend_images/userss.png')) }}" alt="photo pfrofile" onclick="popupGambar(this)"> </a>
            </div>
            <div class="col-sm-2">
                <div class="card text-white bg-success" style="width: 16rem;">
                    <ul class="list-group list-group-flush" style="font-size: smaller;">
                        @if(!empty($userDetails->name))
                        <li class="list-group-item-kita">{{$userDetails->name}}</li>
                        @endif
                        @if(!empty($userDetails->email))
                        <li class="list-group-item-kita">{{$userDetails->email}}</li>
                        @endif
                        @if(!empty($userDetails->mobile))
                        <li class="list-group-item-kita">{{$userDetails->mobile}}</li>
                        @endif
                    </ul>
                    <form id="form_add_update_photo_frofile" method="post" enctype="multipart/form-data">
                       <input type="file" class="hidden" name="input_image_profil_fron" id="input_image_profil_fron">
                       <input type="text" class="hidden" name="for_who_use" id="for_who_use" value="forusers">
                    </form>
                    <a href="javascript:" class="btn btn-warning btn-sm" onclick="addUpdatePhotoProfile()">Change</a>
                </div>
            </div>
            <div class="col-sm-1">
                <h2 class=""></h2>
            </div>
            <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Shipping Address</h5>
                    @if(!empty($userDetails->address))
                      <p class="card-text" style="font-size: smaller;">{{$userDetails->address.','.$userDetails->city.','.$userDetails->state.','.$userDetails->country.','.$userDetails->pincode}}.</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="form" style="margin:20px 0px 5% 0;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--account form-->
						<h2>Update your Account</h2>
						<form action="{{url('/account')}}" id="accountForm" name="accountForm" method="post"> {{csrf_field()}}
							<input type="text" name="name" placeholder="Name" value="{{$userDetails->name}}" />
                            <input type="text" name="address" placeholder="Address" value="{{$userDetails->address}}" />
							<input type="text" name="city" placeholder="City" value="{{$userDetails->city}}" />
                            <input type="text" name="state" placeholder="State" value="{{$userDetails->state}}" />
							<select style="padding:10px;" name="country" id="country">
                                <option value="" >Select Country</option>
                              @foreach($countries as $country)
                                <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif >{{$country->country_name}}</option>
                              @endforeach
                            </select>
                            <input style="margin-top:10px;" type="text" name="pincode" placeholder="Pincode" value="{{$userDetails->pincode}}" />
							<input type="text" name="mobile" placeholder="Mobile" value="{{$userDetails->mobile}}" />
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Your Password </h2>
					    <form action="{{url('/update-user-pwd')}}" id="passswordForm" name="passswordForm" method="post">{{csrf_field()}}
                          <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password">
                          <span id="chkPwd"></span>
                          <input type="password" name="new_pwd" id="new_pwd" placeholder="New Passsword">
                          <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
                          <button type="submit" class="btn btn-default">Update</button>
                        </form>
					</div>
			</div>
		</div>
	</section><!--/form-->

@endsection

@section('script');
<script>
$(document).ready(function () {

});

function addUpdatePhotoProfile() {
    $('#input_image_profil_fron').click()
    $('#input_image_profil_fron').bind('change', function(e) {
        e.preventDefault();
        var valueImg = $(this).val()

        if (valueImg != '') {
            /*valid extention*/    
            var extension = valueImg.split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1)
            {
                new PNotify({
                    title: 'Invalid',
                    text: 'invalid image file !',
                    type: 'error',
                });
                $('#input_image_profil_fron').val('');
                $('#input_image_profil_fron').unbind()
                return false;
            }
            /*end valid extention*/ 

        var form = document.forms.namedItem("form_add_update_photo_frofile"); // high importance!, here you need change "yourformname" with the name of your form
        var formData = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('uploadPhotoProfile')}}",
                dataType:'JSON',
                data:formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $("#photo-profile-front").html(" <a href='javascript:' > <img class='image-profile-front' src='/images/photo/profile/"+data[0].avatar+"' ' alt='photo pfrofile' onclick='popupGambar(this)'> </a> ")
                    new PNotify({
                        title: 'Success !',
                        text: 'profile photo has been changed',
                        type: 'success',
                        cornerclass: 'ui-pnotify-sharp'
                    });

                    $('#input_image_profil_fron').unbind()
                },
                error: function(jqXHR, status, err) {},
                complete: function() {
                   
                }
            })

        }
        
        $('#input_image_profil_fron').unbind()
    })
}
</script>
@endsection