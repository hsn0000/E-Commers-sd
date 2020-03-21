@extends('layouts.frontLayout.front_design')

@section('content')

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout.front_sidebar')
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">Contact Us</h2>
                    @if(Session::has('flash_message_error'))
                    <div class="alert alert-dark alert-block" style="background-color: teal;width: 66%; color: white;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong> {{Session::get('flash_message_error')}}</strong>
                    </div>
                    @endif
                    @if(Session::has('flash_message_drop'))
                    <div class="alert alert-success alert-block"
                        style="background-color: teal;width: 66%; color: white;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong> {{Session::get('flash_message_drop')}}</strong>
                    </div>
                    @endif
                    @if(Session::has('flash_message_success'))
                    <div class="alert alert-dark alert-block" style="background-color: teal;width: 66%; color: white;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong> {{Session::get('flash_message_success')}}</strong>
                    </div>
                    @endif
                    <div id="loading"></div> 
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="contact-form">
                                <h2 class="title text-center">Get In Touch</h2>
                                <div class="status alert alert-success" style="display: none"></div>
                                <form id="main-contact-form" class="contact-form row" name="contact-form" method="post"
                                    action="{{url('/pages/contact')}}"> {{csrf_field()}}
                                    <div class="form-group col-md-6">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: orangered;"> Name cannot be empty ! </strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: orangered;"> Email cannot be empty ! </strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{old('subject')}}" placeholder="Subject">
                                        @error('subject')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: orangered;"> Subject cannot be empty ! </strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="8"  value="{{old('message')}}" placeholder="Your Message Here"></textarea>
                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: orangered;"> Message cannot be empty ! </strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="submit" name="submit" class="btn btn-primary pull-right"
                                            value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="contact-info">
                                <h2 class="title text-center">Contact Info</h2>
                                <address>
                                    <p>E-Commerc Inc.</p>
                                    <p> Gadog km 95, as far as the eye can see. Megamendung, Bogor, Postal code 16770
                                    </p>
                                    <p>Jawa Barat, Indonesia</p>
                                    <p>Mobile: +62821 1154 4414 </p>
                                    <p>Fax: 1-714-252-4414</p>
                                    <p>Email: info@e-commers.co.id</p>
                                </address>
                                <div class="social-networks">
                                    <h2 class="title text-center">Social Networking</h2>
                                    <ul>
                                        <li>
                                            <a href="javascript:"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                        <li>
                                            <a href="javascript:"><i class="fa fa-youtube"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--All_items-->
            </div>
        </div>
    </div>
</section>

@endsection