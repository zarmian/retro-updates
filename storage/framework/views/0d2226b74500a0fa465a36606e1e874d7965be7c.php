<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" Content-type="text/html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php if(trim($__env->yieldContent('template_title'))): ?><?php echo $__env->yieldContent('template_title'); ?> | <?php endif; ?> <?php echo e(trans('installer_messages.title')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('assets/installer/img/favicon/favicon-16x16.png')); ?>" sizes="16x16"/>
        <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon-32x32.png')); ?>" sizes="32x32"/>
        <link rel="icon" type="image/png" href="<?php echo e(asset('installer/img/favicon/favicon-96x96.png')); ?>" sizes="96x96"/>
        <link href="<?php echo e(asset('assets/installer/css/style.min.css')); ?>" rel="stylesheet"/>
        <?php echo $__env->yieldContent('style'); ?>
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <style type="text/css">
            #loading {
                top: 50%;
                left: 50%;
                width:30em;
                margin-top: -18em; /*set to a negative number 1/2 of your height*/
                margin-left: -18em; /*set to a negative number 1/2 of your width*/
               
                position:fixed;
            }
        </style>
    </head>
    <body>
    <div id="loading" style="display: none">
        <div><img src="<?php echo e(asset('assets/cal-Loading.gif')); ?>" alt=""></div>
    Loading content, please wait..
    </div>
        <div class="master">
            <div class="box" id="box">
                <div class="header">
                    <h1 class="header__title"><?php echo $__env->yieldContent('title'); ?></h1>
                </div>
                <ul class="step">

                    <li class="step__divider"></li>
                    <li class="step__item <?php if(Request::get('step') == 'finish'): ?> active <?php endif; ?>">
                        <i class="step__icon fa fa-flag-checkered" aria-hidden="true"></i>
                    </li>
                    
                    <li class="step__divider"></li>
                    <li class="step__item <?php if(Request::get('step') == 4 || Request::get('step') == 5 || Request::get('step') == 6): ?> active <?php endif; ?>">
                        <i class="step__icon fa fa-cogs" aria-hidden="true"></i>
                    </li>
                    <li class="step__divider"></li>
                    
                    <li class="step__item <?php if(Request::get('step') == 3): ?> active <?php endif; ?>">
                        <?php if(Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(url('install?step=3')); ?>">
                                <i class="step__icon fa fa-key" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon fa fa-key" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php if(Request::get('step') == 2): ?> active <?php endif; ?>">
                        <?php if(Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(url('install?step=2')); ?>">
                                <i class="step__icon fa fa-folder" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon fa fa-folder" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php if(Request::get('step') == 1): ?> active <?php endif; ?>">
                        <?php if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') ): ?>
                            <a href="<?php echo e(url('install?step=1')); ?>">
                                <i class="step__icon fa fa-list" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon fa fa-list" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item <?php if(Request::get('step') == 0): ?> active <?php endif; ?>">
                        <?php if(Request::get('step') == 0): ?>
                            <a href="<?php echo e(url('install?step=0')); ?>">
                                <i class="step__icon fa fa-home" aria-hidden="true"></i>
                            </a>
                        <?php else: ?>
                            <i class="step__icon fa fa-home" aria-hidden="true"></i>
                        <?php endif; ?>
                    </li>
                    <li class="step__divider"></li>
                </ul>
                <div class="main">
                    <?php if(session('message')): ?>
                        <p class="alert text-center">
                            <strong>
                                <?php if(is_array(session('message'))): ?>
                                    <?php echo e(session('message')['message']); ?>

                                <?php else: ?>
                                    <?php echo e(session('message')); ?>

                                <?php endif; ?>
                            </strong>
                        </p>
                    <?php endif; ?>
                    <?php if(session()->has('errorss')): ?>
                        <div class="alert alert-danger" id="error_alert">
                            <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                                 <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                            <h4>
                                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                <?php echo e(trans('installer_messages.forms.errorTitle')); ?>

                            </h4>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('container'); ?>
                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('scripts'); ?>
        <script type="text/javascript">
            var x = document.getElementById('error_alert');
            var y = document.getElementById('close_alert');
            y.onclick = function() {
                x.style.display = "none";
            };
        </script>
    </body>
</html>
