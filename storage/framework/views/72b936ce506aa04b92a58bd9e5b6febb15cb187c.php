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
        <h1><?php echo app('translator')->getFromJson('admin/accounting.chart_heading'); ?>: </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/accounting.chart_heading'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12  no-padding-left">
        
          
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.customer_invoice_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_receivable_heading'); ?></span> <?php echo e($today_receivable); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.total_receivable_heading'); ?> </span> <?php echo e($total_receivable); ?> <?php echo e($currency); ?></p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/sales')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/sales/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.vendors_bill_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_payable_txt'); ?></span> <?php echo e($today_payable); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.total_payable_txt'); ?></span> <?php echo e($total_payable); ?> <?php echo e($currency); ?></p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/purchase')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/purchase/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.expenses_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_txt'); ?> </span> <?php echo e($today_expense); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.this_month_txt'); ?> </span> <?php echo e($total_expense); ?> <?php echo e($currency); ?> </p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/journal')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/journal/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
              <div class="inside-block clearfix">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.hr_payroll_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.this_month_salary_txt'); ?> </span> <?php echo e($this_month_salary); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.pervious_month_salary_txt'); ?> </span> <?php echo e($pervious_month_salary); ?> <?php echo e($currency); ?></p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                  <ul>
                    <li><a href="<?php echo e(url('salary/create')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('salary/create')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

          </div>

        
      </div>
      <div class="col-lg-8 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <div class="col-sm-11"><h2><?php echo app('translator')->getFromJson('admin/accounting.chart_heading'); ?></h2></div>
          <div class="col-sm-1">
            <a href="<?php echo e(url('accounting/chart/add')); ?>" class="btn-add-chart"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
          
          <table class="table table-striped">
            
              <tr>
                <th width="90"><?php echo app('translator')->getFromJson('admin/reports.code_txt'); ?></th>
                <th><?php echo app('translator')->getFromJson('admin/accounting.name_txt'); ?></th>
                <th><?php echo app('translator')->getFromJson('admin/accounting.type_txt'); ?></th>
                <th><?php echo app('translator')->getFromJson('admin/accounting.account_opening'); ?></th>
                <th width="120"><?php echo app('translator')->getFromJson('admin/accounting.account_balance'); ?></th>
                <th><?php echo app('translator')->getFromJson('admin/accounting.action_txt'); ?></th>
              </tr>

              <?php if(isset($accounts) ): ?>
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


              <tr>
                <th></th>
                <th></th>
                <td colspan="4"><b><?php echo e($account['name']); ?></b></td>
              </tr>
              
              <?php if(isset($account['coa']) ): ?>
                <?php $__currentLoopData = $account['coa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <td><?php echo e($coa['code']); ?></td>
                    <td><?php echo e($coa['name']); ?></td>
                    <td><?php echo e($coa['type_name']); ?></td>
                    <td><?php echo e($coa['opening']); ?> <?php echo e($coa['balance_type']); ?> </td>
                    <td><?php echo e($coa['balance']); ?> <?php echo e($currency); ?></td>
                    <?php if(isset($coa['is_systemize']) && $coa['is_systemize'] == 1): ?>
                    <td><a href="<?php echo e(url('accounting/chart/edit', $coa['cid'])); ?>"><?php echo app('translator')->getFromJson('admin/accounting.edit_txt'); ?></a> </td>
                    <?php else: ?>
                    <td>
                      <a href="<?php echo e(url('accounting/chart/edit', $coa['cid'])); ?>"><?php echo app('translator')->getFromJson('admin/accounting.edit_txt'); ?></a> 
                    </td>
                    <?php endif; ?>
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
<?php $__env->startSection('scripts'); ?>
  <script src="<?php echo e(asset('assets/dropdown/js/classie.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/dropdown/js/selectFx.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
      (function() {
        [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {  
          new SelectFx(el);
        } );
      })();
    </script>
  
  <script type="text/javascript">

    $(function(){
      // bind change event to select
      $('#per_page').on('change', function () {
      var url = $(this).val(); // get selected value
      if (url) { // require a URL
        window.location = '?per_page='+url; // redirect
      }
      return false;
      });
    });

    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

<script type="text/javascript">
    $('.datepicker').dateDropper();
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>