@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/leaves.offical_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/official-leaves') }}">@lang('admin/leaves.offical_heading')</a>  / 
        <a href="#" class="active">@lang('admin/leaves.create_offical_title')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/official-leaves/store') }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('admin/leaves.offical_heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label">@lang('admin/leaves.title')</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="@lang('admin/leaves.title')*" required="required" value="" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="name" class="input_label">@lang('admin/departments.status')</label>
                <select name="status" id="status" class="form-control1" required="required">
                  <option value="1" selected="selected">@lang('admin/common.active_option_txt')</option>
                  <option value="0">@lang('admin/common.inactive_option_txt')</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="start_date" class="input_label">@lang('admin/leaves.start_date')</label>
                <input type="text" name="start_date" id="start_date" class="datepicker form-control1" placeholder="@lang('admin/leaves.start_date')*" required="required" value="" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="end_date" class="input_label">@lang('admin/leaves.end_date')</label>
                <input type="text" name="end_date" id="end_date" class="datepicker form-control1" placeholder="@lang('admin/leaves.end_date')*" required="required" value="" />
              </div>

             

              

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="name" class="input_label"></label>
                <input type="submit" name="submitButton" value="@lang('admin/common.button_submit')" class="btn btn-primary btn-block new-btn">
              </div>

              

            </div>
            
          </div>


          {{-- Right Form Column --}}

         
          
  
          </div>
        

        

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>

@endsection
@section('scripts')
  <script type="text/javascript">
    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });

    $('.datepicker').dateDropper();
  </script>
@endsection