
<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/common.leaves_request_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/common.leaves_request_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">

    <form action="<?php echo e(url('/leaves')); ?>" method="post">
        
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4><?php echo app('translator')->getFromJson('admin/common.find_leaves_txt'); ?></h4>
          </div>
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 leave-request filter-dropdown">
            <select name="employee" id="employee" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/common.select_employees'); ?></option>
              <?php if(isset($employees) && count($employees) > 0): ?>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($employee->role <> 1): ?>{
                  <?php if($employee->id == app('request')->input('employee')): ?>
                  

                    <option value="<?php echo e($employee->id); ?>" selected="selected"><?php echo e($employee->fullName()); ?></option>
                 
                  <?php else: ?>
                    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->fullName()); ?></option>
                  <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
              
            </select>
           </div>

          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="status" id="status" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/common.select_status_txt'); ?></option>
              
              <option value="1" <?php if(app('request')->input('status') == 1): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.select_approved_txt'); ?> </option>
              <option value="2" <?php if(app('request')->input('status') == 2): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.select_rejected_txt'); ?> </option>
             
            </select>
            <!-- select option -->
      </div>


        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="Find Report Now" />
          </div>
        </div>

      </div>

       
        </form>
    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <?php if(Session::has('msg')): ?>
        <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
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
      
      
      <div id="products" class="row list-group">
        
        <?php if(isset($leaves) && count($leaves) > 0): ?>
        <div class="row">

        <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="col-lg-11 col-sm-11 col-xs-11 payment-block">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li style="width: 25%;"><?php echo app('translator')->getFromJson('admin/leaves.title_txt'); ?>: <b> <?php echo e($leave['title']); ?> </b></li>
                  <li style="width: 50%;"><?php echo app('translator')->getFromJson('admin/leaves.description_txt'); ?>: <b><?php echo e($leave['description']); ?></b></li>
                  
                    
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
           
              <div class="col-sm-12 no-padding"><a href="<?php echo e(url('/leave/show', $leave['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
             
            
          </div>

          
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>

          <div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div>
        <?php endif; ?>
        
      </div>
      
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>


    <script type="text/javascript">
    $(".chosen").select2();
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>