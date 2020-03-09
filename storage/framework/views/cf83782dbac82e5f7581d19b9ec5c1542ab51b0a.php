<link href="<?php echo e(asset('assets/bootstrap/css/bootstrap.css?v=1.23')); ?>" type="text/css" rel="stylesheet">

<style type="text/css">

.invoice-top-space{
  margin-top: 50px;
  display: block;
}

div.setting-detail p{
  line-height:50em !important;
  color: #000066;
}

.color-red{
  color: red;
}
</style>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 top-margin-space-inv">
            
            <div class="inv-block clearfix">


            	<table width="100%">
            		<tr>
            			<td width="50%" align="left">
            				
            				<div class="col-sm-7 col-lg-7 col-md-7 col-xs-12 invoice-left-block">
                    
                    <h2 class="visible-print-block"><?php echo app('translator')->getFromJson('admin/entries.voucher_number_txt'); ?>: <?php echo e($sale['inv_no']); ?></h2>

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

            			</td>
            			<td width="50%" align="right">
            				
            				<div class="text-right" style="text-align: right !important;">
                  
                  <div class="invoice-detail">
                    <h4><?php echo app('translator')->getFromJson('admin/entries.voucher_detail_txt'); ?></h4>
                    <p>
                      <?php echo app('translator')->getFromJson('admin/entries.voucher_date_label'); ?>: <?php echo e($sale['inv_date']); ?> <br>
                      <span class="color-red"><?php echo app('translator')->getFromJson('admin/entries.invoice_due_date_label'); ?>: <?php echo e($sale['due_date']); ?></span> <br>
                      <div id="paid_status" style="padding: 20px !important; display: block !important;">
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
                    <h3><?php echo app('translator')->getFromJson('admin/entries.vendor_customer_detail_txt'); ?></h3>
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
                      
                      <?php echo app('translator')->getFromJson('admin/entries.email_short_txt'); ?> <?php echo $sale['customer']->email; ?> <br>
                      
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

            			</td>
            		</tr>
            	</table>

              
           

              <div class="invoice-top-space clearfix">

                <div class="">
                  <table class="table" width="100%">
                    <tr>
                      <th class="border-none" align="left" style="font-weight: normal;"><?php echo app('translator')->getFromJson('admin/entries.detail_txt'); ?></th>
                      <th class="border-none" align="center" style="font-weight: normal;" width="100"><?php echo app('translator')->getFromJson('admin/entries.quantity_txt'); ?></th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" ><?php echo app('translator')->getFromJson('admin/entries.account_unit_price_label'); ?></th>
                      <th class="border-none" width="150" align="center" style="font-weight: normal;" height="40"><?php echo app('translator')->getFromJson('admin/entries.total_amount_txt'); ?></th>
                    </tr>

                    <?php if(isset($sale['details']) && count($sale['details'])): ?>
                      <?php $__currentLoopData = $sale['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $detail['description']; ?></td>
                          <td class="td-light-gray text-center" style="background: #f5f5f5 !important;"><b><?php echo e(number_format($detail['qty'], 2)); ?></b></td>
                          <td class="td-dark-gray text-center" style="background: #efefef !important"><b><?php echo e(number_format($detail['unit_price'], 2)); ?> <span class="currency"><?php echo e($currency); ?></span></b></td>
                          <td class="td-light-gray text-center" style="background: #f5f5f5 !important;"><b><?php echo e(number_format($detail['amount'], 2)); ?> <span class="currency"><?php echo e($currency); ?></span></b></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                  </table>

                   
                </div>

                <div class="">
                 <table class="table table-bordered total_cal" width="300" style="width: 300px !important" id="total_cal" align="right">
                   <tr>
                     <td width="150" height="30" class="text-right" style="padding-right: 20px;"><?php echo app('translator')->getFromJson('admin/entries.invoice_sub_total_txt'); ?></td>
                     <td style="padding-left: 20px;"><?php echo e(number_format($sale['details']->sum('unit_price'), 2)); ?> <span class="currency"><?php echo e($currency); ?></span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right"><?php echo app('translator')->getFromJson('admin/entries.discount_txt'); ?></td>
                     <td style="padding-left: 20px;"><?php echo e(number_format($sale['discount'], 2)); ?> <span class="currency"><?php echo e($currency); ?></span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right"><?php echo app('translator')->getFromJson('admin/entries.invoice_total_txt'); ?></td>
                     <td style="padding-left: 20px;"><?php echo e(number_format($sale['details']->sum('amount') - $sale['discount'], 2)); ?> <span class="currency"><?php echo e($currency); ?></span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right"> <?php echo app('translator')->getFromJson('admin/entries.total_amount_txt'); ?></td>
                     <td style="padding-left: 20px;"><?php echo e(number_format($sale['payments']->sum('amount'), 2)); ?> <span class="currency"><?php echo e($currency); ?></span></td>
                   </tr>

                   <tr>
                     <td style="padding-right: 20px;" height="30" class="text-right"><?php echo app('translator')->getFromJson('admin/entries.amount_due_txt'); ?></td>
                     <td style="padding-left: 20px;"><?php echo e(number_format($sale['details']->sum('amount') - $sale['discount'] - $sale['payments']->sum('amount'), 2)); ?> <span class="currency"><?php echo e($currency); ?></span></td>
                   </tr>
                 </table>
               </div>
              </div>

              <?php if(isset($sale['payments']) && count($sale['payments']) > 0): ?>
              <div class="invoice-top-space clearfix">
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
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $payment->payment_no; ?></td>
                          <td class="td-light-gray" height="30" align="left" style="background: #f5f5f5 !important; padding-left: 10px;"><?php echo e(date('d, M Y', strtotime($payment->date))); ?></td>

                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $payment->description; ?></td>
                          <td class="td-light-gray text-center" height="30" style="background: #f5f5f5 !important"><b><?php echo e(number_format($payment->amount, 2)); ?> <span class="currency"><?php echo e($currency); ?></span></b></td>
                         
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

                  </table>

                   
                </div>

              <?php endif; ?>

            </div>
             
            
          </div>