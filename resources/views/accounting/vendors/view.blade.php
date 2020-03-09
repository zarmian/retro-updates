@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/vendors.customer_detail_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/vendors') }}">@lang('admin/vendors.manage_heading')</a>  / 
        <a href="#" class="active">@lang('admin/customers.customer_detail_heading')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
  
  <div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">

      <div class="col-sm-3">
        <div class="panel panel-default ibox-content-shadow">
          <div class="panel-body">
            <div class="customer-box">
              <h2>{{ $customer->first_name }} {{ $customer->last_name }}</h2>
              <p class="e-code"># {{ $customer->code }} </p>

              <div class="e-detail">
                <p><b>@lang('admin/customers.email_txt'): </b> {{ $customer->email }}</p>
                <p><b>@lang('admin/customers.phone_txt'):</b> {{ $customer->phone }}</p>
                <p><b>@lang('admin/users.cell_label'):</b> {{ $customer->mobile }}</p>
                <p><b>@lang('admin/users.fax_label'):</b> {{ $customer->fax }}</p>
              </div>

              <div class="e-detail">
                <h3>@lang('admin/customers.company_txt')</h3>
                <h4> {{ $customer->company }}</h4>
              </div>

              <div class="e-detail">
                <h3>@lang('admin/users.present_address_label')</h3>
                <p>{!! $customer->present_address !!}</p>
                <h3>@lang('admin/users.permanant_address_label')</h3>
                <p>{!! $customer->permanent_address !!}</p>
              </div>

              <div class="e-detail">
                <p> <b>@lang('admin/customers.country_txt')</b> {{ $customer->country->country_name }}</p>
                <p><b>@lang('admin/users.state_label'): </b> {{ $customer->state }}</p>
                <p><b>@lang('admin/users.city_label'): </b>{{ $customer->city }}</p>
                <p><b>@lang('admin/users.postal_label'): </b> {{ $customer->postal_code }}</p>

              </div>


              <div class="e-detail">
                <h3>@lang('admin/users.reference_label')</h3>
                <p>{!! $customer->other !!}</p>
                
              </div>


            </div>
           
          </div>
        </div>
      </div>

      <div class="col-sm-9">

      <ul class="nav nav-tabs profile-tabs" role="tablist">
        <li class="active"><a href="#charts" class="ctabs">@lang('admin/customers.overview_txt') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
        <li><a href="#invoices" class="ctabs">@lang('admin/customers.invoices_txt') <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
        
      </ul>
        
        <section id="charts">
          
          <div class="account_block">
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-seagreen">
                <span>@lang('admin/customers.total_order_amount_txt')</span>
                <h1>{{ number_format($total_order_amount, 2) }} <span class="currency">{{ $currency }}</span></h1>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-skyblue">
                <span>@lang('admin/customers.total_rec_amount_txt')</span>
                <h1>{{ number_format($total_received, 2) }} <span class="currency">{{ $currency }}</span></h1>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-pink">
                <span>@lang('admin/customers.total_pend_amount_txt')</span>
                <h1>{{ number_format($total_pending, 2) }} <span class="currency">{{ $currency }}</span></h1>
              </div>
            </div>
          </div>


          <div class="col-md-12">
            <div class="ibox float-e-margins ibox-content border-radius">
              <canvas id="lineChart" height="100"></canvas>
            </div>
          </div>


        </section>



        <section id="invoices">

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
                        <th width="140"> @lang('admin/entries.amt_txt')</th>
                        <th width="100">@lang('admin/entries.invoice_paid_status')</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($recents as $recent)
                          <tr>
                            <td><a href="{{ url('accounting/purchase/detail', $recent['id']) }}"> {{ $recent['invoice_number']}} </a> </td>
                            <td>{{ date('d M, Y', strtotime($recent['date'])) }}</td>
                            <td>{{ $recent['customer'] }}</td>
                            <td class="amount">{{ $recent['amount'] }} <span class="currency">{{ $currency }}</span></td>
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

        </section>

       
      </div>


    </div>
  </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/chart/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/chart/js/mdb.min.js')}}"></script>

<script type="text/javascript">
  //line
var ctxL = document.getElementById("lineChart").getContext('2d');
var total_month = {!! json_encode($total_month) !!};
var customer_sale = {!! json_encode($sales_chart) !!};
var customer_paid = {!! json_encode($sales_received) !!};
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: total_month,
        datasets: [
            {
                label: "@lang('admin/customers.sales_txt')",
                fillColor: "rgba(0,70,142,0.2)",
                strokeColor: "rgba(90,70,142,1)",
                pointColor: "rgba(90,70,142,1)",
                pointStrokeColor: "#000000",
                pointHighlightFill: "#000000",
                pointHighlightStroke: "rgba(90,70,142,1)",
                data: customer_sale
            },
            {
                label: "@lang('admin/customers.received_payment_txt')",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: customer_paid
            }
        ]
    },
    options: {
        responsive: true
    }    
});
    
</script>

<script type="text/javascript">
$(document).ready(function () {
$(window).scroll(function(){
        var window_top = $(window).scrollTop() + 12; 
       // the "12" should equal the margin-top value for nav.stickydiv
        var div_top = $('#checkdiv').offset().top;
        if (window_top >= div_top) {
                $('nav').addClass('stickydiv');
            } else {
                $('nav').removeClass('stickydiv');
            }
    });  



$('.ctabs').on('click', function (e) {
  
      e.preventDefault();
        $(document).off("scroll");
         $('a').each(function () {
            $(this).closest('li').removeClass('active');
        })
        $(this).closest('li').addClass('active');
         var target = this.hash,
         menu = target;
         $target = $(target);
       $('html, body').stop().animate({
            'scrollTop': $target.offset().top+2
        }, 600, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
});


</script>







@endsection