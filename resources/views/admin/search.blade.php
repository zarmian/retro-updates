@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/common.search_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">@lang('admin/common.search_txt')</a></div>
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
      
      <div id="products" class="row list-group">

        @if(isset($employees) && count($employees) > 0)
          <h4>@lang('admin/employees.employees_search_txt')</h4>
          @foreach($employees as $employee)

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li>@lang('admin/employees.employee_code_label'): <b> {{ $employee['employee_code'] }} </b></li>
                    <li style="width: 200px;">@lang('admin/employees.full_name_txt'): <b>{{ $employee['full_name'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.email_label'): <b>{{ $employee['email'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.mobile_label'): <b>{{ $employee['mobile'] }}</b></li>
                    <li style="">@lang('admin/employees.department_label'): <b>{{ $employee['department'] }}</b></li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="{{ url('/employees/view/'.$employee['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          @endforeach
        @endif

        

        @if(isset($customers) && count($customers) > 0)
          <div class="col-sm-12 no-padding"><h4>@lang('admin/common.sales_search_txt')</h4></div>
          
          @foreach($customers as $customer)

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li style="width: 100px;">@lang('admin/employees.employee_code_label'): <b> {{ $customer['code'] }} </b></li>
                    <li style="width: 200px;">@lang('admin/employees.full_name_txt'): <b>{{ $customer['full_name'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.email_label'): <b>{{ $customer['email'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.mobile_label'): <b>{{ $customer['mobile'] }}</b></li>
                    <li style="">@lang('admin/accounting.total_txt'): <b>{{ $customer['total_amount'] }} {{ $currency }}</b></li>
                    <li style="">@lang('admin/accounting.paid_txt'): <b>{{ $customer['total_paid'] }} {{ $currency }}</b></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="{{ url('accounting/customers/view/'.$customer['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          @endforeach
        @endif


        @if(isset($vendors) && count($vendors) > 0)
          <div class="col-sm-12 no-padding"><h4>@lang('admin/common.vendors_search_txt')</h4></div>
          
          @foreach($vendors as $vendor)

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li style="width: 100px;">@lang('admin/employees.employee_code_label'): <b> {{ $vendor['code'] }} </b></li>
                    <li style="width: 200px;">@lang('admin/employees.full_name_txt'): <b>{{ $vendor['full_name'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.email_label'): <b>{{ $vendor['email'] }}</b></li>
                    <li style="width: 200px;">@lang('admin/employees.mobile_label'): <b>{{ $vendor['mobile'] }}</b></li>
                    <li style="">@lang('admin/accounting.total_txt'): <b>{{ $vendor['total_amount'] }} {{ $currency }}</b></li>
                    <li style="">@lang('admin/accounting.paid_txt'): <b>{{ $vendor['total_paid'] }} {{ $currency }}</b></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="{{ url('accounting/vendors/view/'.$vendor['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          @endforeach
        @endif
        

        @if(isset($empty) && $empty <> "")
          <div class="alert alert-danger">{{ $empty }}</div>
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