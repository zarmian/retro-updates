@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/timepicki.css') }}"/>
@endsection

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('employees/common.notification_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('employees/common.dashboard_heading')</a>  /  
        <a href="{{ url('employees/notifications') }}">@lang('employees/common.notification_txt')</a>  /  
        <a href="#" class="active">@lang('employees/common.notification_view_txt')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')

<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">

      <div class="col-sm-6 col-lg-6 col-lg-offset-3">
        <div class="panel-group">
          <div class="panel panel-default">
            <div class="panel-body"><h4>@lang('employees/common.notification_txt')</h4></div>
          </div>
          <div class="panel panel-default">
            <div class="panel-body">
                <b>@lang('employees/common.title_txt'): </b>
                <p>{{ $notification['title'] }}</p>

                <b>@lang('employees/common.date_txt') </b>
                <p>{{ $notification['datetime'] }}</p>

                <b>@lang('employees/common.notification_des_txt'):</b>
                <p>{!! $notification['description'] !!}</p>
            </div>
          </div>
        </div>
      </div>


      
    </div>
  </div>
</div>

@endsection