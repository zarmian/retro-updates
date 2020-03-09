  <div class="modal-container">
    
    <form action="{{ url('/salary/paid',$employee['salary_id']) }}" id="update" method="POST" data-toggle="validator">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <input type="hidden" name="salary_id1" value="{{ $employee['salary_id'] }}" />
    <input type="hidden" name="employee_id1" value="{{ $employee['employee_id'] }}" />

    <div class="col-sm-11 col-xs-11 modal-body form-container clearfix">

    <div class="col-sm-11">
      <div class="alert alert-danger print-error-msg" style="display:none;">
        <ul></ul>
    </div>
    </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <h4>@lang('admin/employees.name_txt') {{ $employee['employee_name'] }} </h4>
        <p>@lang('admin/employees.field_employee_text')</p>
      </div>
  
      <div class="col-sm-4 form-group">
        <label for="code">@lang('admin/employees.code_txt')</label>
        <input type="text" class="form-control1" name="code1" value="{{ $code }}" required="required" />
      </div>

      <div class="col-sm-8 form-group">
        <label for="">@lang('admin/common.date_txt')</label>
        <input type="text" name="pdate" class="form-control1 datepicker" value="{{ date('Y-m-d', time()) }}" />
      </div>

     

      <div class="col-sm-6 form-group">
        <label for="account">@lang('admin/employees.pay_bank_account_txt')</label>
        <select name="account1" id="account" class="form-control1 chosen-modal">
          <option value="">@lang('admin/common.select_option_txt')</option>
          @if(isset($accounts) && count($accounts) > 0)
            @foreach($accounts as $account)
              <option value="{{ $account['id'] }}">{{ $account['code'] }} - {{ $account['name'] }}</option>
            @endforeach
          @endif
        </select>
      </div>

       <div class="col-sm-6 form-group">
        <label for="basic_salary">@lang('admin/employees.basic_salary_label')</label>
        <input type="text" class="form-control1" name="basic_salary1" value="{{ $employee['basic_salary'] }}" disabled="disabled"/>
      </div>


      <div class="col-sm-4 form-group">
        <label for="deduction">@lang('admin/common.leaves_ded_txt')</label>
        <input type="text" class="form-control1" name="leave_deduction1" id="leave_deduction1" value="{{ $employee['leave_deduction'] }}" disabled="disabled" />
      </div>

    
        <input type="hidden" class="form-control1" name="basic_payable1" id="basic_payable" value="{{ $employee['payable'] }}" />

      
      <div class="col-sm-4 form-group">
        <label for="deduction">@lang('admin/employees.short_time_txt')</label>
        <input type="text" class="form-control1" name="deduction1" id="deduction" value="{{ $employee['deduction'] }}" disabled="disabled" />
      </div>

      <div class="col-sm-4 form-group">
        <label for="overtime">@lang('admin/employees.overtime_txt')</label>
        <input type="text" class="form-control1" name="overtime1" id="overtime" value="{{ $employee['overtime'] }}" />
      </div>


      <div class="col-sm-3 form-group">
        <label for="paid_leaves">@lang('admin/employees.paid_leaves_txt')</label>
        <input type="text" class="form-control1" name="paid_leaves1" value="{{ $employee['allowed_leaves'] }}" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="extra_leaves">@lang('admin/employees.extra_leaves_txt')</label>
        <input type="text" class="form-control1" name="extra_leaves1" value="{{ $employee['tlt_leaves'] }}" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="working_days">@lang('admin/employees.working_days_txt')</label>
        <input type="text" class="form-control1" name="working_days1" value="{{ $employee['total_month_working_days']}}" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="short_days">@lang('admin/employees.short_days_txt')</label>
        <input type="text" class="form-control1" name="short_days1" value="{{ $employee['total_working_days_spent'] }}" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="fixed_advance">@lang('admin/employees.fixed_adv_txt')</label>
        <input type="text" class="form-control1" name="fixed_advance1" value="{{ $employee['tlt_loan_fixed'] }}" disabled="disabled" />
      </div>


      <div class="col-sm-3 form-group">
        <label for="temp_advance">@lang('admin/employees.tmp_adv_txt')</label>
        <input type="text" class="form-control1" name="temp_advance1" value="{{ $employee['tlt_loan_temp'] }}" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="fix_installment">@lang('admin/employees.fixed_adv_installment_txt')</label>
        <input type="text" class="form-control1" name="fix_installment1" id="fix_installment" value="{{ $employee['fix_advance'] }}" onkeyup="fixedLoan()" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="temp_installment">@lang('admin/employees.temp_adv_installment_txt')</label>
        <input type="text" class="form-control1" name="temp_installment1" id="temp_installment" value="{{ $employee['temp_advance'] }}" onkeyup="tempLoan()" />
      </div>

      <div class="col-sm-12 form-group">
        <label for="payable">@lang('admin/employees.payable_amount_txt')</label>
        <input type="text" class="form-control1" id="payable" name="payable1" value="{{ $employee['net_amount'] }}" disabled="disabled" />
      </div>


    
      <div class="col-sm-12 form-group">
        <label for=""></label>
        <button type="submit" id="paidSalary" class="btn btn-primary btn-block">@lang('admin/employees.pay_btn_txt')</button>
      </div>

    </div>
    <div class="col-sm-1 col-xs-1 no-padding-right pull-right">
    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    </form>



