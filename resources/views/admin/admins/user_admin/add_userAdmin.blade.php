
@extends('layouts.adminLayout.admin_design')
@section('title')
Add User Admin | Admin Hsn E-commerce
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
    <div id="breadcrumb"> <a href="{{url('/admin/dashboard')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> {{__('backend.home')}}</a> <a href="{{ $module->permalink }}">User Admin</a>
     <a href="{{ $module->permalink.'/add' }}" class="current">Add User Admin</a> </div> 
    <h1> User Admin </h1> 
  </div>

  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
      @include('layouts.adminLayout.actions.action') 
        <div class="widget-box"> 
          <div class="responsif-costume">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add User Admin</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" action="{{ $module->permalink.'/save' }}" id="form-table" method="post" autocomplete="off">
                @csrf
                    <div class="control-group">
                        <label for="" class="control-label required">User Name</label>
                        <div class="controls">
                            <input type="text" name="username" class="form-control" value="{{ old('username') ?: '' }}" style=" @error('username') border-style: solid; border-color: orangered; @enderror ">
                            @error('username') {!! required_field($message) !!} @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="" class="control-label required">Email</label>
                        <div class="controls">
                            <input type="email" name="email" class="form-control" value="{{ old('email') ?: '' }}" style=" @error('email') border-style: solid; border-color: orangered; @enderror ">
                            @error('email') {!! required_field($message) !!} @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="" class="control-label">Phone</label>
                        <div class="controls">
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') ?: '' }}" style=" @error('phone') border-style: solid; border-color: orangered; @enderror ">
                            @error('phone') {!! required_field($message) !!} @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="" class="control-label required">Password</label>
                        <div class="controls">
                            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') ?: '' }}" style=" @error('password') border-style: solid; border-color: orangered; @enderror ">
                            @error('password') {!! required_field($message) !!} @enderror
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="" class="control-label required">Confirm Password</label>
                        <div class="controls">
                            <input type="password" name="repassword" id="repassword" class="form-control" value="{{ old('repassword') ?: '' }}" style=" @error('repassword') border-style: solid; border-color: orangered; @enderror ">
                            @error('repassword') {!! required_field($message) !!} @enderror
                        </div>
                    </div>

                    @if(session('session_guid') > 1 )
                    <div class="control-group">
                        <label for="" class="control-label">Employee</label>
                        <div class="controls">
                          <select name="employee" id="live-search-employee" class="live-search select2-hidden-accessible" aria-hidden="true" style=" width: 220px; @error('employee') border-style: solid; border-color: orangered; @enderror ">
                            <option value="">Search for a item</option>
                          </select>
                            @error('employee') {!! required_field($message) !!} @enderror
                        </div>
                    </div>
                    @endif

                    <div class="control-group">
                        <label for="" class="control-label">User Group </label>
                        <div class="controls">
                        @if(session('session_guid') == 1)
                        <select class="select2" name="user_group" data-minimum-results-for-search="-1" data-placeholder="Select a group" id="" style=" width: 220px; @error('employee') border-style: solid; border-color: orangered; @enderror ">
                        @foreach($query->get_user_group(session('session_guid') > 1 ? ['guid' => session('session_guid')] : '')->get() as $val)
                          <option value="{{ $val->guid }}" {{ old('user_group') == $val->guid ? 'selected' : '' }} > {{$val->gname}} </option>
                          @endforeach
                        </select>
                          @error('user_group') {!! required_field($message) !!} @enderror
                        @else
                        <input type="text" class="" value="{{ $page->user_data()->gname }}" disabled>
                        @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="control-input-content"> Active 
                                <div class="switch">
                                    <input type="checkbox" name="active" class="toggle-switch-checkbox toggle-switch-primary" {{ old('active') ? 'checked' : '' }} >
                                    <span class="slider"></span>
                                </div>
                            </label>
                        </div>
                    </div>

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

<!-- <script src="{{ asset('js/backend_js/live-search.js')}}" ></script> -->
<script>
$(function() {
  // liveSearch.init('/employee/search-item','Search for a employee')

  @if(old('employee'))
     @php $_employee = $query->get_employee(['e.id' => old('employe')])->first() @endphp
     var data = {
       id: '{{ old('employee') }}',
       text: '{{ $_employee->fullname }}'
     };

     var newOption = new Option(data.text, data.id, false,false);
     console.log(data, newOption)
     $('#live-search-employee').append(newOption);
     $('#live-search-employee').val('{{ old('employee') }}').trigger('change')
  @endif

});

</script>

@endsection