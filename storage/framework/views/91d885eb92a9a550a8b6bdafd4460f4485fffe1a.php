
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/users.create'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('/manage-users')); ?>"><?php echo app('translator')->getFromJson('admin/users.manage'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/users.create'); ?></a>
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

         <form data-toggle="validator" role="form" action="<?php echo e(url('manage-users/store')); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/users.person_detail_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/users.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="first_name" class="input_label"><?php echo app('translator')->getFromJson('admin/users.name_label'); ?></label>
                  <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.first_name_label'); ?>*" required="required" value="<?php echo e(old('first_name')); ?>" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="last_name" class="input_label">&nbsp;</label>
                  <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.last_name_label'); ?>*" required="required" value="<?php echo e(old('last_name')); ?>" />
                </div>

                

                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                  <label for="email" class="input_label"><?php echo app('translator')->getFromJson('admin/users.email_label'); ?>*</label>
                  <input type="email" name="email" id="email" class="form-control1" value="<?php echo e(old('email')); ?>" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="<?php echo app('translator')->getFromJson('admin/users.email_label'); ?>*" />
                </div>
               
                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="phone" class="input_label"><?php echo app('translator')->getFromJson('admin/users.phone_label'); ?>*</label>
                  <input type="text" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required="required" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.phone_label'); ?>*">
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                    <label for="cell" class="input_label"><?php echo app('translator')->getFromJson('admin/users.cell_label'); ?></label>
                    <input type="text" name="cell" id="cell" class="form-control1" value="<?php echo e(old('cell')); ?>" required="required" placeholder="<?php echo app('translator')->getFromJson('admin/users.cell_label'); ?>" />
                </div>


                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="gender" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.gender_label'); ?></label>
                  <select name="gender" id="gender" class="form-control1">
                  <?php if(isset($genders) && count($genders) > 0): ?>
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($gender->id); ?>"><?php echo e($gender->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                  </select>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="nationality" class="input_label"><?php echo app('translator')->getFromJson('admin/users.nationality_label'); ?></label>
                  <select name="nationality" id="nationality" class="form-control1" required="required">
                    <?php if(isset($countries) && count($countries) > 0): ?>
                      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('nationality') == $country->id): ?>
                          <option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->country_name); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                        <?php endif; ?>
                        
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>
                </div>



                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                  <label for="present_address" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.present_address_label'); ?>*</label>
                  <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.present_address_label'); ?>" value="<?php echo e(old('present_address')); ?>"  />
                </div>

                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                  <label for="present_address" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.permanant_address_label'); ?>*</label>
                  <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.permanant_address_label'); ?>" value="<?php echo e(old('permanant_address')); ?>" />
                </div>

                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/users.reference_label'); ?>"><?php echo e(old('reference')); ?></textarea>
                </div>

               


              </div>
              
            </div>


            

            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

              <div class="top_content">
                <h3><?php echo app('translator')->getFromJson('admin/users.users_credentials'); ?></h3>
                <p><?php echo app('translator')->getFromJson('admin/users.field_employee_text'); ?></p>
              </div>

              <div class="form_container">
                

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="employee_code" class="input_label"><?php echo app('translator')->getFromJson('admin/users.users_login_label'); ?></label>
                  <input type="text" name="employee_code" id="employee_code" readonly="readonly" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.username_label'); ?>*" value="<?php echo e($code); ?>" required="required">
                </div>

                <div class="col-md-8 col-sm-8 col-lg-8 col-xs-8 form-group">
                  <label for="username" class="input_label"><?php echo app('translator')->getFromJson('admin/users.users_login_label'); ?></label>
                  <input type="text" name="username" id="username" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.username_label'); ?>*" value="<?php echo e(old('username')); ?>" required="required">
                </div>

                

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <input type="password" name="password" id="password" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/users.password_label'); ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required="required" data-bv-identical-field="password_confirmation" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" value="" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" placeholder="<?php echo app('translator')->getFromJson('admin/users.c_password_label'); ?>" />
                </div>

                <div class="col-sm-12 form-group">
                  <label for=""><?php echo app('translator')->getFromJson('admin/common.password_note'); ?></label>
                </div>

                

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">

                  <label for="group" class="input_label"><?php echo app('translator')->getFromJson('admin/users.group_label'); ?></label>
                  <select name="group" id="group" class="form-control1" required="required">
                    <option value=""> <?php echo app('translator')->getFromJson('admin/users.select_option'); ?>  </option>

                    <?php if(isset($groups) && count($groups) > 0): ?>
                      <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(old('group') == $group->id): ?>
                          <option value="<?php echo e($group->id); ?>" selected="selected"><?php echo e($group->title); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($group->id); ?>"><?php echo e($group->title); ?></option>
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>
                
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/users.status_label'); ?>*</label>
                  <select name="status" id="status" class="form-control1" required="required">
                    <option value="1"><?php echo app('translator')->getFromJson('admin/users.active_option'); ?></option>
                    <option value="0"><?php echo app('translator')->getFromJson('admin/users.inactive_option'); ?></option>
                  </select>
                </div>



              </div>

            </div>

            <div class="col-sm-12">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-step mbtn btn-block" id="next"><?php echo app('translator')->getFromJson('admin/users.submit_button'); ?></button>
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