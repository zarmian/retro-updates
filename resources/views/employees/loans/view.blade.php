@if(isset($loan) && count($loan) > 0)
<div class="modal-content">
<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="">{{ $loan->title }}</h4>
      </div>
      <div class="modal-body">
        <div>
          <b>Loan Detail</b>
          <p>{{ $loan->detail }}</p>
        </div>

        <div>
          <b>Amount</b>
          <p>{{ $loan->amount }}</p>
        </div>

        <div>
          <legend>
            Approved Detail
          </legend>
          <p>{{ $loan->approve_detail }}</p>
          
        </div>
        @if($loan->status == 1)
          
          <div>
            <span class="label label-success loan-status">@lang('employees/common.approved_txt')</span>
          </div>
        @elseif($loan->status == 2)
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
@endif