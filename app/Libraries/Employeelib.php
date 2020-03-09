<?php 
namespace App\Libraries;

use App\Http\Models\Admin\EmployeesOfficialLeaveDates;
use App\Http\Models\Admin\EmployeesLoansStatements;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Admin\EmployeesWorkExperience;
use App\Http\Models\Admin\EmployeesQualification;
use App\Http\Models\Employees\EmployeesLedger;
use App\Http\Models\Employees\Notifications;
use App\Http\Models\Admin\EmployeesSalary;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Admin\Settings;
use App\Libraries\Customlib;
use Carbon\Carbon;
use DateTime;
use Config;
use Storage;
use Mail;
use DB;

class Employeelib{

    public function __construct(){
        $this->custom = new Customlib();
    }


    public function getTotalReceivedSalary($user_id = '')
    {
        try {

            $rec = EmployeesLedger::select(DB::raw('SUM(amount) AS t'))
            ->where('employee_id', $user_id)
            ->groupBy('employee_id')
            ->first();

            if(isset($rec) && count($rec) > 0)
            {
                return $rec->t;
            }

            return '0.00';

        } catch (ModelNotFoundException $e) {
            
        }
    }
	
    

    public function getTotalDeduction($user_id = '')
    {
        try {

            $ded = EmployeesSalary::select(DB::raw('SUM(deduction) AS d'))
            ->where('employee_id', $user_id)
            ->groupBy('employee_id')
            ->first();

            if(isset($ded) && count($ded) > 0)
            {
                return $ded->d;
            }

            return '0.00';
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getTotalLoanReceived($user_id = '')
    {
        try {

            $loan = EmployeesLoansStatements::select(DB::raw('SUM(deposit) AS d'))
            ->where('employee_id', $user_id)
            ->groupBy('employee_id')
            ->first();

            if(isset($loan) && count($loan) > 0)
            {
                return $loan->d;
            }

            return '0.00';
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getAttendanceByMonth($user_id = '')
    {
        try {

            $date = date('Y-m-d', time());

            //DATE_SUB(NOW(), INTERVAL 1 MONTH)

            $attendaces = EmployeesAttendance::select(
                DB::raw('spent_time, detail,
                    MONTH(in_time) as month, YEAR(in_time) as year, in_time, out_time,
                    TIME_TO_SEC(TIMEDIFF(COALESCE(out_time), COALESCE(in_time))) / 3600 as t
                ')
            )
            ->whereRaw("MONTH(in_time) = MONTH('".$date."') ")
            ->where('employee_id', $user_id)
            ->orderBy('in_time', 'DESC')
            ->get();

            $data = [];
            if(isset($attendaces) && count($attendaces) > 0)
            {

                $shift = $this->custom->getShiftByEmployee($user_id);

                $in_time = $shift->start_time;
                $out_time = $shift->end_time;

                $shift_total_sec = strtotime($out_time) - strtotime($in_time);
                $shift_total_time =  gmdate("H:i:s", $shift_total_sec);


                $datetime1 = strtotime($shift_total_time);

                $sr = 0;
                $t_short = '-';
                foreach($attendaces as $attendace)
                {


                    if(is_null($attendace->out_time)){
                        $out_time = '-';
                        $t_short = '<b>'.$shift_total_time.'</b>';
                    }else{
                        
                        $t_short = '00:00:00';
                        $out_time = date('h:i:s A', strtotime($attendace->out_time));
                        $datetime2 = strtotime($attendace->spent_time);

                        $da = $datetime1 > $datetime2;
                        if($da)
                        {
                            $tt = $datetime1 - $datetime2;
                            $t_short = '<b>'.gmdate("H:i:s", $tt).'</b>';
                        }
                        
                    }
                    
                    $sr++;
                    $data[] = [
                        'sr' => $sr,
                        'date' => $this->custom->dateformat($attendace->in_time),
                        'in_time' => date('h:i:s A', strtotime($attendace->in_time)),
                        'out_time' => $out_time,
                        'detail' => $attendace->detail,
                        't' => $attendace->t,
                        't_short' => $t_short,
                        'head_date' => date('M Y', strtotime($attendace->in_time))
                     
                    ];
                    
                }
            }

            return $data;

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getSalariesByMonth($user_id = '')
    {
        try {

            $salaries = EmployeesSalary::select(
                DB::raw('
                    MONTH(salary_date) as month, 
                    YEAR(salary_date) as year,
                    deduction,
                    generated_pay, overtime, fix_advance, temp_advance,
                    status,
                    basic_pay,
                    salary_date
                ')
            )
            ->whereRaw('salary_date < DATE_SUB(NOW(), INTERVAL 1 MONTH)')
            ->where('employee_id', $user_id)
            ->get();

            $data = [];
            if(isset($salaries) && count($salaries) > 0)
            {
                $total = 0;
                foreach($salaries as $salary)
                {

                    $total = $salary['generated_pay'] + $salary['overtime'] - $salary['fix_advance'] - $salary['temp_advance'];
                    $status = ($salary['status'] == 0) ? 'P' : 'R';
                    
                    $data[] = [
                        'date' => date('M Y', strtotime($salary['salary_date'])),
                        'basic_pay' => number_format($salary['basic_pay'], 2),
                        'total' => number_format($total, 2),
                        'status' => $status,
                        'deduction' => number_format($salary['deduction'], 2),
                        'received' => number_format($total - $salary['deduction'], 2),
                    ];
                }
            }

            return $data;

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function getNotices()
    {
        try {
            
            $notices = Notifications::where('type', '1')->get();

            $data = [];
            if(isset($notices) && count($notices) > 0)
            {
                $sr=0;
                foreach($notices as $notice)
                {
                    $sr++;
                    $data[] = [
                        'sr' => $sr,
                        'datetime' => date('d M, Y', strtotime($notice['datetime'])),
                        'title' => $notice['title'],
                        'description' => $notice['description'],
                    ];
                }
            }

            return $data;

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function getWorkExperienceByEmployee($user_id = '')
    {
        try {
            
            $workExp = EmployeesWorkExperience::where('employee_id', $user_id)->get();
            if(isset($workExp) && count($workExp) > 0)
            {
                return $workExp;
            }

            return [];

        } catch (ModelNotFoundException $e) {
            
        }
        
    }


    public function getQualificationByEmployee($user_id = '')
    {
        $qualification = EmployeesQualification::where('employee_id', $user_id)->get();
        if(isset($qualification) && count($qualification) > 0)
        {
            return $qualification;
        }

        return [];
        
    }



    public function getPayableLoan($user_id = '')
    {
        $loan = EmployeesLoansStatements::select(DB::raw('SUM(withdraw) - SUM(deposit) AS d'))
            ->where('employee_id', $user_id)
            ->groupBy('employee_id')
            ->first();

            if(isset($loan) && count($loan) > 0)
            {
                return $loan->d;
            }

            return '0.00';
    }



    public function getEmployeesAbsents($user_id = '')
    {

        $start_from = date('Y-m').'-01';
        $end_from = date('Y-m-d', time());

        $absents = EmployeesAttendance::select(DB::raw('DATE_FORMAT(in_time,"%Y-%m-%d") as dd'))
        ->whereRaw("DATE(`in_time`) BETWEEN '".$start_from."' AND '".$end_from."'")
        ->where('employee_id', $user_id)
        ->groupBy('dd')
        ->get();

        
        $data = [];
        if(isset($absents) && count($absents) > 0)
        {
            foreach($absents as $absent)
            {
                $data[] = [
                    'day' => date('D', strtotime($absent['dd'])),
                ];
            }
        }


        $off_days = $this->custom->getSetting('OFFDAYS');
        $off_days = unserialize($off_days);


        $count = 0;
        $length = 0;
      
        $now = Carbon::parse($start_from);
        $end = Carbon::parse($end_from);
        $interval = $end->diffInDays($now);

        $days = 0;
        for($date = $now; $date->lte($end); $date->addDay()) {
            if(!in_array($date->format('D'), $off_days)){
                $dates[] = $date->format('D');
                $days++;
            }
            
        }

        foreach($data as $row)
        {
           
            if(!in_array($row['day'], $off_days))
            {
                $count++;
            }
        }

        return $days - $count;
        die;
    }



    public function getEmployeesShortTimeOut($user_id = '')
    {

        $start_from = date('Y-m').'-01';
        $end_from = date('Y-m-d', time());

        $absents = EmployeesAttendance::select(DB::raw('id, in_time, MONTH(in_time) as month, DAYNAME(in_time) as day, DATE_FORMAT(in_time,"%a") as dd, COUNT(id) AS tlt'))
        ->whereRaw("DATE(`in_time`) BETWEEN '".$start_from."' AND '".$end_from."'")
        ->where('employee_id', $user_id)
        ->whereNull('out_time')
        ->groupBy(DB::raw('MONTH(in_time), in_time, id'))
        ->first();

        if(isset($absents) && count($absents) > 0)
        {

            return $absents['tlt'];
        }

        return 0;

    }


    public function getEmployeesSalary($user_id = '')
    {


        $salaries = EmployeesLedger::select(DB::raw('id, MONTH(date) AS month, YEAR(date) AS year, SUM(amount) as total'))
        ->where('employee_id', $user_id)
        ->groupBy(DB::raw('date, id'))
        ->get();

        $rows = [];

        if(isset($salaries) && count($salaries) > 0)
        {
            foreach($salaries as $salary)
            {
                $rows[] = [
                    'month' => $salary['month'],
                    'amount' => $salary['total']
                ];
            }
        }

        return $rows;
    }


}