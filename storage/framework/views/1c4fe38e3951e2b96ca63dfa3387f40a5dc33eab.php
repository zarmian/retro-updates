

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row"> 
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/common.setting_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="javascript:void();" class="active"><?php echo app('translator')->getFromJson('admin/common.setting_heading'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container mainwrapper margin-top">
  <div class="row">

    <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
      
      <?php if(Session::has('msg')): ?>
          <div class="alert alert-success">
            <?php echo e(Session::get('msg')); ?>

          </div>
          <?php endif; ?>
            
          <?php if(isset($errors) && count($errors) > 0): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            </div>
          <?php endif; ?>
    </div>

    <form action="<?php echo e(url('/setting')); ?>" data-toggle="validator"] method="POST" enctype="multipart/form-data">



    <div class="margin-top">
      
      <div class="col-sm-6">
        
        <div class="top_content">
          <h3><?php echo app('translator')->getFromJson('admin/common.general_setting_heading'); ?></h3>
          <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.company_name_label'); ?>*</label>
          <input type="text" name="st[BUSINESS_NAME]" value="<?php echo e($BUSINESS_NAME); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.ntn_label'); ?></label>
          <input type="text" name="st[NTN_NO]" value="<?php echo e($NTN_NO); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.email_label'); ?>*</label>
          <input type="text" name="st[BUSINESS_EMAIL]" value="<?php echo e($BUSINESS_EMAIL); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.website_label'); ?></label>
          <input type="text" name="st[BUSINESS_WEBSITE]" value="<?php echo e($BUSINESS_WEBSITE); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.phone_label'); ?></label>
          <input type="text" name="st[BUSINESS_PHONE]" value="<?php echo e($BUSINESS_PHONE); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.mobile_label'); ?></label>
          <input type="text" name="st[BUSINESS_MOBILE]" value="<?php echo e($BUSINESS_MOBILE); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.address_label'); ?></label>
          <textarea name="st[BUSINESS_ADDRESS]" id="" cols="30" rows="10" class="form-control2"><?php echo $BUSINESS_ADDRESS; ?></textarea>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.country_label'); ?></label>
          <select name="st[BUSINESS_COUNTRY]" id="" class="form-control1 chosen">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <?php if(isset($countries) && count($countries) > 0): ?>
              <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($country->id == $BUSINESS_COUNTRY): ?>
                  <option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->country_name); ?></option>
                <?php else: ?>
                  <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.email_enable_label'); ?></label>
          <select name="st[ENABLE_EMAIL]" id="" class="form-control1">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <option value="true" <?php if($ENABLE_EMAIL == 'true'): ?> selected="selected" <?php endif; ?>>YES</option>
            <option value="false" <?php if($ENABLE_EMAIL == 'false'): ?> selected="selected" <?php endif; ?>>NO</option>
          </select>
        </div>


        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.off_days_label'); ?></label>
          <select name="st[OFFDAYS][]" id="" data-placeholder="<?php echo app('translator')->getFromJson('admin/common.select_off_days_txt'); ?>" multiple class="form-control1 chosen" tabindex="4">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <?php if(isset($days) && count($days) > 0): ?>
              <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(in_array($value, $OFFDAYS)): ?>
                <option value="<?php echo e($value); ?>" selected="selected"><?php echo e($value); ?></option>
              <?php else: ?>
                <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
              <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.timezone_txt'); ?></label>
          <select name="st[TIMEZONES]" id="" class="form-control1 chosen">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <?php if(isset($timezones) && count($timezones) > 0): ?>
              <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($timezone->zone_name == $TIMEZONES): ?>
                <option value="<?php echo e($timezone->zone_name); ?>" selected="selected"><?php echo e($timezone->zone_name); ?></option>
              <?php else: ?>
                <option value="<?php echo e($timezone->zone_name); ?>"><?php echo e($timezone->zone_name); ?></option>
              <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
        </div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label"></label>

          <div style="width: 200px;">
            <div class="slim" data-service="<?php echo e(url('/setting/logo')); ?>">
            <?php if($BUSINESS_LOGO_IMAGE <> NULL && file_exists(storage_path().'/app/logo/'.$BUSINESS_LOGO_IMAGE)): ?>
                    <img src="<?php echo e(asset('storage/app/logo/'.$BUSINESS_LOGO_IMAGE)); ?>" alt="">
                   <?php endif; ?>
              <input type="file" name="logo">
            </div>
            

          </div>
          
        </div>

        <div class="form-group col-sm-3">
          <label for="" class="input_label"></label>
          <button type="submit" class="btn btn-danger btn-block new-btn"><?php echo app('translator')->getFromJson('admin/common.save_setting_btn'); ?></button>
        </div>

      </div>
      <div class="col-sm-6">
        
        <div class="top_content">
          <h3><?php echo app('translator')->getFromJson('admin/common.finance_setting_heading'); ?></h3>
          <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
        </div>

       

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.default_currency_label'); ?></label>
          <select name="st[DEFAULT_CURRENCY]" id="" class="form-control1 chosen">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <?php if(isset($countries) && count($countries) > 0): ?>
              <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($country->id == $DEFAULT_CURRENCY): ?>
                <option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->currency_code); ?> - <?php echo e($country->country_name); ?></option>
              <?php else: ?>
                <option value="<?php echo e($country->id); ?>"><?php echo e($country->currency_code); ?> - <?php echo e($country->country_name); ?></option>
              <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
          </select>
        </div>



        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.thousand_sep_label'); ?></label>
          <input type="text" name="st[THOUSAND_SEPRETOR]" value="<?php echo e($THOUSAND_SEPRETOR); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.decimal_label'); ?></label>
          <input type="text" name="st[DECIMAL_SEPRETOR]" value="<?php echo e($DECIMAL_SEPRETOR); ?>" class="form-control1">
        </div>

        <div class="form-group col-sm-6">
          <label for="" class="input_label">TAX</label>
          <select name="st[VAT_TAX]" id="" class="form-control1 chosen">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
              
                <option value="1" <?php if($VAT_TAX == '1'): ?> selected="selected" <?php endif; ?>>Enable</option>
                <option value="0" <?php if($VAT_TAX == '0'): ?> selected="selected" <?php endif; ?>>Disable</option>
              
          </select>
        </div>


        <div class="col-sm-12"><div class="top_content">
          <h3><?php echo app('translator')->getFromJson('admin/common.email_setting_heading'); ?></h3>
          <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
        </div></div>

        <div class="form-group col-sm-12">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_name_label'); ?></label>
          <select name="st[MAIL_BY]" id="mail_by" class="form-control1 chosen">
            <option value=""><?php echo app('translator')->getFromJson('admin/common.select_option_txt'); ?></option>
            <option value="gmail" <?php if($MAIL_BY == 'gmail'): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.gmail_option_txt'); ?></option>
            <option value="webmail" <?php if($MAIL_BY == 'webmail'): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.webmail_option_txt'); ?></option>
          </select>
        </div>


        <div class="mblock" id="gmail" <?php if($MAIL_BY != 'gmail'): ?> style="display:none" <?php endif; ?>>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_driver'); ?></label>
            <input type="text" name="st[GMAIL_DRIVER]" value="<?php echo e($GMAIL_DRIVER); ?>" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_host'); ?></label>
            <input type="text" name="st[GMAIL_HOST]" value="<?php echo e($GMAIL_HOST); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_username'); ?></label>
            <input type="text" name="st[GMAIL_USERNAME]" value="<?php echo e($GMAIL_USERNAME); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_password'); ?></label>
            <input type="text" name="st[GMAIL_PASSWORD]" value="<?php echo e($GMAIL_PASSWORD); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_port'); ?></label>
            <input type="text" name="st[GMAIL_PORT]" value="<?php echo e($GMAIL_PORT); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_encryption'); ?></label>
            <input type="text" name="st[GMAIL_ENCRYPTION]" value="<?php echo e($GMAIL_ENCRYPTION); ?>" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_email_label'); ?></label>
            <input type="text" name="st[GMAIL_FROM_ADDRESS]" value="<?php echo e($GMAIL_FROM_ADDRESS); ?>" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_name_label'); ?></label>
            <input type="text" name="st[GMAIL_FROM_NAME]" value="<?php echo e($GMAIL_FROM_NAME); ?>" class="form-control1">
          </div>
        </div>

        <div class="mblock" id="webmail" <?php if($MAIL_BY != 'webmail'): ?> style="display:none" <?php endif; ?>>
            <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_driver'); ?></label>
            <input type="text" name="st[MAIL_DRIVER]" value="<?php echo e($MAIL_DRIVER); ?>" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_host'); ?></label>
            <input type="text" name="st[MAIL_HOST]" value="<?php echo e($MAIL_HOST); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_username'); ?></label>
            <input type="text" name="st[MAIL_USERNAME]" value="<?php echo e($MAIL_USERNAME); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_password'); ?></label>
            <input type="text" name="st[MAIL_PASSWORD]" value="<?php echo e($MAIL_PASSWORD); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_port'); ?></label>
            <input type="text" name="st[MAIL_PORT]" value="<?php echo e($MAIL_PORT); ?>" class="form-control1">
          </div>

          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.gmail_encryption'); ?></label>
            <input type="text" name="st[MAIL_ENCRYPTION]" value="<?php echo e($MAIL_ENCRYPTION); ?>" class="form-control1">
          </div>
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_email_label'); ?></label>
            <input type="text" name="st[MAIL_FROM_ADDRESS]" value="<?php echo e($MAIL_FROM_ADDRESS); ?>" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_name_label'); ?></label>
            <input type="text" name="st[MAIL_FROM_NAME]" value="<?php echo e($MAIL_FROM_NAME); ?>" class="form-control1">
          </div>
        </div>


        <div class="mblock" id="mail" <?php if($MAIL_BY != 'mail'): ?> style="display:none" <?php endif; ?>>
           
          
          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_email_label'); ?></label>
            <input type="text" name="st[EMAIL_FROM_ADDRESS]" value="<?php echo e($EMAIL_FROM_ADDRESS); ?>" class="form-control1">
          </div>


          <div class="form-group col-sm-6">
            <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.from_name_label'); ?></label>
            <input type="text" name="st[EMAIL_FROM_NAME]" value="<?php echo e($EMAIL_FROM_NAME); ?>" class="form-control1">
          </div>
        </div>

        


        <div class="form-group col-sm-12 hidden">
          <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/common.invoice_voucher_label'); ?></label>
          <textarea name="st[INVOICE_VOUCHER_TERMS]" id="st[INVOICE_VOUCHER_TERMS]" cols="30" rows="10" class="form-control2"><?php echo e($INVOICE_VOUCHER_TERMS); ?></textarea>
        </div>





      </div>

    </div>

    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

    </form>


  </div>
</div>


<?php $__env->stopSection(); ?>

<style type="text/css">
/* Adjust feedback icon position */
.has-feedback .form-control-feedback {
    right: -30px;
}
</style>
<?php $__env->startSection('scripts'); ?>



<script src="<?php echo e(asset('assets/chosen/chosen.jquery.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('assets/slim/slim.min.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.commonjs.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.amd.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.global.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.kickstart.min.js')); ?>"></script>

<script>
      $(function() {
        $('.chosen').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>

<script>
$(document).ready(function() {
    $('form[data-toggle="validator"]')
        .bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'st[BUSINESS_NAME]': {
                    validators: {
                        notEmpty: {
                            message: ''
                        }
                    }
                },
                'st[BUSINESS_EMAIL]': {
                    verbose: false,
                    validators: {
                        notEmpty: {
                            message: 'The email address is required and can\'t be empty'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        },
                        stringLength: {
                            max: 512,
                            message: 'Cannot exceed 512 characters'
                        }
                    }
                }

            }
        });
}).on('error.field.bv', function(e, data) {
      data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
  });


</script>

<script type="text/javascript">
      $(function() {
        $('#mail_by').change(function(){
            $('.mblock').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>