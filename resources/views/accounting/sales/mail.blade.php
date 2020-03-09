<div class="modal-content clearfix" id="">
	

<div class="modal-container">
    
    <form action="{{ url('accounting/sales/do-mail') }}" id="update" method="POST" data-toggle="validator">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

	
	 <div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
        <h4>{{ $title }}  </h4>
        <p>@lang('admin/users.field_employee_text')</p>
      </div>
    <div class="col-sm-1 col-xs-1 no-padding-right pull-right">
    	<button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="col-sm-12 col-xs-12 modal-body clearfix">

    <div class="col-sm-11">
      <div class="alert alert-danger print-error-msg" style="display:none;">
        <ul></ul>
    </div>
    </div>


      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="mail_to">@lang('admin/entries.mail_to_label')</label>
        <input type="text" name="mail_to" class="form-control1" value="{{ $template['email_to'] }}" required="required"  />
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="mail_cc">@lang('admin/entries.mail_cc_label')</label>
        <input type="text" name="mail_cc" class="form-control1" value=""  />
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="mail_bcc">@lang('admin/entries.mail_bcc_label')</label>
        <input type="text" name="mail_bcc" class="form-control1" value=""  />
      </div>

      <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 form-group">
        <label for="subject">@lang('admin/entries.subject_label')</label>
        <input type="text" name="subject" class="form-control1" value="{{ $template['subject'] }}" required="required" />
      </div>


      <div class="col-sm-12 form-group">
        <label for="description">@lang('admin/entries.detail_txt')</label>
        <textarea name="description" id="description" cols="30" rows="5" class="sysedit summernote form-control" placeholder="@lang('admin/entries.detail_txt')">{{ $template['body'] }}</textarea>
      </div>

      <div class="col-sm-10">
      <div class="checkbox c-checkbox">
	      <label>
	        <input type="checkbox" name="attach_pdf" id="attach_pdf" value="Yes" checked=""> <i class="fa fa-paperclip"></i> {{ $template['invoice_number'] }}.pdf
	      </label>
	    </div>
    </div>


      <div class="col-sm-12 form-group">
        <label for=""></label>
        <button type="submit" id="do-mail" class="btn btn-primary btn-block">@lang('admin/common.send_email_button')</button>
      </div>

   		<input id="sale_id" name="sale_id" value="{{ $template['sale_id'] }}" type="hidden">

    </div>
    
    
    </form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
<script>
 
 $(document).ready(function(){
 	$('.sysedit').summernote({});
 });

$(document).ready(function() {

    $('form[data-toggle="validator"]').bootstrapValidator({
        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          mail_to: {
            validators: {
              notEmpty: {
	                message: 'The email is required and cannot be empty'
	            }
            }
          },
          subject: {
            validators: {
              notEmpty: {
	                message: 'The subject is required and cannot be empty'
	            }
            }
          }
        }
    }).on('success.form.bv', function(e) {

      

      var $btn = $('#do-mail');
      $btn.button('loading');

      var $form = $(e.target),
      fv    = $(e.target).data('bootstrapValidator');

      var sr = $form.serialize();

      $form.ajaxSubmit({
        url: $form.attr('action'),
        dataType: 'json',
        success: function(responseText, statusText, xhr, $form) {
          if($.isEmptyObject(responseText.error)){
            $('.modal').modal('hide');
          }else{
            printErrorMsg(responseText.error);
            $btn.button('reset');
          }
        }
      });

      e.preventDefault();

      //return false;
    });
});

function printErrorMsg (msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display','block');
  $.each( msg, function( key, value ) {
    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
  });
}
</script>


    
  </div>

</div>

