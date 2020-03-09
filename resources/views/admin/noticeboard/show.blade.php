  <div class="modal-content clearfix" >

  <div class="modal-container">
    

    <div class="col-sm-11 col-xs-11 modal-body form-container clearfix">

    <div class="col-sm-11">
      <div class="alert alert-danger print-error-msg" style="display:none;">
        <ul></ul>
    </div>
    </div>

      <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <h4>@lang('admin/common.noticeboard_heading')  </h4>
        <p></p>
      </div>
    

      <div class="col-sm-5 form-group">
        <label for="description">@lang('admin/common.date_txt')</label>
        {!! $noticeboard['date'] !!}
      </div>

      <div class="col-sm-7 form-group">
        <label for="description">@lang('admin/common.title_label')</label>
        {!! $noticeboard['title'] !!}
      </div>
     


      <div class="col-sm-12 form-group">
        <label for="description">@lang('admin/common.description_label')</label>
        {!! $noticeboard['description'] !!}
      </div>

    

    </div>


    <div class="col-sm-1 col-xs-1 no-padding-right pull-right">
    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    



  </div>


    
  </div>