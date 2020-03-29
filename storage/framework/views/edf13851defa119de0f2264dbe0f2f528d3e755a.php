<!-- menu -->  
<div>
    <nav class="navbar navbar-default" role="navigation">
  <div class="container">

  <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-slide-dropdown">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-slide-dropdown">
        <ul class="nav navbar-nav multi-level">
            
                    
                    
            
            <?php if(Auth::guard('auth')->user()->hasRole('CUSTOMERS_SECTION') || Auth::guard('auth')->user()->hasRole('VENDORS_SECTION')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">CRM<span class="caret"></span></a>       
              <ul class="dropdown-menu" role="menu">
              <?php if(Auth::guard('auth')->user()->hasRole('CUSTOMERS_SECTION')): ?>
                <li><a href="<?php echo e(url('accounting/customers')); ?>">View Customers</a></li>
                <li><a href="<?php echo e(url('accounting/customers/add')); ?>">Add New Customer </a></li>
              <?php endif; ?>

              <?php if(Auth::guard('auth')->user()->hasRole('VENDORS_SECTION')): ?>
                <li><a href="<?php echo e(url('accounting/vendors')); ?>">View Vendors</a></li>
                <li><a href="<?php echo e(url('accounting/vendors/add')); ?>">Add New Vendor</a></li>
              <?php endif; ?>
              </ul>                
            </li>

            <?php endif; ?>

            <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_ITEMS')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Data<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
              <?php if(Auth::guard('auth')->user()->hasRole('SALES')): ?>
              <li class="dropdown-submenu"><a href="#">Trucks</a>
                <ul class="dropdown-menu">
                <li><a href="<?php echo e(url('accounting/trucks/add')); ?>">New Truck</a></li>
                <li><a href="<?php echo e(url('accounting/trucks')); ?>">View Trucks</a></li>
                <li><a href="<?php echo e(url('accounting/trucks/addproducts')); ?>">New Product to Truck</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Destinations</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo e(url('accounting/destination/add')); ?>">New Destination</a></li>
                <li><a href="<?php echo e(url('accounting/destination')); ?>">View Destinations</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Origins</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo e(url('accounting/origin/add')); ?>">New Origin</a></li>
                <li><a href="<?php echo e(url('accounting/origin')); ?>">View Origins</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu"><a href="#">Products</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo e(url('accounting/products/add')); ?>">New Product</a></li>
                <li><a href="<?php echo e(url('accounting/products')); ?>">View Products</a></li>
              </ul>
            </li>
              <?php endif; ?>
              
              
              </ul>                
            </li>
            <?php endif; ?>
            
            <?php if(Auth::guard('auth')->user()->hasRole('SALES') || Auth::guard('auth')->user()->hasRole('PURCHASE') || Auth::guard('auth')->user()->hasRole('EXPENSES')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transactions<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
              <?php if(Auth::guard('auth')->user()->hasRole('SALES')): ?>
                <li><a href="<?php echo e(url('accounting/sales/add')); ?>">New Sale</a></li>
                <li><a href="<?php echo e(url('accounting/sales')); ?>">Sale Records</a></li>
              <?php endif; ?>
              <?php if(Auth::guard('auth')->user()->hasRole('PURCHASE')): ?>
                <li><a href="<?php echo e(url('accounting/purchase/add')); ?>">New Purchase</a></li>
                <li><a href="<?php echo e(url('accounting/purchase')); ?>">Purchase Record</a></li>
              <?php endif; ?>


              

              <?php if(Auth::guard('auth')->user()->hasRole('EXPENSES')): ?>
                <li><a href="<?php echo e(url('accounting/journal/add')); ?>">New Journal Entry</a></li>
                <li><a href="<?php echo e(url('accounting/journal')); ?>">Journal Record</a></li>
              <?php endif; ?>

              <?php if(Auth::guard('auth')->user()->hasRole('FINANCE')): ?>
                <li><a href="<?php echo e(url('accounting/interbank/add')); ?>">Inter-Bank Trans</a></li>
                <li><a href="<?php echo e(url('accounting/interbank')); ?>">Inter-Bank Trans Record</a></li>
              <?php endif; ?>
              </ul>                
            </li>
            <?php endif; ?>

            
            
            

            

            
            

            
            
            <?php if(Auth::guard('auth')->user()->hasRole('FINANCE')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Finance<span class="caret"></span></a>       
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo e(url('accounting')); ?>">Dashboard</a></li>
                <li><a href="<?php echo e(url('accounting/chart')); ?>">Chart Of Accounts</a></li>
                <li><a href="<?php echo e(url('accounting/chart-type')); ?>">Manage Accounts Type</a></li>
                <li><a href="<?php echo e(url('accounting/bank-cash')); ?>">Bank & Cash</a></li>
                <li><a href="<?php echo e(url('reports/trial')); ?>">Trial Balance</a></li>
              </ul>                
            </li>
            <?php endif; ?>
            
            <?php if(Auth::guard('auth')->user()->hasRole('EMPLOYEE_ATTENDANCE_REPORT') || Auth::guard('auth')->user()->hasRole('MANAGE_ATTENDANCE') || Auth::guard('auth')->user()->hasRole('SALE_REPORTS') || Auth::guard('auth')->user()->hasRole('PURCHASE_REPORTS') || Auth::guard('auth')->user()->hasRole('EXPENSES_REPORT') || Auth::guard('auth')->user()->hasRole('ACCOUNTS_REPORTS')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<span class="caret"></span></a>       
              <ul class="dropdown-menu" role="menu">

                

                <?php if(Auth::guard('auth')->user()->hasRole('SALE_REPORTS')): ?>
                <li class="dropdown-submenu"><a href="#">Sale Reports</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo e(url('/reports/sales')); ?>">Sales Report</a></li>
                    <li><a href="<?php echo e(url('/reports/sales-payments')); ?>">Sales Transaction Report</a></li>
                    <li><a href="<?php echo e(url('/reports/sales-balance')); ?>">Sales Balance Report</a></li>
                  </ul>
                </li>
                <?php endif; ?>
                
                <?php if(Auth::guard('auth')->user()->hasRole('PURCHASE_REPORTS')): ?>
                <li class="dropdown-submenu"><a href="#">Purchase Reports</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo e(url('/reports/purchase')); ?>">Purcahse Report</a></li>
                    <li><a href="<?php echo e(url('/reports/purchase-payments')); ?>">Purcahse Transaction Report</a></li>
                    <li><a href="<?php echo e(url('/reports/purchase-balance')); ?>">Purcahse Balance Report</a></li>
                  </ul>
                </li>
                <?php endif; ?>

                <?php if(Auth::guard('auth')->user()->hasRole('EXPENSES_REPORT')): ?>
                <li class="dropdown-submenu"><a href="#">Expense Reports</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo e(url('/reports/expense')); ?>">Expense Report</a></li>
                  </ul>
                </li>
                <?php endif; ?>
                
                <?php if(Auth::guard('auth')->user()->hasRole('ACCOUNTS_REPORTS')): ?>
                <li><a href="<?php echo e(url('/reports/statement')); ?>">Account Statement Report</a></li>
                <?php endif; ?>

                

              </ul>                
            </li>
            <?php endif; ?>
            
            <?php if(Auth::guard('auth')->user()->hasRole('SETTING') || Auth::guard('auth')->user()->hasRole('EMAIL_TEMPLATES') || Auth::guard('auth')->user()->hasRole('MANAGE_USERS') || Auth::guard('auth')->user()->hasRole('EMPLOYEE_ROLES')): ?>
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<span class="caret"></span></a>        
                <ul class="dropdown-menu" role="menu">
                <?php if(Auth::guard('auth')->user()->hasRole('SETTING')): ?>
                <li><a href="<?php echo e(url('/setting')); ?>">General Setting</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('EMAIL_TEMPLATES')): ?>
                <li><a href="<?php echo e(url('/email/templates')); ?>">Email Templates</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_USERS')): ?>
                <li><a href="<?php echo e(url('/manage-users')); ?>">Manage Users</a></li>
                <?php endif; ?>
              
                <?php if(Auth::guard('auth')->user()->hasRole('EMPLOYEE_ROLES')): ?>
                <li><a href="<?php echo e(url('/roles')); ?>">Manage Role</a></li>
                <?php endif; ?>

                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_TAX')): ?>
                <li><a href="<?php echo e(url('/accounting/tax')); ?>">Manage Tax</a></li>
                <?php endif; ?>
              </ul>                
            </li>
            <?php endif; ?>
            

        </ul>

          
       
       
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
