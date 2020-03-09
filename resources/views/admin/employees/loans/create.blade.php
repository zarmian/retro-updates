@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/loans.manage_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('/employees/loans') }}">@lang('admin/loans.manage_heading')</a>  / 
        <a href="#" class="active">@lang('admin/loans.create_loans')</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="{{ url('/employees/loans/store') }}" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            
            <div class="row">

              <div class="col-lg-12"><div class="top_content">
                <h3>@lang('admin/loans.manage_heading')</h3>
                <p>@lang('admin/employees.field_employee_text')</p>
              </div></div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="date" class="input_label">@lang('admin/loans.date_label')*</label>
                <input type="text" name="date" id="date" class="datepicker form-control1" placeholder="@lang('admin/loans.date_label')*" required="required" value="" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="detail" class="input_label">@lang('admin/loans.title_label')*</label>
                <input type="text" name="detail" id="detail" class="form-control1" placeholder="@lang('admin/loans.title_label')*" required="required" value="{{ old('detail') }}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="type" class="input_label">@lang('admin/loans.type_label')</label>
                <select name="type" id="type" class="form-control1" required="required" onchange="getLoanStatement();">
                  <option value="" selected="selected">@lang('admin/employees.select_option')</option>
                  <option value="1">@lang('admin/loans.type_option_fix')</option>
                  <option value="2">@lang('admin/loans.type_option_tmp')</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="employee_id" class="input_label">@lang('admin/loans.employee_label')*</label>
                <select name="employee_id" id="employee_id" class="form-control1" required="required" onchange="getLoanStatement();">
                  <option value="">@lang('admin/loans.select_option')</option>
                  @if(isset($employees) && count($employees) > 0)
                    @foreach($employees as $employee)
                      @if($employee->id == old('employee_id'))
                        <option value="{{ $employee->id }}" selected="selected">{{ $employee->fullName() }}</option>
                      @else
                        <option value="{{ $employee->id }}">{{ $employee->fullName() }}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
              </div>
              

              <div class="col-lg-12" style="display: none;" id="load-details">
                <span class="label label-warning col-lg-12" style=" padding: 10px 10px">
                  
                </span>
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="amount" class="input_label">@lang('admin/loans.amount_label')*</label>
                <input type="text" name="amount" id="amount" class="form-control1" placeholder="@lang('admin/loans.amount_label')*" required="required" data-bv-numeric="true"
                data-bv-numeric-message="The value is not an integer" value="{{ old('amount') }}" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="installment" class="input_label">@lang('admin/loans.installment_label')</label>
                <input type="text" name="installment" id="installment" required="required" class="form-control1">
              </div>
 

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="name" class="input_label"></label>
                <input type="submit" value="@lang('admin/common.button_submit')" name="submitButton" class="btn btn-block btn-primary btn-block new-btn">
              </div>

              

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

    $(".datepicker").dateDropper();

    function getLoanStatement()
    {

      $( "#load-details" ).hide();

      var type_id = $("#type").val();
      var employee_id = $("#employee_id").val();

      $.ajax({
        url: '{{ url('employees/loans/ajax') }}',
        type: 'POST',
        dataType: 'json',
        data: {action: 'loanStatement', type_id: type_id, employee_id: employee_id, '_token': '{{ csrf_token() }}'},
        success: function (data)
        {
          
          if(data.success == true)
          {
            var html = '';

            html += '<span style="float: left"><b>Advance: '+data.balance+' '+data.currency+'</b></span>';
            html += '<span style="float: right"><b>Installment: '+data.installment+' '+data.currency+'</b></span>';

            $("#load-details").slideDown('slow', function() {
              $("#load-details > span").html(html);
            });
            
              console.log(data);
            
          }


          
        }
      });
        
      //alert(3);
    }

  </script>
@endsection