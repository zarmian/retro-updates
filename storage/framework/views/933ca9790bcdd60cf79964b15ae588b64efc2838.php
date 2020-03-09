
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Manage Tax Rates</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active">Manage Tax Rates</a></div>
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

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin"><button class="plus" onclick="window.location = '<?php echo e(url('/accounting/tax/add')); ?>'">+</button></div>
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
        <?php if(isset($departments) && count($departments) > 0): ?>
        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail <?php if($department->status == 1): ?> active-status <?php else: ?> inactive-status <?php endif; ?>" style="min-height: 140px;">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name">Name: <?php echo e($department->name); ?></li>
                        <li class="detail">Rate: <?php echo e($department->rate); ?></li>
                      </ul>
                    </div>
                  </li>
                </ul>

                <?php if($department->type <> 2): ?>
                <ul class="inner-btn clearfix">
                  <li><a href="<?php echo e(url('/accounting/tax/edit', $department->id)); ?>" data-toggle="tooltip" title="Edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></li>
                  <li><a href="<?php echo e(url('/accounting/tax/remove', $department->id)); ?>" data-toggle="tooltip" title="Delete" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                </ul>
                <?php endif; ?>
           
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12"><?php echo $departments->appends(\Input::except('page'))->render(); ?></div>

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