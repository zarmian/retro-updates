
$(document).ready(function() {
  $('.summernote').summernote({
    height: 300,
    tabsize: 2
  });
});

$(document).on('click', '.timing-action', function(){

	var btn = $(this);
	var status = btn.attr('data-status');

	$('#frmAddProject').load(site.base_url + '/attendance/view/' + status);
	$('#ProjectModal').modal({remote: site.base_url + '/attendance/view/' + status});
	$("#ProjectModal").modal();

});


$(document).on('click', '#markAttendance', function (event){

	var btn = $(this);
	var url = $(this).attr('data-url');
	var csrf_token = $('#csrf_token').val();
	var detail = $('#detail').val();

	if(detail!==undefined){ detail = detail; }else{ detail = null;}

		btn.attr('data-temp',btn.html()).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"> </i> Wait....').attr('disabled','disabled');

		$.ajax({
			url: url,
			type: 'post',
			data: {'_token': csrf_token, 'detail': detail},
			success: function (data) {

				if($.isEmptyObject(data.error)){

					if(data == 'in'){
						$('#timing-action').addClass('time-out').removeClass('time-in').html('Time Out &nbsp;&nbsp; <i class="fa fa-clock-o"></i>');
						$("#ProjectModal").modal('hide');
					}else{
						$('#timing-action').addClass('time-in').removeClass('time-out').html('Time In &nbsp;&nbsp; <i class="fa fa-clock-o"></i>');
						$("#ProjectModal").modal('hide');
					}

				}else{
					$("#detail").fadeIn().html('').css("border","1px solid red");
					btn.attr('disabled', false).html(btn.attr('data-temp'));
				}

					
			}
		});

		


});


$(function(){
$(".dropdown").hover(            
	function() {
	    $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
	    $(this).toggleClass('open');
	    //$('b', this).toggleClass("caret caret-up");                
	},
	function() {
	    $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
	    $(this).toggleClass('open');
	    //$('b', this).toggleClass("caret caret-up");                
	});
});
	
$(document).on('click', '.is_delete', function (){

	var conf = confirm('Are you sure to delete this record?');
	if(conf){
		return true;
	}
	return false;
});

$(document).ready(function($) {
	$('.datepicker').dateDropper();
});