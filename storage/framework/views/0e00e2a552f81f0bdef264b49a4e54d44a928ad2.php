

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/profile.manage_profile'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="javascript:void();" class="active"><?php echo app('translator')->getFromJson('admin/profile.manage_profile'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/slim/slim.min.css')); ?>">
<style type="text/css">
    .avatar .slim {
        /*width: 240px;*/
        border-radius: 50%;
    }
    
</style>

<div style="height: 200px;">
 <?php if($user->cover <> NULL && file_exists(storage_path().'/app/employees/covers/'.$user->cover)): ?>
     
<div class="profile_image" style="background: url('<?php echo e(asset('storage/app/employees/covers/'.$user->cover)); ?>'); background-size: 100% 100%;"></div>
<?php else: ?>

<div class="profile_image" style="background: url('<?php echo e(asset('storage/app/employees/covers/bg-solid-dark-grey.png')); ?>'); background-size: 100% 100%;"></div>
<?php endif; ?> 

</div>

<div class="margin-top">&nbsp;</div>
<div class="margin-top">&nbsp;</div>
<div class="container mainwrapper margin-top">
    <div class="row">
        <div class="col-sm-4 col-lg-4 col-xs-12 col-md-4">
            <div class="avatar_area text-center">
                <div class="profile-avatar">
                    <div class="avatar droper">
                         <?php if($user->avatar <> NULL && file_exists(storage_path().'/app/employees/avatars/'.$user->avatar)): ?>
                            <img src="<?php echo e(asset('storage/app/employees/avatars/'.$user->avatar)); ?>" alt="">
                          <?php else: ?>
                          <img src="<?php echo e(asset('storage/app/employees/avatars/img-person.jpg')); ?>" alt="">
                         <?php endif; ?>
                    </div>
                    <h2><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h2>
                    <p><b><?php echo app('translator')->getFromJson('employees/common.department_txt'); ?> </b> <?php echo e($user->department->title); ?></p>
                </div>
            </div>
        </div>

        <div class="col-sm-8 col-lg-8 col-xs-12 col-md-8">

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
            
            <div>

              <!-- Nav tabs -->
              <ul class="nav nav-tabs profile-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('employees/common.profile_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#account" aria-controls="notice" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('employees/common.profile_accounts_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#qdetaul" aria-controls="notice" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('employees/common.profile_qualification_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#exptab" aria-controls="notice" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('employees/common.profile_experience_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#attendance" aria-controls="attendance" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('admin/profile.attendance_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
                <li role="presentation"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('admin/profile.notice_board_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="profile">
                    <div>

                        <div class="row">
                          
                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading"><h2><?php echo app('translator')->getFromJson('employees/common.personal_detail'); ?></h2></div>
                              <div class="detail_area">
                                <h3><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> <span class="circle-box pull-right"><i class="fa fa-<?php echo e(strtolower($user->genders->title)); ?>"></i></span></h3>
                                <p>(<?php echo e($user->department->title); ?>)</p>
                                <p><?php echo app('translator')->getFromJson('employees/common.dob_txt'); ?> <?php echo e(date('d M, Y', strtotime($user->date_of_birth))); ?></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.nationality_txt'); ?> <?php echo e($user->countries->country_name); ?></h2>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.national_id_txt'); ?>:</b> <?php echo e($user->national_id); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.country_txt'); ?>:</b> </p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.parents_txt'); ?></h2>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.fathers_name_txt'); ?>:</b> <?php echo e($user->fathers_name); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.mothers_name_txt'); ?>:</b> <?php echo e($user->mothers_name); ?></p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h2><?php echo app('translator')->getFromJson('employees/common.contact_detail_txt'); ?></h2>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.email_txt'); ?>:</b> <?php echo e($user->email); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.phone_no_txt'); ?>:</b> <?php echo e($user->phone_no); ?></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.present_address_txt'); ?></h2>
                                <p><?php echo e($user->present_address); ?></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.permanant_address_txt'); ?></h2>
                                <p><?php echo e($user->permanant_address); ?></p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h2><?php echo app('translator')->getFromJson('employees/common.login_detail_txt'); ?> </h2>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.username_txt'); ?></b>  <?php echo e($user->username); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.userpass_txt'); ?> </b> ****** </p>

                                <h2><b><?php echo app('translator')->getFromJson('employees/common.joining_date_txt'); ?></b></h2>
                                <p><?php echo e(date('d M, Y', strtotime($user->joining_date))); ?></p>

                                
                                <h2><?php echo app('translator')->getFromJson('employees/common.shift_txt'); ?></h2>
                                <p><?php echo e($user->shift->title); ?></p>
                                <p><?php echo e(date('h:i:s', strtotime($user->shift->start_time))); ?> to <?php echo e(date('h:i:s', strtotime($user->shift->end_time))); ?></p>
                                <p>Off Days: Sat, Sun</p>
                              </div>

                            </div>
                          </div>


                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading">
                                <h2><?php echo app('translator')->getFromJson('employees/common.salary_detail_txt'); ?></h2>
                              </div>

                              <div class="detail_area">
                                  <h1 class="net_cash"><?php echo app('translator')->getFromJson('employees/common.basic_txt'); ?> <?php echo e(number_format($user->basic_salary, 2)); ?> <span class="currency"><?php echo e($currency); ?></span> </h1>
                                  <h2><?php echo app('translator')->getFromJson('employees/common.allowance_txt'); ?></h2>
                                  
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.accomodation_allowance_txt'); ?></b> <?php echo e(number_format($user->accomodation_allowance, 2)); ?> <?php echo e($currency); ?></p>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.medical_allowance_txt'); ?></b> <?php echo e(number_format($user->medical_allowance, 2)); ?> <?php echo e($currency); ?></p>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.food_allowance_txt'); ?></b> <?php echo e(number_format($user->food_allowance, 2)); ?> <?php echo e($currency); ?></p>

                                  <h1 class="net_cash"><b><?php echo app('translator')->getFromJson('employees/common.net_cash_txt'); ?></b> <?php echo e(number_format($user->basic_salary + $user->accomodation_allowance + $user->medical_allowance + $user->food_allowance + $user->house_rent_allowance + $user->transportation_allowance, 2)); ?> <?php echo e($currency); ?></h1>

                                </div>
                            </div>
                              <div class="col-sm-4">

                              <div class="detail_area">

                                <div class="detail_box">
                                  
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.house_txt'); ?> </b> <?php echo e(number_format($user->house_rent_allowance, 2)); ?> <?php echo e($currency); ?></p>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.transportation_allowance_txt'); ?> </b> <?php echo e(number_format($user->transportation_allowance, 2)); ?> <?php echo e($currency); ?></p>
                                </div>

                                </div>
                                
                              </div>

                              <div class="col-sm-4">

                              <div class="detail_area">

                                <h2 class="basic"><?php echo app('translator')->getFromJson('employees/common.overtime_txt'); ?></h2>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.overtime_1_txt'); ?></b> <?php echo e($user->overtime_1); ?></p>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.overtime_2_txt'); ?></b> <?php echo e($user->overtime_2); ?></p>
                                  <p><b><?php echo app('translator')->getFromJson('employees/common.overtime_3_txt'); ?></b> <?php echo e($user->overtime_3); ?></p>
                                </div>
                                
                              </div>


                            
                            
                          </div>

                        </div>
                        
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="account">
                    <div class="">

                        <div class="row">
                          <div class="account_block">
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-pink">
                                <h1><?php echo e($total_received); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
                                <span><?php echo app('translator')->getFromJson('admin/employees.total_receive_txt'); ?></span>
                              </div>
                            </div>
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-orange">
                                <h1><?php echo e($total_ded); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
                                <span><?php echo app('translator')->getFromJson('admin/employees.total_deduction_txt'); ?></span>
                              </div>
                            </div>
                            <div class="col-sm-4 no-padding">
                              <div class="collection_box bg-color-seagreen">
                                <h1><?php echo e($total_loan); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
                                <span><?php echo app('translator')->getFromJson('admin/employees.total_loan_received'); ?></span>
                              </div>
                            </div>
                          </div>

                          <?php if(isset($salaries) && count($salaries) > 0): ?>

                          <div class="col-sm-12 no-padding record-heading"><h4><b><?php echo app('translator')->getFromJson('admin/employees.prevous_month_txt'); ?></b></h4></div>
                          

                          <?php $__currentLoopData = $salaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="col-lg-4 col-sm-6 col-md-4 col-xs-12 no-padding">
                            <div class="accounts_box">
                              <h6><b><?php echo app('translator')->getFromJson('employees/common.salary_of_txt'); ?> <?php echo e($salary['date']); ?></b> <span class="salary-status"><b><?php echo e($salary['status']); ?></b></span></h6>
                              <div class="education_detail">
                                <span><?php echo app('translator')->getFromJson('employees/common.total_salary_txt'); ?>: <b><?php echo e($salary['total']); ?> <?php echo e($currency); ?></b></span><br>
                                <span><?php echo app('translator')->getFromJson('employees/common.deduction_txt'); ?>: <b><?php echo e($salary['deduction']); ?> <?php echo e($currency); ?></b></span><br>
                                <span class="received_amount color-red"><?php echo app('translator')->getFromJson('employees/common.received_txt'); ?>: <b><?php echo e($salary['received']); ?> <?php echo e($currency); ?></b> </span><br> 
                                
                              </div>
                            </div>
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          <?php endif; ?>



                        </div>
  

                        
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="qdetaul">

                <?php if(isset($qualifications) && count($qualifications) > 0): ?>

                    <div class="row">
                      <div class="col-sm-12"><h4><b><?php echo app('translator')->getFromJson('employees/common.education_heading_txt'); ?></b></h4></div>
                      <div class="tab-block">

                        <?php $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="education_box">
                              <h6><b><?php echo e($qualification->degree_name); ?></b> <span class="grade-status"><b><?php echo e($qualification->grade); ?></b></span></h6>
                              <div class="education_detail">
                                <span><?php echo app('translator')->getFromJson('employees/common.from_institue_txt'); ?> <b><?php echo e($qualification->institute); ?><?php if(isset($qualification->eCountry->country_name) && $qualification->eCountry->country_name <> ""): ?> , <?php echo e($qualification->eCountry->country_name); ?> <?php endif; ?> </b></span><br>
                                <span><?php echo app('translator')->getFromJson('employees/common.institue_year'); ?> <b><?php echo e($qualification->year); ?></b> </span><br>
                                <span><?php echo app('translator')->getFromJson('employees/common.total_marks_txt'); ?> <b><?php echo e($qualification->total_marks); ?></b> </span> 
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                <span><?php echo app('translator')->getFromJson('employees/common.obtain_marks_txt'); ?> <b><?php echo e($qualification->obtain_marks); ?></b></span>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          
                      </div>


                    </div>

                    <?php endif; ?>
                </div>


                <div role="tabpanel" class="tab-pane" id="exptab">

                <?php if(isset($experiences) && count($experiences) > 0): ?>

                    <div class="row">
                      <div class="col-sm-12"><h4><b><?php echo app('translator')->getFromJson('employees/common.experience_heading_txt'); ?></b></h4></div>
                      <div class="tab-block">

                        <?php $__currentLoopData = $experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="education_box">
                              <h6><b><?php echo e($experience->job_title); ?></b></h6>
                              <div class="education_detail">
                                <span><?php echo app('translator')->getFromJson('employees/common.from_institue_txt'); ?> <b><?php echo e($experience->company_name); ?> <?php if(isset($experience->eCountry->country_name) && $qualification->eCountry->country_name <> ""): ?> , <?php echo e($qualification->eCountry->country_name); ?> <?php endif; ?> </b></span><br>
                                <span><?php echo app('translator')->getFromJson('employees/common.institue_year'); ?> <b><?php echo e($experience->start_date); ?></b> TO <b><?php echo e($experience->end_date); ?></b> </span>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          
                      </div>


                    </div>

                    <?php endif; ?>
                </div>

                

                <div role="tabpanel" class="tab-pane" id="attendance">
                  <div class="panel panel-default">

                  <?php if(isset($attendences) && count($attendences) > 0): ?>
                    <div class="panel-body">
                      <h3><?php echo app('translator')->getFromJson('employees/common.att_of_txt'); ?> <?php echo e($attendences[0]['head_date']); ?></h3>
                    </div>

                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th align="center" class="text-center">#</th>
                            <th align="left" class="text-left"><?php echo app('translator')->getFromJson('employees/common.date_txt'); ?></th>
                            <th align="left" class="text-left"><?php echo app('translator')->getFromJson('employees/common.closing_detail_txt'); ?></th>
                            <th align="center" class="text-center"><?php echo app('translator')->getFromJson('employees/common.t_in_txt'); ?></th>
                            <th align="center" class="text-center"><?php echo app('translator')->getFromJson('employees/common.t_out_txt'); ?></th>
                            <th class="color-red text-center"><?php echo app('translator')->getFromJson('employees/common.t_short_txt'); ?></th>
                          </tr>
                        </thead>

                        <tbody>
                        <?php $__currentLoopData = $attendences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td align="center"><?php echo e($attendance['sr']); ?></td>
                            <td align="left"><?php echo e($attendance['date']); ?></td>
                            <td align="center"><?php echo e($attendance['in_time']); ?></td>
                            <td align="center"><?php echo e($attendance['out_time']); ?></td>
                            <td align="left"><a href="#" data-toggle="modal" data-detail="<?php echo $attendance['detail']; ?>" data-target="#detailModal"><?php echo e(Str::limit($attendance['detail'], 10)); ?></a> </td>
                            <td align="center" class="color-red text-center"><?php echo $attendance['t_short']; ?></td>
                          </tr>

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                      </table>

                      <?php endif; ?>
                    
                  </div>
                </div>
                
                <div role="tabpanel" class="tab-pane" id="notice">
                    

                  <div class="col-lg-12">

                    <div class="panel panel-default">
                      <div class="panel-heading"><?php echo app('translator')->getFromJson('employees/common.notification_txt'); ?></div>
                      <div class="panel-body">
                      <table class="table table-condensed" style="border-collapse:collapse;">

                      <?php if(isset($notices) && count($notices) > 0): ?>

                        <?php $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <thead>
                              <tr>
                                  <th>&nbsp;</th>
                                  <th><?php echo app('translator')->getFromJson('employees/common.simple_date_txt'); ?></th>
                                  <th><?php echo app('translator')->getFromJson('employees/common.title_txt'); ?></th>
                              </tr>
                          </thead>

                          <tbody>
                              <tr data-toggle="collapse" data-target="#nt<?php echo e($notice['sr']); ?>" class="accordion-toggle">
                                  <td><button class="btn btn-default btn-xs"><span class="fa fa-eye"></span></button></td>
                                  <td><?php echo e($notice['datetime']); ?></td>
                                  <td><?php echo e($notice['title']); ?></td>
                              </tr>
                              <tr>
                                  <td colspan="12" style="border: 1px solid #fff;"><div class="accordian-body collapse" id="nt<?php echo e($notice['sr']); ?>"> 
                                    <table class="table table-striped">
                                            <thead>
                                             <tr>
                                               <th><?php echo app('translator')->getFromJson('employees/common.notification_des_txt'); ?></th>
                                             </tr>
                                              
                                            </thead>
                                            <tbody>
                                          
                                              <tr>
                                                <td><?php echo $notice['description']; ?></td>
                                              </tr>
                                           
                                          
                                            </tbody>
                                      </table>
                                    
                                    </div> </td>
                              </tr>

                            
                          </tbody>

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                      </table>
                      </div>
                  
                    </div> 
                  
                </div>


                </div>
              </div>

            </div> 
        </div>
    </div>
</div>

<!-- Modal -->
<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo app('translator')->getFromJson('admin/shift.today_activity_txt'); ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo app('translator')->getFromJson('admin/shift.wait_txt'); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript">

    $('#detailModal').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // Button that triggered the modal
      var detail = button.data('detail'); // Extract info from data-* attributes
      $('.modal-body').html(detail);
      
    });

    $('.datepicker').dateDropper();
    $(".chosen").select2();
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>