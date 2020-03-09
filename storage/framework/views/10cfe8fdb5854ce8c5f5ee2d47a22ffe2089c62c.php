
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/common.search_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/common.search_txt'); ?></a></div>
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
      
      <div id="products" class="row list-group">

        <?php if(isset($employees) && count($employees) > 0): ?>
          <h4><?php echo app('translator')->getFromJson('admin/employees.employees_search_txt'); ?></h4>
          <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li><?php echo app('translator')->getFromJson('admin/employees.employee_code_label'); ?>: <b> <?php echo e($employee['employee_code']); ?> </b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.full_name_txt'); ?>: <b><?php echo e($employee['full_name']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.email_label'); ?>: <b><?php echo e($employee['email']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.mobile_label'); ?>: <b><?php echo e($employee['mobile']); ?></b></li>
                    <li style=""><?php echo app('translator')->getFromJson('admin/employees.department_label'); ?>: <b><?php echo e($employee['department']); ?></b></li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="<?php echo e(url('/employees/view/'.$employee['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        

        <?php if(isset($customers) && count($customers) > 0): ?>
          <div class="col-sm-12 no-padding"><h4><?php echo app('translator')->getFromJson('admin/common.sales_search_txt'); ?></h4></div>
          
          <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li style="width: 100px;"><?php echo app('translator')->getFromJson('admin/employees.employee_code_label'); ?>: <b> <?php echo e($customer['code']); ?> </b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.full_name_txt'); ?>: <b><?php echo e($customer['full_name']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.email_label'); ?>: <b><?php echo e($customer['email']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.mobile_label'); ?>: <b><?php echo e($customer['mobile']); ?></b></li>
                    <li style=""><?php echo app('translator')->getFromJson('admin/accounting.total_txt'); ?>: <b><?php echo e($customer['total_amount']); ?> <?php echo e($currency); ?></b></li>
                    <li style=""><?php echo app('translator')->getFromJson('admin/accounting.paid_txt'); ?>: <b><?php echo e($customer['total_paid']); ?> <?php echo e($currency); ?></b></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="<?php echo e(url('accounting/customers/view/'.$customer['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>


        <?php if(isset($vendors) && count($vendors) > 0): ?>
          <div class="col-sm-12 no-padding"><h4><?php echo app('translator')->getFromJson('admin/common.vendors_search_txt'); ?></h4></div>
          
          <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-11 col-sm-10 col-xs-10 payment-block">
              
                <div class="col-sm-12 no-padding">

                  <ul class="clearfix">
                    
                    <li style="width: 100px;"><?php echo app('translator')->getFromJson('admin/employees.employee_code_label'); ?>: <b> <?php echo e($vendor['code']); ?> </b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.full_name_txt'); ?>: <b><?php echo e($vendor['full_name']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.email_label'); ?>: <b><?php echo e($vendor['email']); ?></b></li>
                    <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/employees.mobile_label'); ?>: <b><?php echo e($vendor['mobile']); ?></b></li>
                    <li style=""><?php echo app('translator')->getFromJson('admin/accounting.total_txt'); ?>: <b><?php echo e($vendor['total_amount']); ?> <?php echo e($currency); ?></b></li>
                    <li style=""><?php echo app('translator')->getFromJson('admin/accounting.paid_txt'); ?>: <b><?php echo e($vendor['total_paid']); ?> <?php echo e($currency); ?></b></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
             
                <div class="col-sm-12 no-padding"><a href="<?php echo e(url('accounting/vendors/view/'.$vendor['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
                </div>
              
            </div>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        

        <?php if(isset($empty) && $empty <> ""): ?>
          <div class="alert alert-danger"><?php echo e($empty); ?></div>
        <?php endif; ?>
        
      </div>
      
    </div>
  </div>
</div>


<script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>