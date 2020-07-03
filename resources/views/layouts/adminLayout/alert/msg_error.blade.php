<div id="gritter-item-1" class="gritter-item-wrapper" style="position: fixed;z-index: 500;float: right; right: 14px; top: 55px;">
    <a href="javascript:" class="closeToast"> <span style="background-color: black; float: right; width: 23px; text-align: center; color: white;"> x </span> </a>
    <div class="gritter-top">
    </div>
    <div class="gritter-item" style="background: orangered;">
        <div class="gritter-close" style="display: none;">
        </div><img src="{{url('images/fail.jpg')}}" class="gritter-image" style="width: 52px; height: 50px; padding-right: 9px;">
        <div class="gritter-with-image">
            <span class="gritter-title"> <b> Error ! </b></span>
            <p><b> {{Session::get('msg_error')}} </b></p>
        </div>
        <div style="clear:both">
        </div>
    </div>
    <div class="gritter-bottom">
    </div>
</div>