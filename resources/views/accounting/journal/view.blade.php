@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/entries.journal_heading_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="{{ url('accounting/journal') }}">@lang('admin/entries.journal_heading_txt')</a> / 
      <a href="#" class="active">@lang('admin/entries.journal_view_txt')</a>  
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
      
    
               
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-margin-space-inv">
            
            <div class="inv-block clearfix">

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 hidden-print">
                <div class="inv-no-heading">
                  <h2>@lang('admin/entries.entry_no_txt'): {{ $journal['code'] }}</h2>
                </div>
              </div>

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 no-padding-right">
                <div class="invoice_btns text-right">
                  <ul class="hidden-print">
                    <li><a href="javascript:void(0)" class="do-print payment-btn btn-blue-bg"><i class="fa fa-print"></i></a></li>
                  </ul>

                  <div class="clearfix"></div>
                </div>
              </div>

              <div class="invoice-top-space clearfix">
                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <div class="col-sm-7 col-lg-7 col-md-7 col-xs-12 invoice-left-block">
                    
                    <h2 class="visible-print-block">@lang('admin/entries.entry_no_txt'): {{ $journal['code'] }}</h2>

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
                    <h4>@lang('admin/entries.journal_detail_txt')</h4>
                    <p>
                      <b>@lang('admin/entries.date_label'): {{ $journal['date'] }}</b> <br>
                      <span><b>@lang('admin/entries.reference_label'): {{ $journal['reference'] }}</b></span> <br>
                      
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
                      <th class="border-none" width="150">@lang('admin/entries.date_label')</th>
                      <th class="border-none">@lang('admin/entries.detail_txt')</th>
                      <th class="border-none align-center" width="150">@lang('admin/entries.debit_txt')</th>
                      <th class="border-none align-center" width="150">@lang('admin/entries.credit_txt')</th>
                      
                    </tr>

                    @if(isset($journal['details']) && count($journal['details']))
                      @foreach($journal['details'] as $detail)
                        <tr>
                          <td class="td-light-gray">{!! $detail['date'] !!}</td>
                          <td class="td-dark-gray">{!! $detail['description'] !!}</td>
                          <td class="td-light-gray text-center"><b>{{ $detail['debit'] }}</b></td>
                          <td class="td-dark-gray text-center"><b>{{ $detail['credit'] }}</b></td>
                         
                        </tr>
                      @endforeach
                    @endif

                  </table>

                   
                </div>

                <div class="col-sm-3 col-sm-offset-9">
                 <table class="table table-bordered total_cal" id="total_cal">
                   <tr>
                     <th width="100" class="text-right">@lang('admin/entries.invoice_sub_total_txt')</th>
                     <td><b>{{ $journal['tlt_cr']}}</b></td>
                   </tr>

        
                 </table>
               </div>
              
              @if(!empty($journal['description']))
                <div class="col-sm-7 clearfix"><b>@lang('admin/entries.reference_textarea_label')</b> <br> {{ $journal['description'] }} <br> <br></div>
              @endif


               
              </div>



              

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


@endsection
@section('scripts')
  <script type="text/javascript">

    $(document).on('click', '.do-print', function(){
      window.print();
    });

  </script>
@endsection