@extends('layouts.frontLayout.front_design')

@section('style')
<style>
img {
    max-width: 100%;
}

.inbox_people {
    background: #f8f8f8 none repeat scroll 0 0;
    float: left;
    overflow: hidden;
    width: 40%;
    border-right: 1px solid #c4c4c4;
}

.inbox_msg {
    border: 1px solid #c4c4c4;
    clear: both;
    overflow: hidden;
}

.top_spac {
    margin: 20px 0 0;
}

.recent_heading {
    float: left;
    width: 40%;
}

.srch_bar {
    display: inline-block;
    text-align: right;
    width: 60%;
    padding:
}

.headind_srch {
    padding: 10px 29px 10px 20px;
    overflow: hidden;
    border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
    color: #05728f;
    font-size: 21px;
    margin: auto;
}

.chat_ib h5 {
    font-size: 15px;
    color: #464646;
    margin: 0 0 8px 0;
}

.chat_ib h5 span {
    font-size: 13px;
    float: right;
}

.chat_ib p {
    font-size: 14px;
    color: #989898;
    margin: auto
}

.chat_img {
    float: left;
    width: 11%;
}

.chat_ib {
    float: left;
    padding: 0 0 0 15px;
    width: 88%;
}

.chat_people {
    overflow: hidden;
    clear: both;
}

.chat_list {
    border-bottom: 1px solid #c4c4c4;
    margin: 0;
    padding: 18px 16px 10px;
}

.inbox_chat {
    height: 550px;
    overflow-y: scroll;
}

.active_chat {
    background: #ebebeb;
}

.incoming_msg_img {
    display: inline-block;
    width: 6%;
}

.received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
}

.received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 8px 0 0;
}

.received_withd_msg {
    width: 57%;
}

.mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 60%;
}

.sent_msg p {
    background: #05728f none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0;
    color: #fff;
    padding: 5px 10px 5px 12px;
    width: 100%;
}

.outgoing_msg {
    overflow: hidden;
    margin: 26px 0 26px;
}

.sent_msg {
    float: right;
    width: 46%;
}

.image_message {
    border: none;
    position: relative;
    text-align: center;
    margin-top: 13px;
    background: white;
}

#write_msg {
    width: 91%;
    float: right;
}

.input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
}

.type_msg {
    border-top: 1px solid #c4c4c4;
    position: relative;
}

.msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
}

.messaging {
    padding: 0 0 50px 0;
}

.msg_history {
    height: 516px;
    overflow-y: auto;
}
</style>
@endsection

@section('content')

<section>
    <div class="container">
        <div id="app">
        </div>
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout.front_sidebar')
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">Message Admin Us</h2>
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
                        <div class="col-sm-12"> 
                         <!-- message -->
                            <div class="messaging">
                                <div class="inbox_msg">
                                    <div class="inbox_people">
                                        <div class="headind_srch">
                                            <div class="recent_heading">
                                                <h4>Admin Us.</h4>
                                            </div>
                                        </div>
                                        <div class="inbox_chat">
                                            @foreach($usersAll as $usr)
                                            <div class="chat_list user" id="{{$usr->id}}">
                                                <div class="chat_people">
                                                    <div class="chat_img"> <img src="{{$usr->avatar ?? asset('images/backend_images/userss.png') }}" alt="avatar"></div>
                                                    <div class="chat_ib">
                                                        <a href="javascript:">
                                                            <h5 id="msg-count-h{{$usr->id}}">{{$usr->name}}
                                                            @if($usr->unread != 0)<span class="badge badge-pill badge-info msg-count" style="background-color:cornflowerblue">{{$usr->unread}}</span> @endif
                                                            </h5>
                                                            <p>Admin E-commerce-hsn.</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mesgs" id="messages">
                                    <!-- html -->
                                    </div>
                                </div>                          
                            </div>
                         <!-- end message --> 
                        </div>
                    </div>
                    <!--All_items-->
                </div>
            </div>
        </div>
</section>

@endsection

@section('script')

@endsection