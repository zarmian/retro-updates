
<?php $__env->startSection('head'); ?>

<style type="text/css">


@media  print{a[href]:after{content:none}}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/reports.bank_and_cash_text'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/reports.bank_and_cash_text'); ?></a></div>
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

        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <table class="table table-striped">
            
              <?php if(isset($banks) && count($banks) > 0): ?>
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b><?php echo app('translator')->getFromJson('admin/reports.bank_and_cash_text'); ?></b> <span class="filter-txt-highligh"> </span></h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.print_txt'); ?> &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="<?php echo e(url('accounting/export/?type=bankCash')); ?>" class="btn-default-xs btn-excel-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.export_txt'); ?> &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                  <th width="150" style="padding-left: 20px"><?php echo app('translator')->getFromJson('admin/reports.code_txt'); ?></th>
                  <th width=""><?php echo app('translator')->getFromJson('admin/entries.payment_bank_label'); ?></th>
                  <th width="150" align="right" style="text-align: right;padding-right: 20px" width="100"><?php echo app('translator')->getFromJson('admin/entries.account_amount_label'); ?></th>
                </tr>
        
                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <th style="padding-left: 20px"> <b> <?php echo e($bank['code']); ?> </b></th>
                    <th><b> <?php echo e($bank['name']); ?></b> </th>
                    <td align="right" style="text-align: right;padding-right: 20px"><?php echo e($bank['tlt_balance']); ?> <?php echo e($currency); ?></td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <tr>
                <th></th>
                <th align="right" style="text-align: right;"><b><?php echo app('translator')->getFromJson('admin/reports.tlt_amount_txt'); ?></b></th>
                <th align="right" style="text-align: right;padding-right: 20px"><b> <?php echo e($tlt_balance_amt); ?> </b></th>

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
<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $('.datedropper').dateDropper();
    $(".chosen").select2();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>