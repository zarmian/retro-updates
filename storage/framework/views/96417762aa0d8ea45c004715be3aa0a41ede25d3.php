
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/common.noticeboard_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/common.noticeboard_heading'); ?></a></div>
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

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <input type="text" name="title" id="title" class="filter-date-input" placeholder="<?php echo app('translator')->getFromJson('admin/common.enter_tile_txt'); ?>" value="<?php echo e(\Request::get('title')); ?>"  />
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <input type="text" name="date" id="date" class="filter-date-input datepicker" data-init-set="false" placeholder="<?php echo app('translator')->getFromJson('admin/accounting.enter_date_txt'); ?>"   />
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

      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 plus-margin"><button class="plus" onclick="window.location = '<?php echo e(url('/noticeboard/create')); ?>'">+</button></div>



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
        <?php if(isset($notices) && count($notices) > 0): ?>
        <?php $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="list-block clearfix">
          <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12 list-content-row">
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li style="width: 300px;"><?php echo app('translator')->getFromJson('admin/common.date_txt'); ?>: <b> <?php echo e($notice['datetime']); ?> </b></li>
                  <li style="width: 300px;"><?php echo app('translator')->getFromJson('admin/common.title_label'); ?>: <b> <?php echo e($notice['title']); ?> </b></li>
                  
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>

          <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 no-padding">
           
              <div class="col-sm-12 no-padding"><a href="#" data-toggle="modal" data-target="#viewModal" data-id="<?php echo e($notice['id']); ?>" class="payment-btn-list btn-block btn-gray-bg" id="viewNotice"><i class="fa fa-eye" aria-hidden="true"></i></a>
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


<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog" role="document" id="modal-html">
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
    $('.chosen').select2(); 
  });
</script>
<script type="text/javascript">
  
  $(document).on('click', '#viewNotice', function(){

    var btn = $(this);
    var id = btn.attr('data-id');

    $('#modal-html').load(site.base_url + '/noticeboard/view/' + id);
    $("#modal-html").modal();
    
  });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>