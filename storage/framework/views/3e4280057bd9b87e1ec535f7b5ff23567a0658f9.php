

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Create Tax Rates</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/accounting/tax')); ?>">Manage Tax Rates</a>  / 
        <a href="#" class="active">Create Tax Rates</a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="<?php echo e(url('accounting/tax/add')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3>Create Tax Rates</h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">
              
              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group no-padding-left">
                <label for="title" class="input_label">Tax Name</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="Tax Name*" required="required" value="" />
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group no-padding-left">
                <label for="code" class="input_label">Tax Code</label>
                <input type="text" name="code" id="code" class="form-control1" placeholder="Tax Code*" required="required" value="" />
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-12 form-group no-padding-left">
                <label for="rate" class="input_label">Tax Rate</label>
                <input type="text" name="rate" id="rate" class="form-control1" placeholder="Tax Rate*" required="required" value="" />
              </div>


              

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="name" class="input_label"></label>
                <input type="submit" value="<?php echo app('translator')->getFromJson('admin/common.button_submit'); ?>" name="submitButton" class="btn btn-primary btn-block new-btn">
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
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>