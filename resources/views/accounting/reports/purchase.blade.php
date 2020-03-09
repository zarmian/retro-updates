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
        <h1>@lang('admin/reports.purchse_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.purchse_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search hidden-print">
  <div class="container">
    <div class="row">


    <form action="{{ url('/reports/purchase') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($to) && $to <> ""){{date('m-d-Y', strtotime($to) )}}@else{{date('m-d-Y', strtotime('last month'))}}@endif" />
           </div>

           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($from) && $from <> ""){{date('m-d-Y', strtotime($from) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="customer" id="customer" class="chosen form-control1">
              <option value="">@lang('admin/reports.select_by_vendors_option_txt')</option>
              @if(isset($customers) && count($customers) > 0)
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

           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="by_type" id="by_type" class="chosen form-control1">
              <option value="">@lang('admin/reports.select_by_type_option_txt')</option>
              <option value="" @if(app('request')->input('by_type') == 0) selected @endif > @lang('admin/common.select_all_txt') </option>
              <option value="3" @if(app('request')->input('by_type') == 3) selected @endif> @lang('admin/reports.unpaid_option_txt') </option>
              <option value="2" @if(app('request')->input('by_type') == 2) selected @endif> @lang('admin/reports.partial_paid_option_txt') </option>
              <option value="1" @if(app('request')->input('by_type') == 1) selected @endif> @lang('admin/reports.paid_option_txt') </option>
              
            </select>
            <!-- select option -->
          </div>

          

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="due_date" id="due_date" class="filter-date-input datedropper placeholderchange" data-init-set="false" data-large-mode="true" placeholder="@lang('admin/reports.due_date_txt')" data-translate-mode="false" data-auto-lang="false" data-default-date="@if(isset($due_date) && $due_date <> ""){{date('m-d-Y', strtotime($due_date) )}}@else{{date('m-d-Y', time())}}@endif"  />
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

      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          

          <table class="table table-striped">
            
              @if(isset($sales) && count($sales) > 0)
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b>@lang('admin/reports.purchse_report_txt')</b> <span class="filter-txt-highligh">({{ $to_date }} - {{ $from_date }}) </span> @lang('admin/reports.for_search_txt') <span class="filter-txt-highligh">({{ $sales[0]['customer_name']}})</span></h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> @lang('admin/reports.print_txt') &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="{{ url("/reports/purchase/export/?type=purchaseReport&to={$to}&from={$from}&customer={$customer_id}&by_type={$by_type}&due_date={$due_date}") }}" class="btn-default-xs btn-excel-bg btn-block"> @lang('admin/reports.export_txt') &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                 
                  <th width="150">@lang('admin/entries.invoice_number_txt')</th>
                  <th width="">@lang('admin/entries.customer_label')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.invoice_date_label')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.invoice_due_date_label')</th>
                  <th width="150" align="right" style="text-align: right;" width="100">@lang('admin/entries.tlt_txt')</th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;">@lang('admin/reports.tlt_paid')</th>

                </tr>
       
                @foreach($sales as $sale)

                  <tr>
                    <th><a href="{{ url('accounting/purchase/detail', $sale['id']) }}"><b>{{ $sale['invoice_number'] }} </b></a></th>
                    <th><a href="{{ url('accounting/vendors/view', $sale['customer_id']) }}"><b>{{ $sale['customer_name'] }}</b></a></th>
                    <td align="left">{{ $sale['invoice_date'] }}</td>
                    <td align="left">{{ $sale['due_date'] }}</td>
                    <td align="right">{{ $sale['total'] }} {{ $currency }}</td>
                    <td align="right">{{ $sale['paid'] }} {{ $currency }}</td>
                  </tr>
                 
                @endforeach

                <tr>
                  <th></th>
                  <th></th>
                  <td align="right"><b></b></td>
                  <td align="right"><b>@lang('admin/reports.tlt_amount_txt')</b></td>
                  <td align="right"> <b>{{ $sale['total'] }} {{ $currency }}</b></td>
                  <td align="right"><b>{{ $sale['paid'] }} {{ $currency }}</b></td>

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
  </script>

  <script type="text/javascript">
$(".chosen").select2();
</script>
@endsection