<div class="modal-dialog" role="document">
	<div class="modal-content">

		<div class="modal-body">
			
			<div>
				<h1 class="currenttime">
					<b>@lang('employees/common.current_time_txt') </b> <br>
					<span>{{ $currenttime }}</span><br>
				</h1>
			
			@if($modal == 'out')
				<h4 class="text-center"><span> {{ $time }} </span></h4>
				<div class="form-group">
					<label for="" class="text-left">@lang('employees/common.today_detail_txt')</label>
					<textarea name="detail" id="detail" cols="30" rows="30" class="form-control2"></textarea>
				</div>
			@endif

			@if($modal == 'in')
				<button id="markAttendance" class="btn btn-danger btn-block" data-url="{{ url('/attendance/timein') }}"> @lang('employees/common.time_in_txt')</button>
			@else
				<button id="markAttendance" class="btn btn-primary btn-block" data-url="{{ url('/attendance/timeout') }}">@lang('employees/common.time_out_txt')</button>
			@endif
			
			</div>

			<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
		</div>

	</div>
</div>
