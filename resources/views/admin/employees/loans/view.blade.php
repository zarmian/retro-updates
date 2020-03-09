@extends('layouts.app')


@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/loans.view_loan_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('employees') }}">@lang('employees/common.dashboard_heading')</a>  / 
        <a href="#" class="active">@lang('admin/loans.view_loan_txt')</a>
      </div>
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
    

      <form action="{{ url('/employees/loans/show', $loan['id']) }}" method="POST">
      <div class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
        <div class="panel">

        <div class="panel-body">

          
          {{-- Left From Colum --}}
          <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 ">
            <div class="top_content">
              <h3><b>@lang('admin/loans.view_loan_txt')</b></h3>
            </div>

            <div class="">

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <h4><b>@lang('admin/loans.employee_label'):</b> {{ $loan['employee_name'] }}</h4>
              </div>
              
              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                <b>@lang('admin/loans.title_txt'): </b>
                <p>{{ $loan['title'] }}</p>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                
                <b>@lang('admin/loans.date_txt'): </b>
                <p>{{ $loan['date'] }}</p>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                
                <b>@lang('admin/loans.adv_amount_txt'): </b>
                <p>{{ $loan['amount'] }}</p>
              </div>



              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <b>@lang('admin/loans.description_txt'):</b>
                <p>{{ $loan['description'] }}</p>
              </div>


              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for="">@lang('admin/loans.approved_txt'):</label>
                <textarea name="detail" id="detail" cols="30" rows="10" class="form-control2">{{ $loan['approved_description'] }}</textarea>
              </div>



              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group no-padding-left form-group">
                <label for="">@lang('admin/loans.status_txt'):</label>
                <select name="status" id="status" class="form-control1">
                  <option value="0" @if($loan['status'] == 0) selected="selected" @endif>@lang('admin/loans.pending_txt')</option>
                  <option value="1" @if($loan['status'] == 1) selected="selected" @endif>@lang('admin/loans.accpect_txt')</option>
                  <option value="2" @if($loan['status'] == 2) selected="selected" @endif>@lang('admin/loans.reject_txt')</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="type">@lang('admin/loans.type_label')</label>
                <select name="type" id="type" class="form-control1" onchange="getLoanStatement();">
                  <option value="" selected="selected">@lang('admin/employees.select_option')</option>
                  <option value="1">@lang('admin/loans.type_option_fix')</option>
                  <option value="2">@lang('admin/loans.type_option_tmp')</option>
                </select>
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="installment">@lang('admin/loans.installment_label')</label>
                <input type="text" name="installment" id="installment" required="required" class="form-control1">
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="">&nbsp;</label>
                <input type="submit" value="@lang('admin/common.button_submit')" class="btn btn-primary btn-block">
              </div>
              

            </div>
            
          </div>

          </div>


          {{-- Right Form Column --}}

          </div>


      </div>
      </form>
      
      
    </div>
  </div>
</div>

@endsection