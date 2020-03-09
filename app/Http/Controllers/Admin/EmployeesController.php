<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesLoansStatements;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Admin\EmployeesWorkExperience;
use App\Http\Models\Admin\EmployeesQualification;
use App\Http\Models\Employees\EmployeesLedger;
use App\Http\Models\Accounts\AccountsChart;
use App\Jobs\SendEmployeesEmailJob;
use App\Http\Models\Auth\AuthRole;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use App\Libraries\Employeelib;
use App\Libraries\Customlib;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;
use Auth;
use DB;

class EmployeesController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->employee = new Employeelib();
        $this->custom = new Customlib();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $match_department = [];
            $match_role = [];
            $department_id = \Request::get('department');
            $role_id = \Request::get('role');
            $data['per_page'] = \Request::get('per_page') ?: 12;
            
            $default =  Auth::guard('auth')->user()->roles->default;
            $user_id = Auth::guard('auth')->user()->id;

            $employees = Employees::query();
            if(isset($department_id) && $department_id <> ""){
                $employees->where('department_id', $department_id);
            }

            if(isset($role_id) && $role_id <> ""){
                $employees->where('role', $role_id);
            }

            if(isset($default) && $default <> 1){
                $employees->where('create_by', $user_id);
            }

            $employees = $employees->where('role', '!=', '1')->paginate($data['per_page']);
            if(isset($employees) && count($employees) > 0)
            {
                $present_status = '';
                foreach($employees as $employee)
                {

                    $present = $this->isPresent($employee->id);
                    $present_status = ($present == 1) ? '<span class="present">P</span>' : '<span class="absent">A</span>';

                    $data['employees'][] = [
                        'id' => $employee->id,
                        'name' => $employee->first_name.' '.$employee->last_name,
                        'status' => $employee->status,
                        'avatar' => $employee->avatar,
                        'email' => $employee->email,
                        'designation' => $employee->designation->title,
                        'department' => $employee->department->title,
                        'salary' => $employee->sum_salary(),
                        'present_status' => $present_status,

                    ];
                }
            }

            $total_loans = Employees::with(
            ['loan_statements' => function($query){ 
                $query->select('employee_id', DB::raw('SUM(withdraw) As tlt_withdraw'), DB::raw('SUM(deposit) As tlt_deposit'));
                $query->groupBy('employee_id');
            }])
            ->select('id')->get()->toArray();

            if(isset($total_loans)){
                foreach($total_loans as $loan){

                    $data['tlt_loan'][$loan['id']] = array(
                        'tlt_balance' => number_format(($loan['loan_statements']['tlt_withdraw']) - ($loan['loan_statements']['tlt_deposit']), 2)
                    );
                   
                }
            }


            $data['pages'] = $employees->appends(\Input::except('page'))->render();
            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();
            $data['roles'] = DB::table('tbl_employees_roles')->select('id', 'title')->get();


            return view('admin.employees.manage', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function isPresent($employee_id = '')
    {
        try {
            if(isset($employee_id) && $employee_id <> "")
            {
                
                $present = EmployeesAttendance::where('employee_id', $employee_id)
                ->whereRaw('Date(in_time) = CURDATE()')
                ->count();

                if(isset($present) && $present > 0)
                {
                    return true;
                }

                return false;
            }

            return false;
        } catch (ModelNotFoundException $e) {
            
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {

            $data['months'] = [
                '01' => 'Jan', 
                '02' => 'Feb', 
                '03' => 'Mar', 
                '04' => 'Apr', 
                '05' => 'May', 
                '06' => 'Jun', 
                '07' => 'Jul', 
                '08' => 'Aug', 
                '09' => 'Sep', 
                '10' => 'Oct', 
                '11' => 'Nov', 
                '12' => 'Dec'
            ];

            $data['maritals'] = DB::table('tbl_maritals')->select('id','title')->get();
            $data['genders'] = DB::table('tbl_gender')->select('id','title')->get();
            $data['designations'] = DB::table('tbl_designations')->select('id','title')->where('status', '1')->get();
            $data['shifts'] = DB::table('tbl_shift')->where('status', '1')->select('id','title')->get();
            $data['types'] = DB::table('tbl_employees_type')->select('id','title')->get();
            $data['salaries'] = DB::table('tbl_employees_salary_type')->select('id', 'title')->get();
            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();
            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();

            $account = AccountsChart::orWhere('type_id', '11')
                ->orWhere('type_id', '10')
                ->orWhere('type_id', '5')
                ->orderBy('code', 'DESC')
                ->first();

            $data['code'] = '';
            if(isset($account) && count($account) > 0)
            {
                $account_code = $account->code+1;
                $data['code'] = '0'.$account_code;
            }

            $data['roles'] = AuthRole::where('default', '=', '0')->get();
            return view('admin.employees.create', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:tbl_employees',
                'employee_code' => 'required|unique:tbl_employees',
                'email' => 'required|email|unique:tbl_employees',
                'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'department_id' => 'required',
                'designation_id' => 'required',
                'shift_id' => 'required',
                'employee_type' => 'required',
                'salary_type' => 'required',
                'basic_salary' => 'required',
                'group' => 'required',
                'status' => 'required',
                'avatar' => 'mimes:jpeg,png,jpg,gif'
            ]);

          
            $create_by = Auth::guard('auth')->user()->id;
            $create_ip = $request->ip();

            $remember_token = str_random(60);
            $employee_code = $request->input('employee_code');

            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $username = $request->input('username');
            $password = $request->input('password');
            $email = $request->input('email');
            $national_id = $request->input('national_id');

            $nationality = $request->input('nationality');
            $fathers_name = $request->input('fathers_name');
            $mothers_name = $request->input('mothers_name');
            $gender = $request->input('gender');
            $maritial_status = $request->input('marital_status');
            $phone = $request->input('phone');
            $mobile = $request->input('mobile');

            /**
             * Convert to MYSQL Date
             */

            $dob_year = $request->input('dob_year');
            $dob_month = $request->input('dob_month');
            $dob_day = $request->input('dob_day');

            $dob = $dob_year.'-'.$dob_month.'-'.$dob_day;

            $joining_year = $request->input('joining_year');
            $joining_month = $request->input('joining_month');
            $joining_day = $request->input('joining_day');
            $joining_date = $joining_year.'-'.$joining_month.'-'.$joining_day;
            
            $department_id = $request->input('department_id');
            $designation_id = $request->input('designation_id');
            $shift_id = $request->input('shift_id');
            $employee_type = $request->input('employee_type');
            $reference = $request->input('reference');

            $present_address = $request->input('present_address');
            $permanant_address = $request->input('permanant_address');
            $group = $request->input('group');
            $status = $request->input('status');

            $salary_type = $request->input('salary_type');
            $basic_salary = $request->input('basic_salary');
            $accommodation_allowance = $request->input('accommodation_allowance');
            $medical_allowance = $request->input('medical_allowance');
            $living_allowance = $request->input('living_allowance');
            $transportation_allowance = $request->input('transportation_allowance');
            $food_allowance = $request->input('food_allowance');

            $overtime_1 = $request->input('overtime_1');
            $overtime_2 = $request->input('overtime_2');
            $overtime_3 = $request->input('overtime_3');

            $degrees = $request->input('degree');
            $job_title = $request->input('job_title');

            $avatar = $request->file('avatar');

            $allowed_leaves = $request->input('allowed_leaves');

            $employee = new Employees;

            $employee->employee_code = $employee_code;
            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->fathers_name = $fathers_name;
            $employee->mothers_name = $mothers_name;

            $employee->username = $username;
            $employee->password = bcrypt($password);
            $employee->email = $email;
            $employee->gender = $gender;
            //$employee->maritial_status = $maritial_status;
            $employee->national_id = $national_id;
            $employee->nationality = $nationality;
            $employee->present_address = $present_address;
            $employee->permanant_address = $permanant_address;
            $employee->mobile_no = $mobile;
            $employee->phone_no = $phone;
            $employee->date_of_birth = $dob;
            $employee->joining_date = $joining_date;
            $employee->department_id = $department_id;
            $employee->designation_id = $designation_id;
            $employee->shift_id = $shift_id;
            $employee->employee_type = $employee_type;
            $employee->role = $group;
            $employee->allowed_leaves = $allowed_leaves;


            $employee->salary_type = $salary_type;
            $employee->basic_salary = $basic_salary;
            $employee->accomodation_allowance = $accommodation_allowance;
            $employee->medical_allowance = $medical_allowance;
            $employee->house_rent_allowance = $living_allowance;
            $employee->transportation_allowance = $transportation_allowance;
            $employee->food_allowance = $food_allowance;

            $employee->overtime_1 = $overtime_1;
            $employee->overtime_2 = $overtime_2;
            $employee->overtime_3 = $overtime_3;

            $employee->avatar = '';

            /**
             * Store Avatar
             */

          

            $employee->status = $status;
            $employee->reference = $reference;
            $employee->remember_token = $remember_token;
            $employee->create_by = $create_by;
            $employee->create_ip = $create_ip;

            $employee->save();

            $insertedId = $employee->id;
           
            if($insertedId){

                /**
                 * Insert Qualification Record
                 * @var array
                 */
                if(isset($degrees[0]) && count($degrees[0]) > 0){

                    //$employee->employeesq()->detach();
                    $qData = [];

                    foreach($degrees as $key=>$value)
                    {

                        $degree = $request->input('degree')[$key];
                        $year = $request->input('year')[$key];
                        $total_marks = $request->input('total_marks')[$key];
                        $obtain_marks = $request->input('obtain_marks')[$key];
                        $grade = $request->input('grade')[$key];
                        $institute = $request->input('institute')[$key];
                        $institute_country = $request->input('institute_country')[$key];

                        if($degree <> ""){
                            $qData[] = array(
                                'employee_id' => $employee->id,
                                'degree_name' => $degree,
                                'year' => $year,
                                'total_marks' => $total_marks,
                                'obtain_marks' => $obtain_marks,
                                'grade' => $grade,
                                'institute' => $institute,
                                'institute_country' => $institute_country
                            );
                        }
          
                    }

                   EmployeesQualification::insert($qData);

                }

                /**
                 * Insert Work Experience Record
                 * @var array
                 */
                if(isset($job_title[0]) && count($job_title[0]) > 0){

                    $work = new EmployeesWorkExperience;

                    $wData = [];
                    $end_date = NULL;
                    foreach($job_title as $key=>$value){

                        $job_title = $request->input('job_title')[$key];
                        $company_name = $request->input('company_name')[$key];
                        $location_country = $request->input('location_country')[$key];
                        $location_city = $request->input('location_city')[$key];
                        
                        $start_month = $request->input('start_month')[$key];
                        $start_year = $request->input('start_year')[$key];
                        $start_date = $start_year.'-'.$start_month.'-'.'01';

                        $end_year = isset($request->input('end_year')[$key]) ? $request->input('end_year')[$key] : '';

                        $end_month = isset($request->input('end_month')[$key]) ? $request->input('end_month')[$key] : '';

                        if($end_year=="" || $end_month==""){
                            $curWorkingExp = 1;
                        }else{
                            $end_date = $end_year.'-'.$end_month.'-'.'01';
                            $curWorkingExp = 0;
                        }

                        if($job_title <> ""){

                            $wData[] = [
                                'employee_id' => $employee->id,
                                'job_title' => $job_title,
                                'company_name' => $company_name,
                                'city_name' => $location_city,
                                'country_id' => $location_country,
                                'start_date' => $start_date,
                                'current_status' => $curWorkingExp,
                                'end_date' => $end_date,
                                
                            ];
                        }

                    }

                    EmployeesWorkExperience::insert($wData);

                }


                $account = new AccountsChart;
                $account->code = $employee_code;
                $account->name = $first_name.' '.$last_name;
                $account->type_id = '11';
                $account->opening_balance = '0';
                $account->balance_type = 'cr';
                $account->is_systemize = '0';
                $account->save();

                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {
                    $template = $this->custom->getTemplate(1);

                    if(isset($template['status']) && $template['status'] == 1)
                    {

                        $dd = [
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'username' => $username,
                            'password' => $password,
                            'email' => $email,
                            'employee_id' => $insertedId
                        ];


                        $job = (new SendEmployeesEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                        dispatch($job);
                    }
                    

                    

                }



                $request->session()->flash('msg', __('admin/employees.added_msg'));
                return redirect('employees/create');
            }
            
        } catch (ModelNotFoundException $e) {
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('employees');

            $data = [];

            $data['user'] = Employees::findOrFail($id);

            $user_id = $data['user']['id'];
            $data['total_received'] = $this->employee->getTotalReceivedSalary($user_id);
            $data['total_ded'] = $this->employee->getTotalDeduction($user_id);
            $data['total_loan'] = $this->employee->getTotalLoanReceived($user_id);
            $data['attendences'] = $this->employee->getAttendanceByMonth($user_id);
            $data['salaries'] = $this->employee->getSalariesByMonth($user_id);
            $data['qualifications'] = $this->employee->getQualificationByEmployee($user_id);
            $data['experiences'] = $this->employee->getWorkExperienceByEmployee($user_id);
            $data['notices'] = $this->employee->getNotices();
            $data['currency'] = $this->custom->currencyFormatSymbol();


            return view('admin.employees.view', $data);

            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(Employees $employees, $id = NULL)
    {

        try {

            if(is_null($id)){ return redirect('employees'); }

            $data['employee'] = $employees->where('role', '<>', '1')->findOrFail($id);
            $data['qualifications'] = EmployeesQualification::where('employee_id', $id)->get();
            $data['works'] = EmployeesWorkExperience::where('employee_id', $id)->get();

            $data['maritals'] = DB::table('tbl_maritals')->select('id','title')->get();
            $data['genders'] = DB::table('tbl_gender')->select('id','title')->get();
            $data['designations'] = DB::table('tbl_designations')->select('id','title')->where('status', '1')->get();
            $data['shifts'] = DB::table('tbl_shift')->select('id','title')->get();
            $data['types'] = DB::table('tbl_employees_type')->select('id','title')->get();
            $data['salaries'] = DB::table('tbl_employees_salary_type')->select('id', 'title')->get();
            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();

            $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
            
            $data['roles'] = AuthRole::where('default', '0')->get();

            $data['months'] = [
                '01' => 'Jan', 
                '02' => 'Feb', 
                '03' => 'Mar', 
                '04' => 'Apr', 
                '05' => 'May', 
                '06' => 'Jun', 
                '07' => 'Jul', 
                '08' => 'Aug', 
                '09' => 'Sep', 
                '10' => 'Oct', 
                '11' => 'Nov', 
                '12' => 'Dec'
            ];

            return view('admin.employees.edit', $data);

        } catch (ModelNotFoundException $e) {
            return redirect('employees');
        }
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employees, $id = NULL)
    {
        try {

            if(is_null($id)){ return redirect('employees'); }

            /**
             * The employee find
             * @var int
             * @return array
             */
            $employee = $employees->where('role', '<>', '1')->findOrFail($id);

            /**
             * The validate rules
             */
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:tbl_employees,email,'.$employee->id,
                'department_id' => 'required',
                'designation_id' => 'required',
                'shift_id' => 'required',
                'employee_type' => 'required',
                'salary_type' => 'required',
                'basic_salary' => 'required',
                'group' => 'required',
                'status' => 'required',
                'avatar' => 'mimes:jpeg,png,jpg,gif'
            ];
            

            if($request->input('password')){
                $rules['password'] = '|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
            }

            $this->validate($request, $rules);

            $create_by = Auth::guard('auth')->user()->id;
            $create_ip = $request->ip();

            $remember_token = str_random(60);
            $employee_code = $request->input('employee_code');

            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $password = $request->input('password');
            $password_confirmation = $request->input('password_confirmation');
            $email = $request->input('email');
            $national_id = $request->input('national_id');
            $fathers_name = $request->input('fathers_name');
            $mothers_name = $request->input('mothers_name');
            $gender = $request->input('gender');
            $maritial_status = $request->input('marital_status');
            $phone = $request->input('phone');
            $mobile = $request->input('mobile');
            $allowed_leaves = $request->input('allowed_leaves');

            

            /**
             * Convert to MYSQL Date
             */
            $date_of_birth = $request->input('date_of_birth');
            $joining_date = $request->input('joining_date');

            $dob_year = $request->input('dob_year');
            $dob_month = $request->input('dob_month');
            $dob_day = $request->input('dob_day');

            $dob = $dob_year.'-'.$dob_month.'-'.$dob_day;

            $joining_year = $request->input('joining_year');
            $joining_month = $request->input('joining_month');
            $joining_day = $request->input('joining_day');
            $joining_date = $joining_year.'-'.$joining_month.'-'.$joining_day;


            $department_id = $request->input('department_id');
            $designation_id = $request->input('designation_id');
            $shift_id = $request->input('shift_id');
            $employee_type = $request->input('employee_type');
            $reference = $request->input('reference');

            $present_address = $request->input('present_address');
            $permanant_address = $request->input('permanant_address');
            $group = $request->input('group');
            $status = $request->input('status');

            $salary_type = $request->input('salary_type');
            $basic_salary = $request->input('basic_salary');
            $accommodation_allowance = $request->input('accommodation_allowance');
            $medical_allowance = $request->input('medical_allowance');
            $living_allowance = $request->input('living_allowance');
            $transportation_allowance = $request->input('transportation_allowance');
            $food_allowance = $request->input('food_allowance');

            $overtime_1 = $request->input('overtime_1');
            $overtime_2 = $request->input('overtime_2');
            $overtime_3 = $request->input('overtime_3');

            $degrees = $request->input('degree');
            $job_title = $request->input('job_title');

            $avatar = $request->file('avatar');

            $employee->employee_code = $employee_code;
            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->fathers_name = $fathers_name;
            $employee->mothers_name = $mothers_name;

            if($password <> ""){
                $employee->password = bcrypt($password);
            }
            
            $employee->email = $email;
            $employee->gender = $gender;
            //$employee->maritial_status = $maritial_status;
            $employee->national_id = $national_id;
            $employee->present_address = $present_address;
            $employee->permanant_address = $permanant_address;
            $employee->mobile_no = $mobile;
            $employee->phone_no = $phone;
            $employee->date_of_birth = $dob;
            $employee->joining_date = $joining_date;
            $employee->department_id = $department_id;
            $employee->designation_id = $designation_id;
            $employee->shift_id = $shift_id;
            $employee->employee_type = $employee_type;
            $employee->role = $group;
            $employee->allowed_leaves = $allowed_leaves;

            $employee->salary_type = $salary_type;
            $employee->basic_salary = $basic_salary;
            $employee->accomodation_allowance = $accommodation_allowance;
            $employee->medical_allowance = $medical_allowance;
            $employee->house_rent_allowance = $living_allowance;
            $employee->transportation_allowance = $transportation_allowance;
            $employee->food_allowance = $food_allowance;

            $employee->overtime_1 = $overtime_1;
            $employee->overtime_2 = $overtime_2;
            $employee->overtime_3 = $overtime_3;

            /**
             * Store Avatar
             */
            if($avatar){

                // Avatar Remove
                Storage::delete('avatar/employees/'.$employee->image);

                $file_extension = $avatar->getClientOriginalExtension();
                $destinationPath = storage_path().'/app/avatar/employees/';
                $filename = 'avatar_'.date('Y-m-d H:i:s', time()).'.'.$file_extension;
                $avatar->save($destinationPath, $filename);

                $employee->avatar = $filename;
            }

            $employee->status = $status;
            $employee->reference = $reference;
            $employee->remember_token = $remember_token;
            $employee->create_by = $create_by;
            $employee->create_ip = $create_ip;

            $employee->save();

            if($employee->id){


                /**
                 * Insert Qualification Record
                 * @var array
                 */
                if(count($degrees) > 0){

                    $employee->employeesq()->detach();
                    $qData = [];

                    foreach($degrees as $key=>$value)
                    {

                        $degree = $request->input('degree')[$key];
                        $year = $request->input('year')[$key];
                        $total_marks = $request->input('total_marks')[$key];
                        $obtain_marks = $request->input('obtain_marks')[$key];
                        $grade = $request->input('grade')[$key];
                        $institute = $request->input('institute')[$key];
                        $institute_country = $request->input('institute_country')[$key];
                        

                        if($degree <> ""){
                            $qData[] = array(
                                'employee_id' => $employee->id,
                                'degree_name' => $degree,
                                'year' => $year,
                                'total_marks' => $total_marks,
                                'obtain_marks' => $obtain_marks,
                                'grade' => $grade,
                                'institute' => $institute,
                                'institute_country' => $institute_country
                            );
                        }
          
                    }

                   EmployeesQualification::insert($qData);

                }

                /**
                 * Insert Work Experience
                 * @var array
                 */
                if(count($job_title) > 0){

                    $end_date = NULL;

                    $employee->employees_work()->detach();

                    $work = new EmployeesWorkExperience;

                    $wData = [];
                    foreach($job_title as $key=>$value){

                        $job_title = $request->input('job_title')[$key];
                        $company_name = $request->input('company_name')[$key];
                        $location_country = $request->input('location_country')[$key];
                        $location_city = $request->input('location_city')[$key];
                        
                        $start_month = $request->input('start_month')[$key];
                        $start_year = $request->input('start_year')[$key];
                        $start_date = $start_year.'-'.$start_month.'-'.'01';

                        $end_year = isset($request->input('end_year')[$key]) ? $request->input('end_year')[$key] : '';

                        $end_month = isset($request->input('end_month')[$key]) ? $request->input('end_month')[$key] : '';

                        if($end_year=="" || $end_month==""){
                            $curWorkingExp = 1;
                        }else{
                            $end_date = $end_year.'-'.$end_month.'-'.'01';
                            $curWorkingExp = 0;
                        }

                        
                        if($job_title <> ""){

                            $wData[] = [
                                'employee_id' => $employee->id,
                                'job_title' => $job_title,
                                'company_name' => $company_name,
                                'city_name' => $location_city,
                                'country_id' => $location_country,
                                'start_date' => $start_date,
                                'current_status' => $curWorkingExp,
                                'end_date' => $end_date,
                                
                            ];
                        }

                    }

                    EmployeesWorkExperience::insert($wData);

                }


                /**
                 * Insert to Chart of Account
                 */

                $request->session()->flash('msg', __('admin/employees.update_msg'));
                return redirect('employees/edit/'.$employee->id);
            }
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    public function ledger()
    {
        try {

            $data = [];
            $data['html'] = '';

            $data['employees'] = Employees::where('status', 1)->where('role', '!=', 1)->get();

            $data['employee_id'] = \Request::get('employee_id');
            $data['to'] = \Request::get('to');
            $data['from'] = \Request::get('from');
            $data['type'] = \Request::get('type');
            $token = \Request::get('_token');

            if(empty($token) && $token == "")
            {
                
                if((!isset($data['employee_id']) && empty($data['employee_id'])) || (!isset($data['type']) && empty($data['type'])))
                {
                    \Session::flash('error', __('admin/employees.error_ledger_fields'));
                }

                return view('admin.employees.ledger', $data);
                die;
            }
           

            $nice_to_date = Carbon::createFromFormat('m/d/Y', $data['to'])->toDateString();
            $nice_from_date = Carbon::createFromFormat('m/d/Y', $data['from'])->toDateString();
            $currency = $this->custom->currencyFormatSymbol();
            $employee = Employees::select('first_name', 'last_name')->where('id', $data['employee_id'])->first();

            $html = '';
            switch ($data['type']) {
                case '1':

                    $ledgers = EmployeesLedger::where('employee_id', $data['employee_id'])->where('date', '>=', $nice_to_date)->where('date', '<=', $nice_from_date)->get();
                    

                    $html .= '<table class="table table-striped">';

                        $html .= '<div class="col-sm-9">';
                            $html .= '<div class="reports-breads"><h2><b>'.__('admin/employees.ledger_salary_txt').'</b> <span class="filter-txt-highligh">('.$this->custom->dateformat($nice_to_date).' - '.$this->custom->dateformat($nice_to_date).') </span> '.__('admin/employees.for_search_txt').' <span class="filter-txt-highligh">('.$employee->first_name.' '.$employee->last_name.')</span></h2></div>';
                        $html .= '</div>';
                        if(isset($ledgers) && count($ledgers) > 0){

                            $html .= '<tr>';
                 
                              $html .= '<th width="">'.__('admin/common.date_txt').'</th>';
                              $html .= '<th width="">'.__('admin/employees.basic_salary_label').'</th>';
                              $html .= '<th width="" style="text-align: left;">'.__('admin/employees.deduction_txt').'</th>';
                              $html .= '<th width="" style="text-align: left;">'.__('admin/employees.generated_salary_txt').'</th>';
                              $html .= '<th width="" style="text-align: left;">'.__('admin/employees.overtime_txt').'</th>';
                              
                              $html .= '<th align="right" style="text-align: right;">'.__('admin/employees.fixed_adv_txt').'</th>';
                              $html .= '<th align="right" style="text-align: right;" style="text-align: right;">'.__('admin/employees.tmp_adv_txt').'</th>';
                              $html .= '<th align="right" style="text-align: right;" style="text-align: right;">'.__('admin/employees.net_amount_txt').'</th>';

                            $html .= '</tr>';

                            foreach($ledgers as $ledger)
                            {
                                $html .= '<tr>';
                 
                                  $html .= '<td width="">'.$this->custom->dateformat($ledger->date).'</td>';
                                  $html .= '<td width="">'.number_format($ledger->basic_pay, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" style="text-align: left;">'.number_format($ledger->deduction, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" style="text-align: left;">'.number_format($ledger->generated_pay, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" style="text-align: left;">'.number_format($ledger->overtime, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" align="right" style="text-align: right;" width="100">'.number_format($ledger->fixed_advance, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" align="right" style="text-align: right;" width="100" style="text-align: right;">'.number_format($ledger->temp_advance, 2).' '.$currency.'</td>';
                                  $html .= '<td width="" align="right" style="text-align: right;" width="100" style="text-align: right;">'.number_format($ledger->amount, 2).' '.$currency.'</td>';

                                $html .= '</tr>';
                            }



                        }else{

                            $html .= '<tr>';
                              $html .= '<th colspan="6">'.__('admin/common.notfound').'</th>';
                            $html .= '</tr>';
                        }

                    $html .= '</table>';
                break;

                case '2':


                    $html .= '<table class="table table-striped">';

                        $html .= '<div class="col-sm-9">';
                            $html .= '<div class="reports-breads"><h2><b>'.__('admin/employees.ledger_loan_txt').'</b> <span class="filter-txt-highligh">('.$this->custom->dateformat($nice_to_date).' - '.$this->custom->dateformat($nice_to_date).') </span> '.__('admin/employees.for_search_txt').' <span class="filter-txt-highligh">('.$employee->first_name.' '.$employee->last_name.')</span></h2></div>';
                        $html .= '</div>';

                            $statements = EmployeesLoansStatements::where('employee_id', $data['employee_id'])->get();
                            if(isset($statements) && count($statements) > 0)
                            {

                     
                                $html .= '<tr>';
                                  $html .= '<th width="100">'.__('admin/common.date_txt').'</th>';
                                  $html .= '<th width="" style="text-align: left;">'.__('admin/loans.description_txt').'</th>';
                                  $html .= '<th width="150" align="right" style="text-align: left;">'.__('admin/loans.deposit_amount').'</th>';
                                  $html .= '<th width="150" style="text-align: left;">'.__('admin/loans.withdraw_amount').'</th>';
                                  $html .= '<th width="150" align="right" style="text-align: right;">'.__('admin/loans.balance_amount').'</th>';
                                $html .= '</tr>';

                                $tlt = 0;
                                foreach($statements as $statement)
                                {
                                   
                                   $tlt += $statement->withdraw - $statement->deposit;


                                    $html .= '<tr>';
                                      $html .= '<th width="">'.$this->custom->dateformat($statement->datetime).'</th>';
                                      $html .= '<th width="">'.$statement->detail.'</th>';
                                      $html .= '<th width="" style="text-align: left;">'.number_format($statement->deposit, 2).' '.$currency.'</th>';
                                      $html .= '<th width="" style="text-align: left;">'.number_format($statement->withdraw, 2).' '.$currency.'</th>';
                                      $html .= '<th width="100" align="right" style="text-align: right;">'.number_format($tlt, 2).' '.$currency.'</th>';
                                    $html .= '</tr>';



                                }
                            }
                            
                            

                          

                    $html .= '</table>';
                    
                break;
                
                default:
                break;
            }

            //echo $html;
            $data['html'] = $html;
            

            return view('admin.employees.ledger', $data);
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Admin\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employees, $id = NULL)
    {

        try {

            if($id == ""){ return redirect('employees'); }
            
            /**
             * Find Employee Record
             * @var $id
             * @return array
             */
            $employee = $employees->where('role', '1')->findOrFail($id);
            if($employee)
            {
                 /**
                 * Remove realationships 
                 */
                $employee->employees_work()->detach();
                $employee->employeesq()->detach();
                $employee->delete();
            }
            session()->flash('msg', __('employees.delete_msg'));
            return redirect('employees');

        } catch (ModelNotFoundException $e) {
            return redirect('admin/employees');
        }
       
    }

}
