@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>


@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/common.leaves_request_txt') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/common.leaves_request_txt')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

    <form action="{{ url('/leaves') }}" method="post">
        
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        
      <div class="col-lg-12">
        
        <div class="col-lg-10 no-padding">
          
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
            <h4>@lang('admin/common.find_leaves_txt')</h4>
          </div>
          
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 leave-request filter-dropdown">
            <select name="employee" id="employee" class="chosen form-control1">
              <option value="">@lang('admin/common.select_employees')</option>
              @if(isset($employees) && count($employees) > 0)
                @foreach($employees as $employee)
                @if($employee->role <> 1){
                  @if($employee->id == app('request')->input('employee'))
                  

                    <option value="{{ $employee->id }}" selected="selected">{{ $employee->fullName() }}</option>
                 
                  @else
                    <option value="{{ $employee->id }}">{{ $employee->fullName() }}</option>
                  @endif
                  @endif
                @endforeach
              @endif
              
            </select>
           </div>

          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 filter-dropdown">
            <!-- select option -->
            <select name="status" id="status" class="chosen form-control1">
              <option value="">@lang('admin/common.select_status_txt')</option>
              
              <option value="1" @if(app('request')->input('status') == 1) selected="selected" @endif>@lang('admin/common.select_approved_txt') </option>
              <option value="2" @if(app('request')->input('status') == 2) selected="selected" @endif>@lang('admin/common.select_rejected_txt') </option>
             
            </select>
            <!-- select option -->
      </div>


        </div>

        <div class="col-lg-2 no-padding">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="submit" class="filter-submit-btn" value="Find Report Now" />
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
        
        @if(isset($leaves) && count($leaves) > 0)
        <div class="row">

        @foreach($leaves as $leave)

        <div class="col-lg-11 col-sm-11 col-xs-11 payment-block">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li style="width: 25%;">@lang('admin/leaves.title_txt'): <b> {{ $leave['title'] }} </b></li>
                  <li style="width: 50%;">@lang('admin/leaves.description_txt'): <b>{{ $leave['description'] }}</b></li>
                  
                    
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
           
              <div class="col-sm-12 no-padding"><a href="{{ url('/leave/show', $leave['id']) }}" class="payment-btn-list btn-block btn-gray-bg"><i class="fa fa-eye" aria-hidden="true"></i></a>
              </div>
             
            
          </div>

          
          @endforeach
        </div>
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
    $(".chosen").select2();
  </script>

@endsection