

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/accounting.account_type_create_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/chart-type')); ?>"><?php echo app('translator')->getFromJson('admin/accounting.chart_type_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/accounting.account_type_create_txt'); ?></a>
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


      <form data-toggle="validator" role="form" method="post" class="registration-form"  action="<?php echo e(url('accounting/chart-type/save')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/accounting.account_type_create_txt'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">
              
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="name" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.account_type_title'); ?>*</label>
                <input type="text" name="name" id="name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.account_type_title'); ?>*" required="required" value="<?php echo e(old('name')); ?>" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="parent" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.type_name_txt'); ?>*</label>

                <select name="parent" id="parent" data-placeholder="Choose a Types" class="chosen-deselect form-control1" tabindex="2">
                  <option value="0">Parent</option>
                  <?php if(isset($types) && count($types) > 0): ?>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type['type_id']); ?>"><?php echo e($type['name']); ?></option>
                      <?php if(isset($type['children']) && count($type['children']) > 0): ?>
                        <?php $__currentLoopData = $type['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($children['type_id']); ?>"> -- <?php echo e($children['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
               
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="type" class="input_label"><?php echo app('translator')->getFromJson('admin/accounting.type_label'); ?></label>
                <select name="type" id="type" class="form-control1" required="required">
                  <option value="dr" selected="selected"><?php echo app('translator')->getFromJson('admin/accounting.type_dr'); ?></option>
                  <option value="cr"><?php echo app('translator')->getFromJson('admin/accounting.type_cr'); ?></option>
                </select>
              </div>

 

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="submit" class="input_label"></label>
                <input type="submit" class="btn btn-primary btn-block new-btn">
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

  

    // $(document).ready(function (){
    //   $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    // });

    $(".datepicker").dateDropper();

    $(function() {
      $('.chosen').chosen();
      $('.chosen-deselect').chosen({ allow_single_deselect: true });
    });
    

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>