
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/employees.create_role'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/roles')); ?>"><?php echo app('translator')->getFromJson('admin/employees.manage_role'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/employees.create_role'); ?></a>
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
      <form id="group_form" method="post" class="registration-form" action="<?php echo e(url('/roles/store')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
      
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/employees.manage_role'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">
              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
                <label for="title" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.role_title_label'); ?></label>
                <input type="text" name="title" id="title" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.role_title_label'); ?>*" required="required" value="" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding">
                <label for="description" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.role_description_label'); ?></label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/users.role_description_label'); ?>"><?php echo e(old('description')); ?></textarea>
              </div>


            </div>
            
          </div>


          

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

           <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/users.permission_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/users.select_permision_text'); ?></p>
            </div>

            <div class="form_container">

              <?php if(isset($permissions) && count($permissions) > 0): ?>
                  <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xs-12 permission_margin no-padding-left">
                      <div data-toggle="buttons" class="btn-group bizmoduleselect">
                      <label class="btn permission_label">
                        <input type="checkbox" name="permissions[<?php echo e($permission->name); ?>]" name="permissions[<?php echo e($permission->name); ?>]" autocomplete="off" value="true">

                        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9 role_heading no-padding-left"><h6><?php echo e($permission->title); ?></h6></div>
                        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3 no-padding text-right"> 
                          <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                        </div>
                      </label>
                    </div>
                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>




            </div>


          </div>

          
            <div class="col-sm-12">
              <button type="submit" name="submitButton" class="btn btn-primary"><?php echo app('translator')->getFromJson('admin/users.submit_button'); ?></button>
            </div>
          </div>
        

        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">
    $(document).ready(function (){
      $('#group_form').bootstrapValidator('revalidateField');
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>