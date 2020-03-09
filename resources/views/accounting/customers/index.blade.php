@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/customers.manage_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">@lang('admin/customers.manage_heading')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

      <div class="">
      
      <form action="" method="GET">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <input type="text" name="name" id="name" class="filter-date-input" placeholder="@lang('admin/accounting.customer_name')" value="{{ \Request::get('name') }}"  />
       </div>

       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <input type="text" name="email" id="email" class="filter-date-input"  placeholder="@lang('admin/accounting.customer_email')" value="{{ \Request::get('email') }}" />
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

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin"><a href="{{ url('accounting/customers/add') }}" class="plus">+</a></div>

          
        </div>



    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     

      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
      <div id="products" class="row list-group">
        @if(isset($customers) && count($customers) > 0)
        @foreach($customers as $customer)

        <div class="item col-md-6 col-sm-6 col-xs-12 col-lg-3 grid-group-item">
          <div class="thumbnail">
            <div class="row">
            <div class="item grid-group-item">
              <ul>
                 
                   <li class="">
                    <div class="caption">
                    <ul>
                      <li class="name">{{ $customer->first_name }} {{ $customer->last_name }}
                        <div class="dest"><b>@lang('admin/accounting.company_name'): </b> {{ $customer->company }} </div>
                        <div class="dest">@lang('admin/users.cell') {{ $customer->mobile }} </div>
                        <div class="dest">@lang('admin/users.email') {{ $customer->email }} </div>
                      </li>
                     </ul>
                     </div>
                     <div>
                        <a href="{{ url('accounting/customers/edit/'.$customer->id) }}" data-toggle="tooltip"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                        <a href="{{ url('accounting/customers/remove/'.$customer->id) }}" class="is_delete" data-toggle="tooltip"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

                        <a href="{{ url('accounting/customers/view/'.$customer->id) }}" data-toggle="tooltip"><span class="fa fa-list" aria-hidden="true"></span></a>

                     </div>
                    </li>
                    <li></li>
                </ul>
            </div>
            </div>
          </div>
        </div>


        
        @endforeach
          <div class="col-xs-12">{!! $customers->appends(\Input::except('page'))->render() !!}</div>
        @else
          <div class="col-xs-12"><div class="alert alert-warning">@lang('admin/messages.not_found')</div></div>
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
  });
</script>
@endsection