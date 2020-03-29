<div class="topWrapper hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <img src="<?php echo e(asset('assets/images/maxer.jpg')); ?>" class="img-responsive">
      </div>
      
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 col-lg-offset-2 col-md-offset-1">

        
      </div>

      


      <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">

        <div class="col-xs-12 col-lg-4">
          <?php if(isset(Auth::guard('auth')->user()->roles->default) && Auth::guard('auth')->user()->roles->default <> 1): ?>
          <?php echo $data['link']; ?>

          <?php endif; ?>
        </div>
        <ul class="nav nav-pills" role="tablist">
        
          
            <ul class="nav nav-pills">
              <li role="presentation" class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo e((Auth::guard('auth')->user()->username)); ?> <span class="caret"></span> <span class="badge red"><i class="fa fa-user"></i></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo e(url('/profile')); ?>">Profile</a></li>
                  <li><a href="<?php echo e(url('logout')); ?>">Logout</a></li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
        
         

        <script type="text/javascript">
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myNoticeBoard() {
            document.getElementById("style-3").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
          if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }
        }
      </script>

      </div>


    </div>

  </div>
</div>
