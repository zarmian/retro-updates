
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/customers.customer_detail_heading'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/customers')); ?>"><?php echo app('translator')->getFromJson('admin/customers.manage_heading'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/customers.customer_detail_heading'); ?></a>
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
        <div class="panel panel-default ibox-content-shadow">
          <div class="panel-body">
            <div class="customer-box">
              <h2><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></h2>
              <p class="e-code"># <?php echo e($customer->code); ?> </p>

              <div class="e-detail">
                <p><b><?php echo app('translator')->getFromJson('admin/customers.email_txt'); ?>: </b> <?php echo e($customer->email); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/customers.phone_txt'); ?>:</b> <?php echo e($customer->phone); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/users.cell_label'); ?>:</b> <?php echo e($customer->mobile); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/users.fax_label'); ?>:</b> <?php echo e($customer->fax); ?></p>
              </div>

              <div class="e-detail">
                <h3><?php echo app('translator')->getFromJson('admin/customers.company_txt'); ?></h3>
                <h4> <?php echo e($customer->company); ?></h4>
              </div>

              <div class="e-detail">
                <h3><?php echo app('translator')->getFromJson('admin/users.present_address_label'); ?></h3>
                <p><?php echo $customer->present_address; ?></p>
                <h3><?php echo app('translator')->getFromJson('admin/users.permanant_address_label'); ?></h3>
                <p><?php echo $customer->permanent_address; ?></p>
              </div>

              <div class="e-detail">
                <p> <b><?php echo app('translator')->getFromJson('admin/customers.country_txt'); ?></b> <?php echo e($customer->country->country_name); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/users.state_label'); ?>: </b> <?php echo e($customer->state); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/users.city_label'); ?>: </b><?php echo e($customer->city); ?></p>
                <p><b><?php echo app('translator')->getFromJson('admin/users.postal_label'); ?>: </b> <?php echo e($customer->postal_code); ?></p>

              </div>

              <div class="e-detail">
                <h3><?php echo app('translator')->getFromJson('admin/users.reference_label'); ?></h3>
                <p><?php echo $customer->other; ?></p>
                
              </div>


            </div>
           
          </div>
        </div>
      </div>

      <div class="col-sm-9">

      <ul class="nav nav-tabs profile-tabs" role="tablist">
        <li class="active"><a href="#charts" class="ctabs"><?php echo app('translator')->getFromJson('admin/customers.overview_txt'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
        <li><a href="#invoices" class="ctabs"><?php echo app('translator')->getFromJson('admin/customers.invoices_txt'); ?> <i class="fa fa-caret-down" aria-hidden="true"></i></a></li>
        
      </ul>
        
        <section id="charts">
          
          <div class="account_block">
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-seagreen">
                <span><?php echo app('translator')->getFromJson('admin/customers.total_order_amount_txt'); ?></span>
                <h1><?php echo e(number_format($total_order_amount, 2)); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-skyblue">
                <span><?php echo app('translator')->getFromJson('admin/customers.total_rec_amount_txt'); ?></span>
                <h1><?php echo e(number_format($total_received, 2)); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="collection_account_box bg-color-pink">
                <span><?php echo app('translator')->getFromJson('admin/customers.total_pend_amount_txt'); ?></span>
                <h1><?php echo e(number_format($total_pending, 2)); ?> <span class="currency"><?php echo e($currency); ?></span></h1>
              </div>
            </div>
          </div>


          <div class="col-md-12">
            <div class="ibox float-e-margins ibox-content border-radius">
              <canvas id="lineChart" height="100"></canvas>
            </div>
          </div>


        </section>



        <section id="invoices">

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
                <?php if(isset($recents) && count($recents) > 0): ?>
                <h4><?php echo app('translator')->getFromJson('admin/entries.recent_invoice_txt'); ?> </h4>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="120">#</th>
                        <th width="150"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                        <th><?php echo app('translator')->getFromJson('admin/entries.customer_label'); ?></th>
                        <th width="130"> <?php echo app('translator')->getFromJson('admin/entries.amt_txt'); ?></th>
                        <th width="100"><?php echo app('translator')->getFromJson('admin/entries.invoice_paid_status'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $recents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><a href="<?php echo e(url('accounting/sales/detail', $recent['id'])); ?>"> <?php echo e($recent['invoice_number']); ?> </a> </td>
                            <td><?php echo e(date('d M, Y', strtotime($recent['date']))); ?></td>
                            <td><?php echo e($recent['customer']); ?></td>
                            <td class="amount"><?php echo e($recent['amount']); ?> <span class="currency"><?php echo e($currency); ?></span></td>
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

        </section>

       
      </div>


    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('assets/chart/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/chart/js/mdb.min.js')); ?>"></script>

<script type="text/javascript">
  //line
var ctxL = document.getElementById("lineChart").getContext('2d');
var total_month = <?php echo json_encode($total_month); ?>;
var customer_sale = <?php echo json_encode($sales_chart); ?>;
var customer_paid = <?php echo json_encode($sales_received); ?>;
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: total_month,
        datasets: [
            {
                label: "<?php echo app('translator')->getFromJson('admin/customers.sales_txt'); ?>",
                fillColor: "rgba(0,70,142,0.2)",
                strokeColor: "rgba(90,70,142,1)",
                pointColor: "rgba(90,70,142,1)",
                pointStrokeColor: "#000000",
                pointHighlightFill: "#000000",
                pointHighlightStroke: "rgba(90,70,142,1)",
                data: customer_sale
            },
            {
                label: "<?php echo app('translator')->getFromJson('admin/customers.received_payment_txt'); ?>",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: customer_paid
            }
        ]
    },
    options: {
        responsive: true
    }    
});
    
</script>

<script type="text/javascript">
$(document).ready(function () {
$(window).scroll(function(){
        var window_top = $(window).scrollTop() + 12; 
       // the "12" should equal the margin-top value for nav.stickydiv
        var div_top = $('#checkdiv').offset().top;
        if (window_top >= div_top) {
                $('nav').addClass('stickydiv');
            } else {
                $('nav').removeClass('stickydiv');
            }
    });  



$('.ctabs').on('click', function (e) {
  
      e.preventDefault();
        $(document).off("scroll");
         $('a').each(function () {
            $(this).closest('li').removeClass('active');
        })
        $(this).closest('li').addClass('active');
         var target = this.hash,
         menu = target;
         $target = $(target);
       $('html, body').stop().animate({
            'scrollTop': $target.offset().top+2
        }, 600, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
});


</script>







<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>