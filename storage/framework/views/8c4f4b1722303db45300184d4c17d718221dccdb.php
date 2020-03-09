
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/employees.create'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  /
        <a href="<?php echo e(url('/employees')); ?>"><?php echo app('translator')->getFromJson('admin/employees.manage'); ?></a>  /
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/employees.create'); ?></a>
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
      <form id="accountForm" method="post" class="registration-form" action="<?php echo e(url('/employees/store')); ?>" style="margin-top: 20px;" enctype="multipart/form-data">
      

      <fieldset>
  
        <div class="form_container">

          
          
          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/employees.person_detail_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="first_name" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.employees_name_label'); ?></label>
                <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.first_name_label'); ?>*" required="required" value="<?php echo e(old('first_name')); ?>" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="last_name" class="input_label">&nbsp;</label>
                <input type="text"  name="last_name" id="last_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.last_name_label'); ?>*" required="required" value="<?php echo e(old('last_name')); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="gender" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.gender_label'); ?></label>
                <div class="btn-group btn-group-justified" data-toggle="buttons">

                <?php if(isset($genders) && count($genders) > 0): ?>
                  <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="btn btn-default btn-gender <?php if($gender->title == "Male"): ?> active <?php endif; ?>">
                        <input type="radio" name="gender" id="gender" autocomplete="off" <?php if($gender->title == "Male"): ?> checked="checked" <?php endif; ?> value="<?php echo e($gender->id); ?>" /> 
                        <span><?php echo e($gender->title); ?></span> <i class="fa <?php if($gender->title == "Male"): ?> fa-male <?php else: ?> fa-female <?php endif; ?>" aria-hidden="true"></i>
                    </label>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                
              </div>
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <div class="col-sm-12 text-left no-padding"><label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.dob_label'); ?></label></div>
                <div class="col-sm-3 col-xs-3 col-padding">
                  <input type="text" name="dob_day" id="dob_day" value="<?php echo e(old('dob_day')); ?>" class="datepicker form-control1 text-padding-5" required="required" data-format="d" data-fx="false" data-fx-mobile="true" placeholder="DD" />
                </div>

                <div class="col-sm-3 col-xs-3 col-padding">
                  <input type="text" name="dob_month" id="dob_month" value="<?php echo e(old('dob_month')); ?>" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" required="required" />
                </div>

                <div class="col-sm-6 col-xs-6 col-padding">
                  <input type="text" name="dob_year" id="dob_year" value="<?php echo e(old('dob_year')); ?>" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" required="required" data-fx="false" data-fx-mobile="true" />
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="national_id" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.national_id_label'); ?></label>
                <input type="text" name="national_id" id="national_id" class="form-control1" value="<?php echo e(old('national_id')); ?>"  placeholder="<?php echo app('translator')->getFromJson('admin/employees.national_id_label'); ?>">
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="nationality" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.nationality_label'); ?></label>
                <select name="nationality" id="nationality" class="chosen form-control1" required="required" style="width: 100%">
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


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="fathers_name" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.fathers_name_label'); ?></label>
                <input type="text" name="fathers_name" id="fathers_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.fathers_name_label'); ?>" value="<?php echo e(old('fathers_name')); ?>" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="mothers_name" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.mothers_name_label'); ?></label>
                <input type="text" class="form-control1" name="mothers_name" id="mothers_name" placeholder="<?php echo app('translator')->getFromJson('admin/employees.mothers_name_label'); ?>" value="<?php echo e(old('mothers_name')); ?>"  />
              </div>



              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="phone" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.email_label'); ?>*</label>
                <input type="email" name="email" id="email" class="form-control1" value="<?php echo e(old('email')); ?>" required="required" data-bv-emailaddress-message="The input is not a valid email address" placeholder="<?php echo app('translator')->getFromJson('admin/employees.email_label'); ?>*" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.phone_label'); ?>*</label>
                <input type="text" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required="required" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.phone_label'); ?>*">
              </div>


              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.present_address_label'); ?>" value="<?php echo e(old('present_address')); ?>"  />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.permanant_address_label'); ?>" value="<?php echo e(old('permanant_address')); ?>" />
              </div>

              <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
              <textarea name="reference" id="reference" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/employees.reference_label'); ?>"><?php echo e(old('reference')); ?></textarea>
              </div>

              


            </div>
            
          </div>


          

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">

            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/employees.employee_credentials'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="username" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.employee_login_label'); ?></label>
                <input type="text" name="username" id="username" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.username_label'); ?>*" value="<?php echo e(old('username')); ?>" required="required">
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="employee_code" id="employee_code" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.employee_code_label'); ?>" value="<?php echo e($code); ?>" readonly="readonly" required="required" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <input type="password" name="password" id="password" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.password_label'); ?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required="required" data-bv-identical-field="password_confirmation" />
              </div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" value="" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" placeholder="<?php echo app('translator')->getFromJson('admin/employees.c_password_label'); ?>" />
              </div>

              <div class="col-sm-12 input_label" style="margin-bottom: 10px;"><b><?php echo app('translator')->getFromJson('admin/common.password_note'); ?></b></div>
              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">

                <div class="col-sm-12 text-left no-padding"><label for="joining_day" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.joining_date_label'); ?></label></div>

                <div class="col-sm-3 col-padding">
                  <input type="text" name="joining_day" id="joining_day" class="datepicker form-control1 text-padding-5" required="required" data-format="d" data-fx="false" data-fx-mobile="true" placeholder="DD" value="<?php echo e(old('joining_day')); ?>" />
                </div>

                <div class="col-sm-3 col-padding ">
                  <input type="text" name="joining_month" id="joining_month" class="datepicker form-control1 text-padding-5" required="required" data-format="m" data-fx="false" data-fx-mobile="true" placeholder="MM" value="<?php echo e(old('joining_month')); ?>" />
                </div>

                <div class="col-sm-6 col-padding">
                  <input type="text" name="joining_year" id="joining_year"  placeholder="YYYY" class="datepicker form-control1 text-padding-5" required="required" data-format="Y" data-fx="false" data-fx-mobile="true" value="<?php echo e(old('joining_year')); ?>" />
                </div>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group no-padding-right">
                <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.role_label'); ?>*</label>
                <select name="group" id="group" class="form-control1" required="required">
                  <?php if(isset($roles) && count($roles) > 0): ?>
                  <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?> </option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(old('group') == $role->id): ?>
                        <option value="<?php echo e($role->id); ?>" selected="selected"><?php echo e($role->title); ?></option>
                      <?php else: ?>
                        <option value="<?php echo e($role->id); ?>"><?php echo e($role->title); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                <label for="" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.status_label'); ?>*</label>
                <select name="status" id="status" class="form-control1" required="required">
                  <option value="1"><?php echo app('translator')->getFromJson('admin/employees.active_option'); ?></option>
                  <option value="0"><?php echo app('translator')->getFromJson('admin/employees.inactive_option'); ?></option>
                </select>
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="department_id" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.department_label'); ?>*</label>
                <select name="department_id" id="department_id" class="form-control1" required="required">
                <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                  <?php if(isset($departments) && count($departments) > 0): ?>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($department->id == old('department_id')): ?>
                        <option value="<?php echo e($department->id); ?>" selected="selected"><?php echo e($department->title); ?></option>
                      <?php else: ?>
                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->title); ?></option>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="designation_id" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.designation_label'); ?>*</label>
                <select name="designation_id" id="designation_id" class="form-control1" required="required">
                <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?> </option>
                <?php if(isset($designations) && count($designations) > 0): ?>
                  <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($designation->id == old('designation_id')): ?>
                      <option value="<?php echo e($designation->id); ?>" selected="selected"><?php echo e($designation->title); ?></option>
                    <?php else: ?>
                      <option value="<?php echo e($designation->id); ?>"><?php echo e($designation->title); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="shift_id" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.shift_label'); ?>*</label>
                <select name="shift_id" id="shift_id" class="form-control1" required="required">
                <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                <?php if(isset($shifts) && count($shifts) > 0): ?>
                  <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($shift->id == old('shift_id')): ?>
                      <option value="<?php echo e($shift->id); ?>" selected="selected"><?php echo e($shift->title); ?></option>
                    <?php else: ?>
                      <option value="<?php echo e($shift->id); ?>"><?php echo e($shift->title); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
              </div>

              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="employee_type" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.employee_type_label'); ?></label>
                <select name="employee_type" id="employee_type" class="form-control1" required="required">
                <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                <?php if(isset($types) && count($types) > 0): ?>
                  <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($type->id == old('employee_type')): ?>
                      <option value="<?php echo e($type->id); ?>" selected="selected"><?php echo e($type->title); ?></option>
                    <?php else: ?>
                      <option value="<?php echo e($type->id); ?>"><?php echo e($type->title); ?></option>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
              </div>


              <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                <label for="allowed_leaves" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.employee_allowed_leaves'); ?></label>
                <select name="allowed_leaves" id="allowed_leaves" class="form-control1" required="required">
                <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                <?php if(isset($types) && count($types) > 0): ?>
                  <?php for($i=1; $i<=10; $i++): ?>
                    <?php if($type->id == old('allowed_leaves')): ?>
                      <option value="<?php echo e($i); ?>" selected="selected"><?php echo e($i); ?></option>
                    <?php else: ?>
                      <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                <?php endif; ?>
              </select>
              </div>

              <div class="col-sm-12 top_content form_container">
                <h3><?php echo app('translator')->getFromJson('admin/employees.employee_account_heading'); ?></h3>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="salary_type" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.salary_type_label'); ?></label>
                <select name="salary_type" id="salary_type" class="form-control1" required="required">
                  <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?> </option>
                  <?php if(isset($salaries) && count($salaries) > 0): ?>
                    <?php $__currentLoopData = $salaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(old('salary_type') == $salary->id): ?>
                        <option value="<?php echo e($salary->id); ?>" selected="selected"><?php echo e($salary->title); ?></option> 
                      <?php else: ?>
                        <option value="<?php echo e($salary->id); ?>"><?php echo e($salary->title); ?></option>
                      <?php endif; ?>
                      
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                <label for="basic_salary" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.basic_salary_label'); ?></label>
                <input type="text" name="basic_salary" id="basic_salary" class="form-control1" value="<?php echo e(old('basic_salary')); ?>" required="required" placeholder="15000.00" />
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-right">
                <label for="accommodation_allowance" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.allowance'); ?></label>
                <input type="text" name="accommodation_allowance" id="accommodation_allowance" class="form-control1" value="<?php echo e(old('accommodation_allowance')); ?>" placeholder="<?php echo app('translator')->getFromJson('admin/employees.accomodation'); ?>" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="medical_allowance" class="input_label">&nbsp;</label>
                <input type="text" name="medical_allowance" id="medical_allowance" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.medical'); ?>" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="transportation_allowance" class="input_label">&nbsp;</label>
                <input type="text" name="transportation_allowance" id="transportation_allowance" class="form-control1" value="<?php echo e(old('transportation_allowance')); ?>" placeholder="<?php echo app('translator')->getFromJson('admin/employees.transport'); ?>" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-left">
                <label for="food_allowance" class="input_label">&nbsp;</label>
                <input type="text" class="form-control1" name="food_allowance" id="food_allowance"  value="<?php echo e(old('food_allowance')); ?>"  placeholder="<?php echo app('translator')->getFromJson('admin/employees.food_allowance'); ?>"" />
              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding-right">
                <label for="overtime_1" class="input_label"><?php echo app('translator')->getFromJson('admin/employees.overtime'); ?></label>
                <input type="text" name="overtime_1" id="overtime_1" class="form-control1" value="<?php echo e(old('overtime_1')); ?>" placeholder="1.25%" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="overtime_2" id="overtime_2" class="form-control1" value="<?php echo e(old('overtime_2')); ?>" placeholder="1.50%" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group col-padding">
                <label for="" class="input_label">&nbsp;</label>
                <input type="text" name="overtime_3" id="overtime_3" class="form-control1" value="<?php echo e(old('overtime_3')); ?>" placeholder="2.50%" />
              </div>


            </div>

          </div>

          <div class="col-sm-12">
            <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
            <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <button type="button" class="btn btn-primary btn-step mbtn btn-block" id="next"><?php echo app('translator')->getFromJson('admin/employees.submit_next_button'); ?></button>
          </div>
          </div>
  
          </div>
        </fieldset>

        <fieldset>
          <div class="form_container">

          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/employees.employee_eduction_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

              <div class="eduction-container">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="degree"><?php echo app('translator')->getFromJson('admin/employees.degree_label'); ?></label>
                <input type="text" name="degree[]" id="degree" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.degree_label'); ?>" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="year"><?php echo app('translator')->getFromJson('admin/employees.year_label'); ?></label>
                <input type="text" name="year[]" id="year" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="grade"><?php echo app('translator')->getFromJson('admin/employees.grade_label'); ?></label>
                <select name="grade[]" id="grade" class="form-control1">
                   <option value="A+">A+</option>
                   <option value="A">A</option>
                   <option value="B+">B+</option>
                   <option value="B">B</option>
                   <option value="C">C</option>
                   <option value="D">D</option>
                   <option value="E">E</option>
                   <option value="F">F</option>
                 </select>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="total_marks"><?php echo app('translator')->getFromJson('admin/employees.total_marks_label'); ?></label>
                <input type="text" name="total_marks[]" id="total_marks" placeholder="1100" class="form-control1" />
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">
                <label for="obtain_marks"><?php echo app('translator')->getFromJson('admin/employees.obtain_marks_label'); ?></label>
                <input type="text" class="form-control1" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" placeholder="950">
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="institute"><?php echo app('translator')->getFromJson('admin/employees.institute_label'); ?></label>
                <input type="text" name="institute[]" id="institute" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.institute_label'); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for=""><?php echo app('translator')->getFromJson('admin/employees.institute_country_label'); ?></label>


                <select name="institute_country[]" id="institute_country" class="chosen form-control1" style="width: 100%;">
                <?php if(isset($countries) && count($countries) > 0): ?>
                  <option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>
                  <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </select>
              </div>

              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">
                <button type="button" class="btn btn-primary mbtn add-more-btn btn-block"><?php echo app('translator')->getFromJson('admin/employees.add_more_button'); ?></button>
              </div>

              <div class="col-md-12"></div>

              </div>

              

              <div class="add_more_education"></div>

            </div>


          </div>


          <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/employees.job_experience_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/employees.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

              <div class="experience-container">

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="job_title_1"><?php echo app('translator')->getFromJson('admin/employees.job_title_label'); ?></label>
                <input type="text" name="job_title[]" id="job_title_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.job_title_label'); ?>" />
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="company_name_1"><?php echo app('translator')->getFromJson('admin/employees.company_name_label'); ?></label>
                <input type="text" name="company_name[]" id="company_name_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.company_name_label'); ?>" />
              </div>


              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="location_country_1"><?php echo app('translator')->getFromJson('admin/employees.location_country_label'); ?></label>
                <select name="location_country[]" id="location_country_1" class="form-control1 chosen" style="width: 100%;">
                    <?php if(isset($countries) && count($countries) > 0): ?>
                      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </select>
              </div>

              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">
                <label for="location_city_1"><?php echo app('translator')->getFromJson('admin/employees.location_city_label'); ?></label>
                <input type="text" name="location_city[]" id="location_city_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.location_city_label'); ?>" />
              </div>

              <div class="col-sm-12 col-md-12 col-lg-12 col-xs 12 col-padding"><i><?php echo app('translator')->getFromJson('admin/employees.current_working'); ?></i></div>


              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                  <label for="start_month_1"><?php echo app('translator')->getFromJson('admin/employees.join_date_label'); ?> </label>
                  <input type="text" name="start_month[]" id="start_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" />

                </div>

                <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                  <label for="start_year_1">&nbsp; </label>

                  <input type="text" name="start_year[]" id="start_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />
                </div>




              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                <label for="end_month_1"><?php echo app('translator')->getFromJson('admin/employees.to_date_label'); ?></label>
               <input type="text" name="end_month[]" id="end_month_1" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" data-init-set="false" />
              </div>

              <div class="col-md-2 col-sm-2 col-lg-2 col-xs-6 form-group col-padding">
                <label for="end_year_1">&nbsp;</label>

               <input type="text" name="end_year[]" id="end_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" data-init-set="false" />

              </div>


              <div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">
                
                <button type="button" class="btn btn-primary mbtn add-more-btn-exp btn-block"><?php echo app('translator')->getFromJson('admin/employees.add_more_button'); ?></button>
              </div>


              </div>

              

              <div class="add_more_experience"></div>

            </div>

          </div>

          <div class="col-sm-12 no-padding">
            <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
            <label for="" class="input_label">&nbsp;</label>
            <button type="submit" name="submitButton" id="submitButton" class="btn btn-primary mbtn btn-block"><?php echo app('translator')->getFromJson('admin/employees.submit_button'); ?></button>
          </div>
          </div>
            
          </div>
        </fieldset>
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

        </form>

      </div>
      
      
      
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">

    $(document).ready(function() {

      $('.registration-form fieldset:first-child').fadeIn('slow').show();

      $("#next").click(function () {
        $('#accountForm').bootstrapValidator('validate');
      });

      ValidateIt();
    });

    function ValidateIt() {
        $('#accountForm').bootstrapValidator({
                excluded: [':disabled'],
          }).on('status.field.bv', function(e, data) {

                data.element
                .data('bv.messages')
                .find('.help-block[data-bv-for="' + data.field + '"]').hide();

            }).on('success.form.bv', function (e) {

              $('input[type="submit"]').prop('disabled', false);
              var parent_fieldset = $('.registration-form .btn-step').parents('fieldset');
              var next_step = true;

              if (next_step) {
                  parent_fieldset.fadeOut(400, function () {
                      $(this).next().fadeIn();
                  });
                  $("#submitButton").attr('disabled', false);
              }
            });
      }


    $(document).on('click', '.add-more-btn', function (){

      var html = '';
      var year_html = $("#year").html();
      var institute_country = $('#institute_country').html();

      var btn = $(this);
      btn.closest('.add-more-col').find('button').html('REMOVE').attr('data-id', 'remove').removeClass('btn-primary add-more-btn').addClass('btn-danger remove-more-btn');
        
        html += '<div class="eduction-container">';
        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for="degree"><?php echo app('translator')->getFromJson('admin/employees.degree_label'); ?></label>';
          html += '<input type="text" name="degree[]" id="degree" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.degree_label'); ?>" />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="year"><?php echo app('translator')->getFromJson('admin/employees.year_label'); ?></label>';
          html += '<input type="text" name="year[]" id="year" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true"  />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="grade">Grade</label>';
          html += '<select name="grade[]" id="grade" class="form-control1">';
             html += '<option value="A+">A+</option>';
             html += '<option value="A">A</option>';
             html += '<option value="B+">B+</option>';
             html += '<option value="B">B</option>';
             html += '<option value="C">C</option>';
             html += '<option value="D">D</option>';
             html += '<option value="E">E</option>';
             html += '<option value="F">F</option>';
           html += '</select>';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="total_marks"><?php echo app('translator')->getFromJson('admin/employees.total_marks_label'); ?></label>';
          html += '<input type="text" name="total_marks[]" id="total_marks" placeholder="1100" class="form-control1" />';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding">';
          html += '<label for="obtain_marks"><?php echo app('translator')->getFromJson('admin/employees.obtain_marks_label'); ?></label>';
          html += '<input type="text" class="form-control1" name="obtain_marks[]" id="obtain_marks" class="form-control" value="" placeholder="950" />';
        html += '</div>';

        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for="institute"><?php echo app('translator')->getFromJson('admin/employees.institute_label'); ?></label>';
          html += '<input type="text" name="institute[]" id="institute" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.institute_label'); ?>" />';
        html += '</div>';

        html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
          html += '<label for=""><?php echo app('translator')->getFromJson('admin/employees.institute_country_label'); ?></label>';
          html += '<select name="institute_country[]" id="institute_country" class="form-control1 chosen" style="width: 100%;">'+institute_country+'</select>';
        html += '</div>';

        html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">';
          html += '<button type="button" class="btn btn-primary mbtn add-more-btn btn-block"><?php echo app('translator')->getFromJson('admin/employees.add_more_button'); ?></button>';
        html += '</div>';
        html += '<div class="col-md-12"></div>';
        html += '</div>';


        $('.add_more_education').append(html);
        $(".chosen").select2();
        $('.datepicker').dateDropper();
        
    });


    $(document).on('click', '.add-more-btn-exp', function (){

      var html = '';
      var year_html = $("#year").html();
      var institute_country = $('#institute_country').html();

      var btn = $(this);
      btn.closest('.add-more-col').find('button').html('REMOVE').attr('data-id', 'remove').removeClass('btn-primary add-more-btn-exp').addClass('btn-danger remove-more-btn-exp');
        
        html += '<div class="experience-container">';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="job_title_1"><?php echo app('translator')->getFromJson('admin/employees.job_title_label'); ?></label>';
            html += '<input type="text" name="job_title[]" id="job_title_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.job_title_label'); ?>" />';
          html += '</div>';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="company_name_1"><?php echo app('translator')->getFromJson('admin/employees.company_name_label'); ?></label>';
            html += '<input type="text" name="company_name[]" id="company_name_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.company_name_label'); ?>" />';
          html += '</div>';


          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="location_country_1"><?php echo app('translator')->getFromJson('admin/employees.location_country_label'); ?></label>';
            html += '<select name="location_country[]" id="location_country_1" class="form-control1 chosen" style="width: 100%;">';
            <?php if(isset($countries) && count($countries) > 0): ?>
             html += '<option value=""><?php echo app('translator')->getFromJson('admin/employees.select_option'); ?></option>';
            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 html += '<option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>';
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
          html += '</select>';
          html += '</div>';

          html += '<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12 form-group col-padding">';
            html += '<label for="location_city_1"><?php echo app('translator')->getFromJson('admin/employees.location_city_label'); ?></label>';
            html += '<input type="text" name="location_city[]" id="location_city_1" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/employees.location_city_label'); ?>" />';
          html += '</div>';

          html += '<div class="col-sm-12 col-md-12 col-lg-12 col-xs 12 col-padding"><i><?php echo app('translator')->getFromJson('admin/employees.current_working'); ?></i></div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="start_month_1"><?php echo app('translator')->getFromJson('admin/employees.join_date_label'); ?></label>';

            html += '<input type="text" name="start_month[]" id="start_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" />';

          html += '</div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="start_year_1">&nbsp;</label>';

            html += '<input type="text" name="start_year[]" id="start_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" />';

            
          html += '</div>';


          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="end_month_1"><?php echo app('translator')->getFromJson('admin/employees.to_date_label'); ?></label>';

            html += '<input type="text" name="end_month[]" id="end_month_1" value="" class="datepicker form-control1 text-padding-5" data-format="m" placeholder="MM" data-init-set="false" />';

          
          html += '</div>';

          html += '<div class="col-md-2 col-sm-2 col-lg-2 col-xs-4 form-group col-padding">';
            html += '<label for="end_year_1">&nbsp;</label>';

            html += '<input type="text" name="end_year[]" id="end_year_1" class="form-control1 datepicker" data-format="Y" placeholder="YYYY" data-fx="false" data-fx-mobile="true" data-init-set="false" />';
          html += '</div>';

          
          
          html += '<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12 form-group col-padding add-more-col">';
            html += '<button type="button" class="btn btn-primary mbtn add-more-btn-exp btn-block">ADD MORE</button>';
          html += '</div>';


          html += '</div>';


        $('.add_more_experience').append(html);
        $(".chosen").select2();
        $('.datepicker').dateDropper();

        
    });

    $(document).on('click', '.remove-more-btn', function (){
      var btn = $(this);
      btn.closest('.eduction-container').remove();
    });

    $(document).on('click', '.remove-more-btn-exp', function (){
      var btn = $(this);
      btn.closest('.experience-container').remove();
    });

    $('.datepicker').dateDropper();

    </script>

    <script type="text/javascript">
      $(".chosen").select2();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>