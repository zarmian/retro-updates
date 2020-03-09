<?php $__env->startSection('head'); ?>



<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>



<style type="text/css">

@media  print{a[href]:after{content:none}}

</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/reports.sale_balance_report_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/reports.sale_balance_report_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search hidden-print">
  <div class="container">
    <div class="row">


    <form action="<?php echo e(url('/reports/sales-balance')); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          

           <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="customer" id="customer" class="chosen form-control1">
              <option value="" disabled="disabled" selected="selected"><?php echo app('translator')->getFromJson('admin/reports.select_by_customer_option_txt'); ?></option>
              <?php if(isset($customers) && count($customers) > 0): ?>
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
            <input type="text" name="voucher_no" id="voucher_no" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/reports.invoice_no_txt'); ?>" value="<?php if(!empty($voucher_no)): ?> <?php echo e($voucher_no); ?> <?php endif; ?>" />
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
        <div class="alert alert-success hidden-print"><?php echo e(Session::get('msg')); ?></div>
      <?php endif; ?>

      <?php if(isset($errors) && count($errors) > 0): ?>
        <div class="alert alert-danger hidden-print">
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
            
              <?php if(isset($rows) && count($rows) > 0): ?>
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b><?php echo app('translator')->getFromJson('admin/reports.sale_balance_report_txt'); ?></b> <span class="filter-txt-highligh">(<?php echo e($customer_name); ?>) </span> <?php if(isset($voucher_no) && !empty($voucher_no)): ?> <?php echo app('translator')->getFromJson('admin/reports.for_search_invoice_txt'); ?> <span class="filter-txt-highligh">(<?php echo e($voucher_no); ?>)</span> <?php endif; ?></h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.print_txt'); ?> &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                <div class="col-sm-5 no-padding-left pull-right"><a href="<?php echo e(url("/reports/sales/export/?type=salesBalanceReport&customer={$customer_id}&voucher_no={$voucher_no}")); ?>" class="btn-default-xs btn-excel-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.export_txt'); ?> &nbsp;&nbsp; <i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
              </div>
               
                <tr>
                 
                  <th width="150"><?php echo app('translator')->getFromJson('admin/entries.pay_serial_no_txt'); ?></th>
                  <th width=""><?php echo app('translator')->getFromJson('admin/entries.invoice_no_txt'); ?></th>
                  <th width="200" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.payment_date_txt'); ?></th>
                  <th width="200" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.total_txt'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/entries.account_amount_label'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/entries.balance_txt'); ?></th>

                </tr>
       
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <tr>
                    <th><a href="<?php echo e(url('accounting/sales/detail', $row['sale_id'])); ?>"> <b> <?php echo e($row['payment_no']); ?> </b></a></th>
                    <th><a href="<?php echo e(url('accounting/sales/detail', $row['sale_id'])); ?>"><b><?php echo e($row['invoice_number']); ?></b> </a></th>
                    <td align="left"><b> <?php echo e($row['payment_date']); ?></b></td>
                    <td align="left"><?php echo e($row['total']); ?> <?php echo e($currency); ?></td>
                    <td align="right"><?php echo e($row['amount']); ?> <?php echo e($currency); ?></td>
                    <td align="right"><?php echo e($row['balance']); ?> <?php echo e($currency); ?></td>
                  </tr>
                 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <tr>
                  <th></th>
                  <th></th>
                  <td align="right"><b></b></td>
                  <td align="right"></td>
                  <td align="right"> <b><?php echo app('translator')->getFromJson('admin/entries.tlt_balance_txt'); ?></b></td>
                  <td align="right"><b><?php echo e($total); ?> <?php echo e($currency); ?></b></td>

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