@extends('layouts.adminLayout.admin_design')

@section('title')
profile role
@endsection

@section('link')

@endsection

@section('content')


<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i
                    class="icon-home"></i> Home</a>
            <a href="{{url('/admin/view-categories')}}" class="current">Wellcome User</a> </div>
        @if(Session::has('flash_message_error'))
        <div class="alert alert-dark alert-block"
            style="background-color:Tomato; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_error')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_drop'))
        <div class="alert alert-success alert-block"
            style="background-color:#F08080; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_drop')}}</strong>
        </div>
        @endif
        @if(Session::has('flash_message_success'))
        <div class="alert alert-dark alert-block"
            style="background-color:green; color:white; width:21%; margin-left:20px;">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{Session::get('flash_message_success')}}</strong>
        </div>
        @endif
    </div>
    <div id="loading"></div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Profile Role</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div class="container bootstrap snippet">
                            <hr>
                            <div class="row">
                                <div class="col-sm-10">
                                    <h1>{{$adminRole->username}}</h1>
                                </div>
                                <div class="col-sm-2">
                                  <a href="#" style="float:right"> <i class="icon icon-cog" ></i> Settings</a>
                                  <a href="#" style="float:right; margin-bottom:20%;" id="add-roles"> <i class="icon icon-plus" ></i> Add Role</a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <!--left col-->
                                    <div class="text-center">
                                        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                            class="avatar img-circle img-thumbnail" alt="avatar">
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" class="text-center center-block file-upload">
                                    </div>
                                    </hr><br>

                                </div>
                                <!--/col-3-->
                                <div class="col-sm-12">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                                        <li><a data-toggle="tab" href="#messages">Menu 1</a></li>
                                        <li><a data-toggle="tab" href="#settings">Menu 2</a></li>
                                    </ul>


                                    <div class="tab-content">
                                        <div class="tab-pane active" id="home">
                                            <hr>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="first_name">
                                                            <h4>First name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            id="first_name" placeholder="first name"
                                                            title="enter your first name if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group" style="float:rigth;">

                                                    <div class="col-xs-6">
                                                        <label for="last_name">
                                                            <h4>Last name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            id="last_name" placeholder="last name"
                                                            title="enter your last name if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="phone">
                                                            <h4>Phone</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="phone" id="phone"
                                                            placeholder="enter phone"
                                                            title="enter your phone number if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="mobile">
                                                            <h4>Mobile</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="mobile"
                                                            id="mobile" placeholder="enter mobile number"
                                                            title="enter your mobile number if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Email</h4>
                                                        </label>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="you@email.com" title="enter your email.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Location</h4>
                                                        </label>
                                                        <input type="email" class="form-control" id="location"
                                                            placeholder="somewhere" title="enter a location">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="password">
                                                            <h4>Password</h4>
                                                        </label>
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" placeholder="password"
                                                            title="enter your password.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="password2">
                                                            <h4>Verify</h4>
                                                        </label>
                                                        <input type="password" class="form-control" name="password2"
                                                            id="password2" placeholder="password2"
                                                            title="enter your password2.">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success" type="submit"><i
                                                                class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                                        <button class="btn btn-lg" type="reset"><i
                                                                class="glyphicon glyphicon-repeat"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <hr>

                                        </div>
                                        <!--/tab-pane-->
                                        <div class="tab-pane" id="messages">

                                            <h2></h2>

                                            <hr>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="first_name">
                                                            <h4>First name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            id="first_name" placeholder="first name"
                                                            title="enter your first name if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="last_name">
                                                            <h4>Last name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            id="last_name" placeholder="last name"
                                                            title="enter your last name if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="phone">
                                                            <h4>Phone</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="phone" id="phone"
                                                            placeholder="enter phone"
                                                            title="enter your phone number if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="mobile">
                                                            <h4>Mobile</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="mobile"
                                                            id="mobile" placeholder="enter mobile number"
                                                            title="enter your mobile number if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Email</h4>
                                                        </label>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="you@email.com" title="enter your email.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Location</h4>
                                                        </label>
                                                        <input type="email" class="form-control" id="location"
                                                            placeholder="somewhere" title="enter a location">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="password">
                                                            <h4>Password</h4>
                                                        </label>
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" placeholder="password"
                                                            title="enter your password.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="password2">
                                                            <h4>Verify</h4>
                                                        </label>
                                                        <input type="password" class="form-control" name="password2"
                                                            id="password2" placeholder="password2"
                                                            title="enter your password2.">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success" type="submit"><i
                                                                class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                                        <button class="btn btn-lg" type="reset"><i
                                                                class="glyphicon glyphicon-repeat"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <!--/tab-pane-->
                                        <div class="tab-pane" id="settings">


                                            <hr>
                                            <form class="form" action="##" method="post" id="registrationForm">
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="first_name">
                                                            <h4>First name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="first_name"
                                                            id="first_name" placeholder="first name"
                                                            title="enter your first name if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="last_name">
                                                            <h4>Last name</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            id="last_name" placeholder="last name"
                                                            title="enter your last name if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="phone">
                                                            <h4>Phone</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="phone" id="phone"
                                                            placeholder="enter phone"
                                                            title="enter your phone number if any.">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-xs-6">
                                                        <label for="mobile">
                                                            <h4>Mobile</h4>
                                                        </label>
                                                        <input type="text" class="form-control" name="mobile"
                                                            id="mobile" placeholder="enter mobile number"
                                                            title="enter your mobile number if any.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Email</h4>
                                                        </label>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="you@email.com" title="enter your email.">
                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <div class="col-xs-6">
                                                        <label for="email">
                                                            <h4>Location</h4>
                                                        </label>
                                                        <input type="email" class="form-control" id="location"
                                                            placeholder="somewhere" title="enter a location">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-xs-12">
                                                        <br>
                                                        <button class="btn btn-lg btn-success pull-right"
                                                            type="submit"><i class="glyphicon glyphicon-ok-sign"></i>
                                                            Save</button>
                                                        <!--<button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>-->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

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


@endsection

@section('script')

<script>
$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function() {
        readURL(this);
    });
});
</script>

@endsection