$(document).ready(function($) {
	
	$(".is_delete").click(function (){

		var conf = confirm('Are you sure to delete this record?');
		if(conf){
			return true;
		}
		return false;
	});

});