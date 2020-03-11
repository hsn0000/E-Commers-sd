<?php $url = url()->current(); ?>


<!--sidebar-menu-->
<div id="sidebar"><a href="{{url('/admin/dashboard')}}" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
<li <?php if(preg_match("/dashboard/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/dashboard')}}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/category/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-category'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-category')}}">Add Category</a></li>
        <li <?php if(preg_match("/view-categories/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-categories')}}">View Category</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-book"></i> <span>Products</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/product/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-product'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-product')}}">Add Product</a></li>
        <li <?php if(preg_match("/view-product'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-product')}}">View Product</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-qrcode"></i> <span>Coupons</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/coupon/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-coupon'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/add-coupon')}}">Add Coupon</a></li>
        <li <?php if(preg_match("/view-coupon'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-coupon')}}">View Coupon</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-shopping-cart"></i> <span>Orders</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/orders/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/view-orders'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-orders')}}">View Orders</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-picture"></i> <span>Banners</span> <span class="label label-important">2</span></a>
      <ul <?php if(preg_match("/banner/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/add-banner'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/add-banner')}}">Add Banner</a></li>
        <li <?php if(preg_match("/view-banner'/i", $url)) { ?> class="active" <?php } ?>> <a href="{{url('/admin/view-banner')}}">View Banner</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#" id=""><i class="icon icon-user"></i> <span>Users</span> <span class="label label-important">1</span></a>
      <ul <?php if(preg_match("/users/i", $url)) { ?> class="display: block;" <?php } ?>>
        <li <?php if(preg_match("/view-users'/i", $url)) { ?> class="active" <?php } ?>><a href="{{url('/admin/view-users')}}">View Users</a></li>
      </ul>
    </li>
    <li><a href="tables.html"><i class="icon icon-th"></i> <span>Tables</span></a></li>
    
    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->