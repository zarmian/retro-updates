@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Edit New Destination</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/accounting/items') }}">Destination</a>  / 
        <a href="#" class="active">Edit New Destination</a>
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
          
        @if(isset($errors) && count($errors)>0  )
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          </div>
        @endif


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/accounting/destination/edit', $product->id) }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          <div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 col-sm-offset-2 col-md-offset-2 col-sm-offset-0">
            <div class="top_content">
              <h3>Edit New Destination</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="title" class="input_label">Destination Name</label>
                <input type="text" name="destination" id="destination" class="form-control1" placeholder="Destination Name*" required="required" value="{{ $product->name }}" />
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
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
   
   

    $(document).ready(function (){
     
      $('form[data-toggle="validator"]').bootstrapValidator({
        excluded: [':disabled'],
      }).on('status.field.bv', function(e, data) {
        data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
      });

    });

  </script>
@endsection