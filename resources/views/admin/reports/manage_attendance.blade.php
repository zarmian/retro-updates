@extends('layouts.app')
@section('head')


<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="{{ asset('assets/datetimepicker/jquery-ui-timepicker-addon.css') }}" />


<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/dropdown/css/normalize.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/dropdown/css/cs-select.css') }}" type="text/css" rel="stylesheet">


<style type="text/css">
.datetimepicker{
  border: 0px solid transparent !important;
  background: transparent !important;
}

input:focus, input:active{
  border: 0px solid transparent !important;
}

input.active{
  border: 0px solid transparent !important;
}
</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/reports.attendance_heading_txt'):  </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/reports.attendance_heading_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

    <form action="{{ url('/reports/manage-attendance') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        

      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 no-padding">
            <h4>@lang('admin/common.filter_by_txt')</h4>
          </div>
          
           <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <input type="text" name="date" id="date" class="filter-date-input datepicker">
           </div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="department" id="department" class="chosen form-control1">
              <option value="">@lang('admin/employees.select_department')</option>
              @if(isset($departments) && count($departments) > 0)
                @foreach($departments as $department)
                  @if($department->id == app('request')->input('department'))
                    <option value="{{ $department->id }}" selected="selected">{{ $department->title }}</option>
                  @else
                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                  @endif
                @endforeach
              @endif
              
            </select>
            <!-- select option -->
          </div>


          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="employees" id="employees" class="chosen form-control1">
              <option value="">@lang('admin/employees.select_employees')</option>
            </select>
            <!-- select option -->
          </div>


        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" id="filter-submit-btn" value="@lang('admin/common.find_btn_txt')" />
          </div>
        </div>

      </div>

       
        </form>
    </div>
  </div>
</section>

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif

      @if(isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          </div>
        @endif

      <div id="products" class="row list-group">
        <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee_id }}" />
        <input type="hidden" name="shift_time" id="shift_time" value="{{ $shift_time }}" />
        @if(isset($attendances) && count($attendances) > 0)
        <?php $sr=0;?>
        @foreach($attendances as $attendance)
        <?php $sr++; ?>
          
          <div class="@if(($attendance['closed'] == false) && ($attendance['offical']['is_offical'] == false && $attendance['eLeave']['is_leave'] == false)) col-lg-11 col-sm-10 col-xs-12 @else col-lg-12 col-sm-12 col-xs-12 @endif @if($attendance['closed'] == true) bg-warning @elseif(isset($attendance['offical']) && $attendance['offical']['is_offical'] == true) bg-info @elseif(isset($attendance['eLeave']) && $attendance['eLeave']['is_leave'] == true) bg-success @elseif($attendance['absent'] == true) bg-danger @endif payment-block" id="p_{{ $attendance['n'] }}">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li style="width: 50px;"><b> {{ $sr }} </b></li>
                  <li style="width: 250px;">@lang('admin/entries.date_label'): <b>{{ $attendance['date'] }}</b></li>
                  

                  @if($attendance['closed'] == 1 && $attendance['closed'] <> "")
                    <li style="width: 250px;"> <b>@lang('admin/reports.day_closed_txt')</b></li>

                  @elseif(isset($attendance['offical']) && count($attendance['offical']) > 0 && $attendance['offical']['is_offical'] == true)

                    <li style="width: 250px;"> <b>{{ $attendance['offical']['offical_type'] }}</b></li>

                  @elseif(isset($attendance['eLeave']) && count($attendance['eLeave']) > 0 && $attendance['eLeave']['is_leave'] == true)
                    <li style="width: 250px;"> <b>{{ $attendance['eLeave']['offical_type'] }}</b></li>
                  @else
                    <li style="width: 250px;"> @lang('admin/entries.start_date_txt'):  <input type="text" name="in_time" class="datetimepicker indatetimepicker" id="in_time_{{ $sr }}" value="{{ $attendance['in_time'] }}" /> </li>
                    <li style="width: 250px;"> @lang('admin/entries.end_date_txt'):  <input type="text" name="out_time" class="datetimepicker outdatetimepicker" id="out_time_{{ $sr }}" value="{{ $attendance['out_time'] }}"></li>
                    <li id="s">@lang('admin/entries.short_time_txt'): <b>{{ $attendance['short_time'] }}</b> </li>
                  @endif

                  

                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          @if((isset($attendance['closed']) && $attendance['closed'] == false) && (isset($attendance['offical']) && $attendance['offical']['is_offical'] == false) && (isset($attendance['eLeave']) && $attendance['eLeave']['is_leave'] == false))
          <div class="col-lg-1 col-sm-2 col-xs-12 no-padding">
           
                @if($attendance['absent'] == true)
                  <a href="javascript:void(0)" data-id="{{ $attendance['id'] }}" data-url="{{ url('/reports/ajax/eAdded') }}" data-no="{{ $sr }}" class="payment-btn-list btn-block btn-gray-bg save"><i class="fa fa-save" aria-hidden="true"></i></a>
                @else
                  <a href="javascript:void(0)" data-id="{{ $attendance['id'] }}" data-url="{{ url('/reports/ajax/eUpdate') }}" data-no="{{ $sr }}" class="payment-btn-list btn-block btn-blue-bg save"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @endif
                
          </div>
          @endif
          
        
          @endforeach

          @endif
        
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">

