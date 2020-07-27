<?php $url = url()->current(); ?>

<!--sidebar-menu-->
<div id="sidebar"><a href="{{url('/admin/dashboard')}}" class="visible-phone"><i class="icon icon-home"></i>{{__('backend.dashboard')}}</a>
  <ul>

  {!! isset($page) ? $page->module_sidebar(0, isset($module) ? $module : '') : '<div style="padding-left: 10px;">Please load $page on Controller</div>' !!}
    
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