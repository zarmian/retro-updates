@extends('layouts.app')
@section('head')



<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>



<style type="text/css">

@media print{a[href]:after{content:none}}

</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/reports.sale_balance_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.sale_balance_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search hidden-print">
  <div class="container">
    <div class="row">


    <form action="{{ url('/reports/sales-balance') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          

           <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="customer" id="customer" class="chosen form-control1">
              <option value="" disabled="disabled" selected="selected">@lang('admin/reports.select_by_customer_option_txt')</option>
              @if(isset($customers)  )
                @foreach($customers as $customer)
                  @if($customer->id == app('request')->input('customer'))
                    <option value="{{ $customer->id }}" selected="selected">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                  @else
                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                  @endif
                @endforeach
              @endif
              
            </select>
            <!-- select option -->
          </div>


          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 filter-input">
            <input type="text" name="voucher_no" id="voucher_no" class="filter-date-input" placeholder="@lang('admin/reports.invoice_no_txt')" value="@if(!empty($voucher_no)) {{ $voucher_no }} @endif" />
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
        <div class="alert alert-success hidden-print">{{ Session::get('msg') }}</div>
      @endif

      @if(isset($errors) && count($errors)>0  )
        <div class="alert alert-danger hidden-print">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          </div>
        @endif
      
      
      <div id="products" class="row list-group">

        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          

          <table class="table table-striped">
            
              @if(isset($rows)  )
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b>@lang('admin/reports.sale_balance_report_txt')</b> <span class="filter-txt-highligh">({{$customer_name}}) </span> @if(isset($voucher_no) && !empty($voucher_no)) @lang('admin/reports.for_search_invoice_txt') <span class="filter-txt-highligh">({{$voucher_no}})</span> @endif</h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> @lang('admin/reports.print_txt') &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="{{ url("/reports/sales/export/?type=salesBalanceReport&customer={$customer_id}&voucher_no={$voucher_no}") }}" class="btn-default-xs btn-excel-bg btn-block"> @lang('admin/reports.export_txt') &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                 
                  <th width="150">@lang('admin/entries.pay_serial_no_txt')</th>
                  <th width="">@lang('admin/entries.invoice_no_txt')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.payment_date_txt')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.total_txt')</th>
                  <th width="150" align="right" style="text-align: right;" width="100">@lang('admin/entries.account_amount_label')</th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;">@lang('admin/entries.balance_txt')</th>

                </tr>
       
                @foreach($rows as $row)

                  <tr>
                    <th><a href="{{ url('accounting/sales/detail', $row['sale_id']) }}"> <b> {{ $row['payment_no'] }} </b></a></th>
                    <th><a href="{{ url('accounting/sales/detail', $row['sale_id']) }}"><b>{{ $row['invoice_number'] }}</b> </a></th>
                    <td align="left"><b> {{ $row['payment_date'] }}</b></td>
                    <td align="left">{{ $row['total'] }} {{ $currency }}</td>
                    <td align="right">{{ $row['amount'] }} {{ $currency }}</td>
                    <td align="right">{{ $row['balance'] }} {{ $currency }}</td>
                  </tr>
                 
                @endforeach

                <tr>
                  <th></th>
                  <th></th>
                  <td align="right"><b></b></td>
                  <td align="right"></td>
                  <td align="right"> <b>@lang('admin/entries.tlt_balance_txt')</b></td>
                  <td align="right"><b>{{ $total }} {{ $currency }}</b></td>

                </tr>
            
              @endif
            
          </table>

        </div>
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