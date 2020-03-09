@extends('layouts.app')
@section('head')
<style type="text/css">
.select2-dropdown{
  top: 15px;
}

.datetimepicker{
  border: 0px solid transparent !important;
  background: transparent !important;
}

input:focus, input:active{
  border: 0px solid transparent !important;
}

input.active{
  border: 0px solid transparent !important;
}
</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/accounting.trial_balance_heading')  </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right hidden-print"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/accounting.trial_balance_heading')</a></div>
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
          
          <div class="col-sm-10 hidden-print"><h2>@lang('admin/accounting.trial_balance_heading')</h2></div>
          <div class="col-sm-1 text-center hidden-print"><a href="javascript:void(0)" onclick="window.print();" class="btn-add-chart btn-blue-bg btn-block"><i class="fa fa-print" aria-hidden="true"></i></a></div>
          <div class="col-sm-1 text-center hidden-print"><a href="{{ url('/reports/export/?type=trial') }}" class="btn-add-chart btn-block"><i class="fa fa-download" aria-hidden="true"></i></a></div>

          <table class="table table-striped">
            
              <tr>
               
                <th width="100">@lang('admin/accounting.account_code')</th>
                <th width="300">@lang('admin/accounting.account_title')</th>
                <th width="100" style="text-align: right;">@lang('admin/accounting.opening_debit_txt')</th>
                <th width="100" style="text-align: right;">@lang('admin/accounting.opening_credit_txt')</th>
                <th align="right" style="text-align: right;" width="100">@lang('admin/accounting.trans_debit_txt')</th>
                <th align="right" style="text-align: right;" width="100" style="text-align: right;">@lang('admin/accounting.trans_credit_txt')</th>

                <th align="right" style="text-align: right;" width="100">@lang('admin/accounting.closing_debit_txt')</th>
                <th align="right" style="text-align: right;" width="100">@lang('admin/accounting.closing_credit_txt')</th>
              </tr>

              @if(isset($trials) && count($trials) > 0)
                @foreach($trials as $trial)


              <tr>
                <th><b>{{ $trial['code'] }}</b></th>
                <th><b>{{ $trial['name'] }}</b></th>
                <td align="right">{{ $trial['opening_dr'] }}</td>
                <td align="right">{{ $trial['opening_cr'] }}</td>

                <td align="right">{{ $trial['transition_dr'] }}</td>
                <td align="right">{{ $trial['transition_cr'] }}</td>

                <td align="right">{{ $trial['closing_dr'] }}</td>
                <td align="right">{{ $trial['closing_cr'] }}</td>
              </tr>
             

                @endforeach

                <tr>
                <th></th>
                <th></th>
                <td align="right"><b>{{ $total['op_tlt_dr'] }}</b></td>
                <td align="right"><b>{{ $total['op_tlt_cr'] }}</b></td>

                <td align="right"><b>{{ $total['trans_tlt_dr'] }}</b></td>
                <td align="right"><b>{{ $total['trans_tlt_cr'] }}</b></td>

                <td align="right"><b>{{ $total['closing_tlt_dr'] }}</b></td>
                <td align="right"><b>{{ $total['closing_tlt_cr'] }}</b></td>
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
