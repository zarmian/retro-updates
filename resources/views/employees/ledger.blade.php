@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

<style type="text/css">

@media print{a[href]:after{content:none}}
</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.ledger_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  /
        <a href="#" class="active">@lang('admin/employees.ledger_txt')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search hidden-print">
  <div class="container">
    <div class="row">


    <form action="{{ url('/employee/ledger') }}" method="get" id="ledger-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($to) && $to <> ""){{date('m-d-Y', strtotime($to) )}}@else{{date('m-d-Y', strtotime('last month'))}}@endif" />
           </div>

           <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($from) && $from <> ""){{date('m-d-Y', strtotime($from) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>
        
         
          <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">
            <!-- select option -->
            <select name="type" id="type" class="chosen form-control1">
              <option value="">@lang('admin/common.select_option_txt')</option>
              <option value="1" @if(isset($type) && $type == 1) selected="selected" @endif >Salary</option>
              <option value="2" @if(isset($type) && $type == 2) selected="selected" @endif >Loan</option>
              
            </select>
            <!-- select option -->
          </div>

       

        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-2 col-sm-6 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="@lang('admin/common.find_btn_txt')" />
          </div>
        </div>

      </div>

       
        </form>
    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif

      @if(Session::has('error'))
        <div class="col-lg-12"><div class="alert alert-danger">{{ Session::get('error') }}</div></div>
      @endif

      @if(isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          </div>
        @endif
      
      
      <div id="products" class="row list-group">

      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">{!! $html !!}</div>
      </div>


        
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('scripts')


<script type="text/javascript">

  // $(document).ready(function($) {
  //   $('#ledger-form').bootstrapValidator('validate');
  // });
  $('.datedropper').dateDropper();
  $(".chosen").select2();
</script>
@endsection