@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/entries.purchase_heading_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="{{ url('accounting/purchase') }}">@lang('admin/entries.purchase_heading_txt')</a> / 
      <a href="#" class="active">@lang('admin/entries.view_purchase_heading')</a>  
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')



<div class="container mainwrapper">
  <div class="row">
    <div class="container">
     

      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
    
               
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top-margin-space-inv">
            
            <div class="inv-block clearfix">

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 hidden-print">
                <div class="inv-no-heading">
                  <h2>@lang('admin/entries.voucher_number_txt'): @lang('admin/common.vr_prefix'){{ $sale['inv_no'] }}</h2>
                </div>
              </div>

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 no-padding-right">
                <div class="invoice_btns text-right">
                  <ul class="hidden-print">
                    
                    

                    <li><a href="javascript:void(0)" class="do-print payment-btn btn-blue-bg"><i class="fa fa-print"></i></a></li>
                    <li><a href="{{ url('accounting/purchase/edit', $sale['id']) }}" class="payment-btn btn-light-purple-bg"><i class="fa fa-eye"></i></a></li>
                    <li><a data-toggle="modal" data-target="#VoucherpaymentModal" data-id="{{ $sale['id'] }}" rel="tooltip" class="payment-btn btn-gray-bg cursor-pointer"><i class="fa fa-plus"></i></a></li>

                    <li><a href="javascript:void(0)" id="do-email"></a>

                    
                      <li role="presentation" class="dropdown btn-env"> <a class="payment-btn btn-pink-bg" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i> </a>

                        <ul class="dropdown-menu invoice-menu">
                          <li><a href="javascript:void(0)" id="mail_voucher_created" data-id="{{ $sale['id']}}" data-st="created">@lang('admin/entries.create_voucher_btn')</a></li>
                        
                        </ul>

                      </li>


                    </li>
                  </ul>

                  <div class="clearfix"></div>
                </div>
              </div>

              <div class="invoice-top-space clearfix">
                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <div class="col-sm-7 col-lg-7 col-md-7 col-xs-12 invoice-left-block">
                    
                    <h2 class="visible-print-block">@lang('admin/entries.voucher_number_txt'): {{ $sale['inv_no'] }}</h2>

                    <div class="inv-log"><img src="{{ asset($business_logo_image) }}" alt=""></div>
                    <div class="setting-detail">
                      <h2>{{ $business_name }}</h2>
                      <p>{!! $business_address !!}</p>

                      <p>
                        @lang('admin/entries.email_short_txt') {{ $business_email }}<br>
                        @lang('admin/entries.phone_short_txt')   {{ $business_phone }}<br>
                        @lang('admin/entries.mobile_short_txt')  {{ $business_mobile }}
                      </p>
                    </div>
                  </div>
                <div class="col-lg-5 col-md-5 col-xs-12 col-sm-5 invoice-right-block">

                <div class="text-right">
                  
                  <div class="invoice-detail">
                    <h4>@lang('admin/entries.voucher_detail_txt')</h4>
                    <p>
                      <b>@lang('admin/entries.voucher_date_label'): {{ $sale['inv_date']}}</b> <br>
                      <span class="color-red"><b>@lang('admin/entries.invoice_due_date_label'): {{ $sale['due_date']}}</b></span> <br>
                      <b>@lang('admin/entries.reference_label'): {{ $sale['reference'] }}</b> <br>
                      <div id="paid_status">
                        @if($sale['paid_status'] == 3)
                          <span class="increase-label label label-danger">@lang('admin/entries.unpaid_txt')</span>
                        @elseif($sale['paid_status'] == 2)
                          <span class="increase-label label label-warning">@lang('admin/entries.partial_paid_txt')</span>
                        @else
                          <span class="increase-label label label-success">@lang('admin/entries.paid_txt')</span>
                        @endif
                      
                      </div>
                    </p>
                  </div>

                  <div class="customer-detail">
                    <h3>@lang('admin/entries.vendor_customer_detail_txt')</h3>
                    <h4>{{ $sale['customer']->first_name }} {{ $sale['customer']->last_name }}</h4>
                    <p>
                    @if(isset($sale['customer']->company) && !is_null($sale['customer']->company) && $sale['customer']->company <> "")

                      ({{ $sale['customer']->company }}) 
                    @endif

                    @if(isset($sale['customer']->present_address) && !is_null($sale['customer']->present_address) && $sale['customer']->present_address <> "")
                    <br>
                      {!! $sale['customer']->present_address !!}
                      
                    @endif

                    @if(isset($sale['customer']->permanent_address) && !is_null($sale['customer']->permanent_address) && $sale['customer']->permanent_address <> "")
                      <br>
                      {!! $sale['customer']->permanent_address !!}
                      
                    @endif
                    </p>

                    <p>

                     @if(isset($sale['customer']->email) && !is_null($sale['customer']->email) && $sale['customer']->email <> "")
                      
                      @lang('admin/entries.email_short_txt')  {!! $sale['customer']->email !!} <br>
                      
                    @endif
                    @if(isset($sale['customer']->phone) && !is_null($sale['customer']->phone) && $sale['customer']->phone <> "")
                  
                      @lang('admin/entries.phone_short_txt') {!! $sale['customer']->phone !!} <br>
                  
                    @endif

                    @if(isset($sale['customer']->mobile) && !is_null($sale['customer']->mobile) && $sale['customer']->mobile <> "")
                  
                      @lang('admin/entries.mobile_short_txt') {!! $sale['customer']->mobile !!} 
                  
                    @endif
                      </p>
                  </div>

                </div>
                  
                  

                </div>
                </div>
              </div>

              <div class="invoice-top-space clearfix">

                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <table class="table">
                    <tr>
                      <th class="border-none">@lang('admin/entries.detail_txt')</th>
                      <th class="border-none" width="100">@lang('admin/entries.quantity_txt')</th>
                      <th class="border-none" width="150">@lang('admin/entries.account_unit_price_label')</th>
                      <th class="border-none" width="150">@lang('admin/entries.total_amount_txt')</th>
                    </tr>

                    @if(isset($sale['details']) && count($sale['details']))
                      @foreach($sale['details'] as $detail)
                        <tr>
                          <td class="td-dark-gray">{!! $detail['title'] !!}</td>
                          <td class="td-light-gray text-center"><b>{{ ($detail['qty']) }} </b></td>
                          <td class="td-dark-gray text-center"><b>{{ ($detail['unit_price']) }} </b></td>
                          <td class="td-light-gray text-center"><b>{{ $detail['amount'] }} </b></td>
                        </tr>
                      @endforeach
                    @endif

                  </table>

                   
                </div>

                <div class="col-sm-5 col-sm-offset-7">
                 <table class="table table-bordered total_cal" id="total_cal">
                   <tr>
                     <th width="150" class="text-right">@lang('admin/entries.invoice_sub_total_txt')</th>
                     <td>{{ number_format($sale['details2']->sum('unit_price'), 2) }} {{ $currency }}</td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.discount_txt')</th>
                     <td>{{ number_format($sale['discount'], 2) }} {{ $currency }}</td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.invoice_total_txt')</th>
                     <td>{{ number_format($sale['details2']->sum('amount') - $sale['discount'], 2) }} {{ $currency }}</td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.total_amount_txt')</th>
                     <td>{{ number_format($sale['payments']->sum('amount'), 2) }} {{ $currency }}</td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.amount_due_txt')</th>
                     <td>{{ number_format($sale['details2']->sum('amount') - $sale['discount'] - $sale['payments']->sum('amount'), 2) }} {{ $currency }}</td>
                   </tr>
                 </table>
               </div>

               <div class="col-sm-7 clearfix">&nbsp;</div>


               <div class="col-sm-12 clearfix">
                  @if(isset($sale['payments']) && count($sale['payments']) > 0)
              <div class="invoice-top-space">
                <h3>@lang('admin/entries.invoice_payment_txt')</h3>
                  <table class="table" width="100%">
                    <tr>
                      <th class="border-none" align="left" style="font-weight: normal;" width="100" height="30">#</th>
                      <th class="border-none" align="left" style="font-weight: normal;" width="200" height="30">@lang('admin/entries.date_label')</th>
                      <th class="border-none" align="left" style="font-weight: normal;" >@lang('admin/entries.detail_txt')</th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" >@lang('admin/entries.paid_amount_txt')</th>
                      
                    </tr>

                    
                      @foreach($sale['payments'] as $payment)
                        <tr>
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;">@lang('admin/common.payment_prefix') {!! $payment->payment_no !!}</td>
                          <td class="td-light-gray" height="30" align="left" style="background: #f5f5f5 !important; padding-left: 10px;">{{ date('d, M Y', strtotime($payment->date)) }}</td>

                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;">{!! $payment->description !!}</td>
                          <td class="td-light-gray text-center" height="30" style="background: #f5f5f5 !important"><b>{{ number_format($payment->amount, 2) }} {{ $currency }}</b></td>
                         
                        </tr>
                      @endforeach
                    

                  </table>

                   
                </div>

              @endif
               </div>
               @if(!empty($sale['note']))
                  <div class="col-sm-12"><b>@lang('admin/entries.reference_textarea_label')</b> <br> {{ $sale['note'] }}</div>
                @endif
              </div>



              

            </div>
             
            
          </div>


          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top-margin-space-inv hidden-print">
            <div class="inv-block clearfix">
              <div class="col-sm-10 col-lg-8 col-md-8 col-xs-8">
                <div class="inv-no-heading">
                  <h2>@lang('admin/entries.payment_detail_txt')</h2>
                </div>
              </div>

              <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                
                <div class="invoice-payments no-print">
                  <h3>@lang('admin/entries.invoice_amount_txt')</h3>
                  <div class="amounts">
                    <p>
                      @lang('admin/entries.invoice_total_txt'):  {{ number_format($sale['details2']->sum('amount') - $sale['discount'], 2) }} {{ $currency }}<br>
                      @lang('admin/entries.total_paid_txt'): {{ number_format($sale['payments']->sum('amount'), 2) }} {{ $currency }}<br>
                      @lang('admin/entries.amount_due_txt'): {{ number_format($sale['details2']->sum('amount') - $sale['discount'] - $sale['payments']->sum('amount'), 2) }} {{ $currency }}
                    </p>

                    <button data-toggle="modal" data-target="#VoucherpaymentModal" data-id="{{ $sale['id'] }}" rel="tooltip" class="btn btn-danger btn-block new-btn">@lang('admin/entries.add_payment_button')</button>
                  </div>

                </div>

                <div class="payments-records">
                  <h4>@lang('admin/entries.payment_records')</h4>
                  <div id="PaymentsViews">
                  @if(isset($sale['payments']) && count($sale['payments']) > 0)
                    @foreach($sale['payments'] as $payment)

                      <div class="payment-bar">
                        <span class="pe_no"> @lang('admin/common.payment_prefix') {{ $payment->payment_no }}</span>  <span class="pe_date">@lang('admin/entries.date_label'): {{ date('d, M Y', strtotime($payment->date)) }} </span>
                      </div>

                      <div class="payment-detail">
                        <p>
                          @lang('admin/entries.paid_amount_txt'): {{ number_format($payment->amount, 2) }} {{ $currency }}<br>
                          @lang('admin/entries.account_label'): {{ $payment->account->name }} <br>
                          @lang('admin/entries.detail_txt'): {{ $payment->description }}
                        </p>
                      </div>
        
                    @endforeach
                  @endif
                  </div>
                </div>


              </div>
            </div>
          </div>
    </div>
  </div>
