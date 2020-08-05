
@php 
 use App\Product;
 use Carbon\Carbon;
    $notifycationMsgCountAdm = Product::notifycationMsgCountAdm();
    $notifycationMsgAdm = Product::notifycationMsgAdm();
@endphp 

<!--Header-part-->
<div id="header">
  <h1><a href="{{url('/admin/dashboard')}}">{{__('backend.husin_e_comerce_admin')}}</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">{{__('backend.welcome')}} </span> <span style="color:white;">{{ (Session::get('adminSession')) }}</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="{{url('/profile-usr/admin/')}}"><i class="icon-user"></i> {{__('backend.my_profile')}}</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> {{__('backend.my_tasks')}}</a></li>
        <li class="divider"></li>
        <li><a class="logoutUser" href="javascript:"><i class="icon-key"></i> {{__('backend.log_out')}}</a></li>
      </ul>
    </li>

    <li class="dropdown" id="menu-notification-admin"><a href="#" data-toggle="dropdown" data-target="#menu-notification-admin" class="dropdown-toggle" id="{{'ntpCount'.Session::get('adminID') }}"><i class="icon icon-bell"></i> <span class="text">Notification</span> <span class="notiheader-admin"> @if($notifycationMsgCountAdm != 0)<span class="label label-important ntp_count_class">{{$notifycationMsgCountAdm}}</span> @endif </span> <b class="caret"></b></a>
    @if(count($notifycationMsgAdm) > 0)
      <ul class="dropdown-menu" id="ntp_header_messsage" style=" overflow-y: scroll; max-height: 17vw; height:auto;">
        @foreach($notifycationMsgAdm as $key => $notyMsg)
            <li class="list_ntp_header_messsage">
            @if($notyMsg->is_read == 0) <span class="badge badge-pill" style=" position: absolute; background: indianred; margin-left: 2px;">!</span> @else <span> </span> @endif
              <a href="javascript:" onclick='clickNotMsgAdm({{"' $notyMsg->from.$notyMsg->to '"}})'> &nbsp;&nbsp;&nbsp;&nbsp; <b>{{$notyMsg->title}}</b> <span> | {{$notyMsg->name}}</span> | <span style="font-size: small; font-style: italic;">{{Carbon::parse($notyMsg->created_at)->format('j F Y')}}</span> &nbsp;&nbsp;&nbsp;&nbsp;</a>
              <li class="divider list_ntp_header_messsage"></li>
            </li>
        @endforeach
      </ul>
    @endif
    </li>

    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text"> {{__('backend.messages')}}</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="{{url('/messages/admin/messages')}}"><i class="icon-plus"></i>  {{__('backend.new_message')}}</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> {{__('backend.inbox')}}</a></li> 
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> {{__('backend.outbox')}}</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> {{__('backend.trash')}}</a></li>
      </ul>
    </li>

    <li class="dropdown" id="menu-settings"><a href="#" data-toggle="dropdown" data-target="#menu-settings" class="dropdown-toggle"><i class="icon icon-cog"></i> <span class="text"> {{__('backend.settings')}}</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="{{url('/profile-usr/admin/settings')}}"><i class="icon icon-lock"></i>  {{__('backend.update_password')}}</a></li>
        <li class="divider"></li>
      </ul>
    </li>

    <li class="dropdown" id="menu-tema"><a href="#" data-toggle="dropdown" data-target="#menu-tema" class="dropdown-toggle"><i class="icon icon-bookmark"></i> <span class="text"> Tema</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="javascript:" onclick="defaultTema()"><i class="icon icon-pushpin"></i>  Default </a></li>
        <li class="divider"></li>
        <li><a class="sAdd" title="" href="javascript:" onclick="maronTema()"><i class="icon icon-pushpin"></i>  Maron </a></li>
      </ul>
    </li>

    <li class="dropdown" id="menu-language"><a href="#" data-toggle="dropdown" data-target="#menu-language" class="dropdown-toggle"><i class="icon icon-flag"></i> <span class="text"> {{__('backend.language')}}</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li> <a href="{{url('/language/id')}}" class="sAdd" ><i class="icon-flag"></i>Indonesia  </a></li>
        <li class="divider"></li>
        <li><a class="sAdd" title="" href="{{url('/language/en')}}"><i class="icon-flag"></i>English</a></li>
        <li class="divider"></li>
        <li><a class="sAdd" title="" href="{{url('/language/khmer')}}"><i class="icon-flag"></i>Kambodia</a></li>
      </ul>
    </li>
    <li class=""><a title="" class="logoutUser"  href="javascript:"><i class=" icon icon-share-alt"></i> <span class="text">{{__('backend.log_out')}}</span></a></li>
  </ul>
</div>

<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->