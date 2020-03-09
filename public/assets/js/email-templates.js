$(document).ready(function () {


	$('#mail_invoice_created,#mail_invoice_reminder,#mail_invoice_overdue,#mail_invoice_confirm').on('click', function (event) {

		var id = $(this).attr("data-id");
		var st = $(this).attr("data-st");

		$('#viewModal').modal('show');

		$('#modal-html').load(site.base_url + '/accounting/sales/mail/' + id + '/'+ st);
		$('#viewModal').modal('show');
		$('.sysedit').summernote({});
	
		event.preventDefault();
	});


	$('#paymentModal').on('show.bs.modal', function (event) {
      
      var button = $(event.relatedTarget); 
      var id = button.data('id');
      $('#paymentView').load(site.base_url + '/accounting/sales/modal/' + id);

    });


    $('#VoucherpaymentModal').on('show.bs.modal', function (event) {
      
      var button = $(event.relatedTarget); 
      var id = button.data('id');
      $('#paymentView').load(site.base_url + '/accounting/purchase/modal/' + id);

    });


    $('#mail_voucher_created').on('click', function (event) {

		var id = $(this).attr("data-id");
		var st = $(this).attr("data-st");

		$('#viewModal').modal('show');

		$('#modal-html').load(site.base_url + '/accounting/purchase/mail/' + id + '/'+ st);
		$('#viewModal').modal('show');
		$('.sysedit').summernote({});
	
		event.preventDefault();
	});

});