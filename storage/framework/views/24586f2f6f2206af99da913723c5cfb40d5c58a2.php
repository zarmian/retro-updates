

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/common.noticeboard_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/noticeboard')); ?>"><?php echo app('translator')->getFromJson('admin/common.noticeboard_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/common.noticeboard_create_txt'); ?></a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="<?php echo e(url('/noticeboard/create')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/common.noticeboard_create_txt'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

            <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="date" class="input_label"><?php echo app('translator')->getFromJson('admin/common.date_txt'); ?>*</label>
                <input type="text" name="date" id="date" class="form-control1 datepicker" placeholder="<?php echo app('translator')->getFromJson('admin/common.date_txt'); ?>*" required="required" value="" />
              </div>
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
                <label for="title" class="input_label"><?php echo app('translator')->getFromJson('admin/common.title_label'); ?>*</label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/common.title_label'); ?>*" required="required" value="" />
              </div>

           
              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="description" class="input_label"><?php echo app('translator')->getFromJson('admin/common.description_label'); ?></label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control2 summernote" placeholder="<?php echo app('translator')->getFromJson('admin/common.description_label'); ?>"><?php echo e(old('description')); ?></textarea>
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
  <script type="text/javascript">
    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });
    $('.datepicker').dateDropper();
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>