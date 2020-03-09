<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.menu.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
    <?php echo trans('installer_messages.environment.menu.title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>


    <form method="post" action="<?php echo e(url('install?step=finish')); ?>" class="tabs-wrap" id="finalForm">
    <div>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group <?php echo e($errors->has('country') ? ' has-error ' : ''); ?>">
                    <label for="country">
                        <?php echo e(trans('installer_messages.environment.wizard.form.country_label')); ?>*
                    </label>
                    <select name="country" id="country">
                        <?php if(isset($countries) && count($countries) > 0): ?>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        <?php endif; ?>
                    </select>
                    
                    <?php if($errors->has('country')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('country')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('timezone') ? ' has-error ' : ''); ?>">
                    <label for="timezone">
                        <?php echo e(trans('installer_messages.environment.wizard.form.timezone_label')); ?>*
                    </label>
                    <select name="timezone" id="timezone">
                        
                        <?php if(isset($zones) && count($zones) > 0): ?>
                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        <?php endif; ?>
                    </select>
                    
                    <?php if($errors->has('timezone')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('timezone')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('email_enabaled') ? ' has-error ' : ''); ?>">
                    <label for="email_enabaled">
                        <?php echo e(trans('installer_messages.environment.wizard.form.email_enabaled_label')); ?>

                    </label>
                    <select name="email_enabaled" id="email_enabaled">
                       <option value="">Please select</option>
                       <option value="true">YES</option>
                       <option value="false">NO</option>
                    </select>
                    
                    <?php if($errors->has('email_enabaled')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('email_enabaled')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('bank_account') ? ' has-error ' : ''); ?>">
                    <label for="bank_account">
                        <?php echo e(trans('installer_messages.environment.wizard.form.bank_account_label')); ?>

                    </label>
                    <input type="text" name="bank_account" id="bank_account" value="" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.bank_account_label')); ?>" />
                    
                    <?php if($errors->has('bank_account')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('bank_account')); ?>

                        </span>
                    <?php endif; ?>
                </div>


               

                <div class="buttons">
                    <button class="button" onclick="showFinished();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing..." id="load">
                        <?php echo e(trans('installer_messages.environment.wizard.form.buttons.setup_finished')); ?>

                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

    </form>

   <script type="text/javascript">

    function showFinished(){
        $("#loading").css('display', 'block');
    }

    $(window).bind("load", function() {
       $("#loading").css('display', 'block');
    });

    $(window).load(function(){
        $("#loading").hide();
    });
   
   </script>


   <script>
      function showFinished() {
        console.log("load event detected!");

        //document.getElementById('load').style.visibility = 'show';
        document.getElementById("loading").style.display="block";

        document.getElementById("box").style.display="none";
        window.onload = showFinished;
      }
      
    </script>

   <script>
      // const showFinished = () => {
      //   console.log("load event detected!");
      // } 
      //window.onload = showFinished; 
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>