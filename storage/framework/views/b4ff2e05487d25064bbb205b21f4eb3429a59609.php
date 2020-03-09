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
            <li><a href="<?php echo e(url('/')); ?>">Dashboard</a></li>
            
            <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES') || Auth::guard('auth')->user()->hasRole('MANAGE_DEPARTMENTS') || Auth::guard('auth')->user()->hasRole('MANAGE_DESIGNATION') || Auth::guard('auth')->user()->hasRole('MANAGE_SHIFT') || Auth::guard('auth')->user()->hasRole('SALARIES_CREATED') || Auth::guard('auth')->user()->hasRole('SALARIES_MANAGER')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">HR Managment <span class="caret"></span></a>       
              <ul class="dropdown-menu" role="menu">
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES')): ?>
                <li><a href="<?php echo e(url('employees')); ?>">View Employees</a></li>
                <li><a href="<?php echo e(url('employees/create')); ?>">Add New Employees </a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_DEPARTMENTS')): ?>
                <li><a href="<?php echo e(url('departments')); ?>">Departments</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_DESIGNATION')): ?>
                <li><a href="<?php echo e(url('designations')); ?>">Dasignation</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_SHIFT')): ?>
                <li><a href="<?php echo e(url('shift')); ?>">Shifts</a></li>
                <?php endif; ?>

                <?php if(Auth::guard('auth')->user()->hasRole('SALARIES_CREATED') || Auth::guard('auth')->user()->hasRole('SALARIES_MANAGER')): ?>
                <li class="dropdown-submenu"><a href="#">Payroll System</a>
                  <ul class="dropdown-menu">
                    <?php if(Auth::guard('auth')->user()->hasRole('SALARIES_CREATED')): ?>
                    <li><a href="<?php echo e(url('/salary/create')); ?>">Create New Salary</a></li>
                    <?php endif; ?>
                    <?php if(Auth::guard('auth')->user()->hasRole('SALARIES_MANAGER')): ?>
                    
                    <?php endif; ?>
                  </ul>
                </li>
                <?php endif; ?>

              </ul>                
            </li>
            <?php endif; ?>
            
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Items<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
              <?php if(Auth::guard('auth')->user()->hasRole('SALES')): ?>
                <li><a href="<?php echo e(url('accounting/items/add')); ?>">New Item</a></li>
                <li><a href="<?php echo e(url('accounting/items')); ?>">View Items</a></li>
              <?php endif; ?>
              
              
              </ul>                
            </li>
            <?php endif; ?>
            
            <?php if(Auth::guard('auth')->user()->hasRole('SALES') || Auth::guard('auth')->user()->hasRole('PURCHASE') || Auth::guard('auth')->user()->hasRole('EXPENSES')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transections<span class="caret"></span></a>        
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
                <li><a href="<?php echo e(url('accounting/journal/add')); ?>">New Expens</a></li>
                <li><a href="<?php echo e(url('accounting/journal')); ?>">Expens Record</a></li>
              <?php endif; ?>

              <?php if(Auth::guard('auth')->user()->hasRole('FINANCE')): ?>
                <li><a href="<?php echo e(url('accounting/interbank/add')); ?>">Internal Trans</a></li>
                <li><a href="<?php echo e(url('accounting/interbank')); ?>">Internal Trans Record</a></li>
              <?php endif; ?>
              </ul>                
            </li>
            <?php endif; ?>

            
            <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES_LOANS') || Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES_LEAVES')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Requests<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES_LOANS')): ?>
                <li><a href="<?php echo e(url('/employees/loans')); ?>">Loan Requests</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES_LEAVES')): ?>
                <li><a href="<?php echo e(url('/leaves')); ?>">Leave Requests</a></li>
                <?php endif; ?>
              </ul>                
            </li>
            <?php endif; ?>
            

            <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_APPLY_LOAN') || Auth::guard('auth')->user()->hasRole('MANAGE_APPLY_LEAVES')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Apply for Personal<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_APPLY_LOAN')): ?>
                <li><a href="<?php echo e(url('/loan-request')); ?>">Apply Loan</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_APPLY_LEAVES')): ?>
                <li><a href="<?php echo e(url('/leave-request')); ?>">Apply Leave</a></li>
                <?php endif; ?>
              </ul>                
            </li>
            <?php endif; ?>

            
            

            <?php if(Auth::guard('auth')->user()->hasRole('NOTICEBOARD_MANAGE') || Auth::guard('auth')->user()->hasRole('MANAGE_OFFICIAL_LEAVES')): ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Annoumsments<span class="caret"></span></a>        
              <ul class="dropdown-menu" role="menu">
                <?php if(Auth::guard('auth')->user()->hasRole('NOTICEBOARD_MANAGE')): ?>
                <li><a href="<?php echo e(url('/noticeboard')); ?>">Notice Board</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_OFFICIAL_LEAVES')): ?>
                <li><a href="<?php echo e(url('/official-leaves')); ?>">Official Holidays</a></li>
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

                <?php if(Auth::guard('auth')->user()->hasRole('EMPLOYEE_ATTENDANCE_REPORT')): ?>
                <li><a href="<?php echo e(url('/reports/daily-attendance')); ?>">Attendace Reports</a></li>
                <?php endif; ?>
                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_ATTENDANCE')): ?>
                <li><a href="<?php echo e(url('/reports/manage-attendance')); ?>">Manage Attendance</a></li>
                <?php endif; ?>

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

                <?php if(Auth::guard('auth')->user()->hasRole('MANAGE_EMPLOYEES')): ?>
                <li><a href="<?php echo e(url('/employees/ledger')); ?>">Employees Ledger</a></li>
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
