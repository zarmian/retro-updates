  <div class="modal-container">
    
    <form action="{{ url('accounting/purchase/payment') }}" id="update" method="POST" data-toggle="validator">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <input type="hidden" name="sale_id" value="{{ $sale['id'] }}" />
    <input type="hidden" name="customer_id" value="{{ $sale['customer_id'] }}" />

    <div class="col-sm-11 col-xs-11 modal-body form-container clearfix">

    <div class="col-sm-11">
      <div class="alert alert-danger print-error-msg" style="display:none;">
        <ul></ul>
    </div>
    </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <h4>@lang('admin/entries.add_payment_txt')  </h4>
        <p>@lang('admin/users.field_employee_text')</p>
      </div>

      <div class="col-sm-6 col-xs-5 col-md-6 col-lg-6 no-padding-left">
        <h4>@lang('admin/entries.vendor_label'): {{ $sale['customer_name'] }} </h4>
      </div>

      <div class="col-sm-6 col-xs-5 col-md-6 col-lg-6 no-padding-right">
        <h4>@lang('admin/entries.voucher_number_txt'): {{ $sale['inv_no'] }} </h4>
      </div>

      <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 no-padding">
        <h4 class="fontsize13bold">@lang('admin/entries.invoice_sub_total_txt'): {{ $sale['sub_total'] }} <span class="currency">{{ $currency }}</span></h4>
      </div>

      <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 no-padding">
        <h4 class="fontsize13bold">@lang('admin/entries.invoice_discount_txt'): {{ $sale['discount'] }} <span class="currency">{{ $currency }}</span></h4>
      </div>

      <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 no-padding">
        <h4 class="fontsize13bold">@lang('admin/entries.invoice_total_txt'): {{ $sale['total'] }} <span class="currency">{{ $currency }}</span></h4>
      </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group">
        <hr>
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="">@lang('admin/entries.date_label')</label>
        <input type="text" name="pdate" class="form-control1 datepicker" value="{{ date('Y-m-d', time()) }}" required="required" />
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="payment_no">@lang('admin/entries.pay_serial_no_txt')</label>
        <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">PE</span>
          <input type="text" name="payment_no" class="form-control1" value="{{ $payment_number }}" required="required" readonly="readonly" style="border-bottom-left-radius: 0px;border-top-left-radius: 0px;" />
        </div>
        
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="reference">@lang('admin/entries.pay_via_txt')</label>
        <input type="text" name="reference" class="form-control1" value="" />
      </div>


      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="pay_amount">@lang('admin/entries.pay_amount_txt')</label>
        <input type="text" class="form-control1" name="pay_amount" id="pay_amount" value="" placeholder="0.00" required="required" data-bv-lessthan="true" data-bv-lessthan-value="{{ $sale['tlt_amt'] }}" data-bv-lessthan-message="The value must be less than or equal to {{ $sale['tlt_amt'] }}" />
      </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group">
        <label for="account_id">@lang('admin/entries.payment_bank_label')</label>
        <select name="account_id" id="account_id" class="form-control1 chosen" required="required">
          <option value=""> @lang('admin/common.select_option_txt') </option>
          @if(isset($accounts) && count($accounts) > 0)
            @foreach($accounts as $account)
              <option value="{{ $account->id }}">{{ $account->name }} </option>
            @endforeach
          @endif
        </select>
      </div>



      <div class="col-sm-12 form-group">
        <label for="description">@lang('admin/entries.detail_txt')</label>
        <textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="@lang('admin/entries.detail_txt')"></textarea>
      </div>

      @if(isset($sale['tlt_amt']) && $sale['tlt_amt'] <> 0)

      <div class="col-sm-12 form-group">
        <label for=""></label>
        <button type="submit" id="paidInvoice" class="btn btn-primary btn-block" disabled="disabled">@lang('admin/common.pay_button_txt')</button>
      </div>

      @endif

    </div>
    <div class="col-sm-1 col-xs-1 no-padding-right pull-right">
    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    </form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<script>

$(document).ready(function() {

    $('form[data-toggle="validator"]').bootstrapValidator({
        framework: 'bootstrap',
        button: {
            selector: '#paidInvoice',
            disabled: 'disabled'
        },
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          pay_amount: {
            validators: {
              numeric: {
                message: 'The value is not a number',
                thousandsSeparator: '',
                decimalSeparator: '.'
              }
            }
          }
        }
    }).on('success.form.bv', function(e) {

      e.preventDefault();

      $('#paidInvoice').button('loading');

      var $form = $(e.target),
      fv    = $(e.target).data('bootstrapValidator');

      var sr = $form.serialize();


      $form.ajaxSubmit({
        url: $form.attr('action'),
        dataType: 'json',
        success: function(responseText, statusText, xhr, $form) {

     
          var id = responseText.success.id;

          if($.isEmptyObject(responseText.error)){
            $('div#PaymentsViews').load(site.base_url + '/accounting/purchase/detail/'+ id +' div#PaymentsViews');
            $('table#total_cal').load(site.base_url + '/accounting/purchase/detail/'+ id +' table#total_cal');

            $('div#paid_status').load(site.base_url + '/accounting/purchase/detail/'+ id +' div#paid_status');

            
            $('.modal').modal('hide');

            swal('@lang('admin/entries.payment_success')', '@lang('admin/entries.payment_added_msg')', 'success').catch(swal.noop);
          }else{
            $('#paidInvoice').button('reset');
            printErrorMsg(responseText.error);
          }
        }
      });

      return false;


    });
});
</script>



    <script type="text/javascript">
      $(".chosen").chosen();
    </script>

    <script type="text/javascript">

      function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
          $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
      }

      $(".datepicker").dateDropper();
      
    </script>
    
  </div>