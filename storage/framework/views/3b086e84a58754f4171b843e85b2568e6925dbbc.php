

<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/profile.manage_profile'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="<?php echo e(url('')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / <a href="javascript:void();" class="active"><?php echo app('translator')->getFromJson('admin/profile.manage_profile'); ?></a></div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="profile_image" style="">

<div style="height: 200px;">
	<div class="slim" data-label="Drop your cover photo here" data-service="<?php echo e(url('/profile/cover')); ?>" data-ratio="14:3">
         <?php if($user->cover <> NULL && file_exists(storage_path().'/app/cover/'.$user->cover)): ?>
         	<img src="<?php echo e(asset('storage/app/cover/'.$user->cover)); ?>" alt="">
         <?php endif; ?>         
    	<input type="file" name="slim[]" required />
</div>
</div>
	
	<div class="container">
		<div class="col-sm-2 col-md-2 col-lg-2 col-xs-12 pull-right no-padding">
			<div class="col-sm-12 col-xs-12">
				<a href="" class="btn btn-danger btn-block new-btn zindex" data-toggle="modal" data-target="#myModal"><?php echo app('translator')->getFromJson('admin/profile.edit_now_btn'); ?></a>
			</div>
			<!-- Button trigger modal -->
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->getFromJson('admin/profile.manage_profile'); ?></h4>
			      </div>
			      <form data-toggle="validator" method="post" class="registration-form" action="<?php echo e(url('/profile/update')); ?>" enctype="multipart/form-data">
			      <div class="modal-body clearfix">
			      
			        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
			        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
			           
			            <div class="">
			              
			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="first_name" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.first_name_label'); ?>*</label>
			                <input type="text" name="first_name" id="first_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.first_name_label'); ?>*" required="required" value="<?php echo e($user->first_name); ?>" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
			                <label for="last_name" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.last_name_label'); ?>*</label>
			                <input type="text" name="last_name" id="last_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.last_name_label'); ?>*" required="required" value="<?php echo e($user->last_name); ?>" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="password" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.password_label'); ?>*</label>
			                <input type="password" name="password" id="password" class="form-control1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password_confirmation" placeholder="<?php echo app('translator')->getFromJson('admin/profile.password_label'); ?>*" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding">
			                <label for="password_confirmation" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.cpassword_label'); ?>*</label>
			                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.cpassword_label'); ?>*" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" data-bv-identical-field="password" data-bv-identical="true" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="fathers_name" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.fathers_name_label'); ?></label>
			                <input type="text" name="fathers_name" id="fathers_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.fathers_name_label'); ?>" value="<?php echo e($user->fathers_name); ?>" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="mothers_name" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.mothers_name_label'); ?></label>
			                <input type="text" name="mothers_name" id="mothers_name" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.mothers_name_label'); ?>" value="<?php echo e($user->mothers_name); ?>" />
			              </div>

			              
			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group no-padding-left">
			                <label for="country_id" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.nationality_label'); ?>*</label>
			                <select name="country_id" id="country_id" class="form-control1" required="required">
			                	<option value=""><?php echo app('translator')->getFromJson('admin/profile.select_option'); ?></option>
			                	<?php if(isset($countries) && count($countries) > 0): ?>
									<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($country->id == $user->nationality): ?>
											<option value="<?php echo e($country->id); ?>" selected="selected"><?php echo e($country->country_name); ?></option>
										<?php else: ?>
											<option value="<?php echo e($country->id); ?>"><?php echo e($country->country_name); ?></option>
										<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                	<?php endif; ?>
			                </select>

			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="email" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.email_label'); ?>*</label>
			                <input type="text" name="email" id="email" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.email_label'); ?>*" required="required" value="<?php echo e($user->email); ?>" data-bv-emailaddress-message="The input is not a valid email address" data-bv-emailaddress="true" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding-left">
			                <label for="phone_no" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.phone_no_label'); ?>*</label>
			                <input type="text" name="phone_no" id="phone_no" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.phone_no_label'); ?>*" required="required" value="<?php echo e($user->phone_no); ?>" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="mobile_no" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.mobile_no_label'); ?>*</label>
			                <input type="text" name="mobile_no" id="mobile_no" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.mobile_no_label'); ?>" value="<?php echo e($user->mobile_no); ?>" />
			              </div>


			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding-left">
			                <label for="present_address" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.present_address_label'); ?>*</label>
			                <input type="text" name="present_address" id="present_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.present_address_label'); ?>*" required="required" value="<?php echo e($user->present_address); ?>" />
			              </div>

			              <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 col-xs-6 form-group no-padding">
			                <label for="permanant_address" class="input_label"><?php echo app('translator')->getFromJson('admin/profile.permanant_address_label'); ?></label>
			                <input type="text" name="permanant_address" id="permanant_address" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/profile.permanant_address_label'); ?>" value="<?php echo e($user->permanant_address); ?>" />
			              </div>


			            </div>
        
      				</div>
			      </div>
			      <div class="modal-footer">
			        <input type="submit" class="btn btn-primary" value="<?php echo app('translator')->getFromJson('admin/profile.submit_btn'); ?>">
			      </div>

			      </form>

			    </div>
			  </div>
			</div>
			<div class="col-sm-7 col-xs-7 no-padding-right">

				<input type="file" name="cover[<?php echo e($user->id); ?>]" id="imgupload" style="display:none"/>
			</div>
		</div>
	</div>
	
	
