@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/dropdown/css/normalize.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/dropdown/css/cs-select.css') }}" type="text/css" rel="stylesheet">
<style type="text/css">


.select2-dropdown{
  top: 15px;
}
</style>

@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/reports.attendance_heading_txt'):  {{ $date }}</h1>
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

    <form action="{{ url('/reports/daily-attendance') }}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        

      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4>@lang('admin/common.find_attendance_txt')</h4>
          </div>
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <input type="text" name="date" id="date" class="filter-date-input datepicker" data-large-mode="true" placeholder="" data-translate-mode="false" data-auto-lang="true" data-default-date="@if(isset($date) && $date <> ""){{date('m-d-Y', strtotime($date) )}}@else{{date('m-d-Y', time())}}@endif" />
           </div>

          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="department" id="department" class="chosen form-control1">
              <option value="">@lang('admin/employees.select_department')</option>
              <option value="0"> @lang('admin/common.select_all_txt') </option>
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


        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="@lang('admin/common.find_btn_txt')" />
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
        
        @if(isset($attendances) && count($attendances) > 0)
        <div class="row">

        @foreach($attendances as $attendance)
            

            @if(isset($attendance['list']) && count($attendance['list']) > 0)
              @foreach($attendance['list'] as $row)

                <div class="col-lg-12 col-sm-12 col-xs-12 payment-block">
                  <div class="col-sm-12 no-padding">
                    
                    <ul class="clearfix">
                      <li style="width: 230px;">@lang('admin/shift.name_txt'): <b> {{ $attendance['employee_name'] }} </b></li>
                      <li style="width: 230px;">@lang('admin/shift.start_time'): <b> {{ $row['in_time'] }} </b></li>
                      <li style="width: 230px;">@lang('admin/shift.end_time'): <b> {{ $row['out_time'] }} </b></li>
                      <li style="width: 200px;">@lang('admin/shift.description_label'): <b> <a href="#" data-toggle="modal" data-detail="{!! $row['detail'] !!}" data-target="#detailModal">{{ Str::limit($row['detail'], 10) }} </a> </b></li>
                      <li style="width: 200px;">@lang('admin/shift.short_time_txt'): <b> {{ $row['short_time'] }} </b></li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
                
              @endforeach 
            @else
              <div class="col-lg-12 col-sm-12 col-xs-12 payment-block" style="background: pink">
                  <div class="col-sm-12 no-padding">
                    
                    <ul class="clearfix">
                      <li style="width: 230px;">@lang('admin/shift.name_txt'): <b> {{ $attendance['employee_name'] }} </b></li>
                      <li style="width: 200px;">@lang('admin/shift.description_label'): <b> {{ $attendance['detail'] }} </b></li> <b> </b></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
              </div>
            @endif
            

          @endforeach
        </div>

        @endif
        
      </div>
      
    </div>
  </div>
</div>
<!-- Modal -->
<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">@lang('admin/shift.today_activity_txt')</h4>
      </div>
      <div class="modal-body">
        <p>@lang('admin/shift.wait_txt')</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')


<script type="text/javascript">

$('#detailModal').on('show.bs.modal', function (event) {

  var button = $(event.relatedTarget); // Button that triggered the modal
  var detail = button.data('detail'); // Extract info from data-* attributes
  $('.modal-body').html(detail);
  
});

$('.datepicker').dateDropper();
$(".chosen").select2();
</script>
@endsection