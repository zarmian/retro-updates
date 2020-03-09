@extends('layouts.app')
@section('head')

<style type="text/css">


@media print{a[href]:after{content:none}}
</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/reports.bank_and_cash_text') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.bank_and_cash_text')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

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
            
              @if(isset($banks) && count($banks) > 0)
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b>@lang('admin/reports.bank_and_cash_text')</b> <span class="filter-txt-highligh"> </span></h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> @lang('admin/reports.print_txt') &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="{{ url('accounting/export/?type=bankCash') }}" class="btn-default-xs btn-excel-bg btn-block"> @lang('admin/reports.export_txt') &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                  <th width="150" style="padding-left: 20px">@lang('admin/reports.code_txt')</th>
                  <th width="">@lang('admin/entries.payment_bank_label')</th>
                  <th width="150" align="right" style="text-align: right;padding-right: 20px" width="100">@lang('admin/entries.account_amount_label')</th>
                </tr>
        
                @foreach($banks as $bank)
                  <tr>
                    <th style="padding-left: 20px"> <b> {{$bank['code']}} </b></th>
                    <th><b> {{$bank['name']}}</b> </th>
                    <td align="right" style="text-align: right;padding-right: 20px">{{$bank['tlt_balance']}} {{ $currency }}</td>
                  </tr>
                @endforeach

              <tr>
                <th></th>
                <th align="right" style="text-align: right;"><b>@lang('admin/reports.tlt_amount_txt')</b></th>
                <th align="right" style="text-align: right;padding-right: 20px"><b> {{$tlt_balance_amt}} </b></th>

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