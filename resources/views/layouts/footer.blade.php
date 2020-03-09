
<script src="{{ asset('assets/js/jquery.flexnav.js') }}"></script> 
<script type="text/javascript">
		jQuery(".flexnav").flexNav();
</script> 
<!-- menu-->
<!-- select option -->
<script>
$(document).ready(function() {

  // Default dropdown action to show/hide dropdown content
  $('.js-dropp-action').click(function(e) {
    e.preventDefault();
    $(this).toggleClass('js-open');
    $(this).parent().next('.dropp-body').toggleClass('js-open');
  });

  // Using as fake input select dropdown
  $('label').click(function() {
    $(this).addClass('js-open').siblings().removeClass('js-open');
    $('.dropp-body,.js-dropp-action').removeClass('js-open');
  });
  // get the value of checked input radio and display as dropp title
  $('input[name="dropp"]').change(function() {
    var value = $("input[name='dropp']:checked").val();
    $('.js-value').text(value);
  });

});
</script><!-- footer-->
<div class="container-fluid footer">
	<div class="row">
    	<div class="col-lg-12">
        	Copyright © 2016 - Maxer Online. All Rights Reserved.
        </div>
    </div>
</div>
<!--footer-->
</body>
</html>