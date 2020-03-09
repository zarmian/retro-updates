
<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/employees.manage'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  /
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/employees.manage'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('search'); ?>
<section class="find-search">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
        
        <div class="col-lg-9 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4><?php echo app('translator')->getFromJson('admin/employees.find_employee_txt'); ?></h4>
          </div>
          
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <!-- select option -->
            <input type="text" name="by_name" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/common.filter_by_name'); ?>" />
            <!-- select option -->
          </div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
          <!-- select option -->
          <select class="by_department chosen form-control1">
            <option value="" disabled><?php echo app('translator')->getFromJson('admin/employees.select_department'); ?></option>
            <?php if(isset($departments) && count($departments) > 0): ?>
              <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($department->id == app('request')->input('department')): ?>
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

        <div class="col-lg-3 no-padding clearfix">


        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 no-padding-left "></div>
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12 no-padding-left clearfix">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding clearfix plus-margin"><button class="plus" onclick="window.location = '<?php echo e(url('employees/create')); ?>'">+</button></div>

          
        </div>

        <div class="clearfix"></div>

      </div>


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
        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item col-xs-12 col-lg-4 "">
          <div class="thumbnail <?php if($employee['status'] == 1): ?> active-status <?php else: ?> inactive-status <?php endif; ?>">
            <div class="row">
              <div class="item">
                <ul>
                  <li class="emp-left">
                    <?php if(!empty($employee['avatar']) && $employee['avatar'] <> NULL): ?>
                    <img class="group list-group-image" src="<?php echo e(url('storage/app/employees/avatars/'.$employee['avatar'])); ?>" alt="" width="80"  height="80"><br>
                    <?php else: ?>
                    <img class="group list-group-image" src="<?php echo e(url('assets/images/img-person.jpg')); ?>" alt="" width="80"  height="80"><br>
                    <?php endif; ?>
                    <a href="<?php echo e(url('employees/edit/'.$employee['id'])); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="<?php echo e(url('employees/remove/'.$employee['id'])); ?>" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    <a href="<?php echo e(url('employees/view/'.$employee['id'])); ?>"><span class="fa fa-list" aria-hidden="true"></span></a>
                  </li>
                  <li class="emp-right">
                    <div class="caption">
                      <ul>
                        <li class="name"><?php echo e($employee['name']); ?> <?php echo $employee['present_status']; ?>

                        <div class="dest"><?php if(isset($employee['designation']) && $employee['designation'] <> ""): ?> <?php echo e($employee['designation']); ?>  <?php endif; ?> </div>
                      </li>
                      <li class="mobile"><?php echo app('translator')->getFromJson('admin/employees.email'); ?> <?php echo e($employee['email']); ?></li>
                      <li class="distnation"><?php echo app('translator')->getFromJson('admin/employees.dept'); ?>  <?php if(isset($employee['department']) && $employee['department'] <> ""): ?> <?php echo e($employee['department']); ?>  <?php endif; ?></li>
                      <li class="sallry"><?php echo app('translator')->getFromJson('admin/employees.adv'); ?> <?php echo e($tlt_loan[$employee['id']]['tlt_balance']); ?>/- &nbsp; <?php echo app('translator')->getFromJson('admin/employees.sal'); ?> <?php echo e($employee['salary']); ?>/-</li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div class="col-xs-12"><?php echo e($pages); ?></div>
      <?php else: ?>
      <div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div>
      <?php endif; ?>
      
      
    </div>
    
  </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
 
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

      $(document).on('change', '.by_department', function (){

        var x = $(this).val();
        var r = $('.by_role option:selected').attr('value');
        
        if(typeof r == "undefined"){
          r = '';
        }else{
         r = r;
         x = x;
        }

        window.location = '?department='+x+'&role='+r; // redirect
        return false;
      });

      $(document).on('change', '.by_role', function (){

        var x = $('.by_department option:selected').attr('value');
        var r = $(this).val();
        
        if(typeof x == "undefined"){
          x = '';
        }else{
         r = r;
         x = x;
        }

        window.location = '?department='+x+'&role='+r; // redirect
        return false;
      });


    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

<script type="text/javascript">
$(".chosen").select2();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>