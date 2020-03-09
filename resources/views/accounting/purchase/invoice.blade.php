<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Invoice</title>

  <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
<link href="{{ asset('assets/bootstrap/css/bootstrap.css?v=1.23')}}" type="text/css" rel="stylesheet">

<link href="{{ asset('assets/css/stylesheet-main.css?v=1.3')}}" type="text/css" rel="stylesheet">
</head>
<body>


<div class="container mainwrapper">
  <div class="row">
    <div class="container">
     
               
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-margin-space-inv">


            <div class="inv-block clearfix">

           
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
                      
                      E: {!! $sale['customer']->email !!} <br>
                      
                    @endif
                    @if(isset($sale['customer']->phone) && !is_null($sale['customer']->phone) && $sale['customer']->phone <> "")
                  
                      T: {!! $sale['customer']->phone !!} <br>
                  
                    @endif

                    @if(isset($sale['customer']->mobile) && !is_null($sale['customer']->mobile) && $sale['customer']->mobile <> "")
                  
                      Mob: {!! $sale['customer']->mobile !!} 
                  
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
                          <td class="td-dark-gray">{!! $detail['description'] !!}</td>
                          <td class="td-light-gray text-center"><b>{{ number_format($detail['qty'], 2) }}</b></td>
                          <td class="td-dark-gray text-center"><b>{{ number_format($detail['unit_price'], 2) }} <span class="currency">{{ $currency }}</span></b></td>
                          <td class="td-light-gray text-center"><b>{{ number_format($detail['amount'], 2) }} <span class="currency">{{ $currency }}</span></b></td>
                        </tr>
                      @endforeach
                    @endif

                  </table>

                   
                </div>

                <div class="col-sm-5 col-sm-offset-7">
                 <table class="table table-bordered total_cal" id="total_cal">
                   <tr>
                     <th width="150" class="text-right">@lang('admin/entries.invoice_sub_total_txt')</th>
                     <td>{{ number_format($sale['details']->sum('unit_price'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.discount_txt')</th>
                     <td>{{ number_format($sale['discount'], 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.invoice_total_txt')</th>
                     <td>{{ number_format($sale['details']->sum('amount') - $sale['discount'], 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.paid_amount_txt')</th>
                     <td>{{ number_format($sale['payments']->sum('amount'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <th class="text-right">@lang('admin/entries.amount_due_txt')</th>
                     <td>{{ number_format($sale['details']->sum('amount') - $sale['discount'] - $sale['payments']->sum('amount'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>
                 </table>
               </div>

               <div class="col-sm-7 clearfix">&nbsp;</div>


               <div class="col-sm-12 visible-print-block clearfix">
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
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;">{!! $payment->payment_no !!}</td>
                          <td class="td-light-gray" height="30" align="left" style="background: #f5f5f5 !important; padding-left: 10px;">{{ date('d, M Y', strtotime($payment->date)) }}</td>

                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;">{!! $payment->description !!}</td>
                          <td class="td-light-gray text-center" height="30" style="background: #f5f5f5 !important"><b>{{ number_format($payment->amount, 2) }} <span class="currency">{{ $currency }}</span></b></td>
                         
                        </tr>
                      @endforeach
                    

                  </table>

                   
                </div>

              @endif
               </div>
              </div>



              

            </div>
             
             <div class="col-sm-12 no-padding text-right hidden-print">
             <br>
               <button type="button" class="btn btn-primary do-print">@lang('admin/entries.print_txt')</button>
             </div>
            
          </div>


          
    </div>
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

    <script type="text/javascript">

    $(document).on('click', '.do-print', function(){
      window.print();
    });

  </script>

</body>
</html>