@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/entries.purchase_heading_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">@lang('admin/entries.purchase_heading_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

      <form action="" method="GET">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <input type="text" name="invoice_no" id="invoice_no" class="filter-date-input" placeholder="@lang('admin/entries.voucher_number_txt')" value="{{ \Request::get('invoice_no') }}"  />
       </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <select name="v" id="v" class="chosen form-control1">
          <option disabled selected="selected"> @lang('admin/entries.vendor_select_txt')</option>
          <option value="">@lang('admin/common.select_all_txt')</option>
          @if(isset($customers) && count($customers) > 0)
            @foreach($customers as $customer)
              @if(Request::get('v') == md5($customer->id))
                <option value="{{ md5($customer->id) }}" selected="selected">{{ $customer->first_name }} {{ $customer->last_name }}</option>
              @else
                <option value="{{ md5($customer->id) }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
              @endif
            @endforeach
          @endif
        </select>
       </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <select name="status" id="status" class="chosen form-control1">
          <option disabled selected="selected"> @lang('admin/accounting.select_paid_status_filter')</option>
          <option value="">@lang('admin/common.select_all_txt')</option>
          <option value="3" @if(Request::get('status') == "3") selected="selected" @endif>@lang('admin/entries.unpaid_txt')</option>
          <option value="2" @if(Request::get('status') == "2") selected="selected" @endif>@lang('admin/entries.partial_paid_txt')</option>
          <option value="1" @if(Request::get('status') == "1") selected="selected" @endif>@lang('admin/entries.paid_txt')</option>
        </select>
       </div>

       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <button type="submit" class="search"><i class="fa fa-search" aria-hidden="true"></i></button>
       </div>
      </form>

      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <select class="select-page" id="per_page">
          <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
            <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
            <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
            <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
        </select>

      </div>

      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <a href="{{ url('accounting/purchase/add') }}" class="plus">+</a></div>

    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     

      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
      <div id="products" class="list-group">
        @if(isset($sales) && count($sales) > 0)
        @foreach($sales as $sale)
          
          <div class="list-block clearfix">

            <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12 list-content-row">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li>@lang('admin/entries.voucher_number_txt'): <b> {{ $sale['invoice_number'] }} </b></li>
                  <li>@lang('admin/entries.vendor_label'): <b>{{ $sale['customer_name'] }}</b></li>
                  <li>@lang('admin/entries.voucher_date_label'): <b>{{ $sale['invoice_date'] }}</b></li>
                  <li>@lang('admin/entries.invoice_due_date_label'): <b>{{ $sale['due_date'] }}</b></li>
                  <li>@lang('admin/entries.tlt_txt'): <b> {{ $sale['total'] }} {{ $currency }}</b></li>
                  <li>
                    @lang('admin/entries.invoice_paid_status'): 
                    @if($sale['paid_status'] == 3)
                      <span class="increase-label label label-danger">@lang('admin/entries.unpaid_txt')</span>
                    @elseif($sale['paid_status'] == 2)
                      <span class="increase-label label label-warning">@lang('admin/entries.partial_paid_txt')</span>
                    @else
                      <span class="increase-label label label-success">@lang('admin/entries.paid_txt')</span>
                    @endif
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="col-sm-6 no-padding"><a href="{{ url('accounting/purchase/detail/'.$sale['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
            </div>
            <div class="col-sm-6 no-padding"><a href="{{ url('accounting/purchase/edit/'.$sale['id']) }}" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
          </div>
          
          </div>
          
         
        @endforeach
          <div class="col-xs-12">{!! $pages !!}</div>
        @else
          <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif
        
        
      </div>
      
    </div>
  </div>
</div>


<script type="text/javascript">
  $(function(){
    // bind change event to select
    $('#per_page').on('change', function () {
    var url = $(this).val(); // get selected value
    if (url) { // require a URL
    window.location = '?per_page='+url; // redirect
    }
    return false;
    });
  });

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".chosen").select2();  
  });

  
</script>
@endsection