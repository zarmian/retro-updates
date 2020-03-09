
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/loans.manage_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/loans.manage_heading'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">


    <div class="col-lg-12">
    
        <div class="col-lg-4 col-lg-offset-8">

        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-8 col-md-offset-8 col-lg-offset-0">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>

        </div>

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin"><a class="plus" href="<?php echo e(url('/employees/loans/statement')); ?>"><i class="fa fa-search-plus" aria-hidden="true"></i></a></div>

        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin"><a class="plus" href="<?php echo e(url('/employees/loans/create')); ?>">+</a></div>

        </div>
      </div>


    </div>
  </div>
</section>
<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     
      
      <?php if(Session::has('msg')): ?>
      <div class="alert alert-success">
        <?php echo e(Session::get('msg')); ?>

      </div>
      <?php endif; ?>
      
      <div id="products" class="row list-group">
        <?php if(isset($employees) && count($employees) > 0): ?>
        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul class="loans_list">
                          <li class="employee_name"><b><?php echo e($employee['name']); ?> </b></li>
                          <li class="amount"><b><?php echo app('translator')->getFromJson('admin/loans.loan_apply_amount'); ?> </b> <span><b><?php echo e($employee['amount']); ?></b></span> </li>
                          <li class="amount"><b><?php echo app('translator')->getFromJson('admin/loans.withdraw_amount'); ?> </b> <span><b><?php echo e(($tlt_loan[$employee['employee_id']]['withdraw'])); ?></b></span> </li>
                          <li class="amount"><b><?php echo app('translator')->getFromJson('admin/loans.deposit_amount'); ?> </b> <span><b><?php echo e(($tlt_loan[$employee['employee_id']]['deposit'])); ?></b></span> </li>
                          <li class="amount"><b><?php echo app('translator')->getFromJson('admin/loans.balance_amount'); ?> </b> <span><b><?php echo e(($tlt_loan[$employee['employee_id']]['tlt_balance'])); ?></b></span> </li>

                      </ul>
                    </div>
                  </li>
                </ul>
                
           
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12"></div>
        <?php else: ?>
        <div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div>
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