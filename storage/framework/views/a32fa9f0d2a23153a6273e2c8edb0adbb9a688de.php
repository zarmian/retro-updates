

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('employees/common.request_leave_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('employees/common.dashboard_heading'); ?></a>  / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('employees/common.request_leave_txt'); ?></a>
      </div>
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

        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-8 col-md-offset-9 col-lg-offset-3">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>

        </div>

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin">
          <a href="<?php echo e(url('/leave-request/create')); ?>" class="plus">+</a>
        </div>

          
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
      
      <div id="products" class="row">
        <?php if(isset($leaves) && count($leaves) > 0): ?>
        <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        

        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name"><?php echo $leave['title']; ?> </li>
                        <li class="timing"><b><?php echo app('translator')->getFromJson('admin/leaves.date_text'); ?></b> <?php echo e(array_first($leave['leave_date'])); ?> <b><?php echo app('translator')->getFromJson('admin/leaves.to_text'); ?></b> <?php echo e(array_last($leave['leave_date'])); ?></li>

                          <?php if($leave['status'] == 1): ?>
                            <li><span class="label label-success"><?php echo app('translator')->getFromJson('employees/common.approved_txt'); ?></span></li>
                          <?php elseif($leave['status'] == 2): ?>
                            <li> <span class="label label-danger"><?php echo app('translator')->getFromJson('employees/common.rejected_approval_txt'); ?></span></li>
                          <?php else: ?>
                            <li> <span class="label label-warning"><?php echo app('translator')->getFromJson('employees/common.pending_approval_txt'); ?></span></li>
                          <?php endif; ?>
                        
                      </ul>
                    </div>
                  </li>
                </ul>
                <ul class="inner-btn clearfix">
                  <li><a href="<?php echo e(url('/leave-request/edit', $leave['id'])); ?>" data-toggle="tooltip" title="<?php echo app('translator')->getFromJson('employees/common.edit_tooltip'); ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></li>
                 <?php if($leave['status'] == 0): ?>
                  <li><a href="<?php echo e(url('/leave-request/remove', $leave['id'])); ?>" data-toggle="tooltip" title="<?php echo app('translator')->getFromJson('employees/common.delete_tooltip'); ?>" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                   <?php endif; ?>
                   <li><a href="javascript:void(0);" data-toggle="modal" data-target="#leaveModal" data-id="<?php echo e($leave['id']); ?>" rel="tooltip" title="<?php echo app('translator')->getFromJson('employees/common.view_detail_txt'); ?>"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
                </ul>
           
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12"><?php echo $pages; ?></div>
        <?php else: ?>
        <div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div>
        <?php endif; ?>
        
        
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content clearfix" id="leaveRequestView">
    </div>
  </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
  $('#leaveModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var id = button.data('id');
  $('#leaveRequestView').load(site.base_url + '/leave-request/view/' + id);

});
</script>
  
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