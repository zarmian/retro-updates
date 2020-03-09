<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesOfficialLeaveDates;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Employees\EmployeesLedger;
use App\Http\Models\Employees\Notifications;
use App\Http\Models\Accounts\Customers;
use App\Http\Models\Accounts\Vendors;
use App\Http\Models\Admin\Departments;
use App\Http\Models\Auth\AuthRole;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Auth\AuthModel;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Users;
use App\ThirdParty\SlimStatus;
use App\Libraries\Employeelib;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use App\ThirdParty\Slim;
use Auth;
use Mail;
use DB;



class DashboardController extends Controller
{

    protected $guard = 'auth';

    public function __construct()
    {
        $this->custom = new Customlib();
        $this->employee = new Employeelib(); 
    }

	/**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = Auth::guard($this->guard)->user()->id;
        $default = Auth::guard($this->guard)->user()->roles->default;
        
        $data = [];
        $schart = [];

        if($default == 1)
        {
            $str_month = date('Y-m'.'-01', time());
            $end_month = date('Y-m'.'-01', strtotime("-6 month"));

            $end  = strtotime($str_month);
            $start = $month = strtotime($end_month);

            $salaries_rows = $this->getSalaries();
           
            while($month <= $end)
            {

                $total_month[] = date('M', $month);

                $m = date('m', $month);

                $key = "month";
                $schart[] = $this->whatever($salaries_rows, $key, $m);

                $month = strtotime('+1 MONTH', $month);
            }


            $data['total_month'] = $total_month;
            $data['schart'] = $schart;
            $data['departments'] = $this->getTotalDepartments();
            $data['employees'] = $this->getTotalEmployees();
            $data['offical_leaves'] = $this->getOfficalLeaves();
            $data['present_employees'] = $this->getPresentEmployees();

            return view('admin.dashboard', $data);

        }else{

            $total_month = [];
            $ss = [];

            $str_month = date('Y-m'.'-01', time());
            $end_month = date('Y-m-d', strtotime('-6 MONTH'));

            $end = strtotime($str_month);
            $start = $month = strtotime($end_month);


            $rows = $this->employee->getEmployeesSalary($user_id);

            while ($month <= $end) {

                $total_month[] = date('M', $month);

                $m = date('m', $month);
                $key = 'month';

                $ss[] = $this->whatever($rows, $key, $m);

                $month = strtotime('+1 MONTH', $month);
            }

            $data['total_month'] = $total_month;
            $data['emp_salary'] = $ss;
       
            $data['absents'] = $this->employee->getEmployeesAbsents($user_id);
            $data['outtimeshort'] = $this->employee->getEmployeesShortTimeOut($user_id);

            $data['payable'] = $this->employee->getPayableLoan($user_id);
            $data['currency'] = $this->custom->currencyFormatSymbol();

            return view('employees.dashboard', $data);
        }

       
    }


    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalaries()
    {
        try {

            $salaries = EmployeesLedger::select(DB::raw('SUM(amount) as amt, YEAR(date) as year, MONTH(date) as month'))
            ->whereRaw('date > DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->groupBy(DB::raw('YEAR(date), MONTH(date)'))
            ->get();

            $data = [];
            if(isset($salaries) && count($salaries) > 0)
            {
                foreach($salaries as $row)
                {

                    $data[] = [
                        'month' => $row['month'],
                        'year' => $row['year'],
                        'amount' => $row['amt']
                    ];
                    
                }
            }

            return $data;
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getTotalDepartments()
    {
        try {
            
            $row = Departments::select(DB::raw('COUNT(id) as tlt_dep'))->where('status', '1')->first();
            if(isset($row) && $row->tlt_dep > 0)
                return $row->tlt_dep;
            return '0';

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function getTotalEmployees()
    {
        try {
            
            $employees = Employees::select(DB::raw('COUNT(id) as tlt'))->where('role', '<>', '1')->where('status', '1')->first();
            if(isset($employees) && $employees->tlt > 0)
                return $employees->tlt;
            return '0';

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getOfficalLeaves()
    {
        try {
            
            $leaves = EmployeesOfficialLeaveDates::select(DB::raw('COUNT(*) as tlt'))
            ->join('tbl_employees_official_leaves', 'tbl_employees_official_leaves.id', '=', 'tbl_employees_official_leaves_dates.leave_id')
            ->whereRaw('YEAR(tbl_employees_official_leaves_dates.leave_date) = YEAR(CURDATE())')
            ->where('tbl_employees_official_leaves.status', '1')
            ->groupBy(DB::raw('YEAR(tbl_employees_official_leaves_dates.leave_date)'))
            ->first();

            if(isset($leaves) && $leaves->tlt > 0)
                return $leaves->tlt;
            return '0';

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getPresentEmployees()
    {
        try {

            $present = EmployeesAttendance::select(DB::raw('COUNT(*) as tlt'))
            ->whereRaw('Date(in_time) = CURDATE()')
            ->groupBy(DB::raw('DATE(in_time), employee_id'))
            ->get();
            if(isset($present) && count($present) > 0)
            {
                return count($present);
            }

            return '0';
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function whatever($array, $key, $value)
    {

        if(isset($array) && count($array) > 0)
        {
            foreach($array as $item)
            {
                if(isset($item[$key]) && $item[$key] == $value)
                    return $item['amount'];
                return '0.00';
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function profile(){
        
    	try {

            
            $default = Auth::guard($this->guard)->user()->roles->default;
            $user_id = Auth::guard('auth')->user()->id;


            if($default == 1)
            {

                $data['notices'] = [];
                $data['user'] = Employees::findOrFail($user_id);

                $notices = Notifications::where('type', '2')->get();

                
                if(isset($notices) && count($notices) > 0)
                {
                    $sr=0;
                    foreach($notices as $notice)
                    {
                        $sr++;
                        $data['notices'][] = [
                            'sr' => $sr,
                            'datetime' => date('d M, Y', strtotime($notice['datetime'])),
                            'title' => $notice['title'],
                            'description' => $notice['description'],
                        ];
                    }
                }

                $data['genders'] = DB::table('tbl_gender')->select('id','title')->get();
                $data['countries'] = DB::table('tbl_countries')->select('id', 'country_name')->get();
                return view('admin.users.profile', $data);
            }else{
                
                $data['user'] = Employees::findOrFail($user_id);

                $data['total_received'] = $this->employee->getTotalReceivedSalary($user_id);
                $data['total_ded'] = $this->employee->getTotalDeduction($user_id);
                $data['total_loan'] = $this->employee->getTotalLoanReceived($user_id);
                
                $data['attendences'] = $this->employee->getAttendanceByMonth($user_id);

                $data['salaries'] = $this->employee->getSalariesByMonth($user_id);
                $data['notices'] = $this->employee->getNotices();

                $data['qualifications'] = $this->employee->getQualificationByEmployee($user_id);
                $data['experiences'] = $this->employee->getWorkExperienceByEmployee($user_id);
                


                $data['currency'] = $this->custom->currencyFormatSymbol();
                return view('employees.profile', $data);
            }
            

            
            

        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Admin\EmployeesRoles  $employeesRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {

        try {

            
            $user_id = Auth::guard('auth')->user()->id;
            
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'country_id' => 'required',
                'email' => 'required|email|unique:tbl_users,email,'.$id,
                'present_address' => 'required',
            ];

            if($request->input('password')){
                $rules = [
                    'password' => 'confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ];
            }

            $this->validate($request, $rules);

            $user = Employees::findOrFail($user_id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_no = $request->input('phone_no');
            $user->mobile_no = $request->input('mobile_no');
            $user->nationality = $request->input('country_id');
            $user->present_address = $request->input('present_address');
            $user->permanant_address = $request->input('permanant_address');

            if($request->input('password_confirmation') <> ""){
                $user->password = crypt($request->input('password_confirmation'));
            }

            $user->save();

            if($user){
                $request->session()->flash('msg', __('admin/profile.update_msg'));
            }

            return redirect('/profile/'.$id);

        } catch (ModelNotFoundException $e) {
            return redirect('/');
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request){

        try {

            $user_id = Auth::guard('auth')->user()->id;
            
            $images = Slim::getImages();

            $image = $images[0];
            $path = storage_path().'/app/avatar/';
            $file = Slim::saveFile($image['output']['data'], $image['input']['name'], $path);

            $user = Employees::findOrFail($user_id);
            $user->avatar =  $file['name'];
            $user->save();

            // echo results
            Slim::outputJSON(SlimStatus::Success, $file['name'], $file['path']);
            

        } catch (ModelNotFoundException $e) {
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function coverUpadate()
    {
        try {

            $user_id = Auth::guard('auth')->user()->id;
            
            $images = Slim::getImages();

            $image = $images[0];
            $path = storage_path().'/app/cover/';
            $file = Slim::saveFile($image['output']['data'], $image['input']['name'], $path);

            $user = Employees::findOrFail($user_id);
            $user->cover =  $file['name'];
            $user->save();

            // echo results
            Slim::outputJSON(SlimStatus::Success, $file['name'], $file['path']);
            

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function search($q = '', Request $request)
    {

        try {

            $method = $request->method();
            if($method == "GET")
            {
                $q =  $request->get('q');

                if(!empty($q))
                {
                    $employees = Employees::where('first_name', 'LIKE', '%'.$q.'%')->orWhere('last_name', 'LIKE', '%'.$q.'%')->get();

                    $data['employees'] = [];
                    if(isset($employees) && count($employees) > 0)
                    {
                        foreach($employees as $employee)
                        {
                            $data['employees'][] = [
                                'id' => $employee['id'],
                                'employee_code' => $employee['employee_code'],
                                'full_name' => $employee['first_name']. ' '.$employee['last_name'],
                                'email' => $employee['email'],
                                'mobile' => $employee['phone_no'],
                                'department' => $employee->department->title
                            ];
                        }
                    }


                    $data['customers'] = [];

                    $customers = Customers::where('first_name', 'LIKE', '%'.$q.'%')->orWhere('last_name', 'LIKE', '%'.$q.'%')->get();

                    if(isset($customers) && count($customers) > 0)
                    {
                        foreach($customers as $customer)
                        {
                            $data['customers'][] = [
                                'id' => $customer['id'],
                                'code' => $customer['code'],
                                'full_name' => $customer['first_name']. ' '.$customer['last_name'],
                                'email' => $customer['email'],
                                'mobile' => $customer['mobile'],
                                'total_amount' => number_format($customer['sales']->sum('total'), 2),
                                'total_paid' => number_format($customer['ledger']->sum('amount'), 2)
                                
                            ];
                        }
                    }



                    $data['vendors'] = [];

                    $vendors = Vendors::where('first_name', 'LIKE', '%'.$q.'%')->orWhere('last_name', 'LIKE', '%'.$q.'%')->get();

                    if(isset($vendors) && count($vendors) > 0)
                    {
                        foreach($vendors as $vendor)
                        {
                            $data['vendors'][] = [
                                'id' => $vendor['id'],
                                'code' => $vendor['code'],
                                'full_name' => $vendor['first_name']. ' '.$vendor['last_name'],
                                'email' => $vendor['email'],
                                'mobile' => $vendor['mobile'],
                                'total_amount' => number_format($vendor['sales']->sum('total'), 2),
                                'total_paid' => number_format($vendor['ledger']->sum('amount'), 2)
                                
                            ];
                        }
                    }


                    if(count($data['employees']) == 0 && count($data['customers']) == 0 && count($data['vendors']) == 0)
                    {
                        $data['empty'] = __('admin/common.notfound');
                    }
                }else{
                    $data['empty'] = __('admin/common.search_empty_txt');
                }

            }

            $data['currency'] = $this->custom->currencyFormatSymbol();
            
            return view('admin.search', $data);   
            
            die;
        } catch (ModelNotFoundException $e) {
            
        }

    }
}
