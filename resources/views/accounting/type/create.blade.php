@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/accounting.account_type_create_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/chart-type') }}">@lang('admin/accounting.chart_type_heading')</a>  / 
        <a href="#" class="active">@lang('admin/accounting.account_type_create_txt')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('accounting/chart-type/save') }}" style="margin-top: 20px;" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>@lang('admin/accounting.account_type_create_txt')</h3>
              <p>@lang('admin/employees.field_employee_text')</p>
            </div>

            <div class="form_container">
              
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="name" class="input_label">@lang('admin/accounting.account_type_title')*</label>
                <input type="text" name="name" id="name" class="form-control1" placeholder="@lang('admin/accounting.account_type_title')*" required="required" value="{{ old('name') }}" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="parent" class="input_label">@lang('admin/accounting.type_name_txt')*</label>

                <select name="parent" id="parent" data-placeholder="Choose a Types" class="chosen-deselect form-control1" tabindex="2">
                  <option value="0">Parent</option>
                  @if(isset($types) && count($types) > 0)
                    @foreach($types as $type)
                    <option value="{{ $type['type_id'] }}">{{ $type['name'] }}</option>
                      @if(isset($type['children']) && count($type['children']) > 0)
                        @foreach($type['children'] as $children)
                          <option value="{{ $children['type_id'] }}"> -- {{ $children['name'] }}</option>
                        @endforeach
                      @endif
                    
                    @endforeach
                  @endif
                </select>
               
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="type" class="input_label">@lang('admin/accounting.type_label')</label>
                <select name="type" id="type" class="form-control1" required="required">
                  <option value="dr" selected="selected">@lang('admin/accounting.type_dr')</option>
                  <option value="cr">@lang('admin/accounting.type_cr')</option>
                </select>
              </div>

 

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="submit" class="input_label"></label>
                <input type="submit" class="btn btn-primary btn-block new-btn">
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
  
  <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

  <script type="text/javascript">

  

    // $(document).ready(function (){
    //   $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    // });

    $(".datepicker").dateDropper();

    $(function() {
      $('.chosen').chosen();
      $('.chosen-deselect').chosen({ allow_single_deselect: true });
    });
    

</script>
@endsection