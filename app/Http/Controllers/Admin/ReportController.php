<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesOfficialLeaveDates;
use App\Http\Models\Employees\EmployeesLeavesDates;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use App\Http\Models\Admin\Report;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Validator;
use Excel;
use DB;


class ReportController extends Controller
{

    public function __construct(){
        $this->custom = new Customlib();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('admin');
    }


    public function daily_attendance(Request $request)
    {
        $data = [];
        $data['date'] = '';

        if($request->input() && count($request->input()) > 0)
        {

            $data['attendances'] = [];

            $this->validate($request, [
                'date' => 'required',
                'department' => 'required'
            ]);

            $data['department_id'] = $request->input('department');
            $date = $request->input('date');

            $nice_date = convert_sql_date($date);

            $data['date'] = $nice_date;

            $employee = Employees::query();
            if($data['department_id'] && $data['department_id'] > 0){
                $employee->whereDepartmentId($data['department_id']);
            }

            $employees = $employee->get();

            if(isset($employees) && count($employees) > 0)
            {
                $per_day_spent = 0;
                $total_short_time = 0;
                $per_day_time = 0;
                foreach($employees as $employee)
                {

                    $list['attendance'] = [];

                    $break_time = 60;

                    $attendances = EmployeesAttendance::whereEmployeeId($employee->id)->whereDate('in_time', '=', $nice_date)->get();

                    if(isset($attendances) && count($attendances) > 0)
                    {

                        $start_time = strtotime($employee->shift->start_time);
                        $end_time = strtotime($employee->shift->end_time);

                        $per_day_time = $end_time - $start_time;
                       
                        foreach($attendances as $attendance)
                        {

                            $short_time = gmdate('h:i:s', $per_day_time);
                           
                            if(!empty($attendance->out_time) || !is_null($attendance->out_time))
                            {
                                $short_time = '00:00:00';
                                $spend_time = strtotime($attendance->out_time) - strtotime($attendance->in_time);
                                if($spend_time < $per_day_time)
                                {
                                    $shortime = $per_day_time - $spend_time;
                                    $short_time = gmdate('h:i:s', $shortime);

                                }
                                
                            }

                            $list['attendance'][] = [
                                'id' => $attendance->id,
                                'in_time' => $this->custom->timeformat($attendance->in_time),
                                'out_time' => $this->custom->timeformat($attendance->out_time),
                                'short_time' => $short_time,
                                'detail' => $attendance->detail
                            ];
                           
                        }

                       
                    }

                   

                    $data['attendances'][] = [
                        'employee_id' => $employee->id,
                        'employee_name' => $employee->first_name.' '.$employee->last_name,
                        'shift_time_start' => $employee->shift->start_time,
                        'shift_time_end' => $employee->shift->end_time,
                        'detail' => 'Absent',
                        'list' => $list['attendance']
                    ];

                }

                
            }

        }

        $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();
        
        return view('admin.reports.daily_attendance', $data);
    }

