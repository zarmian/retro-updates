@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Payment Recieved Voucher</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">Payment Recieved Voucher</a></div>
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
        <input type="text" name="code" id="code" class="filter-date-input" placeholder="PR Code" value="{{ \Request::get('code') }}"  />
       </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <input type="text" name="date" id="date" class="filter-date-input datepicker" data-init-set="false" placeholder="" value="{{ \Request::get('date') }}"  />
       </div>

    
       <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 plus-margin">
        <button type="submit" class="search"><i class="fa fa-search" aria-hidden="true"></i></button>
       </div>
      </form>

    
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <a href="{{ url('accounting/payments/received/add') }}" class="plus">+</a></div>


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
        @if(isset($journals) && count($journals) > 0)
        @foreach($journals as $journal)

          <div class="list-block clearfix">
            <div class="col-lg-11 col-sm-12 col-xs-12 list-content-row">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li>@lang('admin/entries.entry_no_txt'): <b> {{ $journal['code'] }} </b></li>
                  <li style="width: 282px;">@lang('admin/entries.date_label'): <b>{{ $journal['date'] }}</b></li>
                  <li style="width: 282px;">@lang('admin/entries.detail_txt'): <b>{{ $journal['description'] }}</b></li>
                  <li>@lang('admin/entries.tlt_txt'): <b> {{ $journal['amount'] }} </b></li>
                  <li>
                    
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-12 col-xs-12 no-padding">
           
              <div class="col-sm-6 no-padding"><a href="{{ url('accounting/payments/received/detail/'.$journal['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
              <div class="col-sm-6 no-padding"><a href="{{ url('accounting/payments/received/edit/'.$journal['id']) }}" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
            
          </div>
          </div>

          
         



        
        @endforeach
          <div class="col-xs-12">
            {!! $pages !!}
          </div>
        @else
          <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif
        
        
      </div>
      
      
      
    </div>
  </div>
</div>


<script>
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

    $('.chosen').select2();
  });

  $('.datepicker').dateDropper();
</script>
@endsection