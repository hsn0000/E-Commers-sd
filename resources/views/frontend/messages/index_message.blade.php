@php
use Carbon\Carbon;
@endphp 
<div class="msg_history">
    @foreach($messageUsers as $msgUsr)

    @if(($msgUsr->from == $user_id) && ($msgUsr->to == $my_id))
    <div class="incoming_msg">
        <div class="incoming_msg_img"> <img src="{{ $msgUsr->avatar != '' ? (asset('/images/photo/profile/'.$msgUsr->avatar)) : (asset('/images/backend_images/admin1.jpg')) }}" alt="profile" > </div>
        <div class="received_msg">
            <div class="received_withd_msg">
                @if($msgUsr->message != "")
                <p>{{$msgUsr->message}}</p>
                @elseif($msgUsr->images != "")
                <a href="javascript:"><img src="{{ asset('images/messages/image/'.$msgUsr->images)}}" alt="image-message" style="width: 72%;" onclick="popupGambar(this)"></a>
                @endif
                <span class="time_date"> {{Carbon::parse($msgUsr->created_at)->format('l, j F Y | H:i A')}}</span>
            </div>
        </div>
    </div>
    @else(($msgUsr->from == $my_id) && ($msgUsr->to == $user_id))
    <div class="outgoing_msg">
        <div class="sent_msg">
            @if($msgUsr->message != "")
            <p>{{$msgUsr->message}}</p>
            @elseif($msgUsr->images != "")
            <a href="javascript:"><img src="{{ asset('images/messages/image/'.$msgUsr->images)}}" alt="image-message" style="padding-right: 17%;" onclick="popupGambar(this)"></a>
            @endif
            <span class="time_date">{{Carbon::parse($msgUsr->created_at)->format('l, j F Y | H:i A')}}</span>
        </div>
    </div>
    @endif

@endforeach
</div>
<div class="type_msg">
    <div class="input_msg_write">
    <form id="upload_img_front" method="post" enctype="multipart/form-data">
            <input type="file" class="hidden" name="input_image" id="input_image">
            <input type="text" class="hidden" name="receiver_id_fron" id="receiver_id_fron" >
    </form>
            <button class="image_message" onclick="imageMessage()"><i class="fa fa-picture-o" aria-hidden="true"></i></button>
            <input type="text" class="write_msg" id="write_msg" placeholder="Type a message" />
            <button class="msg_send_btn" type="button" onclick="sendMsgFront()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </div> 
</div>
</div>