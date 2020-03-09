@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>


@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/employees.manage')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  /
      <a href="#" class="active">@lang('admin/employees.manage')</a></div>
    </div>
  </div>
</section>
@endsection
@section('search')
<section class="find-search">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
        
        <div class="col-lg-9 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4>@lang('admin/employees.find_employee_txt')</h4>
          </div>
          
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <!-- select option -->
            <input type="text" name="by_name" class="filter-date-input" placeholder="@lang('admin/common.filter_by_name')" />
            <!-- select option -->
          </div>

          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 filter-dropdown">
          <!-- select option -->
          <select class="by_department chosen form-control1">
            <option value="" disabled>@lang('admin/employees.select_department')</option>
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

        <div class="col-lg-3 no-padding clearfix">


        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 no-padding-left "></div>
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12 no-padding-left clearfix">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>

        </div>

        
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding clearfix plus-margin"><button class="plus" onclick="window.location = '{{ url('employees/create') }}'">+</button></div>

          
        </div>

        <div class="clearfix"></div>

      </div>


    </div>
  </div>
</section>
@endsection
@section('content')
<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      
      @if(Session::has('msg'))
      <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
      <div id="products" class="row list-group">
        @if(isset($employees) && count($employees) > 0)
        @foreach($employees as $employee)
        <div class="item col-xs-12 col-lg-4 "">
          <div class="thumbnail @if($employee['status'] == 1) active-status @else inactive-status @endif">
            <div class="row">
              <div class="item">
                <ul>
                  <li class="emp-left">
                    @if(!empty($employee['avatar']) && $employee['avatar'] <> NULL)
                    <img class="group list-group-image" src="{{ url('storage/app/employees/avatars/'.$employee['avatar'])}}" alt="" width="80"  height="80"><br>
                    @else
                    <img class="group list-group-image" src="{{ url('assets/images/img-person.jpg')}}" alt="" width="80"  height="80"><br>
                    @endif
                    <a href="{{ url('employees/edit/'.$employee['id']) }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="{{ url('employees/remove/'.$employee['id']) }}" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                    <a href="{{ url('employees/view/'.$employee['id']) }}"><span class="fa fa-list" aria-hidden="true"></span></a>
                  </li>
                  <li class="emp-right">
                    <div class="caption">
                      <ul>
                        <li class="name">{{ $employee['name'] }} {!! $employee['present_status'] !!}
                        <div class="dest">@if(isset($employee['designation']) && $employee['designation'] <> "") {{$employee['designation']}}  @endif </div>
                      </li>
                      <li class="mobile">@lang('admin/employees.email') {{ $employee['email'] }}</li>
                      <li class="distnation">@lang('admin/employees.dept')  @if(isset($employee['department']) && $employee['department'] <> "") {{ $employee['department'] }}  @endif</li>
                      <li class="sallry">@lang('admin/employees.adv') {{ $tlt_loan[$employee['id']]['tlt_balance'] }}/- &nbsp; @lang('admin/employees.sal') {{ $employee['salary'] }}/-</li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      @endforeach
      <div class="col-xs-12">{{ $pages }}</div>
      @else
      <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
      @endif
      
      
    </div>
    
  </div>
</div>
</div>
@endsection
@section('scripts')
 
  <script type="text/javascript">

    $(function(){
      // bind change event to select
      $('#per_page').on('change', function () {
      var url = $(this).val(); // get selected value
      if (url) { // require a URL
        window.location = '?per_page='+url; // redirect
      }
      return false;
      });
    });

      $(document).on('change', '.by_department', function (){

        var x = $(this).val();
        var r = $('.by_role option:selected').attr('value');
        
        if(typeof r == "undefined"){
          r = '';
        }else{
         r = r;
         x = x;
        }

        window.location = '?department='+x+'&role='+r; // redirect
        return false;
      });

      $(document).on('change', '.by_role', function (){

        var x = $('.by_department option:selected').attr('value');
        var r = $(this).val();
        
        if(typeof x == "undefined"){
          x = '';
        }else{
         r = r;
         x = x;
        }

        window.location = '?department='+x+'&role='+r; // redirect
        return false;
      });


    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
</script>

<script type="text/javascript">
$(".chosen").select2();
</script>
@endsection