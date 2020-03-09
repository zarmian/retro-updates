@extends('layouts.app')
@section('head')
<style type="text/css">
  .filter-text-input:active { border: 0px solid #FFF !important;}
  @media print{a[href]:after{content:none}}
</style>
@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/reports.expense_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.expense_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search  hidden-print">
  <div class="container">
    <div class="row">


    <form action="{{ url('/reports/expense') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($to) && $to <> ""){{date('m-d-Y', strtotime($to) )}}@else{{date('m-d-Y', strtotime('last month'))}}@endif" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($from) && $from <> ""){{date('m-d-Y', strtotime($from) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="account" id="account" class="chosen form-control1">
              <option value="">@lang('admin/reports.select_by_account_option_txt')</option>
              @if(isset($accounts) && count($accounts) > 0)
                @foreach($accounts as $account)
                  @if($account['id'] == app('request')->input('account'))
                    <option value="{{ $account['id'] }}" selected="selected">{{ $account['name'] }} </option>
                  @else
                    <option value="{{ $account['id'] }}"> {{ $account['name'] }}</option>
                  @endif
                @endforeach
              @endif
              
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

      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          

          <table class="table table-striped">
            
              @if(isset($summery) && count($summery) > 0)
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b>@lang('admin/reports.expense_report_txt')</b> <span class="filter-txt-highligh">({{$to}} - {{$from}}) </span> ({{ $summery[0]['bank_name'] }} ) </h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> @lang('admin/reports.print_txt') &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                
              </div>
               
                <tr>
                 
                  <th width="150">@lang('admin/entries.invoice_number_txt')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.date_label')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.against_account_txt')</th>
                  <th width="200" style="text-align: left;">@lang('admin/entries.detail_txt')</th>
                  <th width="150" align="right" style="text-align: right;" width="100">@lang('admin/accounting.type_dr')</th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;">@lang('admin/accounting.type_cr')</th>
                  
                </tr>

               
       
                @foreach($summery as $row)
    
                  <tr>
                    <th><a href="{{ url('accounting/journal/detail', $row['id']) }}"> <b> {{ $row['code'] }} </b></a></th>
                    <th><b>{{ $row['date'] }}</b></th>
                    <td align="left"><b>{{ $row['payment_detail'] }}</b></td>
                    <td align="left"><b>{{ $row['ddescription'] }}</b></td>
                    <td align="right">{{ $row['debit'] }} {{ $currency }}</td>
                    <td align="right">{{ $row['credit'] }} {{ $currency }}</td>
                  </tr>
                 
                @endforeach

                <tr>
                    <th colspan="4"></th>
                   
                    <th align="right" class="text-right">{{ $tlt_debit }} {{ $currency }}</th>
                    <th align="right" class="text-right">{{ $tlt_credit }} {{ $currency }}</th>
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