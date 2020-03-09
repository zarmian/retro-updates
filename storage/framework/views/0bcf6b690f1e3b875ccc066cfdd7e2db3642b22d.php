<?php if(isset($loan) && count($loan) > 0): ?>
<div class="modal-content">
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id=""><?php echo e($loan->title); ?></h4>
      </div>
      <div class="modal-body">
        <div>
          <b>Loan Detail</b>
          <p><?php echo e($loan->detail); ?></p>
        </div>

        <div>
          <b>Amount</b>
          <p><?php echo e($loan->amount); ?></p>
        </div>

        <div>
          <legend>
            Approved Detail
          </legend>
          <p><?php echo e($loan->approve_detail); ?></p>
          
        </div>
        <?php if($loan->status == 1): ?>
          
          <div>
            <span class="label label-success loan-status"><?php echo app('translator')->getFromJson('employees/common.approved_txt'); ?></span>
          </div>
        <?php elseif($loan->status == 2): ?>
          <div>
            <span class="label label-danger loan-status"><?php echo app('translator')->getFromJson('employees/common.rejected_txt'); ?></span>
          </div>
        <?php else: ?>
          <div>
            <span class="label label-warning loan-status"><?php echo app('translator')->getFromJson('employees/common.pending_txt'); ?></span>
          </div>
        <?php endif; ?>

        

      </div>

    </div>
<?php endif; ?>