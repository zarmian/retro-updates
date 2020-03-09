<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>
	<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
	<link href="{{ asset('assets/bootstrap/css/bootstrap.css?v=1.23')}}" type="text/css" rel="stylesheet">
	<link href="{{ asset('assets/css/stylesheet-main.css?v=1.3')}}" type="text/css" rel="stylesheet">
</head>
<body>
	
	<div class="container">
		<div class="row">
			<div class="col-lg-6" style="width: 50%; float: left;">
				<div class="company-detail text-left">
					<h3>{{ $company }}</h3>
					<p><b>@lang('admin/common.phone_label')#:</b> {{ $phone }} <br>
					<b>@lang('admin/common.email_label'):</b> {{ $email }}
					<br>
					<b>@lang('admin/common.address_label'):</b> {!! $address !!}</p>
				</div>
			</div>

			<div class="col-lg-6" style="width: 50%; float: right;">
				<div class="company-detail text-right">
					<h3>@lang('admin/common.employees_heading'): {{$salary['name']}}</h3>
					<p><b>@lang('admin/common.phone_label')#:</b> {{$salary['phone']}} <br>
					<b>@lang('admin/common.email_label'):</b> {{$salary['email']}}
					<br>
					<b>@lang('admin/common.address_label'):</b> {{$salary['present_address']}}</p>
				</div>
			</div>


			<div class="col-lg-12">
				<table width="100%" class="table">
					<thead>
						<tr>
							<th align="center" class="text-center" style="text-align: center; border:0px dotted #000;"><h3 style="margin: 0px; padding: 0px;"><b>@lang('admin/common.payslip_txt')</b></h3></th>
						</tr>
					</thead>
				</table>

				<table width="100%" class="table">
					
					<tr style="border-top:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<th>@lang('admin/common.earning_txt')</th>
						<th style="border-left:2px solid #000; text-align: right" width="120">@lang('admin/common.amount_txt')</th>
						<th style="border-left:2px solid #000;">@lang('admin/common.deduction')</th>
						<th style="border-left:2px solid #000; text-align: right" width="120">@lang('admin/common.amount_txt')</th>
					</tr>

					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;">@lang('admin/employees.basic_salary_label')</td>
						<td style="border-left:2px solid #000;">{{$salary['basic']}} {{$currency}}</td>
						<td style="border-left:2px solid #000;">@lang('admin/employees.short_time_txt')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['deduction']}} {{$currency}}</td>
					</tr>
					
					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;">@lang('admin/common.generated_salary')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['generate_pay']}} {{$currency}}</td>
						<td style="border-left:2px solid #000;">@lang('admin/common.leaves_ded_txt')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['leave_deduction']}} {{$currency}}</td>
					</tr>


					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;">@lang('admin/common.overtime_txt')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['overtime']}} {{$currency}}</td>
						<td style="border-left:2px solid #000;">@lang('admin/common.fixed_loan_return_txt')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['fix_advance']}} {{$currency}}</td>
					</tr>

					<tr style="border-top:2px dotted #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000;"></td>
						<td style="border-left:2px solid #000; text-align: right"></td>
						<td style="border-left:2px solid #000;">@lang('admin/common.temp_loan_return_txt')</td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['temp_advance']}} {{$currency}}</td>
					</tr>

					<tr style="border-top:2px solid #000; border-bottom:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-left:2px solid #000; text-align: right;"><b>@lang('admin/common.total_txt')</b></td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['total_earning']}} {{$currency}}</td>
						<td style="border-left:2px solid #000; text-align: right;"><b>@lang('admin/common.all_over_total_txt')</b></td>
						<td style="border-left:2px solid #000; text-align: right">{{$salary['total_deduction']}} {{$currency}}</td>
					</tr>

					<tr style="border-top:2px solid #000; border-bottom:2px solid #000; border-left:2px solid #000; border-right:2px solid #000;">
						<td style="border-right:2px solid #000; text-align: right; padding: 0px;"></td>
						<td colspan="2" style="padding: 0px;">
							<table class="table" style="background: none; padding: 0px; margin: 0px;" cellpadding="0" cellspacing="0">
								<tr>
									<td style="text-align: right;  padding-top: 8px"><b>@lang('admin/common.net_amount_txt')</b></td>
								</tr>
							</table>
						</td>

						<td style="border-left:2px solid #000; text-align: right;" height="30">{{ $salary['total_net_amount'] }} {{$currency}}</td>
						
					</tr>

				</table>
			</div>


			<div class="col-lg-1 " style="width: 50%; float: right;">
				<div class="company-detail text-right">
					<div>@lang('admin/common.receiver_sign_txt'): ....................................................................................</div>
				</div>
			</div>

			


		</div>
	</div>

	<script type="text/javascript">
		@if(isset($type) && $type==2)
			window.print();
		@endif
	</script>

	<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
</body>
</html>