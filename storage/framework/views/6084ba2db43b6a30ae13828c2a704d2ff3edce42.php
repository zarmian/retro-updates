
<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?php echo e(asset('assets/dropdown/css/normalize.css')); ?>" type="text/css" rel="stylesheet">
<link href="<?php echo e(asset('assets/dropdown/css/cs-select.css')); ?>" type="text/css" rel="stylesheet">
<style type="text/css">


.select2-dropdown{
  top: 15px;
}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/reports.attendance_heading_txt'); ?>:  <?php echo e($date); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/reports.attendance_heading_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">

    <form action="<?php echo e(url('/reports/daily-attendance')); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        

      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4><?php echo app('translator')->getFromJson('admin/common.find_attendance_txt'); ?></h4>
          </div>
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="date" id="date" class="filter-date-input datepicker" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($date) && $date <> ""): ?><?php echo e(date('m-d-Y', strtotime($date) )); ?><?php else: ?><?php echo e(date('m-d-Y', time())); ?><?php endif; ?>" />
           </div>

          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="department" id="department" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_department'); ?></option>
              <option value="0"> <?php echo app('translator')->getFromJson('admin/common.select_all_txt'); ?> </option>
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
        
        <?php if(isset($attendances) && count($attendances) > 0): ?>
        <div class="row">

        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            

            <?php if(isset($attendance['list']) && count($attendance['list']) > 0): ?>
              <?php $__currentLoopData = $attendance['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="col-lg-12 col-sm-12 col-xs-12 payment-block">
                  <div class="col-sm-12 no-padding">
                    
                    <ul class="clearfix">
                      <li style="width: 230px;"><?php echo app('translator')->getFromJson('admin/shift.name_txt'); ?>: <b> <?php echo e($attendance['employee_name']); ?> </b></li>
                      <li style="width: 230px;"><?php echo app('translator')->getFromJson('admin/shift.start_time'); ?>: <b> <?php echo e($row['in_time']); ?> </b></li>
                      <li style="width: 230px;"><?php echo app('translator')->getFromJson('admin/shift.end_time'); ?>: <b> <?php echo e($row['out_time']); ?> </b></li>
                      <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/shift.description_label'); ?>: <b> <a href="#" data-toggle="modal" data-detail="<?php echo $row['detail']; ?>" data-target="#detailModal"><?php echo e(Str::limit($row['detail'], 10)); ?> </a> </b></li>
                      <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/shift.short_time_txt'); ?>: <b> <?php echo e($row['short_time']); ?> </b></li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
                
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            <?php else: ?>
              <div class="col-lg-12 col-sm-12 col-xs-12 payment-block" style="background: pink">
                  <div class="col-sm-12 no-padding">
                    
                    <ul class="clearfix">
                      <li style="width: 230px;"><?php echo app('translator')->getFromJson('admin/shift.name_txt'); ?>: <b> <?php echo e($attendance['employee_name']); ?> </b></li>
                      <li style="width: 200px;"><?php echo app('translator')->getFromJson('admin/shift.description_label'); ?>: <b> <?php echo e($attendance['detail']); ?> </b></li> <b> </b></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
            <?php endif; ?>
            

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php endif; ?>
        
      </div>
      
    </div>
  </div>
</div>
<!-- Modal -->
<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo app('translator')->getFromJson('admin/shift.today_activity_txt'); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo app('translator')->getFromJson('admin/shift.wait_txt'); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>


<script type="text/javascript">

$('#detailModal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget); // Button that triggered the modal
  var detail = button.data('detail'); // Extract info from data-* attributes
  $('.modal-body').html(detail);
  
});

$('.datepicker').dateDropper();
$(".chosen").select2();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>