<script src="{{ asset('assets/chosen/chosen.jquery.js')}}"></script>
<script type="text/javascript">

  $(".datepicker").dateDropper();
  $(function() {
      $('.chosen-modal').chosen();
      $('.chosen-deselect-modal').chosen({ allow_single_deselect: true });
  });


  function fixedLoan(){

    var tlt;
    var original_amount = {{ $employee['fix_advance'] }};
    var fix_installment = $("#fix_installment").val();
    var payable = {{ $employee['payable'] }};
    fix_installment = parseFloat(fix_installment, 10);

    if (isNaN(fix_installment)) { fix_installment = 0; }

    if(fix_installment >= original_amount){
      tlt = parseFloat(payable - fix_installment);
    }else{
      tlt = parseFloat(payable - fix_installment);
    }

    $("#payable").val(tlt);
    
  }

  function tempLoan(){
    
    var tlt;
    var temp_advance = {{ $employee['temp_advance'] }};
    var temp_installment = $("#temp_installment").val();
    var payable = {{ $employee['payable'] }};
    temp_installment = parseFloat(temp_installment, 10);

    if (isNaN(temp_installment)) { temp_installment = 0; }

    if(temp_installment >= temp_advance){
      tlt = parseFloat(payable - temp_installment);
    }else{
      tlt = parseFloat(payable - temp_installment);
    }

    $("#payable").val(tlt);
  }

</script>


<script src="{{ asset('assets/js/jquery.form.min.js') }}"></script>
<script type="text/javascript">

$(document).ready(function() {
    $('form[data-toggle="validator"]').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                code: {
                    validators: {
                        notEmpty: {
                            message: '',
                        }
                    }
                },
                account: {
                    validators: {
                        notEmpty: {
                            message: '',
                        }
                    }
                }

            }
        });
}).on('success.form.bv', function(e){

  e.preventDefault();

  $("#paidSalary").attr('disabled', true);

  var $form = $(e.target),
  fv    = $(e.target).data('bootstrapValidator');

  var sr = $form.serialize();

  $form.ajaxSubmit({
      url: $form.attr('action'),
      dataType: 'json',
      success: function(responseText, statusText, xhr, $form) {

        if($.isEmptyObject(responseText.error)){
          $('.modal').modal('hide');

          html = '<div class="paid">';
            html += '<div class="col-lg-6 no-padding"><a href="" class="btn btn-block border-radius-none sp-btn bg-color-skyblue"><i class="fa fa-eye" aria-hidden="true"></i></a></div>';

            html += '<div class="col-lg-6 no-padding"><a href="" class="btn btn-block border-radius-none sp-btn bg-color-pink"><i class="fa fa-print" aria-hidden="true"></i></a></div>';
          html += '</div>';

          $('.unpaid_'+responseText.employee_id).html(html);
        }else{
          printErrorMsg(responseText.error);
        }
      }
    });

  

  return false;
});


function printErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
  });
}


</script>

</div>



