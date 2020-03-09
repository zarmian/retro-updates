<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/vendors.manage_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/vendors.manage_heading'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">

      <div class="">
      
      <form action="" method="GET">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <input type="text" name="name" id="name" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.vendor_name'); ?>" value="<?php echo e(\Request::get('name')); ?>"  />
       </div>

       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <input type="text" name="email" id="email" class="filter-date-input"  placeholder="<?php echo app('translator')->getFromJson('admin/accounting.vendor_email'); ?>" value="<?php echo e(\Request::get('email')); ?>" />
       </div>

       <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <button type="submit" class="search"><i class="fa fa-search" aria-hidden="true"></i></button>
       </div>
      </form>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin"><a href="<?php echo e(url('accounting/vendors/add')); ?>" class="plus">+</a></div>

          
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
        <?php if(isset($customers) && count($customers) > 0): ?>
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="item col-md-6 col-sm-6 col-xs-12 col-lg-3 grid-group-item">
          <div class="thumbnail">
            <div class="row">
            <div class="item grid-group-item">
              <ul>
                 
                   <li class="">
                    <div class="caption">
                    <ul>
                      <li class="name"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?>

                        <div class="dest"><b><?php echo app('translator')->getFromJson('admin/accounting.company_name'); ?>: </b> <?php echo e($customer->company); ?> </div>
                        <div class="dest"><?php echo app('translator')->getFromJson('admin/users.cell'); ?> <?php echo e($customer->mobile); ?> </div>
                        <div class="dest"><?php echo app('translator')->getFromJson('admin/users.email'); ?> <?php echo e($customer->email); ?> </div>
                      </li>
                     </ul>
                     </div>
                     <div>
                        <a href="<?php echo e(url('accounting/vendors/edit/'.$customer->id)); ?>" data-toggle="tooltip"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                        <a href="<?php echo e(url('accounting/vendors/remove/'.$customer->id)); ?>" class="is_delete" data-toggle="tooltip"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>

                        <a href="<?php echo e(url('accounting/vendors/view/'.$customer->id)); ?>" data-toggle="tooltip"><span class="fa fa-list" aria-hidden="true"></span></a>

                     </div>
                    </li>
                    <li></li>
                </ul>
            </div>
            </div>
          </div>
        </div>


        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="col-xs-12">
            <?php echo $customers->appends(\Input::except('page'))->render(); ?>

          </div>
        <?php else: ?>
          <div class="col-xs-12"><div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div></div>
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