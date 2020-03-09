

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/shift.update-heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/shift')); ?>"><?php echo app('translator')->getFromJson('admin/shift.manage-heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/shift.update-heading'); ?></a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form" action="<?php echo e(url('/shift/update/'.$shift->id)); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

        <div class="form_container">

          <div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 col-sm-offset-2 col-md-offset-2 col-sm-offset-0">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/shift.manage-heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label"><?php echo app('translator')->getFromJson('admin/shift.title'); ?></label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/shift.title'); ?>*" required="required" value="<?php echo e($shift->title); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="status" class="input_label"><?php echo app('translator')->getFromJson('admin/shift.status_label'); ?></label>
                <select name="status" id="status" class="form-control1" required="required">
                  <option value="1" <?php if($shift->status == 1): ?> selected="selected" <?php endif; ?>>Active</option>
                  <option value="0" <?php if($shift->status == 0): ?> selected="selected" <?php endif; ?>>InActive</option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="start_time" class="input_label"><?php echo app('translator')->getFromJson('admin/shift.start_time'); ?></label>
                <input type="text" name="start_time" id="start_time" class="form-control1 timepicker" placeholder="<?php echo app('translator')->getFromJson('admin/shift.start_time'); ?>*" required="required" value="<?php echo e(date('h:i A', strtotime($shift->start_time))); ?> " />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="end_time" class="input_label"><?php echo app('translator')->getFromJson('admin/shift.end_time'); ?></label>
                <input type="text" name="end_time" id="end_time" class="form-control1 timepicker" placeholder="<?php echo app('translator')->getFromJson('admin/shift.end_time'); ?>*" required="required" value="<?php echo e(date('h:i A', strtotime($shift->end_time))); ?>" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="description" class="input_label"><?php echo app('translator')->getFromJson('admin/shift.description_label'); ?></label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/shift.description_label'); ?>"><?php echo e($shift->description); ?></textarea>
              </div>

              

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding">
                <label for="" class="input_label"></label>
                <input type="submit" name="submitButton" value="<?php echo app('translator')->getFromJson('admin/common.button_submit'); ?>" class="btn btn-primary btn-block new-btn">
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
  <script src="<?php echo e(asset('assets/js/timepicki.js')); ?>"></script>
  <script type='text/javascript'>
    $('.timepicker').timepicki({
      show_meridian:true,
      min_hour_value:0,
      max_hour_value:12,
      step_size_minutes:5,
      overflow_minutes:true,
      increase_direction:'up',
      disable_keyboard_mobile: false
    });

   

    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });

  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>