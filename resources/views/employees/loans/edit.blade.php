@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('employees/common.request_loan_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('employees/common.dashboard_heading')</a>  /  
        <a href="{{ url('/loan-request') }}">@lang('employees/common.request_leave_txt')</a>  /  
        <a href="#" class="active">@lang('employees/common.request_loan_txt')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/loan-request/update', $loan->id) }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('employees/common.request_loan_txt')</h3>
              <p>@lang('employees/common.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label">@lang('employees/common.loan_title_txt')*</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="@lang('employees/common.loan_title_txt')*" required="required" value="{{ $loan->title }}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="date" class="input_label">@lang('employees/common.loan_apply_date')</label>
                <input type="text" name="date" id="date" class="datepicker form-control1" placeholder="@lang('employees/common.loan_apply_date')*" required="required" data-default-date="{{ date('m/d/Y', strtotime($loan->datetime)) }}" data-format="m/d/Y" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="description" class="input_label">@lang('employees/common.loan_amount')</label>
                <input type="text" name="amount" id="amount" class="form-control1" placeholder="@lang('employees/common.loan_amount')*" required="required" value="{{ $loan->amount }}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="reason" class="input_label">@lang('employees/common.loan_reason')</label>
                <textarea name="reason" id="reason" cols="30" rows="10" class="form-control2" placeholder="@lang('employees/common.loan_reason')">{{ $loan->detail }}</textarea>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="" class="input_label"></label>
                <input type="submit" value="@lang('admin/common.button_submit')" class="btn btn-primary btn-block new-btn">
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