</div>

<div class="container mainwrapper margin-top">
	<div class="row">
		<div class="col-sm-4 col-lg-4 col-xs-12 col-md-4">
			<div class="avatar_area text-center">
				<div class="profile-avatar">
					
					<div class="avatar droper">

					    <div class="slim"
					         data-label="Drop your avatar here"
					         data-size="240,240"
					         data-service="<?php echo e(url('/profile/ajax')); ?>"
					         data-meta-user-id="<?php echo e($user->id); ?>"
					         data-ratio="1:1"
					         data-load="isHotEnough">
					         <?php if($user->avatar <> NULL && file_exists(storage_path().'/app/avatar/'.$user->avatar)): ?>
					         	<img src="<?php echo e(asset('storage/app/avatar/'.$user->avatar)); ?>" alt="">
					         <?php endif; ?>
					         
					        <input type="file" name="slim[]" required />
					    </div>

					</div>

					<script type="text/javascript">
						function isHotEnough()
						{
							alert(3);
						}
					</script>

					
					<h2><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h2>
					<p><?php echo e($user->roles->title); ?></p>
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
			    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('admin/profile.profile_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    <li role="presentation"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('admin/profile.notice_board_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?php echo app('translator')->getFromJson('admin/profile.conversation_tab'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
			    
			  </ul>

			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="profile">
			    	<div class="row">
                          
                          <div class="col-sm-12 block no-padding top-margin-space">
                            <div class="col-sm-4">
                              <div class="area-heading"><h2><?php echo app('translator')->getFromJson('employees/common.personal_detail'); ?></h2></div>
                              <div class="detail_area">
                                <h3><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?> </h3>
                                <p></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.nationality_txt'); ?></h2>
                                <p> <?php echo e($user->countries->country_name); ?> </p>

                                
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h1><?php echo app('translator')->getFromJson('employees/common.contact_detail_txt'); ?></h1>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.email_txt'); ?>:</b> <?php echo e($user->email); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.phone_no_txt'); ?>:</b> <?php echo e($user->phone_number); ?></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.present_address_txt'); ?></h2>
                                <p><?php echo e($user->present_address); ?></p>

                                <h2><?php echo app('translator')->getFromJson('employees/common.permanant_address_txt'); ?></h2>
                                <p><?php echo e($user->permanant_address); ?></p>
                              </div>
                            </div>
                            <div class="col-sm-4">
                              
                              <div class="detail_area">
                                <h1><?php echo app('translator')->getFromJson('employees/common.login_detail_txt'); ?> </h1>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.username_txt'); ?></b>  <?php echo e($user->username); ?></p>
                                <p><b><?php echo app('translator')->getFromJson('employees/common.userpass_txt'); ?> </b> ****** </p>

                   
                              </div>
                             
                            </div>
                          </div>


                          

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
                          <td colspan="12" style="border: 1px solid #fff;">
                              <div class="accordian-body collapse" id="nt<?php echo e($notice['sr']); ?>"> 
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
                                </div> 
                            </td>
                      		</tr>
                          	</tbody>

                          	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                          <?php else: ?>

                          	<tr>
                          		<td colspan="4"><?php echo app('translator')->getFromJson('admin/common.notfound'); ?></td>
                          	</tr>
                          <?php endif; ?>
                      </table>
                      </div>
                  
                    </div> 
                  
                </div>

			    </div>
			    <div role="tabpanel" class="tab-pane" id="messages">...b</div>
			  </div>

			</div> 
		</div>
	</div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/slim/slim.min.css')); ?>">
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.commonjs.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.amd.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.global.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/slim/slim.kickstart.min.js')); ?>"></script>

<style type="text/css">
	.avatar .slim {
	    /*width: 240px;*/
	    border-radius: 50%;
	}
	
</style>

<script>
function isHotEnough(file, image, meta) {
   console.log(file);
}
</script>


  <script type='text/javascript'>
   

    $(document).ready(function (){
     
      $('form[data-toggle="validator"]').bootstrapValidator({
        excluded: [':disabled'],
      }).on('status.field.bv', function(e, data) {
        data.element.data('bv.messages').find('.help-block[data-bv-for="' + data.field + '"]').hide();
      });

    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>