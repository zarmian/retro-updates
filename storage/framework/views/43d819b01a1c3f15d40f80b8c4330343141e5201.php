


<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/loans.view_loan_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('employees')); ?>"><?php echo app('translator')->getFromJson('employees/common.dashboard_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/loans.view_loan_txt'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
  
    <?php if(Session::has('msg')): ?>
      <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
    <?php endif; ?>
    

      <form action="<?php echo e(url('/employees/loans/show', $loan['id'])); ?>" method="POST">
      <div class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-sm-offset-0">
      <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  
        <div class="panel">

        <div class="panel-body">

          
          
          <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 ">
            <div class="top_content">
              <h3><b><?php echo app('translator')->getFromJson('admin/loans.view_loan_txt'); ?></b></h3>
            </div>

            <div class="">

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <h4><b><?php echo app('translator')->getFromJson('admin/loans.employee_label'); ?>:</b> <?php echo e($loan['employee_name']); ?></h4>
              </div>
              
              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                <b><?php echo app('translator')->getFromJson('admin/loans.title_txt'); ?>: </b>
                <p><?php echo e($loan['title']); ?></p>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                
                <b><?php echo app('translator')->getFromJson('admin/loans.date_txt'); ?>: </b>
                <p><?php echo e($loan['date']); ?></p>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group no-padding-left">
                
                <b><?php echo app('translator')->getFromJson('admin/loans.adv_amount_txt'); ?>: </b>
                <p><?php echo e($loan['amount']); ?></p>
              </div>



              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <b><?php echo app('translator')->getFromJson('admin/loans.description_txt'); ?>:</b>
                <p><?php echo e($loan['description']); ?></p>
              </div>


              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group no-padding-left">
                <label for=""><?php echo app('translator')->getFromJson('admin/loans.approved_txt'); ?>:</label>
                <textarea name="detail" id="detail" cols="30" rows="10" class="form-control2"><?php echo e($loan['approved_description']); ?></textarea>
              </div>



              
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group no-padding-left form-group">
                <label for=""><?php echo app('translator')->getFromJson('admin/loans.status_txt'); ?>:</label>
                <select name="status" id="status" class="form-control1">
                  <option value="0" <?php if($loan['status'] == 0): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/loans.pending_txt'); ?></option>
                  <option value="1" <?php if($loan['status'] == 1): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/loans.accpect_txt'); ?></option>
                  <option value="2" <?php if($loan['status'] == 2): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('admin/loans.reject_txt'); ?></option>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="type"><?php echo app('translator')->getFromJson('admin/loans.type_label'); ?></label>
                <select name="type" id="type" class="form-control1" onchange="getLoanStatement();">
                  <option value="" selected="selected"><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                  <option value="1"><?php echo app('translator')->getFromJson('admin/loans.type_option_fix'); ?></option>
                  <option value="2"><?php echo app('translator')->getFromJson('admin/loans.type_option_tmp'); ?></option>
                </select>
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="installment"><?php echo app('translator')->getFromJson('admin/loans.installment_label'); ?></label>
                <input type="text" name="installment" id="installment" required="required" class="form-control1">
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <label for="">&nbsp;</label>
                <input type="submit" value="<?php echo app('translator')->getFromJson('admin/common.button_submit'); ?>" class="btn btn-primary btn-block">
              </div>
              

            </div>
            
          </div>

          </div>


          

          </div>


      </div>
      </form>
      
      
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>