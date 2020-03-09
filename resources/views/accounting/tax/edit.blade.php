@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Edit Tax Rates</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/accounting/tax') }}">Manage Tax Rates</a>  / 
        <a href="#" class="active">Edit Tax Rates</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('accounting/tax/edit', $department->id) }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>Manage Tax Rates</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group">
                <label for="title" class="input_label">Tax Name</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="Tax Name*" required="required" value="{{ $department->name }}" />
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group">
                <label for="code" class="input_label">Tax Code</label>
                <input type="text" name="code" id="code" class="form-control1" placeholder="Tax Code*" required="required" value="{{ $department->code }}" />
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group">
                <label for="rate" class="input_label">Tax Rate</label>
                <input type="text" name="rate" id="rate" class="form-control1" placeholder="@lang('admin/departments.title')*" required="required" value="{{ $department->rate }}" />
              </div>


              

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="name" class="input_label"></label>
                <input type="submit" value="@lang('admin/common.button_submit')" name="submitButton" class="btn btn-primary btn-block new-btn">
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