</div>

<div class="modal fade" id="VoucherpaymentModal" tabindex="-1" role="dialog" aria-labelledby="VoucherpaymentModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content clearfix" id="paymentView">
    </div>
  </div>
</div>


<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog" role="document" id="modal-html">
  </div>

</div>



<style type="text/css" media="print">

  table td.td-dark-gray{
    background: #efefef !important;
    border-color:#FFF !important; 
    
  }

  table td.td-light-gray{
    background: #f5f5f5 !important;
    border-color:#FFF !important; 

  }

  .find-search, .topWrapper, .breadcrumb, .menu, .invoice_btns{
    display: none !important;
  }

  .inv-no-heading {
    margin-top: -31px !important;
    background-color: #FFF !important;
    box-shadow: 5px 2px 10px #cecece !important;
    border: 1px solid #cecece;
    width: 100% !important;
    height: 50px;

}

.inv-no-heading h2 {
    font-size: 16px;
    font-weight: bold;
    line-height: 10px;
    padding-left: 20px;
}

.invoice-left-block{
  float: left !important;
  width: 500px !important;
}

.invoice-right-block{
  float: right !important;
  width: 300px !important;
}

.total_cal{
    width: 300px;
    float: right;
}

.inv-block{
  border: none !important;
}

.top-margin-space-inv{
    margin-top: 0px !important;
    padding-bottom: 0px !important;
}


</style>


@endsection
@section('scripts')

  <script type="text/javascript" src="{{ asset('assets/js/email-templates.js') }}"></script>

    <script type="text/javascript">

    $(document).on('click', '.do-print', function(){
      window.print();
    });

  </script>

@endsection