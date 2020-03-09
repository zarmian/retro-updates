<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e(config('app.name')); ?></title>

<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<link href="<?php echo e(asset('assets/bootstrap/css/bootstrap.css?v=1.23')); ?>" type="text/css" rel="stylesheet">
<script type="text/javascript">
		// Your delay in milliseconds
		$(document).ready(function($) {
			var URL = '<?php echo e(url('/')); ?>';
			var delay = 5000; 
			setTimeout(function(){ window.location = URL; }, delay);
		});
		
	</script>
<style type="text/css">

.text p {
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

.image img {
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

.block-of-text p {
  position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}

/* ====================================
   Base styling, to make the demo more fancy
   ==================================== */

@import  url(https://fonts.googleapis.com/css?family=Roboto:400,300,700,100);

body {
  font-family: Roboto, sans-serif;
  background: #2C3D51;
  
  -webkit-font-smoothing: antialiased;
}

h1 {
  text-align: center;
  color: white;
  font-weight: 300;
}

h2 {
 text-transform: uppercase;
 margin: 0;
 font-size: 16px;
 position: absolute;
 top: 5px;
 right: 5px;
 font-weight: bold;
 color: #ECF0F1; 
}

section {
  display: block;
  max-width: 500px;
  background: #fff;
 
  height: 100vh;
  border-radius: .2em;
  position: relative;
  color: white;
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  transform-style: preserve-3d;
  img, p {
    padding: 1em;
    margin: 0;
  }
}


.read-more {
  text-align: center;
  color: white;
  font-size: 12px;
  margin-top: 3em;
  a {
    text-decoration: none;
    color: #E74C3C;
  }
}


</style>
</head>

<body style="background: #eeeeee">

	<div class="">
		<div class="">

			<div class="col-lg-3 col-xs-3">
				<div class="row">
					<section class="image" style=" text-align: center">
				  
				  <img src="<?php echo e(asset('assets/images/404-logo.jpg')); ?>" alt="" class="img-responsive" style="display: initial !important; text-align: center" />
				</section>
				</div>
			</div>

			
			<div class="col-lg-9 col-xs-9 text-center">
				<div class="error-img" style="padding: 20% 0; text-align: center;">
					<h1 style="color: #493781; font-size: 70px; font-weight: bolder; padding:0px; ">ERROR 404</h1>
					<h3 style="color: #493781; font-size: 40px; font-weight: normal;">DATA NOT FOUND</h3>
					<p style="color: #595959; font-size: 15px; font-weight: normal;">Redirect to home page after 5 seconds</p>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
	
</body>
</html>
