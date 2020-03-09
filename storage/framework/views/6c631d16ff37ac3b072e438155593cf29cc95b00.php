<div class="topWrapper hidden-print">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <img src="<?php echo e(asset('assets/images/maxer.jpg')); ?>" class="img-responsive">
      </div>
      
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 col-lg-offset-2 col-md-offset-1">

        <?php if(isset(Auth::guard('auth')->user()->roles->default) && Auth::guard('auth')->user()->roles->default == 1): ?>
        <form action="<?php echo e(url('/search')); ?>" method="get" id="searchForm">
          <label id="email-label">
            <i id="filtersubmit" class="fa fa-search"></i>
            <input type="text" name="q" class="input search" />
          </label>
        </form>
        <?php endif; ?>
      </div>

      <script type="text/javascript">
        $('#filtersubmit').click(function() { 
          $('#searchForm').submit();
      });
      </script>


      <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">

        <div class="col-xs-12 col-lg-4">
          <?php if(isset(Auth::guard('auth')->user()->roles->default) && Auth::guard('auth')->user()->roles->default <> 1): ?>
          <?php echo $data['link']; ?>

          <?php endif; ?>
        </div>
        <ul class="nav nav-pills" role="tablist">
        
          <li role="presentation"><a href="javascript:void(0)" onclick="myNoticeBoard()" class="dropbtn"><?php echo app('translator')->getFromJson('employees/common.noticeboard_txt'); ?><span class="badge purpal"><b><?php echo e(count($notices)); ?></b></span></a></li>
          <li role="presentation">
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
        
         <?php if(isset($notices) && count($notices) > 0): ?>
        <div style="position: relative;">
          
          <div id="style-3" class="dropdown-content">
          <ul>
          <?php $__currentLoopData = $notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <div class="noticeboard_box">
                <a href="<?php echo e($notice['url']); ?>">
                  <div class="notice_heading"><?php echo e($notice['title']); ?>

                  <br>
                    <span class="color-red">
                      
                      <b><?php echo app('translator')->getFromJson('employees/common.date_txt'); ?></b> <?php echo e($notice['date']); ?>

                    </span>
                  </div>
                 
                  <div class="notice_detail"></div>
                </a>
              </div>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
          </ul>

          <div class="noticeboard_viewall text-center"></div>
        </div>

        </div>
        <?php endif; ?>

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
