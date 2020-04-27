<?php $url = url()->current(); ?>


<!--sidebar-menu-->
<div id="sidebar"><a href="{{url('/admin/dashboard')}}" class="visible-phone"><i class="icon icon-home"></i>{{__('backend.dashboard')}}</a>
  <ul>
<li <?php if(preg_match("/dashboard/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>{{__('backend.dashboard')}}</span></a> </li>
   @if(Session::get('adminDetails')['categories_full_access'] == 1)
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>{{__('backend.categories')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/categories/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-categories'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-categories')}}">{{__('backend.add_category')}}</a></li>
        <li <?php if(preg_match("/view-categories/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-categories')}}">{{__('backend.view_category')}}</a></li>
      </ul>
    </li>
    @elseif(Session::get('adminDetails')['categories_edit_access'] == 1 || Session::get('adminDetails')['categories_view_access'] == 1)
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>{{__('backend.categories')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/categories/i", $url)) { ?> class="display: block;" <?php } ?>>
      @if(Session::get('adminDetails')['categories_edit_access'] == 1)
        <li <?php if(preg_match("/add-categories'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-categories')}}">{{__('backend.add_category')}}</a></li>
        @endif
        @if(Session::get('adminDetails')['categories_view_access'] == 1)
        <li <?php if(preg_match("/view-categories/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-categories')}}">{{__('backend.view_category')}}</a></li>
        @endif
      </ul>
    </li>
    @endif

    @if(Session::get('adminDetails')['products_access'] == 1)
    <li class="submenu"> <a href="#" id=""><i class="icon icon-book"></i> <span>{{__('backend.products')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/product/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-product'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-product')}}">{{__('backend.add_product')}}</a></li>
        <li <?php if(preg_match("/view-product'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-product')}}">{{__('backend.view_product')}}</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['type'] == "Admin")
    <li class="submenu"> <a href="#" id=""><i class="icon icon-qrcode"></i> <span>{{__('backend.coupons')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/coupon/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-coupon'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/add-coupon')}}">{{__('backend.add_coupon')}}</a></li>
        <li <?php if(preg_match("/view-coupon'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-coupon')}}">{{__('backend.view_coupon')}}</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['order_access'] == 1)
    <li class="submenu"> <a href="#" id=""><i class="icon icon-shopping-cart"></i> <span>{{__('backend.orders')}}</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/orders/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/view-orders'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-orders')}}">{{__('backend.view_orders')}}</a></li>
        <li <?php if(preg_match("/charts'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-orders-charts')}}">view orders charts</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['type'] == "Admin")
    <li class="submenu"> <a href="#" id=""><i class="icon icon-picture"></i> <span>{{__('backend.banners')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/banner/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-banner'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-banner')}}">{{__('backend.add_banner')}}</a></li>
        <li <?php if(preg_match("/view-banner'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-banner')}}">{{__('backend.view_banner')}}</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-film"></i> <span>{{__('backend.billboards')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/billboard/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-billboard'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-billboard')}}">{{__('backend.add_billboard')}}</a></li>
      <li <?php if(preg_match("/view-billboard'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-billboard')}}">{{__('backend.view_billboard')}}</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['users_access'] == 1)
    <li class="submenu"> <a href="#" id=""><i class="icon icon-user"></i> <span>{{__('backend.users')}}</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/users/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/view-users'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-users')}}">{{__('backend.view_users')}}</a></li>
        <li <?php if(preg_match("/charts'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-users-charts')}}">view users charts</a></li>
        <li <?php if(preg_match("/counties'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-users-countries-charts')}}">view users counties charts</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['type'] == "Admin")
    <li class="submenu"> <a href="#" id=""><i class="icon icon-user-md"></i> <span>Admins / Roles</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/admins/i", $url)) { ?> class="display: block;" <?php } ?>>
      <li <?php if(preg_match("/add-admins'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/add-admins')}}">Add Admins / Roles</a></li>
        <li <?php if(preg_match("/view-admins'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-admins')}}">View Admins / Roles</a></li>
      </ul>
    </li>
    @endif
    @if(Session::get('adminDetails')['type'] == "Admin")
    <li class="submenu"> <a href="#" id=""><i class="icon icon-list-alt"></i> <span>{{__('backend.cms_pages')}}</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/cms-page/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-cms-page'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-cms-page')}}">{{__('backend.add_cms_page')}}</a></li>
        <li <?php if(preg_match("/view-cms-page'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-cms-page')}}">{{__('backend.view_cms_page')}}</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-certificate"></i> <span>Currencies</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/currencies/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-currencies'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-currencies')}}">Add Currencies</a></li>
        <li <?php if(preg_match("/view-currencies'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-currencies')}}">View Currencies</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-truck"></i> <span>Shipping</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/shipping/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/view-shipping'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-shipping')}}">Shipping Charges</a></li>
      </ul>
    </li>

    <li><a href="{{url('/admin/view-newsletter-subscribers')}}"><i class="icon icon-rss"></i> <span>Newsletter Subscribers</span></a></li>
    @endif
    <li><a href="javascript:"><i class="icon icon-th"></i> <span>Tables</span></a></li>
    
    <li class="content"> <span>{{__('backend.monthly_bandwidth_transfer')}}</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>{{__('backend.disk_space_usage')}}</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->