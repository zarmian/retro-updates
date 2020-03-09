<?php 
namespace App\Libraries;

use App\Http\Models\Admin\EmployeesOfficialLeaveDates;
use App\Http\Models\Admin\EmailTemplates;
use App\Http\Models\Admin\EmployeesSalary;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Admin\Settings;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Storage;
use Config;
use Mail;
use DB;

class Salarylib{

    public $present_days = 0;

    public function __construct(){
        $this->custom = new Customlib();
    }


    public function getSalaryData($date = '', $department_id = '')
    {
        $dt = Carbon::parse($date);

        $count = EmployeesSalary::select('
            tbl_employees_salary.id
        ')
        ->leftJoin('tbl_employees', 'tbl_employees.id', '=', 'tbl_employees_salary.employee_id')
        ->whereMonth('tbl_employees_salary.salary_date', '=', $dt->month)
        ->whereYear('tbl_employees_salary.salary_date', '=', $dt->year)
        ->where('tbl_employees.department_id', $department_id)
        ->count();

        return $count;
    }


    public function getEmployeesFixedLoans($employee_id = ''){


        $loan = DB::table('tbl_employees_loans')->select('installment')->where('employee_id', $employee_id)->where('type', '1')->orderBy('id', 'DESC')->first();

        if(isset($loan) && count($loan) > 0)
        {
            return $loan->installment;
        }
        return 0;
    }

    public function getEmployeesTempLoans($employee_id = ''){


        $loan = DB::table('tbl_employees_loans')->select('installment')->where('employee_id', $employee_id)->where('type', '2')->orderBy('id', 'DESC')->first();

        if(isset($loan) && count($loan) > 0)
        {
            return $loan->installment;
        }
        return 0;
    }


    public function getTltLeaves($employee_id = '', $date = ''){


        $dt = Carbon::parse($date);
        $leaves = DB::table('tbl_employees_leaves')->select(DB::raw('COUNT(tbl_employees_leaves_dates.leave_date) as tlt_leaves'))->where('tbl_employees_leaves.employee_id', $employee_id)->leftJoin('tbl_employees_leaves_dates', 'tbl_employees_leaves_dates.leave_id', '=', 'tbl_employees_leaves.id')->whereYear('tbl_employees_leaves_dates.leave_date', $dt->year)->groupby('tbl_employees_leaves.employee_id')->first();

        if(isset($leaves) && count($leaves) > 0){
            return $leaves->tlt_leaves;
        }

        return 0;
    }


    public function getTltLoanFixed($employee_id = ''){

        $fixed_loan = DB::table('tbl_employees_loans_statements')->select(DB::raw('SUM(withdraw) - SUM(deposit) as tlt_loan_fixed'))->where('employee_id', $employee_id)->groupby('employee_id')->where('type', '1')->first();

        if(isset($fixed_loan) && count($fixed_loan) > 0)
        {
            return $fixed_loan->tlt_loan_fixed;
        }
        return 0;
    }


    public function getTltLoanTemp($employee_id = ''){

        $temp_loan = DB::table('tbl_employees_loans_statements')->select(DB::raw('SUM(withdraw) - SUM(deposit) as tlt_loan_temp'))->where('employee_id', $employee_id)->groupby('employee_id')->where('type', '2')->first();

        if(isset($temp_loan) && count($temp_loan) > 0)
        {
            return $temp_loan->tlt_loan_temp;
        }
        return 0;

    }


    public function getEmployees($date = '', $department_id = '')
    {

        $dt = Carbon::parse($date);

        $employees = Employees::leftJoin('tbl_employees_salary', function($join){
            $join->on('tbl_employees_salary.employee_id', '=', 'tbl_employees.id');
        })
        ->select(
            'tbl_employees.id',
            'tbl_employees.first_name',
            'tbl_employees.last_name',
            'tbl_employees.shift_id',
            'tbl_employees.basic_salary',
            'tbl_employees.accomodation_allowance',
            'tbl_employees.medical_allowance',
            'tbl_employees.house_rent_allowance',
            'tbl_employees.transportation_allowance',
            'tbl_employees.food_allowance',
            'tbl_employees.allowed_leaves',
            'tbl_employees.overtime_1',
            'tbl_employees_salary.basic_pay'
        )
        ->where('tbl_employees.department_id', $department_id)
        ->where('tbl_employees.status', '1')
        //->whereNull('tbl_employees_salary.employee_id')
        ->get();

        // print_r($employees);
        // die;

        return $employees;
    }



    public function getOfficalLeaves($date = '')
    {
        $dt = Carbon::parse($date);

        $offical = 0;
        $offical_leaves = EmployeesOfficialLeaveDates::select(
        DB::raw('COUNT(leave_date) as offical,
            YEAR(leave_date) year, MONTH(leave_date) month
        ')
        )->whereMonth('leave_date', '=', $dt->month)
        ->whereYear('leave_date', '=', $dt->year)
        ->groupby('year','month')
        ->first();
        
        if(isset($offical_leaves)){
            $offical = $offical_leaves->offical;
        }

        return $offical;
    }



    public function getTotalOfficalDaysByMonth($year = '', $month = '')
    {
        if ($year == ''){ $year = date('Y'); }
        if ($month == ''){ $month = date('m'); }    
        

        $off_days = $this->custom->getSetting('OFFDAYS');
        $off_days = unserialize($off_days);

        $startdate = strtotime($year . '-' . $month . '-01');
        $enddate = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
        $currentdate = $startdate;

        
        $return = intval((date('t',$startdate)),10);
        
        while ($currentdate <= $enddate)
        {
            //(date('D',$currentdate) == 'Sat') || 
            //if you encounter a Saturday or Sunday, remove from the total days count
            if ((date('D',$currentdate) == 'Sun'))
            {
                $return = $return - 1;
            }
            $currentdate = strtotime('+1 day', $currentdate);
        } 

        return $return;

    }


    public function getTotalDaysOfMonth($date = '')
    {

        $off_days = $this->custom->getSetting('OFFDAYS');
        $off_days = unserialize($off_days);

        $nice_date = Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        $month_by_post = Carbon::parse($nice_date)->month;

        $start_date = date('Y-m-01', strtotime($nice_date));
        $end_date = date('Y-m-t', strtotime($nice_date));

        $dt = Carbon::now();
        $current_month = $dt->month;
        if($month_by_post == $current_month)
        {
            $end_date = date('Y-m-d', time());
        }

        $end = strtotime($end_date);
        $start = $month = strtotime($start_date);

        $days_in_month = 0;
        while($month <= $end)
        {

            $d = date('D', $month);
            if(!in_array($d, $off_days)){
                $days_in_month++;
            } 
            $month = strtotime("+1 day", $month);
        }

        return $days_in_month;
    }




    public function getLeavesCount($data = array())
    {

        $date = $data['date'];
        $nice_date = Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        $month_by_post = Carbon::parse($nice_date)->month;

        $start_date = date('Y-m-01', strtotime($nice_date));
        $end_date = date('Y-m-t', strtotime($nice_date));

        $dt = Carbon::now();
        $current_month = $dt->month;
        if($month_by_post == $current_month)
        {
            $end_date = date('Y-m-d', time());
        }

        $end = strtotime($end_date);
        $start = $month = strtotime($start_date);

        $total_month_days = 1;
        while($month < $end)
        {
            $total_month_days++;
            $month_dates[date('Y-m-d', $month)] = date('Y-m-d', $month);
            $month = strtotime('+1 DAY', $month);
        }

        //echo $total_month_days;

        //echo $date = $data['date'];
        //print_r($data);
    }


    public function getWeeklyOffDays($date = '')
    {

        $dt = Carbon::parse($date);
        
        $off_days = $this->getTotalOfficalDaysByMonth($dt->year, $dt->month);
        return $this->getTotalDaysOfMonth($date) - $off_days;
    }


    public function getEmployeesSalaryByAttendance($data = array())
    {

        if(isset($data) && count($data) > 0)
        {

            $dt = Carbon::parse($data['date']);
            $shift_time = $this->getShiftTimeHours($data);


            /*$atts = DB::select(
            DB::raw('
            SELECT employee_id, 
                CONCAT(CAST(
                CASE WHEN SUM(UNIX_TIMESTAMP(out_time) - UNIX_TIMESTAMP(in_time)) > 21600
                THEN FLOOR(SUM(UNIX_TIMESTAMP(out_time)-UNIX_TIMESTAMP(in_time)) / 21600 )
                ELSE 0 END AS CHAR)) AS working_days, 
                SEC_TO_TIME(MOD(
                    SUM(UNIX_TIMESTAMP(out_time)-UNIX_TIMESTAMP(in_time)), 21600)
                ) AS working_hours
            FROM tbl_employees_attendance
            WHERE employee_id = "'.$data['employee_id'].'"
            AND YEAR(in_time) = "'.$dt->year.'"
            AND MONTH(in_time) = "'.$dt->month.'"
            GROUP
            BY DATE(in_time)')
            );

            if(isset($atts) && count($atts) > 0)
            {

                foreach($atts as $att)
                {  
                    echo '<pre>';
                    print_r($att);
                }
            }


            die;*/

            $atts = DB::select(
                DB::raw('
                    SELECT in_time, out_time, total_hours, employee_id,
                    SEC_TO_TIME(
                        CASE WHEN total_hours - '."{$shift_time}".' > 0
                            THEN total_hours - '."{$shift_time}".'
                            ELSE 0 END
                    ) overtime

                    FROM
                    (SELECT 
                        in_time, 
                        out_time, 
                        employee_id, 
                        DATE(tbl_employees_attendance.in_time) in_time_day, 
                        DATE(tbl_employees_attendance.out_time) out_time_day,
                        TIME_TO_SEC(
                            TIMEDIFF(
                                COALESCE(out_time, "'.$data['sql_end_time'].'"), 
                                COALESCE(in_time, "'.$data['sql_start_time'].'")
                            )
                        ) / 3600 total_hours 
                    FROM
                    tbl_employees_attendance
                    WHERE employee_id = "'.$data['employee_id'].'"
                    AND YEAR(in_time) = "'.$dt->year.'"
                    AND MONTH(in_time) = "'.$dt->month.'"
                    GROUP BY employee_id, DATE(in_time)
                    ) att
                ')
            );
            
            //     
            $attData = [];
            if(isset($atts) && count($atts) > 0)
            {
                
                $deduct = 0;
                $overtime = 0;
                $working = 0;
                $p = 0;
                foreach($atts as $att)
                {
                    $attData = [
                        'total_hours' => round($att->total_hours, 2),
                        'overtime' => $att->overtime,
                        'salary' => $data['salary'],
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'date' => $data['date'],
                        'employee_id' => $data['employee_id'],
                        'eOvertime' => $data['eOvertime'],
                        'in_time' => $att->in_time
                    ];



                    $total_overtime_amount = $this->getOverTimeAmount($attData);
                    $total_deduct_amount = $this->getDedcutionAmount($attData);
                    $total_working_amount = $this->getWorkingAmount($attData);

                    $deduct = $deduct + $total_deduct_amount;
                    $overtime = $overtime + $total_overtime_amount;
                    $working = $working + $total_working_amount;

                    $p++;
                    
                }

                $this->present_days = $p;

                //die;
                $leave_deduction = $this->getLeavesDeduction($data);
                $paid_leaves_amount = $this->getPaidLeavesAmount($data);
                $offical_leaves_amount = $this->getOfficalLeavePaidSalary($data);
                //$weekly_off_days_amount = $this->getWeeklyOffDaysSalary($data);

                $basic_salary = $working + $paid_leaves_amount + $offical_leaves_amount;
                if(isset($data['tlt_leaves']) && $data['tlt_leaves'] > 0)
                {
                    $basic_salary = $working + $offical_leaves_amount;
                }

                $net_amount = $basic_salary + $overtime;


                $d['salaries'] = [
                    'basic_salary' => round($basic_salary, 2),
                    'overtime' => round($overtime, 2),
                    'deduction' => round($deduct, 2),
                    'leaves_deduction' => round($leave_deduction, 2),
                    'net_amount' => round($net_amount, 2),
                ];


                return $d;
                
            }
         
        }
        return [];
        
    }


    public function getWorkingAmount($data)
    {

        $per_hour_salary = $this->getPerHourSalary($data);
        $shift_time_hours = $this->getShiftTimeHours($data);

        if($data['total_hours'] > $shift_time_hours)
        {
            $calc_working_time = $shift_time_hours;
        }
        else
        {
            $calc_working_time =  $data['total_hours'];
        }

    
        if($calc_working_time > 0)
        {

            $working_to_sec = $calc_working_time * 3600;
            $working_time = $this->getSecToMin($working_to_sec);

            $salary = $working_time * $per_hour_salary / 60;
            return $salary;
        }
        return 0;
    }


    public function getDedcutionAmount($data = array())
    {

        $shift_time_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        $total_sum = 0;
        if($data['total_hours'] < $shift_time_hours){

            $deduct_hours = $shift_time_hours - $data['total_hours'];
            $deduct_to_sec = $deduct_hours * 3600;

            $deduct_to_sec = $this->getSecToMin($deduct_to_sec);
            $sec_to_hrs = $deduct_to_sec / 60;

            $per_day_ded = $sec_to_hrs * $per_hour_salary;

            $total_sum = $per_day_ded;
                   
            return $total_sum;
        }

        
        
        return 0;

    }


    public function getOverTimeAmount($data = array())
    {

        $shift_time_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        if($data['total_hours'] > $shift_time_hours)
        {
            $overtime = $data['total_hours'] - $shift_time_hours;
        }
        else
        {
            $overtime =  0;
        }

        
        if($overtime > 0)
        {
            
            $overtime_to_sec = $overtime * 3600;

            $calc_overtime = $this->getSecToMin($overtime_to_sec);
            $overtime_amount = $calc_overtime * $per_hour_salary / 60;

            return $overtime_amount * $data['eOvertime'];
        }

        return 0;
    }


    public function getLeavesDeduction($data = array())
    {

        $present_days = $this->present_days;
        $total_month_days = $this->getTotalDaysOfMonth($data['date']);
        $offical_leaves_salary = $this->getOfficalLeavePaidSalary($data);

        $allowed_leaves = $data['allowed_leaves'];
        $shift_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        $total_absents = $total_month_days - $present_days;

        $total_leaves = ($data['tlt_leaves']) ? $data['tlt_leaves'] : 0;
        $total_leaves = $total_leaves + $total_absents;

        if($total_leaves > $allowed_leaves){
            $deduction_leaves = $allowed_leaves - $total_leaves;
        }
        
        $deduction_leaves = max($total_leaves - $allowed_leaves, 0);

        $leaves_deduction = $deduction_leaves * $shift_hours * $per_hour_salary;
        if($leaves_deduction > 0)
        {
            return $leaves_deduction - $offical_leaves_salary;
        }

        return 0;
        
    }


    public function getPaidLeavesAmount($data = array())
    {
        $shift_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        if($data['allowed_leaves'] > 0)
        {

            $leave_to_hours = $data['allowed_leaves'] * $shift_hours;
            $hours_to_salary = $leave_to_hours * $per_hour_salary;

            return $hours_to_salary;
        }
        return 0;
    }


    public function getShiftTimeHours($data = array())
    {

        $shift_time = $data['end_time'] - $data['start_time'];
        $shift_time_hours = $shift_time / 60 / 60;

        if(isset($shift_time_hours) && $shift_time_hours > 0)
        {
            return $shift_time_hours;
        }
        return 0;
    }


    public function getPerHourSalary($data = array())
    {

        $hours = $this->getShiftTimeHours($data);
        $days = $this->getTotalDaysOfMonth($data['date']);
        $per_hour_salary = $data['salary'] / $days / $hours;

        if(isset($per_hour_salary) && $per_hour_salary > 0)
        {
            return $per_hour_salary;
        }
        return 0;
    }



    public function getOfficalLeavePaidSalary($data = array())
    {

        $offical = $this->getOfficalLeaves($data['date']);
        $shift_time_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        $offical_days_hours = $offical * $shift_time_hours;
        $offical_days_salary = $per_hour_salary * $offical_days_hours;

        if(isset($offical_days_salary) && $offical_days_salary > 0)
        {
            return $offical_days_salary;
        }
        return 0;
    }



    public function getWeeklyOffDaysSalary($data = array())
    {
        $weekly_off_days = $this->getWeeklyOffDays($data['date']);
        $shift_time_hours = $this->getShiftTimeHours($data);
        $per_hour_salary = $this->getPerHourSalary($data);

        $weekly_off_days_hours = $weekly_off_days * $shift_time_hours;
        $weekly_off_days_salary = $per_hour_salary * $weekly_off_days_hours;

        if(isset($weekly_off_days_salary) && $weekly_off_days_salary > 0)
        {
            return $weekly_off_days_salary;
        }
        return 0;
    }



    function getSecToMin($seconds) {

      $hours = floor($seconds / 3600);
      $minutes = floor(($seconds / 60) % 60);
      $seconds = $seconds % 60;

      $hours = ($hours > 0) ? $hours * 60 : 0;
      $minutes = ($minutes > 0) ? $minutes: 0;

      $total_mintues =  $hours + $minutes;
      if($total_mintues > 0)
      {
        return $total_mintues;
      }

      return 0;

    }

}