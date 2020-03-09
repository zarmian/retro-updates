@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/dropdown/css/normalize.css') }}" type="text/css" rel="stylesheet">



@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/loans.loan_statment_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/loans.loan_statment_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">


    <form action="{{ url('/employees/loans/statement') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
     
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($to) && $to <> ""){{date('m-d-Y', strtotime($to) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($from) && $from <> ""){{date('m-d-Y', strtotime($from) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="employee_id" id="employee_id" class="chosen form-control1">
              <option value="">@lang('admin/reports.select_by_employees_option_txt') </option>
              
              @if(isset($employees) && count($employees) > 0)
                @foreach($employees as $employee)
               
                  @if(isset($employee_id) && $employee_id == $employee['id'])
                    <option value="{{ $employee['id'] }}" selected="selected">{{ $employee['employee_code'] }} -- {{ $employee['first_name'] }} {{ $employee['last_name'] }}</option>
                  @else
                    <option value="{{ $employee['id'] }}">{{ $employee['employee_code'] }} -- {{ $employee['first_name'] }} {{ $employee['last_name'] }}</option>
                  @endif
               
                @endforeach
              @endif
            </select>

           

            <!-- select option -->
          </div>


          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12  filter-dropdown">
            <select name="type" id="type" class="chosen form-control1">
              <option value="">@lang('admin/loans.select_by_type_option_txt')</option>
              <option value="2" @if(isset($type) && $type == 2)) selected="selected" @endif>@lang('admin/loans.type_option_tmp')</option>
              <option value="1" @if(isset($type) && $type == 1)) selected="selected" @endif>@lang('admin/loans.type_option_fix')</option>
              
            </select>
            
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



        @if(isset($loans) && count($loans) > 0)

        <div class="col-lg-6 col-md-2 col-sm-4 col-xs-6 col-lg-offset-6 col-md-offset-10 col-sm-offset-8 col-xs-offset-6 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 300px;"><b>@lang('admin/reports.period_date_txt', ['to' => $to, 'from' => $from]) </b></li>
                  <li style="width: 200px;"><b>@lang('admin/loans.total_loan_txt'): {{ $total_loans }}</b></li>
                </ul>
              <div class="clearfix"></div>
          </div>
       
          @foreach($loans as $row)

            <div class="col-lg-12 col-sm-12 col-xs-12 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 250px;"><b>@lang('admin/entries.date_label'): </b> {{ $row['date'] }} </li>
                  <li style="width: 400px;"><b>@lang('admin/accounting.description_txt'):</b> {{ $row['detail'] }} </li>
                  <li style="width: 250px;"><b>@lang('admin/loans.deposit_loan_txt'):</b> {{ $row['deposit'] }} </li>
                 
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
  $('.datedropper').dateDropper();
  $(".chosen").select2();
</script>
@endsection