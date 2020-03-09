<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.wizard.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-key" aria-hidden="true"></i>
    <?php echo trans('installer_messages.environment.wizard.verify_key'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>

    <form method="post" action="<?php echo e(url('install?step=verfiy')); ?>" class="tabs-wrap"  autocomplete="on">
            <div >
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group <?php echo e($errors->has('username') ? ' has-error ' : ''); ?>">
                    <label for="username">
                        <?php echo e(trans('installer_messages.environment.wizard.form.username_label')); ?>

                    </label>
                    <input type="text" name="username" id="username" value="" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.app_verfiy_username')); ?>" autocomplete="off" />
                    <?php if($errors->has('username')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('username')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('verfiy_key') ? ' has-error ' : ''); ?>">
                    <label for="verfiy_key">
                        <?php echo e(trans('installer_messages.environment.wizard.form.verfiy_key_label')); ?>

                    </label>
                    <input type="text" name="verfiy_key" id="verfiy_key" value="" autocomplete="off" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.verfiy_key_label')); ?>" />
                    <?php if($errors->has('verfiy_key')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('verfiy_key')); ?>

                        </span>
                    <?php endif; ?>
                </div>
                


                <div class="buttons">
                    <button class="button" onclick="showDatabaseSettings();return false">
                        <?php echo e(trans('installer_messages.environment.wizard.form.buttons.verfiy')); ?>

                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            
          
        </form>

   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        function checkEnvironment(val) {
            var element=document.getElementById('environment_text_input');
            if(val=='other') {
                element.style.display='block';
            } else {
                element.style.display='none';
            }
        }
        function showDatabaseSettings() {
            document.getElementById('tab2').checked = true;
        }
        function showApplicationSettings() {
            document.getElementById('tab3').checked = true;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('installer.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>