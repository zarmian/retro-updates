
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/entries.ib_heading_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/interbank')); ?>"><?php echo app('translator')->getFromJson('admin/entries.ib_heading_txt'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/entries.create_ib_heading'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <?php if(Session::has('msg')): ?>
          <div class="alert alert-success">
            <?php echo e(Session::get('msg')); ?>

          </div>
          <?php endif; ?>
          
          <?php if(isset($errors) && count($errors) > 0): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
         <?php endif; ?>

         <form data-toggle="validator" role="form" action="<?php echo e(url('accounting/interbank/save')); ?>" method="POST" enctype="multipart/form-data" class="erp-form erp-ac-transaction-form">
         
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <div class="form_container">

          
          
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/entries.create_ib_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/users.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="invoice_no" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.entry_ib_code_txt'); ?>*</label>
                  
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><?php echo app('translator')->getFromJson('admin/entries.ib_txt'); ?></span>
                    <input type="text" name="code" id="code" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/entries.ib_entry_code_txt'); ?>*" value="<?php echo e($ib_code); ?>" required="required" readonly="readonly" style="border-bottom-left-radius: 0px;border-top-left-radius: 0px; background: #e0e0e0;" />
                  </div>
                  
                </div>


                 <div class="col-md-2 col-sm-2 col-lg-2 col-xs-2 form-group">
                  <label for="ref" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.reference_label'); ?></label>
                  <input type="text" name="ref" id="ref" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/entries.reference_label'); ?>" value="" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="date" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?>*</label>
                  <input type="text" name="date" id="date" class="form-control1 datepicker" placeholder="<?php echo app('translator')->getFromJson('admin/entries.date_label'); ?>" required="required" value="<?php echo e(old('date')); ?>" />
                </div>

                <div class="col-sm-12">
                  <table class="journal-table" width="100%" style="width: 100%">
                    <thead>
                        <tr>  
                            <th class="col-desc"><?php echo app('translator')->getFromJson('admin/entries.ib_from_label'); ?></th>
                            <th class="col-chart"><?php echo app('translator')->getFromJson('admin/entries.ib_to_label'); ?></th>
                            <th class="col-desc"><?php echo app('translator')->getFromJson('admin/entries.amt_txt'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                    
                      <tr>

                      <td class="col-chart" width="250" height="50">
                          <select name="account_from" id="account_from" required="required" class="chosen form-control1" tabindex="2">
                          <option value=""> <?php echo app('translator')->getFromJson('admin/entries.select_option_ib_bank_from_value'); ?> </option>
                          <?php if(isset($banks) && count($banks) > 0): ?>
                            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bank['id']); ?>"><?php echo e($bank['code']); ?> -- <?php echo e($bank['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                        </select>
                        </td>

                        <td class="col-chart" width="250" height="50">
                          <select name="account_to" id="account_to" required="required" class="chosen form-control1" tabindex="2">
                          <option value=""> <?php echo app('translator')->getFromJson('admin/entries.select_option_ib_bank_to_value'); ?> </option>
                          <?php if(isset($banks) && count($banks) > 0): ?>
                            <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bank['id']); ?>"><?php echo e($bank['code']); ?> -- <?php echo e($bank['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                        </select>
                        </td>


                        <td class="col-amount">
                            <input type="text" value="" name="transfer_amount" id="transfer_amount" data-bv-callback="true" data-bv-callback-message="Wrong answer" class="line_debit form-control1" placeholder="0.00" />
                        </td>

                        
                      </tr>                 

                            
                    </tbody>

                   

                    
                    <tfoot>

                      
                        <tr>

                            <th colspan="2" class="align-right"></th>
                            <th colspan="2" class="col-amount">
                                <div class="valid erp-ac-journal-diff"><?php echo app('translator')->getFromJson('admin/entries.error_debit_credit_equal'); ?></div>
                            </th>
                        </tr>

                        <tr>
                          <td height="15" colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="summery" id="summery" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/entries.reference_textarea_label'); ?>"><?php echo e(old('summery')); ?></textarea>
                </div>

                


              </div>
              
            </div>


            

            

            <div class="col-sm-10 col-sm-offset-2">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn"><?php echo app('translator')->getFromJson('admin/users.submit_button'); ?></button>
              
            </div>
            </div>
    
            </div>


        </form>


      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
$(".chosen").select2();
</script>

<script>



$(document).ready(function() {

    $('form[data-toggle="validator"]').bootstrapValidator()

  });
</script>

  <script type="text/javascript">
   
    $('.datepicker').dateDropper();
  </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>