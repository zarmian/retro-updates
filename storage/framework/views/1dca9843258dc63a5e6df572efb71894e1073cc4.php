<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.menu.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-user fa-fw" aria-hidden="true"></i>
    <?php echo trans('installer_messages.environment.menu.login_title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
<div id="loading" style="display: none">
    Loading content, please wait..
</div>

    <form method="post" action="<?php echo e(url('install?step=6')); ?>" class="tabs-wrap">
    <div>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group <?php echo e($errors->has('username') ? ' has-error ' : ''); ?>">
                    <label for="username">
                        <?php echo e(trans('installer_messages.environment.wizard.form.username_label')); ?>

                    </label>
                    <input type="text" name="username" id="username" value="" />
                    
                    <?php if($errors->has('username')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('username')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('password') ? ' has-error ' : ''); ?>">
                    <label for="password">
                        <?php echo e(trans('installer_messages.environment.wizard.form.password_label')); ?>

                    </label>
                    <input type="password" name="password" id="password" value="" />
                    
                    <?php if($errors->has('password')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('password')); ?>

                        </span>
                    <?php endif; ?>
                </div>


                <div class="form-group <?php echo e($errors->has('email') ? ' has-error ' : ''); ?>">
                    <label for="email">
                        <?php echo e(trans('installer_messages.environment.wizard.form.email_label')); ?>

                    </label>
                    <input type="text" name="email" id="email" value="" />
                    
                    <?php if($errors->has('email')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('email')); ?>

                        </span>
                    <?php endif; ?>
                </div>


               

                <div class="buttons">
                    <button class="button" onclick="showFinished();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing..." id="load">
                        <?php echo e(trans('installer_messages.environment.wizard.form.buttons.setup_application')); ?>

                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

    </form>

   <script type="text/javascript">

    // function showFinished(){
    //     $("#loading").css('display', 'block');
    // }

    // $(window).bind("load", function() {
    //    $("#loading").css('display', 'block');
    // });

    // $(window).load(function(){
    //     $("#loading").hide();
    // });
   
   </script>


   <script>
      // function showFinished() {
      //   console.log("load event detected!");

      //   document.getElementById('load').style.visibility = 'hidden';
      //   window.onload = showFinished;
      // }
      
    </script>

   <script>
      //const showFinished = () => {
        //console.log("load event detected!");
      //} 
      //window.onload = showFinished; 
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('installer.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>