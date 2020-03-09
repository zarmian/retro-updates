
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/customers.edit_customer_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/customers')); ?>"><?php echo app('translator')->getFromJson('admin/customers.manage_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/customers.edit_customer_heading'); ?></a>
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

         <form data-toggle="validator" role="form" action="<?php echo e(url('accounting/customers/edit', $customer->id)); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <div class="form_container">

          
          
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/users.person_detail_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/users.field_employee_text'); ?></p>
            </div>

            <div class="form_container">


                <div class="col-md-2 col-sm-2 col-lg-2 col-xs-2 form-group">
                  <label for="code" class="input_label"><?php echo app('translator')->getFromJson('admin/customers.code_label'); ?>*</label>
                  <input type="text" name="code" id="code" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/customers.code_label'); ?>*" readonly="readonly" required="required" value="<?php echo e($customer->code); ?>" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="first_name" class="input_label"><?php echo app('translator')->getFromJson('admin/users.name_label'); ?></label>
                  <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.first_name_label'); ?>*" required="required" value="<?php echo e($customer->first_name); ?>" />
                </div>

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="last_name" class="input_label">&nbsp;</label>
                  <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.last_name_label'); ?>*" required="required" value="<?php echo e($customer->last_name); ?>" />
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="company" class="input_label"><?php echo app('translator')->getFromJson('admin/customers.company_label'); ?>*</label>
                  <input type="text" name="company" id="company" class="form-control1" value="<?php echo e($customer->company); ?>" placeholder="<?php echo app('translator')->getFromJson('admin/customers.company_label'); ?>" />
                </div>

                <div class="col-md-8 col-sm-8 col-lg-8 col-xs-8 form-group">
                  <label for="email" class="input_label"><?php echo app('translator')->getFromJson('admin/users.email_label'); ?>*</label>
                  <input type="email" name="email" id="email" class="form-control1" value="<?php echo e($customer->email); ?>" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="<?php echo app('translator')->getFromJson('admin/users.email_label'); ?>*" />
                </div>


                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="phone" class="input_label"><?php echo app('translator')->getFromJson('admin/users.phone_label'); ?>*</label>
                  <input type="text" name="phone" id="phone" value="<?php echo e($customer->phone); ?>" required="required" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.phone_label'); ?>*">
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                    <label for="mobile" class="input_label"><?php echo app('translator')->getFromJson('admin/users.cell_label'); ?></label>
                    <input type="text" name="mobile" id="mobile" class="form-control1" value="<?php echo e($customer->mobile); ?>" placeholder="<?php echo app('translator')->getFromJson('admin/users.cell_label'); ?>" />
                </div>


                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="fax" class="input_label"><?php echo app('translator')->getFromJson('admin/users.fax_label'); ?></label>
                  <input type="text" name="fax" id="fax" value="<?php echo e($customer->fax); ?>" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.fax_label'); ?>">
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="present_address" class="input_label"><?php echo app('translator')->getFromJson('admin/users.present_address_label'); ?></label>
                  <input type="text" name="present_address" id="present_address" value="<?php echo e($customer->present_address); ?>" required="required" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.present_address_label'); ?>">
                </div>


                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="permanent_address" class="input_label"><?php echo app('translator')->getFromJson('admin/users.permanant_address_label'); ?></label>
                  <input type="text" name="permanent_address" id="permanent_address" value="<?php echo e($customer->permanent_address); ?>" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.permanant_address_label'); ?>">
                </div>


                
                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="nationality" class="input_label" required="required"><?php echo app('translator')->getFromJson('admin/users.nationality_label'); ?></label>
                  <select name="nationality" id="nationality" class="form-control1" required="required">
                    <?php if(isset($countries) && count($countries) > 0): ?>
                      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($customer->country_id == $country->id): ?>
                          <option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->country_name); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                        <?php endif; ?>
                        
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>
                </div>

                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="state_label" class="input_label"><?php echo app('translator')->getFromJson('admin/users.state_label'); ?></label>
                  <input type="text" name="state" id="state" value="<?php echo e($customer->state); ?>"  class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.state_label'); ?>">
                </div>


                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="city" class="input_label"><?php echo app('translator')->getFromJson('admin/users.city_label'); ?></label>
                  <input type="text" name="city" id="city" value="<?php echo e($customer->city); ?>" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.city_label'); ?>">
                </div>


                <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="postal_code" class="input_label"><?php echo app('translator')->getFromJson('admin/users.postal_label'); ?></label>
                  <input type="text" name="postal_code" id="postal_code" value="<?php echo e($customer->postal_code); ?>"  class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.postal_label'); ?>">
                </div>



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/users.reference_label'); ?>"><?php echo e($customer->other); ?></textarea>
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
    $(document).ready(function (){
      $('form[data-toggle="validator"]').bootstrapValidator('revalidateField');
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>