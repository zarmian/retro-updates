@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/designations.manage-heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('') }}">@lang('admin/dashboard.dashboard-heading')</a>  / <a href="#" class="active">@lang('admin/designations.manage-heading')</a></div>
    </div>
  </div>
</section>
@endsection

@section('content')

<section class="find-search">
  <div class="container">
    <div class="row">

    <div class="col-lg-12">
    
        <div class="col-lg-4 col-lg-offset-8">

        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-8 col-md-offset-9 col-lg-offset-3">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>

        </div>

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin"><button class="plus" onclick="window.location = '{{ url('/designations/create') }}'">+</button></div>
        </div>
      </div>


    </div>
  </div>
</section>
<div class="container mainwrapper margin-top">
  <div class="row">
    <div class="container">
      
      
      
      @if(Session::has('msg'))
        <div class="alert alert-success">{{ Session::get('msg') }}</div>
      @endif
      
      
      <div id="products" class="row list-group">
        @if(isset($designations) && count($designations) > 0)
        @foreach($designations as $designation)


        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail @if($designation->status == 1) active-status @else inactive-status @endif"  >
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name">{{ $designation->title }}</li>
                        <li class="detail">@lang('admin/departments.detail_label') {{ Str::limit($designation->description, 50)}}</li>
                      </ul>
                    </div>
                  </li>
                </ul>
                <ul class="inner-btn clearfix">
                  <li><a href="{{ url('/designations/edit', $designation->id) }}" data-toggle="tooltip" title="@lang('admin/designations.edit-title')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></li>
                  <li><a href="{{ url('/designations/remove', $designation->id) }}" data-toggle="tooltip" title="@lang('admin/designations.delete-title')" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                </ul>
           
            </div>
          </div>
        </div>
        @endforeach
        <div class="col-xs-12">{!! $designations->appends(\Input::except('page'))->render() !!}</div>

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