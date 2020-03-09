
<?php $__env->startSection('breadcrumb'); ?>
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo app('translator')->getFromJson('admin/entries.purchase_heading_txt'); ?></h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="<?php echo e(url('/')); ?>"><?php echo app('translator')->getFromJson('admin/dashboard.dashboard-heading'); ?></a>  / 
        <a href="<?php echo e(url('accounting/purchase')); ?>"><?php echo app('translator')->getFromJson('admin/entries.purchase_heading_txt'); ?></a>  / 
        <a href="#" class="active"><?php echo app('translator')->getFromJson('admin/entries.update_purchase_heading'); ?></a>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <?php if(Session::has('msg')): ?>
          <div class="alert alert-success">
            <?php echo e(Session::get('msg')); ?>

          </div>
          <?php endif; ?>
          
          <?php if(isset($errors) && count($errors) > 0): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
         <?php endif; ?>

         <form data-toggle="validator" role="form" action="<?php echo e(url('accounting/purchase/edit', $sale['id'])); ?>" method="POST" enctype="multipart/form-data" class="erp-form erp-ac-transaction-form">
         
          <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

          <div class="form_container">

          
          
          <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 col-sm-offset-2">
            <div class="top_content">
              <h3><?php echo app('translator')->getFromJson('admin/entries.update_purchase_heading'); ?></h3>
              <p><?php echo app('translator')->getFromJson('admin/users.field_employee_text'); ?></p>
            </div>

            <div class="form_container">

                <div class="col-md-5 col-sm-5 col-lg-5 col-xs-5 form-group">
                  <label for="vendor" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.vendor_label'); ?>*</label>
                  <select name="vendor" id="vendor" class="form-control1 chosen">
                    <option value=""><?php echo app('translator')->getFromJson('admin/common.select_customer_txt'); ?></option>
                    <?php if(isset($customers) && count($customers) > 0): ?>
                      <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($sale['customer_id'] == $customer->id): ?>
                          <option value="<?php echo e($customer->id); ?>" selected="selected"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
                        <?php else: ?>
                          <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->first_name); ?> <?php echo e($customer->last_name); ?></option>
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>
                </div>


                 <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3 form-group">
                  <label for="reference" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.reference_label'); ?></label>
                  <input type="text" name="reference" id="reference" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/entries.reference_label'); ?>" value="<?php echo e($sale['reference']); ?>"   />
                </div>

                <div class="col-md-4 col-sm-4 col-lg-4 col-xs-4 form-group">
                  <label for="invoice_no" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.voucher_number_txt'); ?>*</label>
                  <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">VR</span>
                    <input type="text" name="invoice_no" id="invoice_no" class="form-control1" placeholder="<?php echo app('translator')->getFromJson('admin/entries.voucher_number_txt'); ?>*" value="<?php echo e($sale['invoice_number']); ?>" readonly="readonly" style="border-bottom-left-radius: 0px;border-top-left-radius: 0px;" />
                  </div>
                 
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="invoice_date" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.voucher_date_label'); ?>*</label>
                  <input type="text" name="invoice_date" id="invoice_date" class="form-control1 datepicker" placeholder="<?php echo app('translator')->getFromJson('admin/entries.voucher_date_label'); ?>" data-default-date="<?php echo e($sale['invoice_date']); ?>" data-format="m/d/Y" data-min-year="<?php echo e(date('Y',time())); ?>" data-max-year="<?php echo e(date('Y',strtotime('+10 year',time()))); ?>" />
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6 form-group">
                  <label for="due_date" class="input_label"><?php echo app('translator')->getFromJson('admin/entries.invoice_due_date_label'); ?>*</label>
                  <input type="text" name="due_date" id="due_date" class="form-control1 datepicker" placeholder="<?php echo app('translator')->getFromJson('admin/entries.invoice_due_date_label'); ?>" data-default-date="<?php echo e($sale['due_date']); ?>" data-format="m/d/Y" data-min-year="<?php echo e(date('Y',time())); ?>" data-max-year="<?php echo e(date('Y',strtotime('+10 year',time()))); ?>" />
                </div>

                <div class="col-sm-12">
                  <table class="erp-table erp-ac-transaction-table payment-voucher-table">
                    <thead>
                        <tr>
                            <th class="col-chart"><?php echo app('translator')->getFromJson('admin/entries.account_label'); ?></th>
                            <th class="col-desc"><?php echo app('translator')->getFromJson('admin/entries.account_description_label'); ?></th>
                            <th class="col-desc"><?php echo app('translator')->getFromJson('admin/entries.account_qty_label'); ?></th>
                            <th class="col-desc"><?php echo app('translator')->getFromJson('admin/entries.account_unit_price_label'); ?></th>
                            <th class="col-amount"><?php echo app('translator')->getFromJson('admin/entries.account_amount_label'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                    <input type="hidden" value="0" name="id" id="id">  
                    <?php if(isset($sale['details']) && count($sale['details']) > 0): ?>
                      <?php $__currentLoopData = $sale['details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="tr">
                        <td class="col-chart" width="250" height="50">
                        <select name="title[]" id="title" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            <?php if(isset($products) && count($products) > 0): ?>
                              <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($product->id == $detail['title']): ?>
                                  <option value="<?php echo e($product->id); ?>" selected="selected"><?php echo e($product->name); ?></option>
                                <?php else: ?>
                                  <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          </select>
                          
                        </td>

                          <td class="col-desc" width="200">
                              <input type="text" value="<?php echo e($detail->description); ?>" name="line_desc[]" id="line_desc[]" class="form-control1" placeholder="Description"  />
                          </td>

                          <td class="col-desc" width="70">
                              <input type="text" value="<?php echo e($detail->qty); ?>" name="line_qty[]" id="line_qty[]" class="line_qty form-control1" value="1" placeholder="Qty" />
                          </td>

                          <td class="col-desc" width="100">
                              <input type="text" value="<?php echo e($detail->unit_price); ?>" name="line_unit_price[]" id="line_unit_price[]" class="line_price form-control1" placeholder="0.00"  /> 
                          </td>

                          <td class="col-amount">
                            <input type="text" value="<?php echo e($detail->amount); ?>" name="line_total[]" id="line_total[]" class="line_total form-control1" placeholder="0.00" readonly=""/>
                          </td>

                          <td class="col-action">
                              <a href="" class="remove-line"><span class="fa fa-trash"></span></a>
                          </td>

                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>                  
                      
                    <tr class="tr">
                          <td class="col-chart" width="250" height="50">
                          <select name="title[]" id="title" class="form-control1 chosen title">
                            <option value="0"> -- SELECT -- </option>
                            <?php if(isset($products) && count($products) > 0): ?>
                              <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($product->id == $detail['title']): ?>
                                  <option value="<?php echo e($product->id); ?>" selected="selected"><?php echo e($product->name); ?></option>
                                <?php else: ?>
                                  <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          </select>
                          
                        </td>

                          <td class="col-desc" width="200">
                              <input type="text" value="" name="line_desc[]" id="line_desc[]" class="form-control1" placeholder="Description"  />
                          </td>

                          <td class="col-desc" width="70">
                              <input type="text" name="line_qty[]" id="line_qty[]" class="line_qty form-control1" value="1" placeholder="Qty" />
                          </td>

                          <td class="col-desc" width="100">
                              <input type="text" value="" name="line_unit_price[]" id="line_unit_price[]" class="line_price form-control1" placeholder="0.00" /> 
                          </td>

                          

                          <td class="col-amount">
                            <input type="text" value="" name="line_total[]" id="line_total[]" class="line_total form-control1" placeholder="0.00" readonly="" />
                          </td>

                          <td class="col-action">
                              <a href="" class="remove-line"><span class="fa fa-trash"></span></a>
                          </td>

                        </tr>
                                      

                            
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><a href="javascript:void(0)" class="button add-line"><?php echo app('translator')->getFromJson('admin/entries.add_new_line_button_txt'); ?></a></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right"><?php echo app('translator')->getFromJson('admin/entries.sub_total_txt'); ?></th>
                           
                            <th class="col-amount">
                                <input type="text" name="sub_total" class="sub-total form-control1" readonly="" placeholder="0.00" value="<?php echo e($sale['sub_total']); ?>" />
                            </th>
                        </tr>

                        <tr>
                            <th></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right"><?php echo app('translator')->getFromJson('admin/entries.discount_txt'); ?></th>
                           
                            <th class="col-amount">
                                <input type="text" name="discount" class="discount form-control1" placeholder="0.00" value="<?php echo e($sale['discount']); ?>" />
                            </th>
                        </tr>

                        <tr>
                            <th></th>
                            <th class="align-right"></th>
                            <th class="align-right"></th>
                            <th class="align-right" align="right"><?php echo app('translator')->getFromJson('admin/entries.total_txt'); ?></th>
                           
                            <th class="col-amount">
                                <input type="text" name="total" class="price-total form-control1" readonly="" placeholder="0.00" value="<?php echo e($sale['total']); ?>" />
                            </th>
                        </tr>
                       

                        <tr>
                          <td height="40" colspan="4"></td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form-group">
                <textarea name="note" id="note" cols="30" rows="10" class="form-control2" placeholder="<?php echo app('translator')->getFromJson('admin/entries.reference_textarea_label'); ?>"><?php echo e($sale['note']); ?></textarea>
                </div>

                


              </div>
              
            </div>


            

            

            <div class="col-sm-10 col-sm-offset-2">
              <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12">
              <label for="" class="input_label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <button type="submit" name="submitButton" class="btn btn-primary btn-block new-btn"><?php echo app('translator')->getFromJson('admin/users.submit_button'); ?></button>
            </div>
            </div>
    
            </div>


        </form>


      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
$(".chosen").select2();
</script>

<script type="text/javascript">
  $(document).on('change', '.title', function (){

    var self = $(this);
    var tr = self.closest('.tr')
    var id = self.val();
    var base_url = site.base_url;

    

    $.ajax({
      url: base_url+'/accounting/items/ajax-price',
      type: 'POST',
      dataType: 'json',
      data: {'_token': '<?php echo e(csrf_token()); ?>', id: id},
      success: function(data, textStatus, xhr){

        if(data.error == 0){

          var qty = tr.find('.line_qty').val();
          tr.find('.line_price').val(data.row.price);

          var final_price = parseFloat(data.row.price) * parseFloat(qty)
          tr.find('.line_total').val(final_price);


          var tables = $('.payment-voucher-table');

          var totals = 0;

          tables.find('tbody > tr').each(function(index, el) {
            var rows    = $(el);
            var total  = ( rows.find('input.line_total').val() ) || '0';

            totals +=  parseFloat( total );

          });

          $('.sub-total').val(totals);
          $('.price-total').val(totals);

        }
        
      } 
    });
    


  });
</script>

<script>


$(document).ready(function() {

    $('form[data-toggle="validator"]').bootstrapValidator()

  });
</script>

  <script type="text/javascript">
   
    $('.datepicker').dateDropper();
  </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>