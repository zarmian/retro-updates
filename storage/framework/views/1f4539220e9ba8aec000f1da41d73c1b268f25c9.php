<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/loans.manage_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/employees/loans')); ?>"><?php echo app('translator')->getFromJson('admin/loans.manage_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/loans.create_loans'); ?></a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="<?php echo e(url('/employees/loans/store')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            
            <div class="row">

              <div class="col-lg-12"><div class="top_content">
                <h3><?php echo app('translator')->getFromJson('admin/loans.manage_heading'); ?></h3>
                <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
              </div></div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="date" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.date_label'); ?>*</label>
                <input type="text" name="date" id="date" class="datepicker form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/loans.date_label'); ?>*" required="required" value="" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="detail" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.title_label'); ?>*</label>
                <input type="text" name="detail" id="detail" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/loans.title_label'); ?>*" required="required" value="<?php echo e(old('detail')); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="type" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.type_label'); ?></label>
                <select name="type" id="type" class="form-control1" required="required" onchange="getLoanStatement();">
                  <option value="" selected="selected"><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                  <option value="1"><?php echo app('translator')->getFromJson('admin/loans.type_option_fix'); ?></option>
                  <option value="2"><?php echo app('translator')->getFromJson('admin/loans.type_option_tmp'); ?></option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="employee_id" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.employee_label'); ?>*</label>
                <select name="employee_id" id="employee_id" class="form-control1" required="required" onchange="getLoanStatement();">
                  <option value=""><?php echo app('translator')->getFromJson('admin/loans.select_option'); ?></option>
                  <?php if(isset($employees) && count($employees) > 0): ?>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($employee->id == old('employee_id')): ?>
                        <option value="<?php echo e($employee->id); ?>" selected="selected"><?php echo e($employee->fullName()); ?></option>
                      <?php else: ?>
                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->fullName()); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>
              

              <div class="col-lg-12" style="display: none;" id="load-details">
                <span class="label label-warning col-lg-12" style=" padding: 10px 10px">
                  
                </span>
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="amount" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.amount_label'); ?>*</label>
                <input type="text" name="amount" id="amount" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/loans.amount_label'); ?>*" required="required" data-bv-numeric="true"
                data-bv-numeric-message="The value is not an integer" value="<?php echo e(old('amount')); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="installment" class="input_label"><?php echo app('translator')->getFromJson('admin/loans.installment_label'); ?></label>
                <input type="text" name="installment" id="installment" required="required" class="form-control1">
              </div>
 

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="name" class="input_label"></label>
                <input type="submit" value="<?php echo app('translator')->getFromJson('admin/common.button_submit'); ?>" name="submitButton" class="btn btn-block btn-primary btn-block new-btn">
              </div>

              

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
  <script type="text/javascript">
    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });

    $(".datepicker").dateDropper();

    function getLoanStatement()
    {

      $( "#load-details" ).hide();

      var type_id = $("#type").val();
      var employee_id = $("#employee_id").val();

      $.ajax({
        url: '<?php echo e(url('employees/loans/ajax')); ?>',
        type: 'POST',
        dataType: 'json',
        data: {action: 'loanStatement', type_id: type_id, employee_id: employee_id, '_token': '<?php echo e(csrf_token()); ?>'},
        success: function (data)
        {
          
          if(data.success == true)
          {
            var html = '';

            html += '<span style="float: left"><b>Advance: '+data.balance+' '+data.currency+'</b></span>';
            html += '<span style="float: right"><b>Installment: '+data.installment+' '+data.currency+'</b></span>';

            $("#load-details").slideDown('slow', function() {
              $("#load-details > span").html(html);
            });
            
              console.log(data);
            
          }


          
        }
      });
        
      //alert(3);
    }

  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>