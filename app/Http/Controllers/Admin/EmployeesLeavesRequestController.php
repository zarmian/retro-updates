<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Admin\EmployeesLeavesRequest;
use App\Jobs\SendLeaveApprovalEmailJob;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Employees;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use DateTime;
use DB;

class EmployeesLeavesRequestController extends Controller
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
        try {
            $data = [];
        
            $data['employees'] = Employees::where('status', '1')->get();
            return view('admin.leaves.index', $data);

        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmployeesLeavesRequest  $employeesLeavesRequest
     * @return \Illuminate\Http\Response
     */
    public function leaves(Request $request)
    {
        try {

            $data = [];
            $data['leaves'] = [];

            $this->validate($request, [
                'employee' => 'required',
                'status' => 'required',
            ]);

            $employee_id = $request->input('employee');
            $status = $request->input('status');

            $query = EmployeesLeavesRequest::query();

            if($employee_id > 0 && $employee_id <> "")
            {
                $query->where('employee_id', $employee_id);
            }
            
            $query->where('status', $status);
            $leavs = $query->get();

            if(isset($leavs) && count($leavs) > 0)
            {
                foreach($leavs as $leave)
                {
                    $data['leaves'][] = [
                        'id' => $leave['id'],
                        'title' => $leave['title'],
                        'description' => $leave['description'],
                    ];
                }
            }

            $data['employees'] = Employees::where('status', '1')->get();
            return view('admin.leaves.index', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Admin\EmployeesLeavesRequest  $employeesLeavesRequest
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('/leaves');

            $data['leave'] = [];
            $days = '0';

            $leave = EmployeesLeavesRequest::findOrFail($id);


            if(($request->input()) && count($request->input()) > 0){
                
                $leave->status = $request->input('status');
                $leave->approved_description = $request->input('detail');
                $leave->save();


                $enable_email = $this->custom->getSetting('ENABLE_EMAIL');
                if(isset($enable_email) && $enable_email == 'true')
                {

                    $template = $this->custom->getTemplate(9);
                    if(isset($template['status']) && $template['status'] == 1)
                    {

                        switch ($request->input('status')) {
                            case '2':
                                $status = __('admin/loans.reject_txt');
                            break;
                            case '1':
                                $status = __('admin/loans.accpect_txt');
                            break;
                            default:
                                $status = __('admin/loans.pending_txt');
                            break;
                        }

                        $dd = [
                            'leave_status' => $status,
                            'employee_id' => $leave->employee_id,
                            'leave_id' => $id,
                        ];

                        $job = (new SendLeaveApprovalEmailJob($dd))->delay(Carbon::now()->addSeconds(10));
                        dispatch($job);

                    }
                }

                //SendLeaveApprovalEmailJob

                $request->session()->flash('msg', __('admin/leaves.status_update_msg'));
            }


            $lDatess = DB::table('tbl_employees_leaves_dates')->whereLeaveId($leave->id)->get();

            
            $ld = [];
            if(isset($lDatess) && count($lDatess) > 0){
                foreach($lDatess as $ldates):
                    $ld[] = $ldates->leave_date;
                endforeach;

                $date1 = new DateTime(current($ld));
                $date2 = new DateTime(end($ld));

                $days = count($lDatess);
                //$days = $date2->diff($date1)->format("%a");
            }

            $data['leave'] = [
                'id' => $leave->id,
                'employee_name' => $leave->employee->first_name.' '.$leave->employee->last_name,
                'title' => $leave->title,
                'date' => date('d, M Y', strtotime(current($ld))) .' TO '. date('d, M Y', strtotime(end($ld))),
                'days' => '('.$days.')',
                'status' => $leave->status,
                'description' => $leave->description,
                'approved_description' => $leave->approved_description,
            ];
            
            if($leave->unread == 1){
                $leave->unread = '0';
                $leave->save();
            }

            return view('admin.leaves.view', $data);
            
        } catch (ModelNotFoundException $e) {
            return redirect('/leaves');
        }
    }

}
