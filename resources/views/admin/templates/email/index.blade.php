@extends('layouts.app')
@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('admin/email.email_templates_heading')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"><a href="{{ url('/') }}">@lang('admin/dashboard.dashboard-heading')</a>  / 
      <a href="#" class="active">@lang('admin/email.email_templates_heading')</a></div>
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
        <div class="col-lg-6 col-md-2 col-sm-3 col-xs-12 col-sm-offset-9 col-md-offset-9 col-lg-offset-6">
          <select class="select-page" id="per_page">
            <option value="12" @if($per_page == 12) selected="selected" @endif>@lang('admin/common.per_page_12')</option>
              <option value="24" @if($per_page == 24) selected="selected" @endif>@lang('admin/common.per_page_24')</option>
              <option value="50" @if($per_page == 50) selected="selected" @endif>@lang('admin/common.per_page_50')</option>
              <option value="100" @if($per_page == 100) selected="selected" @endif>@lang('admin/common.per_page_100')</option>
          </select>
        </div>
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
        @if(isset($templates) && count($templates) > 0)
        @foreach($templates as $template)


          <div class="col-lg-11 col-sm-10 col-xs-10 template-block">
            
              <div class="col-sm-12 no-padding">
                <ul class="clearfix">
                  
                  <li>@lang('admin/email.title_label'): <b> {{ $template['title'] }} </b></li>
                  <li style="width: 310px;">@lang('admin/email.subject_label'): <b> {{ $template['subject'] }} </b></li>
                  

                  <li>
                    @lang('admin/entries.invoice_paid_status'): 
                    @if($template['status'] == 1)
                      <span class="increase-label label label-success">@lang('admin/email.active_label')</span>
                    @else
                      <span class="increase-label label label-danger">@lang('admin/email.inactive_label')</span>
                    @endif
                  </li>

                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="col-lg-1 col-sm-2 col-xs-2 no-padding">
           
             
              <div class="col-sm-6 no-padding"><a href="{{ url('/email/templates/edit', $template['id']) }}" class="payment-btn-list btn-block btn-blue-bg"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
            
          </div>
    
        @endforeach
          <div class="col-xs-12">
           {!! $templates->appends(\Input::except('page'))->render() !!}
          </div>
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