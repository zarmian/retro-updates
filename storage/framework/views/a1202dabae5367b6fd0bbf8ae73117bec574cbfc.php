<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Manage Products</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active">Manage Products</a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">

      <form action="" method="GET">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <input type="text" name="name" id="name" class="filter-date-input" placeholder="Product Name" value="<?php echo e(\Request::get('name')); ?>"  />
       </div>

       <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 plus-margin">
        <button type="submit" class="search"><i class="fa fa-search" aria-hidden="true"></i></button>
       </div>
      </form>

    
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
          <select class="select-page" id="per_page">
            <option value="12" <?php if($per_page == 12): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_12'); ?></option>
              <option value="24" <?php if($per_page == 24): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_24'); ?></option>
              <option value="50" <?php if($per_page == 50): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_50'); ?></option>
              <option value="100" <?php if($per_page == 100): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/common.per_page_100'); ?></option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin">
        <a href="<?php echo e(url('accounting/items/add')); ?>" class="plus">+</a></div>


    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
     

      <?php if(Session::has('msg')): ?>
        <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
      <?php endif; ?>


      <div id="products" class="list-group">

      <div class="row">
        <?php if(isset($items) && count($items) > 0): ?>
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        
        
          
           <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name">Name: <b> <?php echo e($item['name']); ?></li>
                        <li class="name">Available Quantity: <b> <?php echo e($item['price']); ?></li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <ul class="inner-btn clearfix">

                  <li><a href="<?php echo e(url('accounting/items/delete/'.$item['id'])); ?>" data-toggle="tooltip" title="Delete" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                </ul>
           
            </div>
          </div>
        </div>
        

      
          
         



        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <div class="col-xs-12">
            <?php echo $pages; ?>

          </div>
        <?php else: ?>
          <div class="alert alert-warning"><?php echo app('translator')->getFromJson('admin/messages.not_found'); ?></div>
        <?php endif; ?>

        </div>
        
        
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

    $('.chosen').select2();
  });

  $('.datepicker').dateDropper();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>