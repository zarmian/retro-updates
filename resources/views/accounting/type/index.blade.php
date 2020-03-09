@extends('layouts.app')
@section('head')
<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/dropdown/css/normalize.css') }}" type="text/css" rel="stylesheet">
<link href="{{ asset('assets/dropdown/css/cs-select.css') }}" type="text/css" rel="stylesheet">

@endsection
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/accounting.chart_type_heading') </h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
        <a href="#" class="active">@lang('admin/accounting.chart_type_heading')</a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')



<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
   
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div class="ac_chart">
          
          <div class="col-sm-11"><h2>@lang('admin/accounting.chart_type_heading')</h2></div>
          <div class="col-sm-1 pull-right text-right">
            <a href="{{ url('accounting/chart-type/add') }}" class="btn-add-chart"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
          
          <table class="table table-striped">
            
              <tr>
                <th width="50"></th>
                <th>Name</th>
                <th></th>
                <th></th>
                <th class="text-right">Action</th>
              </tr>
              @if(isset($types) && count($types) > 0)
                @foreach($types as $type)
                <tr>
                  <td></td>
                  <td colspan="3">{{ $type['name'] }}</td>
                  <td class="text-right"><a href="{{ url('accounting/chart-type/edit', $type['type_id']) }}" class="edit_link">Edit</a></td>
                </tr>
                @if(isset($type['children']) && count($type['children']) > 0)
                  @foreach($type['children'] as $children)
                <tr>
                  <td></td>
                  <td colspan="3">-- {{ $children['name'] }}</td>
                  <td class="text-right"><a href="{{ url('accounting/chart-type/edit', $children['type_id']) }}" class="edit_link">Edit</a></td>
                </tr>
                  @endforeach
                @endif

                @endforeach
              @endif

          </table>

        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection