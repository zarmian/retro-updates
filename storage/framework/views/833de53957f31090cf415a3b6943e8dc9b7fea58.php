<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Invoice</title>

  <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<link href="<?php echo e(asset('assets/bootstrap/css/bootstrap.css?v=1.23')); ?>" type="text/css" rel="stylesheet">

<link href="<?php echo e(asset('assets/css/stylesheet-main.css?v=1.3')); ?>" type="text/css" rel="stylesheet">
</head>
<body>


<div class="container mainwrapper">
  <div class="row">
    <div class="container">
     
               
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-margin-space-inv">


            <div class="inv-block clearfix">

           
              <div class="invoice-top-space clearfix">
                <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                  <div class="col-sm-7 col-lg-7 col-md-7 col-xs-12 invoice-left-block">
                    
                    <h2><?php echo app('translator')->getFromJson('admin/entries.invoice_no_txt'); ?>: <?php echo app('translator')->getFromJson('admin/common.inv_prefix'); ?> <?php echo e($sale['inv_no']); ?></h2>

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
                      
                      E: <?php echo $sale['customer']->email; ?> <br>
                      
                    <?php endif; ?>
                    <?php if(isset($sale['customer']->phone) && !is_null($sale['customer']->phone) && $sale['customer']->phone <> ""): ?>
                  
                      T: <?php echo $sale['customer']->phone; ?> <br>
                  
                    <?php endif; ?>

                    <?php if(isset($sale['customer']->mobile) && !is_null($sale['customer']->mobile) && $sale['customer']->mobile <> ""): ?>
                  
                      Mob: <?php echo $sale['customer']->mobile; ?> 
                  
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

                    <?php if(isset($sale['details']) && count($sale['details'])): ?>
                      <?php $__currentLoopData = $sale['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="td-dark-gray"><?php echo $detail['description']; ?></td>
                          <td class="td-light-gray text-center"><b><?php echo e($detail['qty']); ?></b></td>
                          <td class="td-dark-gray text-center"><b><?php echo e($detail['unit_price']); ?></b></td>
                          <td class="td-light-gray text-center"><b><?php echo e($detail['amount']); ?></b></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                  </table>

                   
                </div>

                <div class="col-sm-4 col-sm-offset-8">
                 <table class="table table-bordered total_cal" id="total_cal" style="text-align: right">
                   <tr>
                     <th width="150" class="text-right"><?php echo app('translator')->getFromJson('admin/entries.sub_total_txt'); ?></th>
                     <td><?php echo e($sale['unit_price']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.discount_txt'); ?></th>
                     <td><?php echo e($sale['discount']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.total_txt'); ?></th>
                     <td><?php echo e($sale['total']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.total_paid_txt'); ?></th>
                     <td><?php echo e($sale['tlt_paid_sum']); ?></td>
                   </tr>

                   <tr>
                     <th class="text-right"><?php echo app('translator')->getFromJson('admin/entries.amount_due_txt'); ?></th>
                     <td><?php echo e($sale['due_amount']); ?></td>
                   </tr>
                 </table>
               </div>

               <div class="col-sm-7 clearfix">&nbsp;</div>


               <div class="col-sm-12 visible-print-block clearfix">
            <?php if(isset($sale['payments']) && count($sale['payments']) > 0): ?>
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
                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $payment['payment_no']; ?></td>
                          <td class="td-light-gray" height="30" align="left" style="background: #f5f5f5 !important; padding-left: 10px;"><?php echo e(date('d, M Y', strtotime($payment['date']))); ?></td>

                          <td class="td-dark-gray" height="30" style="background: #efefef !important; padding-left: 10px;"><?php echo $payment['description']; ?></td>
                          <td class="td-light-gray text-center" height="30" style="background: #f5f5f5 !important"><b><?php echo e($payment['amount']); ?></b></td>
                         
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    

                  </table>

                   
                </div>

              <?php endif; ?>
               </div>
              </div>



              

            </div>
             
             <div class="col-sm-12 no-padding text-right hidden-print">
             <br>
               <button type="button" class="btn btn-primary do-print"><?php echo app('translator')->getFromJson('admin/entries.print_txt'); ?></button>
             </div>
            
          </div>


          
    </div>
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

    <script type="text/javascript">

    $(document).on('click', '.do-print', function(){
      window.print();
    });

  </script>

</body>
</html>