<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesLoansStatements;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Employees\EmployeesLedger;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Models\Admin\EmployeesSalary;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use App\Jobs\SalaryEmailJob;
use Illuminate\Http\Request;
use App\Libraries\Salarylib;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Input;
use Auth;
use DB;

class EmployeesSalaryController extends Controller
{

    public function __construct()
    {
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

            $data = [];


            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();

            return view('admin.salary.index', $data);
            
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

            $data = [];
            $data['department_id'] = '';
            $data['date'] = date('Y-m', time());

            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();
            
            return view('admin.salary.create', $data);

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
            
            $dataArray = array();

            $this->validate($request, [
                'salary_date' => 'required',
                'department_id' => 'required'
            ]);

            $input = Input::all();

            $data['date'] = $input['salary_date'];
            $data['department_id'] = $input['department_id'];
            $create_by = Auth::guard('auth')->user()->id;

            $dt = Carbon::parse($data['date']);

            $lib = new Salarylib;
            $employees = $lib->getEmployees($data['date'], $data['department_id']);

            if(isset($employees) && count($employees) > 0)
            {

                $offical_days_seconds = 0; $tlt_salary = 0; $per_hour_salary = 0;
                
                /* OFFICIAL LEAVES */
                $offical = $lib->getOfficalLeaves($data['date']);

                /* TOTAL DAYS IN MONTH */
                $days_in_month = $lib->getTotalDaysOfMonth($data['date']);

                /* TOTAL WEEKLY OFF DAYS IN MONTH */
                $weekly_off_days = $lib->getWeeklyOffDays($data['date']);


                /* EMPLOYEES LIST LOOP */
                foreach($employees as $employee)
                {

                    $total = 0;

                    /* EMPLOYEE TOTAL SALARY SUM */
                    $tlt_salary = $employee->basic_salary + $employee->accomodation_allowance + $employee->medical_allowance + $employee->house_rent_allowance + $employee->transportation_allowance + $employee->food_allowance;


                    /* EMPLOYEES DATA ARRAY */
                    $emp_data = [
                        'salary' => $tlt_salary,
                        'start_time' => strtotime($employee->shift->start_time),
                        'end_time' => strtotime($employee->shift->end_time),
                        'date' => $data['date'],
                        'employee_id' => $employee->id,
                        'allowed_leaves' => $employee->allowed_leaves,
                        'eOvertime' => $employee->overtime_1,
                        'tlt_leaves' => $employee->tlt_leaves,
                        'sql_start_time' => $employee->shift->start_time,
                        'sql_end_time' => $employee->shift->end_time
                    ];

                    $salaries = $lib->getEmployeesSalaryByAttendance($emp_data);


                    $loan_fixed_installment = $lib->getEmployeesFixedLoans($employee->id);
                    $loan_temp_installment = $lib->getEmployeesTempLoans($employee->id);
                    

                    $tlt_loan_fixed = $lib->getTltLoanFixed($employee->id);
                    $tlt_loan_temp = $lib->getTltLoanTemp($employee->id);

                    
                    $dataArray = [];
                    if(isset($salaries) && count($salaries) > 0)
                    {

                        foreach($salaries as $salary)
                        {

                            $dataArray[] = [
                                'employee_id' => $employee->id,
                                'salary_date' => $data['date'],
                                'basic_pay' => $tlt_salary,
                                'generated_pay' => $salary['basic_salary'],
                                'overtime' => $salary['overtime'],
                                'deduction' => $salary['deduction'],
                                'leave_deduction' => $salary['leaves_deduction'],
                                'fix_advance' => $loan_fixed_installment,
                                'temp_advance' => $loan_temp_installment,
                                'status' => '0',
                                'created_by' => $create_by,
                                'updated_by' => $create_by,
                                'created_at' => date('Y-m-d H:i:s', time()),
                                'updated_at' => date('Y-m-d H:i:s', time()),
                            ];
                        }

                        EmployeesSalary::insert($dataArray);
                        
                    }

                    $job = (new SalaryEmailJob($dataArray))->delay(Carbon::now()->addSeconds(10));
                    dispatch($job);
                    
                }
            }


            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();

            return \Redirect::route('/salary/show', ['id'=>$data['department_id'],'date'=>$data['date']]);

            

        } catch (ModelNotFoundException $e) {

        }

    }


    public function load($id = NULL, $date = NULL)
    {

        try {

            if(is_null($id) || is_null($date)){ return redirect('/salary/create'); }


            $data['creates'] = array();

            $data['date'] = $date;
            $data['department_id'] = $id;

            $dt = Carbon::parse($data['date']);

            $salaries = EmployeesSalary::select(
                'tbl_employees_salary.id as sid',
                'tbl_employees_salary.employee_id',
                'tbl_employees_salary.salary_date',
                'tbl_employees_salary.basic_pay',
                'tbl_employees_salary.generated_pay',
                'tbl_employees_salary.overtime',
                'tbl_employees_salary.deduction',
                'tbl_employees_salary.leave_deduction',
                'tbl_employees_salary.fix_advance',
                'tbl_employees_salary.temp_advance',
                'tbl_employees_salary.status',
                'tbl_employees.first_name',
                'tbl_employees.last_name'
            )
            ->leftJoin('tbl_employees', 'tbl_employees.id', '=', 'tbl_employees_salary.employee_id')
            ->where('tbl_employees.department_id', $data['department_id'])
            ->whereMonth('tbl_employees_salary.salary_date', '=', $dt->month)
            ->whereYear('tbl_employees_salary.salary_date', '=', $dt->year)
            ->get();

            if(isset($salaries) && count($salaries) > 0){

                foreach($salaries as $salary){

                    $data['creates'][] = [
                        'id' => $salary->sid,
                        'employee_id' => $salary->employee_id,
                        'employee_name' => $salary->first_name .' '.$salary->last_name,
                        'tlt_salary' => $salary->basic_pay,
                        'generated_pay' => $salary->generated_pay,
                        'overtime' => $salary->overtime,
                        'deduction' => $salary->deduction,
                        'leave_deduction' => $salary->leave_deduction,
                        'fix_advance' => $salary->fix_advance,
                        'temp_advance' => $salary->temp_advance,
                        'status' => $salary->status,
                    ];
                }



                $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();

                $data['currency'] = $this->custom->currencyFormatSymbol();
                
                return view('admin.salary.create', $data);

            }else{
                return redirect('/salary/create');
            }

            
        } catch (ModelNotFoundException $e) {
            return redirect('/salary/create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {

            $this->validate($request, [
                'department' => 'required'
            ]);

            $data['department_id'] = $request->input('department');
            $data['date'] = $request->input('date').'-01';

            $dt = Carbon::parse($data['date']);

            $lib = new Salarylib;
            $count = $lib->getSalaryData($data['date'], $data['department_id']);

            if(isset($count) && $count == 0){
                
                $employees = $lib->getEmployees($data['date'], $data['department_id']);

                if(isset($employees) && count($employees) > 0)
                {

                    $offical_days_seconds = 0; $tlt_salary = 0; $per_hour_salary = 0;
                    
                    /* OFFICIAL LEAVES */
                    $offical = $lib->getOfficalLeaves($data['date']);

                    /* TOTAL DAYS IN MONTH */
                    $days_in_month = $lib->getTotalDaysOfMonth($data['date']);

                    /* TOTAL WEEKLY OFF DAYS IN MONTH */
                    $weekly_off_days = $lib->getWeeklyOffDays($data['date']);
                    
                    /* EMPLOYEES LIST LOOP */

                    $loan_fixed_installment = 0; $loan_temp_installment = 0;
                    foreach($employees as $employee)
                    {

                        
                        $total = 0;
                        /* EMPLOYEE TOTAL SALARY SUM */
                        $tlt_salary = $employee->basic_salary + $employee->accomodation_allowance + $employee->medical_allowance + $employee->house_rent_allowance + $employee->transportation_allowance + $employee->food_allowance;

                        $tlt_leaves = $lib->getTltLeaves($employee->id, $data['date']);

                        /* EMPLOYEES DATA ARRAY */
                        $emp_data = [
                            'salary' => $tlt_salary,
                            'start_time' => strtotime($employee->shift->start_time),
                            'end_time' => strtotime($employee->shift->end_time),
                            'date' => $data['date'],
                            'employee_id' => $employee->id,
                            'allowed_leaves' => $employee->allowed_leaves,
                            'eOvertime' => $employee->overtime_1,
                            'tlt_leaves' => $tlt_leaves,
                            'sql_start_time' => $employee->shift->start_time,
                            'sql_end_time' => $employee->shift->end_time
                        ];

                        $salaries = $lib->getEmployeesSalaryByAttendance($emp_data);

                        $loan_fixed_installment = $lib->getEmployeesFixedLoans($employee->id);
                        $loan_temp_installment = $lib->getEmployeesTempLoans($employee->id);
                        

                        $tlt_loan_fixed = $lib->getTltLoanFixed($employee->id);
                        $tlt_loan_temp = $lib->getTltLoanTemp($employee->id);

                       
                        if(isset($salaries) && count($salaries) > 0)
                        {

                            foreach($salaries as $salary)
                            {

                                $data['lists'][] = [
                                    'employee_id' => $employee->id,
                                    'employee_name' => $employee->first_name.' '.$employee->last_name,
                                    'tlt_salary' => $tlt_salary,
                                    'generated_pay' => $salary['basic_salary'],
                                    'overtime' => $salary['overtime'],
                                    'deduction' => $salary['deduction'],
                                    'advance_fixed' => round($employee->loan_fixed_installment, 2),
                                    'tlt_advance' => round($tlt_loan_fixed, 2),
                                    't_loan' =>  round($tlt_loan_temp, 2),
                                    'net_amount' => $salary['net_amount'] - $loan_fixed_installment -  $loan_temp_installment,
                                    'loan_fixed_installment' => $loan_fixed_installment,
                                    'loan_temp_installment' => $loan_temp_installment,
                                    'leaves_deduction' => $salary['leaves_deduction'],
                                ];
                            }
                            
                        }
                        
                    }

                }

            }else{

                $data['creates'] = array();

                $salaries = EmployeesSalary::select(
                    'tbl_employees_salary.id as sid',
                    'tbl_employees_salary.employee_id',
                    'tbl_employees_salary.salary_date',
                    'tbl_employees_salary.basic_pay',
                    'tbl_employees_salary.generated_pay',
                    'tbl_employees_salary.overtime',
                    'tbl_employees_salary.deduction',
                    'tbl_employees_salary.leave_deduction',
                    'tbl_employees_salary.fix_advance',
                    'tbl_employees_salary.temp_advance',
                    'tbl_employees_salary.status',
                    'tbl_employees.first_name',
                    'tbl_employees.last_name'
                )
                ->leftJoin('tbl_employees', 'tbl_employees.id', '=', 'tbl_employees_salary.employee_id')
                ->where('tbl_employees.department_id', $data['department_id'])
                ->get();

                if(isset($salaries) && count($salaries) > 0){

                    foreach($salaries as $salary){

                        $data['creates'][] = [
                            'id' => $salary->sid,
                            'tlt_salary' => $salary->basic_pay,
                            'employee_id' => $salary->employee_id,
                            'employee_name' => $salary->first_name .' '.$salary->last_name,
                            'tlt_salary' => $salary->basic_pay,
                            'generated_pay' => $salary->generated_pay,
                            'overtime' => $salary->overtime,
                            'deduction' => $salary->deduction,
                            'leave_deduction' => $salary->leave_deduction,
                            'fix_advance' => $salary->fix_advance,
                            'temp_advance' => $salary->temp_advance,
                            'status' => $salary->status,
                        ];
                    }

                }

            }

            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();


            $data['currency'] = $this->custom->currencyFormatSymbol();
    
            return view('admin.salary.create', $data);


        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmployeesSalary  $employeesSalary
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            $data = [];

            if(is_null($id)) { $data['error'] = 1; }

            $employee = Employees::leftJoin('tbl_employees_salary', function($join){
                $join->on('tbl_employees_salary.employee_id', '=', 'tbl_employees.id');
            })
            ->select(
                'tbl_employees.id as eid',
                'tbl_employees.first_name',
                'tbl_employees.last_name',
                'tbl_employees.shift_id',
                'tbl_employees.basic_salary as basic',
                'tbl_employees.accomodation_allowance as accom',
                'tbl_employees.medical_allowance as med',
                'tbl_employees.house_rent_allowance as hrent',
                'tbl_employees.transportation_allowance as trans',
                'tbl_employees.food_allowance as food',
                'tbl_employees.allowed_leaves',
                'tbl_employees.overtime_1',
                'tbl_employees_salary.id as sid',
                'tbl_employees_salary.salary_date',
                'tbl_employees_salary.generated_pay',
                'tbl_employees_salary.basic_pay',
                'tbl_employees_salary.overtime',
                'tbl_employees_salary.deduction',
                'tbl_employees_salary.leave_deduction',
                'tbl_employees_salary.fix_advance',
                'tbl_employees_salary.temp_advance',
                'tbl_employees_salary.status as salary_status',
                DB::raw('(
                    SELECT SUM(s.withdraw) - SUM(s.deposit) FROM `tbl_employees_loans_statements` s
                    WHERE s.employee_id = tbl_employees.id AND s.type = 1
                    GROUP BY s.employee_id
                ) AS tlt_loan_fixed'),
                DB::raw('(
                    SELECT SUM(s.withdraw) - SUM(s.deposit) FROM `tbl_employees_loans_statements` s
                    WHERE s.employee_id = tbl_employees.id AND s.type = 2
                    GROUP BY s.employee_id
                ) AS tlt_loan_temp')
            )
            ->where('tbl_employees_salary.id', $id)
            ->where('tbl_employees_salary.status', '0')
            ->first();
            
            //echo $employee->eid;
            //die;

            if(count($employee) > 0){

                $dt = Carbon::parse($employee->salary_date);

                $days_in_month = $dt->daysInMonth;

                $total_working_days = calculateWorkingDaysInMonth($dt->year, $dt->month);

                $basic_salary = $employee->basic + $employee->accom + $employee->med + $employee->hrent + $employee->trans + $employee->food;

                $start_time = strtotime($employee->shift->start_time);
                $end_time = strtotime($employee->shift->end_time);

                $shift_time = $end_time - $start_time;
                $shift_time_hours = $shift_time / 60 / 60;


                /**
                 * ATTANCE DETAIL
                 */

                $atts = DB::select(
                    DB::raw('
                        SELECT in_time, out_time, total_hours, employee_id,
                           CASE WHEN total_hours - 9 > 0 THEN total_hours - 9 ELSE 0 END overtime
                      FROM
                    (
                      SELECT in_time, out_time, employee_id,
                             TIME_TO_SEC(TIMEDIFF(COALESCE(out_time, "'.$employee->shift->end_time.'"), COALESCE(in_time,  "'.$employee->shift->start_time.'"))) / 3600 total_hours
                        FROM
                        tbl_employees_attendance
                        where employee_id = "'.$employee->eid.'"
                        AND YEAR(in_time) = "'.$dt->year.'"
                        AND MONTH(in_time) = "'.$dt->month.'"
                    ) att
                    ')
                );

             
                //$data['salaries'][$employee->id] = [];
               
                
                $time_deduct_amount = 0; 
                $calc_working_days = 0;
                if(isset($atts) && count($atts) > 0)
                {
                    
                    $calc_working_time = 0; 
                    $working_to_sec = 0;

                    foreach($atts as $att)
                    {
                        /**
                         * Get H:i:s from total working
                         */
                        $calc_working_time += $att->total_hours - $att->overtime;
                        $calc_working_days = $calc_working_time / $shift_time_hours;
                    }

                }

                $payable = $employee->generated_pay + $employee->overtime - $employee->fix_advance - $employee->temp_advance;

                $data['employee'] = [
                    'salary_id' => $employee->sid,
                    'employee_id' => $employee->eid,
                    'employee_name' => $employee->first_name.' '.$employee->last_name,
                    'basic_salary' => round($basic_salary, 2),
                    'payable' => round($employee->generated_pay, 2),
                    'overtime' => round($employee->overtime, 2),
                    'deduction' => round($employee->deduction, 2),
                    'leave_deduction' => round($employee->leave_deduction, 2),
                    'fix_advance' => round($employee->fix_advance),
                    'temp_advance' => round($employee->temp_advance),
                    'shift_time_hours' => $shift_time_hours,
                    'total_month_working_days' => $total_working_days,
                    'total_working_days_spent' => round((int)$employee->tlt_leaves),
                    'allowed_leaves' => (int)$employee->allowed_leaves,
                    'tlt_leaves' => (int)$employee->tlt_leaves,
                    'tlt_loan_fixed' => round($employee->tlt_loan_fixed, 2),
                    'tlt_loan_temp' => round($employee->tlt_loan_temp, 2),
                    'net_amount' => round($payable, 2),
                ];

                $data['code'] = $this->custom->getSalaryCode();

                $data['accounts'] = AccountsChart::whereTypeId('9')->get();

                return view('admin.salary.view', $data);
            }
            

            return view('admin.salary.notfound');
            
            
        } catch (ModelNotFoundException $e) {
            return view('admin.salary.notfound');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\EmployeesSalary  $employeesSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return response()->json(['error'=>'Sorry! request is not valid']);

            if($request->ajax()){

                $total_paid_amount = ($request->input('basic_payable1') + $request->input('overtime1'));

                $validator = Validator::make($request->all(), [
                    'code1' => 'required',
                    'employee_id1' => 'required|exists:tbl_employees,id',
                    'salary_id1' => 'required|exists:tbl_employees_salary,id',
                    'account1' => 'required|exists:tbl_accounts_chart,id',
                    'basic_payable1' => 'required|between:0,99.99',
                    'overtime1' => 'required|between:0,99.99'
                ]);

                if ($validator->passes()) {


                    $salary_id = $id;
                    $employee_id = $request->input('employee_id1');
                    $create_by = Auth::guard('auth')->user()->id;
                    
                    $employee = Employees::findOrFail($employee_id);
                    $chart = AccountsChart::where('code', $employee->employee_code)->where('type_id', '11')->first();
                    
                    $date = Carbon::createFromFormat('m/d/Y', $request->input('pdate'))->toDateString();

                    $salary = EmployeesSalary::where('status', '0')->where('employee_id', $employee_id)->findOrFail($salary_id);

                    $salary->generated_pay = $request->input('basic_payable1');
                    $salary->overtime = $request->input('overtime1');
                    $salary->fix_advance = $request->input('fix_installment1');
                    $salary->temp_advance = $request->input('temp_installment1');
                    $salary->status = '1';
                    $salary->updated_by = $create_by;
                    $salary->save();


                    $statement = new EmployeesLoansStatements;
                    if($request->input('fix_installment1') > 0)
                    {
                        $statement->employee_id = $employee_id;
                        $statement->datetime = $date;
                        $statement->detail = 'Loan Deposit from salary: ';
                        $statement->deposit = $request->input('fix_installment1');
                        $statement->type = '1';
                        $statement->save();
                    }

                    if($request->input('temp_installment1') > 0)
                    {
                        $statement->employee_id = $employee_id;
                        $statement->datetime = $date;
                        $statement->detail = 'Loan Deposit from salary: ';
                        $statement->deposit = $request->input('temp_installment1');
                        $statement->type = '1';
                        $statement->save();
                    }

                    

                    $employee_ledger = [
                        'employee_id' => $employee_id,
                        'account_id' => $request->input('account1'),
                        'code' => $request->input('code1'),
                        'date' => $date,
                        'basic_pay' => $salary->basic_pay,
                        'generated_pay' => $request->input('basic_payable1'),
                        'overtime' => $request->input('overtime1'),
                        'deduction' => $salary->deduction,
                        'leave_deduction' => $salary->leave_deduction,
                        'fixed_advance' => $request->input('fix_installment1'),
                        'temp_advance' => $request->input('temp_installment1'),
                        'amount' => $total_paid_amount,
                        'created_by' => $create_by,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time())
                    ];

                    EmployeesLedger::insert($employee_ledger);

                    

                    $jr = [
                        'date' => $date,
                        'code' => $request->input('code1'),
                        'reference' => '',
                        'description' => 'Salary Paid: '.$date,
                        'type' => '3',
                        'added_by' => $create_by
                    ];

                    $id = AccountsSummery::insertGetId($jr);

                    if($id){

                        $cr_amount = [
                            'summery_id' => $id,
                            'account_id' => $chart->id,
                            'date' => $date,
                            'debit' => '0', 
                            'credit' => $total_paid_amount,
                            'description' => 'Salary Paid: '.$date,
                            'added_by' => $create_by,
                        ];

                        AccountsSummeryDetail::insert($cr_amount);


                        $dr_amount = [
                            'summery_id' => $id,
                            'account_id' => $request->input('account1'),
                            'date' => $date,
                            'debit' => $total_paid_amount, 
                            'credit' => '0',
                            'description' => 'Salary Paid: '.$date,
                            'added_by' => $create_by,
                        ];

                        AccountsSummeryDetail::insert($dr_amount);
                    }

                    
                    

                    return response()->json(['success'=> __('admin/common.salary_added'), 'employee_id' => $employee_id]);

                }


               return response()->json(['error'=>$validator->errors()->all()]);

            }

            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getPrintSlip($type = NULL, $id = NULL)
    {
        try {

            if(is_null($id) || is_null($type)) return redirect('/salary/create');

            $data['title'] = __('admin/employees.salary_slip_txt');

            $salary = EmployeesSalary::findOrFail($id);

            $data['salary'] = [
                'date' => $salary['salary_date'],
                'basic' => number_format($salary['basic_pay'], 2),
                'generate_pay' => number_format($salary['generated_pay'], 2),
                'overtime' => number_format($salary['overtime'], 2),
                'deduction' => number_format($salary['deduction'], 2),
                'leave_deduction' => number_format($salary['leave_deduction'],2),
                'fix_advance' => number_format($salary['fix_advance'], 2),
                'temp_advance' => number_format($salary['temp_advance'], 2),
                'status' => $salary['status'],
                'name' => $salary->employee->first_name.' '.$salary->employee->last_name,
                'phone' => $salary->employee->phone_no,
                'present_address' => $salary->employee->present_address,
                'email' => $salary->employee->email,
                'total_earning' => number_format($salary['generated_pay'] + $salary['overtime'], 2),
                'total_deduction' => number_format($salary['deduction'] + $salary['fix_advance'] + $salary['temp_advance'], 2),
                'total_net_amount' => number_format($salary['generated_pay'] + $salary['overtime'] - ($salary['fix_advance'] + $salary['temp_advance']), 2)
            ];

            $data['company'] = $this->custom->getSetting('BUSINESS_NAME');
            $data['email'] = $this->custom->getSetting('BUSINESS_EMAIL');
            $data['phone'] = $this->custom->getSetting('BUSINESS_PHONE');
            $data['address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
            $data['logo'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

            $data['currency'] = $this->custom->currencyFormatSymbol();
            $data['type'] = $type;

            return view('admin.salary.slip', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('/salary/create');
        }
    }
}