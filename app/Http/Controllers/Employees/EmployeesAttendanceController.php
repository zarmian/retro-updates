<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesLoansStatements;
use App\Http\Models\Employees\EmployeesAttendance;
use App\Http\Models\Employees\EmployeesLedger;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use App\Libraries\Employeelib;
use App\Libraries\Customlib;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use DateTime;
use Config;
use Auth;
use DB;
class EmployeesAttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
       return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {

            if($request->ajax()){
            
                $data['status'] = 'in';

                $time = Carbon::now();
                $date = $time->toDateString();

                $user_id = Auth::guard('auth')->user()->id;
            
                $count = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->count();

                $attendance = new EmployeesAttendance;
                $in_time = $time->toDateTimeString();


                /**
                 * Remaining Time
                 */
                if($count == 0){

                    $attendance->employee_id = $user_id;
                    $attendance->in_time = $in_time;
                    $attendance->save();

                    $data['status'] = 'in';

                }else{

                    $row = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->first();

                    if(isset($row) && count($row) > 0){

                        if(isset($row->out_time) && !is_null($row->out_time)){
                            $attendance->employee_id = $user_id;
                            $attendance->in_time = $in_time;
                            $attendance->save();

                            $data['status'] = 'in';
                        }else{
                            return redirect('employees');
                        }

                    }

                }
               
                return $data['status'];
            }


            return redirect('employees');
        } catch (ModelNotFoundException $e) {
            return redirect('employees');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Employees\EmployeesAttendance  $employeesAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         try {

            $validator = Validator::make($request->all(), [
                'detail' => 'required'
            ]);

            if ($validator->fails()) {    
                return response()->json(['error' => $validator->messages()], 200);
            }else{

                if($request->ajax()){

                    $data['status'] = 'out';

                    $time = Carbon::now();
                    $date = $time->toDateString();

                    $user_id = Auth::guard('auth')->user()->id;
                    $count = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->count();

                    if(isset($count) && $count > 0){

                        $row = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->first();

                        $attendance = EmployeesAttendance::findOrFail($row->id);

                        if(empty($row->out_time) && is_null($row->out_time) && $row->out_time == ""){

                            $detail = ($request->input('detail') == 'null' || $request->input('detail') == '') ? NULL : $request->input('detail');

                            $in_time = $row->in_time;
                            $out_time = $time->toDateTimeString();

                            /// Time Calculate
                            $date = Carbon::parse($in_time);
                            $now = Carbon::now();

                            $diff = $date->diffInSeconds($now);
                            
                            $spent_time = gmdate('H:i:s', $diff); // 00:00:21
                            

                            $attendance->out_time = $out_time;
                            $attendance->spent_time = $spent_time;
                            $attendance->detail = $detail;
                            $attendance->save();

                            $data['status'] = 'out';

                        }

                    }

                }

                return response()->json(['error' => '', 'status' => $data['status']], 200);

            }

            return redirect('employees');
        } catch (ModelNotFoundException $e) {
            return redirect('employees');
        }
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function viewModal($status = NULL){

        try {

            
            $t['spend'] = [];

            $data['status'] = 'in';
            $time = Carbon::now();
            $date = $time->toDateString();
            $user_id = Auth::guard('auth')->user()->id;

            $total_spend_sec = 0;

            $st_rows = EmployeesAttendance::select('id', 'in_time', 'out_time')->whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'DESC')->get();

            if(isset($st_rows) && count($st_rows) > 0)
            {
                foreach($st_rows as $row)
                {
                    $out_time = $row->out_time;
                    if(!isset($row->out_time) && is_null($row->out_time))
                    {
                        $out_time = date('Y-m-d H:i:s', time());
                    }

                    $in_time = $row->in_time;

                    $total_sec = strtotime($out_time) - strtotime($in_time);

                    $t['spend'][] = $total_sec;
                }
            }

            

            $shift_time = $this->custom->getShiftByEmployee($user_id);

            $start_time = $shift_time->start_time;
            $end_time = $shift_time->end_time;

            $shift_sec = strtotime($end_time) - strtotime($start_time);
            $spend_sec = array_sum($t['spend']);

            $total_time_spend = 0;

            
            if($spend_sec > $shift_sec)
            {
                $total_time_spend = $spend_sec - $shift_sec;
                $otime = gmdate("H:i:s", $total_time_spend);
                $data['time'] = 'Overtime: '.$otime;
            }else{

                $total_time_spend = $shift_sec - $spend_sec;
                $rtime = gmdate("H:i:s", $total_time_spend);
                $data['time'] = 'Remaining Time: '.$rtime;
            }

            $row = EmployeesAttendance::whereEmployeeId($user_id)->whereDate('in_time', '=', $date)->orderBy('id', 'desc')->first();

            if(isset($row) && count($row) > 0){
                    
                if(empty($row->out_time) && is_null($row->out_time) && $row->out_time == ""){
                    $data['modal'] = 'out';
                }else{
                    $data['modal'] = 'in';
                }
                
            }else{
                $data['modal'] = 'in';
            }

            $data['currenttime'] = $time->toDayDateTimeString();
            return view('employees.attendance.view', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }

        
    }

    public function ledger()
    {
        try {

            $data = [];
            $data['html'] = '';

            
            $data['employee_id'] = Auth::guard('auth')->user()->id;
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

                return view('employees.ledger', $data);
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
            

            return view('employees.ledger', $data);
        } catch (ModelNotFoundException $e) {
            
        }
    }

   
}