function getEmployeeByDepartment(department_id, employee_id) {


    if (department_id != "" && employee_id != "") {
      
        $('#employees').html("");
        
        var url = '{{ url('/reports/ajax/eSuggestion') }}';
        var div_data = '<option value="">@lang('admin/employees.select_employees')</option>';
      
        $.ajax({
            type: "POST",
            url: url,
            data: {'department_id': department_id, '_token': '{{ csrf_token() }}'},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    var sel = "";
                    if (employee_id == obj.id) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.first_name + " " + obj.last_name + "</option>";
                });
                $('#employees').append(div_data);
            }
        });
    }
}

$(document).on('change', '#department', function(){

  var $this = $(this);
  var department_id = $this.val();
  $('#employees').attr('disabled', true);

  url = '{{ url('/reports/ajax/eSuggestion') }}';

  $.ajax({
    url: url,
    type: 'POST',
    dataType: 'json',
    data: {department_id: department_id, '_token': '{{ csrf_token() }}'},
  })
  .done(function($data) {
    
    var options = '<option value="">@lang('admin/employees.select_employees')</option>';
    $.each($data, function(k, v) {
      options += '<option value="'+v.id+'">'+v.first_name+' '+v.last_name+'</option>';
    });
    
    $('#employees').html(options);
    $('#employees').attr('disabled', false);
  });


});

$(document).ready(function() {
  var department_id = $('#department').val();
  var employee_id = '{{ $employee_id }}';
  getEmployeeByDepartment(department_id, employee_id);  
});


  $(document).on('click', '.save', function(){

    var $btn = $(this);
    var url = $btn.attr('data-url');
    var id = $btn.attr('data-id');
    var data_no = $btn.attr('data-no');
    var employee_id = $("#employee_id").val();

    var in_time = $('input#in_time_'+data_no).val();
    var out_time = $('input#out_time_'+data_no).val();

    $btn.attr('data-temp', $btn.html()).html('Wait...').css({
      'color': 'white',
      'text-decoration': 'none'
    });;

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {id: id, '_token': '{{ csrf_token() }}', in_time: in_time, out_time: out_time, employee_id: employee_id},
    })
    .done(function($data) {

      if($.isEmptyObject($data.error)){

        $btn.addClass('btn-blue-bg').removeClass('btn-gray-bg').html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>');
        $btn.attr('data-url', '{{ url('/reports/ajax/eUpdate') }}');

        $('#p_'+data_no).removeClass('bg-danger').css({'background-color' : 'white'});

        $btn.attr('data-id', $data.id);
        

        //$btn.attr('disabled', false);
        swal(
          'Done',
          '',
          'success'
        )

      }else{
        swal(
          'Oops...',
          $data.error,
          'error'
        )
      }

      $btn.html($btn.data('temp').html());
      
    }).fail(function($data) {
      
    });

  });

  

</script>

<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/datetimepicker/jquery-ui-timepicker-addon.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/datetimepicker/i18n/jquery-ui-timepicker-addon-i18n.min.js') }}"></script>

<script type="text/javascript">

$('.indatetimepicker').datetimepicker({
  timeInput: true,
  timeFormat: "hh:mm tt",
  onClose: function(dateText, inst) {

    var in_time = dateText;
    var out_time = $('#'+inst.id).closest('ul').find('li').find('input.outdatetimepicker').val();
    
    var $input = inst.id;
    getShortTime(in_time, out_time, $input);

  }
});


$('.outdatetimepicker').datetimepicker({
  timeInput: true,
  timeFormat: "hh:mm tt",
  onClose: function(dateText, inst) {

    var out_time = dateText;
    var in_time = $('#'+inst.id).closest('ul').find('li').find('input.indatetimepicker').val();

    var $input = inst.id;
    getShortTime(in_time, out_time, $input);
  }
});



  function getShortTime(in_time, out_time, near='')
  {

      var shift_time = $('#shift_time').val();
      var startdate = new Date(in_time);
      var enddate = new Date(out_time);

      var a = shift_time.split(':');
      var shift_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

      var diff = enddate - startdate;

      var diffSeconds = diff/1000;

      var sss = shift_seconds - diffSeconds;

      var HH = Math.floor(sss/3600);
      var MM = Math.floor(sss%3600)/60;

      if (HH > 0 || MM > 0) {
        var formatted = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM);
        formatted = formatted + ":00";
      }else{
        var formatted = '00:00:00';
      }

      $('#'+near).closest('ul').find('li#s b').html(formatted);
      console.log(formatted);
  }
</script>


<script type="text/javascript">
    $('.datepicker').dateDropper();
    $(".chosen").select2();
</script>
@endsection