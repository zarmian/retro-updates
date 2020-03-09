<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.menu.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
    <?php echo trans('installer_messages.environment.menu.title'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
    <form method="post" action="<?php echo e(url('install?step=4')); ?>" class="tabs-wrap">
    <div>
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

                <div class="form-group <?php echo e($errors->has('app_name') ? ' has-error ' : ''); ?>">
                    <label for="app_name">
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_name_label')); ?>

                    </label>
                    <input type="text" name="app_name" id="app_name" value="" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.app_name_placeholder')); ?>" />
                    <?php if($errors->has('app_name')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('app_name')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('environment') ? ' has-error ' : ''); ?>">
                    
                    <div id="environment_text_input" style="display: none;">
                        <input type="text" name="environment_custom" id="environment_custom" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.app_environment_placeholder_other')); ?>"/>
                    </div>
                    <?php if($errors->has('app_name')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('app_name')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('app_debug') ? ' has-error ' : ''); ?>">
                    <label for="app_debug">
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_debug_label')); ?>

                    </label>
                    <label for="app_debug_true">
                        <input type="radio" name="app_debug" id="app_debug_true" value=true checked />
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_debug_label_true')); ?>

                    </label>
                    <label for="app_debug_false">
                        <input type="radio" name="app_debug" id="app_debug_false" value=false />
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_debug_label_false')); ?>

                    </label>
                    <?php if($errors->has('app_debug')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('app_debug')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('app_log_level') ? ' has-error ' : ''); ?>">
                    <label for="app_log_level">
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label')); ?>

                    </label>
                    <select name="app_log_level" id="app_log_level">
                        <option value="debug" selected><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_debug')); ?></option>
                        <option value="info"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_info')); ?></option>
                        <option value="notice"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_notice')); ?></option>
                        <option value="warning"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_warning')); ?></option>
                        <option value="error"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_error')); ?></option>
                        <option value="critical"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_critical')); ?></option>
                        <option value="alert"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_alert')); ?></option>
                        <option value="emergency"><?php echo e(trans('installer_messages.environment.wizard.form.app_log_level_label_emergency')); ?></option>
                    </select>
                    <?php if($errors->has('app_log_level')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('app_log_level')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo e($errors->has('app_url') ? ' has-error ' : ''); ?>">
                    <label for="app_url">
                        <?php echo e(trans('installer_messages.environment.wizard.form.app_url_label')); ?> <i>(http://localhost)</i>
                    </label>
                    <input type="url" name="app_url" id="app_url" value="<?php echo str_replace('/install', ' ', URL::current()); ?>" placeholder="<?php echo e(trans('installer_messages.environment.wizard.form.app_url_placeholder')); ?>" />
                    <?php if($errors->has('app_url')): ?>
                        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            <?php echo e($errors->first('app_url')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="buttons">
                    <button class="button" onclick="showDatabaseSettings();return false">
                        <?php echo e(trans('installer_messages.environment.wizard.form.buttons.setup_application')); ?>

                        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('installer.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>