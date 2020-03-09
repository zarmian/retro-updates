

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/accounting.create_coa_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/chart')); ?>"><?php echo app('translator')->getFromJson('admin/accounting.chart_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/accounting.create_coa_txt'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">


      <div class="col-sm-12 col-md-12 col-lg-12">

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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="<?php echo e(url('accounting/chart/save')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <div class="form_container">

          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/accounting.create_coa_txt'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">
              
              

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="name" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.account_title'); ?>*</label>
                <input type="text" name="name" id="name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.account_type_title'); ?>*" required="required" value="<?php echo e(old('name')); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="code" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.account_code'); ?>*</label>
                <input type="text" name="code" id="code" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.account_code'); ?>*" required="required" value="<?php echo e(old('code')); ?>" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="account_type" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.type_name_txt'); ?>*</label>

                <select name="account_type" id="account_type" data-placeholder="Choose a Types" class="chosen form-control1" tabindex="2">
                  <?php if(isset($types) && count($types) > 0): ?>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <optgroup label="<?php echo e($type['name']); ?>">
                      <?php if(isset($type['children']) && count($type['children']) > 0): ?>
                        <?php $__currentLoopData = $type['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if(old('type') == $children['type_id']): ?>
                            <option value="<?php echo e($children['type_id']); ?>" selected="selected"> -- <?php echo e($children['name']); ?></option>
                          <?php else: ?>
                            <option value="<?php echo e($children['type_id']); ?>"> -- <?php echo e($children['name']); ?></option>
                          <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                      </optgroup>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
               
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="balance_type" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.balance_type_label'); ?></label>
                <select name="balance_type" id="balance_type" class="form-control1" required="required">
                  <option value="dr" selected="selected"><?php echo app('translator')->getFromJson('admin/accounting.type_dr'); ?></option>
                  <option value="cr"><?php echo app('translator')->getFromJson('admin/accounting.type_cr'); ?></option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="opening" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.account_opening'); ?>*</label>
                <input type="text" name="opening" id="opening" class="form-control1" data-bv-integer-message="The value is not an integer" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.account_opening'); ?>*" value="<?php echo e(old('opening')); ?>" />
              </div>



              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="submit" class="input_label"></label>

                <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn">Submit</button>
              </div>

              

            </div>
            
          </div>


          

         
          
  
          </div>
        

        

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script type="text/javascript">
  $(function() {
      $('.chosen').chosen();
      $('.chosen-deselect').chosen({ allow_single_deselect: true });
    });
</script>

  
  <script type="text/javascript">


    $(".datepicker").dateDropper();

    
    

</script>

<script>
$(document).ready(function() {
    $('form[data-toggle="validator"]')
        .find('[name="account_type"]')
            .chosen({
                width: '100%',
                inherit_select_classes: true
            })
            // Revalidate the color when it is changed
            .change(function(e) {
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', 'account_type');
            })
            .end()
        .bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                account_type: {
                    validators: {
                        callback: {
                            message: 'Please choose 2-4 color you like most',
                            callback: function(value, validator, $field) {
                                // Get the selected options
                                var options = validator.getFieldElements('account_type').val();
                                return (options != null);
                            }
                        }
                    }
                },
                opening: {
                    validators: {
                        numeric: {
                          message: 'The value is not an integer',
                          decimalSeparator: '.'
                        }
                    }
                }

            }
        });
});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>