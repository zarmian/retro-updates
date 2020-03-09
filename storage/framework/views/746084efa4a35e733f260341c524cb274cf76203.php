<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/entries.sales_heading_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/entries.sales_heading_txt'); ?></a></div>
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
          <input type="text" name="invoice_no" id="invoice_no" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.enter_inovice_no_txt'); ?>" value="<?php echo e(\Request::get('invoice_no')); ?>"  />
        </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <select name="customer" id="customer" class="chosen form-control1">
          <option disabled selected="selected"> <?php echo app('translator')->getFromJson('admin/entries.customer_select_txt'); ?></option>
          <option value=""><?php echo app('translator')->getFromJson('admin/common.select_all_txt'); ?></option>
          <?php if(isset($customers) && count($customers) > 0): ?>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(Request::get('customer') == md5($customer->id)): ?>
                <option value="<?php echo e(md5($customer->id)); ?>" selected="selected"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
              <?php else: ?>
                <option value="<?php echo e(md5($customer->id)); ?>"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
       </div>

       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <select name="status" id="status" class="chosen form-control1">
          <option disabled selected="selected"> <?php echo app('translator')->getFromJson('admin/accounting.select_paid_status_filter'); ?></option>
          <option value=""><?php echo app('translator')->getFromJson('admin/common.select_all_txt'); ?></option>
          <option value="3" <?php if(Request::get('status') == "3"): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/entries.unpaid_txt'); ?></option>
          <option value="2" <?php if(Request::get('status') == "2"): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/entries.partial_paid_txt'); ?></option>
          <option value="1" <?php if(Request::get('status') == "1"): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/entries.paid_txt'); ?></option>
        </select>
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

      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin"><a href="<?php echo e(url('accounting/sales/add')); ?>" class="plus">+</a></div>

     

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
        <?php if(isset($sales) && count($sales) > 0): ?>
        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div class="list-block clearfix">
            <div class="col-lg-11 col-md-12 col-sm-12 col-xs-12 list-content-row">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li><?php echo app('translator')->getFromJson('admin/entries.invoice_number_txt'); ?>: <b> <?php echo app('translator')->getFromJson('admin/common.inv_prefix'); ?> <?php echo e($sale['invoice_number']); ?> </b></li>
                  <li><?php echo app('translator')->getFromJson('admin/entries.customer_label'); ?>: <b><?php echo e($sale['customer_name']); ?></b></li>
                  <li><?php echo app('translator')->getFromJson('admin/entries.invoice_date_label'); ?>: <b><?php echo e($sale['invoice_date']); ?></b></li>
                  <li><?php echo app('translator')->getFromJson('admin/entries.invoice_due_date_label'); ?>: <b><?php echo e($sale['due_date']); ?></b></li>
                  <li><?php echo app('translator')->getFromJson('admin/entries.tlt_txt'); ?>: <b> <?php echo e($sale['total']); ?></b></li>
                  <li>
                    <?php echo app('translator')->getFromJson('admin/entries.invoice_paid_status'); ?>: 
                    <?php if($sale['paid_status'] == 3): ?>
                      <span class="increase-label label label-danger"><?php echo app('translator')->getFromJson('admin/entries.unpaid_txt'); ?></span>
                    <?php elseif($sale['paid_status'] == 2): ?>
                      <span class="increase-label label label-warning"><?php echo app('translator')->getFromJson('admin/entries.partial_paid_txt'); ?></span>
                    <?php else: ?>
                      <span class="increase-label label label-success"><?php echo app('translator')->getFromJson('admin/entries.paid_txt'); ?></span>
                    <?php endif; ?>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 no-padding">
           
              <div class="col-sm-6 no-padding"><a href="<?php echo e(url('accounting/sales/detail/'.$sale['id'])); ?>" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
              <div class="col-sm-6 no-padding"><a href="<?php echo e(url('accounting/sales/edit/'.$sale['id'])); ?>" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
            
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

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".chosen").select2();
  });

  
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>