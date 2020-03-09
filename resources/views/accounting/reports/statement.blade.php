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
        <h1>@lang('admin/reports.statment_report_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.statment_report_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">


    <form action="{{ url('/reports/statement') }}" method="post">
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
                <optgroup label="{{ $account['name'] }}">
                  @if(isset($account['coa']) && count($account['coa']) > 0)
                    @foreach($account['coa'] as $children)
                      @if(isset($account_id) && $account_id == $children['cid'])
                        <option value="{{ $children['cid'] }}" selected="selected"> -- {{ $children['name'] }}</option>
                      @else
                        <option value="{{ $children['cid'] }}"> -- {{ $children['name'] }}</option>
                      @endif
                    @endforeach
                  @endif
                  </optgroup>
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
            
              @if(isset($results) && count($results) > 0)
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b>@lang('admin/reports.statment_report_txt')</b> <span class="filter-txt-highligh">({{$to}} - {{$from}}) </span> ({{$results[0]['account_name']}}) </h2></div>
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
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;">@lang('admin/accounting.balance_txt')</th>
                </tr>

                <tr>
                  <th width="150"></th>
                  <th width="200" style="text-align: left;"></th>
                  <th width="200" style="text-align: left;"></th>
                  <th width="200" style="text-align: right;">@lang('admin/reports.opening_txt')</th>
                  <th width="150" align="right" style="text-align: right;" width="100">{{ $opening_dr }} {{ $currency }}</th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;">{{ $opening_cr }} {{ $currency }}</th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"></th>
                </tr>
       
                @foreach($results as $row)
                  <tr>
                    <th><b>{{ $row['code'] }} </b></th>
                    <th><b>{{ $row['date'] }}</b></th>
                    <td align="left"><b>{{ $row['payment_detail'] }}</b></td>
                    <th width="200" style="text-align: left;">{{ $row['description'] }}</th>
                    <td align="right">{{ $row['debit'] }} {{ $currency }}</td>
                    <td align="right">{{ $row['credit'] }} {{ $currency }}</td>
                    <td align="right">{{ $row['balance'] }} {{ $currency }}</td>
                  </tr>
                 
                @endforeach
                

                <tr>
                    <th></th>
                    <th></th>
                    <th align="left"></th>
                    <th align="left"></th>
                    <th align="right" style="text-align: right">{{ $tlt_dr }} {{ $currency }}</th>
                    <th align="right" style="text-align: right">{{ $tlt_cr }} {{ $currency }}</th>
                    <th align="right" style="text-align: right">{{ $tlt_balance }} {{ $currency }}</th>
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