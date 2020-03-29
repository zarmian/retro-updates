<?php $__env->startSection('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?php echo e(asset('assets/dropdown/css/normalize.css')); ?>" type="text/css" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/reports.statment_report_txt'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/reports.statment_report_txt'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="find-search">
  <div class="container">
    <div class="row">


    <form action="<?php echo e(url('/reports/statement')); ?>" method="post">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        
      
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
         
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="to" id="to" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($to) && $to <> ""): ?><?php echo e(date('m-d-Y', strtotime($to) )); ?><?php else: ?><?php echo e(date('m-d-Y', strtotime('last month'))); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="from" id="from" class="filter-date-input datedropper" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="<?php if(isset($from) && $from <> ""): ?><?php echo e(date('m-d-Y', strtotime($from) )); ?><?php else: ?><?php echo e(date('m-d-Y', time())); ?><?php endif; ?>" />
           </div>

           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="account" id="account" class="chosen form-control1">
              <option value=""><?php echo app('translator')->getFromJson('admin/reports.select_by_account_option_txt'); ?></option>
              
              <?php if(isset($accounts)  ): ?>
                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <optgroup label="<?php echo e($account['name']); ?>">
                  <?php if(isset($account['coa']) ): ?>
                    <?php $__currentLoopData = $account['coa']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(isset($account_id) && $account_id == $children['cid']): ?>
                        <option value="<?php echo e($children['cid']); ?>" selected="selected"> -- <?php echo e($children['name']); ?></option>
                      <?php else: ?>
                        <option value="<?php echo e($children['cid']); ?>"> -- <?php echo e($children['name']); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                  </optgroup>
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

      <?php if(isset($errors) && count($errors)>0  ): ?>
        <div class="alert alert-danger">
          <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          </div>
        <?php endif; ?>
      
      
      <div id="products" class="row list-group">

      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          

          <table class="table table-striped">
            
              <?php if(isset($results) && count($results) >0 ): ?>
              
              <div class="col-sm-9">
                <div class="reports-breads"><h2><b><?php echo app('translator')->getFromJson('admin/reports.statment_report_txt'); ?></b> <span class="filter-txt-highligh">(<?php echo e($to); ?> - <?php echo e($from); ?>) </span> (<?php echo e($results[0]['account_name']); ?>) </h2></div>
              </div>

              <div class="col-sm-3 text-center pull-right hidden-print">
                <div class="col-sm-5 no-padding-left pull-right"><a href="javascript:void(0)" onclick="window.print();" class="btn-default-xs btn-print-bg btn-block"> <?php echo app('translator')->getFromJson('admin/reports.print_txt'); ?> &nbsp;&nbsp; <i class="fa fa-print" aria-hidden="true"></i></a></div>
                
              </div>
               
                <tr>
                 
                  <th width="150"><?php echo app('translator')->getFromJson('admin/entries.invoice_number_txt'); ?></th>
                  <th width="200" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                  <th width="200" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.against_account_txt'); ?></th>
                  <th width="200" style="text-align: left;"><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100"><?php echo app('translator')->getFromJson('admin/accounting.type_dr'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/accounting.type_cr'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/accounting.balance_txt'); ?></th>
                </tr>

                <tr>
                  <th width="150"></th>
                  <th width="200" style="text-align: left;"></th>
                  <th width="200" style="text-align: left;"></th>
                  <th width="200" style="text-align: right;"><?php echo app('translator')->getFromJson('admin/reports.opening_txt'); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100"><?php echo e($opening_dr); ?> <?php echo e($currency); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"><?php echo e($opening_cr); ?> <?php echo e($currency); ?></th>
                  <th width="150" align="right" style="text-align: right;" width="100" style="text-align: right;"></th>
                </tr>
       
                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <th><b><?php echo e($row['code']); ?> </b></th>
                    <th><b><?php echo e($row['date']); ?></b></th>
                    <td align="left"><b><?php echo e($row['payment_detail']); ?></b></td>
                    <th width="200" style="text-align: left;"><?php echo e($row['description']); ?></th>
                    <td align="right"><?php echo e($row['debit']); ?> <?php echo e($currency); ?></td>
                    <td align="right"><?php echo e($row['credit']); ?> <?php echo e($currency); ?></td>
                    <td align="right"><?php echo e($row['balance']); ?> <?php echo e($currency); ?></td>
                  </tr>
                 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                

                <tr>
                    <th></th>
                    <th></th>
                    <th align="left"></th>
                    <th align="left"></th>
                    <th align="right" style="text-align: right"><?php echo e($tlt_dr); ?> <?php echo e($currency); ?></th>
                    <th align="right" style="text-align: right"><?php echo e($tlt_cr); ?> <?php echo e($currency); ?></th>
                    <th align="right" style="text-align: right"><?php echo e($tlt_balance); ?> <?php echo e($currency); ?></th>
                  </tr>
                
            
              <?php endif; ?>
            
          </table>

        </div>
      </div>


        
      </div>
      
    </div>
  </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
  $('.datedropper').dateDropper();
  $(".chosen").select2();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>