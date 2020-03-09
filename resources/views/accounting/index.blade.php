@extends('layouts.app')


@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/dashboard.dashboard-heading') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('admin') }}">@lang('admin/dashboard.dashboard-heading')</a>  
      </div>
    </div>
  </div>
</section>
@endsection


@section('content')

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">

    <div class="account_block">
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-seagreen">
          <span>@lang('admin/entries.monthly_incone_heading')</span>
          <h1>{{ $total_month_incom }} <span class="currency">{{ $currency }}</span></h1> 
        </div>
      </div>
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-skyblue">
          <span>@lang('admin/entries.monthly_expense_heading')</span>
          <h1>{{ $total_month_expense }} <span class="currency">{{ $currency }}</span></h1>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-pink">
          <span>@lang('admin/entries.total_receivable_heading')</span>
          <h1>{{ $total_receivable }} <span class="currency">{{ $currency }}</span></h1>
        </div>
      </div>


      <div class="col-sm-3">
        <div class="collection_account_box bg-color-orange">
          <span>@lang('admin/entries.total_payable_heading')</span>
          <h1>{{ $total_payable }} <span class="currency">{{ $currency }}</span></h1>
        </div>
      </div>
    </div>

    <div class="col-md-6">
        <div class="ibox float-e-margins ibox-content border-radius">
          <canvas id="lineChart" height="150"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="ibox float-e-margins ibox-content border-radius">
          <canvas id="pieChart" height="150"></canvas>
        </div>
    </div>


    <div class="col-md-12">
        <div class="ibox float-e-margins ">
            
            <div class="ibox-content border-radius">

            <div class="ibox-title">
                <h4>@lang('admin/entries.invoice_txt')</h4>
            </div>

                <div id="invoice_stats" style="" >
                <table class="table table-bordered">

                        <tbody>


                            <tr>
                                <td width="150px;"> <a href="#">@lang('admin/entries.unpaid_txt') ({{ $status['unpaid'] }})</a> </td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: {{ $status['unpaid_percent'] }}%;" class="progress-bar progress-bar-danger"></div>
                                    </div></td>

                               
                            </tr>
                            <tr>
                                <td><a href="#">@lang('admin/entries.partial_paid_txt') ({{ $status['partial'] }})</a></td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: {{ $status['partial_percent'] }}%;" class="progress-bar progress-bar-info"></div>
                                    </div></td>

                               
                            </tr>

                            <tr>
                                <td><a href="#">@lang('admin/entries.paid_txt') ({{ $status['paid'] }})</a></td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: {{ $status['paid_percent'] }}%;" class="progress-bar progress-bar-success"></div>
                                    </div></td>

                               
                            </tr>

                        </tbody>
                    </table></div>
                @if(isset($recents) && count($recents) > 0)
                <h4>@lang('admin/entries.recent_invoice_txt') </h4>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="120">#</th>
                        <th width="150">@lang('admin/entries.date_label')</th>
                        <th>@lang('admin/entries.customer_label')</th>
                        <th width="100"> @lang('admin/entries.amt_txt')</th>
                        <th width="100">@lang('admin/entries.invoice_paid_status')</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($recents as $recent)
                          <tr>
                            <td><a href="{{ url('accounting/sales/detail', $recent['id']) }}"> {{ $recent['invoice_number']}} </a> </td>
                            <td>{{ date('d M, Y', strtotime($recent['date'])) }}</td>
                            <td>{{ $recent['customer'] }}</td>
                            <td class="amount" style="width: 130px;">{{ $recent['amount'] }} {{ $currency }}</td>
                            @if($recent['paid'] == 1)
                              <td width="100"><span class="increase-label label label-success">@lang('admin/entries.paid_txt') </span></td>
                            @elseif($recent['paid'] == 2)
                              <td width="100"><span class="increase-label label label-warning">@lang('admin/entries.partial_paid_txt')</span></td>
                            @else
                              <td width="100"><span class="increase-label label label-danger">@lang('admin/entries.unpaid_txt')</span></td>
                            @endif
                            
                        </tr>
                      @endforeach
                    </tbody>
                </table>
              @endif
            </div>
        </div>

    </div>

   



    {{--  --}}

    <div class="row" id="sort_3">
    
      <div class="col-sm-12">
        <div class="col-md-6">
        <div class="ibox float-e-margins">
            
            <div class="ibox-content border-radius">
            <div class="ibox-title">
                <h4>@lang('admin/entries.latest_income_txt')</h4>
            </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('admin/entries.date_label')</th>
                            <th>@lang('admin/entries.account_description_label')</th>
                            <th class="text-right">@lang('admin/entries.amt_txt')</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @if(isset($payments) && count($payments) > 0)
                            @foreach($payments as $payment)
                                <tr>
                                    <td width="150">{{ $payment['date'] }}</td>
                                    <td>{{ $payment['description'] }}</td>
                                    <td width="100" align="right" style="width: 120px;">{{ $payment['amount'] }} {{ $currency }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">@lang('admin/common.notfound')</td>
                            </tr>
                        @endif
                    </tbody>
                    
                </table>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="ibox float-e-margins">
           
            <div class="ibox-content border-radius">
            <div class="ibox-title">
                <h4>@lang('admin/entries.latest_paid_voucher_txt')</h4>
            </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>@lang('admin/entries.date_label')</th>
                            <th>@lang('admin/entries.account_description_label')</th>
                            <th class="text-right">@lang('admin/entries.amt_txt')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($vouchers) && count($vouchers) > 0)
                            @foreach($vouchers as $payment)
                                <tr>
                                    <td width="150">{{ $payment['date'] }}</td>
                                    <td>{{ $payment['description'] }}</td>
                                    <td width="100" align="right" style="width: 120px;">{{ $payment['amount'] }} {{ $currency }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">@lang('admin/common.notfound')</td>
                            </tr>
                        @endif
                    </tbody>


                </table>
            </div>
        </div>

    </div>
      </div>


</div>


    </div>
 </div>
</div>


@endsection

@section('scripts')
<link href="{{ asset('assets/chart/css/style.css')}}" type="text/css" rel="stylesheet">

<script src="{{ asset('assets/chart/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{ asset('assets/chart/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/chart/js/mdb.min.js')}}"></script>

<script type="text/javascript">
  //line
var ctxL = document.getElementById("lineChart").getContext('2d');
var total_month = {!!json_encode($total_month)!!};
var monthly_income = {!!json_encode($monthly_income)!!};
var montly_expense = {!!json_encode($montly_expense)!!};
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: total_month,
        datasets: [
            {
                label: "Sale",
                fillColor: "rgba(90,70,142,0.2)",
                strokeColor: "rgba(90,70,142,1)",
                pointColor: "rgba(90,70,142,1)",
                pointStrokeColor: "#000000",
                pointHighlightFill: "#000000",
                pointHighlightStroke: "rgba(90,70,142,1)",
                data: monthly_income
            },
            {
                label: "Purchase",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: montly_expense
            }
        ]
    },
    options: {
        responsive: true
    }    
});

//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var tlt_pie = {!! json_encode($total_pie) !!}
var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
        labels: ["Income", "Expense"],
        datasets: [
            {
                data: tlt_pie,
                backgroundColor: ["#46BFBD", "#F7464A"],
                hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
            }
        ]
    },
    options: {
        responsive: true
    }    
});
         
</script>

@endsection