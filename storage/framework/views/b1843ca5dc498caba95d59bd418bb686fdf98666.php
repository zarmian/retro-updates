<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?> </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('admin')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      
        
      
            <div class="col-sm-3">
              <div class="inside-block clearfix">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.customer_invoice_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_receivable_heading'); ?></span> <?php echo e($today_receivable); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.total_receivable_heading'); ?> </span> <?php echo e($total_receivable); ?> <?php echo e($currency); ?></p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/sales')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/sales/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>


            <div class="col-sm-3">
              <div class="inside-block clearfix">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.vendors_bill_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_payable_txt'); ?></span> <?php echo e($today_payable); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.total_payable_txt'); ?></span> <?php echo e($total_payable); ?> <?php echo e($currency); ?></p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/purchase')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/purchase/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-3">
              <div class="inside-block clearfix">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.expenses_txt'); ?></h4>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.today_txt'); ?> </span> <?php echo e($today_expense); ?> <?php echo e($currency); ?></p>
                  <p><span><?php echo app('translator')->getFromJson('admin/entries.this_month_txt'); ?> </span> <?php echo e($total_expense); ?> <?php echo e($currency); ?> </p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                  <ul>
                    <li><a href="<?php echo e(url('accounting/journal')); ?>"><i class="fa fa-th-list" aria-hidden="true"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/journal/add')); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                  </ul>
                </div>
                </div>
            </div>

            

          

        
      </div>
  <div class="row">
    <div class="container">

    <div class="account_block">
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-seagreen">
          <span><?php echo app('translator')->getFromJson('admin/entries.monthly_incone_heading'); ?></span>
          <h1><?php echo e($total_month_incom); ?> <span class="currency"><?php echo e($currency); ?></span></h1> 
        </div>
      </div>
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-skyblue">
          <span><?php echo app('translator')->getFromJson('admin/entries.monthly_expense_heading'); ?></span>
          <h1><?php echo e($total_month_expense); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="collection_account_box bg-color-pink">
          <span><?php echo app('translator')->getFromJson('admin/entries.total_receivable_heading'); ?></span>
          <h1><?php echo e($total_receivable); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
        </div>
      </div>


      <div class="col-sm-3">
        <div class="collection_account_box bg-color-orange">
          <span><?php echo app('translator')->getFromJson('admin/entries.total_payable_heading'); ?></span>
          <h1><?php echo e($total_payable); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
        </div>
      </div>
    </div>

    <div class="col-md-6">
        <div class="ibox float-e-margins ibox-content border-radius">
          <canvas id="lineChart" height="150"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="ibox float-e-margins ibox-content border-radius">
          <canvas id="pieChart" height="150"></canvas>
        </div>
    </div>


    <div class="col-md-12">
        <div class="ibox float-e-margins ">
            
            <div class="ibox-content border-radius">

            <div class="ibox-title">
                <h4><?php echo app('translator')->getFromJson('admin/entries.invoice_txt'); ?></h4>
            </div>

                <div id="invoice_stats" style="" >
                <table class="table table-bordered">

                        <tbody>


                            <tr>
                                <td width="150px;"> <a href="#"><?php echo app('translator')->getFromJson('admin/entries.unpaid_txt'); ?> (<?php echo e($status['unpaid']); ?>)</a> </td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: <?php echo e($status['unpaid_percent']); ?>%;" class="progress-bar progress-bar-danger"></div>
                                    </div></td>

                               
                            </tr>
                            <tr>
                                <td><a href="#"><?php echo app('translator')->getFromJson('admin/entries.partial_paid_txt'); ?> (<?php echo e($status['partial']); ?>)</a></td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: <?php echo e($status['partial_percent']); ?>%;" class="progress-bar progress-bar-info"></div>
                                    </div></td>

                               
                            </tr>

                            <tr>
                                <td><a href="#"><?php echo app('translator')->getFromJson('admin/entries.paid_txt'); ?> (<?php echo e($status['paid']); ?>)</a></td>
                                <td><div class="progress progress-small progress-thin" style="margin-bottom: 0;">
                                        <div style="width: <?php echo e($status['paid_percent']); ?>%;" class="progress-bar progress-bar-success"></div>
                                    </div></td>

                               
                            </tr>

                        </tbody>
                    </table></div>
                <?php if(isset($recents) ): ?>
                <h4><?php echo app('translator')->getFromJson('admin/entries.recent_invoice_txt'); ?> </h4>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="120">#</th>
                        <th width="150"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                        <th><?php echo app('translator')->getFromJson('admin/entries.customer_label'); ?></th>
                        <th width="100"> <?php echo app('translator')->getFromJson('admin/entries.amt_txt'); ?></th>
                        <th width="100"><?php echo app('translator')->getFromJson('admin/entries.invoice_paid_status'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $recents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><a href="<?php echo e(url('accounting/sales/detail', $recent['id'])); ?>"> <?php echo e($recent['invoice_number']); ?> </a> </td>
                            <td><?php echo e(date('d M, Y', strtotime($recent['date']))); ?></td>
                            <td><?php echo e($recent['customer']); ?></td>
                            <td class="amount" style="width: 130px;"><?php echo e($recent['amount']); ?> <?php echo e($currency); ?></td>
                            <?php if($recent['paid'] == 1): ?>
                              <td width="100"><span class="increase-label label label-success"><?php echo app('translator')->getFromJson('admin/entries.paid_txt'); ?> </span></td>
                            <?php elseif($recent['paid'] == 2): ?>
                              <td width="100"><span class="increase-label label label-warning"><?php echo app('translator')->getFromJson('admin/entries.partial_paid_txt'); ?></span></td>
                            <?php else: ?>
                              <td width="100"><span class="increase-label label label-danger"><?php echo app('translator')->getFromJson('admin/entries.unpaid_txt'); ?></span></td>
                            <?php endif; ?>
                            
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
              <?php endif; ?>
            </div>
        </div>

    </div>

   



    

    <div class="row" id="sort_3">
    
      <div class="col-sm-12">
        <div class="col-md-6">
        <div class="ibox float-e-margins">
            
            <div class="ibox-content border-radius">
            <div class="ibox-title">
                <h4><?php echo app('translator')->getFromJson('admin/entries.latest_income_txt'); ?></h4>
            </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                            <th><?php echo app('translator')->getFromJson('admin/entries.account_description_label'); ?></th>
                            <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.amt_txt'); ?></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php if(isset($payments) ): ?>
                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td width="150"><?php echo e($payment['date']); ?></td>
                                    <td><?php echo e($payment['description']); ?></td>
                                    <td width="100" align="right" style="width: 120px;"><?php echo e($payment['amount']); ?> <?php echo e($currency); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3"><?php echo app('translator')->getFromJson('admin/common.notfound'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    
                </table>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <div class="ibox float-e-margins">
           
            <div class="ibox-content border-radius">
            <div class="ibox-title">
                <h4><?php echo app('translator')->getFromJson('admin/entries.latest_paid_voucher_txt'); ?></h4>
            </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                            <th><?php echo app('translator')->getFromJson('admin/entries.account_description_label'); ?></th>
                            <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.amt_txt'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(isset($vouchers) ): ?>
                            <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td width="150"><?php echo e($payment['date']); ?></td>
                                    <td><?php echo e($payment['description']); ?></td>
                                    <td width="100" align="right" style="width: 120px;"><?php echo e($payment['amount']); ?> <?php echo e($currency); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3"><?php echo app('translator')->getFromJson('admin/common.notfound'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>


                </table>
            </div>
        </div>

    </div>
      </div>


</div>


    </div>
 </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('assets/chart/css/style.css')); ?>" type="text/css" rel="stylesheet">

