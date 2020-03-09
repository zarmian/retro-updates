  <div class="modal-container">
    
    <form action="<?php echo e(url('/salary/paid',$employee['salary_id'])); ?>" id="update" method="POST" data-toggle="validator">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

    <input type="hidden" name="salary_id1" value="<?php echo e($employee['salary_id']); ?>" />
    <input type="hidden" name="employee_id1" value="<?php echo e($employee['employee_id']); ?>" />

    <div class="col-sm-11 col-xs-11 modal-body form-container clearfix">

    <div class="col-sm-11">
      <div class="alert alert-danger print-error-msg" style="display:none;">
        <ul></ul>
    </div>
    </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <h4><?php echo app('translator')->getFromJson('admin/employees.name_txt'); ?> <?php echo e($employee['employee_name']); ?> </h4>
        <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
      </div>
  
      <div class="col-sm-4 form-group">
        <label for="code"><?php echo app('translator')->getFromJson('admin/employees.code_txt'); ?></label>
        <input type="text" class="form-control1" name="code1" value="<?php echo e($code); ?>" required="required" />
      </div>

      <div class="col-sm-8 form-group">
        <label for=""><?php echo app('translator')->getFromJson('admin/common.date_txt'); ?></label>
        <input type="text" name="pdate" class="form-control1 datepicker" value="<?php echo e(date('Y-m-d', time())); ?>" />
      </div>

     

      <div class="col-sm-6 form-group">
        <label for="account"><?php echo app('translator')->getFromJson('admin/employees.pay_bank_account_txt'); ?></label>
        <select name="account1" id="account" class="form-control1 chosen-modal">
          <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
          <?php if(isset($accounts) && count($accounts) > 0): ?>
            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($account['id']); ?>"><?php echo e($account['code']); ?> - <?php echo e($account['name']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
      </div>

       <div class="col-sm-6 form-group">
        <label for="basic_salary"><?php echo app('translator')->getFromJson('admin/employees.basic_salary_label'); ?></label>
        <input type="text" class="form-control1" name="basic_salary1" value="<?php echo e($employee['basic_salary']); ?>" disabled="disabled"/>
      </div>


      <div class="col-sm-4 form-group">
        <label for="deduction"><?php echo app('translator')->getFromJson('admin/common.leaves_ded_txt'); ?></label>
        <input type="text" class="form-control1" name="leave_deduction1" id="leave_deduction1" value="<?php echo e($employee['leave_deduction']); ?>" disabled="disabled" />
      </div>

    
        <input type="hidden" class="form-control1" name="basic_payable1" id="basic_payable" value="<?php echo e($employee['payable']); ?>" />

      
      <div class="col-sm-4 form-group">
        <label for="deduction"><?php echo app('translator')->getFromJson('admin/employees.short_time_txt'); ?></label>
        <input type="text" class="form-control1" name="deduction1" id="deduction" value="<?php echo e($employee['deduction']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-4 form-group">
        <label for="overtime"><?php echo app('translator')->getFromJson('admin/employees.overtime_txt'); ?></label>
        <input type="text" class="form-control1" name="overtime1" id="overtime" value="<?php echo e($employee['overtime']); ?>" />
      </div>


      <div class="col-sm-3 form-group">
        <label for="paid_leaves"><?php echo app('translator')->getFromJson('admin/employees.paid_leaves_txt'); ?></label>
        <input type="text" class="form-control1" name="paid_leaves1" value="<?php echo e($employee['allowed_leaves']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="extra_leaves"><?php echo app('translator')->getFromJson('admin/employees.extra_leaves_txt'); ?></label>
        <input type="text" class="form-control1" name="extra_leaves1" value="<?php echo e($employee['tlt_leaves']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="working_days"><?php echo app('translator')->getFromJson('admin/employees.working_days_txt'); ?></label>
        <input type="text" class="form-control1" name="working_days1" value="<?php echo e($employee['total_month_working_days']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="short_days"><?php echo app('translator')->getFromJson('admin/employees.short_days_txt'); ?></label>
        <input type="text" class="form-control1" name="short_days1" value="<?php echo e($employee['total_working_days_spent']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="fixed_advance"><?php echo app('translator')->getFromJson('admin/employees.fixed_adv_txt'); ?></label>
        <input type="text" class="form-control1" name="fixed_advance1" value="<?php echo e($employee['tlt_loan_fixed']); ?>" disabled="disabled" />
      </div>


      <div class="col-sm-3 form-group">
        <label for="temp_advance"><?php echo app('translator')->getFromJson('admin/employees.tmp_adv_txt'); ?></label>
        <input type="text" class="form-control1" name="temp_advance1" value="<?php echo e($employee['tlt_loan_temp']); ?>" disabled="disabled" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="fix_installment"><?php echo app('translator')->getFromJson('admin/employees.fixed_adv_installment_txt'); ?></label>
        <input type="text" class="form-control1" name="fix_installment1" id="fix_installment" value="<?php echo e($employee['fix_advance']); ?>" onkeyup="fixedLoan()" />
      </div>

      <div class="col-sm-3 form-group">
        <label for="temp_installment"><?php echo app('translator')->getFromJson('admin/employees.temp_adv_installment_txt'); ?></label>
        <input type="text" class="form-control1" name="temp_installment1" id="temp_installment" value="<?php echo e($employee['temp_advance']); ?>" onkeyup="tempLoan()" />
      </div>

      <div class="col-sm-12 form-group">
        <label for="payable"><?php echo app('translator')->getFromJson('admin/employees.payable_amount_txt'); ?></label>
        <input type="text" class="form-control1" id="payable" name="payable1" value="<?php echo e($employee['net_amount']); ?>" disabled="disabled" />
      </div>


    
      <div class="col-sm-12 form-group">
        <label for=""></label>
        <button type="submit" id="paidSalary" class="btn btn-primary btn-block"><?php echo app('translator')->getFromJson('admin/employees.pay_btn_txt'); ?></button>
      </div>

    </div>
    <div class="col-sm-1 col-xs-1 no-padding-right pull-right">
    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    </form>



<script src="<?php echo e(asset('assets/chosen/chosen.jquery.js')); ?>"></script>
<script type="text/javascript">

  $(".datepicker").dateDropper();
  $(function() {
      $('.chosen-modal').chosen();
      $('.chosen-deselect-modal').chosen({ allow_single_deselect: true });
  });


  function fixedLoan(){

    var tlt;
    var original_amount = <?php echo e($employee['fix_advance']); ?>;
    var fix_installment = $("#fix_installment").val();
    var payable = <?php echo e($employee['payable']); ?>;
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
    var temp_advance = <?php echo e($employee['temp_advance']); ?>;
    var temp_installment = $("#temp_installment").val();
    var payable = <?php echo e($employee['payable']); ?>;
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


<script src="<?php echo e(asset('assets/js/jquery.form.min.js')); ?>"></script>
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



