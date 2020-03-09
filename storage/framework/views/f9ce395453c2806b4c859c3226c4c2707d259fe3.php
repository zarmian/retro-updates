
<?php $__env->startSection('head'); ?>
    <style type="text/css">body { background-color: #4c3881;}</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container mainwrapper" style="margin-top: 30px;">
        <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="ibox ibox-content border-radius box-margin">
                          <canvas id="barChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="<?php echo e(url('leave-request')); ?>" style="text-decoration: none;">
                        <div class="orang-mudim box-margin">
                        <?php echo app('translator')->getFromJson('admin/common.manage_applications_txt'); ?>
                        <h3><?php echo app('translator')->getFromJson('admin/common.leaves_txt'); ?><span class="dashboard-icon-size" style=""><i class="fa fa-calendar"></i></span></h3>
                            
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                <div class="row">
                
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="orange box-margin"><span class="payable-loan-txt"><?php echo app('translator')->getFromJson('employees/common.payableloan_txt'); ?></span><h3 class="font45px"><?php echo e($payable); ?> <span class="currency currency-font"><?php echo e($currency); ?></span></h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="red-light box-margin">
                            <h3><?php echo e($absents); ?></h3><?php echo app('translator')->getFromJson('employees/common.total_absent_txt'); ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                        <div class="purpal-light box-margin">
                            <h3><?php echo e($outtimeshort); ?></h3><?php echo app('translator')->getFromJson('employees/common.present_employees_txt'); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="<?php echo e(url('employee/ledger')); ?>" style="text-decoration: none;">
                        <div class="blue-mudim box-margin"><?php echo app('translator')->getFromJson('admin/common.manage_employees_txt'); ?>
                            <h3>
                                <?php echo app('translator')->getFromJson('admin/common.ledger_txt'); ?>
                                <span class="dashboard-icon-size" style="">
                                    <i class="fa fa-briefcase"></i>
                                </span>

                            </h3>
                            
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                <div style="width:100%; max-width:100%; display:inline-block;">
                    <div class="monthly" id="mycalendar"></div>
                </div>
            </div>

        </div>

        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('assets/chart/css/style.css')); ?>" type="text/css" rel="stylesheet">

<script src="<?php echo e(asset('assets/chart/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/chart/js/mdb.min.js')); ?>"></script>

<script type="text/javascript">
  //line
//bar
var ctxB = document.getElementById("barChart").getContext('2d');
var total_months = <?php echo json_encode($total_month); ?>

var total_amounts = <?php echo json_encode($emp_salary); ?>

var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: total_months,
        datasets: [{
            label: 'Salary',
            data: total_amounts,
            backgroundColor: [
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)',
                'rgba(202, 255, 245, 1)'
            ],
            borderColor: [
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)',
                'rgba(26,188,156,1)'
            ],
            borderWidth: 1
        }]
    },
    optionss: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

         
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>