@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/shift.manage-heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/shift') }}">@lang('admin/shift.manage-heading')</a>  / 
        <a href="#" class="active">@lang('admin/shift.create-heading')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/shift/store') }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          <div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 col-sm-offset-2 col-md-offset-2 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('admin/shift.manage-heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label">@lang('admin/shift.title')</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="@lang('admin/shift.title')*" required="required" value="" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="name" class="input_label">@lang('admin/shift.status_label')</label>
                <select name="status" id="status" class="form-control1" required="required">
                  <option value="1" selected="selected">Active</option>
                  <option value="0">InActive</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="start_time" class="input_label">@lang('admin/shift.start_time')</label>
                <input type="text" name="start_time" id="start_time" class="form-control1 timepicker" placeholder="@lang('admin/shift.start_time')*" required="required" value="{{ date('h:i A', time()) }} " />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="end_time" class="input_label">@lang('admin/shift.end_time')</label>
                <input type="text" name="end_time" id="end_time" class="form-control1 timepicker" placeholder="@lang('admin/shift.end_time')*" required="required" value="{{ date('h:i A', time() + 28800) }}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="description" class="input_label">@lang('admin/shift.description_label')</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/shift.description_label')">{{old('description')}}</textarea>
              </div>

              

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="" class="input_label"></label>
                <input type="submit" name="submitButton" value="@lang('admin/common.button_submit')" class="btn btn-primary btn-block new-btn">
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
      max_hour_value:12,
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