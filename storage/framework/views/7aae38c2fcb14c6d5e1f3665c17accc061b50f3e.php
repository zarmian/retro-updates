<?php $__env->startSection('head'); ?>
<style type="text/css">
.select2-dropdown{
  top: 15px;
}

.datetimepicker{
  border: 0px solid transparent !important;
  background: transparent !important;
}

input:focus, input:active{
  border: 0px solid transparent !important;
}

input.active{
  border: 0px solid transparent !important;
}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/accounting.trial_balance_heading'); ?>  </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right hidden-print"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/accounting.trial_balance_heading'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <?php if(Session::has('msg')): ?>
        <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
      <?php endif; ?>

      <?php if(isset($errors) && count($errors)>0  ): ?>
        <div class="alert alert-danger">
          <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          </div>
        <?php endif; ?>

      <div id="products" class="row list-group">
        
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <div class="col-sm-10 hidden-print"><h2><?php echo app('translator')->getFromJson('admin/accounting.trial_balance_heading'); ?></h2></div>
          <div class="col-sm-1 text-center hidden-print"><a href="javascript:void(0)" onclick="window.print();" class="btn-add-chart btn-blue-bg btn-block"><i class="fa fa-print" aria-hidden="true"></i></a></div>
          <div class="col-sm-1 text-center hidden-print"><a href="<?php echo e(url('/reports/export/?type=trial')); ?>" class="btn-add-chart btn-block"><i class="fa fa-download" aria-hidden="true"></i></a></div>

          <table class="table table-striped">
            
              <tr>
               
                <th width="100"><?php echo app('translator')->getFromJson('admin/accounting.account_code'); ?></th>
                <th width="300"><?php echo app('translator')->getFromJson('admin/accounting.account_title'); ?></th>
                <th width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/accounting.opening_debit_txt'); ?></th>
                <th width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/accounting.opening_credit_txt'); ?></th>
                <th align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/accounting.trans_debit_txt'); ?></th>
                <th align="right" style="text-align: right;" width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/accounting.trans_credit_txt'); ?></th>

                <th align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/accounting.closing_debit_txt'); ?></th>
                <th align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/accounting.closing_credit_txt'); ?></th>
              </tr>

              <?php if(isset($trials) && count($trials) > 0): ?>
                <?php $__currentLoopData = $trials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


              <tr>
                <th><b><?php echo e($trial['code']); ?></b></th>
                <th><b><?php echo e($trial['name']); ?></b></th>
                <td align="right"><?php echo e($trial['opening_dr']); ?></td>
                <td align="right"><?php echo e($trial['opening_cr']); ?></td>

                <td align="right"><?php echo e($trial['transition_dr']); ?></td>
                <td align="right"><?php echo e($trial['transition_cr']); ?></td>

                <td align="right"><?php echo e($trial['closing_dr']); ?></td>
                <td align="right"><?php echo e($trial['closing_cr']); ?></td>
              </tr>
             

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <tr>
                <th></th>
                <th></th>
                <td align="right"><b><?php echo e($total['op_tlt_dr']); ?></b></td>
                <td align="right"><b><?php echo e($total['op_tlt_cr']); ?></b></td>

                <td align="right"><b><?php echo e($total['trans_tlt_dr']); ?></b></td>
                <td align="right"><b><?php echo e($total['trans_tlt_cr']); ?></b></td>

                <td align="right"><b><?php echo e($total['closing_tlt_dr']); ?></b></td>
                <td align="right"><b><?php echo e($total['closing_tlt_cr']); ?></b></td>
              </tr>
            
              <?php endif; ?>
            
          </table>

        </div>
      </div>
        
      </div>
      
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>