@php
use Carbon\Carbon;  
$msg_count = $messageUsers->count()
@endphp

<div class="chat-messages" id="chat-messages">
    @if($msg_count > 0 )
        @foreach($messageUsers as $msgUsr)
            @if(($msgUsr->from == $user_id) && ($msgUsr->to == $admin_id))
            <div id="chat-messages-inner">
                <p id="msg-1" class="" style="display: block;"><span class="msg-block"><img src="{{ $msgUsr->avatar != '' ? (asset('/images/photo/profile/'.$msgUsr->avatar)) : (asset('/images/backend_images/userss.png')) }}" alt="avatar">
                <strong>{{$msgUsr->name}}</strong> <span class="time">{{Carbon::parse($msgUsr->created_at)->format('l, j F Y | H:i A')}}</span>
                        <strong>You</strong> <span class="time">{{Carbon::parse($msgUsr->created_at)->format('l, j F Y | H:i A')}}</span>
                @if($msgUsr->message != "")
                <span class="msg">{{$msgUsr->message}}</span></span></p>
                @elseif($msgUsr->images != "")
                <div class="imgMessageClass" style="">
                <a href="javascript:"><img src="{{ asset('images/messages/image/'.$msgUsr->images)}}" alt="image-message" style="width: 124px;" onclick="popupGambar(this)"></a>
                </div> </span>
                </p>
                @endif
            </div>
            @else(($msgUsr->to == $admin_id ) && ($msgUsr->from == $user_id))
            <div id="chat-messages-inner">
                <p id="msg-1" class="" style="display: block;"><span class="msg-block" style="background: #eaeaea;">
                <strong>You</strong> <span class="time">{{Carbon::parse($msgUsr->created_at)->format('l, j F Y | H:i A')}}</span>
                @if($msgUsr->message != "")
                <span class="msg">{{$msgUsr->message}}</span></span></p>
                @elseif($msgUsr->images != "")
                <div class="imgMessageClass" style="">
                <a href="javascript:"><img src="{{ asset('images/messages/image/'.$msgUsr->images)}}" alt="image-message" style="width: 124px;" onclick="popupGambar(this)"></a>
                </div> </span>
                </p>
                @endif
            </div>
            @endif 
        @endforeach
    @else
    <div class="empty-content-msg">
        <span class="text-joined badge">{{Carbon::parse($user_detail->created_at)->format('j F, Y')}}</span> <br>
        <span class="text-conten badge">{{ $user_detail->name.' joined E-commerce hsn' }}</span>
    </div>
    @endif
</div>

<div class="chat-message well">
    <button style="float:left;" class="image_message_adm" onclick="imageMessageAdm()"><i class="icon-picture" ></i></button>
    <button class="btn btn-success" onclick="sendMsgAdm()">Send</button>
    <span class="input-box">
        <input type="text" name="msg-box" class="input-texts" id="msg-box">
    </span>
</div>

<form id="upload_img_adm" method="post" enctype="multipart/form-data"> 
    <input type="file" class="hidden" name="input_image_adm" id="input_image_adm">
    <input type="text" class="hidden" name="receiver_id_adm" id="receiver_id_adm" >
</form>


         