<script src="<?php echo e(asset('assets/chart/js/jquery-3.2.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/chart/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/chart/js/mdb.min.js')); ?>"></script>

<script type="text/javascript">
  //line
var ctxL = document.getElementById("lineChart").getContext('2d');
var total_month = <?php echo json_encode($total_month); ?>;
var monthly_income = <?php echo json_encode($monthly_income); ?>;
var montly_expense = <?php echo json_encode($montly_expense); ?>;
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: total_month,
        datasets: [
            {
                label: "Sale",
                fillColor: "rgba(90,70,142,1)",
                strokeColor: "rgba(90,70,142,1)",
                pointColor: "rgba(90,70,142,1)",
                pointStrokeColor: "#1bbc9b",
                pointHighlightFill: "#000000",
                pointHighlightStroke: "rgba(90,70,142,1)",
                data: monthly_income
            },
            {
                label: "Purchase",
                fillColor: "rgba(151,187,205,0.8)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: montly_expense
            }
        ]
    },
    options: {
        responsive: true
    }    
});

//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var tlt_pie = <?php echo json_encode($total_pie); ?>

var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
        labels: ["Income", "Expense"],
        datasets: [
            {
                data: tlt_pie,
                backgroundColor: ["#46BFBD", "#F7464A"],
                hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
            }
        ]
    },
    options: {
        responsive: true
    }    
});
         
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>