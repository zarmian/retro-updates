@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/dropdown/css/normalize.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/dropdown/css/cs-select.css') }}" type="text/css" rel="stylesheet">

@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.salary_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/employees.salary_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">


    <form action="{{ url('/salary/manage') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($to) && $to <> ""){{date('m-d-Y', strtotime($to) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

           

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="department" id="department" class="chosen form-control1">
              <option value="">@lang('admin/employees.select_department')</option>
              @if(isset($departments) && count($departments) > 0)
                @foreach($departments as $department)
                  @if($department->id == app('request')->input('department'))
                    <option value="{{ $department->id }}" selected="selected">{{ $department->title }}</option>
                  @else
                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                  @endif
                @endforeach
              @endif
              
            </select>

           

            <!-- select option -->
          </div>


          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="employees" id="employees" class="chosen form-control1">
              <option value="">@lang('admin/employees.select_employees')</option>
            </select>
            <!-- select option -->
          </div>



        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="@lang('admin/common.find_btn_txt')" />
          </div>
        </div>

      </div>

       
        </form>
    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
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
      
      
      <div id="products" class="row list-group">
        <div class="col-lg-12 col-sm-12 col-xs-12">
        @if(isset($results) && count($results) > 0)

        <div class="col-lg-6 col-md-2 col-sm-4 col-xs-6 col-lg-offset-6 col-md-offset-10 col-sm-offset-8 col-xs-offset-6 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 300px;"><b>@lang('admin/reports.period_date_txt', ['to' => $to, 'from' => $from]) </b></li>
                  <li style="width: 200px;"><b>Opening: {{ $opening['balance'] }}</b></li>
                </ul>
              <div class="clearfix"></div>
          </div>
       
          @foreach($results as $row)

            <div class="col-lg-12 col-sm-12 col-xs-12 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 150px;"><b>@lang('admin/reports.code_txt'):</b> {{ $row['code'] }}</li>
                  <li style="width: 150px;"><b>@lang('admin/entries.date_label'): </b> {{ $row['date'] }}</li>
                  <li style="width: 300px;"><b>@lang('admin/accounting.account_title'):</b> {{ $row['account_name'] }}</li>
                  <li style="width: 150px;"><b>@lang('admin/accounting.type_dr'):</b> {{ $row['debit'] }}</li>
                  <li style="width: 150px;"><b>@lang('admin/accounting.type_cr'):</b> {{ $row['credit'] }}</li>

                  <li style="width: 150px;"><b>@lang('admin/accounting.balance_txt'):</b> {{ $row['balance'] }}</li>

                </ul>
              <div class="clearfix"></div>
          </div>
            
          @endforeach

        @else

          <div class="col-lg-12"><div class="alert alert-danger">@lang('admin/common.notfound')</div></div>

        @endif
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

function getEmployeeByDepartment(department_id, employee_id) {
    if (department_id != "" && employee_id != "") {

        $('#employees').html("");
        
        var url = '{{ url('/reports/ajax/eSuggestion') }}';
        var div_data = '<option value="">@lang('admin/employees.select_employees')</option>';
        
        alert(url);
        $.ajax({
            type: "POST",
            url: url,
            data: {'department_id': department_id, '_token': '{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (employee_id == obj.id) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.first_name + "</option>";
                });
                $('#employees').append(div_data);
            }
        });
    }
}


$(document).ready(function() {
  var department_id = $('#department').val();
  var employee_id = '';
  getEmployeeByDepartment(department_id, employee_id);  
});


$(document).on('change', '#department', function(){

  var $this = $(this);
  var department_id = $this.val();
  $('#employees').attr('disabled', true);

  url = '{{ url('/reports/ajax/eSuggestion') }}';

  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: {'department_id': department_id, '_token': '{{ csrf_token() }}'},
  })
  .done(function($data) {
    
    var options = '<option value="">@lang('admin/employees.select_employees')</option>';
    $.each($data, function(k, v) {
      options += '<option value="'+v.id+'">'+v.first_name+' '+v.last_name+'</option>';
    });
    
    $('#employees').html(options);
    $('#employees').attr('disabled', false);
  });


});




  $('.datedropper').dateDropper();
  $(".chosen").select2();
</script>
@endsection