

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/timepicki.css')); ?>"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('employees/common.notification_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('employees/common.dashboard_heading'); ?></a>  /  
        <a href="<?php echo e(url('employees/notifications')); ?>"><?php echo app('translator')->getFromJson('employees/common.notification_txt'); ?></a>  /  
        <a href="#" class="active"><?php echo app('translator')->getFromJson('employees/common.notification_view_txt'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">

      <div class="col-sm-6 col-lg-6 col-lg-offset-3">
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-body"><h4><?php echo app('translator')->getFromJson('employees/common.notification_txt'); ?></h4></div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
                <b><?php echo app('translator')->getFromJson('employees/common.title_txt'); ?>: </b>
                <p><?php echo e($notification['title']); ?></p>

                <b><?php echo app('translator')->getFromJson('employees/common.date_txt'); ?> </b>
                <p><?php echo e($notification['datetime']); ?></p>

                <b><?php echo app('translator')->getFromJson('employees/common.notification_des_txt'); ?>:</b>
                <p><?php echo $notification['description']; ?></p>
            </div>
          </div>
        </div>
      </div>


      
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>