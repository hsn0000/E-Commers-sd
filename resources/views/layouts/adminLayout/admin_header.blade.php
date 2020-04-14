
<!--Header-part-->
<div id="header">
  <h1><a href="{{url('/admin/dashboard')}}">{{__('backend.husin_e_comerce_admin')}}</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">{{__('backend.welcome')}}  {{ (Session::get('adminDetails'))['username'] }}</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="{{url('/admin/profile-role')}}"><i class="icon-user"></i> {{__('backend.my_profile')}}</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> {{__('backend.my_tasks')}}</a></li>
        <li class="divider"></li>
        <li><a class="logoutUser" href="javascript:"><i class="icon-key"></i> {{__('backend.log_out')}}</a></li>
      </ul>
    </li>
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text"> {{__('backend.messages')}}</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i>  {{__('backend.new_message')}}</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> {{__('backend.inbox')}}</a></li> 
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> {{__('backend.outbox')}}</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> {{__('backend.trash')}}</a></li>
      </ul>
    </li>
    <li class="dropdown" id="menu-settings"><a href="#" data-toggle="dropdown" data-target="#menu-settings" class="dropdown-toggle"><i class="icon icon-cog"></i> <span class="text"> {{__('backend.settings')}}</span> <span class="label label-important">1</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="{{url('/admin/settings')}}"><i class="icon icon-lock"></i>  {{__('backend.update_password')}}</a></li>
        <li class="divider"></li>
      </ul>
    </li>
    <li class="dropdown" id="menu-language"><a href="#" data-toggle="dropdown" data-target="#menu-language" class="dropdown-toggle"><i class="icon icon-flag"></i> <span class="text"> {{__('backend.language')}}</span> <span class="label label-important">3</span> <b class="caret"></b></a>
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