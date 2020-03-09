@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Update Recieve Voucher</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="{{ url('accounting/payments/received') }}">Payment Recieved Voucher
</a>  / 
        <a href="#" class="active">Update Recieve Voucher</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        @if(Session::has('msg'))
          <div class="alert alert-success">
            {{ Session::get('msg') }}
          </div>
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

         <form data-toggle="validator" role="form" action="{{ url('accounting/payments/received/edit', $journal['id']) }}" method="POST" enctype="multipart/form-data" class="erp-form erp-ac-transaction-form">
         
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form_container">

          
          {{-- Left From Colum --}}
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3>Update Recieve Payment Voucher</h3>
              <p>@lang('admin/users.field_employee_text')</p>
            </div>

            <div class="form_container">

                

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="invoice_no" class="input_label">PR Code*</label>
                  
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">PR</span>
                    <input type="text" name="code" id="code" class="form-control1" placeholder="@lang('admin/entries.entry_code_txt')*" value="{{ $journal['code'] }}" required="required" readonly="readonly" style="border-bottom-left-radius: 0px;border-top-left-radius: 0px; background: #e0e0e0;" />
                  </div>
                  
                </div>

                 <div class="col-md-2 col-sm-2 col-lg-2 col-xs-2 form-group">
                  <label for="code" class="input_label">@lang('admin/entries.reference_label')</label>
                  <input type="text" name="code" id="code" class="form-control1" placeholder="@lang('admin/entries.reference_label')" value="{{ $journal['reference'] }}" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="date" class="input_label">@lang('admin/entries.date_label')*</label>
                  <input type="text" name="date" id="date" class="form-control1 datepicker" placeholder="@lang('admin/entries.date_label')" required="required" data-default-date="{{ $journal['date']  }}" data-format="m/d/Y" />
                </div>

                <div class="col-sm-12">
                  <table class="erp-table erp-ac-transaction-table journal-table">
                    <thead>
                        <tr>
                            <th class="col-chart">@lang('admin/entries.account_label')</th>
                            <th class="col-desc">@lang('admin/entries.account_description_label')</th>
                            <th class="col-amount">@lang('admin/entries.debit_txt')</th>
                            <th class="col-amount">@lang('admin/entries.credit_txt')</th>
                            <th class="col-action">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                    <input type="hidden" value="0" name="id" id="id"> 

                    @if(isset($journal['details']) && count($journal['details']) > 0)
                      @foreach($journal['details'] as $detail)

                        <tr>
                          <td class="col-chart" width="250" height="50">

                            @if(isset($detail) && $detail['types'] == 17)
                              
                              <select name="account_type[]" id="account_type" class="chosen form-control1" tabindex="2"  required="required">
                              @if(isset($accounts) && count($accounts) > 0)
    
                              @foreach($accounts as $account)

                                @if($detail['account_id'] == $account['id'])
                                  <option value="{{ $account['id'] }}" selected="selected">{{ $account['code'] }} -- {{ $account['name'] }}</option>
                                  @else
                                    <option value="{{ $account['id'] }}">{{ $account['code'] }} -- {{ $account['name'] }}</option>
                                  @endif
                                @endforeach
                              @endif
                            </select>


                            @else

                              <select name="account_type[]" id="account_type" class="chosen form-control1" tabindex="2"  required="required">
                                @if(isset($banks) && count($banks) > 0)
      
                                @foreach($banks as $bank)

                                  @if($detail['account_id'] == $bank['id'])
                                    <option value="{{ $bank['id'] }}" selected="selected">{{ $bank['code'] }} -- {{ $bank['name'] }}</option>
                                    @else
                                      <option value="{{ $bank['id'] }}">{{ $bank['code'] }} -- {{ $bank['name'] }}</option>
                                    @endif
                                  @endforeach
                                @endif
                              </select>
                              
                            @endif

                           

                          
                          </td>

                          <td class="col-desc" width="300">
                              <input type="text" name="line_desc[]" id="line_desc[]" class="form-control1" value="{{ $detail['description'] }}" />
                          </td>

                          <td class="col-amount">
                              <input type="text" name="line_debit[]" id="line_debit[]" data-bv-callback="true" data-bv-callback-message="Debit / Credit not equal" data-bv-callback-callback="checkEqual" class="line_debit form-control1" placeholder="0.00" value="{{ $detail['debit'] }}" />
                          </td>

                          <td class="col-amount">
                            <input type="text" name="line_credit[]" id="line_credit[]" data-bv-callback="true" data-bv-callback-message="Debit / Credit not equal" data-bv-callback-callback="checkEqual" class="line_credit form-control1" placeholder="0.00" value="{{ $detail['credit'] }}" />
                          </td>

                          <td class="col-action">
                              <a href="" class="remove-line"><span class="fa fa-trash dashicons-trash"></span></a>
                          </td>

                          <input type="hidden" value="0" name="journal_id[]" id="journal_id[]">
                          <input type="hidden" value="0" name="item_id[]" id="item_id[]">

                        </tr>
                        @endforeach
                      @endif

                  
                            
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><a href="javascript:void(0)" class="button add-line">+ Add Line</a></th>
                            <th class="align-right">Total</th>
                            <th class="col-amount">
                                <input type="text" name="debit_total" class="debit-price-total form-control1" readonly="" value="{{ $journal['tlt_dr'] }}">
                            </th>
                            <th class="col-amount">
                                <input type="text" name="credit_total" class="credit-price-total form-control1" readonly="" value="{{ $journal['tlt_cr'] }}">
                            </th>

                        </tr>
                        <tr>

                            <th colspan="2" class="align-right"></th>
                            <th colspan="2" class="col-amount">
                                <div class="valid erp-ac-journal-diff">
                                    The amount of debit and credit are not same                        </div>
                            </th>
                        </tr>

                        <tr>
                          <td height="40" colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="@lang('admin/entries.reference_textarea_label')">{{ $journal['description'] }}</textarea>
                </div>

                


              </div>
              
            </div>


            {{-- Right Form Column --}}

            

            <div class="col-sm-10 col-sm-offset-2">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">@lang('admin/users.submit_button')</button>
              {{-- <button type="submit" class="btn btn-primary btn-step mbtn btn-block" id="next"></button> --}}
            </div>
            </div>
    
            </div>


        </form>


      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
$(".chosen").select2();
</script>

<script>

function checkEqual(value, validator) {
    

    var tables = $('.journal-table');
    var debit_totals = credit_totals = 0;

    tables.find('tbody > tr').each(function(index, el) {
      var rows    = $(el);
      var debits  = ( rows.find('input.line_debit').val() ) || '0';
      var credits = ( rows.find('input.line_credit').val() ) || '0';

      debit_totals +=  parseFloat( debits );
      credit_totals += parseFloat( credits );

    });

    var diffs = Math.abs( credit_totals - debit_totals );
    //console.log(diffs);
    if ( diffs === 0 ) {
      
      $("form[data-toggle="validator"]").data('bootstrapValidator').resetForm();

      validator.updateStatus('line_debit[]', 'VALID');
      validator.updateStatus('line_credit[]', 'VALID');
      return true;
     
    }
    
    return false;
    
};

$(document).ready(function() {

    $('form[data-toggle="validator"]').bootstrapValidator();

  });
</script>

  <script type="text/javascript">
   
    $('.datepicker').dateDropper();
  </script>


@endsection