<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Payment Recieved Voucher</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active">Payment Recieved Voucher</a></div>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <input type="text" name="code" id="code" class="filter-date-input" placeholder="PR Code" value="<?php echo e(\Request::get('code')); ?>"  />
       </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <input type="text" name="date" id="date" class="filter-date-input datepicker" data-init-set="false" placeholder="" value="<?php echo e(\Request::get('date')); ?>"  />
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
        <a href="<?php echo e(url('accounting/payments/received/add')); ?>" class="plus">+</a></div>


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
        <?php if(isset($journals)  ): ?>
        <?php $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div class="list-block clearfix">
            <div class="col-lg-11 col-sm-12 col-xs-12 list-content-row">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li><?php echo app('translator')->getFromJson('admin/entries.entry_no_txt'); ?>: <b> <?php echo e($journal['code']); ?> </b></li>
                  <li style="width: 282px;"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?>: <b><?php echo e($journal['date']); ?></b></li>
                  <li style="width: 282px;"><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?>: <b><?php echo e($journal['description']); ?></b></li>
                  <li><?php echo app('translator')->getFromJson('admin/entries.tlt_txt'); ?>: <b> <?php echo e($journal['amount']); ?> </b></li>
                  <li>
                    
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-12 col-xs-12 no-padding">
           
              <div class="col-sm-6 no-padding"><a href="<?php echo e(url('accounting/payments/received/detail/'.$journal['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
              <div class="col-sm-6 no-padding"><a href="<?php echo e(url('accounting/payments/received/edit/'.$journal['id'])); ?>" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
            
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