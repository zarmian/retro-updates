@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/email.email_templates_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/email/templates') }}">@lang('admin/email.email_templates_heading')</a>  / 
        <a href="#" class="active">@lang('admin/email.create_email_templates_heading')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/email/templates/save', $template['id']) }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('admin/email.create_email_templates_heading')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label">@lang('admin/email.title_label')</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="@lang('admin/email.title_label')*" required="required" value="{{ $template['title']}}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="name" class="input_label">@lang('admin/email.status_label')</label>
                <select name="status" id="status" class="form-control1" required="required">
                  @if(isset($template['status']) && $template['status'] == 1)
                    <option value="1" selected="selected">@lang('admin/common.active_option_txt')</option>
                    <option value="0">@lang('admin/common.inactive_option_txt')</option>
                  @else
                    <option value="1">@lang('admin/common.active_option_txt')</option>
                    <option value="0" selected="selected">@lang('admin/common.inactive_option_txt')</option>
                  @endif
                </select>
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="subject" class="input_label">@lang('admin/email.subject_label')</label>
                <input type="text" name="subject" id="subject" class="form-control1" placeholder="@lang('admin/email.subject_label')" required="required" value="{{ $template['subject']}}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="body" class="input_label">@lang('admin/email.template_label')</label>
                <textarea name="body" id="body" cols="30" rows="10" class="summernote form-control2" placeholder="@lang('admin/email.template_label')">{{ $template['body'] }}</textarea>
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                {!! $template['variables'] !!}
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="name" class="input_label"></label>
                <input type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">
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
  </script>
@endsection