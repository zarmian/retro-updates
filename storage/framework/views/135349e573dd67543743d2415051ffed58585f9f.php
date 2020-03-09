
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
        <h1><?php echo app('translator')->getFromJson('admin/common.create_salary_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/common.create_salary_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">

    <form action="<?php echo e(url('/salary/create')); ?>" method="post" id="filter_form">

        <?php echo csrf_field(); ?>

        

      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4><?php echo app('translator')->getFromJson('admin/common.salary_filter_txt'); ?></h4>
          </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="date" id="date" data-format="Y-m" data-default-date="<?php echo e(date('m-d-Y', strtotime($date))); ?>" placeholder="YYYY" data-fx="false" data-fx-mobile="true" class="filter-date-input datepicker">
           </div>

          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="department" id="department" class="chosen by_department form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/common.salary_department_txt'); ?></option>
              <?php if(isset($departments) && count($departments) > 0): ?>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($department->id == $department_id): ?>
                    <option value="<?php echo e($department->id); ?>" selected="selected"><?php echo e($department->title); ?></option>
                  <?php else: ?>
                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->title); ?></option>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
              
            </select>
            <!-- select option -->
      </div>


        </div>

        <div class="col-lg-2 no-padding">
            <button type="button" id="find_button" class="filter-submit-btn"><?php echo app('translator')->getFromJson('admin/entries.find_txt'); ?></button>
        </div>

      </div>

       
        </form>

    
    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">

      <?php if(isset($errors) && count($errors) > 0): ?>
      <div class="alert alert-danger">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
      
        <?php if(isset($lists) && count($lists) > 0): ?>

        <div class="col-sm-7 salary-top-block">
          <h4> <?php echo app('translator')->getFromJson('admin/employees.salary_txt', ['date' => date('d M, Y', strtotime($date))]); ?>  </h4>
        </div>
        <div class="col-sm-3 col-sm-offset-2 no-padding">
          <button class="btn btn-block btn-create-all" type="button" id="button_create"><?php echo app('translator')->getFromJson('admin/employees.create_emp_salary_btn'); ?></button>
        </div>

        
        <form action="<?php echo e(url('/salary/store')); ?>" method="post" id="salary_store">
          <?php echo csrf_field(); ?>


          <div class="col-lg-12 col-sm-12 col-xs-12 col-md-11 salary-block-full">
          <div class="row">
            <ul>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.employees_name_label'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.basic_salary_label'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.short_time_txt'); ?></b></li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.leaves_deduction_txt'); ?></b></li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.payable_amount_txt'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.overtime'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.advance_return_txt'); ?></b></li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.final_payable_txt'); ?></b></li>
            </ul>
          </div>
        </div>

          <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div class="col-lg-12 col-sm-12 col-xs-12 col-md-11 salary-block-full bg-white">
            <div class="row">
              <ul>
                <li><b><?php echo e($list['employee_name']); ?></b> </li>
                <li><b><?php echo e(number_format($list['tlt_salary'],2)); ?> <?php echo e($currency); ?></b> </li>
                <li><b><?php echo e($list['deduction']); ?> <?php echo e($currency); ?> <input type="hidden" name="deduction[]" class="salary-input" value="<?php echo e($list['deduction']); ?>" readonly="readonly" /></b></li>
                <li><b> <?php echo e($list['leaves_deduction']); ?> <?php echo e($currency); ?> <input type="hidden" name="leave_deduction[]" class="salary-input" value="<?php echo e($list['leaves_deduction']); ?>" readonly="readonly" /></b></li>
                <li><b><?php echo e($list['generated_pay']); ?> <?php echo e($currency); ?> <input type="hidden" name="generated_pay[]" class="salary-input" value="<?php echo e($list['generated_pay']); ?>" readonly="readonly" /></b> </li>
                <li><b> <?php echo e($list['overtime']); ?> <?php echo e($currency); ?> <input type="hidden" name="overtime[]" class="salary-input" value="<?php echo e($list['overtime']); ?>" readonly="readonly" /></b> </li>
                <li><b><?php echo e($list['loan_fixed_installment'] + $list['loan_temp_installment']); ?> <?php echo e($currency); ?> <input type="hidden" name="tlt_advance[]" class="salary-input" value="<?php echo e($list['loan_fixed_installment'] + $list['loan_temp_installment']); ?>" readonly="readonly" /></b></li>
                <li><b><?php echo e($list['net_amount']); ?> <?php echo e($currency); ?> <input type="hidden" name="net_amount[]" class="salary-input" value="<?php echo e($list['net_amount']); ?>" readonly="readonly" /></b></li>
              </ul>
            </div>
          </div>
          
          <input type="hidden" name="employee_id[]" value="<?php echo e($list['employee_id']); ?>" />
          <input type="hidden" name="loan_fixed_installment[]" value="<?php echo e($list['loan_fixed_installment']); ?>" />
          <input type="hidden" name="loan_temp_installment[]" value="<?php echo e($list['loan_temp_installment']); ?>" />
          
          <input type="hidden" name="department_id" value="<?php echo e($department_id); ?>" />
          <input type="hidden" name="salary_date" value="<?php echo e($date); ?>" />
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </form>
        <?php endif; ?>
          
        <?php if(isset($creates) && count($creates) > 0): ?>

        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-11 salary-block">
          <div class="row">
            <ul>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.employees_name_label'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.basic_salary_label'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.deduction_txt'); ?></b></li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.payable_amount_txt'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.overtime'); ?></b> </li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.advance_return_txt'); ?></b></li>
              <li><b><?php echo app('translator')->getFromJson('admin/employees.final_payable_txt'); ?></b></li>
            </ul>
          </div>
        </div>
          <?php $__currentLoopData = $creates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $create): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-11 col-sm-11 col-xs-12 col-md-11 salary-block bg-white">
              <div class="row">
                <ul>
                <li><h4><?php echo e($create['employee_name']); ?></h4></li>
                <li><b><?php echo e(number_format($create['tlt_salary'], 2)); ?> <?php echo e($currency); ?></b></li>
                <li><b><?php echo e($create['deduction'] + $create['leave_deduction']); ?> <?php echo e($currency); ?></b></li>
                <li><b><?php echo e($create['generated_pay']); ?> <?php echo e($currency); ?></b></li>
                <li><b><?php echo e($create['overtime']); ?> <?php echo e($currency); ?></b></li>
                <li><b><?php echo e($create['fix_advance'] + $create['temp_advance']); ?> <?php echo e($currency); ?></b></li>
                <li><b>
                  <?php echo e($create['generated_pay'] + $create['overtime'] - $create['fix_advance'] + $create['temp_advance']); ?> <?php echo e($currency); ?>

                </b></li>
              </ul>
              <div class="clearfix"></div>
              </div>
              
            </div>
          <div class="col-lg-1 col-md-1 col-xs-12 col-sm-1 no-padding unpaid_<?php echo e($create['employee_id']); ?>">
            <?php if(isset($create['status']) && $create['status'] == 0): ?>
              <button data-toggle="modal" data-target="#salaryModal" data-id="<?php echo e($create['id']); ?>" rel="tooltip" class="btn btn-block btn-pay"><?php echo app('translator')->getFromJson('admin/employees.pay_salary_btn'); ?></button>
            <?php else: ?>
              
              <div class="paid">
                <div class="col-lg-6 no-padding"><a href="<?php echo e(url('/salary/print/1', $create['id'])); ?>" class="btn btn-block border-radius-none sp-btn bg-color-skyblue"><i class="fa fa-eye" aria-hidden="true"></i></a></div>

                <div class="col-lg-6 no-padding"><a href="<?php echo e(url('/salary/print/2', $create['id'])); ?>" class="btn btn-block border-radius-none sp-btn bg-color-pink" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a></div>
              </div>
              
              
            <?php endif; ?>
          </div>
              
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        

      
    </div>
  </div>
</div>



<div class="modal fade" id="salaryModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content clearfix" id="salaryView">

      <div id="loadingtext"></div>

    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <script src="<?php echo e(asset('assets/dropdown/js/classie.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/dropdown/js/selectFx.js')); ?>" type="text/javascript"></script>
    
    <script type="text/javascript">
      (function() {
        [].slice.call( document.querySelectorAll('select.cs-select') ).forEach( function(el) {  
          new SelectFx(el);
        } );
      })();
    
    $('.datepicker').dateDropper();
 
    
    $(document).on('click', '#find_button', function(){
      $("#filter_form").submit();
    });

    $(document).on('click', '#button_create', function(){
      $("#salary_store").submit();
    });

    $('#salaryModal').on('show.bs.modal', function (event) {

      
      var count = 0;
      setInterval(function(){
        count++;
        document.getElementById('loadingtext').innerHTML = "Please Wait." + new Array(count % 5).join('.');
      }, 100);

      var ss = $('#salaryView');
      //ss.html('abc');
      var button = $(event.relatedTarget); 
      var id = button.data('id');
      $(ss).load(site.base_url + '/salary/view/' + id);

    });


  </script>
  <script type="text/javascript">
    $(".chosen").select2();
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>