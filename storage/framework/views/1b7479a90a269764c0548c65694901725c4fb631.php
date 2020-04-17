<?php $__env->startSection('head'); ?>

<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

<style type="text/css">
.filter-text-input:active { border: 0px solid #FFF !important;}

@media  print{a[href]:after{content:none}}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/reports.purchse_payments_report_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/reports.purchse_payments_report_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search hidden-print">
  <div class="container">
    <div class="row">


    <form action="<?php echo e(url('/reports/purchase-payments')); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          

          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($to) && $to <> ""): ?><?php echo e(date('m-d-Y', strtotime($to) )); ?><?php else: ?><?php echo e(date('m-d-Y', strtotime('last month'))); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($from) && $from <> ""): ?><?php echo e(date('m-d-Y', strtotime($from) )); ?><?php else: ?><?php echo e(date('m-d-Y', time())); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="customer" id="customer" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/reports.select_by_vendors_option_txt'); ?></option>
              <?php if(isset($customers) ): ?>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($customer->id == app('request')->input('customer')): ?>
                    <option value="<?php echo e($customer->id); ?>" selected="selected"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
                  <?php else: ?>
                    <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
              
            </select>
            <!-- select option -->
          </div>


          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 filter-input">
            <input type="text" name="voucher_no" id="voucher_no" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/reports.voucher_no_txt'); ?>" value="<?php echo e(app('request')->input('voucher_no')); ?>" />
           </div>

        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="<?php echo app('translator')->getFromJson('admin/common.find_btn_txt'); ?>" />
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
          
          <table class="table table-striped">
            
              <?php if(isset($rows) ): ?>
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b><?php echo app('translator')->getFromJson('admin/reports.sales_payments_report_txt'); ?></b> <span class="filter-txt-highligh">(<?php echo e($to_date); ?> - <?php echo e($from_date); ?>) </span><?php if(!empty($voucher_no)): ?> <?php echo app('translator')->getFromJson('admin/reports.for_search_voucher_txt'); ?> <span class="filter-txt-highligh">(<?php echo e($voucher_no); ?>)</span> <?php endif; ?></h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.print_txt'); ?> &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="<?php echo e(url("/reports/purchase/export/?type=purchaseTransaction&to={$to}&from={$from}&customer={$customer_id}&voucher_no={$voucher_no}")); ?>" class="btn-default-xs btn-excel-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.export_txt'); ?> &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                  <th width="150"><?php echo app('translator')->getFromJson('admin/entries.pay_serial_no_txt'); ?></th>
                  <th width="150"><?php echo app('translator')->getFromJson('admin/entries.voucher_number_txt'); ?></th>
                  <th width="150" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.voucher_date_label'); ?></th>
                  <th width="" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/entries.account_amount_label'); ?></th>
                </tr>
        
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <tr>
                    <th><a href="<?php echo e(url('accounting/purchase/detail', $row['sale_id'])); ?>"> <b> <?php echo e($row['payment_no']); ?> </b></a></th>
                    <th><a href="<?php echo e(url('accounting/purchase/detail', $row['sale_id'])); ?>"><b><?php echo e($row['invoice_number']); ?></b> </a></th>
                    <td align="left"><?php echo e($row['invoice_date']); ?></td>
                    <td align="left"><?php echo e($row['detail']); ?></td>
                    <td align="right"><?php echo e($row['amount']); ?> <?php echo e($currency); ?></td>
                  </tr>
                 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <tr>
                <th></th>
                <th></th>
                <td align="right"><b></b></td>
                <td align="right"><b><?php echo app('translator')->getFromJson('admin/reports.tlt_paid_txt'); ?></b></td>
                <td align="right"><b> <?php echo e($total); ?> <?php echo e($currency); ?></b></td>

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