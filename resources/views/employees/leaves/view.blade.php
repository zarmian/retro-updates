
{{-- <div class="modal-content"> --}}
  
  <div class="modal-container">
    
    
    <div class="col-sm-11 modal-body clearfix">

      <h4 class="modal-title">{{ $leave->title }}</h4>

      <div class="content-block">
        <div> 
          <b>Leave Detail</b>
          <p>{{ $leave->description }}</p>
        </div>

        <div>
          <legend>
            Approved Detail
          </legend>
          <p>{{ $leave->approved_description }}</p>
          
        </div>
        
          @if($leave->status == 1)
            <div>
              <span class="label label-success loan-status">@lang('employees/common.approved_txt')</span>
            </div>
          @elseif($leave->status == 2)
          <div>
            <span class="label label-danger loan-status">@lang('employees/common.rejected_txt')</span>
          </div>
          @else
          <div>
            <span class="label label-warning loan-status">@lang('employees/common.pending_txt')</span>
          </div>
          @endif

     
      </div>
    </div>
    <div class="col-sm-1 no-padding-right pull-right"><button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
    

  </div>

  


{{--     </div>
 --}}