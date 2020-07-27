@extends('layouts.adminLayout.admin_design')

@section('title')
Profile Role | Admin Hsn E-commerce
@endsection

@section('link')

@endsection

@section('content')

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{$module->permalink}}" class="current">Wellcome User</a> </div>

    </div>
    <div class="container-fluid">
    <form id="from_change_img_profile_adm" method="post" enctype="multipart/form-data" style="display: none;"> {{ csrf_field() }}
        <input type="file" class="" name="input_image_profile_adm" id="input_image_profile_adm">
        <input type="text" class="" name="for_who_use" id="for_who_use" value="foradmin" >
    </form>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="responsif-costume">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>Profile Role</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="container bootstrap snippet">
                                <hr>
                                <div class="row">
                                    <div class="col-sm-2">
                                    <!-- <a href="#" style="float:right"> <i class="icon icon-cog" ></i> Settings</a> -->
                                    <a href="{{url($module->permalink.'/settings')}}" style="float: right;" id="add-roles"> <i class="icon icon-lock" ></i> Update Password </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!--left col-->
                                        <div class="text-center">
                                            <div id="photo-profile-admin">
                                            <a href="javascript:"> <img width="190" src="{{ $adminRole->avatar != '' ? (asset('/images/photo/profile/'.$adminRole->avatar)) : (asset('/images/backend_images/admin1.jpg')) }}" class="avatar img-circle img-thumbnail" alt="avatar" onclick="popupGambar(this)"> </a>
                                            </div>
                                            <h6>Change different photo.</h6>
                                            <button class="btn btn-dark btn-sm" onclick="changePhotoProfileAdmin()">Change</button>
                                        </div>
                                        </hr><br>
                                    </div>
                                    <!--/col-3-->
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                                            <li><a data-toggle="tab" href="#hallo">Hello</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="home">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="first_name">
                                                                <h4>Username</h4>
                                                            </label>
                                                            <input type="text" value="{{$adminRole->name}}" class="form-control" title="Username." readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="email">
                                                                <h4>Email</h4>
                                                            </label>
                                                            <input type="text" value="{{$adminRole->email}}" class="form-control" title="Email." readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="phone">
                                                                <h4>Mobile</h4>
                                                            </label>
                                                            <input type="text" value="{{$adminRole->mobile}}" class="form-control" title="phone number." readonly>
                                                        </div>
                                                    </div>
                                                <hr>
                                            </div>
                                            <!--/tab-pane-->
                                            <div class="tab-pane" id="hallo">
                                                <h2></h2>
                                                <form class="form" action="##" method="post" id="r">
                                                    <div class="form-group">
                                                        <div class="col-xs-6">
                                                            <label for="first_name">
                                                                <h4>Hallo</h4>
                                                            </label>
                                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat deleniti odio nihil illum soluta rem quisquam, ratione error harum enim, quis ullam voluptates vero quae incidunt maxime? Ipsa, voluptate illo!</p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--/tab-pane-->

                                        </div>
                                        <!--/tab-pane-->
                                    </div>
                                    <!--/tab-content-->
                                </div>
                                <!--/col-9-->
                            </div>
                            <!--/row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
$(document).ready(function() {

});

   /*image change*/ 
   function changePhotoProfileAdmin() {
        $('#input_image_profile_adm').click()
        $('#input_image_profile_adm').bind('change', function(e) {
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
                    $('#input_image_profile_adm').val('');
                    $('#input_image_profile_adm').unbind()
                    return false;
                }
                /*end valid extention*/ 

            var form = document.forms.namedItem("from_change_img_profile_adm"); // high importance!, here you need change "yourformname" with the name of your form
            var formData = new FormData(form);

                $.ajax({
                    type: "post",
                    url: "{{ route('uploadPhotoProfile')}}",
                    dataType:'JSON',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#photo-profile-admin").html(" <a href='javascript:' > <img width='190' src='/images/photo/profile/"+data[0].avatar+"' class='avatar img-circle img-thumbnail' alt='photo pfrofile' onclick='popupGambar(this)'> </a> ")
                        new PNotify({
                            title: 'Success !',
                            text: 'profile photo has been changed',
                            type: 'success',
                            cornerclass: 'ui-pnotify-sharp'
                        });

                        $('#input_image_profile_adm').unbind()
                    },
                    error: function(jqXHR, status, err) {},
                    complete: function() {
                    
                    }
                })

            }
            
            $('#input_image_profile_adm').unbind()
        })

    } 
    /*end imgchange*/ 


</script>

@endsection