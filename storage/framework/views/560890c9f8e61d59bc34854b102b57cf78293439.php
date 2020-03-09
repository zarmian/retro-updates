<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo e($title); ?></title>
	<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
	<link href="<?php echo e(asset('assets/bootstrap/css/bootstrap.css?v=1.23')); ?>" type="text/css" rel="stylesheet">
	<link href="<?php echo e(asset('assets/css/stylesheet-main.css?v=1.3')); ?>" type="text/css" rel="stylesheet">
</head>
<body>
	
	<div class="container">
		<div class="row">
			<div class="col-lg-6" style="width: 50%; float: left;">
				<div class="company-detail text-left">
					<h3><?php echo e($company); ?></h3>
					<p><b><?php echo app('translator')->getFromJson('admin/common.phone_label'); ?>#:</b> <?php echo e($phone); ?> <br>
					<b><?php echo app('translator')->getFromJson('admin/common.email_label'); ?>:</b> <?php echo e($email); ?>

					<br>
					<b><?php echo app('translator')->getFromJson('admin/common.address_label'); ?>:</b> <?php echo $address; ?></p>
				</div>
			</div>

			<div class="col-lg-6" style="width: 50%; float: right;">
				<div class="company-detail text-right">
					<h3><?php echo app('translator')->getFromJson('admin/common.employees_heading'); ?>: <?php echo e($salary['name']); ?></h3>
					<p><b><?php echo app('translator')->getFromJson('admin/common.phone_label'); ?>#:</b> <?php echo e($salary['phone']); ?> <br>
					<b><?php echo app('translator')->getFromJson('admin/common.email_label'); ?>:</b> <?php echo e($salary['email']); ?>

					<br>
					<b><?php echo app('translator')->getFromJson('admin/common.address_label'); ?>:</b> <?php echo e($salary['present_address']); ?></p>
				</div>
			</div>


			<div class="col-lg-12">
				<table width="100%" class="table">
					<thead>
						<tr>
							<th align="center" class="text-center" style="text-align: center; border:0px dotted #000;"><h3 style="margin: 0px; padding: 0px;"><b><?php echo app('translator')->getFromJson('admin/common.payslip_txt'); ?></b></h3></th>
						</tr>
					</thead>
				</table>

				<table width="100%" class="table">
					
					<tr style="border-top:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<th><?php echo app('translator')->getFromJson('admin/common.earning_txt'); ?></th>
						<th style="border-left:2px solid #000; text-align: right" width="120"><?php echo app('translator')->getFromJson('admin/common.amount_txt'); ?></th>
						<th style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.deduction'); ?></th>
						<th style="border-left:2px solid #000; text-align: right" width="120"><?php echo app('translator')->getFromJson('admin/common.amount_txt'); ?></th>
					</tr>

					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/employees.basic_salary_label'); ?></td>
						<td style="border-left:2px solid #000;"><?php echo e($salary['basic']); ?> <?php echo e($currency); ?></td>
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/employees.short_time_txt'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['deduction']); ?> <?php echo e($currency); ?></td>
					</tr>
					
					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.generated_salary'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['generate_pay']); ?> <?php echo e($currency); ?></td>
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.leaves_ded_txt'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['leave_deduction']); ?> <?php echo e($currency); ?></td>
					</tr>


					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.overtime_txt'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['overtime']); ?> <?php echo e($currency); ?></td>
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.fixed_loan_return_txt'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['fix_advance']); ?> <?php echo e($currency); ?></td>
					</tr>

					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;"></td>
						<td style="border-left:2px solid #000; text-align: right"></td>
						<td style="border-left:2px solid #000;"><?php echo app('translator')->getFromJson('admin/common.temp_loan_return_txt'); ?></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['temp_advance']); ?> <?php echo e($currency); ?></td>
					</tr>

					<tr style="border-top:2px solid #000; border-bottom:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000; text-align: right;"><b><?php echo app('translator')->getFromJson('admin/common.total_txt'); ?></b></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['total_earning']); ?> <?php echo e($currency); ?></td>
						<td style="border-left:2px solid #000; text-align: right;"><b><?php echo app('translator')->getFromJson('admin/common.all_over_total_txt'); ?></b></td>
						<td style="border-left:2px solid #000; text-align: right"><?php echo e($salary['total_deduction']); ?> <?php echo e($currency); ?></td>
					</tr>

					<tr style="border-top:2px solid #000; border-bottom:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-right:2px solid #000; text-align: right; padding: 0px;"></td>
						<td colspan="2" style="padding: 0px;">
							<table class="table" style="background: none; padding: 0px; margin: 0px;" cellpadding="0" cellspacing="0">
								<tr>
									<td style="text-align: right;  padding-top: 8px"><b><?php echo app('translator')->getFromJson('admin/common.net_amount_txt'); ?></b></td>
								</tr>
							</table>
						</td>

						<td style="border-left:2px solid #000; text-align: right;" height="30"><?php echo e($salary['total_net_amount']); ?> <?php echo e($currency); ?></td>
						
					</tr>

				</table>
			</div>


			<div class="col-lg-1 " style="width: 50%; float: right;">
				<div class="company-detail text-right">
					<div><?php echo app('translator')->getFromJson('admin/common.receiver_sign_txt'); ?>: ....................................................................................</div>
				</div>
			</div>

			


		</div>
	</div>

	<script type="text/javascript">
		<?php if(isset($type) && $type==2): ?>
			window.print();
		<?php endif; ?>
	</script>

	<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
</body>
</html>