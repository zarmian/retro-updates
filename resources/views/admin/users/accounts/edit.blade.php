@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/users.update')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/manage-users') }}">@lang('admin/users.manage')</a>  / 
        <a href="#" class="active">@lang('admin/users.update')</a>
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

         <form data-toggle="validator" role="form" action="{{ url('/manage-users/update', $user->id) }}" method="POST" enctype="multipart/form-data">
         
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3>@lang('admin/users.person_detail_heading')</h3>
              <p>@lang('admin/users.field_employee_text')</p>
            </div>

            <div class="form_container">

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="first_name" class="input_label">@lang('admin/users.name_label')</label>
                  <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="@lang('admin/users.first_name_label')*" required="required" value="{{ $user->first_name }}" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="last_name" class="input_label">&nbsp;</label>
                  <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="@lang('admin/users.last_name_label')*" required="required" value="{{ $user->last_name }}" />
                </div>

                

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="nationality" class="input_label">@lang('admin/users.nationality_label')</label>
                  <select name="nationality" id="nationality" class="form-control1" required="required">
                    @if(isset($countries) && count($countries) > 0)
                      @foreach($countries as $country)
                        @if($user->country_id == $country->id)
                          <option value="{{ $country->id }}" selected="selected">{{ $country->country_name }}</option>
                        @else
                          <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endif
                      @endforeach
                    @endif
                  </select>
                </div>


                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="email" class="input_label">@lang('admin/users.email_label')*</label>
                  <input type="email" name="email" id="email" class="form-control1" value="{{ $user->email }}" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="@lang('admin/users.email_label')*" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="phone" class="input_label">@lang('admin/users.phone_label')*</label>
                  <input type="text" name="phone" id="phone" value="{{ $user->phone_no }}" required="required" class="form-control1" placeholder="@lang('admin/users.phone_label')*">
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                    <label for="cell" class="input_label">@lang('admin/users.cell_label')</label>
                    <input type="text" name="cell" id="cell" class="form-control1" value="{{ $user->mobile_no }}" required="required" placeholder="@lang('admin/users.cell_label')" />
                </div>


                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                  <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="@lang('admin/users.present_address_label')" value="{{ $user->present_address }}"  />
                </div>

                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                  <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="@lang('admin/users.permanant_address_label')" value="{{ $user->permanant_address }}" />
                </div>

                <div class="col-md-8 col-sm-8 col-lg-8 col-xs-8 form-group">
                <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/users.reference_label')">{{ $user->reference }}</textarea>
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label class="btn btn-block btn-default btn-avatar">
                    @lang('admin/users.avatar_label')&hellip; <input type="file" name="avatar" id="avatar" style="display: none;">
                  </label>
                </div>


              </div>
              
            </div>


            {{-- Right Form Column --}}

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

              <div class="top_content">
                <h3>@lang('admin/users.users_credentials')</h3>
                <p>@lang('admin/users.field_employee_text')</p>
              </div>

              <div class="form_container">

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="employee_code" class="input_label">@lang('admin/users.users_login_label')</label>
                  <input type="text" name="employee_code" id="employee_code" readonly="readonly" class="form-control1" placeholder="@lang('admin/users.username_label')*" value="{{ $user->employee_code }}" required="required">
                </div>

                <div class="col-md-8 col-sm-8 col-lg-8 col-xs-8 form-group">
                  <label for="username" class="input_label">@lang('admin/users.username_label')</label>
                  <input type="text" name="username" id="username" class="form-control1" placeholder="@lang('admin/users.username_label')*" disabled="disabled" value="{{ $user->username }}" required="required">
                </div>


                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <input type="password" name="password" id="password" class="form-control1" placeholder="@lang('admin/users.password_label')" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password_confirmation" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" placeholder="@lang('admin/users.c_password_label')" />
                </div>

                

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">

                  <label for="group" class="input_label">@lang('admin/users.group_label')</label>
                  <select name="group" id="group" class="form-control1" required="required">
                    <option value=""> @lang('admin/users.select_option')  </option>

                    @if(isset($groups) && count($groups) > 0)
                      @foreach($groups as $group)
                        @if($user->role == $group->id)
                          <option value="{{ $group->id }}" selected="selected">{{ $group->title }}</option>
                        @else
                          <option value="{{ $group->id }}">{{ $group->title }}</option>
                        @endif
                      @endforeach
                    @endif
                  </select>
                
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="" class="input_label">@lang('admin/users.status_label')*</label>
                  <select name="status" id="status" class="form-control1" required="required">
                    @if($user->status == 1)
                      <option value="1" selected="selected">@lang('admin/users.active_option')</option>
                      <option value="0">@lang('admin/users.inactive_option')</option>
                    @else
                      <option value="1">@lang('admin/users.active_option')</option>
                      <option value="0" selected="selected">@lang('admin/users.inactive_option')</option>
                    @endif
                  </select>
                </div>



              </div>

            </div>

            <div class="col-sm-12">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-step mbtn btn-block" id="next">@lang('admin/users.submit_button')</button>
            </div>
            </div>
    
            </div>


        </form>


      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

$(document).ready(function (){
    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
});

</script>
@endsection