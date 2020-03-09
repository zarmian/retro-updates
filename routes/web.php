<?php 
 Route::get('/', ['uses' => 'Auth\AuthController@showLoginForm']);
Route::get('login', ['uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['uses' => 'Auth\AuthController@login'])->middleware('verify');

Route::group(['middleware' => ['user']], function () {
	

	Route::get('/', ['as' => '/', 'uses' => 'Admin\DashboardController@index']);

	Route::get('/search/{q?}', ['as' => '/search/{q?}', 'uses' => 'Admin\DashboardController@search']);
	
	Route::get('/profile', ['as' => '/profile', 'uses' => 'Admin\DashboardController@profile']);

	Route::post('/profile/update', ['as' => '/profile/update', 'uses' => 'Admin\DashboardController@update']);

	Route::post('/profile/ajax', ['as' => '/profile/ajax', 'uses' => 'Admin\DashboardController@ajax']);

	Route::post('/profile/cover', ['as' => '/profile/cover', 'uses' => 'Admin\DashboardController@coverUpadate']);

	/* Manage User Groups Route */
	
	Route::get('/manage-groups', ['as' => '/manage-groups', 'uses' => 'Admin\UserGroupsController@index'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::get('/manage-groups/create', ['as' => '/manage-groups/create', 'uses' => 'Admin\UserGroupsController@create'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::get('/manage-groups/edit/{id?}', ['as' => '/manage-groups/edit/{id?}', 'uses' => 'Admin\UserGroupsController@edit'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::post('/manage-groups/store', ['as' => '/manage-groups/store', 'uses' => 'Admin\UserGroupsController@store'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::post('/manage-groups/update/{id?}', ['as' => '/manage-groups/update/{id?}', 'uses' => 'Admin\UserGroupsController@update'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::get('/manage-groups/destroy/{id?}', ['as' => '/manage-groups/destroy/{id?}', 'uses' => 'Admin\UserGroupsController@destroy'])->middleware('permissions:MANAGE_USERS_GROUPS');

	/* Manage User Groups Permissions Route */

	Route::get('admin/manage-permissions/show/{id}', ['as' => 'admin/manage-permissions/show/{id}', 'uses' => 'Admin\UserGroupsPermissionsController@show'])->middleware('permissions:MANAGE_USERS_GROUPS');

	Route::post('admin/manage-permissions/update/{id}', ['as' => 'admin/manage-permissions/update/{id}', 'uses' => 'Admin\UserGroupsPermissionsController@update'])->middleware('permissions:MANAGE_USERS_GROUPS')	;


	/* Manage Users Accounts */

	Route::get('/manage-users', ['as' => '/manage-users', 'uses' => 'Admin\UserController@index'])->middleware('permissions:MANAGE_USERS');

	Route::get('/manage-users/create', ['as' => '/manage-users/create', 'uses' => 'Admin\UserController@create'])->middleware('permissions:MANAGE_USERS');

	Route::post('/manage-users/store', ['as' => '/manage-users/store', 'uses' => 'Admin\UserController@store'])->middleware('permissions:MANAGE_USERS');

	Route::get('/manage-users/edit/{id?}', ['as' => '/manage-users/edit/{id}', 'uses' => 'Admin\UserController@edit'])->middleware('permissions:MANAGE_USERS');

	Route::post('/manage-users/update/{id?}', ['as' => '/manage-users/edit/{id}', 'uses' => 'Admin\UserController@update'])->middleware('permissions:MANAGE_USERS');

	Route::get('/manage-users/remove/{id?}', ['as' => '/manage-users/remove/{id}', 'uses' => 'Admin\UserController@destroy' ])->middleware('permissions:MANAGE_USERS');


	/* Shift Routes */
	Route::get('/shift', ['as' => '/shift', 'uses' => 'Admin\ShiftController@index'])->middleware('permissions:MANAGE_SHIFT');

	Route::get('/shift/create', ['as' => '/shift/create', 'uses' => 'Admin\ShiftController@create'])->middleware('permissions:MANAGE_SHIFT');

	Route::post('/shift/store', ['as' => '/shift/store', 'uses' => 'Admin\ShiftController@store'])->middleware('permissions:MANAGE_SHIFT');

	Route::get('/shift/edit/{id?}', ['as' => '/shift/edit/{id?}', 'uses' => 'Admin\ShiftController@edit'])->middleware('permissions:MANAGE_SHIFT');

	Route::post('/shift/update/{id?}', ['as' => '/shift/update/{id?}', 'uses' => 'Admin\ShiftController@update'])->middleware('permissions:MANAGE_SHIFT');

	Route::get('/shift/remove/{id?}', ['as' => '/shift/remove/{id?}', 'uses' => 'Admin\ShiftController@destroy'])->middleware('permissions:MANAGE_SHIFT');


	/* Departments Routes */

	Route::get('/departments', ['as' => '/departments', 'uses' => 'Admin\DepartmentsController@index'])->middleware('permissions:MANAGE_DEPARTMENTS');

	Route::get('/departments/create', ['as' => '/departments/create', 'uses' => 'Admin\DepartmentsController@create'])->middleware('permissions:MANAGE_DEPARTMENTS');

	Route::post('/departments/store', ['as' => '/departments/store', 'uses' => 'Admin\DepartmentsController@store'])->middleware('permissions:MANAGE_DEPARTMENTS');

	Route::get('/departments/edit/{id?}', ['as' => '/departments/edit/{id?}', 'uses' => 'Admin\DepartmentsController@edit'])->middleware('permissions:MANAGE_DEPARTMENTS');

	Route::post('/departments/update/{id?}', ['as' => '/departments/update/{id?}', 'uses' => 'Admin\DepartmentsController@update'])->middleware('permissions:MANAGE_DEPARTMENTS');
	
	Route::get('/departments/remove/{id?}', ['as' => '/departments/remove/{id?}', 'uses' => 'Admin\DepartmentsController@destroy'])->middleware('permissions:MANAGE_DEPARTMENTS');


	/* Designation Routes */

	Route::get('/designations', ['as' => '/designations', 'uses' => 'Admin\DesignationsController@index'])->middleware('permissions:MANAGE_DESIGNATION');

	Route::get('/designations/create', ['as' => '/designations/create', 'uses' => 'Admin\DesignationsController@create'])->middleware('permissions:MANAGE_DESIGNATION');

	Route::post('/designations/store', ['as' => '/designations/store', 'uses' => 'Admin\DesignationsController@store'])->middleware('permissions:MANAGE_DESIGNATION');

	Route::get('/designations/edit/{id?}', ['as' => '/designations/edit/{id?}', 'uses' => 'Admin\DesignationsController@edit'])->middleware('permissions:MANAGE_DESIGNATION');

	Route::post('/designations/update/{id?}', ['as' => '/designations/update/{id?}', 'uses' => 'Admin\DesignationsController@update'])->middleware('permissions:MANAGE_DESIGNATION');

	Route::get('/designations/remove/{id?}', ['as' => '/designations/remove/{id?}', 'uses' => 'Admin\DesignationsController@destroy'])->middleware('permissions:MANAGE_DESIGNATION');

	/* Employees Routes */

	Route::get('employees', ['as' => 'employees', 'uses' => 'Admin\EmployeesController@index'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('employees/create', ['as' => 'employees/create', 'uses' => 'Admin\EmployeesController@create'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::post('employees/store', ['as' => 'employees/store', 'uses' => 'Admin\EmployeesController@store'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('employees/edit/{id?}', ['as' => 'employees/edit/{id?}', 'uses' => 'Admin\EmployeesController@edit'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::post('employees/update/{id?}', ['as' => 'employees/update/{id?}', 'uses' => 'Admin\EmployeesController@update'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('employees/remove/{id?}', ['as' => 'employees/remove/{id?}', 'uses' => 'Admin\EmployeesController@destroy'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('employees/view/{id?}', ['as' => 'employees/view/{id?}', 'uses' => 'Admin\EmployeesController@show'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('employees/ledger', ['as' => 'employees/ledger', 'uses' => 'Admin\EmployeesController@ledger'])->middleware('permissions:MANAGE_EMPLOYEES');

	// Route::any('/admin/employees/index', ['as' => '/admin/employees/index', 'middleware'=>'adminajax', 'uses' => 'Admin\EmployeesController@index']);


	/* Employees Roles Routes */

	Route::get('/roles', ['as' => '/roles', 'uses' => 'Admin\EmployeesRolesController@index'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('/roles/create', ['as' => '/roles/create', 'uses' => 'Admin\EmployeesRolesController@create'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::post('/roles/store', ['as' => '/roles/store', 'uses' => 'Admin\EmployeesRolesController@store'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('/roles/edit/{id?}', ['as' => '/roles/edit/{id?}', 'uses' => 'Admin\EmployeesRolesController@edit'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::post('/roles/update/{id?}', ['as' => '/roles/update/{id?}', 'uses' => 'Admin\EmployeesRolesController@update'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('/roles/remove/{id?}', ['as' => '/roles/remove/{id?}', 'uses' => 'Admin\EmployeesRolesController@destroy'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::get('/roles/permissions/show/{id?}', ['as' => '/roles/permissions/show/{id?}', 'uses' => 'Admin\EmployeesRolesController@show'])->middleware('permissions:MANAGE_EMPLOYEES');

	Route::post('/role/permissions/update/{id?}', ['as' => '/role/permissions/update/{id?}', 'uses' => 'Admin\EmployeesRolesController@update_permissions'])->middleware('permissions:MANAGE_EMPLOYEES');


	/* Employee Loans Routes */

	Route::get('/employees/loans', ['as' => 'admin/employees/loans', 'uses' => 'Admin\EmployeesLoansController@index'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::get('/employees/loans/create', ['as' => 'admin/employees/loans/create', 'uses' => 'Admin\EmployeesLoansController@create'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::post('/employees/loans/store', ['as' => '/employees/loans/store', 'uses' => 'Admin\EmployeesLoansController@store'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::get('/employees/loans/show/{id?}', ['as' => 'admin/employees/loans/show/{id?}', 'uses' => 'Admin\EmployeesLoansController@show'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::post('/employees/loans/show/{id?}', ['as' => 'admin/employees/loans/show/{id?}', 'uses' => 'Admin\EmployeesLoansController@show'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::get('/employees/loans/statement', ['as' => 'admin/employees/loans/statement', 'uses' => 'Admin\EmployeesLoansController@viewStatment'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::post('/employees/loans/statement', ['as' => 'admin/employees/loans/statement', 'uses' => 'Admin\EmployeesLoansController@getStatment'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');

	Route::post('/employees/loans/ajax', ['as' => 'admin/employees/loans/ajax', 'uses' => 'Admin\EmployeesLoansController@ajax'])->middleware('permissions:MANAGE_EMPLOYEES_LOANS');
	

	/* Official Leaves Routes */
	Route::get('/official-leaves', ['as' => '/official-leaves', 'uses' => 'Admin\EmployeesOfficialLeavesController@index'])->middleware('permissions:MANAGE_OFFICIAL_LEAVES');

	Route::get('/official-leaves/create', ['as' => '/official-leaves/create', 'uses' => 'Admin\EmployeesOfficialLeavesController@create'])->middleware('permissions:MANAGE_OFFICIAL_LEAVES');

	Route::post('/official-leaves/store', ['as' => '/official-leaves/store', 'uses' => 'Admin\EmployeesOfficialLeavesController@store'])->middleware('permissions:MANAGE_OFFICIAL_LEAVES');

	Route::get('/official-leaves/edit/{id?}', ['as' => '/official-leaves/edit/{id?}', 'uses' => 'Admin\EmployeesOfficialLeavesController@edit'])->middleware('permissions:MANAGE_OFFICIAL_LEAVES');

	Route::post('/official-leaves/update/{id?}', ['as' => '/official-leaves/update/{id?}', 'uses' => 'Admin\EmployeesOfficialLeavesController@update'])->middleware('permissions:MANAGE_OFFICIAL_LEAVES');

	/**
	 * Attendance Reports
	 */

	Route::get('/reports/daily-attendance', ['as' => 'admin/reports/daily-attendance', 'uses' => 'Admin\ReportController@daily_attendance'])->middleware('permissions:EMPLOYEE_ATTENDANCE_REPORT');

	Route::post('/reports/daily-attendance', ['as' => '/reports/daily-attendance', 'uses' => 'Admin\ReportController@daily_attendance'])->middleware('permissions:EMPLOYEE_ATTENDANCE_REPORT');

	Route::get('/reports/manage-attendance', ['as' => '/reports/manage-attendance', 'uses' => 'Admin\ReportController@mang_attendance'])->middleware('permissions:MANAGE_ATTENDANCE');

	Route::post('/reports/manage-attendance', ['as' => '/reports/manage-attendance', 'uses' => 'Admin\ReportController@mang_attendance'])->middleware('permissions:MANAGE_ATTENDANCE');

	Route::post('/reports/ajax/{paramenter?}', ['as' => '/reports/ajax/{paramenter?}', 'uses' => 'Admin\ReportController@ajax']);

	Route::get('/reports/trial', ['as' => '/reports/trial', 'uses' => 'Admin\ReportController@trial'])->middleware('permissions:FINANCE');
	
	Route::get('/reports/export/', ['as' => '/reports/export/', 'uses' => 'Admin\ReportController@export'])->middleware('permissions:FINANCE');

	/**
	 * Employee Leaves Routes
	 */
	Route::get('/leaves', ['as' => '/leaves', 'uses' => 'Admin\EmployeesLeavesRequestController@index'])->middleware('permissions:MANAGE_EMPLOYEES_LEAVES');

	Route::post('/leaves', ['as' => '/leaves', 'uses' => 'Admin\EmployeesLeavesRequestController@leaves'])->middleware('permissions:MANAGE_EMPLOYEES_LEAVES');

	Route::get('/leave/show/{id?}', ['as' => '/leave/show/{id?}', 'uses' => 'Admin\EmployeesLeavesRequestController@show'])->middleware('permissions:MANAGE_EMPLOYEES_LEAVES');

	Route::post('/leave/show/{id?}', ['as' => '/leave/show/{id?}', 'uses' => 'Admin\EmployeesLeavesRequestController@show'])->middleware('permissions:MANAGE_EMPLOYEES_LEAVES');


	/**
	 * Salaries Route
	 */

	Route::get('/salary/create', ['as' => '/salary/create', 'uses' => 'Admin\EmployeesSalaryController@create'])->middleware('permissions:SALARIES_CREATED');

	Route::post('/salary/create', ['as' => '/salary/create', 'uses' => 'Admin\EmployeesSalaryController@show'])->middleware('permissions:SALARIES_CREATED');

	Route::post('/salary/store', ['as' => '/salary/store', 'uses' => 'Admin\EmployeesSalaryController@store'])->middleware('permissions:SALARIES_CREATED');

	Route::get('/salary/show/{id?}/{date?}', ['as' => '/salary/show', 'uses' => 'Admin\EmployeesSalaryController@load'])->middleware('permissions:SALARIES_CREATED');

	Route::get('/salary/view/{id?}', ['as' => '/salary/view/{id?}', 'uses' => 'Admin\EmployeesSalaryController@edit'])->middleware('permissions:SALARIES_CREATED');

	Route::post('/salary/paid/{id?}', ['as' => '/salary/paid/{id?}', 'uses' => 'Admin\EmployeesSalaryController@update'])->middleware('permissions:SALARIES_CREATED');

	Route::get('/salary/manage', ['as' => '/salary/manage', 'uses' => 'Admin\EmployeesSalaryController@index'])->middleware('permissions:SALARIES_MANAGER');

	Route::post('/salary/manage', ['as' => '/salary/manage', 'uses' => 'Admin\EmployeesSalaryController@getSalaryReport'])->middleware('permissions:SALARIES_MANAGER');

	Route::get('/salary/print/{type?}/{id?}', ['as' => '/salary/print/{type?}/{id?}', 'uses' => 'Admin\EmployeesSalaryController@getPrintSlip'])->middleware('permissions:SALARIES_MANAGER');

	/**
	 * End Salaries Route
	 */


	Route::get('/noticeboard', ['as' => '/noticeboard', 'uses' => 'Admin\NoticeboardController@index'])->middleware('permissions:NOTICEBOARD_MANAGE');

	Route::get('/noticeboard/create', ['as' => '/noticeboard/create', 'uses' => 'Admin\NoticeboardController@create'])->middleware('permissions:NOTICEBOARD_MANAGE');

	Route::post('/noticeboard/create', ['as' => '/noticeboard/create', 'uses' => 'Admin\NoticeboardController@store'])->middleware('permissions:NOTICEBOARD_MANAGE');

	Route::get('/noticeboard/view/{id?}', ['as' => '/noticeboard/view/{id?}', 'uses' => 'Admin\NoticeboardController@show'])->middleware('permissions:NOTICEBOARD_MANAGE');
	
	/**
	 * Accounting Routes
	 */

	Route::get('accounting', ['as' => 'accounting', 'uses' => 'Accounts\AccountsController@index'])->middleware('permissions:FINANCE');

	Route::get('accounting/chart', ['as' => 'accounting/chart', 'uses' => 'Accounts\AccountsController@chart'])->middleware('permissions:FINANCE');

	Route::get('accounting/chart/add', ['as' => 'accounting/chart/add', 'uses' => 'Accounts\AccountsController@create'])->middleware('permissions:FINANCE');

	Route::post('accounting/chart/save', ['as' => 'accounting/chart/save', 'uses' => 'Accounts\AccountsController@store'])->middleware('permissions:FINANCE');

	Route::get('accounting/chart/edit/{id?}', ['as' => 'accounting/chart/edit/{id?}', 'uses' => 'Accounts\AccountsController@edit'])->middleware('permissions:FINANCE');

	Route::post('accounting/chart/edit/{id?}', ['as' => 'accounting/chart/edit/{id?}', 'uses' => 'Accounts\AccountsController@update'])->middleware('permissions:FINANCE');
	
	Route::get('accounting/chart-type', ['as' => 'accounting/chart-type', 'uses' => 'Accounts\AccountsTypeController@index'])->middleware('permissions:FINANCE');

	Route::get('accounting/chart-type/add', ['as' => 'accounting/chart-type/add', 'uses' => 'Accounts\AccountsTypeController@create'])->middleware('permissions:FINANCE');

	Route::post('accounting/chart-type/save', ['as' => 'accounting/chart-type/save', 'uses' => 'Accounts\AccountsTypeController@store'])->middleware('permissions:FINANCE');

	Route::get('accounting/chart-type/edit/{id?}', ['as' => 'accounting/chart-type/edit/{id?}', 'uses' => 'Accounts\AccountsTypeController@edit'])->middleware('permissions:FINANCE');

	Route::post('accounting/chart-type/edit/{id?}', ['as' => 'accounting/chart-type/edit/{id?}', 'uses' => 'Accounts\AccountsTypeController@update'])->middleware('permissions:FINANCE');

	Route::get('accounting/bank-cash', ['as' => 'accounting/bank-cash', 'uses' => 'Accounts\AccountsReportsController@bankCash'])->middleware('permissions:FINANCE');

	Route::get('/reports/statement', ['as' => 'admin/reports/statement', 'uses' => 'Accounts\AccountsReportsController@index'])->middleware('permissions:ACCOUNTS_REPORTS');

	Route::post('/reports/statement', ['as' => 'admin/reports/statement', 'uses' => 'Accounts\AccountsReportsController@getAccountStatmentReport'])->middleware('permissions:ACCOUNTS_REPORTS');

	Route::get('/accounting/export/', ['as' => '/accounting/export/', 'uses' => 'Accounts\AccountsReportsController@export'])->middleware('permissions:ACCOUNTS_REPORTS');


	/**
	 * Customer Routes
	 */
	Route::get('accounting/customers', ['as' => 'accounting/customers', 'uses' => 'Accounts\CustomersController@index'])->middleware('permissions:CUSTOMERS_SECTION');
	
	Route::get('accounting/customers/add', ['as' => 'accounting/customers/add', 'uses' => 'Accounts\CustomersController@create'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::post('accounting/customers/save', ['as' => 'accounting/customers/save', 'uses' => 'Accounts\CustomersController@store'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::get('accounting/customers/edit/{id?}', ['as' => 'accounting/customers/edit/{id?}', 'uses' => 'Accounts\CustomersController@edit'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::post('accounting/customers/edit/{id?}', ['as' => 'accounting/customers/edit/{id?}', 'uses' => 'Accounts\CustomersController@update'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::get('accounting/customers/remove/{id?}', ['as' => 'accounting/customers/remove/{id?}', 'uses' => 'Accounts\CustomersController@destroy'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::get('accounting/customers/view/{id?}', ['as' => 'accounting/customers/view/{id?}', 'uses' => 'Accounts\CustomersController@show'])->middleware('permissions:CUSTOMERS_SECTION');

	


	/**
	 * Journal Entry
	 */

	Route::get('accounting/journal', ['as' => 'accounting/journal', 'uses' => 'Accounts\JournalsController@index'])->middleware('permissions:EXPENSES');

	Route::get('accounting/journal/add', ['as' => 'accounting/journal/add', 'uses' => 'Accounts\JournalsController@create'])->middleware('permissions:EXPENSES');

	Route::post('accounting/journal/save', ['as' => 'accounting/journal/save', 'uses' => 'Accounts\JournalsController@store'])->middleware('permissions:CUSTOMERS_SECTION');

	Route::get('accounting/journal/edit/{id?}', ['as' => 'accounting/journal/edit/{id?}', 'uses' => 'Accounts\JournalsController@edit'])->middleware('permissions:EXPENSES');

	Route::post('accounting/journal/save/{id?}', ['as' => 'accounting/journal/save/{id?}', 'uses' => 'Accounts\JournalsController@update'])->middleware('permissions:EXPENSES');

	Route::get('accounting/journal/detail/{id?}', ['as' => 'accounting/journal/detail/{id?}', 'uses' => 'Accounts\JournalsController@show'])->middleware('permissions:EXPENSES');

	Route::get('/reports/expense', ['as' => '/reports/expense', 'uses' => 'Accounts\JournalsReportsController@index'])->middleware('permissions:EXPENSES');

	Route::post('/reports/expense', ['as' => '/reports/expense', 'uses' => 'Accounts\JournalsReportsController@getExpenseReport'])->middleware('permissions:EXPENSES');



	/**
	 * Payment Vouchers
	 */

	Route::get('accounting/payments/received', ['as' => 'accounting/payments/received', 'uses' => 'Accounts\PaymentsReceivedController@index'])->middleware('permissions:EXPENSES');

	Route::get('accounting/payments/received/add', ['as' => 'accounting/payments/received/add', 'uses' => 'Accounts\PaymentsReceivedController@create'])->middleware('permissions:EXPENSES');

	Route::post('accounting/payments/received/add', ['as' => 'accounting/payments/received/add', 'uses' => 'Accounts\PaymentsReceivedController@store'])->middleware('permissions:EXPENSES');
	
	Route::get('accounting/payments/received/detail/{id?}', ['as' => 'accounting/payments/received/detail/{id?}', 'uses' => 'Accounts\PaymentsReceivedController@show'])->middleware('permissions:EXPENSES');

	Route::get('accounting/payments/received/edit/{id?}', ['as' => 'accounting/payments/received/edit/{id?}', 'uses' => 'Accounts\PaymentsReceivedController@edit'])->middleware('permissions:EXPENSES');

	Route::post('accounting/payments/received/edit/{id?}', ['as' => 'accounting/payments/received/edit/{id?}', 'uses' => 'Accounts\PaymentsReceivedController@update'])->middleware('permissions:EXPENSES');
	


	Route::get('accounting/payments/send', ['as' => 'accounting/payments/send', 'uses' => 'Accounts\PaymentsSendController@index'])->middleware('permissions:EXPENSES');

	Route::get('accounting/payments/send/add', ['as' => 'accounting/payments/send/add', 'uses' => 'Accounts\PaymentsSendController@create'])->middleware('permissions:EXPENSES');

	Route::post('accounting/payments/send/add', ['as' => 'accounting/payments/send/add', 'uses' => 'Accounts\PaymentsSendController@store'])->middleware('permissions:EXPENSES');
	
	Route::get('accounting/payments/send/detail/{id?}', ['as' => 'accounting/payments/send/detail/{id?}', 'uses' => 'Accounts\PaymentsSendController@show'])->middleware('permissions:EXPENSES');

	Route::get('accounting/payments/send/edit/{id?}', ['as' => 'accounting/payments/send/edit/{id?}', 'uses' => 'Accounts\PaymentsSendController@edit'])->middleware('permissions:EXPENSES');

	Route::post('accounting/payments/send/edit/{id?}', ['as' => 'accounting/payments/send/edit/{id?}', 'uses' => 'Accounts\PaymentsSendController@update'])->middleware('permissions:EXPENSES');

	/**
	 * Interbank Trans
	 */

	Route::get('accounting/interbank', ['as' => 'accounting/interbank', 'uses' => 'Accounts\InterbankController@index'])->middleware('permissions:FINANCE');

	Route::get('accounting/interbank/add', ['as' => 'accounting/interbank/add', 'uses' => 'Accounts\InterbankController@create'])->middleware('permissions:FINANCE');

	Route::post('accounting/interbank/save', ['as' => 'accounting/interbank/save', 'uses' => 'Accounts\InterbankController@store'])->middleware('permissions:FINANCE');

	Route::get('accounting/interbank/edit/{id?}', ['as' => 'accounting/interbank/edit/{id?}', 'uses' => 'Accounts\InterbankController@edit'])->middleware('permissions:FINANCE');

	Route::post('accounting/interbank/update/{id?}', ['as' => 'accounting/interbank/update', 'uses' => 'Accounts\InterbankController@update'])->middleware('permissions:FINANCE');

	Route::get('accounting/interbank/detail/{id?}', ['as' => 'accounting/interbank/detail/{id?}', 'uses' => 'Accounts\InterbankController@show'])->middleware('permissions:EXPENSES');

	/**
	 * Sales
	 */

	Route::get('accounting/sales', ['as' => 'accounting/sales', 'uses' => 'Accounts\SalesController@index'])->middleware('permissions:SALES');

	Route::get('accounting/sales/add', ['as' => 'accounting/sales/add', 'uses' => 'Accounts\SalesController@create'])->middleware('permissions:SALES');

	Route::post('accounting/sales/save', ['as' => 'accounting/sales/save', 'uses' => 'Accounts\SalesController@store'])->middleware('permissions:SALES');

	Route::get('accounting/sales/edit/{id?}', ['as' => 'accounting/sales/edit/{id?}', 'uses' => 'Accounts\SalesController@edit'])->middleware('permissions:SALES');

	Route::post('accounting/sales/edit/{id?}', ['as' => 'accounting/sales/edit/{id?}', 'uses' => 'Accounts\SalesController@update'])->middleware('permissions:SALES');

	Route::get('accounting/sales/remove/{id?}', ['as' => 'accounting/sales/remove/{id?}', 'uses' => 'Accounts\SalesController@destroy'])->middleware('permissions:SALES');

	Route::get('accounting/sales/detail/{id?}', ['as' => 'accounting/sales/detail/{id?}', 'uses' => 'Accounts\SalesController@show'])->middleware('permissions:SALES');

	Route::get('accounting/sales/modal/{id?}', ['as' => 'accounting/sales/modal/{id?}', 'uses' => 'Accounts\SalesController@payment_modal'])->middleware('permissions:SALES');

	Route::post('accounting/sales/payment', ['as' => 'accounting/sales/payment', 'uses' => 'Accounts\SalesController@ajax'])->middleware('permissions:SALES');


	Route::get('accounting/sales/mail/{id?}/{type?}', ['as' => 'accounting/sales/mail/{id?}/{type?}', 'uses' => 'Accounts\SalesController@invoice_modal'])->middleware('permissions:SALES');


	Route::post('accounting/sales/do-mail', ['as' => 'accounting/sales/do-mail', 'uses' => 'Accounts\SalesController@send'])->middleware('permissions:SALES');


	/**
	 * Sales reports routes
	 */

	Route::get('/reports/sales', ['as' => '/reports/sales', 'uses' => 'Accounts\SalesReportsController@index'])->middleware('permissions:SALE_REPORTS');

	Route::post('/reports/sales', ['as' => '/reports/sales', 'uses' => 'Accounts\SalesReportsController@getSalesReport'])->middleware('permissions:SALE_REPORTS');
	
	Route::get('/reports/sales-payments', ['as' => '/reports/sales-payments', 'uses' => 'Accounts\SalesReportsController@paymentReport'])->middleware('permissions:SALE_REPORTS');

	Route::post('/reports/sales-payments', ['as' => '/reports/sales-payments', 'uses' => 'Accounts\SalesReportsController@getPaymentReport'])->middleware('permissions:SALE_REPORTS');
	
	Route::get('/reports/sales-balance', ['as' => '/reports/sales-balance', 'uses' => 'Accounts\SalesReportsController@paymentBalance'])->middleware('permissions:SALE_REPORTS');

	Route::post('/reports/sales-balance', ['as' => '/reports/sales-balance', 'uses' => 'Accounts\SalesReportsController@paymentBalanceReport'])->middleware('permissions:SALE_REPORTS');


	Route::get('/reports/sales/export/', ['as' => '/reports/sales/export/', 'uses' => 'Accounts\SalesReportsController@export'])->middleware('permissions:SALE_REPORTS');

	/**
	 * Vendors
	 */

	Route::get('accounting/vendors', ['as' => 'accounting/vendors', 'uses' => 'Accounts\VendorsController@index'])->middleware('permissions:VENDORS_SECTION');
	
	Route::get('accounting/vendors/add', ['as' => 'accounting/vendors/add', 'uses' => 'Accounts\VendorsController@create'])->middleware('permissions:VENDORS_SECTION');

	Route::post('accounting/vendors/save', ['as' => 'accounting/vendors/save', 'uses' => 'Accounts\VendorsController@store'])->middleware('permissions:VENDORS_SECTION');

	Route::get('accounting/vendors/edit/{id?}', ['as' => 'accounting/vendors/edit/{id?}', 'uses' => 'Accounts\VendorsController@edit'])->middleware('permissions:VENDORS_SECTION');

	Route::post('accounting/vendors/edit/{id?}', ['as' => 'accounting/vendors/edit/{id?}', 'uses' => 'Accounts\VendorsController@update'])->middleware('permissions:VENDORS_SECTION');

	Route::get('accounting/vendors/remove/{id?}', ['as' => 'accounting/vendors/remove/{id?}', 'uses' => 'Accounts\VendorsController@destroy'])->middleware('permissions:VENDORS_SECTION');

	Route::get('accounting/vendors/view/{id?}', ['as' => 'accounting/vendors/view/{id?}', 'uses' => 'Accounts\VendorsController@show'])->middleware('permissions:VENDORS_SECTION');


	/**
	 * Purchase
	 */

	Route::get('accounting/purchase', ['as' => 'accounting/purchase', 'uses' => 'Accounts\PurchaseController@index'])->middleware('permissions:PURCHASE');

	Route::get('accounting/purchase/add', ['as' => 'accounting/purchase/add', 'uses' => 'Accounts\PurchaseController@create'])->middleware('permissions:PURCHASE');

	Route::post('accounting/purchase/save', ['as' => 'accounting/purchase/save', 'uses' => 'Accounts\PurchaseController@store'])->middleware('permissions:PURCHASE');

	Route::get('accounting/purchase/edit/{id?}', ['as' => 'accounting/purchase/edit/{id?}', 'uses' => 'Accounts\PurchaseController@edit'])->middleware('permissions:PURCHASE');

	Route::post('accounting/purchase/edit/{id?}', ['as' => 'accounting/purchase/edit/{id?}', 'uses' => 'Accounts\PurchaseController@update'])->middleware('permissions:PURCHASE');

	// Route::get('accounting/sales/remove/{id?}', ['as' => 'accounting/sales/remove/{id?}', 'uses' => 'Accounts\SalesController@destroy']);

	Route::get('accounting/purchase/detail/{id?}', ['as' => 'accounting/purchase/detail/{id?}', 'uses' => 'Accounts\PurchaseController@show'])->middleware('permissions:PURCHASE');

	Route::get('accounting/purchase/modal/{id?}', ['as' => 'accounting/purchase/modal/{id?}', 'uses' => 'Accounts\PurchaseController@payment_modal'])->middleware('permissions:PURCHASE');

	Route::post('accounting/purchase/payment', ['as' => 'accounting/purchase/payment', 'uses' => 'Accounts\PurchaseController@ajax'])->middleware('permissions:PURCHASE');

	Route::get('accounting/purchase/mail/{id?}/{type?}', ['as' => 'accounting/purchase/mail/{id?}/{type?}', 'uses' => 'Accounts\PurchaseController@invoice_modal'])->middleware('permissions:PURCHASE');

	Route::post('accounting/purchase/do-mail', ['as' => 'accounting/purchase/do-mail', 'uses' => 'Accounts\PurchaseController@send'])->middleware('permissions:PURCHASE');

	/**
	 * Purchase Reports Route
	 */
	Route::get('/reports/purchase', ['as' => '/reports/purchase', 'uses' => 'Accounts\PurchaseReportsController@index'])->middleware('permissions:PURCHASE_REPORTS');

	Route::post('/reports/purchase', ['as' => '/reports/purchase', 'uses' => 'Accounts\PurchaseReportsController@getPurchaseReport'])->middleware('permissions:PURCHASE_REPORTS');

	Route::get('/reports/purchase-payments', ['as' => '/reports/purchase-payments', 'uses' => 'Accounts\PurchaseReportsController@paymentReport'])->middleware('permissions:PURCHASE_REPORTS');

	Route::post('/reports/purchase-payments', ['as' => '/reports/purchase-payments', 'uses' => 'Accounts\PurchaseReportsController@getPaymentReport'])->middleware('permissions:PURCHASE_REPORTS');
	
	Route::get('/reports/purchase-balance', ['as' => '/reports/purchase-balance', 'uses' => 'Accounts\PurchaseReportsController@paymentBalance'])->middleware('permissions:PURCHASE_REPORTS');

	Route::post('/reports/purchase-balance', ['as' => '/reports/purchase-balance', 'uses' => 'Accounts\PurchaseReportsController@paymentBalanceReport'])->middleware('permissions:PURCHASE_REPORTS');


	Route::get('/reports/purchase/export/', ['as' => '/reports/purchase/export/', 'uses' => 'Accounts\PurchaseReportsController@export'])->middleware('permissions:PURCHASE_REPORTS');


	/**
	 * Accounting Routes
	 */


	/* Setting	*/
	Route::get('/setting', ['as' => '/setting', 'uses' => 'Admin\SettingsController@index'])->middleware('permissions:SETTING');

	Route::post('/setting', ['as' => 'admin/setting', 'uses' => 'Admin\SettingsController@update'])->middleware('permissions:SETTING');


	Route::post('/setting/logo', ['as' => '/setting/logo', 'uses' => 'Admin\SettingsController@ajax'])->middleware('permissions:SETTING');


	/* Email Templates	*/
	Route::get('/email/templates', ['as' => 'admin/email/templates', 'uses' => 'Admin\EmailTemplatesController@index'])->middleware('permissions:EMAIL_TEMPLATES');

	Route::get('/email/templates/edit/{id?}', ['as' => 'admin/email/templates/edit/{id?}', 'uses' => 'Admin\EmailTemplatesController@edit'])->middleware('permissions:EMAIL_TEMPLATES');

	Route::post('/email/templates/save/{id?}', ['as' => 'admin/email/templates/save/{id?}', 'uses' => 'Admin\EmailTemplatesController@update'])->middleware('permissions:EMAIL_TEMPLATES');

	/**
	 * Leave request
	 */

	Route::get('/leave-request', ['as' => '/leave-request', 'uses' => 'Employees\EmployeesLeavesController@index'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::get('/leave-request/create', ['as' => '/leave-request/create', 'uses' => 'Employees\EmployeesLeavesController@create'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::post('/leave-request/store', ['as' => '/leave-request/store', 'uses' => 'Employees\EmployeesLeavesController@store'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::get('/leave-request/edit/{id?}', ['as' => '/leave-request/edit/{id?}', 'uses' => 'Employees\EmployeesLeavesController@edit'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::post('/leave-request/update/{id?}', ['as' => '/leave-request/update/{id?}', 'uses' => 'Employees\EmployeesLeavesController@update'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::get('/leave-request/remove/{id?}', ['as' => '/leave-request/remove/{id?}', 'uses' => 'Employees\EmployeesLeavesController@destroy'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	Route::get('/leave-request/view/{id?}', ['as' => '/leave-request/view/{id?}', 'uses' => 'Employees\EmployeesLeavesController@show'])->middleware('permissions:MANAGE_APPLY_LEAVES');

	/**
	 * Loan request
	 */

	Route::get('/loan-request', ['as' => '/laon-request', 'uses' => 'Employees\EmployeesLoansRequest@index'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::get('/loan-request/create', ['as' => '/laon-request/create', 'uses' => 'Employees\EmployeesLoansRequest@create'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::post('/loan-request/store', ['as' => '/loan-request/store', 'uses' => 'Employees\EmployeesLoansRequest@store'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::get('/loan-request/edit/{id?}', ['as' => '/laon-request/edit/{id?}', 'uses' => 'Employees\EmployeesLoansRequest@edit'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::post('/loan-request/update/{id?}', ['as' => '/laon-request/update/{id?}', 'uses' => 'Employees\EmployeesLoansRequest@update'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::get('/loan-request/remove/{id?}', ['as' => '/laon-request/remove/{id?}', 'uses' => 'Employees\EmployeesLoansRequest@destroy'])->middleware('permissions:MANAGE_APPLY_LOAN');

	Route::get('/loan-request/view/{id?}', ['as' => '/loan-request/view/{id?}', 'uses' => 'Employees\EmployeesLoansRequest@show'])->middleware('permissions:MANAGE_APPLY_LOAN');
	

	Route::get('/attendance/view/{status?}', ['as' => '/attendance/view/{status?}', 'uses' => 'Employees\EmployeesAttendanceController@viewModal']);

	Route::any('/attendance/timein', ['as' => '/attendance/timein', 'uses' => 'Employees\EmployeesAttendanceController@create']);

	Route::any('/attendance/timeout', ['as' => '/attendance/timeout', 'uses' => 'Employees\EmployeesAttendanceController@update']);


	Route::get('/notification/show/{id?}', ['as' => '/notification/show/{id?}', 'uses' => 'Employees\EmployeesNotifications@show']);

Route::get('employee/ledger', ['as' => 'employee/ledger', 'uses' => 'Employees\EmployeesAttendanceController@ledger']);

	
	Route::get('accounting/items', ['as' => 'accounting/items', 'uses' => 'Accounts\ItemsController@index']);

	Route::get('accounting/items/add', ['as' => 'accounting/items/add', 'uses' => 'Accounts\ItemsController@create']);

	Route::post('accounting/items/add', ['as' => 'accounting/items/add', 'uses' => 'Accounts\ItemsController@store']);

	Route::get('accounting/items/edit/{id?}', ['as' => 'accounting/items/edit', 'uses' => 'Accounts\ItemsController@edit']);

	Route::post('accounting/items/edit/{id?}', ['as' => 'accounting/items/edit', 'uses' => 'Accounts\ItemsController@update']);

	Route::get('accounting/items/delete/{id?}', ['as' => 'accounting/items/delete', 'uses' => 'Accounts\ItemsController@destroy']);


	Route::post('accounting/items/ajax-price', ['as' => 'accounting/items/ajax-price', 'uses' => 'Accounts\ItemsController@ajax_price']);
	
	Route::post('accounting/sales/vat-price', ['as' => 'accounting/sales/vat-price', 'uses' => 'Accounts\SalesController@vat_price']);

	Route::get('accounting/tax', ['as' => 'accounting/tax', 'uses' => 'Accounts\TaxController@index']);

	Route::get('accounting/tax/add', ['as' => 'accounting/tax/add', 'uses' => 'Accounts\TaxController@create']);

	Route::post('accounting/tax/add', ['as' => 'accounting/tax/add', 'uses' => 'Accounts\TaxController@store']);

	Route::get('accounting/tax/edit/{id?}', ['as' => 'accounting/tax/edit', 'uses' => 'Accounts\TaxController@edit']);

	Route::post('accounting/tax/edit/{id?}', ['as' => 'accounting/tax/edit', 'uses' => 'Accounts\TaxController@update']);

	Route::get('accounting/tax/remove/{id?}', ['as' => 'accounting/tax/remove', 'uses' => 'Accounts\TaxController@destroy']);


	
	/* Logout Route */
	Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
});


Route::get('view/sales/invoice/{type?}', ['as' => 'view/sales/invoice/{type?}', 'uses' => 'Accounts\SalesController@show_invoice']);

Route::get('view/purchase/invoice/{type?}', ['as' => 'view/purchase/invoice/{type?}', 'uses' => 'Accounts\PurchaseController@show_invoice']);


Route::get('install', ['as' => 'install', 'uses' => 'Installer\InstallerController@index']);
Route::post('install', ['as' => 'install', 'uses' => 'Installer\InstallerController@index']);