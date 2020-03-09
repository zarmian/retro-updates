@extends('layouts.employees.app')

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('employees/common.notification_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('employees') }}">@lang('employees/common.dashboard_heading')</a>  / 
      <a href="#" class="active">@lang('employees/common.notification_txt')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">


      
      <div class="well-sm">
        <div class="btn-"> <div>
          <select class="select-page" id="per_page">
           <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
            <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
            <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
            <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>
          
          
        </div> </div>
      </div>

      @if(Session::has('msg'))
      <div class="alert alert-success">
        {{ Session::get('msg') }}
      </div>
      @endif
      
      <div id="products" class="row list-group">
        @if(isset($notifications) && count($notifications) > 0)
        @foreach($notifications as $notification)
        

        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name"><a href="{{ url('employees/notification/show', $notification->id) }}">{{ $notification->title }}</a> </li>
                        <li class="timing"><b>@lang('admin/leaves.date_text')</b> {{ date('d F, Y', strtotime($notification->datetime)) }}</li>
                        <li class="timing"> <br> <b>@lang('employees/common.notification_des_txt')</b> <br> {{ $notification->description }}</li>
                      </ul>
                    </div>
                  </li>
                </ul>
                
           
            </div>
          </div>
        </div>
        @endforeach
          <div class="col-xs-12">{{ $notifications->appends(\Input::except('page'))->render() }}</div>
        @else
          <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif
        
        
      </div>
      
    </div>
  </div>
</div>


<script>
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

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
</script>
@endsection