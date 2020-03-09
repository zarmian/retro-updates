
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/email.email_templates_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/email.email_templates_heading'); ?></a></div>
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
        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-9 col-md-offset-9 col-lg-offset-6">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>
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
        <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
      <?php endif; ?>
      
      <div id="products" class="row list-group">
        <?php if(isset($templates) && count($templates) > 0): ?>
        <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


          <div class="col-lg-11 col-sm-10 col-xs-10 template-block">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li><?php echo app('translator')->getFromJson('admin/email.title_label'); ?>: <b> <?php echo e($template['title']); ?> </b></li>
                  <li style="width: 310px;"><?php echo app('translator')->getFromJson('admin/email.subject_label'); ?>: <b> <?php echo e($template['subject']); ?> </b></li>
                  

                  <li>
                    <?php echo app('translator')->getFromJson('admin/entries.invoice_paid_status'); ?>: 
                    <?php if($template['status'] == 1): ?>
                      <span class="increase-label label label-success"><?php echo app('translator')->getFromJson('admin/email.active_label'); ?></span>
                    <?php else: ?>
                      <span class="increase-label label label-danger"><?php echo app('translator')->getFromJson('admin/email.inactive_label'); ?></span>
                    <?php endif; ?>
                  </li>

                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
           
             
              <div class="col-sm-6 no-padding"><a href="<?php echo e(url('/email/templates/edit', $template['id'])); ?>" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
            
          </div>
    
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="col-xs-12">
           <?php echo $templates->appends(\Input::except('page'))->render(); ?>

          </div>
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