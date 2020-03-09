<link href="{{ asset('assets/bootstrap/css/bootstrap.css?v=1.23')}}" type="text/css" rel="stylesheet">

<style type="text/css">

.invoice-top-space{
  margin-top: 50px;
  display: block;
}

div.setting-detail p{
  line-height:50em !important;
  color: #000066;
}

.color-red{
  color: red;
}
</style>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top-margin-space-inv">
            
            <div class="inv-block clearfix">


            	<table width="100%">
            		<tr>
            			<td width="50%" align="left">
            				
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

            			</td>
            			<td width="50%" align="right">
            				
            				<div class="text-right" style="text-align: right !important;">
                  
                  <div class="invoice-detail">
                    <h4>@lang('admin/entries.voucher_detail_txt')</h4>
                    <p>
                      @lang('admin/entries.voucher_date_label'): {{ $sale['inv_date']}} <br>
                      <span class="color-red">@lang('admin/entries.invoice_due_date_label'): {{ $sale['due_date']}}</span> <br>
                      <div id="paid_status" style="padding: 20px !important; display: block !important;">
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
                      
                      @lang('admin/entries.email_short_txt') {!! $sale['customer']->email !!} <br>
                      
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

            			</td>
            		</tr>
            	</table>

              
           

              <div class="invoice-top-space clearfix">

                <div class="">
                  <table class="table" width="100%">
                    <tr>
                      <th class="border-none" align="left" style="font-weight: normal;">@lang('admin/entries.detail_txt')</th>
                      <th class="border-none" align="center" style="font-weight: normal;" width="100">@lang('admin/entries.quantity_txt')</th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" >@lang('admin/entries.account_unit_price_label')</th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" height="40">@lang('admin/entries.total_amount_txt')</th>
                    </tr>

                    @if(isset($sale['details']) && count($sale['details']))
                      @foreach($sale['details'] as $detail)
                        <tr>
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;">{!! $detail['description'] !!}</td>
                          <td class="td-light-gray text-center" style="background: #f5f5f5 !important;"><b>{{ number_format($detail['qty'], 2) }}</b></td>
                          <td class="td-dark-gray text-center" style="background: #efefef !important"><b>{{ number_format($detail['unit_price'], 2) }} <span class="currency">{{ $currency }}</span></b></td>
                          <td class="td-light-gray text-center" style="background: #f5f5f5 !important;"><b>{{ number_format($detail['amount'], 2) }} <span class="currency">{{ $currency }}</span></b></td>
                        </tr>
                      @endforeach
                    @endif

                  </table>

                   
                </div>

                <div class="">
                 <table class="table table-bordered total_cal" width="300" style="width: 300px !important" id="total_cal" align="right">
                   <tr>
                     <td width="150" height="30" class="text-right" style="padding-right: 20px;">@lang('admin/entries.invoice_sub_total_txt')</td>
                     <td style="padding-left: 20px;">{{ number_format($sale['details']->sum('unit_price'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right">@lang('admin/entries.discount_txt')</td>
                     <td style="padding-left: 20px;">{{ number_format($sale['discount'], 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right">@lang('admin/entries.invoice_total_txt')</td>
                     <td style="padding-left: 20px;">{{ number_format($sale['details']->sum('amount') - $sale['discount'], 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right"> @lang('admin/entries.total_amount_txt')</td>
                     <td style="padding-left: 20px;">{{ number_format($sale['payments']->sum('amount'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right">@lang('admin/entries.amount_due_txt')</td>
                     <td style="padding-left: 20px;">{{ number_format($sale['details']->sum('amount') - $sale['discount'] - $sale['payments']->sum('amount'), 2) }} <span class="currency">{{ $currency }}</span></td>
                   </tr>
                 </table>
               </div>
              </div>

              @if(isset($sale['payments']) && count($sale['payments']) > 0)
              <div class="invoice-top-space clearfix">
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