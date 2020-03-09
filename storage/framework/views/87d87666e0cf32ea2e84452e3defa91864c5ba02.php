
<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?php echo e(asset('assets/dropdown/css/normalize.css')); ?>" type="text/css" rel="stylesheet">



<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/loans.loan_statment_report_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/loans.loan_statment_report_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">


    <form action="<?php echo e(url('/employees/loans/statement')); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
     
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($to) && $to <> ""): ?><?php echo e(date('m-d-Y', strtotime($to) )); ?><?php else: ?><?php echo e(date('m-d-Y', time())); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($from) && $from <> ""): ?><?php echo e(date('m-d-Y', strtotime($from) )); ?><?php else: ?><?php echo e(date('m-d-Y', time())); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="employee_id" id="employee_id" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/reports.select_by_employees_option_txt'); ?> </option>
              
              <?php if(isset($employees) && count($employees) > 0): ?>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               
                  <?php if(isset($employee_id) && $employee_id == $employee['id']): ?>
                    <option value="<?php echo e($employee['id']); ?>" selected="selected"><?php echo e($employee['employee_code']); ?> -- <?php echo e($employee['first_name']); ?> <?php echo e($employee['last_name']); ?></option>
                  <?php else: ?>
                    <option value="<?php echo e($employee['id']); ?>"><?php echo e($employee['employee_code']); ?> -- <?php echo e($employee['first_name']); ?> <?php echo e($employee['last_name']); ?></option>
                  <?php endif; ?>
               
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>

           

            <!-- select option -->
          </div>


          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12  filter-dropdown">
            <select name="type" id="type" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/loans.select_by_type_option_txt'); ?></option>
              <option value="2" <?php if(isset($type) && $type == 2): ?>) selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/loans.type_option_tmp'); ?></option>
              <option value="1" <?php if(isset($type) && $type == 1): ?>) selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/loans.type_option_fix'); ?></option>
              
            </select>
            
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
        <div class="col-lg-12 col-sm-12 col-xs-12">



        <?php if(isset($loans) && count($loans) > 0): ?>

        <div class="col-lg-6 col-md-2 col-sm-4 col-xs-6 col-lg-offset-6 col-md-offset-10 col-sm-offset-8 col-xs-offset-6 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 300px;"><b><?php echo app('translator')->getFromJson('admin/reports.period_date_txt', ['to' => $to, 'from' => $from]); ?> </b></li>
                  <li style="width: 200px;"><b><?php echo app('translator')->getFromJson('admin/loans.total_loan_txt'); ?>: <?php echo e($total_loans); ?></b></li>
                </ul>
              <div class="clearfix"></div>
          </div>
       
          <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-12 col-sm-12 col-xs-12 payment-block">
            
                <ul class="clearfix">
                  
                  <li style="width: 250px;"><b><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?>: </b> <?php echo e($row['date']); ?> </li>
                  <li style="width: 400px;"><b><?php echo app('translator')->getFromJson('admin/accounting.description_txt'); ?>:</b> <?php echo e($row['detail']); ?> </li>
                  <li style="width: 250px;"><b><?php echo app('translator')->getFromJson('admin/loans.deposit_loan_txt'); ?>:</b> <?php echo e($row['deposit']); ?> </li>
                 
                  <li style="width: 150px;"><b><?php echo app('translator')->getFromJson('admin/accounting.balance_txt'); ?>:</b> <?php echo e($row['balance']); ?></li>

                </ul>
              <div class="clearfix"></div>
          </div>
            
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php else: ?>

          <div class="col-lg-12"><div class="alert alert-danger"><?php echo app('translator')->getFromJson('admin/common.notfound'); ?></div></div>

        <?php endif; ?>
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