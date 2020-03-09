@extends('layouts.app')

@section('breadcrumb')
<section class="breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>@lang('employees/common.request_leave_txt')</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
      <a href="{{ url('/') }}">@lang('employees/common.dashboard_heading')</a>  / 
      <a href="#" class="active">@lang('employees/common.request_leave_txt')</a>
      </div>
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

        
        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-12 plus-margin">
          <a href="{{ url('/leave-request/create') }}" class="plus">+</a>
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
      <div class="alert alert-success">
        {{ Session::get('msg') }}
      </div>
      @endif
      
      <div id="products" class="row">
        @if(isset($leaves) && count($leaves) > 0)
        @foreach($leaves as $leave)
        

        <div class="item col-xs-12 col-lg-3 col-sm-3">
          <div class="thumbnail">
            <div class="row">
              
                <ul class="list-detail">
                  <li>
                    <div class="caption">
                      <ul>
                        <li class="name">{!! $leave['title'] !!} </li>
                        <li class="timing"><b>@lang('admin/leaves.date_text')</b> {{ array_first($leave['leave_date']) }} <b>@lang('admin/leaves.to_text')</b> {{ array_last($leave['leave_date']) }}</li>

                          @if($leave['status'] == 1)
                            <li><span class="label label-success">@lang('employees/common.approved_txt')</span></li>
                          @elseif($leave['status'] == 2)
                            <li> <span class="label label-danger">@lang('employees/common.rejected_approval_txt')</span></li>
                          @else
                            <li> <span class="label label-warning">@lang('employees/common.pending_approval_txt')</span></li>
                          @endif
                        
                      </ul>
                    </div>
                  </li>
                </ul>
                <ul class="inner-btn clearfix">
                  <li><a href="{{ url('/leave-request/edit', $leave['id']) }}" data-toggle="tooltip" title="@lang('employees/common.edit_tooltip')"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></li>
                 @if($leave['status'] == 0)
                  <li><a href="{{ url('/leave-request/remove', $leave['id']) }}" data-toggle="tooltip" title="@lang('employees/common.delete_tooltip')" class="is_delete"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>
                   @endif
                   <li><a href="javascript:void(0);" data-toggle="modal" data-target="#leaveModal" data-id="{{ $leave['id'] }}" rel="tooltip" title="@lang('employees/common.view_detail_txt')"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a></li>
                </ul>
           
            </div>
          </div>
        </div>
        @endforeach
        <div class="col-xs-12">{!! $pages !!}</div>
        @else
        <div class="alert alert-warning">@lang('admin/messages.not_found')</div>
        @endif
        
        
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content clearfix" id="leaveRequestView">
    </div>
  </div>
</div>



@endsection

@section('scripts')

<script type="text/javascript">
  $('#leaveModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); 
  var id = button.data('id');
  $('#leaveRequestView').load(site.base_url + '/leave-request/view/' + id);

});
</script>
  
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