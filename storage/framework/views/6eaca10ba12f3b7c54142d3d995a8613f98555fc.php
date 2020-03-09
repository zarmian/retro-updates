<div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-body">
			
			<div>
				<h1 class="currenttime">
					<b><?php echo app('translator')->getFromJson('employees/common.current_time_txt'); ?> </b> <br>
					<span><?php echo e($currenttime); ?></span><br>
				</h1>
			
			<?php if($modal == 'out'): ?>
				<h4 class="text-center"><span> <?php echo e($time); ?> </span></h4>
				<div class="form-group">
					<label for="" class="text-left"><?php echo app('translator')->getFromJson('employees/common.today_detail_txt'); ?></label>
					<textarea name="detail" id="detail" cols="30" rows="30" class="form-control2"></textarea>
				</div>
			<?php endif; ?>

			<?php if($modal == 'in'): ?>
				<button id="markAttendance" class="btn btn-danger btn-block" data-url="<?php echo e(url('/attendance/timein')); ?>"> <?php echo app('translator')->getFromJson('employees/common.time_in_txt'); ?></button>
			<?php else: ?>
				<button id="markAttendance" class="btn btn-primary btn-block" data-url="<?php echo e(url('/attendance/timeout')); ?>"><?php echo app('translator')->getFromJson('employees/common.time_out_txt'); ?></button>
			<?php endif; ?>
			
			</div>

			<input type="hidden" id="csrf_token" value="<?php echo e(csrf_token()); ?>">
		</div>

	</div>
</div>
