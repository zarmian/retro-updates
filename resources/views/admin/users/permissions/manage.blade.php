@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/users.manage_permission_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ route('admin') }}">@lang('admin/dashboard.dashboard-heading')</a> 
      / <a href="{{ url('admin/manage-groups') }}" >@lang('admin/users.manage_groups_txt')</a>
       / <a href="#" class="active" class="active">@lang('admin/users.manage_permission_txt')</a>
       </div>
    </div>
  </div>
</section>
@endsection
@section('content')
<div class="mainwrapper margin-top">
  <div class="row">

  <div class="col-md-6 col-md-offset-3">

        @if(isset($errors) && count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(Session::has('added'))
          <div class="alert alert-success">{{ Session::get('added') }}</div>
        @endif
          <div class="block">
            <div class="block-title">
              <h2>@lang('admin/users.manage_permission_txt')</h2>
            </div>

            
            <form action="{{ url('admin/manage-permissions/update/'.$group->id) }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="row">
                <div class="col-md-12 form-group no-padding">
                  <label for="name">@lang('admin/users.group_name_label') <span class="req">*</span></label>
                  <input type="text" name="name" id="name" disabled="" class="form-control" value="{{ $group->name }}">
                </div>
              </div>

                <div class="col-md-12 form-group no-padding">
                  <label for="name">Manage Permissions</label>
                </div>

                @if(isset($permissions) && count($permissions) > 0)
                  @foreach($permissions as $permission)


                <div class="col-md-6 no-padding">
                  <label>
                  @if(isset($allowed_permissions[$permission->name]) && $allowed_permissions[$permission->name] == 'true')
                    <input type="checkbox" value="true" name="permissions[{{ $permission->name }}]" checked="checked">  {{ $permission->title }}
                  @else
                    <input type="checkbox" value="true" name="permissions[{{ $permission->name }}]"> {{ $permission->title }} 
                  @endif
                    
                  </label>
                </div>

                @endforeach
  

               
                <div class="row">
                  <div class="col-md-12 form-group no-padding">
                    <input type="submit" value="Submit" class="btn btn-primary btn-block">
                  </div>
                </div>

                @endif
              

              </form>


            </div>
          </div>
    
  </div>
</div>
@endsection