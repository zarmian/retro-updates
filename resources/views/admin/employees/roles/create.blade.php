@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.create_role')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/roles') }}">@lang('admin/employees.manage_role')</a>  / 
        <a href="#" class="active">@lang('admin/employees.create_role')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">


      <div class="col-sm-12 col-md-12 col-lg-12">

      @if(Session::has('msg'))
      <div class="alert alert-success">
        {{ Session::get('msg') }}
      </div>
      @endif
      
      @if(isset($errors) && count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form id="group_form" method="post" class="registration-form" action="{{ url('/roles/store') }}" style="margin-top: 20px;" enctype="multipart/form-data">
      
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3>@lang('admin/employees.manage_role')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="title" class="input_label">@lang('admin/employees.role_title_label')</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="@lang('admin/users.role_title_label')*" required="required" value="" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="description" class="input_label">@lang('admin/employees.role_description_label')</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/users.role_description_label')">{{old('description')}}</textarea>
              </div>


            </div>
            
          </div>


          {{-- Right Form Column --}}

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

           <div class="top_content">
              <h3>@lang('admin/users.permission_heading')</h3>
              <p>@lang('admin/users.select_permision_text')</p>
            </div>

            <div class="form_container">

              @if(isset($permissions) && count($permissions) > 0)
                  @foreach($permissions as $permission)

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12 permission_margin no-padding-left">
                      <div data-toggle="buttons" class="btn-group bizmoduleselect">
                      <label class="btn permission_label">
                        <input type="checkbox" name="permissions[{{$permission->name}}]" name="permissions[{{ $permission->name }}]" autocomplete="off" value="true">

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 role_heading no-padding-left"><h6>{{ $permission->title }}</h6></div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3 no-padding text-right"> 
                          <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                        </div>
                      </label>
                    </div>
                    </div>

                @endforeach
              @endif




            </div>


          </div>

          
            <div class="col-sm-12">
              <button type="submit" name="submitButton" class="btn btn-primary">@lang('admin/users.submit_button')</button>
            </div>
          </div>
        

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>


@endsection
@section('scripts')
  <script type="text/javascript">
    $(document).ready(function (){
      $('#group_form').bootstrapValidator('revalidateField');
    });
  </script>
@endsection