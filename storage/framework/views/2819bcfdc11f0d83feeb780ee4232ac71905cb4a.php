
<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?php echo e(asset('assets/dropdown/css/normalize.css')); ?>" type="text/css" rel="stylesheet">
<link href="<?php echo e(asset('assets/dropdown/css/cs-select.css')); ?>" type="text/css" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/accounting.chart_type_heading'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/accounting.chart_type_heading'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <div class="col-sm-11"><h2><?php echo app('translator')->getFromJson('admin/accounting.chart_type_heading'); ?></h2></div>
          <div class="col-sm-1 pull-right text-right">
            <a href="<?php echo e(url('accounting/chart-type/add')); ?>" class="btn-add-chart"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
          
          <table class="table table-striped">
            
              <tr>
                <th width="50"></th>
                <th>Name</th>
                <th></th>
                <th></th>
                <th class="text-right">Action</th>
              </tr>
              <?php if(isset($types) && count($types) > 0): ?>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td></td>
                  <td colspan="3"><?php echo e($type['name']); ?></td>
                  <td class="text-right"><a href="<?php echo e(url('accounting/chart-type/edit', $type['type_id'])); ?>" class="edit_link">Edit</a></td>
                </tr>
                <?php if(isset($type['children']) && count($type['children']) > 0): ?>
                  <?php $__currentLoopData = $type['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td></td>
                  <td colspan="3">-- <?php echo e($children['name']); ?></td>
                  <td class="text-right"><a href="<?php echo e(url('accounting/chart-type/edit', $children['type_id'])); ?>" class="edit_link">Edit</a></td>
                </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>

          </table>

        </div>
      </div>
      
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>