    public function mang_attendance(Request $request)
    {
        try {

            $data = [];
            $employee_id = '';
            $total_shift_time = '';

            if($request->input() && count($request->input()) > 0)
            {

                $this->validate($request, [
                    'date' => 'required',
                    'department' => 'required',
                    'employees' => 'required'
                ]);


                $month_dates = [];

                $employee_id = $request->input('employees');
            
                $date = $request->input('date');

                $nice_date = Carbon::createFromFormat('m/d/Y', $date)->toDateString();
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

                $off_days = unserialize($this->custom->getSetting('OFFDAYS'));
                

                while($month <= $end)
                {
                    $month_dates[date('Y-m-d', $month)] = date('Y-m-d', $month);
                    $month = strtotime('+1 DAY', $month);
                }

            
                $shift = $this->custom->getShiftByEmployee($employee_id);

                $start_time = $shift->start_time;
                $end_time = $shift->end_time;

                $stime = strtotime($start_time);
                $etime = strtotime($end_time);

                $per_day_time = $etime - $stime;

                $total_shift_time = convertToHoursMins($per_day_time / 60, '%02d:%02d:%02d');

                $attendances = EmployeesAttendance::select()
                ->whereEmployeeId($employee_id)
                ->whereRaw('MONTH(in_time) = MONTH("'.$nice_date.'") AND YEAR(in_time) = YEAR("'.$nice_date.'") ')
                //->groupBy(DB::raw('MONTH(in_times   ), YEAR(in_time)'))
                ->get();

                $a = [];
                if(isset($attendances) && count($attendances) > 0)
                {
                    $short_time = '-';
                    foreach($attendances as $attendance)
                    {
                        if(isset($attendance['out_time']) && !is_null($attendance['out_time']))
                        {
                            $spent = strtotime($attendance['out_time']) - strtotime($attendance['in_time']);
                            $shot_seconds = $per_day_time - $spent;
                            $short_time = gmdate('H:i:s', $shot_seconds);
                        }

                        $a[date('Y-m-d', strtotime($attendance['in_time']))][] = [
                            'id' => $attendance['id'],
                            'in_time' => $attendance['in_time'],
                            'out_time' => $attendance['out_time'],
                            'date' => date('Y-m-d', strtotime($attendance['in_time'])),
                            'short_time' => $short_time,
                        ];
                    }
                }


                $l = [];
                if(isset($month_dates) && count($month_dates) > 0)
                {

                    $r=0;
                   
                    foreach($month_dates as $dt)
                    {
                        
                        $is_offical = ['is_offical' => false, 'offical_type' => ''];
                        $eLeave = ['is_leave' => false, 'offical_type' => ''];

                        $off = in_array(date('D', strtotime($dt)), $off_days) ? true : false;

                        $officals = $this->getOfficalLeavesByMonth($dt);

                        if(isset($officals[$dt]) && $officals[$dt]['leave_date'] == $dt)
                        {
                            $is_offical = ['is_offical' => true, 'offical_type' => $officals[$dt]['leave_type']];
                        }

                        $leaves = $this->getPersonalLeavesByMonth($dt);
                        if(isset($leaves[$dt]) && $leaves[$dt]['leave_date'] == $dt)
                        {
                            $eLeave = ['is_leave' => true, 'offical_type' => $leaves[$dt]['leave_type']];
                        }
                        
 
                  
                        $r++;
                        if(isset($a[$dt]) && count($a[$dt]) > 0)
                        {

                            foreach($a[$dt] as $atts)
                            {
                                if(isset($atts['out_time']) && !is_null($atts['out_time'])){
                                   $out_time = date('m/d/Y h:i a', strtotime($atts['out_time']));
                                   $short_time = $atts['short_time'];
                                }else{
                                    $out_time = '';
                                    $short_time = '-';
                                }
                                $data['attendances'][] = [
                                    'n' => $r,
                                    'id' => $atts['id'],
                                    'in_time' => date('m/d/Y h:i a', strtotime($atts['in_time'])),
                                    'out_time' => $out_time,
                                    'date' => date('d F l Y', strtotime($atts['date'])),
                                    'short_time' => $short_time,
                                    'absent' => false,
                                    'closed' => '',
                                    'offical' => $is_offical,
                                    'eLeave' => $eLeave

                                ];
                            }

                            
                        }else{
                            $data['attendances'][] = [
                                'n' => $r,
                                'date' => date('d F l Y', strtotime($dt)),
                                'in_time' => date('m/d/Y h:i A', strtotime($dt.' '.$start_time)),
                                'out_time' => date('m/d/Y h:i A', strtotime($dt.' '.$end_time)),
                                'id' => $employee_id,
                                'short_time' => $total_shift_time,
                                'absent' => true,
                                'closed' => $off,
                                'offical' => $is_offical,
                                'eLeave' => $eLeave
                            ];
                        }

                    }
                }


            }

            $data['employee_id'] = $employee_id;
            $data['shift_time'] = $total_shift_time;
            $data['departments'] = DB::table('tbl_departments')->select('id', 'title')->where('status', '1')->get();
            
            return view('admin.reports.manage_attendance', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function getOfficalLeavesByMonth($date = '')
    {

        try {

            if(isset($date) && $date <> '')
            
                $leaves = EmployeesOfficialLeaveDates::select('leave_date', 'leave_id')
                ->whereRaw('MONTH(leave_date) = MONTH("'.$date.'") AND YEAR(leave_date) = YEAR("'.$date.'") ')
                ->leftJoin('tbl_employees_official_leaves', 'tbl_employees_official_leaves.id', '=', 'tbl_employees_official_leaves_dates.leave_id')
                ->whereStatus('1')
                ->get();

                $l = [];
                if(isset($leaves) && count($leaves) > 0)
                {
                    foreach($leaves as $leave)
                    {
                        $l[$leave['leave_date']] = [
                            'leave_date' => $leave['leave_date'],
                            'leave_type' => $leave->title->title
                        ];
                    }
                }

                return $l;

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function getPersonalLeavesByMonth($date = '')
    {

        try {

            if(isset($date) && $date <> '')
            
                $leaves = EmployeesLeavesDates::select('leave_date', 'leave_id')
                ->whereRaw('MONTH(leave_date) = MONTH("'.$date.'") AND YEAR(leave_date) = YEAR("'.$date.'") ')
                ->get();

                $l = [];
                if(isset($leaves) && count($leaves) > 0)
                {
                    foreach($leaves as $leave)
                    {
                        if(isset($leave->title) && $leave->title->status == 1)
                        {
                            $l[$leave['leave_date']] = [
                                'leave_date' => $leave['leave_date'],
                                'leave_type' => $leave->title->title
                            ];
                        }
                        
                    }
                }

                return $l;

        } catch (ModelNotFoundException $e) {
            
        }
    }



    public function ajax(Request $request, $action='')
    {
        try {

            if($request->ajax())
            {


                switch ($action) {
                    case 'eSuggestion':

                        $data = [];

                        $department_id = $request->input('department_id');
                        
                        $employees = Employees::select('id', 'first_name', 'last_name')->whereDepartmentId($department_id)->get();

                        if(isset($employees) && count($employees) > 0)
                        {
                            foreach($employees as $employee)
                            {
                                $data[] = [
                                    'id' => $employee['id'],
                                    'first_name' => $employee['first_name'],
                                    'last_name' => $employee['last_name']
                                ];
                            }
                        }

                        return response()->json($data);

                    break;

                    case 'eAdded':

                        $validator = Validator::make($request->all(), [
                            'employee_id' => 'required|exists:tbl_employees,id',
                            'in_time' => 'required',
                            'out_time' => 'required'
                        ]);

                        $in_time = $request->input('in_time');
                        $out_time = $request->input('out_time');
                        $employee_id = $request->input('employee_id');

                        if($validator->fails())
                        {
                            return response()->json(['error' => $validator]);
                        }


                        $nice_in_time = Carbon::createFromFormat('m/d/Y h:i A', $in_time)->toDateTimeString();
                        
                        $nice_out_time = Carbon::createFromFormat('m/d/Y h:i A', $out_time)->toDateTimeString();

                        $str_in_time = strtotime($nice_in_time);
                        $str_out_time = strtotime($nice_out_time);

                        $str_seconds = $str_out_time - $str_in_time;

                        $spent_time = gmdate('H:i:s', $str_seconds); // 00:00:21

                        $attendance = new EmployeesAttendance();
                        $attendance->employee_id = $employee_id;
                        $attendance->in_time = $nice_in_time;
                        $attendance->out_time = $nice_out_time;
                        $attendance->spent_time = $spent_time;
                        $attendance->save();
                        if($attendance)
                        {
                            return response()->json(['success' => true, 'id' => $attendance->id]);
                        }

                        return response()->json(['error' => 'Something went wrong!']);
                    break;

                    case 'eUpdate':
                        
                        $validator = Validator::make($request->all(), [
                            'employee_id' => 'required|exists:tbl_employees,id',
                            'in_time' => 'required',
                            'out_time' => 'required',
                            'id' => 'required|exists:tbl_employees_attendance,id'
                        ]);

                        $in_time = $request->input('in_time');
                        $out_time = $request->input('out_time');
                        $employee_id = $request->input('employee_id');
                        $id = $request->input('id');

                        $attendance = EmployeesAttendance::findOrFail($id);

                        if($validator->fails())
                        {
                            return response()->json(['error' => $validator]);
                        }


                        $nice_in_time = Carbon::createFromFormat('m/d/Y h:i A', $in_time)->toDateTimeString();
                        
                        $nice_out_time = Carbon::createFromFormat('m/d/Y h:i A', $out_time)->toDateTimeString();

                        $str_in_time = strtotime($nice_in_time);
                        $str_out_time = strtotime($nice_out_time);

                        $str_seconds = $str_out_time - $str_in_time;

                        $spent_time = gmdate('H:i:s', $str_seconds); // 00:00:21

                        
                        $attendance->in_time = $nice_in_time;
                        $attendance->out_time = $nice_out_time;
                        $attendance->spent_time = $spent_time;
                        $attendance->save();
                        if($attendance)
                        {
                            return response()->json(['success' => true, 'id' => $id]);
                        }

                        return response()->json(['error' => 'Something went wrong!']);

                    break;
                    
                    default:
                    break;
                }
            }
            
        } catch (ModelNotFoundException $e) {
            return redirect('admin');
        }
    }



    public function trial(Request $request)
    {
        try {

            $data = [];
            $data['trials'] = [];

            $accounts = AccountsChart::get();
            if(isset($accounts) && count($accounts) > 0)
            {
                $data['total'] = [];
                $tlt_opening_dr = 0; $tlt_opening_cr = 0; $tlt_trans_dr = 0; $tlt_trans_cr = 0; $tlt_closing_dr = 0; $tlt_closing_cr = 0;

                foreach($accounts as $account)
                {
                    $opening_dr = ($account->balance_type === "dr") ? $account->opening_balance : 0;
                    $opening_cr = ($account->balance_type === "cr") ? $account->opening_balance : 0;

                    $transition = AccountsSummeryDetail::select(DB::raw("SUM(debit) as tdebit, SUM(credit) as tcredit"))->groupBy('account_id')->where('account_id', $account->id)->groupBy('account_id')->first();

                    $transition_dr = 0; $transition_cr = 0; $closing_dr = 0; $closing_cr = 0;

                    if(isset($transition) && count($transition) > 0)
                    {
                        $transition_dr = $transition->tdebit;
                        $transition_cr = $transition->tcredit;
                    }

                    $fdebit = $opening_dr + $transition_dr;
                    $fcredit = $opening_cr + $transition_cr;

                    if($fdebit>$fcredit)
                    {
                        $closing_dr = $fdebit - $fcredit;
                        $closing_cr = 0;
                    }else{

                        $closing_cr = $fcredit - $fdebit;
                        $closing_dr = 0;
                    }

                   
                    $data['trials'][] = [
                        'id' => $account->id,
                        'code' => $account->code,
                        'name' => $account->name,
                        'opening_dr' => number_format($opening_dr, 2),
                        'opening_cr' => number_format($opening_cr, 2),
                        'transition_dr' => number_format($transition_dr, 2),
                        'transition_cr' => number_format($transition_cr, 2),
                        'closing_dr' => number_format($closing_dr, 2),
                        'closing_cr' => number_format($closing_cr, 2),
                    ];

                    $tlt_opening_dr = $tlt_opening_dr + $opening_dr;
                    $tlt_opening_cr = $tlt_opening_cr + $opening_cr;

                    $tlt_trans_dr = $tlt_trans_dr + $transition_dr;
                    $tlt_trans_cr = $tlt_trans_cr + $transition_cr;

                    $tlt_closing_dr = $tlt_closing_dr + $closing_dr;
                    $tlt_closing_cr = $tlt_closing_cr + $closing_cr;
                }

                $data['total'] = [
                    'op_tlt_dr' => number_format($tlt_opening_dr, 2),
                    'op_tlt_cr' => number_format($tlt_opening_cr, 2),
                    'trans_tlt_dr' => number_format($tlt_trans_dr, 2),
                    'trans_tlt_cr' => number_format($tlt_trans_cr, 2),
                    'closing_tlt_dr' => number_format($tlt_closing_dr, 2),
                    'closing_tlt_cr' => number_format($tlt_closing_cr, 2),
                ];
            }

            return view('admin.reports.trial', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }


    public function export(Request $request)
    {

        try {


            $action = $request->type;
            switch ($action) {
                case 'trial':
                    
                Excel::create('Trial Balance Sheet', function($excel) {

                    $excel->sheet('Trial Balance Sheet', function($sheet) {

                        $sheet->mergeCells('A1:H1');
                        $sheet->setHeight(1, 50);
                        $sheet->cells('A1:H1', function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFont(array(
                                    'family'     => 'Calibri',
                                    'size'       => '20',
                                    'bold'       => true
                                )
                            );
                        });

                        $sheet->cells('A2:H2', function($cells) {
                            $cells->setFont(array(
                                    'bold'       => true
                                )
                            );
                        });

                        $sheet->row(1, array('Trial Balance Sheet'));


                        $sheet->row(2, array('Account Code', 'Account Name', 'OP.Debit', 'OP.Credit', 'Trans.Debit', 'Trans.Credit', 'Closing Debit', 'Closing Credit'));

                        // Manipulate 2nd row
                        $accounts = AccountsChart::get();
                        if(isset($accounts) && count($accounts) > 0)
                        {
                            $sr = 3; $tlt_opening_dr = 0; $tlt_opening_cr = 0; $tlt_trans_dr = 0; $tlt_trans_cr = 0; $tlt_closing_dr = 0; $tlt_closing_cr = 0;
                            foreach($accounts as $account)
                            {

                                $opening_dr = ($account->balance_type === "dr") ? $account->opening_balance : 0;
                                $opening_cr = ($account->balance_type === "cr") ? $account->opening_balance : 0;

                                $transition = AccountsSummeryDetail::select(DB::raw("SUM(debit) as tdebit, SUM(credit) as tcredit"))->groupBy('account_id')->where('account_id', $account->id)->groupBy('account_id')->first();

                                $transition_dr = 0; $transition_cr = 0; $closing_dr = 0; $closing_cr = 0;

                                if(isset($transition) && count($transition) > 0)
                                {
                                    $transition_dr = $transition->tdebit;
                                    $transition_cr = $transition->tcredit;
                                }

                                $fdebit = $opening_dr + $transition_dr;
                                $fcredit = $opening_cr + $transition_cr;

                                if($fdebit>$fcredit)
                                {
                                    $closing_dr = $fdebit - $fcredit;
                                    $closing_cr = '0.00';
                                }else{

                                    $closing_cr = $fcredit - $fdebit;
                                    $closing_dr = '0.00';
                                }

                                $sheet->appendRow($sr, array(
                                    $account->code, $account->name, number_format($opening_dr, 2), number_format($opening_cr, 2), number_format($transition_dr, 2), number_format($transition_cr, 2), number_format($closing_dr, 2), number_format($closing_cr, 2)
                                ));

                                $sr++;

                                $tlt_opening_dr = $tlt_opening_dr + $opening_dr;
                                $tlt_opening_cr = $tlt_opening_cr + $opening_cr;

                                $tlt_trans_dr = $tlt_trans_dr + $transition_dr;
                                $tlt_trans_cr = $tlt_trans_cr + $transition_cr;

                                $tlt_closing_dr = $tlt_closing_dr + $closing_dr;
                                $tlt_closing_cr = $tlt_closing_cr + $closing_cr;
                            }

                            $sheet->appendRow($sr, array('', 'Total', number_format($tlt_opening_dr, 2), number_format($tlt_opening_cr, 2), number_format($tlt_trans_dr, 2), number_format($tlt_trans_cr, 2), number_format($tlt_closing_dr, 2), number_format($tlt_closing_cr, 2)));

                           
                        }


                    });

                })->export('xls');

            die;
            break;
                
            default:
            # code...
            break;
            }
           
            die();

            
            
        } catch (ModelNotFoundException $e) {
            
        }

    }

}
