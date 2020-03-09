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
        <h1>@lang('admin/accounting.chart_heading'): </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="#" class="active">@lang('admin/accounting.chart_heading')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')


<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12  no-padding-left">
        
          
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4>@lang('admin/entries.customer_invoice_txt')</h4>
                  <p><span>@lang('admin/entries.today_receivable_heading')</span> {{ $today_receivable }} {{ $currency }}</p>
                  <p><span>@lang('admin/entries.total_receivable_heading') </span> {{ $total_receivable }} {{ $currency }}</p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="{{ url('accounting/sales') }}"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="{{ url('accounting/sales/add') }}"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4>@lang('admin/entries.vendors_bill_txt')</h4>
                  <p><span>@lang('admin/entries.today_payable_txt')</span> {{ $today_payable }} {{ $currency }}</p>
                  <p><span>@lang('admin/entries.total_payable_txt')</span> {{ $total_payable }} {{ $currency }}</p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="{{ url('accounting/purchase') }}"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="{{ url('accounting/purchase/add') }}"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4>@lang('admin/entries.expenses_txt')</h4>
                  <p><span>@lang('admin/entries.today_txt') </span> {{ $today_expense }} {{ $currency }}</p>
                  <p><span>@lang('admin/entries.this_month_txt') </span> {{ $total_expense }} {{ $currency }} </p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="{{ url('accounting/journal') }}"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="{{ url('accounting/journal/add') }}"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4>@lang('admin/entries.hr_payroll_txt')</h4>
                  <p><span>@lang('admin/entries.this_month_salary_txt') </span> {{ $this_month_salary }} {{ $currency }}</p>
                  <p><span>@lang('admin/entries.pervious_month_salary_txt') </span> {{ $pervious_month_salary }} {{ $currency }}</p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="{{ url('salary/create') }}"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="{{ url('salary/create') }}"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

          </div>

        
      </div>
      <div class="col-lg-8 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <div class="col-sm-11"><h2>@lang('admin/accounting.chart_heading')</h2></div>
          <div class="col-sm-1">
            <a href="{{ url('accounting/chart/add') }}" class="btn-add-chart"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
          
          <table class="table table-striped">
            
              <tr>
                <th width="90">@lang('admin/reports.code_txt')</th>
                <th>@lang('admin/accounting.name_txt')</th>
                <th>@lang('admin/accounting.type_txt')</th>
                <th>@lang('admin/accounting.account_opening')</th>
                <th width="120">@lang('admin/accounting.account_balance')</th>
                <th>@lang('admin/accounting.action_txt')</th>
              </tr>

              @if(isset($accounts) && count($accounts) > 0)
                @foreach($accounts as $account)


              <tr>
                <th></th>
                <th></th>
                <td colspan="4"><b>{{ $account['name'] }}</b></td>
              </tr>
              
              @if(isset($account['coa']) && count($account['coa']) > 0)
                @foreach($account['coa'] as $coa)
                  <tr>
                    <td>{{ $coa['code'] }}</td>
                    <td>{{ $coa['name'] }}</td>
                    <td>{{ $coa['type_name'] }}</td>
                    <td>{{ $coa['opening'] }} {{ $coa['balance_type'] }} </td>
                    <td>{{ $coa['balance'] }} {{ $currency }}</td>
                    @if(isset($coa['is_systemize']) && $coa['is_systemize'] == 1)
                    <td>@lang('admin/accounting.system_account')</td>
                    @else
                    <td>
                      <a href="{{ url('accounting/chart/edit', $coa['cid']) }}">@lang('admin/accounting.edit_txt')</a> 
                    </td>
                    @endif
                  </tr>
                @endforeach
              @endif

                @endforeach
            
              @endif
            
          </table>

        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/dropdown/js/classie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/dropdown/js/selectFx.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      (function() {
        [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {  
          new SelectFx(el);
        } );
      })();
    </script>
  
  <script type="text/javascript">

    $(function(){
      // bind change event to select
      $('#per_page').on('change', function () {
      var url = $(this).val(); // get selected value
      if (url) { // require a URL
        window.location = '?per_page='+url; // redirect
      }
      return false;
      });
    });

    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

<script type="text/javascript">
    $('.datepicker').dateDropper();
  </script>
@endsection