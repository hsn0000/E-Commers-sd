@extends('layouts.adminLayout.admin_design')
@section('title')
Add User Group | Admin Hsn E-commerce
@endsection

@section('link')
<style>
</style>
@endsection

@section('content')

@if(Session::has('msg_success'))
    @include('layouts.adminLayout.alert.msg_success')
@endif

@if(Session::has('msg_error'))
   @include('layouts.adminLayout.alert.msg_error')
@endif

<div id="loading"></div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{ $module->permalink }}">User Group</a>
     <a href="{{ $module->permalink.'/add' }}" class="current">Add User Group</a> </div> 
    <h1> User Group </h1> 
  </div>

  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action')
        <div class="widget-box"> 
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add User Group</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" action="{{ $module->permalink.'/save' }}" id="form-table" method="post" autocomplete="off">
                @csrf
                <div class="control-group">
                    <label for="" class="control-label required">Group Name</label>
                        <div class="controls">
                            <input type="text" name="group_name" class="form-control" value="{{ old('group_name') ?: '' }}" style=" @error('group_name') border-style: solid; border-color: orangered; @enderror ">
                            @error('group_name') {!! required_field($message) !!} @enderror
                        </div>
                    </div>
                    {!! $page->module_list(0, '', '') !!}
                    <br>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

$(function(){
    $('.toggle-switch-checkbox').click(function(e){
        switch_checkbox.init($(this));
    });

    $('.toggle-switch-checkbox').ready(function(){
        var $this = $('.toggle-switch-checkbox');
        $this.map(function(i,v){
            switch_checkbox.init($(this));
        });
    });

    switch_checkbox = {
        init: function($this){
            var idArr=$this.attr('id').split('-'),parent=$this.attr('data-parent');
            if($this.attr('is-parent')=='true'){
                if($this.prop('checked')){
                    $('input:checkbox[data-parent='+idArr[1]+']').prop('disabled',false);
                }
                else{
                    $('input:checkbox[data-parent='+idArr[1]+']').prop('disabled',true);
                    $('input:checkbox[data-parent='+idArr[1]+']').prop('checked',false);
                }
            }

            if(idArr[0]=='view' && $this.is(':checked')==false){
                $('#create-'+idArr[1]).prop('checked',false);
                $('#alter-'+idArr[1]).prop('checked',false);
                $('#drop-'+idArr[1]).prop('checked',false);
            }

            if(idArr[0]!='view' && $this.is(':checked')==true){
                $('#view-'+idArr[1]).prop('checked',true);
            }
        }
    }
});
</script>

@endsection