<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/entries.sales_heading_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
      <a href="<?php echo e(url('accounting/sales')); ?>"><?php echo app('translator')->getFromJson('admin/entries.sales_heading_txt'); ?></a> / 
      <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/entries.manage_payment_txt'); ?></a>  
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>



<div class="container mainwrapper">
  <div class="row">
    <div class="container">
     

      <?php if(Session::has('msg')): ?>
        <div class="alert alert-success"><?php echo e(Session::get('msg')); ?></div>
      <?php endif; ?>
      
    
               
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top-margin-space-inv">
            
            <div class="inv-block clearfix">

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 hidden-print">
                <div class="inv-no-heading">
                  <h2><?php echo app('translator')->getFromJson('admin/entries.invoice_no_txt'); ?>: <?php echo app('translator')->getFromJson('admin/common.inv_prefix'); ?> <?php echo e($sale['inv_no']); ?></h2>
                </div>
              </div>

              <div class="col-sm-6 col-lg-6 col-md-6 col-xs-6 no-padding-right">
                <div class="invoice_btns text-right">
                  <ul class="hidden-print">
                    
                    

                    <li><a href="javascript:void(0)" class="do-print payment-btn btn-blue-bg"><i class="fa fa-print"></i></a></li>
                    <li><a href="<?php echo e(url('accounting/sales/edit', $sale['id'])); ?>" class="payment-btn btn-light-purple-bg"><i class="fa fa-eye"></i></a></li>
                    <li><a data-toggle="modal" data-target="#paymentModal" data-id="<?php echo e($sale['id']); ?>" rel="tooltip" class="payment-btn btn-gray-bg cursor-pointer"><i class="fa fa-plus"></i></a></li>

                    <li><a href="javascript:void(0)" id="do-email"></a>

                    
                      <li role="presentation" class="dropdown btn-env"> <a class="payment-btn btn-pink-bg" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i> </a>

                        <ul class="dropdown-menu invoice-menu">
                          <li><a href="javascript:void(0)" id="mail_invoice_created" data-id="<?php echo e($sale['id']); ?>" data-st="created"><?php echo app('translator')->getFromJson('admin/entries.create_invoice_btn'); ?></a></li>
                          <li> <a href="javascript:void(0)" id="mail_invoice_reminder" data-id="<?php echo e($sale['id']); ?>" data-st="reminder"><?php echo app('translator')->getFromJson('admin/entries.create_payment_reminder_btn'); ?></a></li>
                          <li><a href="javascript:void(0)" id="mail_invoice_overdue" data-id="<?php echo e($sale['id']); ?>" data-st="overdue"><?php echo app('translator')->getFromJson('admin/entries.create_invoice_overdue_btn'); ?></a></li>
                          <li><a href="javascript:void(0)" id="mail_invoice_confirm" data-id="<?php echo e($sale['id']); ?>" data-st="confirmation"><?php echo app('translator')->getFromJson('admin/entries.invoice_payement_confirmation'); ?></a></li>
                          

                        </ul>

                      </li>


                    </li>
                  </ul>

                  <div class="clearfix"></div>
                </div>
              </div>

              <div class="invoice-top-space clearfix">
                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <div class="col-sm-7 col-lg-7 col-md-7 col-xs-12 invoice-left-block">
                    
                    <h2 class="visible-print-block"><?php echo app('translator')->getFromJson('admin/entries.invoice_no_txt'); ?>: <?php echo e($sale['inv_no']); ?></h2>

                    <div class="inv-log"><img src="<?php echo e(asset($business_logo_image)); ?>" alt=""></div>
                    <div class="setting-detail">
                      <h2><?php echo e($business_name); ?></h2>
                      <p><?php echo $business_address; ?></p>

                      <p>
                        <?php echo app('translator')->getFromJson('admin/entries.email_short_txt'); ?> <?php echo e($business_email); ?><br>
                        <?php echo app('translator')->getFromJson('admin/entries.phone_short_txt'); ?>   <?php echo e($business_phone); ?><br>
                        <?php echo app('translator')->getFromJson('admin/entries.mobile_short_txt'); ?>  <?php echo e($business_mobile); ?>

                      </p>
                    </div>
                  </div>
                <div class="col-lg-5 col-md-5 col-xs-12 col-sm-5 invoice-right-block">

                <div class="text-right">
                  
                  <div class="invoice-detail">
                    <h4><?php echo app('translator')->getFromJson('admin/entries.invoice_detail_txt'); ?></h4>
                    <p>
                      <b><?php echo app('translator')->getFromJson('admin/entries.invoice_date_label'); ?>: <?php echo e($sale['inv_date']); ?></b> <br>
                      <span class="color-red"><b><?php echo app('translator')->getFromJson('admin/entries.invoice_due_date_label'); ?>: <?php echo e($sale['due_date']); ?></b></span> <br>
                      <b><?php echo app('translator')->getFromJson('admin/entries.reference_label'); ?>: <?php echo e($sale['reference']); ?></b> <br>
                      <div id="paid_status">
                        <?php if($sale['paid_status'] == 3): ?>
                          <span class="increase-label label label-danger"><?php echo app('translator')->getFromJson('admin/entries.unpaid_txt'); ?></span>
                        <?php elseif($sale['paid_status'] == 2): ?>
                          <span class="increase-label label label-warning"><?php echo app('translator')->getFromJson('admin/entries.partial_paid_txt'); ?></span>
                        <?php else: ?>
                          <span class="increase-label label label-success"><?php echo app('translator')->getFromJson('admin/entries.paid_txt'); ?></span>
                        <?php endif; ?>
                      
                      </div>
                    </p>
                  </div>

                  <div class="customer-detail">
                    <h3><?php echo app('translator')->getFromJson('admin/entries.invoice_customer_detail_txt'); ?></h3>
                    <h4><?php echo e($sale['customer']->first_name); ?> <?php echo e($sale['customer']->last_name); ?></h4>
                    <p>
                    <?php if(isset($sale['customer']->company) && !is_null($sale['customer']->company) && $sale['customer']->company <> ""): ?>

                      (<?php echo e($sale['customer']->company); ?>) 
                    <?php endif; ?>

                    <?php if(isset($sale['customer']->present_address) && !is_null($sale['customer']->present_address) && $sale['customer']->present_address <> ""): ?>
                    <br>
                      <?php echo $sale['customer']->present_address; ?>

                      
                    <?php endif; ?>

                    <?php if(isset($sale['customer']->permanent_address) && !is_null($sale['customer']->permanent_address) && $sale['customer']->permanent_address <> ""): ?>
                      <br>
                      <?php echo $sale['customer']->permanent_address; ?>

                      
                    <?php endif; ?>
                    </p>

                    <p>

                     <?php if(isset($sale['customer']->email) && !is_null($sale['customer']->email) && $sale['customer']->email <> ""): ?>
                      
                      <?php echo app('translator')->getFromJson('admin/entries.email_short_txt'); ?>  <?php echo $sale['customer']->email; ?> <br>
                      
                    <?php endif; ?>
                    <?php if(isset($sale['customer']->phone) && !is_null($sale['customer']->phone) && $sale['customer']->phone <> ""): ?>
                  
                      <?php echo app('translator')->getFromJson('admin/entries.phone_short_txt'); ?> <?php echo $sale['customer']->phone; ?> <br>
                  
                    <?php endif; ?>

                    <?php if(isset($sale['customer']->mobile) && !is_null($sale['customer']->mobile) && $sale['customer']->mobile <> ""): ?>
                  
                      <?php echo app('translator')->getFromJson('admin/entries.mobile_short_txt'); ?> <?php echo $sale['customer']->mobile; ?> 
                  
                    <?php endif; ?>
                      </p>
                  </div>

                </div>
                  
                  

                </div>
                </div>
              </div>

              <div class="invoice-top-space clearfix">

                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <table class="table">
                    <tr>
                      <th class="border-none"><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?></th>
                      <th class="border-none" width="100"><?php echo app('translator')->getFromJson('admin/entries.quantity_txt'); ?></th>
                      <th class="border-none" width="150"><?php echo app('translator')->getFromJson('admin/entries.account_unit_price_label'); ?></th>
                      <th class="border-none" width="150"><?php echo app('translator')->getFromJson('admin/entries.total_amount_txt'); ?></th>
                    </tr>

                    <?php if(isset($sale['details']) ): ?>
                      <?php $__currentLoopData = $sale['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="td-dark-gray"><?php echo $detail['title']; ?></td>
                          <td class="td-light-gray text-center"><b><?php echo e($detail['qty']); ?></b></td>
                          <td class="td-dark-gray text-center"><b><?php echo e($detail['unit_price']); ?></b></td>
                          <td class="td-light-gray text-center"><b><?php echo e($detail['amount']); ?></b></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                  </table>

                   
                </div>

                <div class="col-sm-5 col-sm-offset-7">
                 <table class="table table-bordered total_cal" id="total_cal">
                   <tr>
                     <th width="150" class="text-right"><?php echo app('translator')->getFromJson('admin/entries.invoice_sub_total_txt'); ?></th>
                     <td><?php echo e($sale['unit_price']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.discount_txt'); ?></th>
                     <td><?php echo e($sale['discount']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right">TAX</th>
                     <td><?php echo e($sale['vat_tax_amount']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.invoice_total_txt'); ?></th>
                     <td><?php echo e($sale['total']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.total_amount_txt'); ?></th>
                     <td><?php echo e($sale['tlt_paid_sum']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.amount_due_txt'); ?></th>
                     <td><?php echo e($sale['due_amount']); ?></td>
                   </tr>
                 </table>
               </div>



               <div class="col-sm-7 clearfix">&nbsp;</div>

               
               <div class="col-sm-12 clearfix">
                  <?php if(isset($sale['payments']) ): ?>
              <div class="invoice-top-space">
                <h3><?php echo app('translator')->getFromJson('admin/entries.invoice_payment_txt'); ?></h3>
                  <table class="table" width="100%">
                    <tr>
                      <th class="border-none" align="left" style="font-weight: normal;" width="100" height="30">#</th>
                      <th class="border-none" align="left" style="font-weight: normal;" width="200" height="30"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?></th>
                      <th class="border-none" align="left" style="font-weight: normal;" ><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?></th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" ><?php echo app('translator')->getFromJson('admin/entries.paid_amount_txt'); ?></th>
                      
                    </tr>

                    
                      <?php $__currentLoopData = $sale['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo app('translator')->getFromJson('admin/common.payment_prefix'); ?> <?php echo $payment['payment_no']; ?></td>
                          <td class="td-light-gray" height="30" align="left" style="background: #f5f5f5 !important; padding-left: 10px;"><?php echo e(date('d, M Y', strtotime($payment['date']))); ?></td>

                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $payment['description']; ?></td>
                          <td class="td-light-gray text-center" height="30" style="background: #f5f5f5 !important"><b><?php echo e($payment['amount']); ?></b></td>
                         
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

                  </table>

                   
                </div>

              <?php endif; ?>
               </div>

                <?php if(!empty($sale['note'])): ?>
                  <div class="col-sm-12"><b><?php echo app('translator')->getFromJson('admin/entries.reference_textarea_label'); ?></b> <br> <?php echo e($sale['note']); ?></div>
                <?php endif; ?>
              </div>



              

            </div>
             
            
          </div>


          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top-margin-space-inv hidden-print">
            <div class="inv-block clearfix">
              <div class="col-sm-10 col-lg-8 col-md-8 col-xs-8">
                <div class="inv-no-heading">
                  <h2><?php echo app('translator')->getFromJson('admin/entries.payment_detail_txt'); ?></h2>
                </div>
              </div>

              <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                
                <div class="invoice-payments no-print">
                  <h3><?php echo app('translator')->getFromJson('admin/entries.invoice_amount_txt'); ?></h3>
                  <div class="amounts">
                    <p>
                      <?php echo app('translator')->getFromJson('admin/entries.invoice_total_txt'); ?>: <?php echo e($sale['total']); ?> <br>
                      <?php echo app('translator')->getFromJson('admin/entries.total_paid_txt'); ?>: <?php echo e($sale['tlt_paid_sum']); ?> <br>
                      <?php echo app('translator')->getFromJson('admin/entries.amount_due_txt'); ?>: <?php echo e($sale['due_amount']); ?>

                    </p>

                    <button data-toggle="modal" data-target="#paymentModal" data-id="<?php echo e($sale['id']); ?>" rel="tooltip" class="btn btn-danger btn-block new-btn"><?php echo app('translator')->getFromJson('admin/entries.add_payment_button'); ?></button>
                  </div>

                </div>

                <div class="payments-records">
                  <h4><?php echo app('translator')->getFromJson('admin/entries.payment_records'); ?></h4>
                  <div id="PaymentsViews">
                  <?php if(isset($sale['payments']) ): ?>
                    <?php $__currentLoopData = $sale['payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                      <div class="payment-bar">
                        <span class="pe_no"><?php echo app('translator')->getFromJson('admin/common.payment_prefix'); ?> <?php echo e($payment['payment_no']); ?></span>  <span class="pe_date"><?php echo app('translator')->getFromJson('admin/entries.date_label'); ?>: <?php echo e(date('d, M Y', strtotime($payment['date']))); ?> </span>
                      </div>

                      <div class="payment-detail">
                        <p>
                          <?php echo app('translator')->getFromJson('admin/entries.paid_amount_txt'); ?>: <?php echo e($payment['amount']); ?> <br>
                          <?php echo app('translator')->getFromJson('admin/entries.account_label'); ?>: <?php echo e($payment['account_name']); ?> <br>
                          <?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?>: <?php echo e($payment['description']); ?>

                        </p>
                      </div>
        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                  </div>
                </div>


              </div>
            </div>
          </div>
    </div>
  </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content clearfix" id="paymentView">
    </div>
  </div>
</div>


<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog" role="document" id="modal-html">
  </div>

</div>



<style type="text/css" media="print">

  table td.td-dark-gray{
    background: #efefef !important;
    border-color:#FFF !important; 
    
  }

  table td.td-light-gray{
    background: #f5f5f5 !important;
    border-color:#FFF !important; 

  }

  .find-search, .topWrapper, .breadcrumb, .menu, .invoice_btns{
    display: none !important;
  }

  .inv-no-heading {
    margin-top: -31px !important;
    background-color: #FFF !important;
    box-shadow: 5px 2px 10px #cecece !important;
    border: 1px solid #cecece;
    width: 100% !important;
    height: 50px;

}

.inv-no-heading h2 {
    font-size: 16px;
    font-weight: bold;
    line-height: 10px;
    padding-left: 20px;
}

.invoice-left-block{
  float: left !important;
  width: 500px !important;
}

.invoice-right-block{
  float: right !important;
  width: 300px !important;
}

.total_cal{
    width: 300px;
    float: right;
}

.inv-block{
  border: none !important;
}

.top-margin-space-inv{
    margin-top: 0px !important;
    padding-bottom: 0px !important;
}


</style>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

  <script type="text/javascript" src="<?php echo e(asset('assets/js/email-templates.js')); ?>"></script>

    <script type="text/javascript">

    $(document).on('click', '.do-print', function(){
      window.print();
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>