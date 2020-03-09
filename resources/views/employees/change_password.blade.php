@extends('layouts.employees.app')


@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('employees/common.change_password_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('admin') }}">@lang('employees/common.dashboard_heading')</a>  /
        <a href="#" class="active">@lang('employees/common.change_password_txt')</a>
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

		
      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('employees/change-password') }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          <div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 col-sm-offset-2 col-md-offset-2 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('employees/common.change_password_txt')</h3>
              <p>@lang('employees/common.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="old_password" class="input_label">@lang('employees/common.old_password_txt')</label>
                <input type="password" name="old_password" id="old_password" class="form-control1" placeholder="@lang('employees/common.old_password_txt')*" required="required" value="" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="password" class="input_label">@lang('employees/common.new_password_txt')</label>
                <input type="password" name="password" id="password" class="form-control1" placeholder="@lang('employees/common.new_password_txt')*" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password_confirmation" placeholder="@lang('admin/profile.password_label')*" />
                <span class="help-block">@lang('employees/common.password_note_txt')</span>
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="title" class="input_label">@lang('employees/common.confirm_password_txt')</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" placeholder="@lang('employees/common.confirm_password_txt')*" required="required" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" />
                <span class="help-block">@lang('employees/common.password_note_txt')</span>
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="" class="input_label"></label>
                <input type="submit" class="btn btn-primary btn-block new-btn">
              </div>

              

            </div>
            
          </div>

  
          </div>
        

        

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>

@endsection
@section('scripts')
  <script src="{{ asset('assets/js/timepicki.js')}}"></script>
  <script type='text/javascript'>
    $('.timepicker').timepicki({
      show_meridian:true,
      min_hour_value:0,
      max_hour_value:23,
      step_size_minutes:5,
      overflow_minutes:true,
      increase_direction:'up',
      disable_keyboard_mobile: false
    });

   

    $(document).ready(function (){
     
      $('form[data-toggle="validator"]').bootstrapValidator({
        excluded: [':disabled'],
      }).on('status.field.bv', function(e, data) {
        data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
      });

    });

  </script>
@endsection